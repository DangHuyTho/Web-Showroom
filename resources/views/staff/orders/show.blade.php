@extends('staff.layouts.app')

@section('title', 'Chi tiết đơn hàng #' . $order->id)
@section('page-title', 'Chi Tiết Đơn Hàng #' . $order->id)

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
                        <!-- Pending Actions: Confirm or Cancel -->
                        <form action="{{ route('staff.orders.confirm', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                ✓ Xác nhận đơn hàng
                            </button>
                        </form>

                        <button onclick="showCancelModal()" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            ✕ Hủy đơn
                        </button>
                    @endif

                    @if ($order->status === 'confirmed')
                        <!-- Confirmed Actions: Process or Cancel -->
                        <form action="{{ route('staff.orders.process', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #8b5cf6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                📦 Bắt đầu chuẩn bị
                            </button>
                        </form>

                        <button onclick="showCancelModal()" style="background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            ✕ Hủy đơn
                        </button>
                    @endif

                    @if ($order->status === 'processing')
                        <!-- Processing Actions: Print Packing Slip, Mark as Packed -->
                        <a href="{{ route('staff.orders.print-packing-slip', $order->id) }}" target="_blank" style="background: #06b6d4; color: white; padding: 10px 20px; border: none; border-radius: 4px; text-decoration: none; cursor: pointer; font-weight: 500; transition: all 0.3s ease; display: inline-block;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                            🖨️ In vận đơn
                        </a>

                        <form action="{{ route('staff.orders.pack', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                ✓ Đã đóng gói
                            </button>
                        </form>
                    @endif

                    @if ($order->status === 'packed')
                        <!-- Packed Actions: Handover to Shipper -->
                        <form action="{{ route('staff.orders.handover', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="background: #8b5cf6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                🚚 Bàn giao vận chuyển
                            </button>
                        </form>
                    @endif

                    @if ($order->status === 'shipped')
                        <!-- Shipped Actions: Mark as Delivered -->
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

        <!-- Cancel Modal -->
        <div id="cancelModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; flex-direction: column;">
            <div style="background: white; border-radius: 8px; padding: var(--spacing-lg); max-width: 400px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                <h3 style="margin-top: 0; margin-bottom: var(--spacing-md); color: #374151;">Hủy đơn hàng</h3>
                <form action="{{ route('staff.orders.cancel', $order->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: var(--spacing-md);">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #374151;">Lý do hủy:</label>
                        <textarea name="reason" required style="width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 4px; font-family: inherit;" rows="3" placeholder="Nhập lý do hủy đơn hàng..."></textarea>
                    </div>
                    <div style="display: flex; gap: var(--spacing-md);">
                        <button type="submit" style="flex: 1; background: #ef4444; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500;">
                            Xác nhận hủy
                        </button>
                        <button type="button" onclick="closeCancelModal()" style="flex: 1; background: #6b7280; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-weight: 500;">
                            Đóng
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function showCancelModal() {
                document.getElementById('cancelModal').style.display = 'flex';
            }

            function closeCancelModal() {
                document.getElementById('cancelModal').style.display = 'none';
            }

            document.getElementById('cancelModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeCancelModal();
                }
            });
        </script>

        <!-- Back Button -->
        <a href="{{ route('staff.orders.index') }}" style="display: inline-block; background: var(--color-primary); color: white; padding: 10px 20px; border-radius: 4px; text-decoration: none; font-weight: 500; transition: all 0.3s ease;" onmouseover="this.style.background='var(--color-primary-dark)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--color-primary)'; this.style.transform='translateY(0)'">
            ← Quay lại
        </a>
    </div>
</div>
@endsection
