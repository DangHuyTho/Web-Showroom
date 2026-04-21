@extends('staff.layouts.app')

@section('title', 'Bảng điều khiển nhân viên')
@section('page-title', 'Bảng Điều Khiển')

@section('content')
<div>
        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: var(--spacing-lg); color: var(--color-text);">Bảng Điều Khiển Nhân Viên</h1>

        <!-- Order Statistics -->
        <div style="margin-bottom: var(--spacing-lg) * 2;">
            <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: var(--spacing-md); color: var(--color-text);">📦 Quản Lý Đơn Hàng</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-lg);">
                <!-- Pending Orders -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #fbbf24;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">⏳ Chờ xác nhận</p>
                    <p style="font-size: 2.5rem; font-weight: 700; color: #f59e0b; margin: 8px 0 0 0;">{{ $pendingOrders }}</p>
                    <a href="{{ route('staff.orders.index', ['status' => 'pending']) }}" style="color: var(--color-primary); text-decoration: none; font-size: 0.9rem; margin-top: var(--spacing-md); display: inline-block;">Xem chi tiết →</a>
                </div>

                <!-- Confirmed Orders -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #3b82f6;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">✓ Đã xác nhận</p>
                    <p style="font-size: 2.5rem; font-weight: 700; color: #2563eb; margin: 8px 0 0 0;">{{ $confirmedOrders }}</p>
                    <a href="{{ route('staff.orders.index', ['status' => 'confirmed']) }}" style="color: var(--color-primary); text-decoration: none; font-size: 0.9rem; margin-top: var(--spacing-md); display: inline-block;">Xem chi tiết →</a>
                </div>

                <!-- Processing Orders -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #8b5cf6;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">⚙️ Đang chuẩn bị</p>
                    <p style="font-size: 2.5rem; font-weight: 700; color: #7c3aed; margin: 8px 0 0 0;">{{ $processingOrders }}</p>
                    <a href="{{ route('staff.orders.index', ['status' => 'processing']) }}" style="color: var(--color-primary); text-decoration: none; font-size: 0.9rem; margin-top: var(--spacing-md); display: inline-block;">Xem chi tiết →</a>
                </div>

                <!-- Packed Orders (Chờ lấy hàng) -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #06b6d4;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">📤 Chờ lấy hàng</p>
                    <p style="font-size: 2.5rem; font-weight: 700; color: #0891b2; margin: 8px 0 0 0;">{{ $packedOrders }}</p>
                    <a href="{{ route('staff.orders.index', ['status' => 'packed']) }}" style="color: var(--color-primary); text-decoration: none; font-size: 0.9rem; margin-top: var(--spacing-md); display: inline-block;">Xem chi tiết →</a>
                </div>

                <!-- Total Orders -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #10b981;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">📋 Tổng đơn hàng</p>
                    <p style="font-size: 2.5rem; font-weight: 700; color: #059669; margin: 8px 0 0 0;">{{ $totalOrders }}</p>
                    <a href="{{ route('staff.orders.index') }}" style="color: var(--color-primary); text-decoration: none; font-size: 0.9rem; margin-top: var(--spacing-md); display: inline-block;">Xem chi tiết →</a>
                </div>
            </div>
        </div>

        <!-- Inventory Statistics -->
        <div style="margin-bottom: var(--spacing-lg) * 2;">
            <h3 style="font-size: 1.2rem; font-weight: 600; margin-bottom: var(--spacing-md); color: var(--color-text);">📊 Quản Lý Tồn Kho</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--spacing-lg);">
                <!-- Total Products -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid var(--color-primary);">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">📦 Tổng sản phẩm</p>
                    <p style="font-size: 2.5rem; font-weight: 700; color: var(--color-primary); margin: 8px 0 0 0;">{{ $totalProducts }}</p>
                    <a href="{{ route('staff.inventory.index') }}" style="color: var(--color-primary); text-decoration: none; font-size: 0.9rem; margin-top: var(--spacing-md); display: inline-block;">Quản lý →</a>
                </div>

                <!-- Total Inventory Value -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid var(--color-secondary);">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">💰 Giá trị tồn kho</p>
                    <p style="font-size: 2rem; font-weight: 700; color: var(--color-secondary); margin: 8px 0 0 0;">{{ number_format($totalInventoryValue, 0, ',', '.') }} đ</p>
                    <a href="{{ route('staff.inventory.report') }}" style="color: var(--color-primary); text-decoration: none; font-size: 0.9rem; margin-top: var(--spacing-md); display: inline-block;">Báo cáo →</a>
                </div>

                <!-- Low Stock -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #f59e0b;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">⚠️ Tồn kho thấp</p>
                    <p style="font-size: 2.5rem; font-weight: 700; color: #f59e0b; margin: 8px 0 0 0;">{{ $lowStockCount }}</p>
                    <a href="{{ route('staff.inventory.index', ['stock_status' => 'low']) }}" style="color: var(--color-primary); text-decoration: none; font-size: 0.9rem; margin-top: var(--spacing-md); display: inline-block;">Xem chi tiết →</a>
                </div>

                <!-- Out of Stock -->
                <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-left: 4px solid #ef4444;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">🚫 Hết hàng</p>
                    <p style="font-size: 2.5rem; font-weight: 700; color: #ef4444; margin: 8px 0 0 0;">{{ $outOfStockCount }}</p>
                    <a href="{{ route('staff.inventory.index', ['stock_status' => 'out']) }}" style="color: var(--color-primary); text-decoration: none; font-size: 0.9rem; margin-top: var(--spacing-md); display: inline-block;">Xem chi tiết →</a>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg) * 2;">
            <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">⚡ Hành động nhanh</h3>
            <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap;">
                <a href="{{ route('staff.orders.index') }}" style="flex: 1; min-width: 200px; background: var(--color-primary); color: white; padding: 12px 20px; border-radius: 4px; text-decoration: none; text-align: center; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.2)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    📦 Quản lý đơn hàng
                </a>
                <a href="{{ route('staff.inventory.index') }}" style="flex: 1; min-width: 200px; background: var(--color-secondary); color: white; padding: 12px 20px; border-radius: 4px; text-decoration: none; text-align: center; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(212,175,55,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    📊 Quản lý kho hàng
                </a>
                <a href="{{ route('staff.inventory.report') }}" style="flex: 1; min-width: 200px; background: #8b5cf6; color: white; padding: 12px 20px; border-radius: 4px; text-decoration: none; text-align: center; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                    📈 Báo cáo tồn kho
                </a>
            </div>
        </div>

        <!-- Low Stock Alert -->
        @if($lowStockProducts->count() > 0)
        <div style="background: #fef3c7; border-left: 4px solid #f59e0b; border-radius: 8px; padding: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <h3 style="margin-top: 0; margin-bottom: var(--spacing-md); color: #92400e;">⚠️ Cảnh báo: {{ $lowStockProducts->count() }} sản phẩm tồn kho thấp</h3>
            <div style="display: grid; gap: var(--spacing-sm);">
                @foreach($lowStockProducts as $product)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: white; border-radius: 4px;">
                        <div>
                            <strong style="color: #92400e;">{{ $product->name }}</strong>
                            <small style="color: #6b7280; display: block;">{{ $product->brand->name ?? 'N/A' }} - Tồn kho: {{ $product->quantity }} / Tối thiểu: {{ $product->min_stock }}</small>
                        </div>
                        <a href="{{ route('staff.inventory.edit', $product->id) }}" style="background: #f59e0b; color: white; padding: 6px 12px; border-radius: 4px; text-decoration: none; font-weight: 500; font-size: 0.9rem; white-space: nowrap;">Cập nhật</a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Recent Orders -->
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="padding: var(--spacing-lg); border-bottom: 1px solid #e5e7eb;">
                <h3 style="font-weight: 600; margin: 0;">📋 Đơn hàng gần đây</h3>
            </div>
            @if ($recentOrders->isEmpty())
                <div style="padding: var(--spacing-lg); text-align: center; color: #6b7280;">
                    Chưa có đơn hàng nào
                </div>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f3f4f6; border-bottom: 1px solid #e5e7eb;">
                            <th style="padding: var(--spacing-md); text-align: left; color: #374151;">Đơn hàng</th>
                            <th style="padding: var(--spacing-md); text-align: left; color: #374151;">Khách hàng</th>
                            <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Ngày</th>
                            <th style="padding: var(--spacing-md); text-align: right; color: #374151;">Tiền</th>
                            <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Trạng thái</th>
                            <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: var(--spacing-md);">
                                    <a href="{{ route('staff.orders.show', $order->id) }}" style="color: var(--color-primary); text-decoration: none; font-weight: 600;">
                                        #{{ $order->id }}
                                    </a>
                                </td>
                                <td style="padding: var(--spacing-md); color: #6b7280;">
                                    {{ $order->user->name }}
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center; color: #6b7280;">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                                <td style="padding: var(--spacing-md); text-align: right; font-weight: 600;">
                                    {{ number_format($order->total_amount) }} đ
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center;">
                                    <span style="display: inline-block; padding: 6px 12px; border-radius: 4px; font-weight: 600; font-size: 0.85rem;
                                        @if ($order->status === 'pending') background: #fef3c7; color: #92400e;
                                        @elseif ($order->status === 'confirmed') background: #dbeafe; color: #0c2d6b;
                                        @elseif ($order->status === 'processing') background: #e0e7ff; color: #312e81;
                                        @elseif ($order->status === 'shipped') background: #cffafe; color: #164e63;
                                        @elseif ($order->status === 'delivered') background: #dcfce7; color: #166534;
                                        @else background: #fee2e2; color: #991b1b;
                                        @endif
                                    ">
                                        @switch($order->status)
                                            @case('pending') Chờ xác nhận @break
                                            @case('confirmed') Đã xác nhận @break
                                            @case('processing') Đang xử lý @break
                                            @case('shipped') Đã gửi @break
                                            @case('delivered') Đã giao @break
                                            @case('cancelled') Đã hủy @break
                                        @endswitch
                                    </span>
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center;">
                                    <a href="{{ route('staff.orders.show', $order->id) }}" style="color: var(--color-primary); text-decoration: none; font-weight: 500; font-size: 0.9rem;">
                                        Chi tiết
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
