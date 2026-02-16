<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product, App\Models\Brand;

echo "=== VERIFICATION ===\n\n";

echo "Royal Products (5 samples):\n";
$royal = Brand::where('slug', 'royal')->first();
$products = Product::where('brand_id', $royal->id)->take(5)->get(['id', 'name', 'size', 'surface_type']);
foreach($products as $p) {
    echo "- Size: " . ($p->size ?? 'NULL') . " | Surface: " . ($p->surface_type ?? 'NULL') . "\n";
}

echo "\nViglacera Products (5 samples):\n";
$vig = Brand::where('slug', 'viglacera')->first();
$products = Product::where('brand_id', $vig->id)->take(5)->get(['id', 'name', 'size', 'surface_type']);
foreach($products as $p) {
    echo "- Size: " . ($p->size ?? 'NULL') . " | Surface: " . ($p->surface_type ?? 'NULL') . "\n";
}

echo "\nFuji Products (5 samples):\n";
$fuji = Brand::where('slug', 'fuji')->first();
$products = Product::where('brand_id', $fuji->id)->take(5)->get(['id', 'name', 'product_type']);
foreach($products as $p) {
    echo "- Type: " . ($p->product_type ?? 'NULL') . "\n";
}

echo "\nToto Products (5 samples):\n";
$toto = Brand::where('slug', 'toto')->first();
$products = Product::where('brand_id', $toto->id)->take(5)->get(['id', 'name', 'product_category']);
foreach($products as $p) {
    echo "- Category: " . ($p->product_category ?? 'NULL') . "\n";
}
