<div class="container mt-4">
    <h2>Danh sách Truyện</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width:70px; text-align:center;">ID</th>
                <th>Tiêu đề</th>
                <th>Tác giả</th>
                <th style="width:170px; text-align:center;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($stories)): ?>
                <?php foreach ($stories as $story): ?>
                    <tr>
                        <td style="text-align:center; vertical-align:middle;">
                            <?= htmlspecialchars($story['id']) ?>
                        </td>
                        <td><?= htmlspecialchars($story['title']) ?></td>
                        <td><?= htmlspecialchars($story['author']) ?></td>
                        <td style="text-align:center; vertical-align:middle;">
                            <a href="<?= APP_URL ?>/admin/chapters/story/<?= $story['id'] ?>" class="btn btn-primary btn-sm">Xem chapter</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="4" class="text-center">Chưa có truyện nào.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div> 