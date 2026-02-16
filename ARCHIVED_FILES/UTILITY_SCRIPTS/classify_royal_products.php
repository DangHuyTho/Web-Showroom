<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product, App\Models\Brand;
use Illuminate\Support\Facades\DB;

$royal = Brand::where('slug', 'royal')->first();
$products = Product::where('brand_id', $royal->id)->get();

// Size pattern mapping
$sizePatterns = [
    '80×80|80x80' => '80×80',
    '60×60|60x60' => '60×60',
    '50×50|50x50' => '50×50',
    '20×20|20x20' => '20×20',
    '15×80|15x80' => '15×80',
];

// Surface types for random assignment
$surfaceTypes = ['vân đá', 'vân gỗ', 'vân cát', 'giả gỗ', 'giả cỏ', 'giả sỏi', 'vân mây', 'trắng'];

echo "=== Classifying ROYAL Sizes and Surface Types ===\n";
$updated = 0;

foreach($products as $product) {
    $size = null;
    $surfaceType = $surfaceTypes[array_rand($surfaceTypes)];
    
    // Extract size from name
    foreach($sizePatterns as $pattern => $sizeValue) {
        if (preg_match('/(' . $pattern . ')/', $product->name)) {
            $size = $sizeValue;
            break;
        }
    }
    
    if ($size) {
        DB::table('products')->where('id', $product->id)->update([
            'size' => $size,
            'surface_type' => $surfaceType
        ]);
        echo $product->id . " | " . substr($product->name, 0, 50) . " => Size: $size, Surface: $surfaceType\n";
        $updated++;
    }
}

echo "\n=== Summary ===\n";
echo "Total Royal products updated: $updated\n";

// Verify
$result = Product::where('brand_id', $royal->id)->groupBy('size')->selectRaw('size, COUNT(*) as count')->get();
echo "\n=== By Size ===\n";
foreach($result as $r) {
    echo ($r->size ?? 'NULL') . ': ' . $r->count . " products\n";
}
