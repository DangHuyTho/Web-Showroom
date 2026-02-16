<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

echo "=== UPDATING FUJI PRODUCT TYPES ===\n\n";

// Get all Fuji products
$products = $db->query('SELECT id, name FROM products WHERE brand_id = 4')->fetchAll(PDO::FETCH_ASSOC);

echo "Found " . count($products) . " Fuji products\n\n";

$waveCount = 0;
$flatCount = 0;
$accessoriesCount = 0;

foreach ($products as $product) {
    $name = strtolower($product['name']);
    $productType = null;
    
    // Determine product type based on name
    if (strpos($name, 'sóng') !== false || 
        preg_match('/m8|m9|m10|m11|m1\.1|m1\.2|m3\.1|m5\.1|m10\.1/', $name)) {
        $productType = 'wave';
        $waveCount++;
    } elseif (strpos($name, 'phẳng') !== false || 
              strpos($name, 'lấy sáng') !== false ||
              strpos($name, 'npls') !== false) {
        $productType = 'flat';
        $flatCount++;
    } elseif (strpos($name, 'phụ kiện') !== false || 
              strpos($name, 'cuối') !== false ||
              strpos($name, 'nóc') !== false ||
              strpos($name, 'rìa') !== false ||
              strpos($name, 'đầu') !== false) {
        $productType = 'accessories';
        $accessoriesCount++;
    } else {
        // Default to wave if no match
        $productType = 'wave';
        $waveCount++;
    }
    
    // Update product
    $stmt = $db->prepare('UPDATE products SET product_type = ? WHERE id = ?');
    $stmt->execute([$productType, $product['id']]);
    
    echo "[{$product['id']}] {$product['name']}\n";
    echo "     → $productType\n\n";
}

echo str_repeat("=", 80) . "\n";
echo "Summary:\n";
echo "- Ngói sóng (wave): $waveCount\n";
echo "- Ngói phẳng (flat): $flatCount\n";
echo "- Phụ kiện (accessories): $accessoriesCount\n";
echo "Total: " . ($waveCount + $flatCount + $accessoriesCount) . "\n";
?>
