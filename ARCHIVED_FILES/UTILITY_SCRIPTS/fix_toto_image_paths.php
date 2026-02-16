<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

echo "=== FIXING TOTO IMAGE PATHS ===\n\n";

// Check how many need fixing
$count = $db->query('SELECT COUNT(*) FROM product_images pi 
    JOIN products p ON pi.product_id = p.id
    WHERE p.brand_id = 3 AND pi.image_path NOT LIKE "%/toto/%"')->fetch()[0];

echo "Found $count images to fix.\n\n";

if ($count > 0) {
    // Fix the paths
    $stmt = $db->prepare('UPDATE product_images 
        SET image_path = REPLACE(image_path, "images/products/", "images/products/toto/")
        WHERE product_id IN (
            SELECT id FROM products WHERE brand_id = 3
        ) AND image_path NOT LIKE "%/toto/%"');
    
    $stmt->execute();
    
    echo "✓ Updated " . $db->query('SELECT changes()')->fetch()[0] . " image paths!\n\n";
    
    // Verify
    $remaining = $db->query('SELECT COUNT(*) FROM product_images pi 
        JOIN products p ON pi.product_id = p.id
        WHERE p.brand_id = 3 AND pi.image_path NOT LIKE "%/toto/%"')->fetch()[0];
    
    if ($remaining === 0) {
        echo "✅ All TOTO images now have correct paths!\n";
    } else {
        echo "⚠ Still $remaining images with incorrect paths.\n";
    }
} else {
    echo "✅ All TOTO images already have correct paths!\n";
}

// Show some examples
echo "\nSample of fixed paths:\n";
echo str_repeat("=", 80) . "\n";
$samples = $db->query('SELECT p.name, pi.image_path 
    FROM products p
    JOIN product_images pi ON p.id = pi.product_id
    WHERE p.brand_id = 3 AND pi.image_path LIKE "%/toto/%"
    LIMIT 5')->fetchAll(PDO::FETCH_ASSOC);

foreach($samples as $s) {
    echo "{$s['name']}\n";
    echo "  → {$s['image_path']}\n\n";
}
?>
