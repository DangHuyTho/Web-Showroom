@extends('staff.layouts.app')

@section('title', 'Báo cáo tồn kho')
@section('page-title', 'Báo Cáo Tồn Kho')

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 1400px; margin: 0 auto;">
        <a href="{{ route('staff.inventory.index') }}" style="color: var(--color-primary); text-decoration: none; font-weight: 500; margin-bottom: var(--spacing-md); display: inline-block;">← Quay lại</a>

        <h1 style="font-size: 2rem; font-weight: 700; color: var(--color-text); margin-bottom: var(--spacing-lg);">📊 Báo Cáo Tồn Kho</h1>

        <!-- Summary Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <!-- Total Quantity -->
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid var(--color-primary);">
                <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">Tổng số lượng tồn kho</p>
                <p style="font-size: 2.5rem; font-weight: 700; color: var(--color-primary); margin: 8px 0 0 0;">{{ number_format($totalQuantity) }}</p>
            </div>

            <!-- Total Value -->
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid var(--color-secondary);">
                <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">Giá trị tồn kho</p>
                <p style="font-size: 2rem; font-weight: 700; color: var(--color-secondary); margin: 8px 0 0 0;">{{ number_format($totalValue, 0, ',', '.') }} đ</p>
            </div>

            <!-- Out of Stock -->
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #ef4444;">
                <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">Sản phẩm hết hàng</p>
                <p style="font-size: 2.5rem; font-weight: 700; color: #ef4444; margin: 8px 0 0 0;">{{ count($outOfStockProducts) }}</p>
            </div>

            <!-- Low Stock -->
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #f59e0b;">
                <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">Sản phẩm tồn kho thấp</p>
                <p style="font-size: 2.5rem; font-weight: 700; color: #f59e0b; margin: 8px 0 0 0;">{{ count($lowStockProducts) }}</p>
            </div>
        </div>

        <!-- Out of Stock Products -->
        <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <h3 style="margin-top: 0; margin-bottom: var(--spacing-md); font-weight: 600; color: var(--color-text);">⚠️ Sản phẩm hết hàng ({{ count($outOfStockProducts) }})</h3>
            
            @if(count($outOfStockProducts) > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #fee2e2; border-bottom: 2px solid #fecaca;">
                            <tr>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: #991b1b;">Sản phẩm</th>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: #991b1b;">Thương hiệu</th>
                                <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: #991b1b;">SKU</th>
                                <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: #991b1b;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($outOfStockProducts as $product)
                                <tr style="border-bottom: 1px solid #fecaca;">
                                    <td style="padding: var(--spacing-md); color: #991b1b;">{{ $product->name }}</td>
                                    <td style="padding: var(--spacing-md); color: #991b1b;">{{ $product->brand->name ?? 'N/A' }}</td>
                                    <td style="padding: var(--spacing-md); text-align: center; color: #991b1b; font-family: monospace;">{{ $product->sku ?? '-' }}</td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <a href="{{ route('staff.inventory.edit', $product->id) }}" style="color: #991b1b; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Cập nhật →</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: var(--spacing-lg); text-align: center; color: #10b981;">
                    ✓ Không có sản phẩm hết hàng
                </div>
            @endif
        </div>

        <!-- Low Stock Products -->
        <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <h3 style="margin-top: 0; margin-bottom: var(--spacing-md); font-weight: 600; color: var(--color-text);">⚠️ Sản phẩm tồn kho thấp ({{ count($lowStockProducts) }})</h3>
            
            @if(count($lowStockProducts) > 0)
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #fef3c7; border-bottom: 2px solid #fde68a;">
                            <tr>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: #92400e;">Sản phẩm</th>
                                <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: #92400e;">Thương hiệu</th>
                                <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: #92400e;">Tồn kho / Tối thiểu</th>
                                <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: #92400e;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lowStockProducts as $product)
                                <tr style="border-bottom: 1px solid #fde68a;">
                                    <td style="padding: var(--spacing-md); color: #92400e;">{{ $product->name }}</td>
                                    <td style="padding: var(--spacing-md); color: #92400e;">{{ $product->brand->name ?? 'N/A' }}</td>
                                    <td style="padding: var(--spacing-md); text-align: center; color: #92400e; font-weight: 600;">{{ $product->quantity }} / {{ $product->min_stock }}</td>
                                    <td style="padding: var(--spacing-md); text-align: center;">
                                        <a href="{{ route('staff.inventory.edit', $product->id) }}" style="color: #92400e; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Cập nhật →</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div style="padding: var(--spacing-lg); text-align: center; color: #10b981;">
                    ✓ Tất cả sản phẩm đều có đủ tồn kho
                </div>
            @endif
        </div>

        <!-- Products by Brand -->
        <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <h3 style="margin-top: 0; margin-bottom: var(--spacing-md); font-weight: 600; color: var(--color-text);">📦 Tồn kho theo thương hiệu</h3>
            
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead style="background: #f3f4f6; border-bottom: 2px solid #d1d5db;">
                        <tr>
                            <th style="padding: var(--spacing-md); text-align: left; font-weight: 600; color: #374151;">Thương hiệu</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: #374151;">Số sản phẩm</th>
                            <th style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: #374151;">Tổng tồn kho</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productsByBrand as $item)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: var(--spacing-md); color: #374151;">{{ $item->brand->name ?? 'N/A' }}</td>
                                <td style="padding: var(--spacing-md); text-align: center; color: #374151; font-weight: 600;">{{ $item->product_count }}</td>
                                <td style="padding: var(--spacing-md); text-align: center; font-weight: 600; color: var(--color-primary);">{{ $item->total_quantity }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" style="padding: var(--spacing-lg); text-align: center; color: #6b7280;">
                                    Không có dữ liệu
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
