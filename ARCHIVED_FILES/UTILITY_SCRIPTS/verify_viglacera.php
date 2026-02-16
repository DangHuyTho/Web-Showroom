<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

echo "=== VIGLACERA PRODUCTS SUMMARY ===\n\n";

// Get Viglacera products
$products = $db->query('SELECT p.id, p.name, p.price, COUNT(pi.id) as image_count 
    FROM products p 
    LEFT JOIN product_images pi ON p.id = pi.product_id
    WHERE p.brand_id = 2 
    GROUP BY p.id
    ORDER BY p.id DESC')->fetchAll(PDO::FETCH_ASSOC);

echo "Total Viglacera products: " . count($products) . "\n";
echo "Total images: " . array_sum(array_column($products, 'image_count')) . "\n\n";

echo "Product List:\n";
foreach($products as $i => $p) {
    $imgStr = $p['image_count'] > 0 ? "✓" : "✗";
    echo ($i+1) . ". [{$p['id']}] {$p['name']} ({$p['price']}₫) - Images: {$p['image_count']} $imgStr\n";
}
?>
