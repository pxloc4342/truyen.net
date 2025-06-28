-- Tạo database
CREATE DATABASE IF NOT EXISTS webtruyentranh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE webtruyentranh;

-- Bảng stories (truyện)
CREATE TABLE stories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    author VARCHAR(100),
    thumbnail VARCHAR(255),
    status ENUM('ongoing', 'completed', 'hiatus') DEFAULT 'ongoing',
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng categories (thể loại)
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE
);

-- Bảng story_category (quan hệ nhiều-nhiều)
CREATE TABLE story_category (
    story_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (story_id, category_id),
    FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Bảng chapters (chương)
CREATE TABLE chapters (
    id INT AUTO_INCREMENT PRIMARY KEY,
    story_id INT NOT NULL,
    chapter_number DECIMAL(10,2) NOT NULL,
    title VARCHAR(255),
    content TEXT,
    views INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_story_chapter (story_id, chapter_number)
);

-- Bảng admins (quản trị viên)
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng users (người dùng)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Thêm dữ liệu mẫu
INSERT INTO categories (name) VALUES 
('Hành động'), ('Phiêu lưu'), ('Hài hước'), ('Tình cảm'), ('Kinh dị');

INSERT INTO stories (title, description, author) VALUES 
('One Piece', 'Câu chuyện về Monkey D. Luffy', 'Eiichiro Oda'),
('Naruto', 'Câu chuyện về Uzumaki Naruto', 'Masashi Kishimoto');

INSERT INTO chapters (story_id, chapter_number, title) VALUES 
(1, 1, 'Tôi là Luffy!'),
(1, 2, 'Họ xuất hiện!'),
(2, 1, 'Uzumaki Naruto xuất hiện!');

INSERT INTO story_category (story_id, category_id) VALUES 
(1, 1), (1, 2), (2, 1);

-- Tạo admin mặc định (password: password)
INSERT INTO admins (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@example.com'); 