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
                                <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>">
                                    <img src="<?= APP_URL . $story['thumbnail'] ?>" 
                                         class="card-img-top" 
                                         alt="<?= htmlspecialchars($story['title']) ?>">
                                </a>
                            <?php else: ?>
                                <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>">
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                </a>
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

<!-- Suggested Stories Section -->
<section class="py-5">
    <div class="container">
        <div class="section-header d-flex justify-content-between align-items-center">
            <div>
                <h2 class="mb-0">Truyện đề xuất</h2>
                <p class="mb-0">Gợi ý truyện hấp dẫn dành cho bạn</p>
            </div>
            <a href="<?= APP_URL ?>/truyen" class="btn btn-outline-primary">
                <i class="fas fa-list me-1"></i>Xem tất cả
            </a>
        </div>
        <div class="position-relative">
            <button class="scroll-btn scroll-left btn btn-light position-absolute top-50 start-0 translate-middle-y shadow" style="z-index:2;" title="Trượt sang trái"><i class="fas fa-chevron-left"></i></button>
            <div class="suggested-scroll row flex-nowrap overflow-auto pb-2" style="scroll-behavior:smooth;">
                <?php foreach ($suggestedStories as $story): ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-4" style="min-width:200px;max-width:220px;">
                    <div class="story-card">
                        <?php if ($story['thumbnail']): ?>
                            <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>">
                                <img src="<?= APP_URL . $story['thumbnail'] ?>" 
                                     class="card-img-top" 
                                     alt="<?= htmlspecialchars($story['title']) ?>">
                            </a>
                        <?php else: ?>
                            <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>">
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            </a>
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
            <button class="scroll-btn scroll-right btn btn-light position-absolute top-50 end-0 translate-middle-y shadow" style="z-index:2;" title="Trượt sang phải"><i class="fas fa-chevron-right"></i></button>
        </div>
    </div>
</section>

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
                        <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>">
                            <img src="<?= APP_URL . $story['thumbnail'] ?>" 
                                 class="card-img-top" 
                                 alt="<?= htmlspecialchars($story['title']) ?>">
                        </a>
                    <?php else: ?>
                        <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>">
                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        </a>
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

<style>
.suggested-scroll::-webkit-scrollbar { height: 8px; }
.suggested-scroll::-webkit-scrollbar-thumb { background: #e0e0e0; border-radius: 4px; }
.scroll-btn { width: 38px; height: 38px; border-radius: 50%; opacity: 0.85; }
.scroll-btn:active { opacity: 1; }
@media (max-width: 768px) {
    .scroll-btn { display: none !important; }
}
</style>
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

// Nút cuộn ngang cho suggested-scroll
const scrollRow = document.querySelector('.suggested-scroll');
const btnLeft = document.querySelector('.scroll-left');
const btnRight = document.querySelector('.scroll-right');
if (scrollRow && btnLeft && btnRight) {
    btnLeft.onclick = () => scrollRow.scrollBy({left: -220, behavior: 'smooth'});
    btnRight.onclick = () => scrollRow.scrollBy({left: 220, behavior: 'smooth'});
}
</script> 