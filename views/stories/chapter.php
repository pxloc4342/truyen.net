<?php /* Trang đọc chương truyện hiện đại, đẹp, dark mode, responsive */ ?>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&family=Roboto+Slab:wght@400;700&display=swap" rel="stylesheet">
<style>
.chapter-title {
    font-family: 'Merriweather', 'Georgia', 'Roboto Slab', serif;
    font-size: 2.1rem;
    font-weight: 700;
    color: #222;
    text-align: center;
    margin: 0 auto 10px auto;
    padding: 20px 0 10px 0;
    letter-spacing: 0.01em;
}
.chapter-story-title {
    font-family: 'Merriweather', 'Georgia', 'Roboto Slab', serif;
    font-size: 1.2rem;
    color: #444;
    text-align: center;
    font-weight: 500;
    margin-bottom: 0.5em;
}
.chapter-nav {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin: 0 auto 24px auto;
    flex-wrap: wrap;
}
.chapter-nav .btn {
    min-width: 120px;
    font-size: 1.05rem;
    font-weight: 600;
    transition: background 0.3s, color 0.3s, border 0.3s, box-shadow 0.3s;
}
.chapter-nav .btn-list {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: #fff;
    border: none;
    box-shadow: 0 2px 10px rgba(102,126,234,0.08);
}
.chapter-nav .btn-list:hover {
    background: linear-gradient(45deg, #5a6fd8, #6a4c93);
    color: #fff;
}
.chapter-nav .btn-outline-primary {
    border-radius: 30px;
}
.chapter-nav .btn-outline-primary:hover {
    background: #667eea;
    color: #fff;
    border-color: #667eea;
}
@media (max-width: 600px) {
    .chapter-nav { flex-direction: column; gap: 0.7rem; }
    .chapter-nav .btn { width: 100%; min-width: unset; }
}
.chapter-content {
    max-width: 700px;
    margin: 0 auto 2.5rem auto;
    font-family: 'Merriweather', 'Open Sans', 'Georgia', serif;
    font-size: 19px;
    line-height: 1.85;
    color: #333;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 16px rgba(102,126,234,0.04);
    padding: 2.2rem 1.5rem;
    transition: background 0.3s, color 0.3s;
    animation: fadeIn 0.7s;
}
.chapter-content p { margin-bottom: 1.2em; }
.chapter-content img { max-width: 100%; height: auto; display: block; margin: 1.2em auto; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }

/* Dark mode */
body.dark-mode, .chapter-content.dark-mode {
    background: #181a1b !important;
    color: #e0e0e0 !important;
}
body.dark-mode .chapter-content {
    background: #23272b !important;
    color: #e0e0e0 !important;
}
body.dark-mode .chapter-title, body.dark-mode .chapter-story-title {
    color: #f1f1f1 !important;
}
body.dark-mode .chapter-nav .btn-list {
    background: linear-gradient(45deg, #2323a7, #764ba2);
    color: #fff;
}
body.dark-mode .chapter-nav .btn-outline-primary {
    border-color: #bbb;
    color: #eee;
    background: transparent;
}
body.dark-mode .chapter-nav .btn-outline-primary:hover {
    background: #2323a7;
    color: #fff;
    border-color: #2323a7;
}
body.dark-mode a, body.dark-mode .chapter-content a { color: #7ecfff; }
body.dark-mode .chapter-content img { box-shadow: 0 2px 8px rgba(0,0,0,0.18); }

/* Fade-in effect */
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

/* Scroll to top button */
#scrollToTopBtn {
    position: fixed;
    right: 24px;
    bottom: 24px;
    z-index: 999;
    display: none;
    background: #667eea;
    color: #fff;
    border: none;
    border-radius: 50%;
    width: 48px;
    height: 48px;
    font-size: 1.5rem;
    box-shadow: 0 2px 10px rgba(102,126,234,0.18);
    transition: background 0.2s;
}
#scrollToTopBtn:hover { background: #764ba2; }

/* Dark mode for scroll to top */
body.dark-mode #scrollToTopBtn { background: #2323a7; color: #fff; }
</style>

<div class="container py-3">
    <div class="chapter-title fade-in">
        <?= htmlspecialchars($story['title']) ?>
    </div>
    <div class="chapter-story-title fade-in">
        <?= htmlspecialchars($chapter['title']) ?>
    </div>
    <div class="chapter-nav sticky-top py-2 bg-white fade-in justify-content-center d-flex" style="top: 0; z-index: 10;">
        <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $prevChapter ? $prevChapter['id'] : $chapter['id'] ?>" class="btn btn-outline-primary<?= !$prevChapter ? ' disabled' : '' ?>">
            <i class="fas fa-angle-left me-1"></i> Chương trước
        </a>
        <div class="dropdown d-inline-block" style="margin: 0 8px;">
            <button class="btn btn-list dropdown-toggle px-4 py-2" type="button" id="chapterDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 30px; box-shadow: 0 2px 8px rgba(102,126,234,0.10); font-weight:600;">
                <i class="fas fa-list me-1"></i> Danh sách chương
            </button>
            <ul class="dropdown-menu text-center" aria-labelledby="chapterDropdown" style="max-height:320px;overflow-y:auto;min-width:170px;border-radius:18px;box-shadow:0 4px 24px rgba(102,126,234,0.13);left:50%;transform:translateX(-50%);">
                <?php if (!empty($chapters)): ?>
                    <?php foreach ($chapters as $ch): ?>
                        <li>
                            <a class="dropdown-item py-2<?= $ch['id'] == $chapter['id'] ? ' active fw-bold text-primary' : '' ?>" href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $ch['id'] ?>" style="border-radius:12px;transition:background 0.2s;">
                                Chương <?= (int)$ch['chapter_number'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $nextChapter ? $nextChapter['id'] : $chapter['id'] ?>" class="btn btn-outline-primary<?= !$nextChapter ? ' disabled' : '' ?>">
            Chương sau <i class="fas fa-angle-right ms-1"></i>
        </a>
    </div>
    <div class="chapter-content fade-in" id="chapterContent">
        <?= $chapterContent ?>
    </div>
    <div class="chapter-nav py-2 bg-white fade-in justify-content-center d-flex" style="margin-top: -1.5rem;">
        <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $prevChapter ? $prevChapter['id'] : $chapter['id'] ?>" class="btn btn-outline-primary<?= !$prevChapter ? ' disabled' : '' ?>">
            <i class="fas fa-angle-left me-1"></i> Chương trước
        </a>
        <div class="dropdown d-inline-block" style="margin: 0 8px;">
            <button class="btn btn-list dropdown-toggle px-4 py-2" type="button" id="chapterDropdown2" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 30px; box-shadow: 0 2px 8px rgba(102,126,234,0.10); font-weight:600;">
                <i class="fas fa-list me-1"></i> Danh sách chương
            </button>
            <ul class="dropdown-menu text-center" aria-labelledby="chapterDropdown2" style="max-height:320px;overflow-y:auto;min-width:170px;border-radius:18px;box-shadow:0 4px 24px rgba(102,126,234,0.13);left:50%;transform:translateX(-50%);">
                <?php if (!empty($chapters)): ?>
                    <?php foreach ($chapters as $ch): ?>
                        <li>
                            <a class="dropdown-item py-2<?= $ch['id'] == $chapter['id'] ? ' active fw-bold text-primary' : '' ?>" href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $ch['id'] ?>" style="border-radius:12px;transition:background 0.2s;">
                                Chương <?= (int)$ch['chapter_number'] ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
        <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $nextChapter ? $nextChapter['id'] : $chapter['id'] ?>" class="btn btn-outline-primary<?= !$nextChapter ? ' disabled' : '' ?>">
            Chương sau <i class="fas fa-angle-right ms-1"></i>
        </a>
    </div>
    <button id="darkModeToggle" class="btn btn-outline-secondary position-fixed" style="top: 24px; right: 24px; z-index: 1001;">
        <i class="fas fa-moon"></i>
    </button>
    <button id="scrollToTopBtn" title="Lên đầu trang"><i class="fas fa-arrow-up"></i></button>
</div>

<script>
// Dark mode toggle
const darkBtn = document.getElementById('darkModeToggle');
function setDarkMode(on) {
    if (on) {
        document.body.classList.add('dark-mode');
        localStorage.setItem('darkMode', '1');
    } else {
        document.body.classList.remove('dark-mode');
        localStorage.setItem('darkMode', '0');
    }
}
darkBtn.onclick = () => setDarkMode(!document.body.classList.contains('dark-mode'));
if (localStorage.getItem('darkMode') === '1') setDarkMode(true);

// Scroll to top
const scrollBtn = document.getElementById('scrollToTopBtn');
window.addEventListener('scroll', function() {
    if(window.scrollY > 200) scrollBtn.style.display = 'block';
    else scrollBtn.style.display = 'none';
});
scrollBtn.onclick = () => window.scrollTo({top:0,behavior:'smooth'});

// Fade-in effect for chapter content
window.addEventListener('DOMContentLoaded', function() {
    document.getElementById('chapterContent').classList.add('fade-in');
});
</script> 