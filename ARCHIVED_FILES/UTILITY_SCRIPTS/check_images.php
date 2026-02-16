<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$products = App\Models\Product::where('brand_id', 3)->whereDoesntHave('images')->get();
echo "Sản phẩm không có ảnh: " . $products->count() . "\n";
foreach($products as $p) {
    echo "- ID {$p->id}: {$p->name}\n";
}

echo "\n--- Hiển thị tất cả TOTO sản phẩm có ảnh ---\n";
$withImages = App\Models\Product::where('brand_id', 3)->has('images')->get();
echo "Total: " . $withImages->count() . "\n";
