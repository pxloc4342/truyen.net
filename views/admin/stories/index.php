<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-book me-2"></i>Quản lý truyện</h2>
        <a href="/admin/stories/create" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Thêm truyện mới
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle bg-white">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Ảnh bìa</th>
                    <th>Tiêu đề</th>
                    <th>Tác giả</th>
                    <th>Thể loại</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($stories)): ?>
                    <?php foreach ($stories as $story): ?>
                        <tr>
                            <td><?= $story['id'] ?></td>
                            <td>
                                <?php if ($story['thumbnail']): ?>
                                    <img src="<?= $story['thumbnail'] ?>" alt="cover" style="width:60px;height:80px;object-fit:cover;border-radius:6px;">
                                <?php else: ?>
                                    <span class="text-muted">(Không có)</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($story['title']) ?></td>
                            <td><?= htmlspecialchars($story['author']) ?></td>
                            <td>
                                <?php
                                $cats = $this->db->fetchAll("SELECT c.name FROM categories c JOIN story_category sc ON c.id = sc.category_id WHERE sc.story_id = ?", [$story['id']]);
                                if ($cats) {
                                    foreach ($cats as $cat) {
                                        echo '<span class="badge bg-info me-1">' . htmlspecialchars($cat['name']) . '</span>';
                                    }
                                } else {
                                    echo '<span class="text-muted">Chưa gán</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($story['status'] === 'completed'): ?>
                                    <span class="badge bg-success">Hoàn thành</span>
                                <?php elseif ($story['status'] === 'hiatus'): ?>
                                    <span class="badge bg-warning text-dark">Tạm ngưng</span>
                                <?php else: ?>
                                    <span class="badge bg-primary">Đang ra</span>
                                <?php endif; ?>
                            </td>
                            <td><?= date('d/m/Y', strtotime($story['created_at'])) ?></td>
                            <td>
                                <a href="/admin/stories/edit/<?= $story['id'] ?>" class="btn btn-sm btn-warning me-1">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/admin/stories/delete/<?= $story['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa truyện này?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">Chưa có truyện nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div> 