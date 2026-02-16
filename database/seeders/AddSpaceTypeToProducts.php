<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddSpaceTypeToProducts extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy tất cả sản phẩm
        $products = DB::table('products')->get();

        foreach ($products as $product) {
            $spaceType = $this->determineSpaceType($product);
            
            DB::table('products')
                ->where('id', $product->id)
                ->update(['space_type' => $spaceType]);
        }

        $this->command->info('Space types assigned to all products.');
    }

    private function determineSpaceType($product): string
    {
        // TOTO: sử dụng cho phòng tắm chủ yếu
        if (strtolower($product->brand_id) == 3 || strpos(strtolower($product->name), 'toto') !== false) {
            return 'bathroom';
        }

        // Ngói Fuji: sử dụng cho ngoại thất
        if (strtolower($product->brand_id) == 4 || strpos(strtolower($product->name), 'fuji') !== false) {
            return 'outdoor';
        }

        // Gạch lát (Royal, Viglacera): phân loại dựa trên size và tên
        $productName = strtolower($product->name);
        $productSize = strtolower($product->size ?? '');

        // Gạch lát nhà tắm thường nhỏ (20x20, 30x30, 30x60)
        if (in_array($productSize, ['20x20', '30x30', '30x60'])) {
            return 'bathroom';
        }

        // Gạch sân vườn/ngoài trời thường lớn (60x60, 80x80, 120x120)
        if (in_array($productSize, ['60x60', '80x80', '120x120'])) {
            return 'outdoor';
        }

        // Gạch phòng khách/phòng ngủ thường 50x50
        if (in_array($productSize, ['50x50', '15x80'])) {
            return rand(0, 1) ? 'living_room' : 'bedroom';
        }

        // Mặc định: phòng khách hoặc phòng ngủ
        return rand(0, 1) ? 'living_room' : 'bedroom';
    }
}
