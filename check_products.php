<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$kernel = $app->make('Illuminate\Contracts\Console\Kernel');
$kernel->bootstrap();

$totalProducts = \App\Models\Product::count();
$brandStats = \App\Models\Product::selectRaw('brand_id, COUNT(*) as count, brands.name')
    ->join('brands', 'products.brand_id', '=', 'brands.id')
    ->groupBy('brand_id', 'brands.id', 'brands.name')
    ->get();

echo "=== TỔNG HỢP SẢN PHẨM ===\n\n";
echo "Tổng số sản phẩm: " . $totalProducts . "\n\n";
echo "Phân bổ theo thương hiệu:\n";
foreach ($brandStats as $stat) {
    echo "  - {$stat->name}: {$stat->count} sản phẩm\n";
}

// Kiểm tra một vài sản phẩm
$sampleProducts = \App\Models\Product::with(['brand', 'images'])->limit(3)->get();
echo "\n=== MẪU SẢN PHẨM ===\n";
foreach ($sampleProducts as $product) {
    echo "\nSản phẩm: {$product->name}\n";
    echo "  - SKU: {$product->sku}\n";
    echo "  - Giá: " . number_format($product->price) . " VNĐ\n";
    echo "  - Thương hiệu: {$product->brand->name}\n";
    echo "  - Ảnh: " . $product->images->count() . " hình\n";
}
?>
