<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TotoProductSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy brand TOTO đã tồn tại
        $brand = Brand::where('slug', 'toto')->first();

        // Lấy category "Thiết bị vệ sinh" đã tồn tại hoặc tạo mới
        $category = Category::where('slug', 'thiet-bi-ve-sinh')->firstOrCreate(
            ['slug' => 'thiet-bi-ve-sinh'],
            ['name' => 'Thiết bị vệ sinh']
        );

        // Danh sách sản phẩm TOTO từ tdm.vn
        $products = [
            [
                'name' => 'Bồn Cầu TOTO MS885DT8 Một Khối Nắp TC600VS',
                'price' => 9620000,
                'excerpt' => 'Bồn cầu TOTO 1 khối cao cấp với chất lượng tốt nhất',
                'content' => 'Bồn cầu TOTO MS885DT8 là sản phẩm bồn cầu 1 khối được ưa chuộng trên thị trường. Nắp rửa điện tử TC600VS tự động lau vệ sinh, tiết kiệm nước, độ bền cao.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT505T#XW Âm Bàn',
                'price' => 2860000,
                'excerpt' => 'Chậu rửa mặt TOTO âm bàn sang trọng',
                'content' => 'Chậu lavabo TOTO LT505T được thiết kế âm bàn tạo điểm nhấn hiện đại cho phòng tắm. Chất liệu sứ cao cấp, dễ làm sạch.'
            ],
            [
                'name' => 'Vòi Xịt Xi Vệ Sinh TOTO TVCF201 (THX20MCRB)',
                'price' => 830000,
                'excerpt' => 'Vòi xịt xi vệ sinh TOTO chất lượng cao',
                'content' => 'Vòi xịt TOTO TVCF201 thiết kế hiện đại, vòi uốn linh hoạt, chống rỉ sét.'
            ],
            [
                'name' => 'Bồn Cầu TOTO MS889DRT8 (MS889DT8) Một Khối Nắp TC600VS',
                'price' => 11500000,
                'excerpt' => 'Bồn cầu thông minh TOTO dòng cao cấp',
                'content' => 'MS889DT8 là bồn cầu 1 khối cao cấp từ TOTO với công nghệ tiên tiến.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LW1536V#XW Âm Bàn',
                'price' => 3190000,
                'excerpt' => 'Chậu lavabo TOTO dạng hình chữ nhật',
                'content' => 'Chậu rửa mặt lavabo TOTO LW1536V ám bàn hình chữ nhật 590 x 380 mm, thiết kế thanh lịch.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT1705#XW Đặt Bàn',
                'price' => 4550000,
                'excerpt' => 'Chậu rửa mặt TOTO kiểu đặt bàn',
                'content' => 'Chậu rửa mặt lavabo TOTO LT1705 đặt trên bàn đá 550 x 380 mm, tạo được điểm nhấn độc đáo.'
            ],
            [
                'name' => 'Bồn Cầu Thông Minh TOTO C971/TCF9433A GG',
                'price' => 49880000,
                'excerpt' => 'Bồn cầu thông minh TOTO dòng Neorest',
                'content' => 'Bồn cầu thông minh TOTO C971/TCF9433A với nắp rửa điện tử Washlet cao cấp, tự động làm sạch, sấy khô hơi ấm.'
            ],
            [
                'name' => 'Phểu Thoát Sàn TOTO TVBA407',
                'price' => 1130000,
                'excerpt' => 'Phểu thoát sàn TOTO chống hôi',
                'content' => 'Ga phểu thoát sàn Toto TVBA407 chống hôi ống thoát phi 60mm, thiết kế chuyên nghiệp.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT533R#XW Bán Âm Bàn',
                'price' => 2080000,
                'excerpt' => 'Chậu lavabo TOTO dạng tròn',
                'content' => 'Chậu rửa mặt lavabo TOTO LT533R bán âm bàn đá tròn 430 mm, về sạch, dễ vệ sinh.'
            ],
            [
                'name' => 'Bồn Cầu TOTO MS857DT10 1 Khối Nắp TC395VS',
                'price' => 6970000,
                'excerpt' => 'Bồn cầu 1 khối TOTO với nắp êm',
                'content' => 'Bồn cầu 1 khối TOTO MS857DT10 với nắp rửa điện tử TC395VS, tự động làm sạch.'
            ],
            [
                'name' => 'Ống Xả Nước Co Chữ P TOTO TVLF401',
                'price' => 550000,
                'excerpt' => 'Ống xả nước chữ P TOTO',
                'content' => 'Ống thải xả nước lavabo co chữ P TOTO TVLF401, chất lượng cao, bền lâu.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LHT300CR Treo Tường Chân Ngắn',
                'price' => 1520000,
                'excerpt' => 'Chậu lavabo TOTO treo tường',
                'content' => 'Chậu Lavabo TOTO LHT300CR treo tường chân ngắn, tiết kiệm không gian.'
            ],
            [
                'name' => 'Chậu Rửa Lavabo TOTO LT710CSR#XW Đặt Bàn',
                'price' => 2610000,
                'excerpt' => 'Chậu rửa TOTO kiểu đặt bàn',
                'content' => 'Chậu rửa lavabo TOTO LT710CSR đặt bàn có desinger tươi mới.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LHT240CS Treo Tường Chân Ngắn',
                'price' => 1860000,
                'excerpt' => 'Chậu lavabo TOTO treo tường compact',
                'content' => 'Bộ chậu rửa mặt lavabo TOTO LHT240CS treo tường chân ngắn, phù hợp với không gian nhỏ.'
            ],
            [
                'name' => 'Vòi Lavabo TOTO TLS04301V Gật Gù Nóng Lạnh',
                'price' => 2060000,
                'excerpt' => 'Vòi lavabo TOTO nóng lạnh gật gù',
                'content' => 'Vòi chậu rửa mặt lavabo TOTO TLS04301V nóng lạnh với chuyển động gật gù tiện dụng.'
            ],
            [
                'name' => 'Vòi Lavabo TOTO TLG04301V Nóng Lạnh',
                'price' => 3150000,
                'excerpt' => 'Vòi lavabo TOTO nóng lạnh tech mới',
                'content' => 'Vòi Lavabo TOTO TLG04301V nóng lạnh với thiết kế thẳng hiện đại.'
            ],
            [
                'name' => 'Bồn Cầu TOTO MS887RT8 (MS887T8) Một Khối Nắp TC600VS',
                'price' => 11500000,
                'excerpt' => 'Bồn cầu 1 khối TOTO dòng cao cấp',
                'content' => 'Bồn cầu TOTO MS887T8 một khối với nắp TC600VS, chất lượng bền bỉ.'
            ],
            [
                'name' => 'Bồn Cầu 2 Khối TOTO CS326DT10 Nắp Êm TC395VS',
                'price' => 4000000,
                'excerpt' => 'Bồn cầu 2 khối TOTO với nắp êm',
                'content' => 'Bồn cầu 2 khối TOTO CS326DT10 nắp êm TC395VS, kinh tế hiệu quả.'
            ],
            [
                'name' => 'Nắp Êm Bồn Cầu TOTO TC393VS (T2) C884 C864 C688 C914 MS885 MS889 MS887',
                'price' => 1280000,
                'excerpt' => 'Nắp rửa điện tử TOTO dành cho nhiều model',
                'content' => 'Nắp nhựa bồn cầu TOTO TC393VS tương thích với nhiều model bồn cầu TOTO.'
            ],
            [
                'name' => 'Chậu Rửa Lavabo TOTO LT5715#XW Đặt Bàn',
                'price' => 3410000,
                'excerpt' => 'Chậu rửa TOTO đặt bàn từ 500x380mm',
                'content' => 'Chậu rửa mặt lavabo TOTO LT5715 đặt bàn đá 500 x 380 mm, hiện đại sang trọng.'
            ],
            [
                'name' => 'Bồn Cầu TOTO MS885DT2 Một Khối Nắp TC393VS',
                'price' => 9620000,
                'excerpt' => 'Bồn cầu TOTO 1 khối với nắp TC393VS',
                'content' => 'Bồn cầu TOTO MS885DT2 một khối dengan nắp rửa TC393VS chất lượng cao.'
            ],
            [
                'name' => 'Vòi Lavabo TOTO TVLM102NSR Nóng Lạnh',
                'price' => 1780000,
                'excerpt' => 'Vòi lavabo TOTO nóng lạnh tiện nghi',
                'content' => 'Vòi chậu rửa mặt lavabo TOTO TVLM102NSR nóng lạnh, thiết kế sang trọng.'
            ],
            [
                'name' => 'Bồn Cầu TOTO MS636DT8 1 Khối Nắp TC600VS',
                'price' => 20610000,
                'excerpt' => 'Bồn cầu TOTO dòng cao cấp MS636',
                'price' => 20610000,
                'content' => 'Bồn cầu TOTO MS636DT8 một khối nắp TC600VS, sản phẩm cao cấp từ TOTO.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT765#XW Âm Bàn',
                'price' => 2440000,
                'excerpt' => 'Chậu lavabo TOTO compact âm bàn',
                'content' => 'Chậu Lavabo TOTO LT765 âm bàn, thiết kế tinh tế phù hợp với nhiều phòng tắm.'
            ],
            [
                'name' => 'Bồn Cầu Thông Minh TOTO CS988VT/TCF9575Z NEOREST DH',
                'price' => 66900000,
                'excerpt' => 'Bồn cầu thông minh TOTO Neorest DH',
                'content' => 'Bồn cầu thông minh TOTO CS988VT/TCF9575Z Neorest DH điện tử tự động với công nghệ tới tân.'
            ],
            [
                'name' => 'Vòi Xịt Toilet TOTO THX20NBPIV',
                'price' => 640000,
                'excerpt' => 'Vòi xịt toilet TOTO THX20NBPIV',
                'content' => 'Vòi xịt Toilet TOTO THX20NBPIV, thiết kế chuyên dụng cho phòng vệ sinh.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LW1535V#XW Âm Bàn',
                'price' => 2830000,
                'excerpt' => 'Chậu lavabo TOTO dạng chữ nhật',
                'content' => 'Chậu Lavabo TOTO LW1535V LW1535V/TL516GV âm bàn, tạo không gian phòng tắm sang trọng.'
            ],
            [
                'name' => 'Bồn Cầu TOTO MS855DT8 Một Khối Nắp TC600VS',
                'price' => 7610000,
                'excerpt' => 'Bồn cầu TOTO 1 khối dòng MS855',
                'content' => 'Bồn cầu TOTO MS855DT8 một khối với nắp TC600VS, chất lượng bề mặt sáng bóng.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT1706#XW Đặt Bàn',
                'price' => 4730000,
                'excerpt' => 'Chậu lavabo TOTO kiểu đặt bàn L1706',
                'content' => 'Chậu Lavabo TOTO LT1706 Đặt Bàn, thiết kế thanh lịch cho phòng tắm hiện đại.'
            ],
            [
                'name' => 'Vòi Sen Tắm TOTO TVSM103NSS Nóng Lạnh',
                'price' => 2540000,
                'excerpt' => 'Vòi sen tắm TOTO nóng lạnh',
                'content' => 'Vòi Sen Tắm TOTO TVSM103NSS Nóng Lạnh, thiết kế kiểu cố định hoặc di động tùy chọn.'
            ],
            [
                'name' => 'T Cầu TOTO HTHX58 Chia 2 Đường Nước',
                'price' => 330000,
                'excerpt' => 'T cầu TOTO chia đường nước',
                'content' => 'T Cầu TOTO HTHX58 chia 2 đường nước, phễu kiếm chất lượng cao.'
            ],
            [
                'name' => 'Bộ Thoát và Ống Xả Nước Chữ P TOTO TVLF405 (TX709AV6)',
                'price' => 950000,
                'excerpt' => 'Bộ thoát và ống xả TOTO',
                'content' => 'Bộ Thoát và Ống Xả Nước Chữ P TOTO TVLF405 tương thích với lavabo TOTO.'
            ],
            [
                'name' => 'Vòi Chậu Rửa TOTO TVLC101NSR Lạnh',
                'price' => 1280000,
                'excerpt' => 'Vòi chậu rửa TOTO nước lạnh',
                'content' => 'Vòi Chậu Rửa TOTO TVLC101NSR Lạnh, thiết kế đơn giản hiệu quả.'
            ],
            [
                'name' => 'Bồn Cầu TOTO CS769DRT8 (CS769DT8) Hai Khối Nắp TC600VS',
                'price' => 6980000,
                'excerpt' => 'Bồn cầu 2 khối TOTO với nắp TC600',
                'content' => 'Bồn cầu TOTO CS769DT8 hai khối nắp TC600VS, thiết kế chắc chắn thoải mái.'
            ],
            [
                'name' => 'Phểu Thoát Sàn TOTO TVBA413',
                'price' => 1280000,
                'excerpt' => 'Phểu thoát sàn TOTO model 413',
                'content' => 'Phểu Thoát Sàn TOTO TVBA413, chất lượng chống hôi hiệu quả.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT523S#XW Đặt Bàn Hình Tròn',
                'price' => 2260000,
                'excerpt' => 'Chậu lavabo TOTO tròn đặt bàn',
                'content' => 'Chậu Lavabo TOTO LT523S đặt bàn hình tròn, thiết kế thẩm mỹ cao.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT546#XW Âm Bàn Oval',
                'price' => 2020000,
                'excerpt' => 'Chậu lavabo TOTO hình oval âm bàn',
                'content' => 'Chậu Lavabo TOTO LT546 âm bàn oval, tạo điểm nhấn cho thiết kế nội thất.'
            ],
            [
                'name' => 'Vòi Sen Cây TOTO TVSM104NSR/DM907CS Nóng Lạnh',
                'price' => 8850000,
                'excerpt' => 'Vòi sen cây TOTO cao cấp',
                'content' => 'Vòi Sen Cây TOTO TVSM104NSR nóng lạnh, thiết kế cao cấp sang trọng.'
            ],
            [
                'name' => 'Chậu Rửa Lavabo TOTO LT5716#XW Đặt Bàn',
                'price' => 3670000,
                'excerpt' => 'Chậu rửa TOTO model LT5716',
                'content' => 'Chậu Rửa Lavabo TOTO LT5716 Đặt Bàn, dễ lắp dễ vệ sinh.'
            ],
            [
                'name' => 'Nắp Êm Bồn Cầu TOTO TC385VS (T3 CS300 CS320 CS325 CS735 CS945 CS818)',
                'price' => 710000,
                'excerpt' => 'Nắp rửa TOTO TC385VS tương thích nhiều model',
                'content' => 'Nắp bồn cầu TOTO TC385VS rơi êm, tương thích với nhiều model bồn cầu.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT710CTR#XW (LT710CTRM) Đặt Bàn',
                'price' => 2520000,
                'excerpt' => 'Chậu lavabo TOTO đặt bàn chữ nhật',
                'content' => 'Chậu rửa mặt lavabo TOTO LT710CTR đặt bàn đá chữ nhật, dễ làm sạch bề mặt.'
            ],
            [
                'name' => 'Bồn Cầu TOTO MS885DT3 Một Khối Nắp TC385VS',
                'price' => 9178000,
                'excerpt' => 'Bồn cầu TOTO 1 khối kết hợp đôi',
                'content' => 'Bồn Cầu TOTO MS885DT3 một khối nắp TC385VS, phù hợp với nhiều không gian.'
            ],
            [
                'name' => 'Bồn Cầu 2 Khối TOTO CS302DT10#W Nắp Êm TC395VS',
                'price' => 3150000,
                'excerpt' => 'Bồn cầu 2 khối TOTO CS302',
                'content' => 'Bồn Cầu 2 Khối TOTO CS302DT10 nắp êm TC395VS, tiết kiệm giá trị cao.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT548#XW Âm Bàn',
                'price' => 2330000,
                'excerpt' => 'Chậu lavabo TOTO âm bàn oval',
                'content' => 'Chậu rửa mặt lavabo TOTO LT548 âm bàn đá oval 600x420 mm, đẹp mắt.'
            ],
            [
                'name' => 'Chậu Lavabo TOTO LT700CTR#XW Đặt Bàn',
                'price' => 2610000,
                'excerpt' => 'Chậu lavabo TOTO LT700 đặt bàn',
                'content' => 'Chậu Lavabo TOTO LT700CTR Đặt Bàn, thiết kế khía cạnh độc đáo.'
            ],
            [
                'name' => 'Chậu Rửa Lavabo TOTO LT952#XW Đặt Bàn',
                'price' => 3060000,
                'excerpt' => 'Chậu rửa TOTO LT952 đặt bàn',
                'content' => 'Chậu Rửa Lavabo TOTO LT952 Đặt Bàn, thiết kế hiện đại tinh tế.'
            ],
            [
                'name' => 'Nắp Rửa Điện Tử Washlet TOTO TCF23410AAA (W16) C2',
                'price' => 12894000,
                'excerpt' => 'Nắp rửa điện tử TOTO Washlet',
                'content' => 'Nắp rửa điện tử Toto TCF23410AAA tự rửa thông minh 220v, công nghệ vệ sinh cao cấp.'
            ],
            [
                'name' => 'Bồn Cầu Hai Khối TOTO CS325DRT3 (C320R, S325D) Nắp TC385VS',
                'price' => 3800000,
                'excerpt' => 'Bồn cầu 2 khối TOTO CS325',
                'content' => 'Bồn cầu hai khối TOTO CS325DRT3, xí bệt bàn cầu vệ sinh chất lượng cao.'
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                [
                    'slug' => str()->slug($product['name']),
                    'short_description' => $product['excerpt'] ?? '',
                    'description' => $product['content'] ?? '',
                    'price' => $product['price'] ?? 0,
                    'unit' => 'cái',
                    'brand_id' => $brand->id,
                    'category_id' => $category->id,
                    'is_featured' => false,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('✅ Đã import ' . count($products) . ' sản phẩm TOTO vào database!');
    }
}
