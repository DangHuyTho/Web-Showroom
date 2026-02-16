@extends('layouts.app')

@section('title', 'Danh Mục Sản Phẩm')

@section('content')
<section class="section">
    <div class="container">
        <h1 class="section-title">Danh Mục Sản Phẩm</h1>
        
        <!-- Filters -->
        <form method="GET" action="{{ route('products.index') }}" style="margin-bottom: var(--spacing-md);" id="filterForm">
            <!-- Search Bar -->
            <div style="margin-bottom: var(--spacing-md);">
                <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}" style="width: 100%; padding: 0.75rem 1rem; border: 1px solid var(--color-border); border-radius: 0.375rem; font-size: 0.95rem;">
            </div>

            <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap; align-items: flex-end;">
                <!-- Space Filter (New) -->
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500; font-size: 0.9rem;">Không gian:</label>
                    <select name="space" id="spaceSelect" style="padding: 0.5rem 1rem; border: 1px solid var(--color-border); border-radius: 0.375rem; cursor: pointer;">
                        <option value="">Tất cả</option>
                        @foreach($spaces ?? [] as $key => $name)
                        <option value="{{ $key }}" @if(request('space') == $key) selected @endif>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Brand Selection (Always Visible) -->
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500; font-size: 0.9rem;">Thương hiệu:</label>
                    <select name="brand" id="brandSelect" style="padding: 0.5rem 1rem; border: 1px solid var(--color-border); border-radius: 0.375rem; cursor: pointer;" onchange="updateFilters()">
                        <option value="">Tất cả</option>
                        @foreach($brands ?? [] as $brand)
                        <option value="{{ $brand->slug }}" @if(request('brand') == $brand->slug) selected @endif>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Kích thước Filter (For Royal, Viglacera) -->
                <div id="sizeFilterDiv" style="display: none;">
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500; font-size: 0.9rem;">Kích thước:</label>
                    <select name="size" id="sizeSelect" style="padding: 0.5rem 1rem; border: 1px solid var(--color-border); border-radius: 0.375rem; cursor: pointer;">
                        <option value="">Tất cả</option>
                        @foreach($sizes ?? [] as $size)
                        <option value="{{ $size }}" @if(request('size') == $size) selected @endif>{{ $size }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Bề mặt Filter (For Royal, Viglacera) -->
                <div id="surfaceTypeFilterDiv" style="display: none;">
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500; font-size: 0.9rem;">Bề mặt:</label>
                    <select name="surface_type" id="surfaceTypeSelect" style="padding: 0.5rem 1rem; border: 1px solid var(--color-border); border-radius: 0.375rem; cursor: pointer;">
                        <option value="">Tất cả</option>
                        @foreach($surfaceTypes ?? [] as $type)
                        <option value="{{ $type }}" @if(request('surface_type') == $type) selected @endif>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Loại ngói Filter (For Fuji) -->
                <div id="fujiTypeFilterDiv" style="display: none;">
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500; font-size: 0.9rem;">Loại ngói:</label>
                    <select name="product_type" id="productTypeSelect" style="padding: 0.5rem 1rem; border: 1px solid var(--color-border); border-radius: 0.375rem; cursor: pointer;">
                        <option value="">Tất cả</option>
                        <option value="flat" @if(request('product_type') == 'flat') selected @endif>Ngói phẳng</option>
                        <option value="wave" @if(request('product_type') == 'wave') selected @endif>Ngói sóng</option>
                        <option value="accessories" @if(request('product_type') == 'accessories') selected @endif>Phụ kiện</option>
                    </select>
                </div>

                <!-- Loại sản phẩm Filter (For Toto) -->
                <div id="totoFilterDiv" style="display: none;">
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500; font-size: 0.9rem;">Loại sản phẩm:</label>
                    <select name="product_category" id="productCategorySelect" style="padding: 0.5rem 1rem; border: 1px solid var(--color-border); border-radius: 0.375rem; cursor: pointer;">
                        <option value="">Tất cả</option>
                        <option value="Bồn Cầu" @if(request('product_category') == 'Bồn Cầu') selected @endif>Bồn Cầu</option>
                        <option value="Chậu Lavabo" @if(request('product_category') == 'Chậu Lavabo') selected @endif>Chậu Rửa</option>
                        <option value="Nắp Bồn Cầu" @if(request('product_category') == 'Nắp Bồn Cầu') selected @endif>Nắp Bồn Cầu</option>
                        <option value="Vòi" @if(request('product_category') == 'Vòi') selected @endif>Vòi</option>
                        <option value="Vòi Xịt" @if(request('product_category') == 'Vòi Xịt') selected @endif>Vòi Xịt</option>
                        <option value="Phễu Thoát & Ống Xả" @if(request('product_category') == 'Phễu Thoát & Ống Xả') selected @endif>Ống Xả & Phễu</option>
                    </select>
                </div>

                <button type="submit" style="padding: 0.5rem var(--spacing-md); background: var(--color-primary); color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='#0d6bb5'" onmouseout="this.style.background='var(--color-primary)'">Lọc sản phẩm</button>
                @if(request()->hasAny(['brand', 'space', 'size', 'surface_type', 'product_type', 'product_category', 'search']))
                <a href="{{ route('products.index') }}" style="padding: 0.5rem var(--spacing-md); background: #6b7280; color: white; border: none; border-radius: 0.375rem; font-weight: 500; cursor: pointer; text-decoration: none; display: inline-block; transition: all 0.3s;" onmouseover="this.style.background='#4b5563'" onmouseout="this.style.background='#6b7280'">Xóa bộ lọc</a>
                @endif
            </div>
        </form>

        <script>
            // Filter configuration data
            const filterConfig = @json($filterConfig ?? []);
            
            function updateFilters() {
                const brandSelect = document.getElementById('brandSelect');
                const selectedBrand = brandSelect.value;
                
                // Get all filter sections
                const sizeFilterDiv = document.getElementById('sizeFilterDiv');
                const surfaceTypeFilterDiv = document.getElementById('surfaceTypeFilterDiv');
                const fujiTypeFilterDiv = document.getElementById('fujiTypeFilterDiv');
                const totoFilterDiv = document.getElementById('totoFilterDiv');
                
                // Hide all filters first
                sizeFilterDiv.style.display = 'none';
                surfaceTypeFilterDiv.style.display = 'none';
                fujiTypeFilterDiv.style.display = 'none';
                totoFilterDiv.style.display = 'none';
                
                // Show filters based on selected brand
                if (selectedBrand === '') {
                    // "Tất cả" - show no additional filters
                } else if (selectedBrand === 'royal' || selectedBrand === 'viglacera') {
                    // Royal and Viglacera - show size and surface type
                    sizeFilterDiv.style.display = 'block';
                    surfaceTypeFilterDiv.style.display = 'block';
                } else if (selectedBrand === 'fuji') {
                    // Fuji - show loại ngói
                    fujiTypeFilterDiv.style.display = 'block';
                } else if (selectedBrand === 'toto') {
                    // Toto - show product category
                    totoFilterDiv.style.display = 'block';
                }
            }
            
            // Initialize filters on page load
            document.addEventListener('DOMContentLoaded', function() {
                updateFilters();
            });
        </script>

        <!-- Products Grid -->
        <div class="grid grid-4">
            @forelse($products as $product)
            <a href="{{ route('products.show', $product->slug) }}" class="card" style="text-decoration: none; display: flex; flex-direction: column; height: 100%;">
                <div class="card-image" style="background-size: cover; background-position: center; overflow: hidden; height: 250px;">
                    @php
                        $primaryImage = $product->images()->where('is_primary', true)->first() ?? $product->images->first();
                    @endphp
                    @if($primaryImage)
                        <img src="{{ asset($primaryImage->image_path) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block;">
                    @else
                        <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 500;">
                            {{ substr($product->name, 0, 20) }}...
                        </div>
                    @endif
                </div>
                <div class="card-body" style="flex: 1; display: flex; flex-direction: column;">
                    <h3 class="card-title" style="font-size: 1rem; margin-bottom: var(--spacing-xs);">{{ substr($product->name, 0, 40) }}</h3>
                    <p class="card-text" style="color: var(--color-text-light); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">{{ $product->brand->name ?? 'N/A' }}</p>
                    @if($product->size)
                    <p style="color: var(--color-text-light); font-size: 0.85rem; margin-bottom: var(--spacing-xs);">Kích thước: {{ $product->size }}</p>
                    @endif
                    @if($product->price)
                    <p style="font-weight: 600; color: var(--color-secondary); margin-top: auto;">
                        {{ number_format($product->price, 0, ',', '.') }} đ/{{ $product->unit }}
                    </p>
                    @endif
                </div>
            </a>
            @empty
            <div style="grid-column: 1 / -1; text-align: center; padding: var(--spacing-lg);">
                <p style="color: var(--color-text-light); font-size: 1.1rem;">Chưa có sản phẩm nào</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if(isset($products) && method_exists($products, 'links'))
        <div style="margin-top: var(--spacing-lg); display: flex; justify-content: center; padding: var(--spacing-md) 0;">
            <nav style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap; justify-content: center;">
                @php
                    $paginator = $products;
                @endphp

                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span style="padding: 0.5rem 0.75rem; background: #e5e7eb; color: #9ca3af; border-radius: 0.375rem; font-size: 0.9rem; cursor: not-allowed;">
                        &laquo; Trước
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" style="padding: 0.5rem 0.75rem; background: var(--color-primary); color: white; border-radius: 0.375rem; font-size: 0.9rem; text-decoration: none; transition: all 0.3s; display: inline-block;" onmouseover="this.style.background='#0d6bb5';" onmouseout="this.style.background='var(--color-primary)';">
                        &laquo; Trước
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding: 0.5rem 0.75rem; background: var(--color-secondary); color: white; border-radius: 0.375rem; font-weight: 600; font-size: 0.9rem; min-width: 2.5rem; text-align: center; display: inline-block;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" style="padding: 0.5rem 0.75rem; background: #f3f4f6; color: #374151; border-radius: 0.375rem; font-size: 0.9rem; text-decoration: none; transition: all 0.3s; display: inline-block; min-width: 2.5rem; text-align: center;" onmouseover="this.style.background='#e5e7eb';" onmouseout="this.style.background='#f3f4f6';">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" style="padding: 0.5rem 0.75rem; background: var(--color-primary); color: white; border-radius: 0.375rem; font-size: 0.9rem; text-decoration: none; transition: all 0.3s; display: inline-block;" onmouseover="this.style.background='#0d6bb5';" onmouseout="this.style.background='var(--color-primary)';">
                        Tiếp &raquo;
                    </a>
                @else
                    <span style="padding: 0.5rem 0.75rem; background: #e5e7eb; color: #9ca3af; border-radius: 0.375rem; font-size: 0.9rem; cursor: not-allowed;">
                        Tiếp &raquo;
                    </span>
                @endif

                <span style="color: #6b7280; font-size: 0.9rem; margin-left: var(--spacing-sm);">
                    Trang {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
                </span>
            </nav>
        </div>
        @endif
    </div>
</section>
@endsection
