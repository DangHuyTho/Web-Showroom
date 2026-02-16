# Admin Panel Guide - Hộ Nhâm Showroom

## Giới thiệu
Trang admin quản lý đầy đủ cho website showroom vật liệu xây dựng cao cấp. Cung cấp các tính năng quản lý danh mục sản phẩm và thông tin các mặt hàng.

## Truy cập Admin Panel
- **URL**: `http://localhost:8000/admin` hoặc `http://localhost:8000/admin/dashboard`
- **Dashboard**: Trang tổng quan với các thống kê chính

## Các Chức Năng Chính

### 1. Dashboard (`/admin` hoặc `/admin/dashboard`)
- **Tổng sản phẩm**: Hiển thị tổng số sản phẩm có trong hệ thống
- **Sản phẩm hoạt động**: Số lượng sản phẩm đang kích hoạt
- **Danh mục**: Tổng số danh mục sản phẩm
- **Thương hiệu**: Tổng số thương hiệu
- **Sản phẩm gần đây**: Danh sách 5 sản phẩm được tạo mới nhất

### 2. Quản lý Danh mục (`/admin/categories`)

#### Danh sách danh mục
- Xem tất cả các danh mục sản phẩm
- Tìm kiếm danh mục theo tên
- Sắp xếp theo thứ tự
- Hiển thị loại danh mục (product/inspiration)
- Xem danh mục cha (nếu có)

#### Tạo danh mục mới
- **Tên danh mục** (bắt buộc): Tên đầy đủ của danh mục
- **Slug** (bắt buộc): Đường dẫn thân thiện với URL (tự động tạo từ tên)
- **Loại danh mục** (bắt buộc): Chọn "Sản phẩm" hoặc "Cảm hứng"
- **Danh mục cha** (tùy chọn): Chọn danh mục cha nếu là danh mục con
- **Mô tả** (tùy chọn): Mô tả chi tiết về danh mục
- **Icon** (tùy chọn): Tên class Font Awesome (VD: fas fa-cube)
- **Thứ tự sắp xếp** (tùy chọn): Số thứ tự hiển thị (mặc định: 0)
- **Kích hoạt danh mục**: Checkbox để bật/tắt

#### Sửa danh mục
- Chỉnh sửa bất kỳ trường nào của danh mục
- Slug sẽ kiểm tra tính duy nhất (loại trừ danh mục hiện tại)

#### Xóa danh mục
- Không thể xóa danh mục di chuyển sang danh mục cha (nếu có)
- Xóa sẽ xóa vĩnh viễn

#### Toggle trạng thái
- Nhấp vào nút trạng thái để bật/tắt danh mục
- Danh mục không hoạt động sẽ không hiển thị trên website khách

### 3. Quản lý Sản phẩm (`/admin/products`)

#### Danh sách sản phẩm
- Xem tất cả sản phẩm với phân trang (15 sản phẩm/trang)
- **Tìm kiếm**: Theo tên sản phẩm hoặc SKU
- **Lọc theo danh mục**: Chọn danh mục cụ thể
- **Lọc theo thương hiệu**: Chọn thương hiệu cụ thể
- Hiển thị thông tin: Tên, SKU, Danh mục, Thương hiệu, Giá, Trạng thái

#### Tạo sản phẩm mới

**Thông tin cơ bản:**
- **Tên sản phẩm** (bắt buộc): Tên đầy đủ sản phẩm
- **Slug** (bắt buộc): Đường dẫn thân thiện (tự động tạo)
- **SKU** (bắt buộc): Mã SKU duy nhất
- **Giá** (bắt buộc): Giá bán (đơn vị: VNĐ)
- **Danh mục** (bắt buộc): Chọn danh mục
- **Thương hiệu** (bắt buộc): Chọn thương hiệu

**Mô tả:**
- **Mô tả ngắn** (tùy chọn): Tóm tắt sản phẩm
- **Mô tả chi tiết** (tùy chọn): Mô tả chi tiết và đầy đủ

**Thông tin chi tiết:**
- **Đơn vị tính**: VD: m², cái, tấm, ...
- **Vật liệu**: Loại vật liệu
- **Kích thước**: VD: 60x60cm, 30x60cm, ...
- **Loại bề mặt**: Bóng, mờ, sần, ...
- **Độ hút nước**: VD: < 0.5%, ...
- **Độ cứng**: VD: PEI 4, PEI 3, ...
- **Công nghệ phủ men**: Mô tả công nghệ
- **Thứ tự sắp xếp**: Số thứ tự hiển thị

