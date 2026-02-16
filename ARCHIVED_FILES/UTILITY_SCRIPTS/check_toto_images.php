<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

echo "=== CHECKING TOTO PRODUCT IMAGES ===\n\n";

// Get last 10 TOTO products
$products = $db->query('SELECT p.id, p.name, pi.image_path 
    FROM products p
    LEFT JOIN product_images pi ON p.id = pi.product_id
    WHERE p.brand_id = 3 AND p.is_active = 1
    ORDER BY p.id DESC
    LIMIT 10')->fetchAll(PDO::FETCH_ASSOC);

echo "Last 10 TOTO products:\n";
echo str_repeat("=", 100) . "\n";

foreach($products as $p) {
    echo "[{$p['id']}] {$p['name']}\n";
    echo "    Image: {$p['image_path']}\n";
    $hasToTo = strpos($p['image_path'], '/toto/') !== false;
    echo "    Has /toto/: " . ($hasToTo ? "✓" : "✗") . "\n\n";
}

// Find problematic images
$problematic = $db->query('SELECT p.id, p.name, pi.id as image_id, pi.image_path 
    FROM products p
    JOIN product_images pi ON p.id = pi.product_id
    WHERE p.brand_id = 3 AND p.is_active = 1
    AND pi.image_path NOT LIKE "%/toto/%"')->fetchAll(PDO::FETCH_ASSOC);

echo "\n" . str_repeat("=", 100) . "\n";
echo "Products WITHOUT /toto/ in path:\n";
echo str_repeat("=", 100) . "\n";

if (empty($problematic)) {
    echo "✅ Không có sản phẩm nào lỗi!\n";
} else {
    echo "Found " . count($problematic) . " problematic images:\n\n";
    foreach($problematic as $p) {
        echo "[{$p['id']}] {$p['name']}\n";
        echo "    Current: {$p['image_path']}\n";
        
        // Tạo đường dẫn mới
        if (strpos($p['image_path'], 'images/products/') !== false) {
            $newPath = str_replace('images/products/', 'images/products/toto/', $p['image_path']);
        } else {
            $newPath = $p['image_path'];
        }
        echo "    Should be: $newPath\n\n";
    }
}
?>
