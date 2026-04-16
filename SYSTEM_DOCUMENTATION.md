# Hệ Thống Đăng Nhập, Đăng Ký, Mua Bán & Thanh Toán

## 📋 Tổng Quan Hệ Thống

Hệ thống hoàn chỉnh bao gồm:
- **Đăng nhập/Đăng ký**: Người dùng có thể tạo tài khoản mới hoặc đăng nhập
- **Phân cấp người dùng**: User (thường), Staff (nhân viên), Admin (quản lý)
- **Giỏ hàng**: Thêm/xóa sản phẩm, quản lý số lượng
- **Đơn hàng**: Căn cứ vào tên đăng nhập, người dùng được chuyển hướng đến trang tương ứng
- **Thanh toán**: Hỗ trợ nhiều phương thức thanh toán trực tiếp, chuyển khoản, thẻ tín dụng, ví điện tử
- **Quản lý đơn hàng**: Staff xác nhận, xử lý, gửi hàng và hoàn tất
- **Báo cáo tồn kho**: Theo dõi bán hàng và xuất báo cáo

---

## 🔐 Phân Cấp & Quyền Hạn

### 1. **User (Người dùng thường)**
- Đăng ký tài khoản mới
- Đăng nhập bằng tên đăng nhập & mật khẩu
- Xem sản phẩm
- Thêm sản phẩm vào giỏ hàng
- Đặt hàng
- Thanh toán
- Xem lịch sử đơn hàng
- Hủy đơn hàng (nếu chưa xác nhận)
- **Redirect URL sau đăng nhập**: Trang chủ (/)

### 2. **Staff (Nhân viên)**
- Xem tất cả đơn hàng
- Xác nhận đơn hàng (pending → confirmed)
- Bắt đầu xử lý (confirmed → processing)
- Gửi hàng (processing → shipped)
- Hoàn tất giao hàng (shipped → delivered)
- Từ chối đơn hàng với lý do
- Xem báo cáo tồn kho
- Xuất báo cáo CSV
- **Redirect URL sau đăng nhập**: /staff/dashboard

### 3. **Admin (Quản lý cấp cao)**
- Tất cả quyền của Staff
- Quản lý sản phẩm
- Quản lý danh mục
- Quản lý hình ảnh sản phẩm
- **Redirect URL sau đăng nhập**: /admin/dashboard

---

## 📁 Cơ Sở Dữ Liệu (Database Schema)

### Bảng Users
```sql
- id (Primary Key)
- name (Tên)
- username (Tên đăng nhập, unique)
- email (Email, unique)
- password (Mật khẩu hash)
- role (enum: 'user', 'staff', 'admin') - DEFAULT: 'user'
- google_id (Nullable - cho OAuth Google)
- google_token (Nullable - cho OAuth Google)
- is_active (Boolean) - DEFAULT: true
- timestamps
```

### Bảng Carts
```sql
- id (Primary Key)
- user_id (Foreign Key → users)
- timestamps
```

### Bảng Cart Items
```sql
- id (Primary Key)
- cart_id (Foreign Key → carts)
- product_id (Foreign Key → products)
- quantity (Integer)
- timestamps
```

### Bảng Orders
```sql
- id (Primary Key)
- user_id (Foreign Key → users)
- total_amount (Decimal)
- status (enum: 'pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled')
- delivery_address (Text)
- phone (String)
- notes (Text, nullable)
- payment_id (Foreign Key → payments, nullable)
- timestamps
```

### Bảng Order Items
```sql
- id (Primary Key)
- order_id (Foreign Key → orders)
- product_id (Foreign Key → products)
- quantity (Integer)
- unit_price (Decimal)
- subtotal (Decimal)
- timestamps
```

### Bảng Payments
```sql
- id (Primary Key)
- order_id (Foreign Key → orders)
- transaction_id (String, unique)
- amount (Decimal)
- payment_method (enum: 'direct_payment', 'banking', 'credit_card', 'e_wallet')
- status (enum: 'pending', 'completed', 'failed', 'cancelled')
- response_data (Text, nullable - cho API response)
- paid_at (Timestamp, nullable)
- timestamps
```

---

## 🛣️ Routes & URLs

### Public Routes
```
GET  /                            - Trang chủ
GET  /products                    - Danh sách sản phẩm
GET  /products/{slug}             - Chi tiết sản phẩm
GET  /categories/{slug}           - Sản phẩm theo danh mục
GET  /brands/{brandSlug}          - Sản phẩm theo thương hiệu
GET  /inspiration                 - Bài viết cảm hứng
GET  /inspiration/{slug}          - Chi tiết bài viết
GET  /login                       - Form đăng nhập
POST /login                       - Xử lý đăng nhập
GET  /register                    - Form đăng ký
POST /register                    - Xử lý đăng ký
GET  /forgot-password             - Form quên mật khẩu
POST /logout                      - Đăng xuất
```

