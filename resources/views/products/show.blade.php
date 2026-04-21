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

                <!-- Purchase Buttons -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-sm); margin-top: var(--spacing-md); margin-bottom: var(--spacing-sm);">
                    <button onclick="addToCart()" style="padding: 0.75rem 1.5rem; background: var(--color-secondary); color: var(--color-primary); border: none; border-radius: 4px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        🛒 Thêm vào giỏ
                    </button>
                    <button onclick="purchaseNow()" style="padding: 0.75rem 1.5rem; background: var(--color-primary); color: white; border: none; border-radius: 4px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        💳 Mua ngay
                    </button>
                </div>
                
                <!-- Quote Button -->
                <a href="#quote" style="display: block; text-align: center; padding: 0.75rem 1.5rem; background: #f3f4f6; color: var(--color-primary); border: 2px solid #d1d5db; border-radius: 4px; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                    📊 Dự Toán Chi Phí
                </a>
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
                
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">
                        Hao phí gạch (%)
                        <span style="font-size: 0.85rem; color: #6b7280; font-weight: 400;">(bao gồm cắt, hỏng, lẻ)</span>
                    </label>
                    <input type="number" id="wasteInput" name="waste" placeholder="Nhập hao phí..." min="0" max="100" step="0.5" value="7" style="width: 100%; padding: 0.75rem; border: 1px solid var(--color-border); border-radius: 4px; font-size: 1rem;" onchange="calculateEstimate()" oninput="calculateEstimate()">
                </div>
                @endif

                <!-- Estimate Display -->
                <div style="background: #ecfdf5; padding: var(--spacing-md); border-radius: 6px; border-left: 4px solid #10b981;">
                    <h3 style="margin-top: 0; margin-bottom: var(--spacing-md); font-size: 1.2rem; color: #059669;">Tổng Chi Phí Dự Kiến</h3>
                    <div style="display: grid; gap: var(--spacing-sm); font-size: 0.95rem;">
                        <!-- Basic Info -->
                        <div style="display: flex; justify-content: space-between; padding-bottom: var(--spacing-sm); border-bottom: 2px solid #d1fae5;">
                            <span style="color: #047857;">Diện tích/Số lượng:</span>
                            <strong id="estimateQuantity" style="color: #047857;">0</strong>
                        </div>
                        
                        @if(!($product->brand && $product->brand->slug === 'toto'))
                        <!-- Tile Details -->
                        <div style="background: #f0fdf4; padding: var(--spacing-sm); border-radius: 4px; border-left: 3px solid #10b981; margin-bottom: var(--spacing-sm);">
                            <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-xs);">
                                <span style="color: #047857; font-size: 0.9rem;">📏 Kích thước 1 viên:</span>
                                <strong id="tileDimension" style="color: #047857; font-size: 0.9rem;">-</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-xs);">
                                <span style="color: #047857; font-size: 0.9rem;">📊 Số viên cơ bản:</span>
                                <strong id="baseTileCount" style="color: #047857; font-size: 0.9rem;">0 viên</strong>
                            </div>
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: #047857; font-size: 0.9rem;">➕ Hao phí:</span>
                                <strong id="wastePercentage" style="color: #047857; font-size: 0.9rem;">0%</strong>
                            </div>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; padding-bottom: var(--spacing-sm); border-bottom: 2px solid #d1fae5; font-weight: 600;">
                            <span style="color: #047857;">✓ Số viên thực tế cần:</span>
                            <strong id="tileCount" style="color: #10b981; font-size: 1.05rem;">0 viên</strong>
                        </div>
                        
                        <div style="display: flex; justify-content: space-between; padding-bottom: var(--spacing-sm); border-bottom: 2px solid #d1fae5;">
                            <span style="color: #047857; font-size: 0.9rem;">Đơn giá/ m²:</span>
                            <strong id="pricePerM2" style="color: #047857; font-size: 0.9rem;">{{ number_format($product->price ?? 0, 0, ',', '.') }} đ</strong>
                        </div>
                        @else
                        <div style="display: flex; justify-content: space-between; padding-bottom: var(--spacing-sm); border-bottom: 2px solid #d1fae5;">
                            <span style="color: #047857; font-size: 0.9rem;">Đơn giá:</span>
                            <strong id="estimatePrice" style="color: #047857; font-size: 0.9rem;">{{ number_format($product->price ?? 0, 0, ',', '.') }} đ</strong>
                        </div>
                        @endif
                        
                        <div style="display: flex; justify-content: space-between; padding-top: var(--spacing-sm); background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%); padding: var(--spacing-sm); border-radius: 4px; margin-top: var(--spacing-sm);">
                            <span style="color: #059669; font-weight: 700; font-size: 1.1rem;">💰 Tổng Cộng:</span>
                            <strong style="color: #059669; font-size: 1.4rem;" id="totalEstimate">0 đ</strong>
                        </div>
                        
                        <div style="background: #fef3c7; padding: var(--spacing-sm); border-radius: 4px; border-left: 3px solid #fbbf24; margin-top: var(--spacing-sm); color: #78350f; font-size: 0.9rem; line-height: 1.5;">
                            <p style="margin: 0; font-weight: 600;">💡 Cách tính:</p>
                            <ul style="margin: var(--spacing-xs) 0; padding-left: var(--spacing-md); list-style: none;">
                                <li id="calcMethod" style="margin: var(--spacing-xs) 0;"></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const productPrice = {{ $product->price ?? 0 }};
        const productId = {{ $product->id ?? 0 }};
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
            
            let total = 0;
            let calcMethod = '';
            
            if (isToto) {
                // TOTO: Tính theo số lượng sản phẩm
                document.getElementById('estimateQuantity').textContent = quantity + ' sản phẩm';
                total = quantity * productPrice;
                calcMethod = `${quantity.toLocaleString('vi-VN')} sản phẩm × ${(productPrice).toLocaleString('vi-VN')} đ = ${total.toLocaleString('vi-VN')} đ`;
            } else {
                // Sản phẩm khác: Tính theo diện tích → số viên → cộng
                const wastePercentage = parseFloat(document.getElementById('wasteInput').value) || 7;
                
                document.getElementById('estimateQuantity').textContent = quantity + ' m²';
                document.getElementById('wastePercentage').textContent = wastePercentage + '%';
                
                if (tileSizeM2 > 0) {
                    // Số viên cơ bản = diện tích / diện tích mỗi viên, làm tròn lên
                    const baseTileCount = Math.ceil(quantity / tileSizeM2);
                    document.getElementById('baseTileCount').textContent = baseTileCount + ' viên';
                    
                    // Số viên thực tế = làm tròn lên (số viên cơ bản × (1 + hao phí%))
                    const actualTileCount = Math.ceil(baseTileCount * (1 + wastePercentage / 100));
                    document.getElementById('tileCount').textContent = actualTileCount + ' viên';
                    
                    // Tính diện tích thực tế (kèm hao phí)
                    const actualArea = quantity * (1 + wastePercentage / 100);
                    
                    // Cộng = diện tích thực tế × đơn giá /m²
                    total = Math.round(actualArea * productPrice);
                    
                    // Hiển thị kích thước
                    const sizeStr = productSize.replace(/×/g, '×').replace(/x/g, '×');
                    document.getElementById('tileDimension').textContent = sizeStr + ' cm';
                    document.getElementById('pricePerM2').textContent = (productPrice).toLocaleString('vi-VN') + ' đ/m²';
                    
                    // Giải thích công thức
                    calcMethod = `
                        <li>Diện tích công trình: ${quantity} m²</li>
                        <li>Số viên cơ bản: ${quantity} ÷ ${(tileSizeM2).toFixed(2)} = ${(quantity/tileSizeM2).toFixed(2)} → làm tròn = ${baseTileCount} viên</li>
                        <li>Hao phí ${wastePercentage}%: ${baseTileCount} × (1 + ${wastePercentage}%) = ${(baseTileCount * (1 + wastePercentage/100)).toFixed(2)} → làm tròn = ${actualTileCount} viên</li>
                        <li>Diện tích thực tế: ${quantity} × (1 + ${wastePercentage}%) = ${actualArea.toFixed(2)} m²</li>
                        <li>Tổng cộng: ${actualArea.toFixed(2)} m² × ${productPrice.toLocaleString('vi-VN')} đ/m²</li>
                    `;
                } else {
                    total = quantity * productPrice;
                    calcMethod = `${quantity.toLocaleString('vi-VN')} m² × ${(productPrice).toLocaleString('vi-VN')} đ/m²`;
                }
            }
            
            document.getElementById('totalEstimate').textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total).replace('₫', 'đ');
            document.getElementById('calcMethod').innerHTML = calcMethod;
        }

        function addToCart() {
            @auth
                showPurchaseModal('add-to-cart');
            @else
                alert('Vui lòng đăng nhập để thêm vào giỏ hàng');
                window.location.href = '{{ route("login") }}';
            @endauth
        }

        function purchaseNow() {
            @auth
                showPurchaseModal('purchase-now');
            @else
                alert('Vui lòng đăng nhập để tiếp tục');
                window.location.href = '{{ route("login") }}';
            @endauth
        }

        function showPurchaseModal(action) {
            // Hiển thị modal
            document.getElementById('purchaseModal').style.display = 'flex';
            
            // Nếu là gạch (không TOTO), set input số viên là giá trị cơ bản từ dự toán
            if (!isToto) {
                const quantityEstimate = parseFloat(document.getElementById('quantityInput').value) || 1;
                const wasteEstimate = parseFloat(document.getElementById('wasteInput').value) || 7;
                
                if (tileSizeM2 > 0) {
                    const baseTileCount = Math.ceil(quantityEstimate / tileSizeM2);
                    const actualTileCount = Math.ceil(baseTileCount * (1 + wasteEstimate / 100));
                    document.getElementById('modalQuantityInput').value = actualTileCount;
                } else {
                    document.getElementById('modalQuantityInput').value = 1;
                }
            } else {
                // TOTO: set từ input dự toán
                document.getElementById('modalQuantityInput').value = parseFloat(document.getElementById('quantityInput').value) || 1;
            }
            
            // Set action
            document.getElementById('purchaseModal').dataset.action = action;
            
            // Tính lại dự toán trong modal
            calculateModalEstimate();
        }

        function closePurchaseModal() {
            document.getElementById('purchaseModal').style.display = 'none';
        }

        function calculateModalEstimate() {
            const quantity = parseFloat(document.getElementById('modalQuantityInput').value) || 1;
            
            let total = 0;
            let summary = '';
            
            if (isToto) {
                // TOTO: số lượng × đơn giá
                total = quantity * productPrice;
                summary = `${quantity.toLocaleString('vi-VN')} sản phẩm × ${productPrice.toLocaleString('vi-VN')} đ`;
            } else {
                // Gạch: Tính theo diện tích thực tế
                if (tileSizeM2 > 0) {
                    // Diện tích thực tế = Số viên × Diện tích 1 viên
                    const actualArea = quantity * tileSizeM2;
                    // Giá = Diện tích × Đơn giá/m² (đơn giá đã bao gồm hao phí)
                    total = Math.round(actualArea * productPrice);
                    summary = `${quantity.toLocaleString('vi-VN')} viên = ${actualArea.toFixed(2)} m² × ${productPrice.toLocaleString('vi-VN')} đ/m²`;
                } else {
                    total = quantity * productPrice;
                    summary = `${quantity.toLocaleString('vi-VN')} × ${productPrice.toLocaleString('vi-VN')} đ`;
                }
            }
            
            document.getElementById('modalTotalEstimate').textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(total).replace('₫', 'đ');
            document.getElementById('modalSummary').textContent = summary;
            document.getElementById('modalTotalPrice').dataset.total = total;
        }

        function confirmPurchase() {
            const quantity = parseFloat(document.getElementById('modalQuantityInput').value) || 1;
            const action = document.getElementById('purchaseModal').dataset.action;
            
            @auth
                if (action === 'purchase-now') {
                    // For purchase now: show checkout modal
                    closePurchaseModal();
                    showCheckoutModal(quantity);
                } else {
                    // For add to cart: proceed as usual with flying animation
                    createFlyingAnimation();
                    
                    setTimeout(() => {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = '{{ route("cart.add", $product->id) }}';
                        form.innerHTML = `
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="quantity" value="${quantity}">
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }, 600);
                    
                    closePurchaseModal();
                }
            @endauth
        }

        function createFlyingAnimation() {
            // Tạo element bay
            const flyingItem = document.createElement('div');
            flyingItem.style.cssText = `
                position: fixed;
                top: 50%;
                left: 50%;
                width: 80px;
                height: 80px;
                background: linear-gradient(135deg, var(--color-secondary) 0%, #ffd700 100%);
                border-radius: 8px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.3);
                pointer-events: none;
                z-index: 2000;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                animation: flyToCart 0.8s ease-in forwards;
            `;
            flyingItem.innerHTML = '🛒';
            document.body.appendChild(flyingItem);
            
            // Xóa element sau animation
            setTimeout(() => {
                flyingItem.remove();
            }, 800);
        }

        // Checkout Modal Functions
        function showCheckoutModal(quantity) {
            document.getElementById('checkoutModal').style.display = 'flex';
            document.getElementById('checkoutQuantity').value = quantity;
            document.getElementById('checkoutQuantityDisplay').value = quantity;
            updateCheckoutSummary(quantity);
        }

        function updateCheckoutSummary(quantity) {
            const unitPrice = productPrice;
            let totalAmount = 0;

            if (isToto) {
                totalAmount = quantity * unitPrice;
            } else {
                if (tileSizeM2 > 0) {
                    const actualArea = quantity * tileSizeM2;
                    totalAmount = Math.round(actualArea * unitPrice);
                } else {
                    totalAmount = quantity * unitPrice;
                }
            }

            document.getElementById('checkoutSummaryQuantity').textContent = isToto ? quantity + ' sản phẩm' : quantity + ' viên';
            document.getElementById('checkoutSummarySubtotal').textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalAmount).replace('₫', 'đ');
            document.getElementById('checkoutSummaryTotal').textContent = new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(totalAmount).replace('₫', 'đ');
        }

        function updateCheckoutQuantity() {
            const quantity = parseFloat(document.getElementById('checkoutQuantityDisplay').value) || 1;
            document.getElementById('checkoutQuantity').value = quantity;
            updateCheckoutSummary(quantity);
        }

        function closeCheckoutModal() {
            document.getElementById('checkoutModal').style.display = 'none';
        }

        function submitCheckoutForm() {
            const form = document.getElementById('checkoutForm');
            const quantity = parseFloat(document.getElementById('checkoutQuantityDisplay').value) || 1;
            const deliveryAddress = document.getElementById('checkoutAddress').value;
            const phone = document.getElementById('checkoutPhone').value;
            const notes = document.getElementById('checkoutNotes').value;
            const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;

            // Validation
            if (!deliveryAddress) {
                alert('Vui lòng nhập địa chỉ giao hàng');
                return;
            }
            if (!phone) {
                alert('Vui lòng nhập số điện thoại');
                return;
            }
            if (!paymentMethod) {
                alert('Vui lòng chọn phương thức thanh toán');
                return;
            }

            // Submit form via AJAX
            const formData = new FormData();
            formData.append('quantity', quantity);
            formData.append('delivery_address', deliveryAddress);
            formData.append('phone', phone);
            formData.append('notes', notes);
            formData.append('payment_method', paymentMethod);
            formData.append('_token', '{{ csrf_token() }}');

            fetch('{{ route("orders.storeDirect", $product->id) }}', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.error || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi khi xử lý đơn hàng');
            });
        }

        // Đóng modal khi bấm vào overlay
        document.addEventListener('click', function(e) {
            const modal = document.getElementById('purchaseModal');
            const checkoutModal = document.getElementById('checkoutModal');
            if (e.target === modal) {
                closePurchaseModal();
            }
            if (e.target === checkoutModal) {
                closeCheckoutModal();
            }
        });

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateEstimate();
            
            // Add event listener for checkout quantity input if modal exists
            const checkoutQuantityInput = document.getElementById('checkoutQuantityDisplay');
            if (checkoutQuantityInput) {
                checkoutQuantityInput.addEventListener('change', function() {
                    updateCheckoutQuantity();
                });
                checkoutQuantityInput.addEventListener('input', function() {
                    updateCheckoutQuantity();
                });
            }
        });
    </script>

    <!-- Purchase Modal -->
    <div id="purchaseModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center; padding: var(--spacing-md);">
        <div style="background: white; border-radius: 12px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3); max-width: 500px; width: 100%; max-height: 90vh; overflow-y: auto;">
            <!-- Header -->
            <div style="background: linear-gradient(135deg, var(--color-primary) 0%, #0d6bb5 100%); color: white; padding: var(--spacing-md); border-radius: 12px 12px 0 0; display: flex; justify-content: space-between; align-items: center;">
                <h2 style="margin: 0; font-size: 1.3rem;">✓ Xác Nhận Đơn Hàng</h2>
                <button onclick="closePurchaseModal()" style="background: rgba(255,255,255,0.3); border: none; color: white; font-size: 1.5rem; cursor: pointer; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.5)'" onmouseout="this.style.background='rgba(255,255,255,0.3)'">
                    ✕
                </button>
            </div>

            <!-- Content -->
            <div style="padding: var(--spacing-lg);">
                <!-- Product Name -->
                <div style="margin-bottom: var(--spacing-md); padding-bottom: var(--spacing-md); border-bottom: 2px solid #e5e7eb;">
                    <p style="margin: 0; color: #6b7280; font-size: 0.9rem;">Sản phẩm:</p>
                    <h3 style="margin: var(--spacing-xs) 0 0 0; font-size: 1.1rem; color: var(--color-primary);">{{ $product->name }}</h3>
                </div>

                <!-- Quantity Input -->
                @if($product->brand && $product->brand->slug === 'toto')
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600; color: var(--color-primary);">Số lượng sản phẩm</label>
                    <input type="number" id="modalQuantityInput" min="1" value="1" step="1" style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 1rem; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--color-secondary)'" onblur="this.style.borderColor='#e5e7eb'" onchange="calculateModalEstimate()" oninput="calculateModalEstimate()">
                </div>
                @else
                <div style="margin-bottom: var(--spacing-md);">
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 600; color: var(--color-primary);">Số viên gạch cần mua</label>
                    <input type="number" id="modalQuantityInput" min="1" step="1" value="1" style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 1rem; transition: border-color 0.3s;" onfocus="this.style.borderColor='var(--color-secondary)'" onblur="this.style.borderColor='#e5e7eb'" onchange="calculateModalEstimate()" oninput="calculateModalEstimate()">
                </div>
                @endif

                <!-- Price Summary -->
                <div style="background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%); padding: var(--spacing-md); border-radius: 8px; border-left: 4px solid #10b981; margin-bottom: var(--spacing-md);">
                    <p style="margin: 0 0 var(--spacing-sm) 0; color: #6b7280; font-size: 0.9rem;">Cách tính:</p>
                    <p id="modalSummary" style="margin: 0 0 var(--spacing-sm) 0; color: #047857; font-weight: 500;">-</p>
                    <div style="padding-top: var(--spacing-sm); border-top: 2px solid #d1fae5; display: flex; justify-content: space-between; align-items: baseline;">
                        <span style="color: #059669; font-weight: 600;">Tổng Cộng:</span>
                        <div id="modalTotalPrice" style="font-size: 1.8rem; font-weight: 700; color: var(--color-secondary);">
                            <span id="modalTotalEstimate">0 đ</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-sm);">
                    <button onclick="closePurchaseModal()" style="padding: 0.75rem 1.5rem; background: #f3f4f6; color: #374151; border: 2px solid #d1d5db; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                        ✕ Hủy
                    </button>
                    <button onclick="confirmPurchase()" style="padding: 0.75rem 1.5rem; background: var(--color-secondary); color: var(--color-primary); border: none; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        ✓ Xác Nhận
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Flying Cart Animation CSS -->
    <style>
        @keyframes flyToCart {
            0% {
                transform: translate(0, 0) scale(1);
                opacity: 1;
            }
            50% {
                transform: translate(calc(100vw * 0.4), -100px) scale(0.8);
                opacity: 0.8;
            }
            100% {
                transform: translate(calc(100vw * 0.85), calc(-100vh * 0.85)) scale(0.5);
                opacity: 0;
            }
        }

        /* Responsive layout for checkout modal */
        @media (max-width: 768px) {
            #checkoutModal > div {
                grid-template-columns: 1fr !important;
            }
            
            #checkoutModal > div > div:nth-child(2) {
                border-left: none !important;
                border-top: 1px solid #e5e7eb;
            }
        }
    </style>

    <!-- Checkout Modal (for direct purchase) -->
    <div id="checkoutModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center; padding: var(--spacing-md);">
        <div style="background: white; border-radius: 12px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3); max-width: 900px; width: 100%; max-height: 90vh; overflow-y: auto; display: grid; grid-template-columns: 1fr 350px; gap: 0;">
            <!-- Left: Form -->
            <div>
                <!-- Header -->
                <div style="background: linear-gradient(135deg, var(--color-primary) 0%, #0d6bb5 100%); color: white; padding: var(--spacing-md); display: flex; justify-content: space-between; align-items: center; grid-column: 1;">
                    <h2 style="margin: 0; font-size: 1.3rem;">💳 Thanh Toán</h2>
                    <button onclick="closeCheckoutModal()" style="background: rgba(255,255,255,0.3); border: none; color: white; font-size: 1.5rem; cursor: pointer; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: all 0.3s;" onmouseover="this.style.background='rgba(255,255,255,0.5)'" onmouseout="this.style.background='rgba(255,255,255,0.3)'">
                        ✕
                    </button>
                </div>

                <!-- Form Content -->
                <form id="checkoutForm" style="padding: var(--spacing-lg);">
                    <input type="hidden" id="checkoutQuantity" value="1">

                    <!-- Quantity -->
                    <div style="margin-bottom: var(--spacing-lg); background: #f3f4f6; padding: var(--spacing-md); border-radius: 6px;">
                        <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-primary);">
                            @if($product->brand && $product->brand->slug === 'toto')
                                Số lượng sản phẩm
                            @else
                                Số viên gạch
                            @endif
                        </label>
                        <input type="number" id="checkoutQuantityDisplay" min="1" value="1" step="1" style="width: 100%; padding: 0.75rem; border: 2px solid var(--color-primary); border-radius: 6px; font-size: 1rem; font-weight: 600; color: var(--color-primary);" onchange="updateCheckoutQuantity()" oninput="updateCheckoutQuantity()">
                    </div>

                    <!-- Delivery Address -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text);">Địa chỉ giao hàng</label>
                        <textarea id="checkoutAddress" placeholder="Nhập địa chỉ giao hàng" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 4px; font-family: inherit; resize: vertical;" rows="3"></textarea>
                    </div>

                    <!-- Phone -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text);">Số điện thoại</label>
                        <input type="text" id="checkoutPhone" placeholder="Ví dụ: 0912345678" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 4px;">
                    </div>

                    <!-- Notes -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <label style="display: block; font-weight: 600; margin-bottom: var(--spacing-xs); color: var(--color-text);">Ghi chú (tùy chọn)</label>
                        <textarea id="checkoutNotes" placeholder="Thêm ghi chú cho đơn hàng" style="width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 4px; font-family: inherit; resize: vertical;" rows="2"></textarea>
                    </div>

                    <!-- Payment Method -->
                    <div style="margin-bottom: var(--spacing-lg);">
                        <h3 style="font-weight: 600; margin-bottom: var(--spacing-md); color: var(--color-text);">Phương thức thanh toán</h3>
                        
                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: flex; align-items: center; padding: 12px; border: 2px solid #e5e7eb; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='var(--color-secondary)'; this.style.backgroundColor='#fffbf0'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='transparent'">
                                <input type="radio" name="payment_method" value="direct_payment" checked style="margin-right: var(--spacing-sm);">
                                <div>
                                    <strong style="display: block; color: var(--color-text);">Thanh toán trực tiếp</strong>
                                    <small style="color: #6b7280; display: block;">Thanh toán khi nhận hàng hoặc chuyển khoản</small>
                                </div>
                            </label>
                        </div>

                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: flex; align-items: center; padding: 12px; border: 2px solid #e5e7eb; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='var(--color-secondary)'; this.style.backgroundColor='#fffbf0'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='transparent'">
                                <input type="radio" name="payment_method" value="banking" style="margin-right: var(--spacing-sm);">
                                <div>
                                    <strong style="display: block; color: var(--color-text);">Chuyển khoản ngân hàng</strong>
                                    <small style="color: #6b7280; display: block;">Chuyển khoản trực tiếp đến tài khoản ngân hàng</small>
                                </div>
                            </label>
                        </div>

                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: flex; align-items: center; padding: 12px; border: 2px solid #e5e7eb; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='var(--color-secondary)'; this.style.backgroundColor='#fffbf0'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='transparent'">
                                <input type="radio" name="payment_method" value="credit_card" style="margin-right: var(--spacing-sm);">
                                <div>
                                    <strong style="display: block; color: var(--color-text);">Thẻ tín dụng</strong>
                                    <small style="color: #6b7280; display: block;">Visa, Mastercard, hoặc các thẻ khác</small>
                                </div>
                            </label>
                        </div>

                        <div style="margin-bottom: var(--spacing-md);">
                            <label style="display: flex; align-items: center; padding: 12px; border: 2px solid #e5e7eb; border-radius: 4px; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.borderColor='var(--color-secondary)'; this.style.backgroundColor='#fffbf0'" onmouseout="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='transparent'">
                                <input type="radio" name="payment_method" value="e_wallet" style="margin-right: var(--spacing-sm);">
                                <div>
                                    <strong style="display: block; color: var(--color-text);">Ví điện tử</strong>
                                    <small style="color: #6b7280; display: block;">Momo, ZaloPay, hoặc ví khác</small>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-sm);">
                        <button type="button" onclick="closeCheckoutModal()" style="padding: 0.75rem 1.5rem; background: #f3f4f6; color: #374151; border: 2px solid #d1d5db; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#e5e7eb'" onmouseout="this.style.background='#f3f4f6'">
                            ✕ Hủy
                        </button>
                        <button type="button" onclick="submitCheckoutForm()" style="padding: 0.75rem 1.5rem; background: var(--color-secondary); color: var(--color-primary); border: none; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            ✓ Xác Nhận
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right: Summary -->
            <div style="background: white; padding: var(--spacing-lg); border-left: 1px solid #e5e7eb;">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md); border-bottom: 1px solid #e5e7eb; padding-bottom: var(--spacing-md);">Đơn hàng</h3>
                
                <div style="margin-bottom: var(--spacing-md);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: #6b7280; font-size: 0.9rem;">Sản phẩm:</span>
                        <strong style="font-size: 0.9rem;">{{ $product->name }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: #6b7280; font-size: 0.9rem;">Thương hiệu:</span>
                        <strong style="font-size: 0.9rem;">{{ $product->brand->name ?? 'N/A' }}</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: #6b7280; font-size: 0.9rem;">Số lượng:</span>
                        <strong id="checkoutSummaryQuantity" style="font-size: 0.9rem;">0</strong>
                    </div>
                </div>

                <div style="border-top: 2px solid #e5e7eb; margin-top: var(--spacing-md); padding-top: var(--spacing-md);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm);">
                        <span style="color: #6b7280;">Hàng:</span>
                        <span id="checkoutSummarySubtotal">0 đ</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-md);">
                        <span style="color: #6b7280;">Vận chuyển:</span>
                        <span>Miễn phí</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 1.1rem;">
                        <span>Tổng:</span>
                        <span style="color: var(--color-secondary);" id="checkoutSummaryTotal">0 đ</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
