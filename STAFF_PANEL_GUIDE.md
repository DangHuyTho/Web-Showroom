# 📊 Staff Panel Guide

## 🎯 Giới Thiệu
Staff Panel là một dashboard quản lý hoàn chỉnh dành cho nhân viên kho/warehouse, cho phép quản lý đơn hàng, kho hàng, và xem báo cáo.

## 🚀 Cách Truy Cập

### URL
```
https://your-domain.com/staff
hoặc
https://your-domain.com/staff/dashboard
```

### Yêu Cầu
- Phải đăng nhập (auth middleware)
- Phải có role **staff** (is_staff middleware)

---

## 📑 Cấu Trúc Layout

### Sidebar Navigation
```
✓ Dashboard
├── 📦 Quản lý đơn hàng
├── 🏭 Quản lý kho hàng
├── 📊 Báo cáo tồn kho
├── 🏠 Về trang chủ
└── Đăng xuất
```

### Top Bar
- **Page Title** - Tên trang hiện tại
- **Date/Time** - Ngày giờ hiện tại
- **User Info** - Tên & username
- **Logout Button** - Đăng xuất

---

## 📊 Dashboard Tổng Quan

Hiển thị 5 chỉ số chính về đơn hàng:

| Chỉ Số | Mô Tả |
|--------|-------|
| ⏳ Chờ xác nhận | Đơn mới chưa xác nhận stock |
| ✓ Đã xác nhận | Đơn đã xác nhận, chờ chuẩn bị |
| ⚙️ Đang chuẩn bị | Đơn đang lấy/đóng gói |
| 📤 Chờ lấy hàng | Đơn đã đóng, chờ shipper |
| 📋 Tổng đơn hàng | Tất cả đơn |

### Inventory Statistics (4 chỉ số)
- **📦 Tổng sản phẩm** → Link tới Quản lý kho
- **💰 Giá trị tồn kho** → Link tới Báo cáo
- **⚠️ Tồn kho thấp** → 5 sản phẩm cần nhập
- **🚫 Hết hàng** → Sản phẩm hết ngay

### Recent Orders Table
Hiển thị 10 đơn hàng mới nhất với status badge

---

## 📦 Quản Lý Đơn Hàng

### URL: `/staff/orders`

### Chức Năng
- **Search** - Tìm theo ID, tên khách, SĐT
- **Filter by Status** - Lọc theo trạng thái
- **Pagination** - 15 đơn hàng/trang

### Trạng Thái Đơn Hàng

```
pending (Chờ xác nhận)
    ↓ Nhấn "Xác nhận" → Kiểm kho → Trừ stock
confirmed (Đã xác nhận)
    ↓ Nhấn "Bắt đầu chuẩn bị"
processing (Đang chuẩn bị)
    ↓ In vận đơn & "Đã đóng gói"
packed (Chờ lấy hàng)
    ↓ "Bàn giao vận chuyển"
shipped (Đã gửi)
    ↓ "Giao hàng hoàn tất"
delivered (Đã giao)
    ✓ Hoàn thành
```

### Chi Tiết Đơn Hàng (`/staff/orders/{id}`)

**Thông tin hiển thị:**
- Trạng thái đơn hàng (status badge)
- Thông tin khách hàng
- Thông tin thanh toán
- Địa chỉ giao hàng
- Danh sách sản phẩm với SKU & số lượng
- **Hành động** theo từng trạng thái (xem chi tiết dưới)

### Hành Động Theo Trạng Thái

#### 1. **pending** (Chờ xác nhận)
```
Nhấn: ✓ Xác nhận đơn hàng
  → Kiểm tra tồn kho
  → Nếu không đủ: hiển thị lỗi + danh sách thiếu
  → Nếu đủ: Confirm + Trừ kho tự động
  
Hoặc: ✕ Hủy đơn
  → Nhập lý do hủy (required)
  → Hủy (không ảnh hưởng kho)
```

#### 2. **confirmed** (Đã xác nhận)
```
Nhấn: 📦 Bắt đầu chuẩn bị
  → Chuyển sang "processing"
  → Ready để pick & pack
  
Hoặc: ✕ Hủy đơn
  → Nhập lý do (required)
  → Hủy + Khôi phục kho
```

