@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 1000px; margin: 0 auto;">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: var(--spacing-lg); color: var(--color-text);">Đơn Hàng Của Tôi</h1>

        @if ($orders->isEmpty())
            <div style="background: #f3f4f6; border-radius: 8px; padding: var(--spacing-lg) * 2; text-align: center;">
                <p style="color: #6b7280; font-size: 1.1rem; margin-bottom: var(--spacing-md);">Bạn chưa có đơn hàng nào</p>
                <a href="{{ route('products.index') }}" style="display: inline-block; background: var(--color-primary); color: white; padding: 12px 24px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.background='var(--color-primary-dark)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary)'; this.style.transform='translateY(0)'">
                    Bắt đầu mua sắm
                </a>
            </div>
        @else
            <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f3f4f6; border-bottom: 1px solid #e5e7eb;">
                            <th style="padding: var(--spacing-md); text-align: left; color: #374151;">Đơn hàng</th>
                            <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Ngày</th>
                            <th style="padding: var(--spacing-md); text-align: right; color: #374151;">Tổng tiền</th>
                            <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Trạng thái</th>
                            <th style="padding: var(--spacing-md); text-align: center; color: #374151;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: var(--spacing-md);">
                                    <a href="{{ route('orders.show', $order->id) }}" style="color: var(--color-primary); text-decoration: none; font-weight: 600;">
                                        #{{ $order->id }}
                                    </a>
                                </td>
                                <td style="padding: var(--spacing-md); text-align: center; color: #6b7280;">
                                    {{ $order->created_at->format('d/m/Y') }}
                                </td>
                                <td style="padding: var(--spacing-md); text-align: right; font-weight: 600;">
                                    {{ number_format($order->total_amount) }}₫
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
                                    <a href="{{ route('orders.show', $order->id) }}" style="color: var(--color-primary); text-decoration: none; font-weight: 500; font-size: 0.9rem; transition: all 0.3s ease;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                        Xem chi tiết
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($orders->hasPages())
                <div style="margin-top: var(--spacing-lg); display: flex; justify-content: center; gap: var(--spacing-sm);">
                    {{ $orders->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
