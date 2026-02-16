<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;

class DownloadProductImages extends Command
{
    protected $signature = 'products:generate-images {--limit=48}';
    protected $description = 'Generate product placeholder images';

    public function handle()
    {
        $limit = (int)$this->option('limit');
        $products = Product::where('brand_id', 3)->limit($limit)->get(); // brand_id 3 = TOTO
        
        $this->info("🖼️  Bắt đầu tạo ảnh cho " . count($products) . " sản phẩm TOTO...\n");
        
        $successCount = 0;

        foreach ($products as $index => $product) {
            $this->info("[$index/$limit] Xử lý: {$product->name}");
            
            // Tạo tên file từ slug
            $filename = $product->slug . '.jpg';
            $filepath = public_path('images/products/' . $filename);
            
            // Kiểm tra xem ảnh đã tồn tại chưa
            if (file_exists($filepath)) {
                $this->line("  ✓ Ảnh đã tồn tại");
                
                // Kiểm tra database record
                if (!ProductImage::where('product_id', $product->id)->exists()) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => '/images/products/' . $filename,
                        'is_primary' => true,
                    ]);
                }
                continue;
            }

            try {
                $this->createSimpleImage($product, $filename);
                $this->line("  ✅ Tạo thành công");
                $successCount++;
            } catch (\Exception $e) {
                $this->warn("  ❌ Lỗi: " . $e->getMessage());
            }
        }

        $this->info("\n✨ Hoàn thành!");
        $this->info("✅ Tạo ảnh thành công: $successCount / " . count($products));
    }

    private function createSimpleImage($product, $filename)
    {
        // Tạo ảnh SVG đơn giản
        $colors = ['3498db', '2ecc71', '9b59b6', 'e67e22', 'e74c3c', '1abc9c'];
        $color = $colors[array_rand($colors)];
        
        $width = 600;
        $height = 400;
        
        // Tạo SVG
        $svg = <<<SVG
<?xml version="1.0" encoding="UTF-8"?>
<svg width="$width" height="$height" xmlns="http://www.w3.org/2000/svg">
    <defs>
        <linearGradient id="grad" x1="0%" y1="0%" x2="0%" y2="100%">
            <stop offset="0%" style="stop-color:#$color;stop-opacity:1" />
            <stop offset="100%" style="stop-color:#ecf0f1;stop-opacity:1" />
        </linearGradient>
    </defs>
    <rect width="$width" height="$height" fill="url(#grad)"/>
    <text x="$width" y="180" font-size="28" font-weight="bold" text-anchor="end" fill="white" font-family="Arial">
        TOTO
    </text>
    <text x="$width" y="220" font-size="16" text-anchor="end" fill="white" font-family="Arial">
        Sanitary Product
    </text>
</svg>
SVG;

        // Lưu SVG
        $svgPath = public_path('images/products/' . str_replace('.jpg', '.svg', $filename));
        file_put_contents($svgPath, $svg);
        
        // Convert SVG to JPG (simple approach: lưu ảnh placeholder JPEG bằng format tương tự)
        // Nếu không có libraryImageMagick/GD, tôi sẽ copy một ảnh placeholder generic
        
        // Tạo JPG placeholder đơn giản
        $jpgData = $this->createJpegPlaceholder($color);
        file_put_contents(
            public_path('images/products/' . $filename),
            $jpgData
        );
        
        // Lưu record vào database
        ProductImage::create([
            'product_id' => $product->id,
            'image_path' => '/images/products/' . $filename,
            'is_primary' => true,
        ]);
    }

    private function createJpegPlaceholder($hexColor)
    {
        // Tạo ảnh JPG đơn giản từ canvas
        // Vì GD library có thể không được enable, ta tạo binary data của một ảnh nhỏ đơn giản
        // hoặc download từ placeholder service
        
        $colors = [
            '3498db' => [52, 152, 219],   // Blue
            '2ecc71' => [46, 204, 113],   // Green
            '9b59b6' => [155, 89, 182],   // Purple
            'e67e22' => [230, 126, 34],   // Orange
            'e74c3c' => [231, 76, 60],    // Red
            '1abc9c' => [26, 188, 156],   // Teal
        ];
        
        $rgb = $colors[$hexColor] ?? [52, 152, 219];
        
        // Tạo GIF placeholder rất nhỏ (1x1 pixel) - đây là workaround
        // Tốt hơn sẽ là download từ placeholder service
        $placeholderUrl = "https://via.placeholder.com/600x400/$hexColor/ffffff?text=TOTO";
        
        try {
            $imageData = @file_get_contents($placeholderUrl);
            if ($imageData !== false) {
                return $imageData;
            }
        } catch (\Exception $e) {
            // Fallback
        }
        
        // Fallback: Tạo 1x1 JPEG từ binary data (minimal JPEG)
        // JPG header for solid color 600x400
        // Đây là cách manual tạo JPEG header (complex, tôi sẽ dùng base64)
        
        return base64_decode(
            '/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCAABAAEDASIAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8VAFQEBAQAAAAAAAAAAAAAAAAAAAAX/xAAUEQEAAAAAAAAAAAAAAAAAAAAA/9oADAMBAAIRAxEAPwCwAA8A/9k='
        );
    }
}