### User Routes (Require Auth)
```
GET  /cart                        - Xem giỏ hàng
POST /cart/add/{id}               - Thêm vào giỏ hàng
PATCH /cart/update/{itemId}       - Cập nhật số lượng
DELETE /cart/remove/{itemId}      - Xóa khỏi giỏ hàng
POST /cart/clear                  - Xóa toàn bộ giỏ hàng
GET  /cart/count                  - Số lượng giỏ hàng (AJAX)

GET  /orders                      - Danh sách đơn hàng của tôi
GET  /orders/{id}                 - Chi tiết đơn hàng
GET  /checkout                    - Form đặt hàng
POST /orders                      - Tạo đơn hàng
GET  /payment/{paymentId}         - Form thanh toán
POST /payment/{paymentId}/process - Xử lý thanh toán
POST /orders/{id}/cancel          - Hủy đơn hàng

GET  /change-password             - Đổi mật khẩu
POST /change-password             - Xử lý đổi mật khẩu
```

### Staff Routes (Require Staff Role)
```
GET  /staff                       - Dashboard nhân viên
GET  /staff/dashboard             - Dashboard nhân viên
GET  /staff/orders                - Danh sách đơn hàng
GET  /staff/orders/{id}           - Chi tiết đơn hàng
POST /staff/orders/{id}/confirm   - Xác nhận đơn hàng
POST /staff/orders/{id}/process   - Bắt đầu xử lý
POST /staff/orders/{id}/ship      - Gửi hàng
POST /staff/orders/{id}/deliver   - Hoàn tất giao hàng
POST /staff/orders/{id}/reject    - Từ chối đơn hàng
GET  /staff/inventory             - Báo cáo tồn kho
GET  /staff/inventory/export      - Xuất báo cáo CSV
```

### Admin Routes (Require Admin Role)
```
GET  /admin                       - Dashboard quản trị
POST /admin/products              - Quản lý sản phẩm
POST /admin/categories            - Quản lý danh mục
POST /admin/products/{id}/images  - Quản lý hình ảnh
... (tất cả quyền của Staff + Admin)
```

---

## 🔐 Middleware & Authorization

### Middleware đã tạo:
- `auth` - Yêu cầu đăng nhập
- `is_admin` - Chỉ cho phép Admin
- `is_staff` - Cho phép Staff và Admin

### Ví dụ sử dụng:
```php
Route::middleware(['auth', 'is_admin'])->group(function () {
    // Chỉ Admin có thể truy cập
});

Route::middleware(['auth', 'is_staff'])->group(function () {
    // Staff và Admin có thể truy cập
});
```

---

## 🛒 Quy Trình Mua Hàng

### Bước 1: Đăng ký/Đăng nhập
- User truy cập `/register` hoặc `/login`
- Nhập thông tin đăng ký (Tên, Tên đăng nhập, Email, Mật khẩu)
- Hệ thống tạo User với `role='user'` và tạo Cart
- Tự động đăng nhập và chuyển hướng đến trang chủ

### Bước 2: Thêm sản phẩm vào giỏ hàng
- User xem sản phẩm
- Nhấn "Thêm vào giỏ hàng"
- Hệ thống tạo CartItem
- Hiển thị thông báo thành công

### Bước 3: Xem giỏ hàng
- User truy cập `/cart`
- Có thể cập nhật số lượng hoặc xóa sản phẩm
- Tính toán tổng tiền

### Bước 4: Thanh toán
- User nhấn "Thanh toán"
- Điền địa chỉ giao hàng, số điện thoại, chọn phương thức thanh toán
- Hệ thống tạo Order và Payment
- Chuyển hướng đến trang thanh toán

### Bước 5: Xác nhận thanh toán
- Tùy theo phương thức:
  - **Direct Payment**: Xác nhận ngay
  - **Banking**: Hướng dẫn chuyển khoản
  - **Credit Card/E-wallet**: (Cần integrate)
- Order chuyển sang trạng thái `confirmed`

### Bước 6: Xác nhận & giao hàng (Staff)
- Staff đăng nhập và vào `/staff/dashboard`
- Xem danh sách đơn hàng chờ xác nhận
- Xác nhận → Bắt đầu xử lý → Gửi hàng → Hoàn tất

---

## 💳 Phương Thức Thanh Toán

### 1. Direct Payment (Thanh toán trực tiếp)
- Thanh toán khi nhận hàng hoặc chuyển khoản sau
- **Status flow**: pending → completed (ngay khi xác nhận)

### 2. Banking (Chuyển khoản)
- Yêu cầu khách chuyển khoản
- **Thông tin**:
  - Số tài khoản: (được cấu hình trong code)
  - Nội dung: DH{ORDER_ID}
  - Số tiền: {TOTAL_AMOUNT}₫
- **Status flow**: pending (choczạ nhận thanh toán từ khách)

### 3. Credit Card (Cần integrate)
- Placeholder cho Stripe, PayPal, 2Checkout
- **TODO**: Thêm payment gateway API

### 4. E-wallet (Cần integrate)
- Placeholder cho Momo, ZaloPay
- **TODO**: Thêm e-wallet API

---

## 📊 Order Status Flow

