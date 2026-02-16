# Admin Panel - Quick Start Guide

## 🚀 Cách Truy Cập Admin Panel

### URLs Chính
- **Dashboard**: `http://localhost:8000/admin`
- **Danh Mục**: `http://localhost:8000/admin/categories`
- **Sản Phẩm**: `http://localhost:8000/admin/products`

## 📋 Tính Năng Chính

### 1. Dashboard (`/admin`)
Trang tổng quan với:
- 📊 Tổng số sản phẩm
- ✅ Sản phẩm hoạt động
- 📁 Số danh mục
- 🏢 Số thương hiệu
- 📝 Danh sách 5 sản phẩm mới nhất

### 2. Quản Lý Danh Mục (`/admin/categories`)

**Xem danh sách:**
```
GET /admin/categories
```

**Tạo danh mục mới:**
```
GET  /admin/categories/create
POST /admin/categories
```

**Sửa danh mục:**
```
GET  /admin/categories/{id}/edit
PUT  /admin/categories/{id}
```

**Xóa danh mục:**
```
DELETE /admin/categories/{id}
```

**Bật/Tắt danh mục:**
```
PATCH /admin/categories/{id}/toggle-active
```

### 3. Quản Lý Sản Phẩm (`/admin/products`)

**Xem danh sách:**
```
GET /admin/products
```

**Tạo sản phẩm mới:**
```
GET  /admin/products/create
POST /admin/products
```

**Sửa sản phẩm:**
```
GET  /admin/products/{id}/edit
PUT  /admin/products/{id}
```

**Xóa sản phẩm:**
```
DELETE /admin/products/{id}
```

**Bật/Tắt sản phẩm:**
```
PATCH /admin/products/{id}/toggle-active
```

## 📝 Biểu Mẫu (Forms)

### Tạo/Sửa Danh Mục

| Field | Type | Bắt Buộc | Ghi Chú |
|-------|------|----------|--------|
| name | text | ✅ | Tên danh mục |
| slug | text | ✅ | URL-friendly, tự động tạo |
| type | select | ✅ | product hay inspiration |
| parent_id | select | ❌ | Danh mục cha |
| description | textarea | ❌ | Mô tả chi tiết |
| icon | text | ❌ | Font Awesome class |
| sort_order | number | ❌ | Thứ tự sắp xếp |
| is_active | checkbox | ❌ | Kích hoạt danh mục |

### Tạo/Sửa Sản Phẩm

#### Bắt Buộc
| Field | Type | Ghi Chú |
|-------|------|--------|
| name | text | Tên sản phẩm |
| slug | text | URL-friendly, tự động tạo |
| sku | text | Mã định danh duy nhất |
| price | number | Giá bán (đơn vị: VNĐ) |
| category_id | select | Chọn danh mục |
| brand_id | select | Chọn thương hiệu |

#### Tùy Chọn - Mô Tả
| Field | Type | Ghi Chú |
|-------|------|--------|
| short_description | textarea | Tóm tắt |
| description | textarea | Mô tả chi tiết |

#### Tùy Chọn - Chi Tiết Kỹ Thuật
| Field | Type | Ghi Chú |
|-------|------|--------|
| unit | text | Đơn vị: m², cái, tấm... |
| material | text | Loại vật liệu |
| size | text | Kích thước |
| surface_type | text | Bề mặt: bóng, mờ, sần... |
| water_absorption | text | Độ hút nước |
| hardness | text | Độ cứng |
| glaze_technology | text | Công nghệ phủ men |
| sort_order | number | Thứ tự sắp xếp |

#### Tùy Chọn - Trạng Thái
| Field | Type | Ghi Chú |
|-------|------|--------|
| is_active | checkbox | Kích hoạt sản phẩm |
| is_featured | checkbox | Sản phẩm nổi bật |

## 🔍 Tìm Kiếm và Lọc

### Danh Mục
- Tìm kiếm theo tên

### Sản Phẩm
- Tìm theo tên hoặc SKU
- Lọc theo danh mục
- Lọc theo thương hiệu

## 📊 Phân Trang

- **Danh mục**: 20 item/trang
- **Sản phẩm**: 15 item/trang

## ✨ Tính Năng Thông Minh

### Auto-generate Slug
- Tự động tạo slug từ tên
- Loại bỏ ký tự đặc biệt
- Chuyển thành chữ thường
- Thay khoảng trắng bằng dấu gạch ngang

### Validation
- Kiểm tra slug duy nhất
- Kiểm tra SKU duy nhất
- Kiểm tra trường bắt buộc
- Giới hạn độ dài trường

### UI/UX
- Thông báo thành công/lỗi
- Xác nhận trước khi xóa
- Highlight hàng khi hover
- Sidebar dẫn hướng

## 🛠️ Cấu Trúc File

```
app/Http/Controllers/Admin/
├── DashboardController.php
├── ProductController.php
└── CategoryController.php

resources/views/admin/
├── layouts/
│   └── app.blade.php
├── dashboard.blade.php
├── categories/
│   ├── index.blade.php
│   ├── create.blade.php
│   └── edit.blade.php
└── products/
    ├── index.blade.php
    ├── create.blade.php
    └── edit.blade.php
```

## 🐛 Troubleshooting

### "Không tìm thấy trang"
- Kiểm tra URL chính xác
- Đảm bảo server Laravel đang chạy

### Lỗi Validation
- Kiểm tra tất cả trường bắt buộc
- Slug/SKU phải duy nhất
- Slug/SKU chỉ chứa chữ cái, số, dấu gạch ngang

### Slug không tự động tạo
- Kiểm tra JavaScript đã load
- Nhấp ra ngoài trường tên để kích hoạt

## 📞 Hỗ Trợ

Để biết thêm chi tiết, xem: `ADMIN_GUIDE.md`
