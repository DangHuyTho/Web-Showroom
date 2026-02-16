<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product, App\Models\Brand;

$toto = Brand::where('slug', 'toto')->first();
$products = Product::where('brand_id', $toto->id)->orderBy('name')->get(['id', 'name']);

echo "=== TOTO PRODUCTS ===\n";
foreach($products as $p) {
    echo $p->id . " | " . $p->name . "\n";
}

echo "\nTotal: " . $products->count() . "\n";
