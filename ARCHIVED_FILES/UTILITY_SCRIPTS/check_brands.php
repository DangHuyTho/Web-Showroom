<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

// Check if Fuji brand exists
$result = $db->query("SELECT * FROM brands WHERE name = 'Fuji'")->fetch(PDO::FETCH_ASSOC);
echo "Brand Fuji: " . json_encode($result, JSON_UNESCAPED_UNICODE) . "\n";

// List all brands
echo "\nAll brands:\n";
$brands = $db->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_ASSOC);
foreach($brands as $b) {
    echo $b['id'] . ': ' . $b['name'] . "\n";
}
?>
