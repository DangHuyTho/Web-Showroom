@component('mail::message')
# ✓ Đơn Hàng Đã Xác Nhận

Xin chào {{ $customer->name }},

Đơn hàng **#{{ $order->id }}** của bạn đã được **xác nhận** và tồn kho đủ!

**Thông tin đơn hàng:**
- **Số đơn:** #{{ $order->id }}
- **Tổng tiền:** {{ number_format($order->total_amount) }}₫
- **Trạng thái:** ⚙️ Đang chuẩn bị
- **Giao đến:** {{ $order->delivery_address }}
- **SĐT:** {{ $order->phone }}

**Chi tiết sản phẩm:**
@foreach($order->items as $item)
- {{ $item->product->name }} x{{ $item->quantity }} = {{ number_format($item->subtotal) }}₫
@endforeach

---

## ⏳ Bước Tiếp Theo

Chúng tôi đang chuẩn bị và đóng gói hàng của bạn. Hàng sẽ được giao cho shipper trong vòng **1-2 ngày**.

Bạn sẽ nhận được thông báo tiếp theo khi hàng được bàn giao vận chuyển.

---

Cảm ơn bạn đã đặt hàng tại **Hộ Nhâm**!

@endcomponent