**Trạng thái:**
- **Kích hoạt sản phẩm**: Bật để hiển thị trên website
- **Sản phẩm nổi bật**: Bật để đưa vào danh sách sản phẩm nổi bật

#### Sửa sản phẩm
- Chỉnh sửa mọi thông tin sản phẩm
- Slug và SKU sẽ kiểm tra tính duy nhất (loại trừ sản phẩm hiện tại)

#### Xóa sản phẩm
- Xóa vĩnh viễn sản phẩm khỏi hệ thống

#### Toggle trạng thái
- Nhanh chóng bật/tắt sản phẩm mà không cần vào trang sửa

## Ghi chú Quan trọng

### Slug (Đường dẫn thân thiện)
- Slug được tự động tạo từ tên sản phẩm/danh mục
- Chỉ bao gồm chữ cái, số, dấu gạch ngang
- Phải duy nhất (không trùng lặp)
- VD: "Gạch men sứ cao cấp" → "gach-men-su-cao-cap"

### Thứ tự hiển thị
- Sắp xếp theo số thứ tự tăng dần
- Số nhỏ hơn hiển thị trước
- Nếu không nhập, mặc định là 0

### Trạng thái hoạt động
- Chỉ sản phẩm/danh mục có trạng thái "Hoạt động" mới hiển thị trên website khách
- Danh mục không hoạt động sẽ ẩn tất cả sản phẩm trong danh mục

### SKU sản phẩm
- Mã định danh duy nhất cho mỗi sản phẩm
- Không thể trùng lặp
- Có thể sử dụng để quản lý kho hàng

### Danh mục cha/con
- Danh mục có thể có danh mục cha để tạo cấu trúc theo cấp bậc
- Không thể xóa danh mục có danh mục con hoặc có sản phẩm

## Thiết kế UI/UX
- **Thanh bên trái (Sidebar)**: Điều hướng chính
- **Thanh trên**: Hiển thị tiêu đề trang và thời gian hiện tại
- **Nội dung chính**: Hiển thị form hoặc bảng dữ liệu
- **Thông báo**: Hiển thị thông báo thành công/lỗi tại đầu trang
- **Phân trang**: Tại cuối danh sách dữ liệu

## Hướng dẫn Sử dụng Từng Bước

### Thêm một danh mục sản phẩm mới
1. Truy cập: `/admin/categories`
2. Nhấp: "+ Thêm danh mục mới"
3. Điền thông tin danh mục
4. Nhấp: "Tạo danh mục"

### Thêm một sản phẩm mới
1. Truy cập: `/admin/products`
2. Nhấp: "+ Thêm sản phẩm"
3. Điền tất cả thông tin bắt buộc (Tên, SKU, Giá, Danh mục, Thương hiệu)
4. Điền mô tả và thông tin chi tiết (tùy chọn)
5. Nhấp: "Tạo sản phẩm"

### Tìm kiếm sản phẩm
1. Truy cập: `/admin/products`
2. Nhập tên sản phẩm hoặc SKU
3. Chọn danh mục hoặc thương hiệu (tùy chọn)
4. Nhấp: "Tìm kiếm"

### Sửa sản phẩm
1. Truy cập: `/admin/products`
2. Nhấp: "Sửa" trên sàng phẩm muốn chỉnh sửa
3. Thay đổi thông tin
4. Nhấp: "Cập nhật sản phẩm"

### Xóa sản phẩm
1. Truy cập: `/admin/products`
2. Nhấp: "Xóa" trên sản phẩm muốn xóa
3. Xác nhận xóa trong hộp thoại

## Lỗi Thường Gặp

### "Danh mục đã tồn tại"
- Slug của danh mục đã được sử dụng
- Thử sử dụng slug khác

### "Không thể xóa danh mục"
- Danh mục có sản phẩm
- Xóa tất cả sản phẩm trong danh mục trước

### "SKU đã tồn tại"
- SKU được sử dụng bởi sản phẩm khác
- Sử dụng SKU khác

## Hỗ Trợ
Nếu gặp bất kỳ vấn đề nào, vui lòng liên hệ với bộ phận hỗ trợ kỹ thuật.
