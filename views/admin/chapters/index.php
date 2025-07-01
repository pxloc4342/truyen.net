<div class="container mt-4">
    <h2>Danh sách Chapter của truyện: <span class="text-primary"><?= htmlspecialchars($story['title']) ?></span></h2>
    <a href="<?= APP_URL ?>/admin/chapters/create?story_id=<?= $story['id'] ?>" class="btn btn-success mb-3">Thêm Chapter mới</a>
    <a href="<?= APP_URL ?>/admin/chapters" class="btn btn-secondary mb-3 ms-2">Quay lại danh sách truyện</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:110px; text-align:center;">Số thứ tự</th>
                <th>Tiêu đề</th>
                <th style="width:170px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($chapters)): ?>
                <?php foreach (array_reverse($chapters) as $chapter): ?>
                    <tr>
                        <td style="text-align:center; vertical-align:middle;">
                            <?= (int)$chapter['chapter_number'] ?>
                        </td>
                        <td><?= htmlspecialchars($chapter['title']) ?></td>
                        <td>
                            <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $chapter['id'] ?>" class="btn btn-primary btn-sm" target="_blank">Đọc</a>
                            <a href="<?= APP_URL ?>/admin/chapters/edit/<?= $chapter['id'] ?>" class="btn btn-warning btn-sm ms-1">Sửa</a>
                            <a href="<?= APP_URL ?>/admin/chapters/delete/<?= $chapter['id'] ?>" class="btn btn-danger btn-sm ms-1" onclick="return confirm('Bạn có chắc muốn xóa chapter này?');">Xóa</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="3" class="text-center">Chưa có chapter nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div> 