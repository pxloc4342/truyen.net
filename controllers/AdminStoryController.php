<?php
class AdminStoryController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireAdmin();
    }

    // Danh sách truyện
    public function index() {
        $stories = $this->db->fetchAll("SELECT * FROM stories ORDER BY created_at DESC");
        $this->render('admin/stories/index', [
            'stories' => $stories,
            'title' => 'Quản lý truyện - ' . APP_NAME
        ]);
    }

    // Thêm truyện mới
    public function create() {
        $categories = $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
        $errors = [];
        if ($this->isPost()) {
            $title = $this->getPost('title');
            $description = $this->getPost('description');
            $author = $this->getPost('author');
            $status = $this->getPost('status', 'ongoing');
            $category_ids = $this->getPost('categories', []);
            $thumbnail = null;

            // Validate
            $errors = $this->validate([
                'title' => $title,
                'author' => $author
            ], [
                'title' => 'required',
                'author' => 'required'
            ]);

            // Xử lý upload ảnh bìa
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $errors['thumbnail'] = 'Chỉ chấp nhận ảnh jpg, jpeg, png, gif';
                } else {
                    $filename = 'cover_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                    $uploadPath = ASSETS_PATH . '/images/' . $filename;
                    if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadPath)) {
                        $thumbnail = '/assets/images/' . $filename;
                    } else {
                        $errors['thumbnail'] = 'Lỗi upload ảnh';
                    }
                }
            } else if (!empty($_POST['thumbnail_existing'])) {
                // Nếu không upload mới, lấy ảnh có sẵn nếu có chọn
                $thumbnail = $_POST['thumbnail_existing'];
            }

            if (empty($errors)) {
                $this->db->insert('stories', [
                    'title' => $title,
                    'description' => $description,
                    'author' => $author,
                    'thumbnail' => $thumbnail,
                    'status' => $status
                ]);
                $story_id = $this->db->getConnection()->lastInsertId();
                // Gán thể loại
                foreach ($category_ids as $cat_id) {
                    $this->db->insert('story_category', [
                        'story_id' => $story_id,
                        'category_id' => $cat_id
                    ]);
                }
                $this->redirect('/admin/stories');
            }
        }
        $this->render('admin/stories/create', [
            'categories' => $categories,
            'errors' => $errors,
            'title' => 'Thêm truyện mới - ' . APP_NAME
        ]);
    }

    // Sửa truyện
    public function edit($id) {
        $story = $this->db->fetch("SELECT * FROM stories WHERE id = ?", [$id]);
        if (!$story) $this->redirect('/admin/stories');
        $categories = $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC");
        $storyCats = $this->db->fetchAll("SELECT category_id FROM story_category WHERE story_id = ?", [$id]);
        $storyCatIds = array_column($storyCats, 'category_id');
        $errors = [];
        if ($this->isPost()) {
            $title = $this->getPost('title');
            $description = $this->getPost('description');
            $author = $this->getPost('author');
            $status = $this->getPost('status', 'ongoing');
            $category_ids = $this->getPost('categories', []);
            $thumbnail = $story['thumbnail'];

            // Validate
            $errors = $this->validate([
                'title' => $title,
                'author' => $author
            ], [
                'title' => 'required',
                'author' => 'required'
            ]);

            // Xử lý upload ảnh bìa mới nếu có
            if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] === UPLOAD_ERR_OK) {
                $ext = strtolower(pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION));
                if (!in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
                    $errors['thumbnail'] = 'Chỉ chấp nhận ảnh jpg, jpeg, png, gif';
                } else {
                    $filename = 'cover_' . time() . '_' . rand(1000,9999) . '.' . $ext;
                    $uploadPath = ASSETS_PATH . '/images/' . $filename;
                    if (move_uploaded_file($_FILES['thumbnail']['tmp_name'], $uploadPath)) {
                        $thumbnail = '/assets/images/' . $filename;
                    } else {
                        $errors['thumbnail'] = 'Lỗi upload ảnh';
                    }
                }
            }

            if (empty($errors)) {
                $this->db->update('stories', [
                    'title' => $title,
                    'description' => $description,
                    'author' => $author,
                    'thumbnail' => $thumbnail,
                    'status' => $status
                ], 'id = ?', [$id]);
                // Cập nhật thể loại
                $this->db->query("DELETE FROM story_category WHERE story_id = ?", [$id]);
                foreach ($category_ids as $cat_id) {
                    $this->db->insert('story_category', [
                        'story_id' => $id,
                        'category_id' => $cat_id
                    ]);
                }
                $this->redirect('/admin/stories');
            }
        }
        $this->render('admin/stories/edit', [
            'story' => $story,
            'categories' => $categories,
            'storyCatIds' => $storyCatIds,
            'errors' => $errors,
            'title' => 'Sửa truyện - ' . APP_NAME
        ]);
    }

    // Xóa truyện
    public function delete($id) {
        $story = $this->db->fetch("SELECT * FROM stories WHERE id = ?", [$id]);
        if ($story) {
            $this->db->query("DELETE FROM stories WHERE id = ?", [$id]);
        }
        $this->redirect('/admin/stories');
    }

    // Middleware kiểm tra đăng nhập admin
    private function requireAdmin() {
        if (!isset($_SESSION['admin_id'])) {
            $this->redirect('/admin/login');
        }
    }
} 