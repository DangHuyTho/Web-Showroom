<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

// Check Viglacera brand
$result = $db->query("SELECT * FROM brands WHERE name = 'Viglacera'")->fetch(PDO::FETCH_ASSOC);
echo "Brand Viglacera: " . json_encode($result, JSON_UNESCAPED_UNICODE) . "\n";
?>
