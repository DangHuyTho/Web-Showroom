@extends('layouts.app')

@section('title', 'Báo cáo tồn kho')

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--color-text);">Báo Cáo Tồn Kho</h1>
            <a href="{{ route('staff.inventory.export') }}" style="background: var(--color-secondary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(212,175,55,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                📥 Xuất CSV
            </a>
        </div>

        <!-- Products Table -->
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            @if ($products->isEmpty())
                <div style="padding: var(--spacing-lg); text-align: center; color: #6b7280;">
                    Chưa có sản phẩm nào
                </div>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f3f4f6; border-bottom: 1px solid #e5e7eb;">
                            <th style="padding: var(--spacing-md); text-align: left; color: #374151;">Sản phẩm</th>
                            <th style="padding: var(--spacing-md); text-align: center; color: #374151;">SKU</th>
                            <th style="padding: var(--spacing-md); text-align: right; color: #374151;">Giá</th>
                            <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Số lượng bán</th>
                            <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: var(--spacing-md);">
                                    <div style="display: flex; gap: var(--spacing-sm); align-items: center;">
                                        @if ($product->primaryImage)
                                            <img src="{{ Storage::url($product->primaryImage->image_path) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div style="width: 50px; height: 50px; background: #e5e7eb; border-radius: 4px;"></div>
                                        @endif
                                        <div>
                                            <strong style="display: block;">{{ $product->name }}</strong>
                                            <small style="color: #6b7280; display: block;">{{ $product->category->name ?? 'N/A' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center; color: #6b7280;">
                                    {{ $product->sku }}
                                </td>
                                <td style="padding: var(--spacing-md); text-align: right; font-weight: 600;">
                                    {{ number_format($product->price) }}₫
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center;">
                                    <span style="display: inline-block; background: #dbeafe; color: #0c2d6b; padding: 6px 12px; border-radius: 4px; font-weight: 600; font-size: 0.9rem;">
                                        {{ $product->sold_quantity ?? 0 }} / {{ $product->order_items_count ?? 0 }}
                                    </span>
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center;">
                                    <a href="{{ route('products.show', $product->slug) }}" style="color: var(--color-primary); text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                        Xem
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div style="margin-top: var(--spacing-lg); display: flex; justify-content: center;">
                {{ $products->links() }}
            </div>
        @endif

        <!-- Info -->
        <div style="background: #fef3c7; color: #92400e; padding: var(--spacing-lg); border-radius: 8px; margin-top: var(--spacing-lg);">
            <p style="margin: 0;">
                <strong>💡 Thông tin:</strong> Báo cáo này hiển thị số lượng sản phẩm được bán qua các đơn hàng. 
                Để quản lý tồn kho chi tiết, vui lòng liên hệ quản trị viên.
            </p>
        </div>
    </div>
</div>
@endsection
