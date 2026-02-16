<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Tạo ảnh cho 2 sản phẩm còn lại - dùng GD library
$productsWithoutImages = App\Models\Product::where('brand_id', 3)->whereDoesntHave('images')->get();

$colors = ['#3498db', '#2ecc71', '#9b59b6', '#e67e22', '#e74c3c', '#1abc9c'];

foreach($productsWithoutImages as $idx => $product) {
    echo "Xử lý: {$product->name}\n";
    
    $filename = $product->slug . '.jpg';
    $filepath = public_path('images/products/' . $filename);
    
    try {
        // Tạo ảnh đơn giản với GD
        if (extension_loaded('gd')) {
            $img = imagecreatetruecolor(600, 400);
            
            // Color
            $hex = $colors[$idx % count($colors)];
            list($r, $g, $b) = sscanf($hex, "#%02x%02x%02x");
            $color = imagecolorallocate($img, $r, $g, $b);
            $white = imagecolorallocate($img, 255, 255, 255);
            
            imagefill($img, 0, 0, $color);
            
            // Text
            $text = substr($product->name, 0, 25);
            imagestring($img, 5, 50, 180, $text, $white);
            imagestring($img, 3, 50, 210, 'TOTO Product', $white);
            
            imagejpeg($img, $filepath, 85);
            imagedestroy($img);
            
            App\Models\ProductImage::create([
                'product_id' => $product->id,
                'image_path' => '/images/products/' . $filename,
                'is_primary' => true,
            ]);
            
            echo "  ✅ Thành công\n";
        } else {
            echo "  ⚠️  GD extension không được enable - bỏ qua\n";
        }
    } catch (\Exception $e) {
        echo "  ❌ Lỗi: " . $e->getMessage() . "\n";
    }
}

echo "\n✅ Hoàn thành. Tất cả TOTO sản phẩm giờ đã có ảnh.\n";
echo "Kiểm tra: " . App\Models\Product::where('brand_id', 3)->has('images')->count() . "/50 sản phẩm có ảnh\n";
