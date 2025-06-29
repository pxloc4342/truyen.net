<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Quản lý thể loại' ?></title>
    
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
        .table {
            border-radius: 10px;
            overflow: hidden;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-tags me-2"></i>Quản lý thể loại</h2>
            <div>
                <a href="<?= APP_URL ?>/admin/dashboard" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left me-2"></i>Về Dashboard
                </a>
                <a href="<?= APP_URL ?>/admin/categories/create" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Thêm thể loại mới
                </a>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="card">
            <div class="card-body">
                <?php if (empty($categories)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Chưa có thể loại nào</h5>
                        <p class="text-muted">Bắt đầu bằng cách thêm thể loại mới</p>
                        <a href="<?= APP_URL ?>/admin/categories/create" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Thêm thể loại đầu tiên
                        </a>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Tên thể loại</th>
                                    <th width="200">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $index => $category): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <span class="badge bg-primary fs-6">
                                                <?= htmlspecialchars($category['name']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?= APP_URL ?>/admin/categories/edit/<?= $category['id'] ?>" 
                                                   class="btn btn-sm btn-outline-warning" 
                                                   title="Sửa thể loại">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        onclick="deleteCategory(<?= $category['id'] ?>, '<?= htmlspecialchars($category['name']) ?>')" 
                                                        title="Xóa thể loại">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    function deleteCategory(categoryId, categoryName) {
        if (confirm(`Bạn có chắc chắn muốn xóa thể loại "${categoryName}"? Hành động này sẽ xóa tất cả quan hệ với truyện.`)) {
            window.location.href = '<?= APP_URL ?>/admin/categories/delete/' + categoryId;
        }
    }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 