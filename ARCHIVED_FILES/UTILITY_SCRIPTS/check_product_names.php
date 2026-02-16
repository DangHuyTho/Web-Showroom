<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product, App\Models\Brand;

echo "=== ROYAL PRODUCTS (all) ===\n";
$royal = Brand::where('slug', 'royal')->first();
$products = Product::where('brand_id', $royal->id)->get(['id', 'name', 'size']);
foreach($products as $p) {
    echo $p->id . ' | ' . $p->name . ' | Size: ' . ($p->size ?? 'NULL') . "\n";
}

echo "\n=== VIGLACERA PRODUCTS (all) ===\n";
$vig = Brand::where('slug', 'viglacera')->first();
$products = Product::where('brand_id', $vig->id)->get(['id', 'name', 'surface_type']);
foreach($products as $p) {
    echo $p->id . ' | ' . substr($p->name, 0, 50) . ' | Surface: ' . ($p->surface_type ?? 'NULL') . "\n";
}
