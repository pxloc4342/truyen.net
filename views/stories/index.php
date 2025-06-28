<?php include VIEWS_PATH . '/layouts/main.php'; ?>

<div class="container mt-4">
    <h1 class="mb-4">Danh sách truyện</h1>
    
    <div class="row">
        <?php if (!empty($stories)): ?>
            <?php foreach ($stories as $story): ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <?php if (!empty($story['cover_image'])): ?>
                            <img src="<?= APP_URL ?>/assets/images/covers/<?php echo $story['cover_image']; ?>" 
                                 class="card-img-top" alt="<?php echo htmlspecialchars($story['title']); ?>">
                        <?php endif; ?>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($story['title']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars(substr($story['description'], 0, 100)) . '...'; ?></p>
                            <a href="<?= APP_URL ?>/truyen/<?php echo $story['id']; ?>" class="btn btn-primary">Đọc truyện</a>
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
</div> 