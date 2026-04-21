@component('mail::message')
# ✓ Đơn Hàng Đã Được Giao

Xin chào {{ $customer->name }},

Cảm ơn bạn đã xác nhận **nhận hàng**! Đơn hàng **#{{ $order->id }}** của bạn đã **hoàn tất**.

**Thông tin đơn hàng:**
- **Số đơn:** #{{ $order->id }}
- **Tổng tiền:** {{ number_format($order->total_amount) }}₫
- **Trạng thái:** ✓ Đã nhận hàng
- **Giao đến:** {{ $order->delivery_address }}

**Chi tiết sản phẩm:**
@foreach($order->items as $item)
- {{ $item->product->name }} x{{ $item->quantity }} = {{ number_format($item->subtotal) }}₫
@endforeach

---

## ⭐ Vui Lòng Để Lại Đánh Giá

Để giúp chúng tôi cải thiện dịch vụ, vui lòng để lại **đánh giá và bình luận** về sản phẩm bạn vừa nhận.

@component('mail::button', ['url' => route('orders.show', $order->id)])
Để Lại Đánh Giá
@endcomponent

---

Cảm ơn bạn đã tin tưởng và ủng hộ **Hộ Nhâm**!

Chúng tôi mong được phục vụ bạn lần tới. 💙

@endcomponent
