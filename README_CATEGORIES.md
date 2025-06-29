# 📚 Quản lý Thể loại - Web Truyện Tranh

## 🎯 Tổng quan

Chức năng quản lý thể loại cho phép admin thêm, sửa, xóa các thể loại truyện trong hệ thống.

## 🏗️ Cấu trúc

### Controller
- **File**: `controllers/AdminCategoryController.php`
- **Chức năng**: Xử lý logic CRUD cho thể loại

### Views
- **Danh sách**: `views/admin/categories/index.php`
- **Thêm mới**: `views/admin/categories/create.php`
- **Sửa**: `views/admin/categories/edit.php`

### Routes
```php
/admin/categories              // Danh sách thể loại
/admin/categories/create       // Thêm thể loại mới
/admin/categories/edit/{id}    // Sửa thể loại
/admin/categories/delete/{id}  // Xóa thể loại
```

## 🚀 Cách sử dụng

### 1. Truy cập trang quản lý thể loại
- Đăng nhập admin
- Vào menu "Thể loại" trong sidebar
- Hoặc truy cập trực tiếp: `/admin/categories`

### 2. Thêm thể loại mới
1. Click nút "Thêm thể loại mới"
2. Nhập tên thể loại (ví dụ: Hành động, Tình cảm, Kinh dị...)
3. Click "Lưu thể loại"

### 3. Sửa thể loại
1. Click nút "Sửa" (biểu tượng bút chì) bên cạnh thể loại
2. Cập nhật tên thể loại
3. Click "Cập nhật thể loại"

### 4. Xóa thể loại
1. Click nút "Xóa" (biểu tượng thùng rác) bên cạnh thể loại
2. Xác nhận xóa trong hộp thoại
3. Hệ thống sẽ tự động xóa quan hệ với truyện

## ⚠️ Lưu ý quan trọng

### Validation
- Tên thể loại không được để trống
- Tên thể loại không được trùng lặp
- Tên thể loại sẽ được trim() để loại bỏ khoảng trắng

### Xóa thể loại
- Khi xóa thể loại, hệ thống sẽ tự động xóa tất cả quan hệ trong bảng `story_category`
- Điều này đảm bảo tính toàn vẹn dữ liệu
- Hành động xóa không thể hoàn tác

### Quan hệ với truyện
- Một truyện có thể thuộc nhiều thể loại
- Một thể loại có thể được gán cho nhiều truyện
- Quan hệ được lưu trong bảng `story_category`

## 🧪 Test

Chạy file `test_categories.php` để kiểm tra các chức năng:

```bash
# Truy cập trong trình duyệt
http://localhost/Truyen.net/test_categories.php
```

File test sẽ:
- Thêm các thể loại mẫu
- Hiển thị danh sách thể loại
- Test chức năng cập nhật
- Kiểm tra quan hệ với truyện

## 📊 Database Schema

### Bảng `categories`
```sql
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);
```

### Bảng `story_category` (quan hệ nhiều-nhiều)
```sql
CREATE TABLE story_category (
    story_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (story_id, category_id),
    FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);
```

## 🎨 Giao diện

### Tính năng UI/UX
- Responsive design với Bootstrap 5
- Icons từ Font Awesome
- Card layout với shadow và border radius
- Form validation với visual feedback
- Confirmation dialog cho hành động xóa
- Loading states và error handling

### Màu sắc và styling
- Primary: #667eea (gradient với #764ba2)
- Success: #28a745
- Warning: #ffc107
- Danger: #dc3545
- Info: #17a2b8

## 🔧 Troubleshooting

### Lỗi thường gặp

1. **"Thể loại này đã tồn tại"**
   - Kiểm tra tên thể loại đã nhập
   - Sử dụng tên khác hoặc sửa thể loại hiện có

2. **"Trường name là bắt buộc"**
   - Đảm bảo đã nhập tên thể loại
   - Không để trống trường input

3. **Lỗi database**
   - Kiểm tra kết nối database
   - Đảm bảo bảng `categories` đã được tạo
   - Kiểm tra quyền truy cập database

### Debug
- Bật error reporting trong `config/config.php`
- Kiểm tra log lỗi PHP
- Sử dụng `var_dump()` để debug dữ liệu

## 📈 Phát triển tương lai

### Tính năng có thể thêm
- Sắp xếp thể loại theo thứ tự
- Mô tả cho từng thể loại
- Icon cho thể loại
- Thống kê số truyện theo thể loại
- Import/Export thể loại
- Bulk actions (xóa nhiều thể loại cùng lúc)

### Tối ưu hóa
- Caching danh sách thể loại
- Pagination cho danh sách lớn
- Search và filter thể loại
- AJAX cho các thao tác CRUD 