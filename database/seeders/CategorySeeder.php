<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Room Categories
        $rooms = [
            ['name' => 'Phòng Khách', 'slug' => 'phong-khach', 'type' => 'room', 'description' => 'Gạch lát nền và ốp tường cho phòng khách'],
            ['name' => 'Phòng Tắm', 'slug' => 'phong-tam', 'type' => 'room', 'description' => 'Thiết bị vệ sinh và gạch ốp phòng tắm'],
            ['name' => 'Nhà Bếp', 'slug' => 'nha-bep', 'type' => 'room', 'description' => 'Gạch chống trơn và dễ vệ sinh cho nhà bếp'],
            ['name' => 'Ngoại Thất', 'slug' => 'ngoai-that', 'type' => 'room', 'description' => 'Gạch sân vườn và ngói mái'],
        ];

        foreach ($rooms as $room) {
            Category::create($room);
        }

        // Product Categories
        $productCategories = [
            ['name' => 'Gạch Lát Nền', 'slug' => 'gach-lat-nen', 'type' => 'product', 'description' => 'Gạch lát nền cao cấp'],
            ['name' => 'Gạch Ốp Tường', 'slug' => 'gach-op-tuong', 'type' => 'product', 'description' => 'Gạch ốp tường đa dạng'],
            ['name' => 'Gạch Sân Vườn', 'slug' => 'gach-san-vuon', 'type' => 'product', 'description' => 'Gạch chống trơn cho sân vườn'],
            ['name' => 'Bồn Cầu', 'slug' => 'bon-cau', 'type' => 'product', 'description' => 'Bồn cầu thông minh và cao cấp'],
            ['name' => 'Chậu Rửa', 'slug' => 'chau-rua', 'type' => 'product', 'description' => 'Chậu rửa lavabo đa dạng'],
            ['name' => 'Sen Vòi', 'slug' => 'sen-voi', 'type' => 'product', 'description' => 'Sen tắm và vòi nước'],
            ['name' => 'Bồn Tắm', 'slug' => 'bon-tam', 'type' => 'product', 'description' => 'Bồn tắm nằm và massage'],
            ['name' => 'Ngói Sóng', 'slug' => 'ngoi-song', 'type' => 'product', 'description' => 'Ngói sóng truyền thống'],
            ['name' => 'Ngói Phẳng', 'slug' => 'ngoi-phang', 'type' => 'product', 'description' => 'Ngói phẳng hiện đại'],
        ];

        foreach ($productCategories as $cat) {
            Category::create($cat);
        }
    }
}
