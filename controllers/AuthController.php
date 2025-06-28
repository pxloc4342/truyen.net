<?php
class AuthController extends Controller {
    public function login() {
        if ($this->isPost()) {
            $username = $this->getPost('username');
            $password = $this->getPost('password');
            $errors = [];

            // Debug: Log thông tin đăng nhập
            error_log("Login attempt - Username: $username");

            // Kiểm tra admin trước
            $admin = $this->db->fetch("SELECT * FROM admins WHERE username = ?", [$username]);
            if ($admin) {
                error_log("Admin found: " . $admin['username']);
                if (password_verify($password, $admin['password'])) {
                    error_log("Admin password verified successfully");
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $this->redirect(APP_URL . '/admin/dashboard');
                    exit;
                } else {
                    error_log("Admin password verification failed");
                }
            } else {
                error_log("Admin not found for username: $username");
            }

            // Kiểm tra user
            $user = $this->db->fetch("SELECT * FROM users WHERE username = ?", [$username]);
            if ($user) {
                error_log("User found: " . $user['username']);
                if (password_verify($password, $user['password'])) {
                    error_log("User password verified successfully");
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $this->redirect(APP_URL . '/');
                    exit;
                } else {
                    error_log("User password verification failed");
                }
            } else {
                error_log("User not found for username: $username");
            }

            // Sai thông tin
            error_log("Login failed for username: $username");
            $errors['login'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
            $this->render('auth/login', [
                'errors' => $errors,
                'username' => $username,
                'title' => 'Đăng nhập - ' . APP_NAME
            ]);
        } else {
            $this->render('auth/login', [
                'title' => 'Đăng nhập - ' . APP_NAME
            ]);
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['email']);
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_email']);
        session_destroy();
        $this->redirect(APP_URL . '/dang-nhap');
    }
} 