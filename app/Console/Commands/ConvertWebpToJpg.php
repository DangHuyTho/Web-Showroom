<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConvertWebpToJpg extends Command
{
    protected $signature = 'images:convert-webp-to-jpg {--folder=toto}';
    protected $description = 'Convert WebP images to JPG format';

    public function handle()
    {
        $folder = $this->option('folder');
        $directory = public_path("images/products/{$folder}");

        if (!is_dir($directory)) {
            $this->error("Folder not found: $directory");
            return 1;
        }

        $this->info("Converting WebP to JPG in: $directory");

        $webpFiles = glob($directory . '/*.webp');
        
        if (empty($webpFiles)) {
            $this->info("No WebP files found in $directory");
            return 0;
        }

        $converted = 0;
        $failed = 0;

        foreach ($webpFiles as $webpFile) {
            try {
                $jpgFile = str_replace('.webp', '.jpg', $webpFile);
                $filename = basename($webpFile);
                
                // Convert using GD Library
                $image = imagecreatefromwebp($webpFile);
                if (!$image) {
                    throw new \Exception("Failed to load WebP file");
                }

                // Save as JPG with 80% quality
                imagejpeg($image, $jpgFile, 80);
                imagedestroy($image);

                // Update database
                $oldPath = "images/products/{$folder}/" . basename($webpFile);
                $newPath = "images/products/{$folder}/" . basename($jpgFile);
                
                \DB::table('product_images')
                    ->where('image_path', $oldPath)
                    ->update(['image_path' => $newPath]);

                // Delete WebP file
                unlink($webpFile);

                $this->line("✓ Converted: $filename");
                $converted++;

            } catch (\Exception $e) {
                $this->error("✗ Failed to convert: " . basename($webpFile) . " - " . $e->getMessage());
                $failed++;
            }
        }

        $this->info("\nConversion completed!");
        $this->info("Converted: $converted files");
        if ($failed > 0) {
            $this->warn("Failed: $failed files");
        }

        return 0;
    }
}
?>
