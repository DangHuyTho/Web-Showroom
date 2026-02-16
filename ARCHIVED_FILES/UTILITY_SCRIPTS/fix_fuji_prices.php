<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

// Fix price for NPLS product (should be around 204000 based on website)
$db->exec("UPDATE products SET price = 204000 WHERE id = 54");

// Verify the fix
$product = $db->query("SELECT id, name, price FROM products WHERE id = 54")->fetch(PDO::FETCH_ASSOC);
echo "Fixed product: [{$product['id']}] {$product['name']} ({$product['price']}₫)\n";

echo "\nAll Fuji products after fix:\n";
$products = $db->query('SELECT id, name, price FROM products WHERE brand_id = 4 ORDER BY id')->fetchAll(PDO::FETCH_ASSOC);
foreach($products as $p) {
    echo "- [{$p['id']}] {$p['name']} ({$p['price']}₫)\n";
}
?>
