<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-plus me-2"></i>Thêm truyện mới</h2>
        <a href="/admin/stories" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách
        </a>
    </div>
    <form method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded shadow-sm">
        <div class="row mb-3">
            <div class="col-md-8">
                <label class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                <?php if (isset($errors['title'])): ?>
                    <div class="invalid-feedback d-block"> <?= htmlspecialchars($errors['title']) ?> </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4">
                <label class="form-label">Tác giả <span class="text-danger">*</span></label>
                <input type="text" name="author" class="form-control <?= isset($errors['author']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_POST['author'] ?? '') ?>" required>
                <?php if (isset($errors['author'])): ?>
                    <div class="invalid-feedback d-block"> <?= htmlspecialchars($errors['author']) ?> </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($_POST['description'] ?? '') ?></textarea>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Thể loại</label>
                <select name="categories[]" class="form-select" multiple size="5">
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= (isset($_POST['categories']) && in_array($cat['id'], (array)$_POST['categories'])) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="form-text">Giữ Ctrl để chọn nhiều thể loại</div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Trạng thái</label>
                <select name="status" class="form-select">
                    <option value="ongoing" <?= (($_POST['status'] ?? '') === 'ongoing') ? 'selected' : '' ?>>Đang ra</option>
                    <option value="completed" <?= (($_POST['status'] ?? '') === 'completed') ? 'selected' : '' ?>>Hoàn thành</option>
                    <option value="hiatus" <?= (($_POST['status'] ?? '') === 'hiatus') ? 'selected' : '' ?>>Tạm ngưng</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Ảnh bìa</label>
                <input type="file" name="thumbnail" accept="image/*" class="form-control <?= isset($errors['thumbnail']) ? 'is-invalid' : '' ?>">
                <?php if (isset($errors['thumbnail'])): ?>
                    <div class="invalid-feedback d-block"> <?= htmlspecialchars($errors['thumbnail']) ?> </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="mt-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-save me-1"></i> Lưu truyện
            </button>
        </div>
    </form>
</div> 