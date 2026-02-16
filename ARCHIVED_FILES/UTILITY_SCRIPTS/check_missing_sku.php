<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$productsWithoutSKU = Product::whereNull('sku')
    ->orWhere('sku', '')
    ->get();

echo "Products without SKU: " . $productsWithoutSKU->count() . "\n\n";

if ($productsWithoutSKU->count() > 0) {
    echo "Products needing SKU:\n";
    echo str_repeat("=", 80) . "\n";
    foreach ($productsWithoutSKU as $product) {
        echo "ID: {$product->id} | Brand: {$product->brand_id} | Name: {$product->name}\n";
    }
}
