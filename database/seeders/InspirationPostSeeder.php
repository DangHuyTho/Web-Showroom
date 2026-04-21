<?php

namespace Database\Seeders;

use App\Models\InspirationPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InspirationPostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Biệt Thự Hiện Đại với Gạch Royal 80x80',
                'slug' => 'biet-thu-hien-dai-voi-gach-royal-80x80',
                'post_type' => 'project',
                'excerpt' => 'Công trình biệt thự hiện đại sử dụng gạch Royal Marble 80x80 cho không gian sang trọng',
                'featured_image' => 'biet-thu-hien-dai-voi-gach-royal.png',
                'content' => '<h2>Biệt Thự Hiện Đại với Gạch Royal 80x80</h2>

<p>Công trình biệt thự tại quận 2 với diện tích 500m² sử dụng gạch Royal Marble 80x80 cho phòng khách và phòng ăn. Thiết kế tối giản nhưng sang trọng, tạo không gian rộng rãi và hiện đại.</p>

<h3>Thông Tin Chi Tiết Công Trình</h3>

<ul>
<li><strong>Diện tích:</strong> 500m²</li>
<li><strong>Vị trí:</strong> Quận 2, TP.HCM</li>
<li><strong>Thời gian thực hiện:</strong> 3 tháng</li>
<li><strong>Chủ đầu tư:</strong> Anh Nguyễn Văn A</li>
</ul>

<h3>Đặc Điểm Thiết Kế</h3>

<p>Công trình sử dụng gạch Royal Marble kích thước 80x80cm với texture bề mặt polished cao cấp. Màu sắc trắng kem kết hợp với chân sàn gỗ tự nhiên tạo nên sự ấm áp và hiện đại cho toàn bộ không gian.</p>

<p>Phòng khách được thiết kế với trần cao 4m, tạo cảm giác rộng rãi. Sàn gạch Royal 80x80 được lát nối với phòng ăn liền kề, tạo sự thống nhất và chảy chảy không gian.</p>

<h3>Kết Quả Thực Hiện</h3>

<p>Sau 3 tháng hoàn thành, công trình đã nhận được sự hài lòng cao từ chủ đầu tư. Không gian sống trở nên sang trọng, hiện đại và vô cùng thoải mái với gạch Royal Marble 80x80.</p>',
                'project_location' => 'Quận 2, TP.HCM',
                'project_date' => now()->subMonths(3),
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Phòng Tắm Sang Trọng với Thiết Bị Toto',
                'slug' => 'phong-tam-sang-trong-voi-thiet-bi-toto-neorest',
                'post_type' => 'project',
                'excerpt' => 'Thiết kế phòng tắm cao cấp với bồn cầu thông minh Toto Neorest AH',
                'featured_image' => 'phong-tam-sang-trong-voi-thiet-bi-toto.png',
                'content' => '<h2>Phòng Tắm Sang Trọng với Thiết Bị Toto</h2>

<p>Phòng tắm được thiết kế với bồn cầu thông minh Toto Neorest AH, chậu rửa lavabo Toto và sen tắm cao cấp. Không gian sang trọng, hiện đại với công nghệ Nhật Bản.</p>

<h3>Các Sản Phẩm Toto Sử Dụng</h3>

<ul>
<li><strong>Bồn Cầu:</strong> Toto Neorest AH với công nghệ tự động rửa, sấy</li>
<li><strong>Chậu Rửa Lavabo:</strong> Toto Nexus với thiết kế tinh tế</li>
<li><strong>Vòi Nước:</strong> Toto tiêu chuẩn đứng cao cấp</li>
<li><strong>Sen Tắm:</strong> Toto Rain Shower với công nghệ tiết kiệm nước</li>
</ul>

<h3>Đặc Điểm Nổi Bật</h3>

<p>Phòng tắm sử dụng gạch Viglacera 30x60cm với màu trắng tinh khôi, kết hợp với các thiết bị vệ sinh Toto cao cấp. Hệ thống thông gió hiện đại đảm bảo không gian luôn khô ráo và sạch sẽ.</p>

