<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

echo "=== COMPLETE PRODUCT CATALOG SUMMARY ===\n\n";

// Get all brands with product counts
$brands = $db->query('SELECT b.id, b.name, 
    COUNT(DISTINCT p.id) as product_count,
    COUNT(DISTINCT pi.id) as image_count
    FROM brands b
    LEFT JOIN products p ON b.id = p.brand_id AND p.is_active = 1
    LEFT JOIN product_images pi ON p.id = pi.product_id
    WHERE b.is_active = 1
    GROUP BY b.id
    ORDER BY b.sort_order')->fetchAll(PDO::FETCH_ASSOC);

echo "Brand Summary:\n";
echo str_repeat("=", 80) . "\n";
$totalProducts = 0;
$totalImages = 0;
foreach($brands as $b) {
    echo "- {$b['name']}: {$b['product_count']} products, {$b['image_count']} images";
    if ($b['product_count'] > 0 && $b['image_count'] === $b['product_count']) {
        echo " ✓ (complete)\n";
    } else if ($b['product_count'] > 0) {
        echo " ⚠ (missing " . ($b['product_count'] - $b['image_count']) . " images)\n";
    } else {
        echo "\n";
    }
    $totalProducts += $b['product_count'];
    $totalImages += $b['image_count'];
}
echo str_repeat("=", 80) . "\n";
echo "Total: $totalProducts products, $totalImages images\n\n";

// Directory structure
echo "Image Directory Structure:\n";
echo "- public/images/products/toto/ (" . count(glob('public/images/products/toto/*.jpg')) . " files)\n";
echo "- public/images/products/fuji/ (" . count(glob('public/images/products/fuji/*.jpg')) . " files)\n";
echo "- public/images/products/viglacera/ (" . count(glob('public/images/products/viglacera/*.jpg')) . " files)\n";
echo "- public/images/products/royal/ (" . count(glob('public/images/products/royal/*.jpg')) . " files)\n";
?>
