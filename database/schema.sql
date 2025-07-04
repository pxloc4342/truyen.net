-- Database schema cho Web Truyện Tranh
-- Tạo database
CREATE DATABASE IF NOT EXISTS WebTruyenTranh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE WebTruyenTranh;

-- Bảng stories (truyện)
CREATE TABLE stories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    author VARCHAR(100),
    thumbnail VARCHAR(255),
    status ENUM('ongoing', 'completed', 'hiatus') DEFAULT 'ongoing',
    views INT DEFAULT 0,
    rating DECIMAL(3,2) DEFAULT 0.00,
    total_rating INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_title (title),
    INDEX idx_status (status),
    INDEX idx_views (views),
    INDEX idx_created_at (created_at)
);

-- Bảng categories (thể loại)
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_name (name)
);

-- Bảng story_category (quan hệ nhiều-nhiều giữa truyện và thể loại)
CREATE TABLE story_category (
    story_id INT NOT NULL,
    category_id INT NOT NULL,
    PRIMARY KEY (story_id, category_id),
    FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_story_id (story_id),
    INDEX idx_category_id (category_id)
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
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_story_chapter (story_id, chapter_number),
    INDEX idx_story_id (story_id),
    INDEX idx_chapter_number (chapter_number),
    INDEX idx_created_at (created_at)
);

-- Bảng chapter_images (ảnh trong chapter)
CREATE TABLE chapter_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    chapter_id INT NOT NULL,
    image_url VARCHAR(500) NOT NULL,
    image_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (chapter_id) REFERENCES chapters(id) ON DELETE CASCADE,
    INDEX idx_chapter_id (chapter_id),
    INDEX idx_image_order (image_order)
);

-- Bảng admins (quản trị viên)
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    full_name VARCHAR(100),
    role ENUM('super_admin', 'admin', 'moderator') DEFAULT 'admin',
    is_active BOOLEAN DEFAULT TRUE,
    last_login TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_username (username),
    INDEX idx_email (email)
);

-- Bảng users (người dùng)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng user_favorites (truyện yêu thích của user)
CREATE TABLE user_favorites (
    user_id INT NOT NULL,
    story_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id, story_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_story_id (story_id)
);

-- Bảng user_reading_history (lịch sử đọc)
CREATE TABLE user_reading_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    story_id INT NOT NULL,
    chapter_id INT NOT NULL,
    read_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    FOREIGN KEY (chapter_id) REFERENCES chapters(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_story_id (story_id),
    INDEX idx_read_at (read_at)
);

-- Bảng comments (bình luận)
CREATE TABLE comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    story_id INT NOT NULL,
    chapter_id INT NULL,
    parent_id INT NULL,
    content TEXT NOT NULL,
    is_approved BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    FOREIGN KEY (chapter_id) REFERENCES chapters(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_id) REFERENCES comments(id) ON DELETE CASCADE,
    INDEX idx_story_id (story_id),
    INDEX idx_chapter_id (chapter_id),
    INDEX idx_user_id (user_id),
    INDEX idx_created_at (created_at)
);

-- Bảng ratings (đánh giá)
CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    story_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_story_rating (user_id, story_id),
    INDEX idx_story_id (story_id),
    INDEX idx_user_id (user_id)
);

-- Thêm dữ liệu mẫu cho categories
INSERT INTO categories (name, description) VALUES
('Hành động', 'Truyện có nhiều cảnh hành động, chiến đấu'),
('Phiêu lưu', 'Truyện về những cuộc phiêu lưu, khám phá'),
('Hài hước', 'Truyện vui nhộn, hài hước'),
('Tình cảm', 'Truyện về tình yêu, tình cảm'),
('Kinh dị', 'Truyện kinh dị, ma quái'),
('Viễn tưởng', 'Truyện khoa học viễn tưởng'),
('Fantasy', 'Truyện thần thoại, phép thuật'),
('Đời thường', 'Truyện về cuộc sống hàng ngày'),
('Thể thao', 'Truyện về thể thao, thi đấu'),
('Trinh thám', 'Truyện trinh thám, điều tra');

-- Thêm admin mặc định
INSERT INTO admins (username, password, email, full_name, role) VALUES
('admin', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@webtruyentranh.com', 'Administrator', 'super_admin');

-- Thêm dữ liệu mẫu cho stories
INSERT INTO stories (title, description, author, status) VALUES
('One Piece', 'Câu chuyện về Monkey D. Luffy và băng hải tặc Mũ Rơm trong hành trình tìm kiếm kho báu One Piece', 'Eiichiro Oda', 'ongoing'),
('Naruto', 'Câu chuyện về Uzumaki Naruto, một ninja trẻ tuổi với ước mơ trở thành Hokage', 'Masashi Kishimoto', 'completed'),
('Dragon Ball', 'Câu chuyện về Goku và những cuộc phiêu lưu của anh trong việc bảo vệ Trái Đất', 'Akira Toriyama', 'completed'),
('Attack on Titan', 'Câu chuyện về Eren Yeager và cuộc chiến chống lại những Titan khổng lồ', 'Hajime Isayama', 'completed'),
('Demon Slayer', 'Câu chuyện về Tanjiro Kamado và cuộc hành trình tiêu diệt quỷ để cứu em gái', 'Koyoharu Gotouge', 'completed');

-- Thêm dữ liệu mẫu cho chapters
INSERT INTO chapters (story_id, chapter_number, title) VALUES
(1, 1, 'Tôi là Luffy!'),
(1, 2, 'Họ xuất hiện!'),
(2, 1, 'Uzumaki Naruto xuất hiện!'),
(2, 2, 'Konohamaru!'),
(3, 1, 'Bulma và Goku'),
(3, 2, 'Không ai đánh bại được Goku'),
(4, 1, 'Đến với loài người, Titan xuất hiện'),
(4, 2, 'Ngày đó, loài người nhớ lại'),
(5, 1, 'Tàn nhẫn'),
(5, 2, 'Gia đình Kamado');

-- Liên kết stories với categories
INSERT INTO story_category (story_id, category_id) VALUES
(1, 1), (1, 2), (1, 7), -- One Piece: Hành động, Phiêu lưu, Fantasy
(2, 1), (2, 7), (2, 4), -- Naruto: Hành động, Fantasy, Tình cảm
(3, 1), (3, 2), (3, 7), -- Dragon Ball: Hành động, Phiêu lưu, Fantasy
(4, 1), (4, 5), (4, 7), -- Attack on Titan: Hành động, Kinh dị, Fantasy
(5, 1), (5, 5), (5, 7); -- Demon Slayer: Hành động, Kinh dị, Fantasy 