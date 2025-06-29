<?php
class AdminCategoryController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireAdmin();
    }

    // Danh sách thể loại
    public function index() {
        $categories = $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
        $this->render('admin/categories/index', [
            'categories' => $categories,
            'title' => 'Quản lý thể loại - ' . APP_NAME
        ]);
    }

    // Thêm thể loại mới
    public function create() {
        $errors = [];
        if ($this->isPost()) {
            $name = trim($this->getPost('name'));
            
            // Validate
            $errors = $this->validate([
                'name' => $name
            ], [
                'name' => 'required'
            ]);

            // Kiểm tra thể loại đã tồn tại
            if (empty($errors)) {
                $existing = $this->db->fetch("SELECT id FROM categories WHERE name = ?", [$name]);
                if ($existing) {
                    $errors['name'] = 'Thể loại này đã tồn tại';
                }
            }

            if (empty($errors)) {
                $this->db->insert('categories', ['name' => $name]);
                $this->redirect('/admin/categories');
            }
        }
        
        $this->render('admin/categories/create', [
            'errors' => $errors,
            'title' => 'Thêm thể loại mới - ' . APP_NAME
        ]);
    }

    // Sửa thể loại
    public function edit($id) {
        $category = $this->db->fetch("SELECT * FROM categories WHERE id = ?", [$id]);
        if (!$category) {
            $this->redirect('/admin/categories');
        }

        $errors = [];
        if ($this->isPost()) {
            $name = trim($this->getPost('name'));
            
            // Validate
            $errors = $this->validate([
                'name' => $name
            ], [
                'name' => 'required'
            ]);

            // Kiểm tra thể loại đã tồn tại (trừ thể loại hiện tại)
            if (empty($errors)) {
                $existing = $this->db->fetch("SELECT id FROM categories WHERE name = ? AND id != ?", [$name, $id]);
                if ($existing) {
                    $errors['name'] = 'Thể loại này đã tồn tại';
                }
            }

            if (empty($errors)) {
                $this->db->update('categories', ['name' => $name], 'id = ?', [$id]);
                $this->redirect('/admin/categories');
            }
        }
        
        $this->render('admin/categories/edit', [
            'category' => $category,
            'errors' => $errors,
            'title' => 'Sửa thể loại - ' . APP_NAME
        ]);
    }

    // Xóa thể loại
    public function delete($id) {
        $category = $this->db->fetch("SELECT * FROM categories WHERE id = ?", [$id]);
        if ($category) {
            // Kiểm tra xem có truyện nào đang sử dụng thể loại này không
            $stories = $this->db->fetchAll("SELECT story_id FROM story_category WHERE category_id = ?", [$id]);
            if (!empty($stories)) {
                // Nếu có truyện đang sử dụng, chỉ xóa quan hệ
                $this->db->query("DELETE FROM story_category WHERE category_id = ?", [$id]);
            }
            // Xóa thể loại
            $this->db->query("DELETE FROM categories WHERE id = ?", [$id]);
        }
        $this->redirect('/admin/categories');
    }

    // Middleware kiểm tra đăng nhập admin
    private function requireAdmin() {
        if (!isset($_SESSION['admin_id'])) {
            $this->redirect('/admin/login');
        }
    }
}
?> 