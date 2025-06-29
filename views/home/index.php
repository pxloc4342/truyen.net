<!-- Latest Stories Section -->
<section class="py-5">
    <div class="container">
        <div class="section-header">
            <h2>Danh sách truyện mới cập nhật</h2>
            <p>Những chương mới nhất vừa được đăng</p>
        </div>
        
        <div class="row">
            <?php foreach ($latestStories as $story): ?>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4">
                <div class="story-card">
                    <?php if ($story['thumbnail']): ?>
                        <img src="<?= APP_URL . $story['thumbnail'] ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($story['title']) ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($story['title']) ?></h5>
                        <p class="author">
                            <i class="fas fa-user me-1"></i><?= htmlspecialchars($story['author']) ?>
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-book-open me-1"></i>Đọc
                            </a>
                            <small class="text-muted">
                                <i class="fas fa-eye me-1"></i><?= number_format($story['views']) ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="status-badge status-<?= $story['status'] ?>">
                        <?php
                        $statusText = [
                            'ongoing' => 'Đang ra',
                            'completed' => 'Full',
                            'hiatus' => 'Tạm ngưng'
                        ];
                        echo $statusText[$story['status']] ?? 'Đang ra';
                        ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="text-center mt-4">
            <a href="<?= APP_URL ?>/truyen" class="btn btn-primary btn-lg">
                <i class="fas fa-list me-2"></i>Xem thêm
            </a>
        </div>
    </div>
</section>

<!-- Featured Stories Slider -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-header">
            <h2>Truyện nổi bật</h2>
            <p>Những bộ truyện được yêu thích nhất</p>
        </div>
        
        <div class="featured-slider">
            <div class="swiper featured-swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($featuredStories as $story): ?>
                    <div class="swiper-slide">
                        <div class="story-card">
                            <?php if ($story['thumbnail']): ?>
                                <img src="<?= APP_URL . $story['thumbnail'] ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($story['title']) ?>">
                            <?php else: ?>
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($story['title']) ?></h5>
                                <p class="author">
                                    <i class="fas fa-user me-1"></i><?= htmlspecialchars($story['author']) ?>
                                </p>
                                <p class="card-text">
                                    <?= htmlspecialchars(substr($story['description'], 0, 100)) ?>...
                                </p>
                                <div class="category-pills">
                                    <?php
                                    $categories = $this->db->fetchAll(
                                        "SELECT c.id, c.name FROM categories c 
                                         JOIN story_category sc ON c.id = sc.category_id 
                                         WHERE sc.story_id = ? LIMIT 3", 
                                        [$story['id']]
                                    );
                                    foreach ($categories as $category):
                                    ?>
                                    <span class="category-pill">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </span>
                                    <?php endforeach; ?>
                                </div>
                                <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>" class="btn btn-primary w-100">
                                    <i class="fas fa-book-open me-2"></i>Đọc ngay
                                </a>
                            </div>
                            
                            <div class="status-badge status-<?= $story['status'] ?>">
                                <?php
                                $statusText = [
                                    'ongoing' => 'Đang ra',
                                    'completed' => 'Full',
                                    'hiatus' => 'Tạm ngưng'
                                ];
                                echo $statusText[$story['status']] ?? 'Đang ra';
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
</section>

<script>
// Initialize Swiper for Featured Stories
document.addEventListener('DOMContentLoaded', function() {
    const swiper = new Swiper('.featured-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
        }
    });
});

// Add fade-in animation to story cards
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in-up');
        }
    });
}, observerOptions);

document.querySelectorAll('.story-card').forEach(card => {
    observer.observe(card);
});
</script> 