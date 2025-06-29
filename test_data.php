<?php
define('ROOT_PATH', __DIR__);
require_once 'config/config.php';
require_once 'config/database.php';
require_once 'core/Database.php';

try {
    $db = Database::getInstance();
    
    // Xóa dữ liệu cũ
    $db->execute("SET FOREIGN_KEY_CHECKS=0");
    $db->execute("TRUNCATE TABLE story_category");
    $db->execute("TRUNCATE TABLE chapters");
    $db->execute("TRUNCATE TABLE stories");
    $db->execute("SET FOREIGN_KEY_CHECKS=1");
    echo "<p>✓ Đã xóa dữ liệu cũ thành công</p>";
    
    echo "<h2>Thêm dữ liệu mẫu cho testing...</h2>";
    
    // Thêm stories mẫu
    $stories = [
        [
            'title' => 'One Piece',
            'description' => 'Câu chuyện về Monkey D. Luffy và băng hải tặc Mũ Rơm trong hành trình tìm kiếm kho báu One Piece và trở thành Vua Hải Tặc.',
            'author' => 'Oda Eiichiro',
            'status' => 'ongoing',
            'views' => 1500000,
            'thumbnail' => '/assets/images/one-piece.jpg'
        ],
        [
            'title' => 'Naruto',
            'description' => 'Hành trình trở thành Hokage của Uzumaki Naruto, một ninja trẻ tuổi với ước mơ được mọi người công nhận.',
            'author' => 'Kishimoto Masashi',
            'status' => 'completed',
            'views' => 1200000,
            'thumbnail' => '/assets/images/naruto.jpg'
        ],
        [
            'title' => 'Dragon Ball',
            'description' => 'Hành trình tìm kiếm viên ngọc rồng của Son Goku và cuộc chiến bảo vệ Trái Đất.',
            'author' => 'Toriyama Akira',
            'status' => 'completed',
            'views' => 900000,
            'thumbnail' => null
        ],
        [
            'title' => 'Doraemon',
            'description' => 'Chú mèo máy từ tương lai giúp đỡ Nobita bằng những bảo bối thần kỳ trong cuộc sống hàng ngày.',
            'author' => 'Fujiko F. Fujio',
            'status' => 'ongoing',
            'views' => 800000,
            'thumbnail' => '/assets/images/Doraemon.jpg'
        ],
        [
            'title' => 'Shin - Cậu bé bút chì',
            'description' => 'Những câu chuyện hài hước về cậu bé Shin và gia đình trong cuộc sống thường ngày.',
            'author' => 'Usui Yoshito',
            'status' => 'ongoing',
            'views' => 600000,
            'thumbnail' => '/assets/images/shin.webp'
        ],
        [
            'title' => 'Bleach',
            'description' => 'Câu chuyện về Kurosaki Ichigo và thế giới Shinigami trong cuộc chiến chống lại Hollow.',
            'author' => 'Kubo Tite',
            'status' => 'completed',
            'views' => 750000,
            'thumbnail' => null
        ],
        [
            'title' => 'Attack on Titan',
            'description' => 'Câu chuyện về Eren Yeager và cuộc chiến chống lại những Titan khổng lồ để bảo vệ nhân loại.',
            'author' => 'Isayama Hajime',
            'status' => 'completed',
            'views' => 1100000,
            'thumbnail' => null
        ],
        [
            'title' => 'Demon Slayer',
            'description' => 'Câu chuyện về Tanjiro Kamado và cuộc hành trình tiêu diệt quỷ để cứu em gái Nezuko.',
            'author' => 'Gotouge Koyoharu',
            'status' => 'completed',
            'views' => 950000,
            'thumbnail' => null
        ],
        [
            'title' => 'My Hero Academia',
            'description' => 'Câu chuyện về Midoriya Izuku và hành trình trở thành siêu anh hùng số 1.',
            'author' => 'Horikoshi Kouhei',
            'status' => 'ongoing',
            'views' => 700000,
            'thumbnail' => null
        ],
        [
            'title' => 'Jujutsu Kaisen',
            'description' => 'Câu chuyện về Itadori Yuji và cuộc chiến chống lại những lời nguyền trong thế giới Jujutsu.',
            'author' => 'Akutami Gege',
            'status' => 'ongoing',
            'views' => 850000,
            'thumbnail' => null
        ],
        [
            'title' => 'Spy x Family',
            'description' => 'Câu chuyện về gia đình giả của điệp viên Twilight, sát thủ Yor và cô con gái có khả năng đọc suy nghĩ Anya.',
            'author' => 'Endou Tatsuya',
            'status' => 'ongoing',
            'views' => 500000,
            'thumbnail' => null
        ],
        [
            'title' => 'Chainsaw Man',
            'description' => 'Câu chuyện về Denji và cuộc sống của anh với Pochita, chú chó quỷ biến thành cưa xích.',
            'author' => 'Fujimoto Tatsuki',
            'status' => 'ongoing',
            'views' => 650000,
            'thumbnail' => null
        ]
    ];
    
    foreach ($stories as $story) {
        $db->execute("
            INSERT INTO stories (title, description, author, status, views, thumbnail) 
            VALUES (?, ?, ?, ?, ?, ?)
        ", [$story['title'], $story['description'], $story['author'], $story['status'], $story['views'], $story['thumbnail']]);
    }
    
    echo "<p>✓ Thêm " . count($stories) . " truyện mẫu thành công</p>";
    
    // Thêm chapters mẫu
    $chapters = [
        ['story_id' => 1, 'chapter_number' => 1, 'title' => 'Chương 1: Tôi sẽ trở thành Vua Hải Tặc'],
        ['story_id' => 1, 'chapter_number' => 2, 'title' => 'Chương 2: Họ xuất hiện'],
        ['story_id' => 2, 'chapter_number' => 1, 'title' => 'Chương 1: Uzumaki Naruto xuất hiện'],
        ['story_id' => 2, 'chapter_number' => 2, 'title' => 'Chương 2: Konohamaru'],
        ['story_id' => 3, 'chapter_number' => 1, 'title' => 'Chương 1: Bulma và Son Goku'],
        ['story_id' => 3, 'chapter_number' => 2, 'title' => 'Chương 2: Viên ngọc rồng'],
        ['story_id' => 4, 'chapter_number' => 1, 'title' => 'Chương 1: Doraemon đến'],
        ['story_id' => 4, 'chapter_number' => 2, 'title' => 'Chương 2: Bảo bối đầu tiên'],
        ['story_id' => 5, 'chapter_number' => 1, 'title' => 'Chương 1: Shin xuất hiện'],
        ['story_id' => 5, 'chapter_number' => 2, 'title' => 'Chương 2: Gia đình Shin'],
        ['story_id' => 6, 'chapter_number' => 1, 'title' => 'Chương 1: Kurosaki Ichigo'],
        ['story_id' => 6, 'chapter_number' => 2, 'title' => 'Chương 2: Rukia Kuchiki']
    ];
    
    foreach ($chapters as $chapter) {
        $db->execute("
            INSERT INTO chapters (story_id, chapter_number, title) 
            VALUES (?, ?, ?)
        ", [$chapter['story_id'], $chapter['chapter_number'], $chapter['title']]);
    }
    
    echo "<p>✓ Thêm " . count($chapters) . " chương mẫu thành công</p>";
    
    // Liên kết stories với categories
    $storyCategories = [
        [1, 1], [1, 2], // One Piece: Hành động, Phiêu lưu
        [2, 1], [2, 2], // Naruto: Hành động, Phiêu lưu
        [3, 1], [3, 2], // Dragon Ball: Hành động, Phiêu lưu
        [4, 3], [4, 8], // Doraemon: Hài hước, Đời thường
        [5, 3], [5, 8], // Shin: Hài hước, Đời thường
        [6, 1], [6, 2], // Bleach: Hành động, Phiêu lưu
        [7, 1], [7, 2], // Attack on Titan: Hành động, Phiêu lưu
        [8, 1], [8, 2], // Demon Slayer: Hành động, Phiêu lưu
        [9, 1], [9, 9], // My Hero Academia: Hành động, Thể thao
        [10, 1], [10, 6], // Jujutsu Kaisen: Hành động, Viễn tưởng
        [11, 3], [11, 8], // Spy x Family: Hài hước, Đời thường
        [12, 1], [12, 6] // Chainsaw Man: Hành động, Viễn tưởng
    ];
    
    foreach ($storyCategories as $sc) {
        $db->execute("
            INSERT INTO story_category (story_id, category_id) 
            VALUES (?, ?)
        ", $sc);
    }
    
    echo "<p>✓ Liên kết truyện với thể loại thành công</p>";
    
    echo "<h3 style='color: green;'>🎉 Thêm dữ liệu mẫu hoàn tất!</h3>";
    echo "<p><a href='index.php'>Về trang chủ</a></p>";
    
} catch (Exception $e) {
    echo "<h3 style='color: red;'>❌ Lỗi: " . $e->getMessage() . "</h3>";
}
?> 