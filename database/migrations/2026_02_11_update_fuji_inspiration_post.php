<?php

use App\Models\InspirationPost;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $content = '<h2>Hướng Dẫn Chọn Ngói Màu Hợp Tuổi</h2>

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

<p>Chúc các bạn chọn ngói màu Fuji hợp tuổi với màu sắc phù hợp cho ngôi nhà của mình nhé!</p>';

        // Update or create the blog post
        InspirationPost::updateOrCreate(
            ['slug' => 'cach-chon-mau-ngoi-fuji-hop-menh'],
            [
                'title' => 'Cách Chọn Màu Ngói Fuji Hợp Mệnh',
                'post_type' => 'blog',
                'excerpt' => 'Hướng dẫn chọn màu ngói Fuji phù hợp với phong thủy và mệnh của gia chủ',
                'featured_image' => 'phong-thuy-ngoi-1024x724.png',
                'content' => $content,
                'is_featured' => true,
                'is_active' => true,
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Optional: Delete the post if rolling back
        InspirationPost::where('slug', 'cach-chon-mau-ngoi-fuji-hop-menh')->delete();
    }
};
