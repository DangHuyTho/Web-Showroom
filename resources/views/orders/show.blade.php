@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 900px; margin: 0 auto;">
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

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
            <!-- Order Info -->
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md); border-bottom: 1px solid #e5e7eb; padding-bottom: var(--spacing-md);">Thông tin đơn hàng</h3>
                <div style="margin-bottom: var(--spacing-sm);">
                    <p style="color: #6b7280; font-size: 0.9rem;">Ngày đặt:</p>
                    <p style="font-weight: 500;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div style="margin-bottom: var(--spacing-sm);">
                    <p style="color: #6b7280; font-size: 0.9rem;">Tổng tiền:</p>
                    <p style="font-weight: 600; font-size: 1.1rem; color: var(--color-secondary);">{{ number_format($order->total_amount) }}₫</p>
                </div>
            </div>

            <!-- Delivery Info -->
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md); border-bottom: 1px solid #e5e7eb; padding-bottom: var(--spacing-md);">Thông tin giao hàng</h3>
                <div style="margin-bottom: var(--spacing-sm);">
                    <p style="color: #6b7280; font-size: 0.9rem;">Địa chỉ:</p>
                    <p style="font-weight: 500;">{{ $order->delivery_address }}</p>
                </div>
                <div>
                    <p style="color: #6b7280; font-size: 0.9rem;">Số điện thoại:</p>
                    <p style="font-weight: 500;">{{ $order->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <div style="padding: var(--spacing-lg); border-bottom: 1px solid #e5e7eb;">
                <h3 style="font-weight: 600;">Sản phẩm trong đơn hàng</h3>
            </div>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f3f4f6; border-bottom: 1px solid #e5e7eb;">
                        <th style="padding: var(--spacing-md); text-align: left; color: #374151;">Sản phẩm</th>
                        <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Số lượng</th>
                        <th style="padding: var(--spacing-md); text-align: right; color: #374151;">Đơn giá</th>
                        <th style="padding: var(--spacing-md); text-align: right; color: #374151;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr style="border-bottom: 1px solid #e5e7eb;">
                            <td style="padding: var(--spacing-md);">
                                <a href="{{ route('products.show', $item->product->slug) }}" style="color: var(--color-primary); text-decoration: none; font-weight: 500;">
                                    {{ $item->product->name }}
                                </a>
                            </td>
                            <td style="padding: var(--spacing-md); text-align: center;">{{ $item->quantity }}</td>
                            <td style="padding: var(--spacing-md); text-align: right;">{{ number_format($item->unit_price) }}₫</td>
                            <td style="padding: var(--spacing-md); text-align: right; font-weight: 600;">{{ number_format($item->subtotal) }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Actions -->
        @if (!in_array($order->status, ['delivered', 'cancelled']))
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">Hành động</h3>
                @if ($order->payment && $order->payment->status === 'pending')
                    <a href="{{ route('orders.payment', $order->payment->id) }}" style="display: inline-block; background: var(--color-secondary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; margin-right: var(--spacing-md); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(212,175,55,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Hoàn tất thanh toán
                    </a>
                @endif
                @if (in_array($order->status, ['pending', 'confirmed']))
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            Hủy đơn hàng
                        </button>
                    </form>
                @endif
            </div>
        @endif

        <!-- Back Button -->
        <a href="{{ route('orders.index') }}" style="display: inline-block; background: var(--color-primary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.background='var(--color-primary-dark)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary)'; this.style.transform='translateY(0)'">
            ← Quay lại danh sách đơn hàng
        </a>
    </div>
</div>
@endsection
