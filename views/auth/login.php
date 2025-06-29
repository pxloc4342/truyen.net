<div class="login-container">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="login-card">
                    <div class="login-header">
                        <div class="login-icon">
                            <i class="fas fa-user-circle"></i>
                        </div>
                        <h2>Đăng nhập</h2>
                        <p>Chào mừng bạn trở lại với <?= APP_NAME ?></p>
                    </div>
                    
                    <div class="login-body">
                        <?php if (isset($errors['login'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?= htmlspecialchars($errors['login']) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" action="<?= APP_URL ?>/dang-nhap" class="login-form">
                            <div class="form-group">
                                <label for="username" class="form-label">
                                    <i class="fas fa-user me-2"></i>Tên đăng nhập
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input type="text" 
                                           class="form-control" 
                                           id="username" 
                                           name="username" 
                                           value="<?= htmlspecialchars($username ?? '') ?>" 
                                           placeholder="Nhập tên đăng nhập"
                                           required>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Mật khẩu
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input type="password" 
                                           class="form-control" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Nhập mật khẩu"
                                           required>
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Ghi nhớ đăng nhập
                                </label>
                            </div>
                            
                            <button type="submit" class="btn btn-login w-100">
                                <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                            </button>
                        </form>
                        
                        <div class="login-footer">
                            <div class="divider">
                                <span>hoặc</span>
                            </div>
                            
                            <div class="social-login">
                                <button class="btn btn-social btn-facebook">
                                    <i class="fab fa-facebook-f me-2"></i>Đăng nhập với Facebook
                                </button>
                                <button class="btn btn-social btn-google">
                                    <i class="fab fa-google me-2"></i>Đăng nhập với Google
                                </button>
                            </div>
                            
                            <div class="text-center mt-4">
                                <p class="mb-2">Chưa có tài khoản? 
                                    <a href="<?= APP_URL ?>/dang-ky" class="text-decoration-none">Đăng ký ngay</a>
                                </p>
                                <a href="<?= APP_URL ?>/quen-mat-khau" class="text-decoration-none">Quên mật khẩu?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const passwordInput = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});
</script> 