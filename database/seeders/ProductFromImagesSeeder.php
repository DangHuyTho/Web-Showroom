<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductFromImagesSeeder extends Seeder
{
    private $skuCounter = [];

    public function run(): void
    {
        // Initialize SKU counters for each brand
        $this->skuCounter = [
            'royal' => 1000,
            'viglacera' => 2000,
            'fuji' => 3000,
            'toto' => 4000,
        ];
        // Get or create categories
        $categories = [
            'gach-lat-nen' => Category::firstOrCreate(['slug' => 'gach-lat-nen'], ['name' => 'Gạch Lát Nền', 'type' => 'product']),
            'gach-bong' => Category::firstOrCreate(['slug' => 'gach-bong'], ['name' => 'Gạch Bông', 'type' => 'product']),
            'ngoi-song' => Category::firstOrCreate(['slug' => 'ngoi-song'], ['name' => 'Ngói Sóng', 'type' => 'product']),
            'ngoi-phang' => Category::firstOrCreate(['slug' => 'ngoi-phang'], ['name' => 'Ngói Phẳng', 'type' => 'product']),
            'phu-kien' => Category::firstOrCreate(['slug' => 'phu-kien'], ['name' => 'Phụ Kiện', 'type' => 'product']),
            'bon-cau' => Category::firstOrCreate(['slug' => 'bon-cau'], ['name' => 'Bồn Cầu', 'type' => 'product']),
            'chau-lavabo' => Category::firstOrCreate(['slug' => 'chau-lavabo'], ['name' => 'Chậu Lavabo', 'type' => 'product']),
            'voi' => Category::firstOrCreate(['slug' => 'voi'], ['name' => 'Vòi', 'type' => 'product']),
        ];

        // Get brands
        $royal = Brand::where('slug', 'royal')->first();
        $viglacera = Brand::where('slug', 'viglacera')->first();
        $fuji = Brand::where('slug', 'fuji')->first();
        $toto = Brand::where('slug', 'toto')->first();

        // Product image base path
        $imagePath = public_path('images/products');

        // ROYAL PRODUCTS
        if ($royal) {
            $this->createProductsFromImages(
                $imagePath . '/royal',
                $royal,
                $categories['gach-lat-nen'],
                'royal',
                ['30x60', '60x60', '60x120', '80x80'],
                ['Polished', 'Matt', 'Textured']
            );
        }

        // VIGLACERA PRODUCTS
        if ($viglacera) {
            $this->createProductsFromImages(
                $imagePath . '/viglacera',
                $viglacera,
                $categories['gach-lat-nen'],
                'viglacera',
                ['30x30', '30x60', '60x60', '120x120'],
                ['Matte', 'Glossy', 'Textured']
            );
        }

        // FUJI PRODUCTS
        if ($fuji) {
            $this->createFujiProducts($imagePath . '/fuji', $fuji, $categories);
        }

        // TOTO PRODUCTS
        if ($toto) {
            $this->createTotoProducts($imagePath . '/toto', $toto, $categories);
        }
    }

    private function createProductsFromImages($dirPath, $brand, $category, $brandType, $sizes, $surfaceTypes)
    {
        if (!is_dir($dirPath)) {
            return;
        }

        $files = array_diff(scandir($dirPath), ['.', '..']);
        $imageFiles = array_filter($files, fn($f) => preg_match('/\.(jpg|jpeg|png)$/i', $f));

        foreach ($imageFiles as $file) {
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            
            // Clean up filename for product name
            $productName = $this->cleanFileName($fileName, $brandType);
            
            // Create product
            $product = Product::create([
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'name' => $productName,
                'slug' => Str::slug($productName),
                'sku' => $this->generateSKU($brand->slug),
                'price' => $this->generatePrice(),
                'unit' => 'm²',
                'size' => $sizes[array_rand($sizes)],
                'surface_type' => $surfaceTypes[array_rand($surfaceTypes)],
                'material' => 'Gạch Porcelain',
                'water_absorption' => '< 0.5%',
                'hardness' => ['PEI 3', 'PEI 4', 'PEI 5'][array_rand(['PEI 3', 'PEI 4', 'PEI 5'])],
                'short_description' => "Sản phẩm {$productName} từ thương hiệu {$brand->name}",
                'description' => "Gạch kiến trúc chất lượng cao từ {$brand->name}. Mã: " . Str::slug($productName),
                'is_active' => true,
                'is_featured' => rand(0, 10) > 7,
            ]);

            // Add product image
            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => "images/products/{$brand->slug}/$file",
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }

    private function createFujiProducts($dirPath, $brand, $categories)
    {
        if (!is_dir($dirPath)) {
            return;
        }

        $files = array_diff(scandir($dirPath), ['.', '..']);
        $imageFiles = array_filter($files, fn($f) => preg_match('/\.(jpg|jpeg|png)$/i', $f));

        $productTypes = ['flat' => 'Ngói phẳng', 'wave' => 'Ngói sóng', 'accessories' => 'Phụ kiện'];

        foreach ($imageFiles as $file) {
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $productName = $this->cleanFileName($fileName, 'fuji');

            // Determine product type and category
            if (str_contains(strtolower($fileName), 'phu-kien') || str_contains(strtolower($fileName), 'accessories')) {
                $productType = 'accessories';
                $category = $categories['phu-kien'];
            } elseif (str_contains(strtolower($fileName), 'song') || str_contains(strtolower($fileName), 'wave')) {
                $productType = 'wave';
                $category = $categories['ngoi-song'];
            } else {
                $productType = 'flat';
                $category = $categories['ngoi-phang'];
            }

            $product = Product::create([
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'name' => $productName,
                'slug' => Str::slug($productName),
                'sku' => $this->generateSKU($brand->slug),
                'price' => $this->generatePrice(),
                'unit' => 'viên',
                'product_type' => $productType,
                'material' => 'Ngói Cao Cấp',
                'short_description' => "$productName - " . $productTypes[$productType],
                'description' => "Ngói cao cấp Fuji từ Thái Lan. Loại: {$productTypes[$productType]}",
                'is_active' => true,
                'is_featured' => rand(0, 10) > 7,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => "images/products/fuji/$file",
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }

    private function createTotoProducts($dirPath, $brand, $categories)
    {
        if (!is_dir($dirPath)) {
            return;
        }

        $files = array_diff(scandir($dirPath), ['.', '..']);
        $imageFiles = array_filter($files, fn($f) => preg_match('/\.(jpg|jpeg|png)$/i', $f));

        $productCategories = [
            'bon-cau' => 'Bồn Cầu',
            'chau-lavabo' => 'Chậu Lavabo',
            'nap-em' => 'Nắp Bồn Cầu',
            'voi' => 'Vòi',
            'ong-xa' => 'Ống Xả',
            'pheu-thoat' => 'Phễu Thoát',
        ];

        foreach ($imageFiles as $file) {
            $fileName = pathinfo($file, PATHINFO_FILENAME);
            $productName = $this->cleanFileName($fileName, 'toto');

            // Determine category
            $category = $categories['bon-cau'];
            foreach ($productCategories as $keyword => $catName) {
                if (str_contains(strtolower($fileName), $keyword)) {
                    $category = $categories[Str::slug($catName)] ?? $categories['bon-cau'];
                    break;
                }
            }

            // Determine product category for filter
            $productCategory = 'Bồn Cầu';
            if (str_contains(strtolower($fileName), 'chau-lavabo') || str_contains(strtolower($fileName), 'chau-rua')) {
                $productCategory = 'Chậu Lavabo';
            } elseif (str_contains(strtolower($fileName), 'nap-em')) {
                $productCategory = 'Nắp Bồn Cầu';
            } elseif (str_contains(strtolower($fileName), 'voi-lavabo')) {
                $productCategory = 'Vòi';
            } elseif (str_contains(strtolower($fileName), 'voi-xit')) {
                $productCategory = 'Vòi Xịt';
            } elseif (str_contains(strtolower($fileName), 'ong-xa')) {
                $productCategory = 'Ống Xả & Phễu';
            }

            $product = Product::create([
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'name' => $productName,
                'slug' => Str::slug($productName),
                'sku' => $this->generateSKU($brand->slug),
                'price' => $this->generatePrice(5000000, 60000000),
                'unit' => 'bộ',
                'product_category' => $productCategory,
                'material' => 'Sứ cao cấp',
                'short_description' => "$productName - Thiết bị vệ sinh Toto",
                'description' => "Thiết bị vệ sinh cao cấp Toto công nghệ Nhật Bản. Danh mục: $productCategory",
                'is_active' => true,
                'is_featured' => rand(0, 10) > 7,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => "images/products/toto/$file",
                'is_primary' => true,
                'sort_order' => 1,
            ]);
        }
    }

    private function generateSKU($brandSlug)
    {
        $prefix = strtoupper(substr($brandSlug, 0, 3));
        $this->skuCounter[$brandSlug]++;
        return "{$prefix}-{$this->skuCounter[$brandSlug]}";
    }

    private function generatePrice($min = 150000, $max = 800000)
    {
        // Generate price in steps of 5000
        $price = rand(intval($min / 5000), intval($max / 5000)) * 5000;
        return $price;
    }

    private function cleanFileName($fileName, $brandType)
    {
        // Remove timestamp suffix
        $cleaned = preg_replace('/_\d+$/', '', $fileName);
        
        // Convert hyphens to spaces and title case
        $cleaned = str_replace('-', ' ', $cleaned);
        
        // Remove file extension if present
        $cleaned = preg_replace('/\.[^.]+$/', '', $cleaned);
        
        // Title case
        $cleaned = ucwords(strtolower($cleaned));
        
        return trim($cleaned);
    }
}
