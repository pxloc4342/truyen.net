<!-- Hero Section -->
<div class="hero-section bg-primary text-white py-5 rounded mb-4">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h1 class="display-4 fw-bold">Chào mừng đến với <?= APP_NAME ?></h1>
            <p class="lead">Khám phá thế giới truyện tranh đa dạng với hàng nghìn bộ truyện hấp dẫn</p>
            <a href="<?= APP_URL ?>/truyen" class="btn btn-light btn-lg">Khám phá ngay</a>
        </div>
        <div class="col-md-4 text-center">
            <i class="fas fa-book-open display-1"></i>
        </div>
    </div>
</div>

<!-- Latest Stories Section -->
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h3">Truyện mới cập nhật</h2>
        <a href="<?= APP_URL ?>/truyen" class="btn btn-outline-primary">Xem tất cả</a>
    </div>
    
    <div class="row">
        <?php if (!empty($latestStories)): ?>
            <?php foreach ($latestStories as $story): ?>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card h-100">
                        <img src="<?= $story['thumbnail'] ?? APP_URL . '/assets/images/default-cover.jpg' ?>" 
                             class="card-img-top" alt="<?= htmlspecialchars($story['title']) ?>"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($story['title']) ?></h5>
                            <p class="card-text text-muted small">
                                <?= htmlspecialchars(substr($story['description'] ?? '', 0, 100)) ?>...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i><?= number_format($story['views'] ?? 0) ?>
                                </small>
                                <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>" class="btn btn-sm btn-primary">Đọc</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Chưa có truyện nào được thêm vào hệ thống.
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Hot Stories Section -->
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h3">Truyện hot</h2>
        <a href="<?= APP_URL ?>/truyen?sort=hot" class="btn btn-outline-primary">Xem tất cả</a>
    </div>
    
    <div class="row">
        <?php if (!empty($hotStories)): ?>
            <?php foreach ($hotStories as $story): ?>
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card h-100">
                        <img src="<?= $story['thumbnail'] ?? APP_URL . '/assets/images/default-cover.jpg' ?>" 
                             class="card-img-top" alt="<?= htmlspecialchars($story['title']) ?>"
                             style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($story['title']) ?></h5>
                            <p class="card-text text-muted small">
                                <?= htmlspecialchars(substr($story['description'] ?? '', 0, 100)) ?>...
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-fire text-danger me-1"></i><?= number_format($story['views'] ?? 0) ?>
                                </small>
                                <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>" class="btn btn-sm btn-primary">Đọc</a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Chưa có truyện nào được thêm vào hệ thống.
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Categories Section -->
<section class="mb-5">
    <h2 class="h3 mb-3">Thể loại</h2>
    <div class="row">
        <?php if (!empty($categories)): ?>
            <?php foreach ($categories as $category): ?>
                <div class="col-md-2 col-sm-4 col-6 mb-2">
                    <a href="<?= APP_URL ?>/the-loai/<?= $category['id'] ?>" class="text-decoration-none">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-tag text-primary mb-2"></i>
                                <h6 class="card-title"><?= htmlspecialchars($category['name']) ?></h6>
                                <small class="text-muted"><?= $category['count'] ?? 0 ?> truyện</small>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>
                    Chưa có thể loại nào được thêm vào hệ thống.
                </div>
            </div>
        <?php endif; ?>
    </div>
</section> 