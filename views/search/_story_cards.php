<?php if (empty($stories)): ?>
    <div class="no-result">Không tìm thấy truyện phù hợp.</div>
<?php else: ?>
    <div class="story-grid">
        <?php foreach ($stories as $story): ?>
            <?php
            $cover = !empty($story['thumbnail']) ? $story['thumbnail'] : '/assets/images/default.jpg';
            if (strpos($cover, 'http') === 0) {
                // giữ nguyên
            } elseif (strpos($cover, '/assets/images/') === 0) {
                $cover = APP_URL . $cover;
            } elseif ($cover && $cover !== '/assets/images/default.jpg') {
                $cover = APP_URL . '/assets/images/' . $cover;
            } else {
                $cover = APP_URL . '/assets/images/default.jpg';
            }
            ?>
            <div class="story-card">
                <div class="cover-wrap">
                    <img src="<?= htmlspecialchars($cover) ?>" alt="<?= htmlspecialchars($story['title']) ?>">
                </div>
                <div class="story-info">
                    <div class="story-title"> <?= htmlspecialchars($story['title']) ?> </div>
                    <div class="story-chapter">
                        <?php
                        if (!empty($story['latest_chapter_id'])) {
                            echo 'Chapter ' . htmlspecialchars($story['latest_chapter_id']);
                        } else {
                            echo '&nbsp;';
                        }
                        ?>
                    </div>
                    <a class="read-btn" href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>">Đọc</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<style>
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
    height: 100%;
}
.story-info {
    padding: 12px 10px 14px 10px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    flex: 1 1 auto;
    justify-content: flex-start;
}
.read-btn {
    margin-top: auto;
}
</style> 