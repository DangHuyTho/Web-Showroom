<?php
require_once 'vendor/autoload.php';

$db = new PDO('sqlite:database/database.sqlite');

echo "=== FINAL VERIFICATION ===\n\n";

// Check database
$webpCount = $db->query("SELECT COUNT(*) FROM product_images WHERE image_path LIKE '%.webp'")->fetch()[0];
echo "📊 Database records with .webp extension: $webpCount\n";

// Check file system
$webpFiles = [];
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('public/images/products/'));
foreach ($iterator as $file) {
    if (strtolower($file->getExtension()) === 'webp') {
        $webpFiles[] = $file->getPathname();
    }
}
echo "📂 WebP files in filesystem: " . count($webpFiles) . "\n\n";

// TOTO folder summary
echo "=== TOTO FOLDER SUMMARY ===\n";
$jpgCount = count(glob('public/images/products/toto/*.jpg'));
$webpCount = count(glob('public/images/products/toto/*.webp'));
echo "JPG files: $jpgCount\n";
echo "WebP files: $webpCount\n";

// Get product count
$totoProducts = $db->query("SELECT COUNT(*) FROM products WHERE brand_id = 3 AND is_active = 1")->fetch()[0];
echo "Active products: $totoProducts\n";

$totoImages = $db->query("SELECT COUNT(*) FROM product_images pi 
    JOIN products p ON pi.product_id = p.id 
    WHERE p.brand_id = 3")->fetch()[0];
echo "Product images: $totoImages\n\n";

if ($jpgCount > 0 && $webpCount === 0) {
    echo "✅ SUCCESS: All WebP files have been converted to JPG!\n";
} else {
    echo "⚠️ WARNING: Some WebP files may still exist.\n";
}
?>