<p>Bồn cầu Toto Neorest AH với chức năng tự động rửa, sấy, khử mùi và tự động mở/đóng nắp tạo nên sự tiện nghi tối đa cho người dùng.</p>',
                'project_location' => 'Quận 7, TP.HCM',
                'project_date' => now()->subMonths(2),
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'Cách Chọn Màu Ngói Fuji Hợp Mệnh',
                'slug' => 'cach-chon-mau-ngoi-fuji-hop-menh-phong-thuy',
                'post_type' => 'blog',
                'excerpt' => 'Hướng dẫn chọn màu ngói Fuji phù hợp với phong thủy và mệnh của gia chủ',
                'featured_image' => 'phong-thuy-ngoi-1024x724.png',
                'content' => '<h2>Hướng Dẫn Chọn Ngói Màu Hợp Tuổi</h2>

<p>Chọn ngói màu hợp tuổi không chỉ giúp tăng tính thẩm mỹ cho công trình mà còn phù hợp với phong thủy để mang đến những điều tốt lành. "Có thờ có thiêng, có kiêng có lành" là quan niệm được truyền lại từ rất lâu đời mà ông bà ta vẫn luôn mong sự bình an, thịnh vượng cho gia đình, con cháu.</p>

<h3>Nguyên Tắc Lựa Chọn Ngói Màu Hợp Tuổi Theo Phong Thủy</h3>

<p>Để lựa chọn ngói màu phù hợp theo phong thủy, bạn cần phối màu theo mệnh gia chủ, theo hướng nhà hoặc theo nguyên lý Ngũ hành Tương Sinh, Tương Khắc.</p>

<h4>Ngũ Hành và Màu Sắc Đặc Trưng:</h4>

<ul>
<li><strong>Kim:</strong> Màu sáng và những sắc ánh kim, màu trắng</li>
<li><strong>Mộc:</strong> Màu xanh, màu lục</li>
<li><strong>Thủy:</strong> Xanh biển sâm, màu đen</li>
<li><strong>Hỏa:</strong> Màu đỏ, màu tím</li>
<li><strong>Thổ:</strong> Màu nâu, vàng, cam</li>
</ul>

<h3>Chi Tiết Chọn Ngói Màu Hợp Tuổi Cho Từng Bản Mệnh</h3>

<h4>Hành Kim (Mệnh Kim)</h4>
<p>Gia chủ mệnh Kim nên sử dụng tông màu sáng và những sắc ánh kim vì màu trắng là màu sở hữu của bản mệnh. Nên kết hợp với tông màu nâu và vàng xẫm (Hoàng Thổ sinh Kim) – những màu đem lại may mắn cho gia chủ.</p>
<p><strong>Lưu ý:</strong> Tránh những màu sắc kiêng kỵ như màu hồng, màu đỏ, màu tím (Hồng Hỏa khắc Kim).</p>

<h4>Hành Mộc (Mệnh Mộc)</h4>
<p>Gia chủ mệnh Mộc nên sử dụng tông màu xanh – màu sở hữu của bản mệnh. Xanh có nhiều sắc độ, từ cốm nhạt đến xanh lá đậm tạo cảm giác mát mẻ. Nên kết hợp với tông màu đen, màu xanh biển sâm (nước đen sinh Mộc).</p>
<p><strong>Lưu ý:</strong> Tránh dùng những tông màu trắng và sắc ánh kim (Trắng bạch kim khắc Mộc).</p>

<h4>Hành Thủy (Mệnh Thủy)</h4>
<p>Gia chủ mệnh Thủy nên sử dụng tông màu đen, màu xanh biển sâm. Ngoài ra kết hợp với các tông màu trắng và những sắc ánh kim (Trắng bạch kim sinh Thủy).</p>
<p><strong>Lưu ý:</strong> Tránh dùng những màu sắc kiêng kỵ như màu vàng đất, màu nâu (Hoàng thổ khắc Thủy).</p>

<h4>Hành Hỏa (Mệnh Hỏa)</h4>
<p>Gia chủ mệnh Hỏa nên sử dụng tông màu đỏ, hồng, tím. Ngoài ra kết hợp với các màu xanh (Thanh mộc sinh Hỏa) – màu đại diện cho hành Mộc, rất tốt cho người hành Hỏa.</p>
<p><strong>Lưu ý:</strong> Tránh dùng những tông màu đen, màu xanh biển sâm (nước đen khắc Hỏa).</p>

