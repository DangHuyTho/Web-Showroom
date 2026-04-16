@extends('layouts.app')

@section('title', 'Thanh toán - Đơn hàng #' . $order->id)

@section('content')
<div style="padding: var(--spacing-lg);">
    <div style="max-width: 600px; margin: 0 auto;">
        <h1 style="font-size: 2rem; font-weight: 700; margin-bottom: var(--spacing-lg); color: var(--color-text); text-align: center;">Thanh Toán</h1>

        <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <!-- Order Info -->
            <div style="border-bottom: 1px solid #e5e7eb; padding-bottom: var(--spacing-lg); margin-bottom: var(--spacing-lg);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">Đơn hàng #{{ $order->id }}</h3>
                
                <div style="background: #f3f4f6; padding: var(--spacing-md); border-radius: 8px; margin-bottom: var(--spacing-md);">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">Tổng thanh toán:</p>
                    <p style="font-size: 1.5rem; font-weight: 700; color: var(--color-secondary); margin: 0;">{{ number_format($payment->amount) }}₫</p>
                </div>

                <div style="margin-bottom: var(--spacing-sm);">
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">Phương thức thanh toán:</p>
                    <p style="font-weight: 600; margin: 0;">
                        @switch($payment->payment_method)
                            @case('direct_payment') Thanh toán trực tiếp @break
                            @case('banking') Chuyển khoản ngân hàng @break
                            @case('credit_card') Thẻ tín dụng @break
                            @case('e_wallet') Ví điện tử @break
                        @endswitch
                    </p>
                </div>

                <div>
                    <p style="color: #6b7280; font-size: 0.9rem; margin: 0;">Trạng thái:</p>
                    <span style="display: inline-block; padding: 6px 12px; border-radius: 4px; font-weight: 600; font-size: 0.9rem;
                        @if ($payment->status === 'pending') background: #fef3c7; color: #92400e;
                        @elseif ($payment->status === 'completed') background: #dcfce7; color: #166534;
                        @elseif ($payment->status === 'failed') background: #fee2e2; color: #991b1b;
                        @endif
                    ">
                        @switch($payment->status)
                            @case('pending') Chờ thanh toán @break
                            @case('completed') Thanh toán thành công @break
                            @case('failed') Thanh toán thất bại @break
                        @endswitch
                    </span>
                </div>
            </div>

            <!-- Products Summary -->
            <div style="margin-bottom: var(--spacing-lg);">
                <h4 style="font-weight: 600; margin-bottom: var(--spacing-md);">Sản phẩm:</h4>
                @foreach ($items as $item)
                    <div style="display: flex; justify-content: space-between; margin-bottom: var(--spacing-sm); padding-bottom: var(--spacing-sm); border-bottom: 1px solid #f3f4f6;">
                        <span style="color: #6b7280;">{{ $item->product->name }} x{{ $item->quantity }}</span>
                        <span style="font-weight: 600;">{{ number_format($item->subtotal) }}₫</span>
                    </div>
                @endforeach
            </div>

            <!-- Payment Method Section -->
            @if ($payment->status === 'pending')
                <div style="border-top: 1px solid #e5e7eb; padding-top: var(--spacing-lg);">
                    <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">Xác nhận thanh toán</h3>

                    @if ($payment->payment_method === 'direct_payment' || $payment->payment_method === 'banking')
                        <div style="background: #fef3c7; color: #92400e; padding: var(--spacing-md); border-radius: 8px; margin-bottom: var(--spacing-lg);">
                            <p style="font-weight: 600; margin: 0 0 var(--spacing-sm) 0;">Hướng dẫn thanh toán:</p>
                            <ul style="margin: 0; padding-left: 20px; color: #92400e;">
                                <li>Sau khi xác nhận, vui lòng chuyển khoản số tiền <strong>{{ number_format($payment->amount) }}₫</strong></li>
                                <li>Số tài khoản: <strong>1234567890</strong> (Ví dụ)</li>
                                <li>Nội dung: <strong>DH{{ $order->id }}</strong></li>
                                <li>Chúng tôi sẽ xác nhận nhận được thanh toán trong vòng 1-2 giờ</li>
                            </ul>
                        </div>
                    @elseif ($payment->payment_method === 'credit_card')
                        <div style="background: #dbeafe; color: #0c2d6b; padding: var(--spacing-md); border-radius: 8px; margin-bottom: var(--spacing-lg);">
                            <p style="font-weight: 600; margin: 0;">⚠️ Tính năng thanh toán bằng thẻ tín dụng sẽ sớm khả dụng</p>
                        </div>
                    @elseif ($payment->payment_method === 'e_wallet')
                        <div style="background: #dbeafe; color: #0c2d6b; padding: var(--spacing-md); border-radius: 8px; margin-bottom: var(--spacing-lg);">
                            <p style="font-weight: 600; margin: 0;">⚠️ Tính năng thanh toán ví điện tử sẽ sớm khả dụng</p>
                        </div>
                    @endif

                    <form action="{{ route('orders.processPayment', $payment->id) }}" method="POST">
                        @csrf
                        <button type="submit" style="width: 100%; background: var(--color-secondary); color: white; padding: 12px; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; transition: all 0.3s ease; margin-bottom: var(--spacing-md);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(212,175,55,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                            @if ($payment->payment_method === 'direct_payment')
                                Xác nhận thanh toán
                            @else
                                Tiếp tục xử lý thanh toán
                            @endif
                        </button>
                    </form>

                    <a href="{{ route('orders.show', $order->id) }}" style="display: inline-block; background: #9ca3af; color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        Quay lại
                    </a>
                </div>
            @else
                <div style="background: #dcfce7; color: #166534; padding: var(--spacing-lg); border-radius: 8px; text-align: center;">
                    <p style="font-size: 1.1rem; font-weight: 600; margin: 0;">✓ Thanh toán đã được xác nhận</p>
                    <p style="color: #166534; margin: var(--spacing-md) 0 0 0;">Cảm ơn bạn đã mua hàng!</p>
                </div>

                <div style="margin-top: var(--spacing-lg);">
                    <a href="{{ route('orders.show', $order->id) }}" style="display: inline-block; background: var(--color-primary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.background='var(--color-primary-dark)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary)'; this.style.transform='translateY(0)'">
                        Xem chi tiết đơn hàng
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
