<?php include VIEWS_PATH . '/layouts/main.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <?php if (!empty($story['cover_image'])): ?>
                <img src="<?= APP_URL ?>/assets/images/covers/<?php echo $story['cover_image']; ?>" 
                     class="img-fluid" alt="<?php echo htmlspecialchars($story['title']); ?>">
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <h1><?php echo htmlspecialchars($story['title']); ?></h1>
            <p class="text-muted">Tác giả: <?php echo htmlspecialchars($story['author']); ?></p>
            <p class="text-muted">Trạng thái: <?php echo $story['status'] ? 'Đang tiến hành' : 'Hoàn thành'; ?></p>
            <p><?php echo nl2br(htmlspecialchars($story['description'])); ?></p>
            
            <div class="mt-3">
                <h4>Thể loại:</h4>
                <?php if (!empty($story['categories'])): ?>
                    <?php foreach ($story['categories'] as $category): ?>
                        <span class="badge bg-secondary me-1"><?php echo htmlspecialchars($category['name']); ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Chưa có thể loại</p>
                <?php endif; ?>
            </div>
            
            <div class="mt-4">
                <a href="<?= APP_URL ?>/truyen" class="btn btn-secondary">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</div> 