<h4>Hành Thổ (Mệnh Thổ)</h4>
<p>Chủ nhà nên sử dụng tông màu hồng, màu đỏ, màu tím (Hồng hoả sinh Thổ) – màu đại diện cho hành Hỏa, rất tốt cho người hành Thổ. Màu vàng, nâu đất sự mạnh mẽ và hài hoà của yếu tố Thổ trong nhà sẽ giúp tạo ra sự chắc chắn, giàu sinh lực.</p>
<p><strong>Lưu ý:</strong> Màu xanh là màu sắc kiêng kỵ mà gia chủ nên tránh dùng (Thanh mộc khắc Thổ).</p>

<h3>Tầm Quan Trọng Của Màu Sắc</h3>

<p>Lựa chọn màu ngói cho mái nhà không chỉ góp phần làm đẹp thêm cho ngôi nhà mà còn là sự thể hiện sở thích và mong muốn của chủ nhà. Theo các nghiên cứu khoa học từ lâu đã khẳng định màu sắc có sự tác động không nhỏ lên trạng thái tâm lý và sức khỏe của người sử dụng.</p>

<p>Chọn màu ngói trong giai đoạn xây dựng hoàn thiện ngôi nhà cũng quan trọng như khâu chọn màu cho nội ngoại thất. Hiện nay dòng ngói màu Fuji đã trở nên rất thông dụng có nhiều mẫu màu đa dạng hơn nhằm đáp ứng nhu cầu, sở thích của gia chủ.</p>

<p>Chúc các bạn chọn ngói màu Fuji hợp tuổi với màu sắc phù hợp cho ngôi nhà của mình nhé!</p>',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'Nhà Phố Viglacera với Thiết Kế Tối Giản',
                'slug' => 'nha-pho-viglacera-thiet-ke-toi-gian',
                'post_type' => 'project',
                'excerpt' => 'Thiết kế nhà phố hiện đại sử dụng gạch Viglacera 30x60cm với tông màu xám nhạt',
                'featured_image' => 'nha-pho-viglacera-voi-thiet-ke-toi-gian.png',
                'content' => '<h2>Nhà Phố Viglacera với Thiết Kế Tối Giản</h2>

<p>Công trình nhà phố kết hợp gạch Viglacera kích thước 30x60cm với màu xám nhạt, tạo nên không gian hiện đại, tối giản nhưng đầy tinh tế.</p>

<h3>Thông Tin Công Trình</h3>

<ul>
<li><strong>Diện tích xây dựng:</strong> 120m²</li>
<li><strong>Số tầng:</strong> 4 tầng</li>
<li><strong>Vị trí:</strong> Thủ Đức, TP.HCM</li>
<li><strong>Thời gian hoàn thành:</strong> 4 tháng</li>
</ul>

<h3>Vật Liệu Sử Dụng</h3>

<ul>
<li>Gạch Viglacera 30x60cm màu xám - cho sàn</li>
<li>Gạch Viglacera 30x60cm màu trắng - cho tường</li>
<li>Sơn nội thất cao cấp</li>
<li>Kính cường lực cho cửa sổ</li>
</ul>

<h3>Đặc Điểm Thiết Kế</h3>

<p>Nhà phố được thiết kế với phong cách tối giản nhưng không kém phần sang trọng. Sử dụng gạch Viglacera 30x60 xám nhạt cho sàn phòng khách, phòng bếp tạo sự thống nhất và hiện đại.</p>

<p>Không gian mở giữa phòng khách và phòng bếp tạo cảm giác rộng rãi, thông thoáng. Cầu thang được thiết kế với bậc bê tông bao phủ gạch Viglacera, vừa an toàn vừa thẩm mỹ.</p>',
                'project_location' => 'Thủ Đức, TP.HCM',
                'project_date' => now()->subMonths(1),
                'is_featured' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($posts as $post) {
            InspirationPost::create($post);
        }
    }
}
