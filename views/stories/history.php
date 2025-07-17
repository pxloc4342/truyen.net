<?php /** @var array $history */ ?>
<div class="container py-4">
    <h2 class="mb-4">Lịch sử đọc truyện</h2>
    <?php if (empty($history)): ?>
        <div class="alert alert-info">Bạn chưa đọc truyện nào gần đây.</div>
    <?php else: ?>
        <div class="row g-3">
            <?php foreach (array_slice($history, 0, 24) as $item): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <div class="card h-100 shadow-sm">
                        <a href="<?= APP_URL ?>/truyen/<?= $item['story_id'] ?>">
                            <img src="<?= $item['thumbnail'] ? APP_URL . $item['thumbnail'] : APP_URL . '/assets/images/default_cover.jpg' ?>" class="card-img-top" style="height:150px;object-fit:cover;" alt="<?= htmlspecialchars($item['story_title']) ?>">
                        </a>
                        <div class="card-body p-2">
                            <h6 class="card-title mb-1" style="font-size:1rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <a href="<?= APP_URL ?>/truyen/<?= $item['story_id'] ?>" class="text-dark text-decoration-none">
                                    <?= htmlspecialchars($item['story_title']) ?>
                                </a>
                            </h6>
                            <div class="small text-muted mb-2">Chương gần nhất: <b><?= htmlspecialchars($item['chapter_title'] ?: 'Chương ' . $item['chapter_number']) ?></b></div>
                            <a href="<?= APP_URL ?>/truyen/<?= $item['story_id'] ?>/chuong/<?= $item['chapter_id'] ?>" class="btn btn-primary btn-sm w-100">Tiếp tục đọc</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div> 