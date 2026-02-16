<?php
require_once 'vendor/autoload.php';

$totoDir = __DIR__ . '/public/images/products/toto';
$db = new PDO('sqlite:database/database.sqlite');

if (!is_dir($totoDir)) {
    echo "Thư mục toto không tồn tại!\n";
    exit(1);
}

// Tìm tất cả file WebP
$webpFiles = glob($totoDir . '/*.webp');
echo "Tìm thấy " . count($webpFiles) . " file WebP trong thư mục toto\n\n";

if (empty($webpFiles)) {
    echo "Không có file WebP nào cần convert!\n";
    exit(0);
}

// Kiểm tra Imagick
if (!extension_loaded('imagick')) {
    echo "⚠ ImageMagick (Imagick) không được cài đặt. Sẽ chỉ copy file.\n\n";
    $useImagick = false;
} else {
    $useImagick = true;
    echo "✓ Imagick có sẵn, sẽ convert ảnh.\n\n";
}

$converted = 0;
$copied = 0;
$failed = 0;

foreach ($webpFiles as $webpFile) {
    $fileName = basename($webpFile);
    $jpgFile = str_replace('.webp', '.jpg', $webpFile);
    
    echo "Processing: $fileName ... ";
    
    try {
        // Kiểm tra nếu file JPG đã tồn tại
        if (file_exists($jpgFile)) {
            echo "JPG đã tồn tại\n";
            // Xóa file WebP cũ
            if (file_exists($webpFile)) {
                unlink($webpFile);
            }
            $converted++;
            continue;
        }
        
        if ($useImagick) {
            // Dùng Imagick
            try {
                $image = new \Imagick($webpFile);
                $image->setImageFormat('jpeg');
                $image->setImageQuality(85);
                $image->writeImage($jpgFile);
                $image->destroy();
                
                // Xóa file WebP cũ
                unlink($webpFile);
                echo "✓ Converted\n";
                $converted++;
            } catch (\Exception $e) {
                echo "✗ Lỗi: " . $e->getMessage() . "\n";
                $failed++;
            }
        } else {
            // Chỉ copy file
            if (copy($webpFile, $jpgFile)) {
                unlink($webpFile);
                echo "✓ Copied\n";
                $copied++;
            } else {
                echo "✗ Copy thất bại\n";
                $failed++;
            }
        }
    } catch (\Exception $e) {
        echo "✗ Lỗi: " . $e->getMessage() . "\n";
        $failed++;
    }
}

echo "\n";
echo str_repeat("=", 60) . "\n";
echo "Kết quả: $converted converted, $copied copied, $failed failed\n";

// Update database paths
echo "\nCập nhật database...\n";
$update = $db->exec("UPDATE product_images 
    SET image_path = REPLACE(image_path, '.webp', '.jpg') 
    WHERE image_path LIKE '%.webp' AND image_path LIKE '%toto%'");

if ($update !== false) {
    echo "✓ Cập nhật database thành công!\n";
} else {
    echo "✗ Lỗi cập nhật database\n";
}

// Danh sách file hiện tại
echo "\nDanh sách file WebP còn lại (nếu có):\n";
$remaining = glob($totoDir . '/*.webp');
if (empty($remaining)) {
    echo "✓ Không có file WebP nào còn lại!\n";
} else {
    foreach ($remaining as $file) {
        echo "- " . basename($file) . "\n";
    }
}
?>
