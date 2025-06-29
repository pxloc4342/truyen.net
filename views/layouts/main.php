<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? APP_NAME ?></title>
    
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
    <link rel="stylesheet" href="<?= APP_URL ?>/assets/css/style.css?v=<?= time() ?>">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Top Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <!-- Logo -->
                <a class="navbar-brand fw-bold text-primary" href="<?= APP_URL ?>/">
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
                            <a class="nav-link <?= $_SERVER['REQUEST_URI'] === '/' ? 'active' : '' ?>" href="<?= APP_URL ?>/">
                                <i class="fas fa-home me-1"></i>Trang chủ
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-tags me-1"></i>Thể loại
                            </a>
                            <ul class="dropdown-menu">
                                <?php
                                $categories = $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC LIMIT 10");
                                foreach ($categories as $category):
                                ?>
                                <li><a class="dropdown-item" href="<?= APP_URL ?>/the-loai/<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></a></li>
                                <?php endforeach; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= APP_URL ?>/the-loai">Xem tất cả</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= APP_URL ?>/truyen-hot">
                                <i class="fas fa-fire me-1"></i>Truyện hot
                            </a>
                        </li>
                    </ul>
                    
                    <!-- User Menu -->
                    <ul class="navbar-nav">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-1"></i><?= htmlspecialchars($_SESSION['username']) ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/profile">Hồ sơ</a></li>
                                    <li><a class="dropdown-item" href="/favorites">Yêu thích</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/dang-xuat">Đăng xuất</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= APP_URL ?>/dang-nhap">
                                    <i class="fas fa-sign-in-alt me-1"></i>Đăng nhập
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= APP_URL ?>/dang-ky">
                                    <i class="fas fa-user-plus me-1"></i>Đăng ký
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        
        <!-- Large Search Bar -->
        <div class="search-hero py-4 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <form method="GET" action="<?= APP_URL ?>/tim-kiem" class="search-form">
                            <div class="input-group input-group-lg">
                                <input class="form-control" 
                                       type="search" 
                                       name="q" 
                                       placeholder="Nhập tên truyện..." 
                                       value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
                                       aria-label="Tìm kiếm truyện">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content">
        <?= $content ?>
    </main>

    <!-- Footer -->
    <footer class="footer bg-dark text-light py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="mb-0"><?= APP_NAME ?></h6>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="footer-links">
                        <a href="#" class="text-muted text-decoration-none me-3">Giới thiệu</a>
                        <a href="#" class="text-muted text-decoration-none me-3">Liên hệ</a>
                        <a href="#" class="text-muted text-decoration-none me-3">
                            <i class="fab fa-facebook"></i> Facebook
                        </a>
                        <a href="#" class="text-muted text-decoration-none">Chính sách bản quyền</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/main.js"></script>
</body>
</html> 