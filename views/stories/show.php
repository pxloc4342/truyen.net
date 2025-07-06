<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mt-4">
  <ol class="breadcrumb bg-white px-0">
    <li class="breadcrumb-item"><a href="<?= APP_URL ?>/">Trang chủ</a></li>
    <?php if (!empty($story['categories'])): ?>
      <li class="breadcrumb-item">
        <a href="<?= APP_URL ?>/the-loai/<?= $story['categories'][0]['id'] ?>">
          <?= htmlspecialchars($story['categories'][0]['name']) ?>
        </a>
      </li>
    <?php endif; ?>
    <li class="breadcrumb-item active" aria-current="page"><?= htmlspecialchars($story['title']) ?></li>
  </ol>
</nav>

<div class="container mt-4">
  <div class="row">
    <!-- Cột trái: Ảnh bìa -->
    <div class="col-md-4 text-center mb-4 mb-md-0">
      <img src="<?= $story['thumbnail'] ? APP_URL . $story['thumbnail'] : APP_URL . '/assets/images/default_cover.jpg' ?>"
           alt="<?= htmlspecialchars($story['title']) ?>"
           class="img-fluid shadow-sm"
           style="max-width:180px; max-height:250px; border-radius:12px; object-fit:cover;">
    </div>
    <!-- Cột phải: Thông tin truyện -->
    <div class="col-md-8">
      <h1 class="fw-bold mb-2" style="font-size:2rem;"> <?= htmlspecialchars($story['title']) ?> </h1>
      <p class="fst-italic text-muted mb-2">
        <i class="fas fa-pen-nib me-1"></i> <?= htmlspecialchars($story['author']) ?>
      </p>
      <div class="mb-2">
        <?php if (!empty($story['categories'])): ?>
          <?php foreach ($story['categories'] as $category): ?>
            <span class="badge bg-primary me-1 mb-1"> <?= htmlspecialchars($category['name']) ?> </span>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
      <div class="mb-2">
        <?php
          $statusMap = [
            'ongoing' => ['Đang ra', 'success'],
            'completed' => ['Hoàn thành', 'danger'],
            'hiatus' => ['Tạm ngưng', 'warning']
          ];
          $status = $statusMap[$story['status']] ?? ['Đang ra', 'success'];
        ?>
        <span class="badge bg-<?= $status[1] ?>"> <?= $status[0] ?> </span>
      </div>
      <div class="mb-3">
        <div class="story-desc" style="max-height:7.5em; overflow:hidden; position:relative;">
          <?= nl2br(htmlspecialchars($story['description'])) ?>
        </div>
        <button class="btn btn-link p-0 mt-1" id="toggleDesc">Xem thêm...</button>
      </div>
      <div class="d-flex gap-2 mb-3">
        <?php $firstChapterId = !empty($chapters) ? $chapters[0]['id'] : 1; ?>
        <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $firstChapterId ?>" class="btn btn-primary">
          <i class="fas fa-book-open me-1"></i> Đọc từ đầu
        </a>
        <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/moi-nhat" class="btn btn-outline-primary">
          <i class="fas fa-bolt me-1"></i> Đọc mới nhất
        </a>
      </div>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <form method="post" action="<?= APP_URL ?>/toggle-favorite" style="display:inline;">
          <input type="hidden" name="story_id" value="<?= $story['id'] ?>">
          <input type="hidden" name="redirect" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
          <button type="submit" name="toggle_favorite" style="background:<?= !empty($story['is_favorite']) ? '#fff' : '#ff5e62' ?>;color:<?= !empty($story['is_favorite']) ? '#ff5e62' : '#fff' ?>;border:2px solid <?= !empty($story['is_favorite']) ? '#ff5e62' : 'transparent' ?>;padding:6px 18px;border-radius:8px;font-weight:600;box-shadow:0 2px 8px rgba(255,94,98,0.08);margin-bottom:12px;transition:background 0.2s, border 0.2s;">
            <?= !empty($story['is_favorite']) ? 'Đã yêu thích' : 'Yêu thích' ?>
          </button>
        </form>
      <?php else: ?>
        <button type="button" onclick="alert('Bạn cần đăng nhập để sử dụng tính năng này!')" style="background:#ff5e62;color:#fff;border:none;padding:6px 18px;border-radius:8px;font-weight:600;box-shadow:0 2px 8px rgba(255,94,98,0.08);margin-bottom:12px;transition:background 0.2s;">Yêu thích</button>
      <?php endif; ?>
    </div>
  </div>

  <!-- Danh sách chương -->
  <div class="mt-5">
    <h4 class="mb-3">Danh sách chương</h4>
    <div class="table-responsive">
      <table class="table table-bordered align-middle bg-white">
        <thead class="table-light">
          <tr>
            <th style="width:60px;">#</th>
            <th>Tên chương</th>
            <th style="width:140px;">Ngày đăng</th>
            <th style="width:80px;"></th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($chapters)): ?>
            <?php foreach ($chapters as $i => $chapter): ?>
              <tr>
                <td><?= $i+1 ?></td>
                <td>
                  <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $chapter['id'] ?>">
                    <?= htmlspecialchars($chapter['title'] ?: 'Chương ' . ($i+1)) ?>
                  </a>
                </td>
                <td><?= date('d/m/Y', strtotime($chapter['created_at'])) ?></td>
                <td>
                  <a href="<?= APP_URL ?>/truyen/<?= $story['id'] ?>/chuong/<?= $chapter['id'] ?>" class="btn btn-sm btn-outline-primary">Đọc</a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="4" class="text-center text-muted">Chưa có chương nào.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- Form bình luận -->
<div class="container mt-4">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 rounded-top-4 pb-0">
          <h5 class="mb-0 text-primary"><i class="fas fa-comments me-2"></i>Bình luận truyện</h5>
        </div>
        <div class="card-body">
          <form method="POST" action="" class="d-flex align-items-end gap-2">
            <div class="flex-grow-1">
              <label for="comment_content" class="form-label visually-hidden">Nội dung bình luận</label>
              <div class="input-group input-group-lg">
                <span class="input-group-text bg-white border-end-0"><i class="far fa-comment-dots text-primary"></i></span>
                <textarea class="form-control border-start-0 rounded-end-4" id="comment_content" name="comment_content" rows="2" placeholder="Viết bình luận của bạn..." required style="resize:none;"></textarea>
              </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg rounded-4 px-4 shadow-sm" title="Gửi bình luận">
              <i class="fas fa-paper-plane"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
// Xem thêm mô tả
const btn = document.getElementById('toggleDesc');
const desc = document.querySelector('.story-desc');
let expanded = false;
btn.addEventListener('click', function() {
  if (!expanded) {
    desc.style.maxHeight = 'none';
    btn.textContent = 'Thu gọn';
  } else {
    desc.style.maxHeight = '7.5em';
    btn.textContent = 'Xem thêm...';
  }
  expanded = !expanded;
});
</script> 