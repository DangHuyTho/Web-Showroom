<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product, App\Models\Brand;

$toto = Brand::where('slug', 'toto')->first();
$products = Product::where('brand_id', $toto->id)->groupBy('product_category')->selectRaw('product_category, COUNT(*) as count')->get();

echo "=== TOTO Classification Summary ===\n";
foreach($products as $p) {
    echo ($p->product_category ?? 'NULL') . ': ' . $p->count . "\n";
}

echo "\n=== Individual Check (first 5) ===\n";
$all = Product::where('brand_id', $toto->id)->take(5)->get(['id', 'name', 'product_category']);
foreach($all as $p) {
    echo $p->id . " | " . $p->name . " => " . ($p->product_category ?? 'NULL') . "\n";
}
