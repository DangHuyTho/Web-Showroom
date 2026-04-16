@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 1000px; margin: 0 auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--spacing-lg);">
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--color-text);">Đơn hàng #{{ $order->id }}</h1>
            <span style="display: inline-block; padding: 8px 16px; border-radius: 4px; font-weight: 600;
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
                    @case('shipped') Đã gửi hàng @break
                    @case('delivered') Đã giao hàng @break
                    @case('cancelled') Đã hủy @break
                @endswitch
            </span>
        </div>

        @if (session('success'))
            <div style="background: #dcfce7; color: #166534; padding: var(--spacing-md); border-radius: 8px; margin-bottom: var(--spacing-lg);">
                {{ session('success') }}
            </div>
        @endif

        <!-- Customer & Order Info -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">Thông tin khách hàng</h3>
                <p style="margin-bottom: 8px;"><strong>{{ $order->user->name }}</strong></p>
                <p style="margin: 4px 0; color: #6b7280;">Email: {{ $order->user->email }}</p>
                <p style="margin: 4px 0; color: #6b7280;">Số điện thoại: {{ $order->phone }}</p>
            </div>

            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">Thông tin đơn hàng</h3>
                <p style="margin-bottom: 8px;"><strong>{{ number_format($order->total_amount) }}₫</strong></p>
                <p style="margin: 4px 0; color: #6b7280;">Ngày: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p style="margin: 4px 0; color: #6b7280;">ID thanh toán: {{ $order->payment?->transaction_id ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Delivery Address -->
        <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">Địa chỉ giao hàng</h3>
            <p style="margin: 0; color: #6b7280;">{{ $order->delivery_address }}</p>
            @if ($order->notes)
                <div style="margin-top: var(--spacing-md); padding-top: var(--spacing-md); border-top: 1px solid #e5e7eb;">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0 0 4px 0;">Ghi chú:</p>
                    <p style="margin: 0; color: #374151;">{{ $order->notes }}</p>
                </div>
            @endif
        </div>

        <!-- Order Items -->
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <div style="padding: var(--spacing-lg); border-bottom: 1px solid #e5e7eb;">
                <h3 style="font-weight: 600; margin: 0;">Sản phẩm</h3>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f3f4f6; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: var(--spacing-md); text-align: left; color: #374151;">Sản phẩm</th>
                        <th style="padding: var(--spacing-md); text-align: center; color: #374151;">SL</th>
                        <th style="padding: var(--spacing-md); text-align: right; color: #374151;">Đơn giá</th>
                        <th style="padding: var(--spacing-md); text-align: right; color: #374151;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: var(--spacing-md);">
                                <strong>{{ $item->product->name }}</strong><br>
                                <small style="color: #6b7280;">SKU: {{ $item->product->sku }}</small>
                            </td>
                            <td style="padding: var(--spacing-md); text-align: center;">{{ $item->quantity }}</td>
                            <td style="padding: var(--spacing-md); text-align: right;">{{ number_format($item->unit_price) }}₫</td>
                            <td style="padding: var(--spacing-md); text-align: right; font-weight: 600;">{{ number_format($item->subtotal) }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="padding: var(--spacing-lg); border-top: 1px solid #e5e7eb; text-align: right;">
                <p style="margin: 0; color: #6b7280; margin-bottom: var(--spacing-sm);">Tổng cộng:</p>
                <p style="margin: 0; font-size: 1.5rem; font-weight: 700; color: var(--color-secondary);">{{ number_format($order->total_amount) }}₫</p>
            </div>
        </div>

        <!-- Actions -->
        @if (!in_array($order->status, ['delivered', 'cancelled']))
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">Hành động</h3>
                <div style="display: flex; gap: var(--spacing-md); flex-wrap: wrap;">
                    @if ($order->status === 'pending')
                        <form action="{{ route('staff.orders.confirm', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                ✓ Xác nhận đơn hàng
                            </button>
                        </form>

                        <form action="{{ route('staff.orders.reject', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="reason" value="Từ chối nhân viên">
                            <button type="submit" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onclick="return confirm('Bạn có chắc chắn?');" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                ✕ Từ chối
                            </button>
                        </form>
                    @endif

                    @if ($order->status === 'confirmed')
                        <form action="{{ route('staff.orders.process', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #8b5cf6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                📦 Bắt đầu xử lý
                            </button>
                        </form>

                        <form action="{{ route('staff.orders.reject', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="reason" value="Từ chối nhân viên">
                            <button type="submit" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onclick="return confirm('Bạn có chắc chắn?');" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                ✕ Từ chối
                            </button>
                        </form>
                    @endif

                    @if ($order->status === 'processing')
                        <form action="{{ route('staff.orders.ship', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #06b6d4; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                🚚 Gửi hàng
                            </button>
                        </form>
                    @endif

                    @if ($order->status === 'shipped')
                        <form action="{{ route('staff.orders.deliver', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                ✓ Giao hàng hoàn tất
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('staff.orders.index') }}" style="display: inline-block; background: var(--color-primary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.background='var(--color-primary-dark)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary)'; this.style.transform='translateY(0)'">
            ← Quay lại
        </a>
    </div>
</div>
@endsection
