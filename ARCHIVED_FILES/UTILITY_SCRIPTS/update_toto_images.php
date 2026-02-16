<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

// Update product_images table - change .webp to .jpg for toto products
$result = $db->exec("
    UPDATE product_images 
    SET image_path = REPLACE(image_path, '.webp', '.jpg')
    WHERE image_path LIKE 'images/products/toto/%.webp'
");

echo "Database updated: $result rows affected\n";

// Verify the changes
echo "\nVerifying TOTO product images:\n";
$images = $db->query("
    SELECT pi.id, pi.product_id, pi.image_path 
    FROM product_images pi 
    JOIN products p ON pi.product_id = p.id 
    WHERE p.brand_id = 3
    LIMIT 10
")->fetchAll(PDO::FETCH_ASSOC);

foreach($images as $img) {
    echo "- [{$img['id']}] Product {$img['product_id']}: {$img['image_path']}\n";
}

echo "\nDone! All TOTO images converted from WebP to JPG.\n";
?>
