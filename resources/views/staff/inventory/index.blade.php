@extends('staff.layouts.app')

@section('title', 'Quản lý tồn kho')
@section('page-title', 'Quản Lý Tồn Kho')

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 1400px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
            <h1 style="font-size: 2rem; font-weight: 700; margin: 0; color: var(--color-text);">📦 Quản Lý Tồn Kho</h1>
            <a href="{{ route('staff.inventory.report') }}" style="background: var(--color-secondary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s;">📊 Báo Cáo</a>
        </div>

        @if (session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: var(--spacing-md); border-radius: 8px; margin-bottom: var(--spacing-lg);">
                ✓ {{ session('success') }}
            </div>
        @endif

        <!-- Filters & Search -->
        <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <h3 style="margin-top: 0; margin-bottom: var(--spacing-md); font-weight: 600;">Tìm kiếm & Lọc</h3>
            <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-md);">
                <!-- Search -->
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Tên sản phẩm / SKU</label>
                    <input type="text" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px;">
                </div>

                <!-- Brand Filter -->
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Thương hiệu</label>
                    <select name="brand_id" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px;">
                        <option value="">Tất cả</option>
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Loại</label>
                    <select name="category_id" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px;">
                        <option value="">Tất cả</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Stock Status -->
                <div>
                    <label style="display: block; margin-bottom: var(--spacing-xs); font-weight: 500;">Trạng thái tồn kho</label>
                    <select name="stock_status" style="width: 100%; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 4px;">
                        <option value="">Tất cả</option>
                        <option value="ok" {{ request('stock_status') === 'ok' ? 'selected' : '' }}>Đầy đủ</option>
                        <option value="low" {{ request('stock_status') === 'low' ? 'selected' : '' }}>Cảnh báo thấp</option>
                        <option value="out" {{ request('stock_status') === 'out' ? 'selected' : '' }}>Hết hàng</option>
                    </select>
                </div>

                <!-- Search Button -->
                <div style="display: flex; gap: var(--spacing-sm); align-items: flex-end;">
                    <button type="submit" style="flex: 1; background: var(--color-primary); color: white; padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s;">
                        🔍 Tìm kiếm
                    </button>
                    <a href="{{ route('staff.inventory.index') }}" style="padding: 8px 16px; background: #f3f4f6; color: #374151; border-radius: 4px; text-decoration: none; font-weight: 500; text-align: center; white-space: nowrap;">
                        ↺ Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Inventory Table -->
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f3f4f6; border-bottom: 2px solid #d1d5db;">
                        <tr>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: var(--color-text);">Sản phẩm</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: var(--color-text);">Thương hiệu</th>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: var(--color-text);">SKU</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: var(--color-text);">Vị trí kệ</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: var(--color-text);">Tồn kho</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: var(--color-text);">Tối thiểu</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: var(--color-text);">Trạng thái</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: var(--color-text);">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: var(--spacing-md);">
                                    <strong style="color: var(--color-text);">{{ $product->name }}</strong>
                                </td>
                                <td style="padding: var(--spacing-md); color: #6b7280;">
                                    {{ $product->brand->name ?? 'N/A' }}
                                </td>
                                <td style="padding: var(--spacing-md); color: #6b7280; font-family: monospace;">
                                    {{ $product->sku ?? '-' }}
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center; font-family: monospace; font-weight: 600; color: var(--color-secondary);">
                                    {{ $product->shelf_location ?? '—' }}
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center;">
                                    <strong style="font-size: 1.1rem; color: var(--color-primary);">
                                        {{ $product->quantity }}
                                    </strong>
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center; color: #6b7280;">
                                    {{ $product->min_stock }}
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center;">
                                    @if($product->quantity == 0)
                                        <span style="background: #fee2e2; color: #991b1b; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">⚠️ Hết hàng</span>
                                    @elseif($product->quantity <= $product->min_stock)
                                        <span style="background: #fef3c7; color: #92400e; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">⚠️ Thấp</span>
                                    @else
                                        <span style="background: #dcfce7; color: #166534; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; font-weight: 500;">✓ Đầy đủ</span>
                                    @endif
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center;">
                                    <a href="{{ route('staff.inventory.edit', $product->id) }}" style="background: var(--color-primary); color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-size: 0.9rem; font-weight: 500; display: inline-block; transition: all 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
                                        ✏️ Cập nhật
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding: var(--spacing-lg); text-align: center; color: #6b7280;">
                                    Không tìm thấy sản phẩm nào
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div style="display: flex; justify-content: center; gap: var(--spacing-sm);">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
