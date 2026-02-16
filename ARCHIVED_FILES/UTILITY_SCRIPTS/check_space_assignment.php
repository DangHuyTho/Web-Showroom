<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

$total = Product::count();
$assigned = Product::whereNotNull('space_type')->count();
$unassigned = Product::whereNull('space_type')->count();

echo "Space Type Assignment Summary:\n";
echo "=============================\n\n";
echo "Total Products:    $total\n";
echo "Assigned:          $assigned\n";
echo "Unassigned (NULL): $unassigned\n";

if ($unassigned > 0) {
    echo "\nUnassigned Products:\n";
    echo "====================\n\n";
    $products = Product::whereNull('space_type')->get();
    foreach ($products as $product) {
        echo "- {$product->id}: {$product->name} ({$product->brand->name})\n";
    }
}
