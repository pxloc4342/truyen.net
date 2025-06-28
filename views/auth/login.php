<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Đăng nhập</h4>
                </div>
                <div class="card-body">
                    <?php if (isset(
                        $errors['login'])): ?>
                        <div class="alert alert-danger"><?= htmlspecialchars($errors['login']) ?></div>
                    <?php endif; ?>
                    <form method="POST" action="<?= APP_URL ?>/dang-nhap">
                        <div class="mb-3">
                            <label for="username" class="form-label">Tên đăng nhập</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 