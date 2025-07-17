<?php

class StoryController extends Controller {
    
    public function index() {
        $storyModel = new Story();
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $categoryId = isset($_GET['category']) ? $_GET['category'] : '';
        $stories = $storyModel->getLatestWithFilter($status, $categoryId, 30, 0);
        // Lấy danh sách thể loại cho bộ lọc
        $categories = $this->db->fetchAll("SELECT id, name FROM categories ORDER BY name ASC");
        $this->render('stories/index', [
            'stories' => $stories,
            'categories' => $categories,
            'title' => 'Truyện mới cập nhật',
            'status' => $status,
            'category' => $categoryId
        ]);
    }
    
    public function show($id) {
        $storyModel = new Story();
        require_once MODELS_PATH . '/Chapter.php';
        $chapterModel = new Chapter();
        $story = $storyModel->getById($id);
        if (!$story) {
            $this->render('errors/404', [
                'title' => 'Không tìm thấy truyện'
            ]);
            return;
        }
        // Gán trạng thái yêu thích nếu đã đăng nhập
        if (!empty($_SESSION['user_id'])) {
            $isFav = $this->db->fetch("SELECT 1 FROM favorite_stories WHERE user_id = ? AND story_id = ?", [$_SESSION['user_id'], $id]);
            $story['is_favorite'] = (bool)$isFav;
        }
        $chapters = $chapterModel->getByStoryId($id);
        $this->render('stories/show', [
            'story' => $story,
            'chapters' => $chapters,
            'title' => $story['title']
        ]);
    }

    public function chapter($story_id, $chapter_id) {
        require_once MODELS_PATH . '/Story.php';
        require_once MODELS_PATH . '/Chapter.php';
        require_once MODELS_PATH . '/ChapterImage.php';
        $storyModel = new Story();
        $chapterModel = new Chapter();
        $chapterImageModel = new ChapterImage();
        $story = $storyModel->getById($story_id);
        $chapter = $chapterModel->getById($chapter_id);
        if (!$story || !$chapter) {
            $this->render('errors/404', ['title' => 'Không tìm thấy chương']);
            return;
        }
        // Lưu lịch sử đọc truyện
        if (!empty($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
            // Kiểm tra đã có lịch sử chưa
            $history = $this->db->fetch("SELECT id FROM user_reading_history WHERE user_id = ? AND story_id = ?", [$user_id, $story_id]);
            if ($history) {
                $this->db->query("UPDATE user_reading_history SET chapter_id = ?, read_at = NOW() WHERE id = ?", [$chapter_id, $history['id']]);
            } else {
                $this->db->insert('user_reading_history', [
                    'user_id' => $user_id,
                    'story_id' => $story_id,
                    'chapter_id' => $chapter_id,
                    'read_at' => date('Y-m-d H:i:s')
                ]);
            }
        }
        // Lấy nội dung chapter
        $chapterContent = htmlspecialchars($chapter['content']);
        // Lấy chapter trước/sau
        $chapters = $chapterModel->getByStoryId($story_id);
        $prevChapter = $nextChapter = null;
        foreach ($chapters as $idx => $ch) {
            if ($ch['id'] == $chapter_id) {
                $prevChapter = $chapters[$idx-1] ?? null;
                $nextChapter = $chapters[$idx+1] ?? null;
                break;
            }
        }
        // Lấy danh sách ảnh chapter
        $chapterImages = $chapterImageModel->getImagesByChapter($chapter_id);
        $this->render('stories/chapter', [
            'story' => $story,
            'chapter' => $chapter,
            'chapterContent' => $chapterContent,
            'prevChapter' => $prevChapter,
            'nextChapter' => $nextChapter,
            'chapters' => $chapters,
            'chapterImages' => $chapterImages
        ]);
    }

    // Hiển thị tất cả truyện đề xuất với phân trang
    public function allSuggested() {
        $perPage = 30;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $perPage;
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $categoryId = isset($_GET['category']) ? $_GET['category'] : '';
        $storyModel = new Story();
        $stories = $storyModel->getLatestWithFilter($status, $categoryId, $perPage, $offset);
        $total = $this->db->fetch("SELECT COUNT(*) as count FROM stories")['count'];
        $totalPages = ceil($total / $perPage);
        $categories = $this->db->fetchAll("SELECT id, name FROM categories ORDER BY name ASC");
        $this->render('stories/index', [
            'stories' => $stories,
            'title' => 'Tất cả truyện đề xuất - ' . APP_NAME,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'categories' => $categories,
            'status' => $status,
            'category' => $categoryId
        ]);
    }

    public function hot() {
        $storyModel = new Story();
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $categoryId = isset($_GET['category']) ? $_GET['category'] : '';
        $stories = $storyModel->getHot(30, $status, $categoryId);
        $categories = $this->db->fetchAll("SELECT id, name FROM categories ORDER BY name ASC");
        $this->render('stories/index', [
            'stories' => $stories,
            'title' => 'Truyện hot',
            'categories' => $categories,
            'status' => $status,
            'category' => $categoryId
        ]);
    }

    public function toggleFavorite() {
        if (empty($_SESSION['user_id']) || empty($_POST['story_id'])) {
            $this->redirect(APP_URL . '/auth.php');
            return;
        }
        $user_id = $_SESSION['user_id'];
        $story_id = (int)$_POST['story_id'];
        $favorite = $this->db->fetch("SELECT * FROM favorite_stories WHERE user_id = ? AND story_id = ?", [$user_id, $story_id]);
        if ($favorite) {
            $this->db->delete('favorite_stories', 'user_id = ? AND story_id = ?', [$user_id, $story_id]);
            $_SESSION['favorite_message'] = 'Đã xóa khỏi danh sách yêu thích.';
        } else {
            $this->db->insert('favorite_stories', [
                'user_id' => $user_id,
                'story_id' => $story_id
            ]);
            $_SESSION['favorite_message'] = 'Đã thêm vào danh sách yêu thích.';
        }
        $redirect = $_POST['redirect'] ?? ($_SERVER['HTTP_REFERER'] ?? (APP_URL . '/'));
        $this->redirect($redirect);
    }

    public function favorites() {
        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/auth.php');
            return;
        }
        $user_id = $_SESSION['user_id'];
        $stories = $this->db->fetchAll("SELECT s.* FROM stories s JOIN favorite_stories f ON s.id = f.story_id WHERE f.user_id = ? ORDER BY f.created_at DESC", [$user_id]);
        $this->render('stories/favorites', [
            'stories' => $stories,
            'title' => 'Truyện yêu thích'
        ]);
    }

    public function history() {
        if (empty($_SESSION['user_id'])) {
            $this->redirect(APP_URL . '/auth.php');
            return;
        }
        $user_id = $_SESSION['user_id'];
        $history = $this->db->fetchAll("SELECT h.*, s.title as story_title, s.thumbnail, c.chapter_number, c.title as chapter_title FROM user_reading_history h JOIN stories s ON h.story_id = s.id JOIN chapters c ON h.chapter_id = c.id WHERE h.user_id = ? ORDER BY h.read_at DESC LIMIT 20", [$user_id]);
        $this->render('stories/history', [
            'history' => $history,
            'title' => 'Lịch sử đọc truyện'
        ]);
    }
} 