<?php
// File demo để test giao diện trang chủ
// Truy cập: http://localhost/Truyen.net/demo_homepage.php

// Define ROOT_PATH
define('ROOT_PATH', __DIR__);

// Load cấu hình
require_once 'config/database.php';
require_once 'config/config.php';
require_once 'core/Database.php';

// Initialize database
$db = new Database();

// Dữ liệu mẫu cho demo
$demoData = [
    'totalStories' => 156,
    'totalChapters' => 1247,
    'totalUsers' => 892,
    'totalViews' => 45678,
    
    'featuredStories' => [
        [
            'id' => 1,
            'title' => 'One Piece',
            'author' => 'Oda Eiichiro',
            'description' => 'Câu chuyện về Monkey D. Luffy và băng hải tặc Mũ Rơm trong hành trình tìm kiếm kho báu One Piece và trở thành Vua Hải Tặc.',
            'thumbnail' => '/assets/images/one-piece.jpg',
            'status' => 'ongoing',
            'views' => 1500000,
            'chapter_count' => 1089
        ],
        [
            'id' => 2,
            'title' => 'Naruto',
            'author' => 'Kishimoto Masashi',
            'description' => 'Hành trình trở thành Hokage của Uzumaki Naruto, một ninja trẻ tuổi với ước mơ lớn.',
            'thumbnail' => '/assets/images/naruto.jpg',
            'status' => 'completed',
            'views' => 12850
        ],
        [
            'id' => 3,
            'title' => 'Dragon Ball Super',
            'author' => 'Akira Toriyama',
            'description' => 'Tiếp tục câu chuyện của Son Goku và các chiến binh Z trong những cuộc phiêu lưu mới.',
            'thumbnail' => '/assets/images/Doraemon.jpg',
            'status' => 'ongoing',
            'views' => 9870
        ],
        [
            'id' => 4,
            'title' => 'Attack on Titan',
            'author' => 'Hajime Isayama',
            'description' => 'Cuộc chiến của loài người chống lại những Titan khổng lồ để bảo vệ sự tồn tại.',
            'thumbnail' => '/assets/images/shin.webp',
            'status' => 'completed',
            'views' => 11230
        ]
    ],
    
    'latestStories' => [
        [
            'id' => 5,
            'title' => 'Demon Slayer',
            'author' => 'Koyoharu Gotouge',
            'description' => 'Câu chuyện về Tanjiro Kamado, một thanh niên trở thành diệt quỷ để cứu em gái.',
            'thumbnail' => '/assets/images/cover_1751178281_3304.jpg',
            'status' => 'ongoing',
            'views' => 8760
        ],
        [
            'id' => 6,
            'title' => 'My Hero Academia',
            'author' => 'Kohei Horikoshi',
            'description' => 'Thế giới nơi mọi người đều có siêu năng lực và câu chuyện về Izuku Midoriya.',
            'thumbnail' => null,
            'status' => 'ongoing',
            'views' => 6540
        ],
        [
            'id' => 7,
            'title' => 'Jujutsu Kaisen',
            'author' => 'Gege Akutami',
            'description' => 'Thế giới của những pháp sư Jujutsu và cuộc chiến chống lại lũ quỷ.',
            'thumbnail' => null,
            'status' => 'ongoing',
            'views' => 5430
        ],
        [
            'id' => 8,
            'title' => 'Black Clover',
            'author' => 'Yuki Tabata',
            'description' => 'Câu chuyện về Asta, một cậu bé không có phép thuật nhưng muốn trở thành Ma Vương.',
            'thumbnail' => null,
            'status' => 'ongoing',
            'views' => 4320
        ]
    ],
    
    'popularCategories' => [
        ['id' => 1, 'name' => 'Hành động', 'story_count' => 45],
        ['id' => 2, 'name' => 'Phiêu lưu', 'story_count' => 38],
        ['id' => 3, 'name' => 'Tình cảm', 'story_count' => 32],
        ['id' => 4, 'name' => 'Hài hước', 'story_count' => 28],
        ['id' => 5, 'name' => 'Kinh dị', 'story_count' => 25],
        ['id' => 6, 'name' => 'Thể thao', 'story_count' => 22],
        ['id' => 7, 'name' => 'Trường học', 'story_count' => 20],
        ['id' => 8, 'name' => 'Siêu nhiên', 'story_count' => 18]
    ]
];

