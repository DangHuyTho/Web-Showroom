# ARCHIVED_FILES - Documentation

Thư mục này chứa các file không ảnh hưởng đến việc chạy ứng dụng web.
Được tổ chức vào ngày 14/02/2026.

## Cấu Trúc

### REPORTS/
Chứa các file báo cáo DATN (Thesis Reports) dưới dạng:
- **Word Documents (.docx)**: Báo cáo hoàn chỉnh và các phiên bản
- **Markdown (.md)**: Báo cáo dưới dạng Markdown

**Nội dung:**
- BAO_CAO_DATN.docx - Báo cáo DATN phiên bản 1
- BAO_CAO_DATN_FINAL.docx - Báo cáo DATN phiên bản final
- BAO_CAO_DATN_NEW.docx - Báo cáo DATN phiên bản mới
- BAO_CAO_DATN_V2_COMPLETE.docx - Báo cáo DATN phiên bản 2 hoàn chỉnh
- CHUONG_5_KET_LUAN.docx - Chương 5: Kết luận (Conclusion)
- CHUONG_5_KET_LUAN_VA_HUONG_PHAT_TRIEN.docx - Chương 5: Kết luận và Hướng phát triển
- BAO_CAO_DATN_PHAN_1.md - Báo cáo DATN phần 1 (Markdown)
- CHUONG_5_KET_LUAN_VA_HUONG_PHAT_TRIEN.md - Chương 5 (Markdown)

### ADMIN_DOCS/
Chứa các tài liệu hướng dẫn quản trị (Admin Guides):
- ADMIN_GUIDE.md - Hướng dẫn quản trị chung
- ADMIN_QUICK_START.md - Hướng dẫn nhanh cho Admin
- ADMIN_SETUP.md - Hướng dẫn thiết lập cho Admin

### UTILITY_SCRIPTS/
Chứa các PHP script utility dùng cho:
- Data checking (check_*.php): Kiểm tra dữ liệu
- Data classification (classify_*.php): Phân loại sản phẩm
- Data fixing (fix_*.php): Sửa dữ liệu
- Data conversion (convert_*.php): Chuyển đổi dữ liệu
- Data scraping (scraper.php): Tạo dữ liệu
- Data verification (verify_*.php): Xác minh dữ liệu
- Data updating (update_*.php): Cập nhật dữ liệu
- Testing (test_*.php): Test các thành phần

**Tổng số files:** 29 PHP scripts

### CONVERTERS/
Chứa các Python script dùng để chuyển đổi định dạng:
- convert_md_to_docx.py - Chuyển Markdown sang Word
- convert_to_word.py - Chuyển file sang Word format
- convert_v2.py - Converter phiên bản 2
- convert_webp_to_jpg.py - Chuyển WebP sang JPG

## Tại sao những file này được archive?

1. **Không ảnh hưởng đến ứng dụng web**: Tất cả những file này là:
   - Báo cáo và tài liệu (không phục vụ chức năng web)
   - Utility scripts để xử lý/testing dữ liệu (đã sử dụng, không cần hàng ngày)
   - Converter scripts (already executed, không còn cần)

2. **Giữ project sạch sẽ**: Thư mục root của project sẽ gọn gàng hơn

3. **Dễ bảo trì**: Các file cần thiết cho ứng dụng web nằm ở root level:
   - app/ (ứng dụng chính)
   - config/ (cấu hình)
   - database/ (migration, seeder)
   - public/ (public files)
   - resources/ (views, CSS, JS)
   - routes/ (định tuyến)
   - storage/ (lưu trữ)
   - tests/ (test cases)

## Khi nào dùng những file này?

- **REPORTS/**: Khi cần tham khảo báo cáo DATN
- **ADMIN_DOCS/**: Khi cần hướng dẫn thiết lập/quản trị admin
- **UTILITY_SCRIPTS/**: Nếu cần chạy lại data processing (hiếm khi)
- **CONVERTERS/**: Nếu cần convert file (hiếm khi)

---

**Ngày archive:** 14/02/2026
**Mục đích:** Dọn dẹp project, giữ nó gọn gàng và easy to maintain
