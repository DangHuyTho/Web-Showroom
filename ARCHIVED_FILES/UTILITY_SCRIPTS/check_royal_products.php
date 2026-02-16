<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

echo "=== ROYAL/CERAMIC PRODUCTS SUMMARY ===\n\n";

// Get Royal products
$products = $db->query('SELECT p.id, p.name, p.price, COUNT(pi.id) as image_count 
    FROM products p 
    LEFT JOIN product_images pi ON p.id = pi.product_id
    WHERE p.brand_id = 1 
    GROUP BY p.id
    ORDER BY p.id DESC')->fetchAll(PDO::FETCH_ASSOC);

echo "Total Royal/Ceramic products: " . count($products) . "\n";
echo "Total images: " . array_sum(array_column($products, 'image_count')) . "\n\n";

echo "Product List (latest 20):\n";
$count = 0;
foreach($products as $p) {
    if ($count >= 20) break;
    $imgStr = $p['image_count'] > 0 ? "✓" : "✗";
    echo ($count+1) . ". [{$p['id']}] {$p['name']} ({$p['price']}₫) - Images: {$p['image_count']} $imgStr\n";
    $count++;
}
?>