```
pending (Chờ xác nhận)
    ↓ (Staff xác nhận)
confirmed (Đã xác nhận)
    ↓ (Staff bắt đầu xử lý)
processing (Đang xử lý)
    ↓ (Staff gửi hàng)
shipped (Đã gửi)
    ↓ (Giao hàng hoàn tất)
delivered (Đã giao)

Hoặc tại bất kỳ bước nào:
    → cancelled (Đã hủy)
```

---

## 👥 Các Models & Relationships

```
User
  - has one Cart
  - has many Orders
  - has many Payments (through Orders)

Cart
  - belongs to User
  - has many CartItems
  - has many Products (through CartItems)

CartItem
  - belongs to Cart
  - belongs to Product

Product
  - has many CartItems
  - has many OrderItems
  - has many ProductImages
  - belongs to Category
  - belongs to Brand

Order
  - belongs to User
  - has many OrderItems
  - has one Payment
  - has many Products (through OrderItems)

OrderItem
  - belongs to Order
  - belongs to Product

Payment
  - belongs to Order
```

---

## 🧪 Cách Test Hệ Thống

### 1. Đăng ký User
```
GET http://localhost:8000/register
Nhập: Name, Username, Email, Password
POST /register
```

### 2. Đăng nhập
```
GET http://localhost:8000/login
POST /login (username + password)
→ Redirect to /
```

### 3. Thêm sản phẩm vào giỏ
```
GET /products (xem sản phẩm)
POST /cart/add/{productId}
```

### 4. Xem giỏ hàng
```
GET /cart
→ Xem danh sách CartItems
→ Có thể cập nhật số lượng hoặc xóa
```

### 5. Thanh toán
```
GET /checkout
POST /orders (địa chỉ + phương thức thanh toán)
→ Chuyển hướng /payment/{paymentId}
POST /payment/{paymentId}/process
→ Cập nhật status → confirmed
```

### 6. Xem đơn hàng
```
GET /orders (danh sách)
GET /orders/{id} (chi tiết)
```

### 7. Staff quản lý đơn hàng
```
Tạo user với role='staff' (manuallydatabase)
GET /staff/dashboard
GET /staff/orders
POST /staff/orders/{id}/confirm
POST /staff/orders/{id}/process
POST /staff/orders/{id}/ship
POST /staff/orders/{id}/deliver
```

---

## ⚙️ Cấu Hình & Tùy Chỉnh

### Tạo User Admin/Staff
```bash
# Chạy lệnh:
php artisan tinker

# Tạo Admin
App\Models\User::create([
    'name' => 'Admin',
    'username' => 'admin',
    'email' => 'admin@example.com',
    'password' => Hash::make('password123'),
    'role' => 'admin'
]);

# Tạo Staff
App\Models\User::create([
    'name' => 'Staff',
    'username' => 'staff',
    'email' => 'staff@example.com',
    'password' => Hash::make('password123'),
    'role' => 'staff'
]);
```

### Cấu hình Email (Quên mật khẩu)
```php
// .env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Your App"
```

### Cấu hình Payment Gateway (TODO)
```php
// app/Services/PaymentService.php
// Thêm credit card processor (Stripe)
// Thêm e-wallet processor (Momo, ZaloPay)
```

---

## 🔁 OAuth Google (TODO)

Chưa implement. Để thêm:

1. Cài Socialite:
```bash
composer require laravel/socialite
```

2. Cấu hình Google OAuth
3. Thêm routes cho Google callback
4. Update User model với google_id, google_token

---

## 🐛 Troubleshooting

### "Chỉ admin có thể truy cập"
- Kiểm tra role của user trong database
- `SELECT * FROM users WHERE username='xxx';`
- Cập nhật: `UPDATE users SET role='admin' WHERE id=1;`

### "Giỏ hàng không xuất hiện"
- Kiểm tra user có Cart không
- Tạo Cart: `App\Models\Cart::create(['user_id' => auth()->id()]);`

### "Thanh toán không thành công"
- Kiểm tra Payment record trong database
- Kiểm tra Order status

### "Không nhận được email quên mật khẩu"
- Kiểm tra MAIL_* config dalam .env
- Kiểm tra log: `storage/logs/laravel.log`

---

## 📝 Notes & Future Improvements

### Hiện tại đã implement:
✅ Registration & Login
✅ Role-based access control (User, Staff, Admin)
✅ Shopping cart management
✅ Order creation & management
✅ Payment processing (Direct & Banking)
✅ Staff order confirmation & tracking
✅ Inventory reporting
✅ Password reset via email

### Cần implement sau:
❌ OAuth Google login
❌ Credit card payment gateway (Stripe)
❌ E-wallet integration (Momo, ZaloPay)
❌ Order status notifications (Email/SMS)
❌ Real inventory stock management
❌ Refund & return process
❌ Rating & review system
❌ Shipping tracking
❌ Admin analytics dashboard

---

## 📞 Support Commands

```bash
# Clear cache
php artisan cache:clear

# Run migrations
php artisan migrate

# Seed database
php artisan db:seed

# Check routes
php artisan route:list

# Watch assets
npm run dev

# Build assets
npm run build
```

---

**Last Updated**: March 16, 2026
**Version**: 1.0
