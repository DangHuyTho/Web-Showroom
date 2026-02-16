<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Product, App\Models\Brand;
use Illuminate\Support\Facades\DB;

$toto = Brand::where('slug', 'toto')->first();

// Classification mapping
$classifications = [
    'Bồn Cầu' => ['Bồn Cầu'],
    'Chậu Lavabo' => ['Chậu Lavabo', 'Chậu Rửa Lavabo'],
    'Nắp Bồn Cầu' => ['Nắp Rửa Điện Tử Washlet', 'Nắp Êm Bồn Cầu'],
    'Vòi' => ['Vòi Chậu Rửa', 'Vòi Lavabo', 'Vòi Sen'],
    'Vòi Xịt' => ['Vòi Xịt'],
    'Phễu Thoát & Ống Xả' => ['Phểu Thoát Sàn', 'Ống Xả Nước', 'T Cầu', 'Bộ Thoát'],
];

$products = Product::where('brand_id', $toto->id)->get();
echo "=== Updating TOTO Products ===\n";
$updated = 0;

foreach($products as $product) {
    $category = null;
    
    foreach($classifications as $cat => $keywords) {
        foreach($keywords as $keyword) {
            if(stripos($product->name, $keyword) !== false) {
                $category = $cat;
                break 2;
            }
        }
    }
    
    if($category) {
        // Use direct DB update
        DB::table('products')->where('id', $product->id)->update(['product_category' => $category]);
        echo $product->id . " | " . $product->name . " => " . $category . "\n";
        $updated++;
    }
}

echo "\n=== Updated: $updated products ===\n";

// Verify
echo "\n=== Verification ===\n";
$result = Product::where('brand_id', $toto->id)->groupBy('product_category')->selectRaw('product_category, COUNT(*) as count')->get();
foreach($result as $r) {
    echo ($r->product_category ?? 'NULL') . ': ' . $r->count . " products\n";
}