// Simulate database queries
$totalStories = $demoData['totalStories'];
$totalChapters = $demoData['totalChapters'];
$totalUsers = $demoData['totalUsers'];
$totalViews = $demoData['totalViews'];
$featuredStories = $demoData['featuredStories'];
$latestStories = $demoData['latestStories'];
$popularCategories = $demoData['popularCategories'];

// Start output buffering
ob_start();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo - Trang chủ Web Truyện Tranh</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand fw-bold text-primary" href="#">
                    <i class="fas fa-book-open me-2"></i><?= APP_NAME ?>
                </a>
                
                <!-- Mobile Toggle -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <!-- Navigation -->
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-home me-1"></i>Trang chủ
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-tags me-1"></i>Thể loại
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Hành động</a></li>
                                <li><a class="dropdown-item" href="#">Phiêu lưu</a></li>
                                <li><a class="dropdown-item" href="#">Tình cảm</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Xem tất cả</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-book me-1"></i>Tất cả truyện
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Search Bar -->
                    <form class="d-flex me-3" method="GET" action="#">
                        <div class="input-group">
                            <input class="form-control" type="search" name="q" placeholder="Tìm kiếm truyện..." value="">
                            <button class="btn btn-outline-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- User Menu -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-user-plus me-1"></i>Đăng ký
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h1 class="mb-4">Khám phá thế giới truyện tranh</h1>
                        <p class="mb-4">Hàng nghìn bộ truyện hay, cập nhật liên tục. Thỏa mãn đam mê đọc truyện của bạn!</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="#" class="btn btn-light btn-lg px-4">
                                <i class="fas fa-book me-2"></i>Xem tất cả truyện
                            </a>
                            <a href="#" class="btn btn-outline-light btn-lg px-4">
                                <i class="fas fa-tags me-2"></i>Thể loại
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-5 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="stats-card">
                            <div class="icon bg-gradient-primary">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="number"><?= number_format($totalStories) ?></div>
                            <div class="label">Truyện</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="stats-card">
                            <div class="icon" style="background: #28a745;">
                                <i class="fas fa-list"></i>
                            </div>
                            <div class="number"><?= number_format($totalChapters) ?></div>
                            <div class="label">Chương</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="stats-card">
                            <div class="icon" style="background: #ffc107;">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="number"><?= number_format($totalUsers) ?></div>
                            <div class="label">Người dùng</div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-4">
                        <div class="stats-card">
                            <div class="icon" style="background: #17a2b8;">
                                <i class="fas fa-eye"></i>
                            </div>
                            <div class="number"><?= number_format($totalViews) ?></div>
                            <div class="label">Lượt xem</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Stories Slider -->
        <section class="py-5">
            <div class="container">
                <div class="section-header">
                    <h2>Truyện nổi bật</h2>
                    <p>Những bộ truyện được yêu thích nhất</p>
                </div>
                
                <div class="featured-slider">
                    <div class="swiper featured-swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($featuredStories as $story): ?>
                            <div class="swiper-slide">
                                <div class="story-card">
                                    <?php if ($story['thumbnail']): ?>
                                        <img src="<?= APP_URL . $story['thumbnail'] ?>" 
                                             class="card-img-top" 
                                             alt="<?= htmlspecialchars($story['title']) ?>">
                                    <?php else: ?>
                                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                            <i class="fas fa-image fa-3x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="card-body">
                                        <h5 class="card-title"><?= htmlspecialchars($story['title']) ?></h5>
                                        <p class="author">
                                            <i class="fas fa-user me-1"></i><?= htmlspecialchars($story['author']) ?>
                                        </p>
                                        <p class="card-text">
                                            <?= htmlspecialchars(substr($story['description'], 0, 100)) ?>...
                                        </p>
                                        <div class="category-pills">
                                            <a href="#" class="category-pill">Hành động</a>
                                            <a href="#" class="category-pill">Phiêu lưu</a>
                                            <a href="#" class="category-pill">Tình cảm</a>
                                        </div>
                                        <a href="#" class="btn btn-primary w-100">
                                            <i class="fas fa-book-open me-2"></i>Đọc ngay
                                        </a>
                                    </div>
                                    
                                    <div class="status-badge status-<?= $story['status'] ?>">
                                        <?php
                                        $statusText = [
                                            'ongoing' => 'Đang ra',
                                            'completed' => 'Full',
                                            'hiatus' => 'Tạm ngưng'
                                        ];
                                        echo $statusText[$story['status']] ?? 'Đang ra';
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Latest Stories -->
        <section class="py-5 bg-light">
            <div class="container">
                <div class="section-header">
                    <h2>Truyện mới cập nhật</h2>
                    <p>Những chương mới nhất vừa được đăng</p>
                </div>
                
                <div class="row">
                    <?php foreach ($latestStories as $story): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="story-card">
                            <?php if ($story['thumbnail']): ?>
                                <img src="<?= APP_URL . $story['thumbnail'] ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($story['title']) ?>">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($story['title']) ?></h5>
                                <p class="author">
                                    <i class="fas fa-user me-1"></i><?= htmlspecialchars($story['author']) ?>
                                </p>
                                <p class="card-text">
                                    <?= htmlspecialchars(substr($story['description'], 0, 80)) ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="#" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-book-open me-1"></i>Đọc
                                    </a>
                                    <small class="text-muted">
                                        <i class="fas fa-eye me-1"></i><?= number_format($story['views']) ?>
                                    </small>
                                </div>
                            </div>
                            
                            <div class="status-badge status-<?= $story['status'] ?>">
                                <?php
                                $statusText = [
                                    'ongoing' => 'Đang ra',
                                    'completed' => 'Full',
                                    'hiatus' => 'Tạm ngưng'
                                ];
                                echo $statusText[$story['status']] ?? 'Đang ra';
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="text-center mt-4">
                    <a href="#" class="btn btn-primary btn-lg">
                        <i class="fas fa-list me-2"></i>Xem tất cả truyện
                    </a>
                </div>
            </div>
        </section>

        <!-- Categories Section -->
        <section class="py-5">
            <div class="container">
                <div class="section-header">
                    <h2>Thể loại phổ biến</h2>
                    <p>Khám phá truyện theo thể loại yêu thích</p>
                </div>
                
                <div class="row">
                    <?php foreach ($popularCategories as $category): ?>
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                        <a href="#" class="text-decoration-none">
                            <div class="card text-center h-100 border-0 shadow-sm">
                                <div class="card-body">
                                    <div class="mb-3">
                                        <i class="fas fa-tag fa-2x text-primary"></i>
                                    </div>
                                    <h6 class="card-title text-dark"><?= htmlspecialchars($category['name']) ?></h6>
                                    <small class="text-muted"><?= number_format($category['story_count']) ?> truyện</small>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="footer bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <!-- Website Info -->
                <div class="col-lg-4 mb-4">
                    <h5 class="mb-3">
                        <i class="fas fa-book-open me-2"></i><?= APP_NAME ?>
                    </h5>
                    <p class="text-muted">
                        Website đọc truyện tranh online miễn phí với kho tàng truyện phong phú, 
                        cập nhật liên tục các bộ truyện mới nhất.
                    </p>
                    <div class="social-links">
                        <a href="#" class="text-muted me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-muted me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-muted me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-muted"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Liên kết nhanh</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Trang chủ</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Tất cả truyện</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Thể loại</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Tìm kiếm</a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="mb-3">Thể loại</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-muted text-decoration-none">Hành động</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Phiêu lưu</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Tình cảm</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Hài hước</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Kinh dị</a></li>
                        <li><a href="#" class="text-muted text-decoration-none">Thể thao</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div class="col-lg-4 mb-4">
                    <h6 class="mb-3">Liên hệ</h6>
                    <div class="contact-info">
                        <p class="text-muted mb-2">
                            <i class="fas fa-envelope me-2"></i>contact@truyen.net
                        </p>
                        <p class="text-muted mb-2">
                            <i class="fas fa-phone me-2"></i>+84 123 456 789
                        </p>
                        <p class="text-muted mb-2">
                            <i class="fas fa-map-marker-alt me-2"></i>Hà Nội, Việt Nam
                        </p>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <!-- Copyright -->
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        &copy; <?= date('Y') ?> <?= APP_NAME ?>. Tất cả quyền được bảo lưu.
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">
                        <a href="#" class="text-muted text-decoration-none me-3">Điều khoản sử dụng</a>
                        <a href="#" class="text-muted text-decoration-none me-3">Chính sách bảo mật</a>
                        <a href="#" class="text-muted text-decoration-none">DMCA</a>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/main.js"></script>

    <script>
    // Initialize Swiper for Featured Stories
    document.addEventListener('DOMContentLoaded', function() {
        const swiper = new Swiper('.featured-swiper', {
            slidesPerView: 1,
            spaceBetween: 30,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                1024: {
                    slidesPerView: 4,
                },
            }
        });
    });
    </script>
</body>
</html>

<?php
// Get the content and clean the buffer
$content = ob_get_clean();
echo $content;
?> 