#### 3. **processing** (Đang chuẩn bị)
```
Nhấn: 🖨️ In vận đơn
  → Mở PDF (target="_blank")
  → Xem thông tin khách, danh sách sản phẩm + VỊ TRÍ KỆ
  → In hoặc in PDF
  
Sau khi đóng gói xong → Nhấn: ✓ Đã đóng gói
  → Chuyển sang "packed"
  → Đảnh dấu packed_at timestamp
```

#### 4. **packed** (Chờ lấy hàng)
```
Khi shipper đến → Nhấn: 🚚 Bàn giao vận chuyển
  → Chuyển sang "shipped"
  → Đánh dấu shipped_at timestamp
```

#### 5. **shipped** (Đã gửi)
```
Khi hàng được giao → Nhấn: ✓ Giao hàng hoàn tất
  → Chuyển sang "delivered"
  → Đánh dấu delivered_at timestamp
  → Đơn hoàn thành
```

---

## 🏭 Quản Lý Kho Hàng

### URL: `/staff/inventory`

### Tính Năng
- **Search** - Tìm theo tên sản phẩm / SKU
- **Filters**:
  - Thương hiệu (Brand)
  - Loại (Category)
  - Trạng thái tồn kho (Đầy đủ/Thấp/Hết)
- **Pagination** - 20 sản phẩm/trang

### Bảng Tồn Kho (8 cột)

| Cột | Mô Tả |
|-----|-------|
| 📦 Sản phẩm | Tên sản phẩm (bold) |
| 🏪 Thương hiệu | Tên brand |
| 🆔 SKU | Mã sản phẩm (monospace) |
| 📍 Vị trí kệ | Vị trí lưu trữ (A1, B2-3, etc.) |
| 📊 Tồn kho | Số lượng hiện tại |
| ⚠️ Tối thiểu | Ngưỡng cảnh báo |
| 🎨 Trạng thái | Badge màu |
| ✏️ Hành động | Nút Edit |

### Trạng Thái Tồn Kho

```
🟢 Xanh "Đầy đủ"     → quantity > min_stock
🟡 Vàng "Thấp"      → 0 < quantity ≤ min_stock
🔴 Đỏ "Hết hàng"    → quantity = 0
```

### Cập Nhật Tồn Kho (`/staff/inventory/{id}/edit`)

**Form chính:**
- **Vị trí kệ** (Shelf Location)
  - Ví dụ: A1, B2-3, Kệ 5
  - Dùng cho picking (vận đơn)
- **Số lượng tồn kho**
  - Hiển thị màu theo trạng thái
  - Auto-update status badge
- **Số tối thiểu cảnh báo**
  - Trigger "Thấp" khi ≤ giá trị này
- **Ghi chú** (Tùy chọn)
  - Lý do cập nhật

**Form điều chỉnh nhanh** (Quick Adjust)
```
Số lượng | Lý do (Nhập/Hư/Trả/Khác) | Ghi chú | Nút
```
- Nhập hàng → action_type: stock_in
- Hư hỏng → action_type: damage
- Trả lại → action_type: return
- Khác → action_type: adjustment

### Lịch Sử Tồn Kho (Inventory History)

Bảng chi tiết 20 dòng log gần nhất:

| Cột | Mô Tả |
|-----|-------|
| ⏰ Thời gian | Khi nào |
| 🎯 Hành động | Loại (stock_in/sale/damage/etc.) |
| 📈 Thay đổi | +10 hoặc -5 (mã màu) |
| 🔄 Trước/Sau | 50 → 60 |
| 👤 Nhân viên | Tên user thực hiện |
| 📝 Ghi chú | Chi tiết thêm |

**Màu sắc hành động:**
- 🟢 stock_in (Nhập) - xanh
- 🟢 sale (Bán) - xanh
- 🔴 damage (Hư) - đỏ
- 🔴 stock_out (Xuất) - đỏ
- 🟡 adjustment (Điều chỉnh) - vàng
- ⚫ return (Trả) - xám

---

## 📊 Báo Cáo Tồn Kho

### URL: `/staff/inventory/report`

### Thống Kê Tổng Hợp (4 stat cards)

