<div class="container mt-4">
    <h2>Sửa Chapter</h2>
    <form method="POST" action="<?= APP_URL ?>/admin/chapters/update/<?= $chapter['id'] ?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="story_id" class="form-label">Chọn truyện</label>
            <select class="form-select" id="story_id" name="story_id" required>
                <?php foreach ($stories as $story): ?>
                    <option value="<?= $story['id'] ?>" <?= $story['id'] == $chapter['story_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($story['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="title" class="form-label">Tiêu đề chapter</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($chapter['title']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Nội dung chapter</label>
            <textarea class="form-control" id="content" name="content" rows="8"><?= htmlspecialchars($chapter['content']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="chapter_number" class="form-label">Số thứ tự chương</label>
            <input type="number" class="form-control" id="chapter_number" name="chapter_number" min="1" step="1" value="<?= (int)$chapter['chapter_number'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Ảnh chương hiện tại</label>
            <div class="row g-2">
                <?php if (!empty($images)): ?>
                    <?php foreach ($images as $img): ?>
                        <div class="col-6 col-md-4 col-lg-3 text-center">
                            <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="Ảnh chương" style="max-width:100%;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.07);margin-bottom:6px;">
                            <div>
                                <input type="checkbox" name="delete_images[]" value="<?= $img['id'] ?>"> Xoá
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-muted">Chưa có ảnh nào</div>
                <?php endif; ?>
            </div>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Thêm ảnh mới (có thể chọn nhiều)</label>
            <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple>
            <small class="form-text text-muted">Chọn các ảnh theo đúng thứ tự trang truyện.</small>
        </div>
        <button type="submit" class="btn btn-primary">Cập nhật chapter</button>
        <a href="<?= APP_URL ?>/admin/chapters" class="btn btn-secondary">Quay lại</a>
    </form>
</div> 