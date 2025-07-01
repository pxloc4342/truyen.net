<?php
// Đã xóa toàn bộ chức năng quản lý chương 

class AdminChapterController extends Controller {
    public function index() {
        require_once MODELS_PATH . '/Story.php';
        $storyModel = new Story();
        $stories = $storyModel->getAll();
        // Sắp xếp theo ID tăng dần
        usort($stories, function($a, $b) { return $a['id'] <=> $b['id']; });
        $this->render('admin/chapters/stories', [
            'stories' => $stories
        ]);
    }

    public function listChapters($story_id) {
        require_once MODELS_PATH . '/Chapter.php';
        require_once MODELS_PATH . '/Story.php';
        $chapterModel = new Chapter();
        $storyModel = new Story();
        $story = $storyModel->getById($story_id);
        $chapters = $chapterModel->getByStoryId($story_id);
        $this->render('admin/chapters/index', [
            'story' => $story,
            'chapters' => $chapters
        ]);
    }

    public function create() {
        require_once MODELS_PATH . '/Story.php';
        require_once MODELS_PATH . '/Chapter.php';
        $storyModel = new Story();
        $chapterModel = new Chapter();
        $story_id = $_GET['story_id'] ?? null;
        $stories = [];
        $selected_story = null;
        if ($story_id) {
            $selected_story = $storyModel->getById($story_id);
            $max = $chapterModel->getMaxChapterNumber($story_id);
            $default_chapter_number = $max + 1;
        } else {
            $stories = $storyModel->getAll();
            $default_chapter_number = 1;
            if (!empty($stories)) {
                $first_story_id = $stories[0]['id'];
                $max = $chapterModel->getMaxChapterNumber($first_story_id);
                $default_chapter_number = $max + 1;
            }
        }
        $this->render('admin/chapters/create', [
            'stories' => $stories,
            'selected_story' => $selected_story,
            'default_chapter_number' => $default_chapter_number
        ]);
    }

    public function store() {
        // Xử lý lưu chapter mới
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once MODELS_PATH . '/Chapter.php';
            require_once MODELS_PATH . '/ChapterImage.php';
            $story_id = $_POST['story_id'] ?? null;
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $chapter_number = $_POST['chapter_number'] ?? null;
            if ($story_id && $title && $content) {
                $chapterModel = new Chapter();
                $chapter_id = $chapterModel->create([
                    'story_id' => $story_id,
                    'title' => $title,
                    'content' => $content,
                    'chapter_number' => $chapter_number ?? 1
                ]);
                // Xử lý upload nhiều ảnh
                if ($chapter_id && isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                    $chapterImageModel = new ChapterImage();
                    $upload_dir = __DIR__ . '/../uploads/chapters/' . $story_id . '/' . $chapter_id . '/';
                    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                    foreach ($_FILES['images']['tmp_name'] as $i => $tmp_name) {
                        if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                            $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                            $filename = 'chapter_' . $chapter_id . '_' . time() . '_' . $i . '.' . $ext;
                            $target_path = $upload_dir . $filename;
                            if (move_uploaded_file($tmp_name, $target_path)) {
                                $image_path = '/uploads/chapters/' . $story_id . '/' . $chapter_id . '/' . $filename;
                                $chapterImageModel->addImage($chapter_id, $image_path, $i);
                            }
                        }
                    }
                }
            }
            // Chuyển hướng về danh sách chapter
            header('Location: ' . APP_URL . '/admin/chapters');
            exit;
        }
    }

    public function edit($id) {
        require_once MODELS_PATH . '/Chapter.php';
        require_once MODELS_PATH . '/Story.php';
        require_once MODELS_PATH . '/ChapterImage.php';
        $chapterModel = new Chapter();
        $storyModel = new Story();
        $chapterImageModel = new ChapterImage();
        $chapter = $chapterModel->getById($id);
        if (!$chapter) {
            http_response_code(404);
            echo 'Chapter not found';
            exit;
        }
        $stories = $storyModel->getAll();
        $images = $chapterImageModel->getImagesByChapter($id);
        $this->render('admin/chapters/edit', [
            'chapter' => $chapter,
            'stories' => $stories,
            'images' => $images
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once MODELS_PATH . '/Chapter.php';
            require_once MODELS_PATH . '/ChapterImage.php';
            $chapterModel = new Chapter();
            $chapterImageModel = new ChapterImage();
            $story_id = $_POST['story_id'] ?? null;
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $chapter_number = $_POST['chapter_number'] ?? null;
            // Cập nhật thông tin chapter
            $chapterModel->update($id, [
                'story_id' => $story_id,
                'title' => $title,
                'content' => $content,
                'chapter_number' => $chapter_number ?? 1
            ]);
            // Xoá ảnh đã chọn
            if (!empty($_POST['delete_images'])) {
                foreach ($_POST['delete_images'] as $img_id) {
                    // Lấy đường dẫn ảnh để xoá file vật lý
                    $img = $chapterImageModel->getImageById($img_id);
                    if ($img && !empty($img['image_path'])) {
                        $file = __DIR__ . '/../' . ltrim($img['image_path'], '/');
                        if (file_exists($file)) unlink($file);
                    }
                    $chapterImageModel->deleteById($img_id);
                }
            }
            // Upload ảnh mới
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                $upload_dir = __DIR__ . '/../uploads/chapters/' . $story_id . '/' . $id . '/';
                if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
                // Lấy số thứ tự lớn nhất hiện tại
                $maxOrder = $chapterImageModel->getMaxOrder($id);
                foreach ($_FILES['images']['tmp_name'] as $i => $tmp_name) {
                    if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                        $ext = pathinfo($_FILES['images']['name'][$i], PATHINFO_EXTENSION);
                        $filename = 'chapter_' . $id . '_' . time() . '_' . $i . '.' . $ext;
                        $target_path = $upload_dir . $filename;
                        if (move_uploaded_file($tmp_name, $target_path)) {
                            $image_path = '/uploads/chapters/' . $story_id . '/' . $id . '/' . $filename;
                            $chapterImageModel->addImage($id, $image_path, $maxOrder + $i + 1);
                        }
                    }
                }
            }
            // Chuyển hướng về trang sửa chapter
            header('Location: ' . APP_URL . '/admin/chapters/edit/' . $id);
            exit;
        }
    }
} 