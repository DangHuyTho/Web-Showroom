<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

// Check Fuji products
$count = $db->query('SELECT COUNT(*) FROM products WHERE brand_id = 4')->fetch()[0];
echo "Total Fuji products: $count\n";

// Show some Fuji products
echo "\nFuji products:\n";
$products = $db->query('SELECT id, name, price FROM products WHERE brand_id = 4 LIMIT 10')->fetchAll(PDO::FETCH_ASSOC);
foreach($products as $p) {
    echo "- [{$p['id']}] {$p['name']} ({$p['price']}₫)\n";
}

// Check images
echo "\nProductImages for Fuji products:\n";
$images = $db->query('SELECT pi.id, pi.product_id, pi.image_path FROM product_images pi 
    JOIN products p ON pi.product_id = p.id 
    WHERE p.brand_id = 4 LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);
foreach($images as $img) {
    echo "- [{$img['id']}] Product {$img['product_id']}: {$img['image_path']}\n";
}
?>
