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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    
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
                    <span class="logo-text" style="font-size:2.1rem; font-weight:700; letter-spacing:1px;">
                        <span style="color:#1ec6f7;">Truyen</span><span style="color:#ffb300;">.net</span>
                    </span>
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
                        <?php if (isset($_SESSION['admin_id'])): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-shield me-1"></i><?= htmlspecialchars($_SESSION['admin_username']) ?> (Admin)
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="<?= APP_URL ?>/admin/dashboard">Dashboard</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= APP_URL ?>/admin/logout">Đăng xuất</a></li>
                                </ul>
                            </li>
                        <?php elseif (isset($_SESSION['user_id'])): ?>
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

    <!-- Footer mới -->
    <footer class="footer-custom mt-5">
      <div class="container py-4">
        <div class="row align-items-start">
          <div class="col-md-6 mb-4 mb-md-0">
            <div class="d-flex align-items-center mb-3">
              <span class="footer-logo fw-bold" style="font-size:2rem;">
                <span style="color:#1ec6f7;">Truyen</span><span style="color:#ffb300;">.net</span>
              </span>
            </div>
            <ul class="list-unstyled text-light small mb-3">
              <li>Quyền riêng tư</li>
              <li>Bản quyền</li>
              <li>Liên hệ</li>
              <li>Chính sách bảo mật</li>
              <li>Quy định nội dung</li>
              <li>Điều khoản sử dụng</li>
            </ul>
            <hr class="border-secondary my-2">
            <div class="text-light small">
              Liên hệ: truyen.net@gmail.com<br>
              Copyright © 2024 Truyen.net
            </div>
          </div>
          <div class="col-md-6">
            <h5 class="text-white mb-3">Từ khóa</h5>
            <div class="footer-tags d-flex flex-wrap gap-2">
              <span class="footer-badge">Truyện tranh</span>
              <span class="footer-badge">Truyện tranh online</span>
              <span class="footer-badge">Đọc truyện tranh</span>
              <span class="footer-badge">Truyện tranh hot</span>
              <span class="footer-badge">Truyện tranh hay</span>
              <span class="footer-badge">Truyện ngôn tình</span>
              <span class="footer-badge">Manhwa</span>
              <span class="footer-badge">Manga</span>
              <span class="footer-badge">Manhua</span>
              <span class="footer-badge">truyenqq</span>
              <span class="footer-badge">mi2manga</span>
              <span class="footer-badge">doctruyen3q</span>
              <span class="footer-badge">toptruyen</span>
              <span class="footer-badge">cmanga</span>
              <span class="footer-badge">vlogtruyen</span>
              <span class="footer-badge">blogtruyen</span>
              <span class="footer-badge">truyentranhaudio</span>
              <span class="footer-badge">vcomi</span>
            </div>
          </div>
        </div>
      </div>
      <button id="backToTop" class="btn btn-outline-light rounded-3 shadow-sm position-fixed" style="right:24px;bottom:24px;z-index:999;display:none;">
        <i class="fas fa-chevron-up" style="color:#1ec6f7;"></i>
      </button>
    </footer>
    <style>
      .footer-custom {
        background: #232323;
        color: #eee;
        border-radius: 0 0 16px 16px;
        box-shadow: 0 -2px 16px rgba(0,0,0,0.08);
        margin-top: 3rem;
      }
      .footer-logo {
        font-family: 'Segoe UI', 'Arial', sans-serif;
        letter-spacing: 1px;
        user-select: none;
      }
      .footer-tags {
        gap: 0.5rem;
      }
      .footer-badge {
        display: inline-block;
        border: 1px solid #fff3;
        color: #fff;
        background: transparent;
        border-radius: 8px;
        padding: 0.3em 1em;
        font-size: 1em;
        margin-bottom: 0.3em;
        transition: background 0.2s, color 0.2s, border-color 0.2s;
        cursor: pointer;
      }
      .footer-badge:hover {
        background: #1ec6f7;
        color: #232323;
        border-color: #1ec6f7;
      }
      #backToTop {
        background: #232323;
        border: 1px solid #1ec6f7;
        transition: background 0.2s;
      }
      #backToTop:hover {
        background: #1ec6f7;
        border-color: #1ec6f7;
      }
      @media (max-width: 768px) {
        .footer-custom { border-radius: 0; }
        .footer-logo { font-size: 1.3rem; }
      }
      .navbar.bg-white {
        background: linear-gradient(45deg, #667eea, #764ba2) !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      }
      .navbar .navbar-brand, .navbar .nav-link, .navbar .dropdown-item {
        color: #fff !important;
      }
      .navbar .nav-link:hover, .navbar .nav-link.active {
        color: #ffb300 !important;
      }
    </style>
    <script>
      // Hiện nút cuộn lên đầu trang khi cuộn xuống
      const backToTop = document.getElementById('backToTop');
      window.addEventListener('scroll', function() {
        if(window.scrollY > 200) backToTop.style.display = 'block';
        else backToTop.style.display = 'none';
      });
      backToTop.onclick = () => window.scrollTo({top:0,behavior:'smooth'});
    </script>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="<?= APP_URL ?>/assets/js/main.js"></script>
</body>
</html> 