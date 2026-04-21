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
                @elseif ($order->status === 'packed') background: #cffafe; color: #0369a1;
                @elseif ($order->status === 'shipped') background: #ccfbf1; color: #0d4d49;
                @elseif ($order->status === 'delivered') background: #dcfce7; color: #166534;
                @else background: #fee2e2; color: #991b1b;
                @endif
            ">
                @switch($order->status)
                    @case('pending') ⏳ Chờ xác nhận @break
                    @case('confirmed') ✓ Đã xác nhận @break
                    @case('processing') ⚙️ Đang chuẩn bị @break
                    @case('packed') 📦 Chờ lấy hàng @break
                    @case('shipped') 🚚 Đang giao @break
                    @case('delivered') ✓ Đã nhận hàng @break
                    @case('cancelled') ✕ Đã hủy @break
                @endswitch
            </span>
        </div>

        {{-- Status Timeline --}}
        <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
            <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">📊 Trạng thái đơn hàng</h3>
            <div style="display: flex; justify-content: space-between; position: relative; margin: 40px 0;">
                <style>
                    .timeline-item {
                        flex: 1;
                        text-align: center;
                        position: relative;
                    }
                    .timeline-item.active .timeline-circle {
                        background: #10b981;
                        color: white;
                    }
                    .timeline-item.completed .timeline-circle {
                        background: #10b981;
                        color: white;
                    }
                    .timeline-item.pending .timeline-circle {
                        background: #e5e7eb;
                        color: #6b7280;
                    }
                    .timeline-circle {
                        width: 50px;
                        height: 50px;
                        border-radius: 50%;
                        margin: 0 auto 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        font-weight: 600;
                        border: 3px solid white;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                    }
                    .timeline-label {
                        font-size: 0.9rem;
                        font-weight: 500;
                        color: #374151;
                    }
                    .timeline-divider {
                        position: absolute;
                        top: 25px;
                        left: 0;
                        right: 0;
                        height: 2px;
                        background: #e5e7eb;
                        z-index: -1;
                    }
                </style>
                <div class="timeline-divider"></div>
                
                <div class="timeline-item {{ in_array($order->status, ['pending', 'confirmed', 'processing', 'packed', 'shipped', 'delivered']) ? 'completed' : 'pending' }}">
                    <div class="timeline-circle">1</div>
                    <div class="timeline-label">Đã đặt</div>
                </div>
                
                <div class="timeline-item {{ in_array($order->status, ['confirmed', 'processing', 'packed', 'shipped', 'delivered']) ? 'completed' : 'pending' }}">
                    <div class="timeline-circle">2</div>
                    <div class="timeline-label">Xác nhận</div>
                </div>
                
                <div class="timeline-item {{ in_array($order->status, ['processing', 'packed', 'shipped', 'delivered']) ? 'completed' : 'pending' }}">
                    <div class="timeline-circle">3</div>
                    <div class="timeline-label">Chuẩn bị</div>
                </div>
                
                <div class="timeline-item {{ in_array($order->status, ['shipped', 'delivered']) ? 'completed' : 'pending' }}">
                    <div class="timeline-circle">4</div>
                    <div class="timeline-label">Vận chuyển</div>
                </div>
                
                <div class="timeline-item {{ $order->status === 'delivered' ? 'completed' : 'pending' }}">
                    <div class="timeline-circle">5</div>
                    <div class="timeline-label">Hoàn tất</div>
                </div>
            </div>

            {{-- Status Description --}}
            <div style="background: #f3f4f6; border-left: 4px solid var(--color-secondary); padding: var(--spacing-lg); border-radius: 4px;">
                @switch($order->status)
                    @case('pending')
                        <p style="margin: 0; color: #374151;">
                            <strong>Chờ xác nhận</strong> - Đơn hàng của bạn đã được tạo và đang chờ xác nhận từ cửa hàng. 
                            Chúng tôi sẽ kiểm tra tồn kho và xác nhận trong vòng 1-2 giờ.
                        </p>
                    @break
                    @case('confirmed')
                        <p style="margin: 0; color: #374151;">
                            <strong>Đã xác nhận</strong> - Đơn hàng của bạn đã được xác nhận và tồn kho đủ. 
                            Chúng tôi đang chuẩn bị hàng để giao cho vận chuyển.
                        </p>
                    @break
                    @case('processing')
                        <p style="margin: 0; color: #374151;">
                            <strong>Đang chuẩn bị</strong> - Chúng tôi đang chuẩn bị và đóng gói hàng của bạn. 
                            Hàng sẽ được giao cho shipper trong vòng 1-2 ngày.
                        </p>
                    @break
                    @case('packed')
                        <p style="margin: 0; color: #374151;">
                            <strong>Chờ lấy hàng</strong> - Hàng đã được đóng gói và chờ shipper lấy. 
                            Bạn sẽ nhận được thông báo khi hàng được bàn giao.
                        </p>
                    @break
                    @case('shipped')
                        <p style="margin: 0; color: #374151;">
                            <strong>Đang giao</strong> - Hàng đã được bàn giao cho đơn vị vận chuyển. 
                            Bạn có thể theo dõi tình trạng vận chuyển qua shipper.
                        </p>
                    @break
                    @case('delivered')
                        <p style="margin: 0; color: #374151;">
                            <strong>Đã nhận hàng</strong> - Bạn đã xác nhận nhận hàng. Cảm ơn bạn đã mua sắm tại cửa hàng của chúng tôi!
                        </p>
                    @break
                    @case('cancelled')
                        <p style="margin: 0; color: #991b1b;">
                            <strong>Đã hủy</strong> - Đơn hàng đã bị hủy. 
                            @if ($order->notes)
                                Lý do: {{ $order->notes }}
                            @endif
                        </p>
                    @break
                @endswitch
            </div>
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
        @if ($order->status === 'shipped')
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">Hành động</h3>
                <form action="{{ route('orders.received', $order->id) }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" style="background: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                        ✓ Xác nhận đã nhận được hàng
                    </button>
                </form>
            </div>
        @endif

        @if (!in_array($order->status, ['delivered', 'cancelled', 'packed']))
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: var(--spacing-lg);">
                <h3 style="font-weight: 600; margin-bottom: var(--spacing-md);">Hành động khác</h3>
                @if ($order->payment && $order->payment->status === 'pending')
                    <a href="{{ route('orders.payment', $order->payment->id) }}" style="display: inline-block; background: var(--color-secondary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; margin-right: var(--spacing-md); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(212,175,55,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                        Hoàn tất thanh toán
                    </a>
                @endif
                @if (in_array($order->status, ['pending', 'confirmed', 'processing']))
                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 4px; font-weight: 500; cursor: pointer; transition: all 0.3s ease;" onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            ✕ Hủy đơn hàng
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
