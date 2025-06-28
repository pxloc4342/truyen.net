<?php
class AdminController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function login() {
        // Nếu đã đăng nhập thì chuyển về dashboard
        if (isset($_SESSION['admin_id'])) {
            $this->redirect('/admin/dashboard');
        }
        
        if ($this->isPost()) {
            $username = $this->getPost('username');
            $password = $this->getPost('password');
            
            // Validate input
            $errors = $this->validate([
                'username' => $username,
                'password' => $password
            ], [
                'username' => 'required',
                'password' => 'required'
            ]);
            
            if (empty($errors)) {
                // Kiểm tra thông tin đăng nhập
                $admin = $this->db->fetch(
                    "SELECT * FROM admins WHERE username = ?",
                    [$username]
                );
                
                if ($admin && password_verify($password, $admin['password'])) {
                    // Đăng nhập thành công
                    $_SESSION['admin_id'] = $admin['id'];
                    $_SESSION['admin_username'] = $admin['username'];
                    $_SESSION['admin_email'] = $admin['email'];
                    
                    // Cập nhật last_login
                    $this->db->query(
                        "UPDATE admins SET last_login = NOW() WHERE id = ?",
                        [$admin['id']]
                    );
                    
                    $this->redirect('/admin/dashboard');
                } else {
                    $errors['login'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
                }
            }
            
            $this->render('admin/login', [
                'errors' => $errors,
                'username' => $username,
                'title' => 'Đăng nhập Admin - ' . APP_NAME
            ], false);
        } else {
            $this->render('admin/login', [
                'title' => 'Đăng nhập Admin - ' . APP_NAME
            ], false);
        }
    }
    
    public function logout() {
        // Xóa session
        unset($_SESSION['admin_id']);
        unset($_SESSION['admin_username']);
        unset($_SESSION['admin_email']);
        session_destroy();
        
        $this->redirect('/admin/login');
    }
    
    public function dashboard() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['admin_id'])) {
            $this->redirect('/admin/login');
        }
        
        // Lấy thống kê
        $totalStories = $this->db->fetch("SELECT COUNT(*) as count FROM stories")['count'];
        $totalChapters = $this->db->fetch("SELECT COUNT(*) as count FROM chapters")['count'];
        $totalUsers = $this->db->fetch("SELECT COUNT(*) as count FROM users")['count'];
        $totalViews = $this->db->fetch("SELECT SUM(views) as total FROM stories")['total'] ?? 0;
        
        // Lấy truyện mới nhất
        $latestStories = $this->db->fetchAll(
            "SELECT * FROM stories ORDER BY created_at DESC LIMIT 5"
        );
        
        // Lấy chapter mới nhất
        $latestChapters = $this->db->fetchAll(
            "SELECT c.*, s.title as story_title FROM chapters c 
             JOIN stories s ON c.story_id = s.id 
             ORDER BY c.created_at DESC LIMIT 5"
        );
        
        $this->render('admin/dashboard', [
            'totalStories' => $totalStories,
            'totalChapters' => $totalChapters,
            'totalUsers' => $totalUsers,
            'totalViews' => $totalViews,
            'latestStories' => $latestStories,
            'latestChapters' => $latestChapters,
            'title' => 'Dashboard - Admin Panel'
        ]);
    }
    
    // Middleware để kiểm tra đăng nhập admin
    private function requireAuth() {
        if (!isset($_SESSION['admin_id'])) {
            $this->redirect('/admin/login');
        }
    }
}
?> 