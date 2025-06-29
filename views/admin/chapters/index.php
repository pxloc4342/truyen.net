<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-list me-2"></i>Quản lý chương: <?= htmlspecialchars($story['title']) ?></h2>
        <div>
            <a href="<?= APP_URL ?>/admin/stories" class="btn btn-outline-secondary me-2">
                <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách truyện
            </a>
            <a href="<?= APP_URL ?>/admin/chapters/create/<?= $story['id'] ?>" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Thêm chương mới
            </a>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Tiêu đề chương</th>
                    <th>Số chương</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($chapters)): ?>
                    <?php foreach ($chapters as $chapter): ?>
                        <tr>
                            <td><?= $chapter['id'] ?></td>
                            <td><?= htmlspecialchars($chapter['title']) ?></td>
                            <td><?= htmlspecialchars($chapter['chapter_number']) ?></td>
                            <td><?= isset($chapter['created_at']) ? date('d/m/Y', strtotime($chapter['created_at'])) : '' ?></td>
                            <td>
                                <a href="<?= APP_URL ?>/admin/chapters/edit/<?= $chapter['id'] ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?= APP_URL ?>/admin/chapters/delete/<?= $chapter['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa chương này?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">Chưa có chương nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div> 