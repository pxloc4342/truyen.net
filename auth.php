<!doctype html>
<html lang="en">
<head>
  <title>Authentication</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://unicons.iconscout.com/release/v2.1.9/css/unicons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/auth.css">
</head>
<body>
  <?php if (!empty($_SESSION['error_message'])): ?>
    <div style="margin: 0 auto; max-width: 420px; margin-top: 24px;" class="alert alert-danger text-center">
      <?= htmlspecialchars($_SESSION['error_message']) ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>
  <a href="/WebTruyenTranh/" class="btn btn-home btn-outline-primary" style="font-weight:500; font-size:12px; padding:2px 12px; border-radius:8px; height:32px; line-height:28px; position:absolute; top:8px; left:8px; z-index:1000;">TRANG CHỦ</a>
  <div class="section">
    <div class="container">
      <div class="row full-height justify-content-center">
        <div class="col-12 text-center align-self-center py-5">
          <div class="section pb-5 pt-5 pt-sm-2 text-center">
            <h6 class="mb-0 pb-3"><span id="login-tab">Đăng nhập </span><span id="register-tab">Đăng ký</span></h6>
            <input class="checkbox" type="checkbox" id="reg-log" name="reg-log"/>
            <label for="reg-log"></label>
            <div class="card-3d-wrap mx-auto">
              <div class="card-3d-wrapper">
                <div class="card-front">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 class="mb-4 pb-3">Đăng nhập</h4>
                      <form method="POST" action="dang-nhap">
                        <div class="form-group">
                          <input type="text" class="form-style" name="username" placeholder="Tên đăng nhập hoặc Email" required>
                          <i class="input-icon uil uil-at"></i>
                        </div>  
                        <div class="form-group mt-2">
                          <input type="password" class="form-style" name="password" placeholder="Mật khẩu" required>
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <button type="submit" class="btn mt-4">Đăng nhập</button>
                      </form>
                      <p class="mb-0 mt-4 text-center"><a href="#" class="link">Quên mật khẩu?</a></p>
                    </div>
                  </div>
                </div>
                <div class="card-back">
                  <div class="center-wrap">
                    <div class="section text-center">
                      <h4 class="mb-3 pb-3">Đăng ký</h4>
                      <form method="POST" action="dang-ky">
                        <div class="form-group">
                          <input type="text" class="form-style" name="name" placeholder="Họ và tên" required>
                          <i class="input-icon uil uil-user"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input type="email" class="form-style" name="email" placeholder="Gmail" required>
                          <i class="input-icon uil uil-at"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input type="password" class="form-style" name="password" placeholder="Mật khẩu" required>
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <div class="form-group mt-2">
                          <input type="password" class="form-style" name="confirm_password" placeholder="Xác nhận mật khẩu" required>
                          <i class="input-icon uil uil-lock-alt"></i>
                        </div>
                        <button type="submit" class="btn mt-4">Đăng ký</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<script>
  const regLogCheckbox = document.getElementById('reg-log');
  const loginTab = document.getElementById('login-tab');
  const registerTab = document.getElementById('register-tab');
  function updateTabShadow() {
    if (!regLogCheckbox.checked) {
      loginTab.classList.add('tab-active');
      registerTab.classList.remove('tab-active');
    } else {
      loginTab.classList.remove('tab-active');
      registerTab.classList.add('tab-active');
    }
  }
  loginTab.onclick = function() {
    regLogCheckbox.checked = false;
    updateTabShadow();
  };
  registerTab.onclick = function() {
    regLogCheckbox.checked = true;
    updateTabShadow();
  };
  regLogCheckbox.addEventListener('change', updateTabShadow);
  // Tự động chuyển sang tab Đăng ký nếu có #register trên URL
  if (window.location.hash === '#register') {
    regLogCheckbox.checked = true;
  }
  updateTabShadow();
</script>
</body>
</html> 