| Chỉ Số | Mô Tả |
|--------|-------|
| 📦 Tổng số lượng | SUM(quantity) |
| 💰 Giá trị tồn kho | SUM(quantity × price) |
| 🔴 Hết hàng | Sản phẩm có quantity = 0 |
| 🟡 Tồn kho thấp | Sản phẩm có quantity ≤ min_stock |

### Danh Sách Sản Phẩm Hết Hàng

- Bảng với cột: Sản phẩm | Thương hiệu | SKU | Hành động (Cập nhật)
- Đỏ (#fee2e2) để dễ nhận biết
- Click "Cập nhật" → `/inventory/{id}/edit`

### Danh Sách Tồn Kho Thấp

- Bảng với cột: Sản phẩm | Thương hiệu | Tồn kho/Tối thiểu | Hành động
- Vàng (#fef3c7) để cảnh báo
- Click "Cập nhật" → `/inventory/{id}/edit`

---

## 🔐 Permissions & Security

### Middleware
```php
['auth', 'is_staff']
```

### Yêu cầu
- Phải có account với `role = 'staff'` hoặc `is_staff = true`
- Nếu không, redirect đến home page

---

## 🎨 Design System

### CSS Variables (trong layout)
```css
--color-primary: #1a1a1a (đen)
--color-secondary: #d4af37 (vàng)
--color-accent: #f5f5f0 (trắng)
--spacing-xs: 0.25rem
--spacing-md: 0.5rem
--spacing-lg: 1rem
```

### Status Badge Colors
- **pending**: Yellow (#fef3c7)
- **confirmed**: Blue (#dbeafe)
- **processing**: Purple (#f3e8ff)
- **packed**: Cyan (#cffafe)
- **shipped**: Teal (#ccfbf1)
- **delivered**: Green (#dcfce7)
- **cancelled**: Red (#fee2e2)

---

## 📝 Workflow Ví Dụ

### Xử lý đơn hàng mới

**Scenario:** Khách hàng mua 2 chiếc áo (tồn kho: 5 cái)

```
1. Dashboard → Thấy 1 đơn "Chờ xác nhận"
2. Click "Chi tiết" → Xem đơn #123
3. Click "Xác nhận đơn hàng"
   → Hệ thống check: Có 5 cái, cần 2 cái ✓
   → Status: pending → confirmed
   → Tồn kho: 5 → 3
   → InventoryLog: {action: sale, qty: -2}
4. Click "Bắt đầu chuẩn bị"
   → Status: confirmed → processing
5. Click "In vận đơn"
   → PDF với customer info + 2 áo (vị trí kệ: A5)
6. Staff lấy từ kệ A5, đóng gói
7. Click "Đã đóng gói"
   → Status: processing → packed
   → packed_at = now()
8. Shipper đến, click "Bàn giao vận chuyển"
   → Status: packed → shipped
   → shipped_at = now()
9. Shipper giao hàng, click "Giao hàng hoàn tất"
   → Status: shipped → delivered
   → delivered_at = now()
   → ✓ Đơn hoàn thành
```

---

## 🆘 Troubleshooting

### "Access Denied" khi vào /staff
**Nguyên nhân:** User không có role staff
**Giải pháp:** Admin phải approve verification request hoặc set is_staff = true

### "Không đủ hàng" khi xác nhận
**Nguyên nhân:** Sản phẩm đã hết hoặc quantity < order quantity
**Giải pháp:** 
1. Click "Chi tiết" để xem cần bao nhiêu
2. Vào Quản lý kho → Cập nhật tồn kho
3. Thử xác nhận lại

### Vị trí kệ không hiển thị trên vận đơn
**Nguyên nhân:** Chưa nhập shelf_location cho sản phẩm
**Giải pháp:**
1. Vào Quản lý kho
2. Edit sản phẩm → Nhập vị trí kệ (A1, B2, etc.)
3. Save → In vận đơn sẽ hiển thị

### Lịch sử tồn kho không update
**Nguyên nhân:** Điều chỉnh được log nhưng cache chưa refresh
**Giải pháp:** F5 refresh hoặc clear browser cache

---

## 📞 Support

Nếu gặp vấn đề:
1. Kiểm tra logs: `storage/logs/laravel.log`
2. Verify database: Check `orders`, `products`, `inventory_logs` tables
3. Check auth: Verify user role và permissions

---

**Last Updated:** April 21, 2026  
**Version:** 1.0
