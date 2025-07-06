<?php
class AuthController extends Controller {
    public function login() {
        if ($this->isPost()) {
            $username = $this->getPost('username');
            $password = $this->getPost('password');
            // Kiểm tra admin trước
            $admin = $this->db->fetch("SELECT * FROM admins WHERE username = ?", [$username]);
            if ($admin) {
                if (password_verify($password, $admin['password'])) {
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_email'] = $admin['email'];
                    $this->redirect(APP_URL . '/admin/dashboard');
                    exit;
                }
            }
            // Kiểm tra user
            $user = $this->db->fetch("SELECT * FROM users WHERE username = ? OR email = ?", [$username, $username]);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $this->redirect(APP_URL . '/');
                exit;
            } else {
                $_SESSION['error_message'] = 'Tài khoản hoặc mật khẩu không đúng.';
                $this->redirect(APP_URL . '/auth.php');
                exit;
            }
        } else {
            $this->redirect(APP_URL . '/auth.php');
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
        $this->redirect(APP_URL . '/');
    }

    public function register() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            // Validate
            if (!$username || !$email || !$password || !$confirm) {
                $error = 'Vui lòng nhập đầy đủ thông tin.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Email không hợp lệ.';
            } elseif ($password !== $confirm) {
                $error = 'Mật khẩu nhập lại không khớp.';
            } else {
                // Kiểm tra username hoặc email đã tồn tại
                $user = $this->db->fetch("SELECT * FROM users WHERE username = ? OR email = ?", [$username, $email]);
                if ($user) {
                    $error = 'Tên đăng nhập hoặc email đã được sử dụng.';
                } else {
                    // Lưu user mới
                    $hash = password_hash($password, PASSWORD_DEFAULT);
                    $this->db->insert('users', [
                        'username' => $username,
                        'email' => $email,
                        'password' => $hash
                    ]);
                    // Chuyển hướng sang trang chủ
                    $this->redirect(APP_URL . '/');
                }
            }
        }
        $this->render('auth/register', [
            'error' => $error,
            'title' => 'Đăng ký tài khoản'
        ]);
    }
} 