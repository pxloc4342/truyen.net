<?php /** @var array $stories */ ?>
<div class="container py-4">
  <h2 class="mb-4"><i class="fas fa-heart me-2 text-danger"></i>Truyện yêu thích</h2>
  <?php if (empty($stories)): ?>
    <div class="alert alert-info">Bạn chưa lưu truyện nào vào mục yêu thích.</div>
  <?php else: ?>
    <div class="row">
      <?php foreach ($stories as $story): ?>
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
          <div class="card h-100 shadow-sm text-center" style="border-radius: 24px; overflow: hidden; min-height: 370px; max-height: 390px;">
            <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>">
              <img src="<?= $story['thumbnail'] ? APP_URL . $story['thumbnail'] : APP_URL . '/assets/images/default_cover.jpg' ?>" alt="<?= htmlspecialchars($story['title']) ?>" style="width:100%;height:260px;object-fit:cover;border-radius: 0 0 0 0;">
            </a>
            <div class="card-body d-flex flex-column align-items-center p-2" style="padding-bottom: 4px !important;">
              <h5 class="card-title mb-1 mt-2" style="font-size:1.02rem; min-height: 36px; display: flex; align-items: center; justify-content: center;">
                <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>" class="text-decoration-none text-dark">
                  <?= htmlspecialchars($story['title']) ?>
                </a>
              </h5>
              <div class="d-flex gap-2 justify-content-center mt-1 mb-0">
                <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>" class="btn btn-outline-primary btn-xs d-flex align-items-center px-2 py-1" style="font-size:0.92rem;">
                  <i class="fas fa-book-open me-1"></i> Đọc
                </a>
                <form method="post" action="<?= APP_URL ?>/toggle-favorite" class="m-0 p-0">
                  <input type="hidden" name="story_id" value="<?= $story['id'] ?>">
                  <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
                  <button type="submit" class="btn btn-outline-danger btn-xs d-flex align-items-center px-2 py-1" style="font-size:0.92rem;">
                    <i class="fas fa-trash-alt me-1"></i> Xóa
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div> 