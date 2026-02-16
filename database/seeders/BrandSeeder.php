<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Royal',
                'slug' => 'royal',
                'description' => 'Thương hiệu gạch kiến trúc cao cấp với công nghệ hiện đại và thiết kế sang trọng',
                'sort_order' => 1,
            ],
            [
                'name' => 'Viglacera',
                'slug' => 'viglacera',
                'description' => 'Gạch kiến trúc chất lượng cao với đa dạng mẫu mã và kích thước',
                'sort_order' => 2,
            ],
            [
                'name' => 'Toto',
                'slug' => 'toto',
                'description' => 'Thiết bị vệ sinh cao cấp với công nghệ Nhật Bản, đẳng cấp quốc tế',
                'sort_order' => 3,
            ],
            [
                'name' => 'Fuji',
                'slug' => 'fuji',
                'description' => 'Ngói màu cao cấp với bảng màu phong phú và độ bền vượt trội',
                'sort_order' => 4,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
