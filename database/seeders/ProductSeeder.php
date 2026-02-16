<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $royal = Brand::where('slug', 'royal')->first();
        $viglacera = Brand::where('slug', 'viglacera')->first();
        $toto = Brand::where('slug', 'toto')->first();
        $fuji = Brand::where('slug', 'fuji')->first();

        // Royal Products
        if ($royal) {
            $gachLatNen = Category::where('slug', 'gach-lat-nen')->first();
            $products = [
                [
                    'name' => 'Royal Marble 80x80',
                    'slug' => 'royal-marble-80x80',
                    'brand_id' => $royal->id,
                    'category_id' => $gachLatNen->id ?? 1,
                    'size' => '80x80',
                    'surface_type' => 'Marble-like',
                    'material' => 'Porcelain',
                    'price' => 450000,
                    'unit' => 'm²',
                    'short_description' => 'Gạch giả đá cẩm thạch cao cấp, kích thước lớn',
                    'description' => 'Gạch Royal Marble 80x80 với thiết kế giả đá cẩm thạch tự nhiên, độ bền cao và dễ vệ sinh.',
                    'water_absorption' => '< 0.5%',
                    'hardness' => 'PEI 4',
                    'is_featured' => true,
                ],
                [
                    'name' => 'Royal Wood 60x120',
                    'slug' => 'royal-wood-60x120',
                    'brand_id' => $royal->id,
                    'category_id' => $gachLatNen->id ?? 1,
                    'size' => '60x120',
                    'surface_type' => 'Wood-like',
                    'material' => 'Porcelain',
                    'price' => 520000,
                    'unit' => 'm²',
                    'short_description' => 'Gạch giả gỗ khổ lớn, sang trọng',
                    'description' => 'Gạch Royal Wood với thiết kế giả gỗ tự nhiên, phù hợp cho không gian hiện đại.',
                    'water_absorption' => '< 0.5%',
                    'hardness' => 'PEI 4',
                    'is_featured' => true,
                ],
            ];

            foreach ($products as $product) {
                Product::create($product);
            }
        }

        // Toto Products
        if ($toto) {
            $bonCau = Category::where('slug', 'bon-cau')->first();
            $chauRua = Category::where('slug', 'chau-rua')->first();
            $products = [
                [
                    'name' => 'Toto Neorest AH',
                    'slug' => 'toto-neorest-ah',
                    'brand_id' => $toto->id,
                    'category_id' => $bonCau->id ?? 1,
                    'price' => 45000000,
                    'unit' => 'bộ',
                    'short_description' => 'Bồn cầu thông minh cao cấp với công nghệ Washlet',
                    'description' => 'Bồn cầu thông minh Toto Neorest với công nghệ Cefiontect kháng khuẩn, tự động mở nắp, sưởi ấm ghế ngồi.',
                    'features' => ['Công nghệ Cefiontect', 'Tự động mở/đóng nắp', 'Sưởi ấm ghế ngồi', 'Vệ sinh tự động'],
                    'is_featured' => true,
                ],
                [
                    'name' => 'Toto Lavabo LK',
                    'slug' => 'toto-lavabo-lk',
                    'brand_id' => $toto->id,
                    'category_id' => $chauRua->id ?? 1,
                    'price' => 3500000,
                    'unit' => 'bộ',
                    'short_description' => 'Chậu rửa lavabo đặt bàn cao cấp',
                    'description' => 'Chậu rửa lavabo Toto với thiết kế hiện đại, dễ vệ sinh và độ bền cao.',
                ],
            ];

            foreach ($products as $product) {
                Product::create($product);
            }
        }

        // Fuji Products
        if ($fuji) {
            $ngoiSong = Category::where('slug', 'ngoi-song')->first();
            $products = [
                [
                    'name' => 'Fuji Ngói Xám',
                    'slug' => 'fuji-ngoi-xam',
                    'brand_id' => $fuji->id,
                    'category_id' => $ngoiSong->id ?? 1,
                    'price' => 85000,
                    'unit' => 'viên',
                    'short_description' => 'Ngói sóng màu xám cao cấp',
                    'description' => 'Ngói Fuji màu xám với độ bền cao, chống thấm tốt, phù hợp với kiến trúc hiện đại.',
                    'is_featured' => true,
                ],
            ];

            foreach ($products as $product) {
                Product::create($product);
            }
        }
    }
}
