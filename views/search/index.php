<?php
// Biến truyền vào: $categories, $stories, $keyword, $category, $status
?>
<div class="search-page">
    <form class="search-form" method="get" action="">
        <div class="search-bar">
            <input type="text" name="q" placeholder="Tìm tên truyện..." value="<?= htmlspecialchars($keyword) ?>" autocomplete="off">
            <button type="submit">Tìm kiếm</button>
        </div>
        <div class="filters">
            <select name="category">
                <option value="">-- Thể loại --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $category == $cat['id'] ? 'selected' : '' ?>><?= htmlspecialchars($cat['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="status">
                <option value="">-- Trạng thái --</option>
                <option value="completed" <?= $status == 'completed' ? 'selected' : '' ?>>Hoàn thành</option>
                <option value="ongoing" <?= $status == 'ongoing' ? 'selected' : '' ?>>Đang ra</option>
                <option value="paused" <?= $status == 'paused' ? 'selected' : '' ?>>Tạm dừng</option>
            </select>
        </div>
    </form>
    <div class="search-results" id="search-results">
        <?php include __DIR__ . '/_story_cards.php'; ?>
    </div>
</div>

<style>
.search-page {
    max-width: 1200px;
    margin: 0 auto;
    padding: 24px 8px;
}
.search-form {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    align-items: center;
    margin-bottom: 24px;
}
.search-bar {
    flex: 1 1 300px;
    display: flex;
    gap: 8px;
    position: relative;
}
.search-bar input[type="text"] {
    width: 100%;
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 1rem;
}
.search-bar button {
    padding: 8px 18px;
    border-radius: 6px;
    border: none;
    background: #2d8cf0;
    color: #fff;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.2s;
}
.search-bar button:hover {
    background: #1766b0;
}
.filters select {
    padding: 8px 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 1rem;
    margin-right: 8px;
}
.story-grid {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 20px;
}
@media (max-width: 1100px) {
    .story-grid { grid-template-columns: repeat(4, 1fr); }
}
@media (max-width: 900px) {
    .story-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 600px) {
    .story-grid { grid-template-columns: repeat(2, 1fr); }
}
.story-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    align-items: stretch;
    transition: box-shadow 0.2s;
    min-height: 260px;
}
.story-card:hover {
    box-shadow: 0 4px 24px rgba(0,0,0,0.16);
}
.cover-wrap {
    width: 100%;
    aspect-ratio: 3/4;
    background: #f3f3f3;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border-top-left-radius: 14px;
    border-top-right-radius: 14px;
}
.cover-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
    transition: transform 0.2s;
}
.story-card:hover .cover-wrap img {
    transform: scale(1.04);
}
.story-info {
    padding: 12px 10px 14px 10px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    flex: 1 1 auto;
}
.story-title {
    font-size: 1.08rem;
    font-weight: bold;
    color: #222;
    margin-bottom: 2px;
    line-height: 1.2;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.story-chapter {
    font-size: 0.98rem;
    color: #666;
    min-height: 18px;
}
.read-btn {
    margin-top: 8px;
    padding: 7px 0;
    background: #2d8cf0;
    color: #fff;
    border-radius: 6px;
    text-align: center;
    font-weight: 500;
    text-decoration: none;
    transition: background 0.2s;
    font-size: 1rem;
}
.read-btn:hover {
    background: #1766b0;
}
.no-result {
    text-align: center;
    color: #888;
    font-size: 1.1rem;
    margin: 40px 0;
}
.autocomplete-dropdown {
    position: absolute;
    left: 0; right: 0;
    top: 100%;
    margin-top: 2px;
    background: #fff;
    border: 1px solid #d0d0d0;
    border-radius: 8px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.13);
    z-index: 99;
    max-height: 320px;
    overflow-y: auto;
    min-width: 220px;
    padding: 4px 0;
}
.autocomplete-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 8px 14px;
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.15s;
    border-radius: 5px;
}
.autocomplete-item img {
    width: 34px; height: 44px;
    object-fit: cover;
    border-radius: 5px;
    background: #eee;
    flex-shrink: 0;
}
.autocomplete-item span {
    flex: 1 1 auto;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.autocomplete-item:hover {
    background: #f2f6fa;
}
</style>

<script>
// Lắng nghe submit form và thay đổi filter
const form = document.querySelector('.search-form');
const results = document.getElementById('search-results');
let ajaxTimeout = null;

function doAjaxSearch() {
    const formData = new FormData(form);
    const params = new URLSearchParams(formData).toString();
    results.innerHTML = '<div style="text-align:center;padding:40px 0;">Đang tải...</div>';
    fetch('/tim-kiem/ajax?' + params)
        .then(res => res.text())
        .then(html => {
            results.innerHTML = html;
        });
}

form.addEventListener('submit', function(e) {
    e.preventDefault();
    doAjaxSearch();
});

// Tự động Ajax khi thay đổi input/select (debounce)
form.querySelectorAll('input, select').forEach(el => {
    el.addEventListener('input', function() {
        clearTimeout(ajaxTimeout);
        ajaxTimeout = setTimeout(doAjaxSearch, 350);
    });
});

// Lấy APP_URL từ PHP
const APP_URL = "<?= APP_URL ?>";

// Autocomplete cho ô tìm kiếm
const searchInput = form.querySelector('input[name="q"]');
let acDropdown = null;
let acTimeout = null;

searchInput.addEventListener('input', function() {
    const val = this.value.trim();
    if (val.length < 2) {
        if (acDropdown) acDropdown.remove();
        return;
    }
    clearTimeout(acTimeout);
    acTimeout = setTimeout(() => {
        fetch(APP_URL + '/tim-kiem/autocomplete?q=' + encodeURIComponent(val))
            .then(res => res.json())
            .then(data => {
                if (acDropdown) acDropdown.remove();
                if (!data.length) return;
                acDropdown = document.createElement('div');
                acDropdown.className = 'autocomplete-dropdown';
                data.forEach(story => {
                    let cover = story.thumbnail && story.thumbnail.trim() ? story.thumbnail : APP_URL + '/assets/images/default.jpg';
                    if (cover.startsWith('http')) {
                        // giữ nguyên
                    } else if (cover.startsWith('/assets/images/')) {
                        cover = APP_URL + cover;
                    } else if (cover && cover !== APP_URL + '/assets/images/default.jpg') {
                        cover = APP_URL + '/assets/images/' + cover;
                    } else {
                        cover = APP_URL + '/assets/images/default.jpg';
                    }
                    const item = document.createElement('div');
                    item.className = 'autocomplete-item';
                    item.innerHTML = `<img src="${cover}" onerror=\"this.src='${APP_URL}/assets/images/default.jpg'\"><span>${story.title}</span>`;
                    item.addEventListener('mousedown', function(e) {
                        e.preventDefault();
                        searchInput.value = story.title;
                        if (acDropdown) acDropdown.remove();
                        setTimeout(() => {
                            form.dispatchEvent(new Event('submit'));
                        }, 10);
                    });
                    acDropdown.appendChild(item);
                });
                // Xóa dropdown cũ nếu có
                searchInput.parentNode.querySelectorAll('.autocomplete-dropdown').forEach(d => d.remove());
                searchInput.parentNode.appendChild(acDropdown);
            });
    }, 200);
});

document.addEventListener('click', function(e) {
    if (acDropdown && !acDropdown.contains(e.target) && e.target !== searchInput) {
        acDropdown.remove();
    }
});
</script> 