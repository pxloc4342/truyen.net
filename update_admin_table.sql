-- Cập nhật bảng admins để thêm cột last_login
USE webtruyentranh;

-- Thêm cột last_login vào bảng admins
ALTER TABLE admins ADD COLUMN last_login TIMESTAMP NULL AFTER email;

-- Cập nhật admin mặc định với password mới (password: password)
UPDATE admins SET 
    password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    email = 'admin@example.com'
WHERE username = 'admin';

-- Nếu chưa có admin, tạo mới
INSERT IGNORE INTO admins (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com'); 