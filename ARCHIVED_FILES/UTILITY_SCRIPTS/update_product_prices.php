<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product, App\Models\Brand;
use Illuminate\Support\Facades\DB;

// Price ranges by product type
$priceRanges = [
    // TOTO by product_category
    'toto' => [
        'Bồn Cầu' => [1800000, 5000000],
        'Chậu Lavabo' => [600000, 2500000],
        'Nắp Bồn Cầu' => [1200000, 4000000],
        'Vòi' => [400000, 1800000],
        'Vòi Xịt' => [300000, 1000000],
        'Phễu Thoát & Ống Xả' => [200000, 800000],
    ],
    // Tiles by size
    'tiles' => [
        '15×80' => [120000, 200000],  // m²
        '20×20' => [80000, 150000],
        '30×60' => [100000, 200000],
        '50×50' => [120000, 250000],
        '60×60' => [150000, 300000],
        '60×90' => [180000, 350000],
        '80×80' => [200000, 400000],
        '100×100' => [250000, 450000],
        '120×120' => [300000, 500000],
    ]
];

echo "=== Updating Product Prices ===\n\n";

// Update TOTO products
echo "TOTO Products:\n";
$toto = Brand::where('slug', 'toto')->first();
$totoProducts = Product::where('brand_id', $toto->id)->get();

foreach($totoProducts as $product) {
    $category = $product->product_category;
    
    if (!isset($priceRanges['toto'][$category])) {
        echo $product->id . " | " . substr($product->name, 0, 40) . " | Category: $category => NO RANGE FOUND\n";
        continue;
    }
    
    $range = $priceRanges['toto'][$category];
    $newPrice = rand($range[0], $range[1]);
    
    DB::table('products')->where('id', $product->id)->update(['price' => $newPrice]);
    echo $product->id . " | " . substr($product->name, 0, 40) . " | " . number_format($newPrice, 0, ',', '.') . " đ\n";
}

// Update Tile products (Royal, Viglacera, Fuji)
foreach(['royal', 'viglacera', 'fuji'] as $brandSlug) {
    echo "\n" . strtoupper($brandSlug) . " Products:\n";
    $brand = Brand::where('slug', $brandSlug)->first();
    $products = Product::where('brand_id', $brand->id)->get();
    
    foreach($products as $product) {
        $size = $product->size;
        
        if (!isset($priceRanges['tiles'][$size])) {
            // Default range for unknown sizes
            $range = [100000, 300000];
        } else {
            $range = $priceRanges['tiles'][$size];
        }
        
        $newPrice = rand($range[0], $range[1]);
        
        DB::table('products')->where('id', $product->id)->update(['price' => $newPrice]);
        echo $product->id . " | " . substr($product->name, 0, 40) . " | Size: $size | " . number_format($newPrice, 0, ',', '.') . " đ\n";
    }
}

echo "\n=== Price Update Complete ===\n";

// Summary
echo "\n=== Summary ===\n";
foreach(['royal', 'viglacera', 'fuji', 'toto'] as $slug) {
    $brand = Brand::where('slug', $slug)->first();
    $products = Product::where('brand_id', $brand->id)->get();
    $avgPrice = $products->avg('price');
    $minPrice = $products->min('price');
    $maxPrice = $products->max('price');
    
    echo strtoupper($slug) . ": " . $products->count() . " products | ";
    echo "Avg: " . number_format($avgPrice, 0, ',', '.') . " đ | ";
    echo "Min: " . number_format($minPrice, 0, ',', '.') . " đ | ";
    echo "Max: " . number_format($maxPrice, 0, ',', '.') . " đ\n";
}
