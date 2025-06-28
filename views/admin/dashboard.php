<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 2px 0;
            transition: all 0.3s ease;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }
        
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease;
        }
        
        .stats-card:hover {
            transform: translateY(-5px);
        }
        
        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }
        
        .bg-primary-gradient {
            background: linear-gradient(45deg, #667eea, #764ba2);
        }
        
        .bg-success-gradient {
            background: linear-gradient(45deg, #28a745, #20c997);
        }
        
        .bg-warning-gradient {
            background: linear-gradient(45deg, #ffc107, #fd7e14);
        }
        
        .bg-info-gradient {
            background: linear-gradient(45deg, #17a2b8, #6f42c1);
        }
        
        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="p-3">
                    <h4 class="text-white mb-4">
                        <i class="fas fa-user-shield me-2"></i>Admin Panel
                    </h4>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link active" href="/admin/dashboard">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                        <a class="nav-link" href="/admin/stories">
                            <i class="fas fa-book me-2"></i>Quản lý truyện
                        </a>
                        <a class="nav-link" href="/admin/chapters">
                            <i class="fas fa-list me-2"></i>Quản lý chapter
                        </a>
                        <a class="nav-link" href="/admin/categories">
                            <i class="fas fa-tags me-2"></i>Thể loại
                        </a>
                        <a class="nav-link" href="/admin/users">
                            <i class="fas fa-users me-2"></i>Người dùng
                        </a>
                        <a class="nav-link" href="/admin/settings">
                            <i class="fas fa-cog me-2"></i>Cài đặt
                        </a>
                        <hr class="text-white-50">
                        <a class="nav-link" href="/" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Xem website
                        </a>
                        <a class="nav-link" href="/admin/logout">
                            <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                        </a>
                    </nav>
                </div>
            </div>
            
            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Top Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                    <div class="container-fluid">
                        <span class="navbar-brand">Dashboard</span>
                        <div class="navbar-nav ms-auto">
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-2"></i><?= htmlspecialchars($_SESSION['admin_username']) ?>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="/admin/profile">Hồ sơ</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="/admin/logout">Đăng xuất</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
                
                <!-- Content -->
                <div class="p-4">
                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon bg-primary-gradient me-3">
                                        <i class="fas fa-book"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= number_format($totalStories) ?></h3>
                                        <p class="text-muted mb-0">Tổng truyện</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon bg-success-gradient me-3">
                                        <i class="fas fa-list"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= number_format($totalChapters) ?></h3>
                                        <p class="text-muted mb-0">Tổng chapter</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon bg-warning-gradient me-3">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= number_format($totalUsers) ?></h3>
                                        <p class="text-muted mb-0">Người dùng</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="stats-card">
                                <div class="d-flex align-items-center">
                                    <div class="stats-icon bg-info-gradient me-3">
                                        <i class="fas fa-eye"></i>
                                    </div>
                                    <div>
                                        <h3 class="mb-0"><?= number_format($totalViews) ?></h3>
                                        <p class="text-muted mb-0">Lượt xem</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Recent Content -->
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="table-card">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0">
                                        <i class="fas fa-clock me-2"></i>Truyện mới nhất
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($latestStories)): ?>
                                        <div class="list-group list-group-flush">
                                            <?php foreach ($latestStories as $story): ?>
                                                <div class="list-group-item border-0 px-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1"><?= htmlspecialchars($story['title']) ?></h6>
                                                            <small class="text-muted">
                                                                <i class="fas fa-user me-1"></i><?= htmlspecialchars($story['author']) ?>
                                                            </small>
                                                        </div>
                                                        <span class="badge bg-primary"><?= $story['status'] ?></span>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted text-center">Chưa có truyện nào</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-4">
                            <div class="table-card">
                                <div class="card-header bg-white border-0">
                                    <h5 class="mb-0">
                                        <i class="fas fa-clock me-2"></i>Chapter mới nhất
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <?php if (!empty($latestChapters)): ?>
                                        <div class="list-group list-group-flush">
                                            <?php foreach ($latestChapters as $chapter): ?>
                                                <div class="list-group-item border-0 px-0">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h6 class="mb-1"><?= htmlspecialchars($chapter['story_title']) ?></h6>
                                                            <small class="text-muted">
                                                                Chapter <?= $chapter['chapter_number'] ?>: <?= htmlspecialchars($chapter['title']) ?>
                                                            </small>
                                                        </div>
                                                        <small class="text-muted">
                                                            <?= date('d/m/Y', strtotime($chapter['created_at'])) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <p class="text-muted text-center">Chưa có chapter nào</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 