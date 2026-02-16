<?php

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;

echo "Space Type Distribution:\n";
echo "========================\n\n";

$distribution = Product::selectRaw('space_type, count(*) as count')
    ->groupBy('space_type')
    ->orderBy('space_type')
    ->get();

$total = 0;
foreach ($distribution as $item) {
    $spaceType = $item->space_type ?? 'NULL';
    $count = $item->count;
    $total += $count;
    echo sprintf("%-20s: %3d products\n", $spaceType, $count);
}

echo "\n" . str_repeat("=", 30) . "\n";
echo sprintf("%-20s: %3d products\n", "TOTAL", $total);
echo "\n";

// Additional stats
echo "\nBrand-wise Distribution:\n";
echo "========================\n\n";

$brandStats = Product::selectRaw('brand_id, space_type, count(*) as count')
    ->with('brand')
    ->groupBy('brand_id', 'space_type')
    ->orderBy('brand_id')
    ->orderBy('space_type')
    ->get();

$currentBrand = null;
foreach ($brandStats as $item) {
    if ($item->brand_id !== $currentBrand) {
        if ($currentBrand !== null) {
            echo "\n";
        }
        echo $item->brand->name . ":\n";
        $currentBrand = $item->brand_id;
    }
    $spaceType = $item->space_type ?? 'NULL';
    echo "  - $spaceType: " . $item->count . "\n";
}
