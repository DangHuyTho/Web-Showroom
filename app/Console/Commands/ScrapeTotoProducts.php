<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Console\Command;

class ScrapeTotoProducts extends Command
{
    protected $signature = 'scrape:toto {--pages=5}';
    protected $description = 'Scrape TOTO products from tdm.vn';

    private $baseUrl = 'https://www.tdm.vn/thiet-bi-ve-sinh-toto';
    private $products = [];

    public function handle()
    {
        $this->info('🔍 Bắt đầu scrape sản phẩm TOTO từ tdm.vn...');
        
        // Đảm bảo brand TOTO tồn tại
        $brand = Brand::firstOrCreate(
            ['name' => 'TOTO'],
            ['slug' => 'toto']
        );
        
        // Đảm bảo category "Thiết bị vệ sinh" tồn tại
        $category = Category::firstOrCreate(
            ['name' => 'Thiết bị vệ sinh'],
            ['slug' => 'thiet-bi-ve-sinh']
        );

        $pages = (int)$this->option('pages');
        
        for ($page = 1; $page <= $pages; $page++) {
            $this->info("\n📄 Đang scrape trang $page...");
            
            $url = $page === 1 ? $this->baseUrl : $this->baseUrl . "?page=$page";
            
            $products = $this->scrapePage($url);
            
            if (empty($products)) {
                $this->warn("Không tìm thấy sản phẩm trên trang $page");
                break;
            }

            // Lưu vào database
            foreach ($products as $productData) {
                Product::updateOrCreate(
                    ['name' => $productData['name']],
                    [
                        'slug' => str()->slug($productData['name']),
                        'excerpt' => $productData['excerpt'] ?? '',
                        'content' => $productData['content'] ?? '',
                        'price' => $productData['price'] ?? 0,
                        'unit' => 'cái',
                        'brand_id' => $brand->id,
                        'category_id' => $category->id,
                    ]
                );
            }

            $this->info("✅ Đã thêm/cập nhật " . count($products) . " sản phẩm");
            
            // Sleep 2 giây để tránh bị block
            sleep(2);
        }

        $this->info("\n✨ Hoàn thành scrape sản phẩm TOTO!");
    }

    private function scrapePage($url)
    {
        try {
            // Sử dụng cURL để fetch với user-agent
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            
            $html = curl_exec($ch);
            curl_close($ch);

            if (!$html) {
                $this->error("❌ Không thể fetch: $url");
                return [];
            }

            // Parse HTML để lấy sản phẩm
            $products = [];
            
            // Regex để tìm product title và price
            if (preg_match_all('/#### \[([^\]]+)\]\(([^)]+)\)/', $html, $matches)) {
                foreach ($matches[1] as $idx => $title) {
                    $link = $matches[2][$idx] ?? '';
                    
                    $products[] = [
                        'name' => trim($title),
                        'url' => $link,
                        'excerpt' => 'Thiết bị vệ sinh TOTO chính hãng',
                        'content' => 'Sản phẩm TOTO nhập khẩu từ Nhật Bản. Chất lượng cao, bảo hành đầy đủ.',
                        'price' => $this->extractPrice($html, $title),
                    ];
                }
            }

            return array_slice($products, 0, 50); // Giới hạn 50 sản phẩm/trang để tránh trùng

        } catch (\Exception $e) {
            $this->error("❌ Lỗi: " . $e->getMessage());
            return [];
        }
    }

    private function extractPrice($html, $productName)
    {
        // Tìm giá gần tiêu đề sản phẩm
        if (preg_match('/' . preg_quote($productName) . '.*?(\d{1,3}(?:\.\d{3})*(?:,\d{3})?)\s*đ/s', $html, $match)) {
            $price = str_replace(['.', ','], '', $match[1]);
            return (int)$price;
        }
        return 0;
    }
}
