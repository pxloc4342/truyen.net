<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="fas fa-edit me-2"></i>Sửa chương: <?= htmlspecialchars($chapter['title']) ?> (<?= htmlspecialchars($story['title']) ?>)</h2>
        <a href="<?= APP_URL ?>/admin/chapters/<?= $story['id'] ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Quay lại danh sách chương
        </a>
    </div>
    <form method="POST" class="bg-white p-4 rounded shadow-sm">
        <div class="mb-3">
            <label class="form-label">Tiêu đề chương <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control <?= isset($errors['title']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_POST['title'] ?? $chapter['title']) ?>" required>
            <?php if (isset($errors['title'])): ?>
                <div class="invalid-feedback d-block"> <?= htmlspecialchars($errors['title']) ?> </div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Số chương <span class="text-danger">*</span></label>
            <input type="number" name="chapter_number" class="form-control <?= isset($errors['chapter_number']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($_POST['chapter_number'] ?? $chapter['chapter_number']) ?>" required>
            <?php if (isset($errors['chapter_number'])): ?>
                <div class="invalid-feedback d-block"> <?= htmlspecialchars($errors['chapter_number']) ?> </div>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Nội dung chương</label>
            <textarea name="content" class="form-control" rows="8"><?= htmlspecialchars($_POST['content'] ?? $chapter['content']) ?></textarea>
        </div>
        <div class="mt-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-success px-4">
                <i class="fas fa-save me-1"></i> Lưu thay đổi
            </button>
        </div>
    </form>
</div> 