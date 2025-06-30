<div class="container mt-4">
    <h2>Thêm Chapter mới</h2>
    <form method="POST" action="<?= APP_URL ?>/admin/chapters/store">
        <?php if (isset($selected_story) && $selected_story): ?>
            <div class="mb-3">
                <label class="form-label">Truyện</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($selected_story['title']) ?>" disabled>
                <input type="hidden" name="story_id" value="<?= htmlspecialchars($selected_story['id']) ?>">
            </div>
        <?php else: ?>
            <div class="mb-3">
                <label for="story_id" class="form-label">Chọn truyện</label>
                <select class="form-select" id="story_id" name="story_id" required>
                    <option value="">-- Chọn truyện --</option>
                    <?php if (!empty($stories)): ?>
                        <?php foreach ($stories as $story): ?>
                            <option value="<?= htmlspecialchars($story['id']) ?>">
                                <?= htmlspecialchars($story['title']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề chapter</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung chapter</label>
            <textarea class="form-control" id="content" name="content" rows="8" required></textarea>
        </div>
        <div class="mb-3">
            <label for="chapter_number" class="form-label">Số thứ tự chương</label>
            <input type="number" class="form-control" id="chapter_number" name="chapter_number" min="1" step="1" value="<?= isset($default_chapter_number) ? $default_chapter_number : 1 ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Thêm chapter</button>
        <a href="<?= APP_URL ?>/admin/chapters" class="btn btn-secondary">Quay lại</a>
    </form>
</div> 