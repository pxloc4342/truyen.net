<div class="container mt-4">
    <h2 class="mb-4" style="font-size:1.7rem;font-weight:700;color:#222;">
        <?php if (!empty($categoryName)): ?>
            Truyện <?= htmlspecialchars($categoryName) ?>
        <?php else: ?>
            <?= htmlspecialchars($title) ?>
        <?php endif; ?>
    </h2>
    <div class="row mb-4">
        <div class="col-md-6 mb-2">
            <form method="get" class="d-flex align-items-center gap-2">
                <label for="status" class="me-2 mb-0">Trạng thái:</label>
                <select name="status" id="status" class="form-select form-select-sm w-auto">
                    <option value="">Tất cả</option>
                    <option value="ongoing" <?= isset($status) && $status == 'ongoing' ? 'selected' : '' ?>>Đang ra</option>
                    <option value="completed" <?= isset($status) && $status == 'completed' ? 'selected' : '' ?>>Full</option>
                    <option value="hiatus" <?= isset($status) && $status == 'hiatus' ? 'selected' : '' ?>>Tạm ngưng</option>
                </select>
                <label for="category" class="ms-3 me-2 mb-0">Thể loại:</label>
                <select name="category" id="category" class="form-select form-select-sm w-auto">
                    <option value="">Tất cả</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= isset($category) && $category == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary btn-sm ms-2">Lọc</button>
            </form>
        </div>
    </div>
    
    <div class="row">
        <?php if (!empty($stories)): ?>
            <?php foreach ($stories as $story): ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                    <div class="card h-100 d-flex flex-column align-items-stretch">
                        <?php if (!empty($story['thumbnail'])): ?>
                            <img src="<?= APP_URL . $story['thumbnail']; ?>" class="card-img-top mx-auto d-block story-cover-img" alt="<?= htmlspecialchars($story['title']); ?>">
                        <?php elseif (!empty($story['cover_image'])): ?>
                            <img src="<?= APP_URL ?>/assets/images/covers/<?= $story['cover_image']; ?>" class="card-img-top mx-auto d-block story-cover-img" alt="<?= htmlspecialchars($story['title']); ?>">
                        <?php endif; ?>
                        <div class="card-body d-flex flex-column align-items-stretch justify-content-between" style="flex:1 1 auto;">
                            <div class="w-100 text-start mb-2">
                                <h5 class="card-title mb-1" style="line-height:1.2;overflow:hidden;margin-bottom:0.3em !important;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;white-space:normal;">
                                    <?= htmlspecialchars($story['title']); ?>
                                </h5>
                                <?php if (!empty($story['latest_chapter_id']) && !empty($story['latest_chapter_number'])): ?>
                                    <a href="<?= APP_URL ?>/truyen/<?= $story['id']; ?>/chuong/<?= $story['latest_chapter_id']; ?>" class="chapter-link-custom" style="text-decoration:none;">
                                        Chapter <?= (int)$story['latest_chapter_number'] ?>
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted chapter-link-custom">Chapter 0</span>
                                <?php endif; ?>
                            </div>
                            <a href="<?= APP_URL ?>/truyen/<?= $story['id']; ?>" class="btn btn-primary mt-auto w-100">Đọc</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <p class="text-center">Chưa có truyện nào.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php if (!empty($totalPages) && $totalPages > 1): ?>
    <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item<?= ($i == ($currentPage ?? 1)) ? ' active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</div>

<script>
// Chỉ submit form khi bấm nút "Lọc"
document.addEventListener('DOMContentLoaded', function() {
    // Không cần JS tự động submit khi đổi select nữa
    // Nếu muốn chuyển trang khi chọn thể loại, có thể giữ lại đoạn window.location.href nếu thực sự cần
    // Nếu không, chỉ để form submit khi bấm nút
});
</script> 