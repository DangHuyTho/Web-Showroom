@component('mail::message')
# 🚚 Đơn Hàng Đang Giao

Xin chào {{ $customer->name }},

Đơn hàng **#{{ $order->id }}** của bạn đã được **bàn giao cho đơn vị vận chuyển**!

**Thông tin đơn hàng:**
- **Số đơn:** #{{ $order->id }}
- **Tổng tiền:** {{ number_format($order->total_amount) }}₫
- **Trạng thái:** 🚚 Đang giao
- **Giao đến:** {{ $order->delivery_address }}
- **SĐT:** {{ $order->phone }}

---

## ✓ Hàng Đã Được Gửi

Hàng của bạn đang trên đường đến. Vui lòng chuẩn bị để nhận hàng.

**Vui lòng xác nhận** khi bạn nhận được hàng bằng cách click vào nút dưới đây.

@component('mail::button', ['url' => route('orders.show', $order->id)])
Xem Chi Tiết Đơn Hàng
@endcomponent

---

Cảm ơn bạn đã đặt hàng tại **Hộ Nhâm**!

@endcomponent
