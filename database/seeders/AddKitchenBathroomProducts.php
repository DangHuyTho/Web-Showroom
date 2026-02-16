<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class AddKitchenBathroomProducts extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add kitchen and bathroom products
        $products = [
            // Kitchen tiles - Royal
            [
                'brand_id' => 1,
                'category_id' => 1,
                'name' => 'Royal Bề Mặt Bóng 30x60 - Trắng Sáng',
                'slug' => 'royal-bemat-bong-30x60-trang-sang',
                'short_description' => 'Gạch bề mặt bóng chống trơn cho nhà bếp',
                'description' => 'Gạch Royal kích thước 30x60cm, bề mặt bóng, màu trắng sáng. Dễ vệ sinh và chống trơn, lý tưởng cho nhà bếp.',
                'sku' => 'ROYAL-30X60-TRANG-1',
                'price' => 125000,
                'unit' => 'viên',
                'size' => '30x60',
                'surface_type' => 'Bóng',
                'is_active' => 1,
                'is_featured' => 1,
                'sort_order' => 50,
                'spaces' => ['kitchen']
            ],
            // Kitchen tiles - Viglacera
            [
                'brand_id' => 2,
                'category_id' => 1,
                'name' => 'Viglacera Lát Bếp 25x50 - Kem Nhạt',
                'slug' => 'viglacera-lat-bep-25x50-kem-nhat',
                'short_description' => 'Gạch chuyên dùng lát bếp màu kem nhạt',
                'description' => 'Gạch Viglacera kích thước 25x50cm, chuyên dùng cho nhà bếp, màu kem nhạt dễ phối hợp.',
                'sku' => 'VIG-25X50-KEM-1',
                'price' => 95000,
                'unit' => 'viên',
                'size' => '25x50',
                'surface_type' => 'Bóng',
                'is_active' => 1,
                'is_featured' => 1,
                'sort_order' => 51,
                'spaces' => ['kitchen']
            ],
            // Bathroom tiles - Royal
            [
                'brand_id' => 1,
                'category_id' => 1,
                'name' => 'Royal Ốp Phòng Tắm 20x30 - Xanh Nhạt',
                'slug' => 'royal-op-phong-tam-20x30-xanh-nhat',
                'short_description' => 'Gạch ốp phòng tắm Royal màu xanh nhạt',
                'description' => 'Gạch ốp phòng tắm Royal kích thước 20x30cm, màu xanh nhạt, tạo không gian thoáng mát.',
                'sku' => 'ROYAL-20X30-XANH-1',
                'price' => 85000,
                'unit' => 'viên',
                'size' => '20x30',
                'surface_type' => 'Bóng',
                'is_active' => 1,
                'is_featured' => 1,
                'sort_order' => 52,
                'spaces' => ['bathroom']
            ],
            // Bathroom tiles - Viglacera
            [
                'brand_id' => 2,
                'category_id' => 1,
                'name' => 'Viglacera Chống Trơn Phòng Tắm 20x20 - Xám',
                'slug' => 'viglacera-chong-tron-phong-tam-20x20-xam',
                'short_description' => 'Gạch chống trơn phòng tắm Viglacera',
                'description' => 'Gạch Viglacera chống trơn chuyên dùng phòng tắm, kích thước 20x20cm, màu xám an toàn.',
                'sku' => 'VIG-20X20-XAM-1',
                'price' => 75000,
                'unit' => 'viên',
                'size' => '20x20',
                'surface_type' => 'Nhám',
                'is_active' => 1,
                'is_featured' => 1,
                'sort_order' => 53,
                'spaces' => ['bathroom']
            ],
            // Kitchen + Bathroom - can use both
            [
                'brand_id' => 1,
                'category_id' => 1,
                'name' => 'Royal Đa Năng 30x30 - Trắng',
                'slug' => 'royal-da-nang-30x30-trang',
                'short_description' => 'Gạch đa năng cho nhà bếp và phòng tắm',
                'description' => 'Gạch Royal kích thước 30x30cm, bề mặt bóng, màu trắng tinh. Dùng được cho cả nhà bếp và phòng tắm.',
                'sku' => 'ROYAL-30X30-TRANG-2',
                'price' => 105000,
                'unit' => 'viên',
                'size' => '30x30',
                'surface_type' => 'Bóng',
                'is_active' => 1,
                'is_featured' => 0,
                'sort_order' => 54,
                'spaces' => ['kitchen', 'bathroom']
            ],
            // Kitchen + Bathroom - can use both
            [
                'brand_id' => 2,
                'category_id' => 1,
                'name' => 'Viglacera Bền Vững 25x25 - Nâu',
                'slug' => 'viglacera-ben-vung-25x25-nau',
                'short_description' => 'Gạch bền vững cho nhiều không gian',
                'description' => 'Gạch Viglacera kích thước 25x25cm, bền vững, màu nâu đất phù hợp cho nhà bếp và phòng tắm.',
                'sku' => 'VIG-25X25-NAU-1',
                'price' => 82000,
                'unit' => 'viên',
                'size' => '25x25',
                'surface_type' => 'Nhám',
                'is_active' => 1,
                'is_featured' => 0,
                'sort_order' => 55,
                'spaces' => ['kitchen', 'bathroom']
            ],
        ];

        // Insert products and assign spaces
        foreach ($products as $productData) {
            $spaces = $productData['spaces'];
            unset($productData['spaces']);

            // Create product
            $product = Product::create($productData);

            // Assign spaces
            foreach ($spaces as $space) {
                DB::table('product_space')->insert([
                    'product_id' => $product->id,
                    'space_type' => $space,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        echo "✓ Added 6 new kitchen and bathroom tile products!\n";
    }
}
