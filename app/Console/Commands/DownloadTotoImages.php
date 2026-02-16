<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DownloadTotoImages extends Command
{
    protected $signature = 'toto:download-images {--limit=48}';
    protected $description = 'Download product images from tdm.vn for TOTO products';

    public function handle()
    {
        $limit = (int)$this->option('limit');
        $products = Product::where('brand_id', 3)->limit($limit)->get();
        
        $this->info("📥 Bắt đầu crawl ảnh từ tdm.vn cho " . count($products) . " sản phẩm TOTO...\n");
        
        if (!is_dir(public_path('images/products/toto'))) {
            mkdir(public_path('images/products/toto'), 0755, true);
        }
        
        $successCount = 0;
        
        foreach ($products as $index => $product) {
            $this->info("[$index/" . count($products) . "] Xử lý: {$product->name}");
            
            try {
                // Xây dựng URL sản phẩm dựa trên slug
                $url = "https://www.tdm.vn/" . $product->slug . ".html";
                
                $this->line("  🔗 Accessing: $url");
                
                // Crawl ảnh từ trang sản phẩm
                $response = Http::timeout(10)->get($url);
                
                if ($response->successful()) {
                    $html = $response->body();
                    $imageUrl = $this->extractImageUrl($html);
                    
                    if ($imageUrl) {
                        $this->line("  🖼️  Found image: $imageUrl");
                        
                        // Download ảnh
                        $filename = $product->slug . '.jpg';
                        $filepath = public_path('images/products/toto/' . $filename);
                        
                        $imageResponse = Http::timeout(15)->get($imageUrl);
                        if ($imageResponse->successful()) {
                            file_put_contents($filepath, $imageResponse->body());
                            
                            // Lưu vào database
                            ProductImage::updateOrCreate(
                                [
                                    'product_id' => $product->id,
                                    'is_primary' => true,
                                ],
                                [
                                    'image_path' => '/images/products/toto/' . $filename,
                                ]
                            );
                            
                            $this->line("  ✅ Lưu thành công");
                            $successCount++;
                        } else {
                            $this->warn("  ❌ Không thể download ảnh");
                        }
                    } else {
                        $this->warn("  ⚠️  Không tìm thấy ảnh");
                    }
                } else {
                    $this->warn("  ❌ Lỗi HTTP: " . $response->status());
                }
            } catch (\Exception $e) {
                $this->warn("  ❌ Lỗi: " . $e->getMessage());
            }
            
            sleep(1); // Rate limiting
        }
        
        $this->info("\n✨ Hoàn thành!");
        $this->info("✅ Download ảnh thành công: $successCount / " . count($products));
    }
    
    private function extractImageUrl($html)
    {
        // Tìm ảnh sản phẩm chính từ HTML - thường là ảnh lớn nhất với độ phân giải cao
        
        // Cách 1: Tìm từ ảnh lớn nhất - 600x600 hoặc 408x408 từ product cache
        if (preg_match('/["\']https:\/\/www\.tdm\.vn\/image\/cache\/catalog\/product-\d+\/[^"\']+\.jpg["\']/', $html, $matches)) {
            return preg_replace('/["\']/', '', $matches[0]);
        }
        
        // Cách 2: Tìm từ thẻ img có data-src với product folder
        if (preg_match('/data-src=["\']https:\/\/[^\s"\']*\/product-\d+\/[^\s"\']*\.jpg["\']/', $html, $matches)) {
            return preg_replace('/data-src=["\']|["\']/', '', $matches[0]);
        }
        
        // Cách 3: Tìm ảnh JPG từ image/cache/catalog/product (pattern khác)
        if (preg_match_all('/["\']https:\/\/www\.tdm\.vn\/image\/[^\s"\']*\.jpg["\']/', $html, $matches)) {
            foreach ($matches[0] as $url) {
                $cleanUrl = preg_replace('/["\']/', '', $url);
                if (strpos($cleanUrl, 'product') !== false && strlen($cleanUrl) > 50) {
                    return $cleanUrl;
                }
            }
        }
        
        // Cách 4: Tìm ảnh JPG lớn nhất từ tdm.vn
        if (preg_match_all('/https:\/\/www\.tdm\.vn\/image\/[^\s"\']*\.jpg/', $html, $matches)) {
            foreach ($matches[0] as $url) {
                if (strpos($url, 'product') !== false || strpos($url, 'catalog') !== false) {
                    return $url;
                }
            }
        }
        
        return null;
    }
    
    private function normalizeUrl($url)
    {
        // Loại bỏ quotes
        $url = preg_replace('/["\']/', '', $url);
        
        // Nếu URL đã complete, trả về
        if (strpos($url, 'http') === 0) {
            return $url;
        }
        
        // Nếu là URL tương đối, thêm domain
        if (strpos($url, '/') === 0) {
            return 'https://www.tdm.vn' . $url;
        }
        
        return 'https://www.tdm.vn/' . $url;
    }
}
