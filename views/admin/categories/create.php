<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Thêm thể loại mới' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background: #f8f9fa;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        }
        .btn {
            border-radius: 8px;
            font-weight: 500;
        }
        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2><i class="fas fa-plus me-2"></i>Thêm thể loại mới</h2>
                    <a href="<?= APP_URL ?>/admin/categories" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Quay lại
                    </a>
                </div>

                <!-- Form -->
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="<?= APP_URL ?>/admin/categories/create">
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Tên thể loại
                                </label>
                                <input type="text" 
                                       class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" 
                                       placeholder="Ví dụ: Hành động, Tình cảm, Kinh dị..."
                                       required>
                                <?php if (isset($errors['name'])): ?>
                                    <div class="invalid-feedback"><?= htmlspecialchars($errors['name']) ?></div>
                                <?php endif; ?>
                                <div class="form-text">
                                    Nhập tên thể loại truyện (ví dụ: Hành động, Phiêu lưu, Tình cảm, Kinh dị...)
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Lưu thể loại
                                </button>
                                <a href="<?= APP_URL ?>/admin/categories" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-2"></i>Hủy bỏ
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tips -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6><i class="fas fa-lightbulb me-2 text-warning"></i>Gợi ý</h6>
                        <ul class="mb-0 text-muted">
                            <li>Tên thể loại nên ngắn gọn và dễ hiểu</li>
                            <li>Một số thể loại phổ biến: Hành động, Phiêu lưu, Tình cảm, Hài hước, Kinh dị, Thể thao</li>
                            <li>Không được trùng tên với thể loại đã có</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 