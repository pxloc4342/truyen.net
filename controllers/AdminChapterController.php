<?php
// Đã xóa toàn bộ chức năng quản lý chương 

class AdminChapterController extends Controller {
    public function index() {
        // Hiển thị danh sách chapter (tạm thời để trống)
        $this->render('admin/chapters/index');
    }

    public function create() {
        // Lấy danh sách truyện
        require_once MODELS_PATH . '/Story.php';
        $storyModel = new Story();
        $stories = $storyModel->getAll();
        // Hiển thị form thêm chapter, truyền danh sách truyện
        $this->render('admin/chapters/create', ['stories' => $stories]);
    }

    public function store() {
        // Xử lý lưu chapter mới
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $story_id = $_POST['story_id'] ?? null;
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            // TODO: Validate và lưu vào DB
            // Chuyển hướng về danh sách chapter
            header('Location: ' . APP_URL . '/admin/chapters');
            exit;
        }
    }
} 