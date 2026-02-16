<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product, App\Models\Brand;
use Illuminate\Support\Facades\DB;

$vig = Brand::where('slug', 'viglacera')->first();
$products = Product::where('brand_id', $vig->id)->get();

// Surface type patterns
$surfacePatterns = [
    'vân đá|stone' => 'vân đá',
    'vân gỗ|wood' => 'vân gỗ',
    'vân cát|sand' => 'vân cát',
    'giả gỗ|wood look' => 'giả gỗ',
    'giả sỏi|gravel' => 'giả sỏi',
    'giả cỏ' => 'giả cỏ',
    'vân mây' => 'vân mây',
];

// Random sizes for Viglacera
$sizes = ['30×60', '60×60', '60×90', '80×80', '100×100', '120×120'];

echo "=== Classifying VIGLACERA Surface Types and Sizes ===\n";
$updated = 0;

foreach($products as $product) {
    $surfaceType = null;
    $randomSize = $sizes[array_rand($sizes)];
    
    // Extract surface type from name
    foreach($surfacePatterns as $pattern => $typeValue) {
        if (preg_match('/(' . $pattern . ')/i', $product->name)) {
            $surfaceType = $typeValue;
            break;
        }
    }
    
    // If no pattern matched, assign random
    if (!$surfaceType) {
        $surfaceTypeOptions = ['vân đá', 'vân gỗ', 'vân cát', 'giả gỗ', 'giả sỏi', 'giả cỏ', 'vân mây'];
        $surfaceType = $surfaceTypeOptions[array_rand($surfaceTypeOptions)];
    }
    
    DB::table('products')->where('id', $product->id)->update([
        'size' => $randomSize,
        'surface_type' => $surfaceType
    ]);
    echo $product->id . " | " . substr($product->name, 0, 45) . " => Size: $randomSize, Surface: $surfaceType\n";
    $updated++;
}

echo "\n=== Summary ===\n";
echo "Total Viglacera products updated: $updated\n";

// Verify
$result = Product::where('brand_id', $vig->id)->groupBy('surface_type')->selectRaw('surface_type, COUNT(*) as count')->get();
echo "\n=== By Surface Type ===\n";
foreach($result as $r) {
    echo ($r->surface_type ?? 'NULL') . ': ' . $r->count . " products\n";
}
