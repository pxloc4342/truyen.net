<?php
// Script tự động tạo database và bảng
echo "<h2>Đang cài đặt database cho Web Truyện Tranh...</h2>";

try {
    // Kết nối MySQL (không chọn database)
    $pdo = new PDO('mysql:host=localhost', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    
    echo "<p>✓ Kết nối MySQL thành công</p>";
    
    // Tạo database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS webtruyentranh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p>✓ Tạo database 'webtruyentranh' thành công</p>";
    
    // Chọn database
    $pdo->exec("USE webtruyentranh");
    
    // Tạo bảng stories
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS stories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            description TEXT,
            author VARCHAR(100),
            thumbnail VARCHAR(255),
            status ENUM('ongoing', 'completed', 'hiatus') DEFAULT 'ongoing',
            views INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "<p>✓ Tạo bảng 'stories' thành công</p>";
    
    // Tạo bảng categories
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL UNIQUE
        )
    ");
    echo "<p>✓ Tạo bảng 'categories' thành công</p>";
    
    // Tạo bảng story_category
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS story_category (
            story_id INT NOT NULL,
            category_id INT NOT NULL,
            PRIMARY KEY (story_id, category_id),
            FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
            FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
        )
    ");
    echo "<p>✓ Tạo bảng 'story_category' thành công</p>";
    
    // Tạo bảng chapters
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS chapters (
            id INT AUTO_INCREMENT PRIMARY KEY,
            story_id INT NOT NULL,
            chapter_number DECIMAL(10,2) NOT NULL,
            title VARCHAR(255),
            content TEXT,
            views INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (story_id) REFERENCES stories(id) ON DELETE CASCADE,
            UNIQUE KEY unique_story_chapter (story_id, chapter_number)
        )
    ");
    echo "<p>✓ Tạo bảng 'chapters' thành công</p>";
    
    // Tạo bảng admins
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS admins (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "<p>✓ Tạo bảng 'admins' thành công</p>";
    
    // Tạo bảng users
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");
    echo "<p>✓ Tạo bảng 'users' thành công</p>";
    
    // Thêm dữ liệu mẫu
    $categories = ['Hành động', 'Phiêu lưu', 'Hài hước', 'Tình cảm', 'Kinh dị'];
    foreach ($categories as $category) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO categories (name) VALUES (?)");
        $stmt->execute([$category]);
    }
    echo "<p>✓ Thêm dữ liệu categories thành công</p>";
    
    // Thêm truyện mẫu
    $stories = [
        ['One Piece', 'Câu chuyện về Monkey D. Luffy và băng hải tặc Mũ Rơm', 'Eiichiro Oda'],
        ['Naruto', 'Câu chuyện về Uzumaki Naruto, một ninja trẻ tuổi', 'Masashi Kishimoto'],
        ['Dragon Ball', 'Câu chuyện về Goku và những cuộc phiêu lưu', 'Akira Toriyama']
    ];
    
    foreach ($stories as $story) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO stories (title, description, author) VALUES (?, ?, ?)");
        $stmt->execute($story);
    }
    echo "<p>✓ Thêm dữ liệu stories thành công</p>";
    
    // Thêm chapters mẫu
    $chapters = [
        [1, 1, 'Tôi là Luffy!'],
        [1, 2, 'Họ xuất hiện!'],
        [2, 1, 'Uzumaki Naruto xuất hiện!'],
        [2, 2, 'Konohamaru!'],
        [3, 1, 'Bulma và Goku']
    ];
    
    foreach ($chapters as $chapter) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO chapters (story_id, chapter_number, title) VALUES (?, ?, ?)");
        $stmt->execute($chapter);
    }
    echo "<p>✓ Thêm dữ liệu chapters thành công</p>";
    
    // Thêm admin mặc định (password: password)
    $adminPassword = password_hash('password', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT IGNORE INTO admins (username, password, email) VALUES (?, ?, ?)");
    $stmt->execute(['admin', $adminPassword, 'admin@example.com']);
    echo "<p>✓ Tạo admin mặc định thành công</p>";
    
    echo "<h3 style='color: green;'>🎉 Cài đặt database hoàn tất!</h3>";
    echo "<p><strong>Thông tin đăng nhập admin:</strong></p>";
    echo "<p>Username: <strong>admin</strong></p>";
    echo "<p>Password: <strong>password</strong></p>";
    echo "<p><a href='index.php'>Về trang chủ</a></p>";
    
} catch (PDOException $e) {
    echo "<h3 style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</h3>";
    echo "<p>Hãy kiểm tra:</p>";
    echo "<ul>";
    echo "<li>XAMPP đã được khởi động chưa?</li>";
    echo "<li>MySQL service đã chạy chưa?</li>";
    echo "<li>Username và password MySQL có đúng không?</li>";
    echo "</ul>";
}
?> 