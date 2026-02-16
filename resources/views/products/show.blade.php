@extends('layouts.app')

@section('title', $product->name)

@section('content')
<section class="section">
    <div class="container" style="max-width: 1200px;">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <!-- Product Images -->
            <div>
                <div class="card-image" style="height: 500px; margin-bottom: var(--spacing-sm); background-size: cover; background-position: center; overflow: hidden;">
                    @php
                        $primaryImage = $product->images()->where('is_primary', true)->first() ?? $product->images->first();
                    @endphp
                    @if($primaryImage)
                        <img src="{{ asset($primaryImage->image_path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 500;">
                            {{ $product->name }}
                        </div>
                    @endif
                </div>
                @if($product->images->count() > 1)
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--spacing-xs);">
                    @foreach($product->images->take(4) as $image)
                    <div class="card-image" style="height: 100px; background-size: cover; background-position: center; overflow: hidden; cursor: pointer;" onclick="this.parentElement.parentElement.previousElementSibling.innerHTML='<img src=&quot;' + '{{ asset($image->image_path) }}' + '&quot; alt=&quot;{{ $product->name }}&quot; style=&quot;width: 100%; height: 100%; object-fit: cover; display: block;&quot;>'">
                        <img src="{{ asset($image->image_path) }}" alt="{{ $product->name }} - {{ $loop->iteration }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <h1 style="font-size: 2.5rem; margin-bottom: var(--spacing-sm);">{{ $product->name }}</h1>
                <p style="color: var(--color-text-light); margin-bottom: var(--spacing-md);">
                    Thương hiệu: <strong>{{ $product->brand->name ?? 'N/A' }}</strong>
                </p>
                
                @if($product->price)
                <div style="margin-bottom: var(--spacing-md);">
                    <p style="font-size: 2rem; font-weight: 700; color: var(--color-secondary);">
                        {{ number_format($product->price, 0, ',', '.') }} đ/{{ $product->unit }}
                    </p>
                </div>
                @endif

                @if($product->short_description)
                <div style="margin-bottom: var(--spacing-md);">
                    <p style="font-size: 1.1rem; line-height: 1.8;">{{ $product->short_description }}</p>
                </div>
                @endif

                <!-- Technical Specifications -->
                <div style="border-top: 1px solid var(--color-border); padding-top: var(--spacing-md); margin-bottom: var(--spacing-md);">
                    <h2 style="font-size: 1.5rem; margin-bottom: var(--spacing-sm);">Thông Số Kỹ Thuật</h2>
                    <div style="display: grid; gap: var(--spacing-xs);">
                        @if($product->size)
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Kích thước:</span>
                            <strong>{{ $product->size }}</strong>
                        </div>
                        @endif
                        @if($product->material)
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Chất liệu:</span>
                            <strong>{{ $product->material }}</strong>
                        </div>
                        @endif
                        @if($product->surface_type)
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Bề mặt:</span>
                            <strong>{{ $product->surface_type }}</strong>
                        </div>
                        @endif
                        @if($product->product_type)
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Loại ngói:</span>
                            <strong>
                                @if($product->product_type == 'flat')
                                    Ngói phẳng
                                @elseif($product->product_type == 'wave')
                                    Ngói sóng
                                @elseif($product->product_type == 'accessories')
                                    Phụ kiện
                                @else
                                    {{ $product->product_type }}
                                @endif
                            </strong>
                        </div>
                        @endif
                        @if($product->product_category)
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Loại sản phẩm:</span>
                            <strong>{{ $product->product_category }}</strong>
                        </div>
                        @endif
                        @if($product->water_absorption)
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Độ hút nước:</span>
                            <strong>{{ $product->water_absorption }}</strong>
                        </div>
                        @endif
                        @if($product->hardness)
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Độ cứng:</span>
                            <strong>{{ $product->hardness }}</strong>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Features -->
                @if($product->features && is_array($product->features) && count($product->features) > 0)
                <div style="margin-bottom: var(--spacing-md);">
                    <h3 style="font-size: 1.25rem; margin-bottom: var(--spacing-sm);">Tính Năng Nổi Bật</h3>
                    <ul style="list-style: none; padding-left: 0;">
                        @foreach($product->features as $feature)
                        <li style="padding: var(--spacing-xs) 0;">✓ {{ $feature }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- CTA Button -->
                <div style="margin-top: var(--spacing-md);">
                    <a href="#quote" class="btn" style="display: inline-block; padding: 0.75rem 2rem; background: var(--color-primary); color: white; text-decoration: none; border-radius: 4px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.background='#0d6bb5'" onmouseout="this.style.background='var(--color-primary)'">Dự Toán Chi Phí</a>
                </div>
            </div>
        </div>

        <!-- Description -->
        @if($product->description)
        <div style="border-top: 1px solid var(--color-border); padding-top: var(--spacing-md); margin-bottom: var(--spacing-md);">
            <h2 style="font-size: 1.5rem; margin-bottom: var(--spacing-sm);">Mô Tả Chi Tiết</h2>
            <div style="line-height: 1.8; color: var(--color-text-light);">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
        @endif

        <!-- 3D View -->
        @if($product->view_3d_url)
        <div style="border-top: 1px solid var(--color-border); padding-top: var(--spacing-md); margin-bottom: var(--spacing-md);">
            <h2 style="font-size: 1.5rem; margin-bottom: var(--spacing-sm);">Phối Cảnh 3D</h2>
            <div class="card-image" style="height: 400px;">
                Hình ảnh 3D - {{ $product->name }}
            </div>
        </div>
        @endif

        <!-- Related Products -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div style="border-top: 1px solid var(--color-border); padding-top: var(--spacing-md);">
            <h2 style="font-size: 1.5rem; margin-bottom: var(--spacing-md);">Sản Phẩm Liên Quan</h2>
            <div class="grid grid-4">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->slug) }}" class="card" style="text-decoration: none; display: flex; flex-direction: column; height: 100%;">
                    <div class="card-image" style="background-size: cover; background-position: center; overflow: hidden; height: 250px;">
                        @php
                            $primaryImage = $related->images()->where('is_primary', true)->first() ?? $related->images->first();
                        @endphp
                        @if($primaryImage)
                            <img src="{{ asset($primaryImage->image_path) }}" alt="{{ $related->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                        @else
                            <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 500; text-align: center; padding: var(--spacing-sm);">
                                {{ substr($related->name, 0, 30) }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body" style="flex: 1; display: flex; flex-direction: column;">
                        <h3 class="card-title" style="font-size: 0.95rem; margin-bottom: var(--spacing-xs);">{{ substr($related->name, 0, 40) }}</h3>
                        <p class="card-text" style="color: var(--color-text-light); font-size: 0.85rem;  margin-bottom: var(--spacing-xs);">{{ $related->brand->name ?? 'N/A' }}</p>
                        @if($related->price)
                        <p style="font-weight: 600; color: var(--color-secondary); margin-top: auto;">
                            {{ number_format($related->price, 0, ',', '.') }} đ/{{ $related->unit }}
                        </p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>

<!-- Quote Form -->
<section id="quote" class="section" style="background: var(--color-accent);">
    <div class="container" style="max-width: 600px;">
        <h2 class="section-title">Dự Toán Chi Phí</h2>
        <div style="background: white; padding: var(--spacing-lg); border-radius: 8px; border-left: 4px solid var(--color-primary);">
            <div style="display: grid; gap: var(--spacing-md);">
                <!-- Product Info Section -->
                <div style="background: #f3f4f6; padding: var(--spacing-md); border-radius: 6px;">
                    <h3 style="margin-top: 0; margin-bottom: var(--spacing-sm); font-size: 1.1rem;">Thông tin sản phẩm</h3>
                    <div style="display: grid; gap: var(--spacing-xs);">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Sản phẩm:</span>
                            <strong>{{ $product->name }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Thương hiệu:</span>
                            <strong>{{ $product->brand->name ?? 'N/A' }}</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--color-text-light);">Giá:</span>
                            <strong style="color: var(--color-secondary); font-size: 1.1rem;">{{ number_format($product->price ?? 0, 0, ',', '.') }} đ/{{ $product->unit }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Quantity/Area Input -->
                @if($product->brand && $product->brand->slug === 'toto')
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Số lượng sản phẩm cần</label>
                    <input type="number" id="quantityInput" name="quantity" placeholder="Nhập số lượng..." min="1" value="1" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 4px; font-size: 1rem;" onchange="calculateEstimate()" oninput="calculateEstimate()">
                </div>
                @else
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Diện tích công trình (m²)</label>
                    <input type="number" id="quantityInput" name="area" placeholder="Nhập diện tích..." min="1" step="0.5" value="1" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 4px; font-size: 1rem;" onchange="calculateEstimate()" oninput="calculateEstimate()">
                </div>
                @endif

                <!-- Estimate Display -->
                <div style="background: #ecfdf5; padding: var(--spacing-md); border-radius: 6px; border-left: 4px solid #10b981;">
                    <h3 style="margin-top: 0; margin-bottom: var(--spacing-md); font-size: 1.2rem; color: #059669;">Tổng Chi Phí Dự Kiến</h3>
                    <div style="display: grid; gap: var(--spacing-sm);">
                        <div style="display: flex; justify-content: space-between; padding-bottom: var(--spacing-sm); border-bottom: 2px solid #d1fae5;">
                            <span style="color: #047857; font-size: 0.95rem;">Số lượng/Diện tích:</span>
                            <strong id="estimateQuantity" style="color: #047857; font-size: 0.95rem;">0</strong>
                        </div>
                        @if(!($product->brand && $product->brand->slug === 'toto'))
                        <div style="display: flex; justify-content: space-between; padding-bottom: var(--spacing-sm); border-bottom: 2px solid #d1fae5;">
                            <span style="color: #047857; font-size: 0.95rem;">Số viên gạch cần:</span>
                            <strong id="tileCount" style="color: #047857; font-size: 0.95rem;">0 viên</strong>
                        </div>
                        @endif
                        <div style="display: flex; justify-content: space-between; padding-bottom: var(--spacing-sm); border-bottom: 2px solid #d1fae5;">
                            <span style="color: #047857; font-size: 0.95rem;">Đơn giá:</span>
                            <strong id="estimatePrice" style="color: #047857; font-size: 0.95rem;">{{ number_format($product->price ?? 0, 0, ',', '.') }} đ</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: var(--spacing-sm);">
                            <span style="color: #059669; font-weight: 600; font-size: 1.1rem;">Cộng:</span>
                            <strong style="color: #059669; font-size: 1.5rem;" id="totalEstimate">0 đ</strong>
                        </div>
                    </div>
                </div>

                <!-- Note -->
                <div style="background: #fef3c7; padding: var(--spacing-md); border-radius: 6px; border-left: 4px solid #fbbf24;">
                    <p style="margin: 0; color: #92400e; font-size: 0.9rem;">
                        <strong>Lưu ý:</strong> Đây là dự toán chi phí dự kiến. Để nhận báo giá chính xác, vui lòng <a href="javascript:void(0)" style="color: #d97706; text-decoration: underline; font-weight: 600;">liên hệ với chúng tôi</a> hoặc sử dụng chức năng chat trực tuyến.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        const productPrice = {{ $product->price ?? 0 }};
        const isToto = {{ ($product->brand && $product->brand->slug === 'toto') ? 'true' : 'false' }};
        const productSize = "{{ $product->size ?? '' }}";

        // Parse product size to calculate tile count
        function getTileSizeM2() {
            if (!productSize || isToto) return null;
            
            // Parse size format: "60×90" or "60x90" to get dimensions in cm
            const match = productSize.match(/(\d+)\s*[×x]\s*(\d+)/);
            if (!match) return null;
            
            const width = parseInt(match[1]) / 100; // Convert cm to m
            const height = parseInt(match[2]) / 100;
            return width * height; // Return area in m²
        }

        const tileSizeM2 = getTileSizeM2();

        function calculateEstimate() {
            const quantityInput = document.getElementById('quantityInput');
            const quantity = parseFloat(quantityInput.value) || 1;
            
            const total = quantity * productPrice;
            document.getElementById('estimateQuantity').textContent = quantity + (isToto ? ' sản phẩm' : ' m²');
            
            // Calculate tile count for non-TOTO products
            if (!isToto && tileSizeM2 > 0) {
                const tileCount = Math.ceil(quantity / tileSizeM2);
                document.getElementById('tileCount').textContent = tileCount.toLocaleString('vi-VN') + ' viên';
            }
            
            document.getElementById('totalEstimate').textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total).replace('₫', 'đ');
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateEstimate();
        });
    </script>
</section>
@endsection
