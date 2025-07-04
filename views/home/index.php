<!-- Featured Stories Slider -->
<section class="py-5 bg-light">
    <div class="container-fluid">
        <div class="section-header">
            <h2>Truyện nổi bật</h2>
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
                                <h5 class="card-title mb-1" style="margin-bottom:0.1em !important;">
                                    <?= htmlspecialchars($story['title']) ?>
                                </h5>
                                <p class="author" style="margin-bottom:0.12rem;margin-top:0;font-size:0.85em;">
                                    <i class="fas fa-user me-1"></i><?= htmlspecialchars($story['author']) ?>
                                </p>
                                <div class="category-pills">
                                    <?php
                                    $categories = $this->db->fetchAll(
                                        "SELECT c.id, c.name FROM categories c 
                                         JOIN story_category sc ON c.id = sc.category_id 
                                         WHERE sc.story_id = ?",
                                        [$story['id']]
                                    );
                                    $maxCategories = 2;
                                    $catCount = count($categories);
                                    $displayed = 0;
                                    foreach ($categories as $category):
                                        if ($displayed >= $maxCategories) break;
                                    ?>
                                    <span class="category-pill" style="font-size:0.8em;padding:0.08em 0.38em;border-radius:6px;min-width:unset;display:inline-block;">
                                        <?= htmlspecialchars($category['name']) ?>
                                    </span>
                                    <?php $displayed++; endforeach; ?>
                                    <?php if ($catCount > $maxCategories): ?>
                                    <span class="category-pill" style="font-size:0.8em;padding:0.08em 0.38em;border-radius:6px;min-width:unset;display:inline-block;background:#eee;color:#888;">...</span>
                                    <?php endif; ?>
                                </div>
                                <div class="read-btn-wrapper">
                                    <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>" class="btn btn-primary w-100">
                                        <i class="fas fa-book-open me-2"></i>Đọc ngay
                                    </a>
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
                <div class="swiper-pagination"></div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
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
            </div>
            <a href="<?= APP_URL ?>/truyen-de-xuat" class="btn btn-outline-primary">
                <i class="fas fa-list me-1"></i>Xem tất cả
            </a>
        </div>
        <div class="position-relative">
            <button class="scroll-btn scroll-left btn btn-light position-absolute top-50 start-0 translate-middle-y shadow" style="z-index:2;" title="Trượt sang trái"><i class="fas fa-chevron-left"></i></button>
            <div class="suggested-scroll row flex-nowrap overflow-auto pb-2" style="scroll-behavior:smooth;">
                <?php foreach ($suggestedStories as $story): ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6 mb-4" style="min-width:227px;max-width:227px;">
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
                        <div class="card-body d-flex flex-column justify-content-between" style="flex:1 1 auto;">
                            <h5 class="card-title mb-1" style="margin-bottom:0.1em !important;">
                                <?= htmlspecialchars($story['title']) ?>
                            </h5>
                            <p class="author" style="margin-bottom:0.12rem;margin-top:0;font-size:0.85em;">
                                <i class="fas fa-user me-1"></i><?= htmlspecialchars($story['author']) ?>
                            </p>
                            <div class="category-pills mb-2" style="gap:0.25em;">
                                <?php
                                $categories = $this->db->fetchAll(
                                    "SELECT c.id, c.name FROM categories c 
                                     JOIN story_category sc ON c.id = sc.category_id 
                                     WHERE sc.story_id = ?",
                                    [$story['id']]
                                );
                                $maxCategories = 2;
                                $catCount = count($categories);
                                $displayed = 0;
                                foreach ($categories as $category):
                                    if ($displayed >= $maxCategories) break;
                                ?>
                                <span class="category-pill" style="font-size:0.8em;padding:0.08em 0.38em;border-radius:6px;min-width:unset;display:inline-block;">
                                    <?= htmlspecialchars($category['name']) ?>
                                </span>
                                <?php $displayed++; endforeach; ?>
                                <?php if ($catCount > $maxCategories): ?>
                                <span class="category-pill" style="font-size:0.8em;padding:0.08em 0.38em;border-radius:6px;min-width:unset;display:inline-block;background:#eee;color:#888;">...</span>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="read-btn-wrapper">
                                    <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>" class="btn btn-outline-primary btn-sm mt-auto w-100" style="margin-top:auto;">
                                        <i class="fas fa-book-open me-1"></i>Đọc
                                    </a>
                                </div>
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
            <h2>Truyện mới cập nhật</h2>
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
                        <div class="info-group">
                            <h5 class="card-title mb-1" style="margin-bottom:0.2em !important;">
                                <?= htmlspecialchars($story['title']) ?>
                            </h5>
                            <p class="author" style="margin-bottom:0.25rem;margin-top:0;">
                                <i class="fas fa-user me-1"></i><?= htmlspecialchars($story['author']) ?>
                            </p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="read-btn-wrapper">
                                <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-book-open me-1"></i>Đọc
                                </a>
                            </div>
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
.suggested-slider {
    margin-top: 1.5rem;
}
.suggested-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 16px rgba(102,126,234,0.10);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
    min-height: 320px;
    transition: box-shadow 0.2s;
}
.suggested-card:hover {
    box-shadow: 0 8px 32px rgba(102,126,234,0.18);
}
.suggested-thumb {
    width: 100%;
    aspect-ratio: 3/4;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.suggested-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 16px 16px 0 0;
    transition: transform 0.3s;
}
.suggested-card:hover .suggested-thumb img {
    transform: scale(1.04);
}
.suggested-title {
    font-weight: 600;
    font-size: 1.1rem;
    color: #222;
    text-align: center;
    margin: 1rem 0 0.5rem 0;
    padding: 0 10px;
    line-height: 1.3;
    min-height: 2.6em;
    max-height: 2.6em;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
}
.suggested-swiper .swiper-slide {
    height: 100%;
    display: flex;
    align-items: stretch;
}
.suggested-swiper {
    padding-bottom: 32px;
}
.suggested-swiper .swiper-button-prev,
.suggested-swiper .swiper-button-next {
    color: #3b5bdb;
    background: #fff;
    border-radius: 50%;
    box-shadow: 0 2px 8px rgba(102,126,234,0.10);
    width: 38px;
    height: 38px;
    top: 40%;
    transition: background 0.2s;
}
.suggested-swiper .swiper-button-prev:hover,
.suggested-swiper .swiper-button-next:hover {
    background: #e9ecef;
}
.suggested-swiper .swiper-button-prev:after,
.suggested-swiper .swiper-button-next:after {
    font-size: 1.3rem;
}
.suggested-swiper .swiper-wrapper {
    gap: 20px;
}
.suggested-scroll {
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE 10+ */
}
.suggested-scroll::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}
.suggested-scroll .card-body {
    padding-top: 10px;
    padding-bottom: 10px;
}
.suggested-scroll .card-title {
    margin-bottom: 2px !important;
    margin-top: 0 !important;
}
.suggested-scroll .author {
    margin-bottom: 2px !important;
    margin-top: 0 !important;
    padding-top: 0 !important;
    line-height: 1.1;
}
.suggested-scroll .category-pills {
    margin-bottom: 4px !important;
    margin-top: 0 !important;
}
</style>
<script>
// Initialize Swiper for Featured Stories
document.addEventListener('DOMContentLoaded', function() {
    // Kiểm tra số lượng slide
    const slideCount = document.querySelectorAll('.featured-swiper .swiper-slide').length;
    console.log('Số lượng slide truyện nổi bật:', slideCount);
    const swiper = new Swiper('.featured-swiper', {
        slidesPerView: 5,
        slidesPerGroup: 1,
        spaceBetween: 4,
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
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
            640: { slidesPerView: 2, slidesPerGroup: 1 },
            768: { slidesPerView: 3, slidesPerGroup: 1 },
            1024: { slidesPerView: 4, slidesPerGroup: 1 },
            1200: { slidesPerView: 5, slidesPerGroup: 1 }
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
    btnLeft.onclick = () => {
        const card = scrollRow.querySelector('.col-lg-3');
        const cards = scrollRow.querySelectorAll('.col-lg-3');
        if (!card) return;
        let scrollAmount = card.offsetWidth;
        if (cards.length > 1) {
            const gap = cards[1].offsetLeft - cards[0].offsetLeft - cards[0].offsetWidth;
            scrollAmount += gap;
        }
        if (scrollRow.scrollLeft <= 0) {
            scrollRow.scrollTo({left: scrollRow.scrollWidth - scrollRow.clientWidth, behavior: 'smooth'});
        } else {
            scrollRow.scrollBy({left: -scrollAmount, behavior: 'smooth'});
        }
    };
    btnRight.onclick = () => {
        const card = scrollRow.querySelector('.col-lg-3');
        const cards = scrollRow.querySelectorAll('.col-lg-3');
        if (!card) return;
        let scrollAmount = card.offsetWidth;
        if (cards.length > 1) {
            const gap = cards[1].offsetLeft - cards[0].offsetLeft - cards[0].offsetWidth;
            scrollAmount += gap;
        }
        if (scrollRow.scrollLeft >= scrollRow.scrollWidth - scrollRow.clientWidth - 2) {
            scrollRow.scrollTo({left: 0, behavior: 'smooth'});
        } else {
            scrollRow.scrollBy({left: scrollAmount, behavior: 'smooth'});
        }
    };
}

// Initialize Swiper for Latest Stories
const latestSwiper = new Swiper('.latest-swiper', {
    slidesPerView: 6,
    slidesPerGroup: 1,
    spaceBetween: 16,
    loop: true,
    loopedSlides: 12,
    centeredSlides: false,
    navigation: {
        nextEl: '.latest-swiper .swiper-button-next',
        prevEl: '.latest-swiper .swiper-button-prev',
    },
    pagination: {
        el: '.latest-swiper .swiper-pagination',
        clickable: true,
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
        1200: {
            slidesPerView: 6,
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const suggestedSwiper = new Swiper('.suggested-swiper', {
        slidesPerView: 4,
        slidesPerGroup: 1,
        spaceBetween: 20,
        loop: true,
        navigation: {
            nextEl: '.suggested-swiper .swiper-button-next',
            prevEl: '.suggested-swiper .swiper-button-prev',
        },
        breakpoints: {
            640: { slidesPerView: 1, slidesPerGroup: 1 },
            900: { slidesPerView: 2, slidesPerGroup: 1 },
            1200: { slidesPerView: 3, slidesPerGroup: 1 },
            1400: { slidesPerView: 4, slidesPerGroup: 1 }
        }
    });
});
</script> 