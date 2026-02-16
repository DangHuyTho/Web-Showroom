<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

// Count Viglacera products
$count = $db->query('SELECT COUNT(*) FROM products WHERE brand_id = 2')->fetch()[0];
echo "Total Viglacera products: $count\n";

// Fix unrealistic prices (those huge numbers) by setting to a reasonable default
$unrealisticPrice = 9223372036854775807; // PHP_INT_MAX
$db->exec("UPDATE products SET price = 320000 WHERE price = $unrealisticPrice OR price > 1000000");

// Also add proper prices for some known products
$updates = [
    'Gạch Viglacera SG527' => 180000,
    'Gạch Viglacera SG528' => 180000,
    'Gạch Viglacera 5526' => 180000,
    'Gạch Viglacera SG529' => 1200000,
    'Gạch Eurotile YMI S04M' => 480000,
    'Gạch Eurotile NGG S04H' => 480000,
    'Gạch Eurotile THS S01P' => 450000,
];

foreach($updates as $name => $price) {
    $db->exec("UPDATE products SET price = $price WHERE name LIKE '%$name%' AND brand_id = 2");
}

echo "\nViglacera products after price fix:\n";
$products = $db->query('SELECT id, name, price FROM products WHERE brand_id = 2 ORDER BY id DESC LIMIT 10')->fetchAll(PDO::FETCH_ASSOC);
foreach($products as $p) {
    echo "- [{$p['id']}] {$p['name']} ({$p['price']}₫)\n";
}

// Check images
echo "\nTotal Viglacera product images:\n";
$imageCount = $db->query('SELECT COUNT(*) FROM product_images pi 
    JOIN products p ON pi.product_id = p.id 
    WHERE p.brand_id = 2')->fetch()[0];
echo "Images: $imageCount\n";
?>
