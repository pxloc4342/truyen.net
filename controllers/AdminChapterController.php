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
            $story_id = $_POST['story_id'] ?? null;
            $title = $_POST['title'] ?? '';
            $content = $_POST['content'] ?? '';
            $chapter_number = $_POST['chapter_number'] ?? null;
            if ($story_id && $title && $content) {
                $chapterModel = new Chapter();
                $chapterModel->create([
                    'story_id' => $story_id,
                    'title' => $title,
                    'content' => $content,
                    'chapter_number' => $chapter_number ?? 1
                ]);
            }
            // Chuyển hướng về danh sách chapter
            header('Location: ' . APP_URL . '/admin/chapters');
            exit;
        }
    }
} 