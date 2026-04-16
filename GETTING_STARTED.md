# 🚀 Bắt Đầu Nhanh

## Setup Ban Đầu

### 1. Chạy Migrations
```bash
php artisan migrate
```

Các bảng được tạo:
- users (cập nhật: thêm role, google_id, is_active)
- carts
- cart_items
- orders
- order_items
- payments

### 2. Tạo Tài Khoản Test (Tùy chọn)

```bash
php artisan tinker

# Tạo Admin
$admin = App\Models\User::create([
    'name' => 'Admin Showroom',
    'username' => 'admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password123'),
    'role' => 'admin',
    'is_active' => true
]);
Cart::create(['user_id' => $admin->id]);

# Tạo Staff
$staff = App\Models\User::create([
    'name' => 'Nhân Viên',
    'username' => 'staff',
    'email' => 'staff@example.com',
    'password' => Hash::make('password123'),
    'role' => 'staff',
    'is_active' => true
]);
Cart::create(['user_id' => $staff->id]);

# Tạo User thường
$user = App\Models\User::create([
    'name' => 'Khách Hàng',
    'username' => 'user',
    'email' => 'user@example.com',
    'password' => Hash::make('password123'),
    'role' => 'user',
    'is_active' => true
]);
Cart::create(['user_id' => $user->id]);
```

### 3. Start Server
```bash
php artisan serve
```

### 4. Truy cập
```
http://localhost:8000
```

---

## 🔑 Login Test

### Admin
- URL: `/login`
- Username: `admin`
- Password: `password123`
- Redirect: `/admin/dashboard`

### Staff
- URL: `/login`
- Username: `staff`
- Password: `password123`
- Redirect: `/staff/dashboard`

### User
- URL: `/login`
- Username: `user`
- Password: `password123`
- Redirect: `/` (trang chủ)

---

## 🛍️ Quy Trình Đặt Hàng

### Bước 1: Đăng ký (Nếu chưa có tài khoản)
```
GET /register
Nhập thông tin → POST /register
```

### Bước 2: Xem Sản Phẩm & Thêm Vào Giỏ
```
GET /products
Chọn sản phẩm → POST /cart/add/{productId}
```

### Bước 3: Xem Giỏ Hàng
```
GET /cart
Cập nhật số lượng → PATCH /cart/update/{itemId}
```

### Bước 4: Thanh Toán
```
GET /checkout
Điền thông tin → POST /orders
→ Chuyển hướng /payment/{paymentId}
POST /payment/{paymentId}/process
```

### Bước 5: Xem Đơn Hàng
```
GET /orders (danh sách)
GET /orders/{id} (chi tiết)
```

---

## 👨‍💼 Quản Lý Đơn Hàng (Staff)

### Bước 1: Vào Dashboard
```
/staff/dashboard
```

### Bước 2: Quản Lý Đơn Hàng
```
GET /staff/orders (danh sách)
GET /staff/orders/{id} (chi tiết)

Hành động:
- Xác nhận: POST /staff/orders/{id}/confirm
- Xử lý: POST /staff/orders/{id}/process
- Gửi hàng: POST /staff/orders/{id}/ship
- Hoàn tất: POST /staff/orders/{id}/deliver
- Từ chối: POST /staff/orders/{id}/reject
```

### Bước 3: Báo Cáo Tồn Kho
```
GET /staff/inventory (xem báo cáo)
GET /staff/inventory/export (xuất CSV)
```

---

## 📊 Phương Thức Thanh Toán

Hiện tại hỗ trợ:
1. **Direct Payment** - Thanh toán trực tiếp
2. **Banking** - Chuyển khoản ngân hàng
3. **Credit Card** - Cần integrate (TODO)
4. **E-wallet** - Cần integrate (TODO)

---

## 🔗 URLs Quan Trọng

| Chức Năng | URL | Yêu Cầu |
|----------|-----|--------|
| Trang chủ | `/` | - |
| Danh sách sản phẩm | `/products` | - |
| Chi tiết sản phẩm | `/products/{slug}` | - |
| Đăng nhập | `/login` | - |
| Đăng ký | `/register` | - |
| Giỏ hàng | `/cart` | Đăng nhập |
| Thanh toán | `/checkout` | Đăng nhập + Có giỏ |
| Đơn hàng | `/orders` | Đăng nhập |
| Staff Dashboard | `/staff` | Staff/Admin |
| Quản lý đơn hàng | `/staff/orders` | Staff/Admin |
| Báo cáo tồn kho | `/staff/inventory` | Staff/Admin |
| Admin Dashboard | `/admin` | Admin |

---

## 🐛 Debug Tips

### Xem Users
```bash
php artisan tinker
App\Models\User::all();
```

### Xem Orders
```bash
App\Models\Order::with('user', 'payment')->latest()->get();
```

### Xem Carts
```bash
App\Models\Cart::with('items.product')->get();
```

### Clear Cache
```bash
php artisan cache:clear
php artisan view:clear
```

---

## 📧 Email Configuration (Optional)

Để gửi email quên mật khẩu, cấu hình `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## ✅ Checklist After Setup

- [ ] Database migrations chạy thành công
- [ ] Tạo test users (admin, staff, user)
- [ ] Test đăng nhập với 3 loại user
- [ ] Test thêm sản phẩm vào giỏ hàng
- [ ] Test đặt hàng
- [ ] Test staff quản lý đơn hàng
- [ ] Test báo cáo tồn kho

---

## 🎉 Ready!

Hệ thống đã sẵn sàng để sử dụng. Để hiểu thêm chi tiết, xem file `SYSTEM_DOCUMENTATION.md`.
