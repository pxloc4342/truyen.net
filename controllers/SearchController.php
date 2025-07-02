<?php
class SearchController extends Controller {
    public function index() {
        // Lấy danh sách thể loại
        $categories = $this->db->fetchAll("SELECT * FROM categories ORDER BY name ASC");

        // Lấy filter từ query string
        $keyword = trim($this->getQuery('q', ''));
        $category = $this->getQuery('category', '');
        $status = $this->getQuery('status', '');

        // Chỉ lấy các trường cần thiết, dùng thumbnail thay cho cover
        $sql = "SELECT s.id, s.title, s.thumbnail, s.status, s.created_at,
            (
                SELECT c.id FROM chapters c WHERE c.story_id = s.id ORDER BY c.id DESC LIMIT 1
            ) AS latest_chapter_id,
            (
                SELECT c.title FROM chapters c WHERE c.story_id = s.id ORDER BY c.id DESC LIMIT 1
            ) AS latest_chapter_title
        FROM stories s ";
        $params = [];
        $where = [];

        // Lọc theo thể loại (nếu có)
        if ($category) {
            $sql .= "JOIN story_category sc ON s.id = sc.story_id ";
            $where[] = "sc.category_id = ?";
            $params[] = $category;
        }

        // Lọc theo tên truyện (nếu có)
        if ($keyword) {
            $where[] = "s.title LIKE ?";
            $params[] = "%$keyword%";
        }

        // Lọc theo trạng thái (nếu có)
        if ($status) {
            $where[] = "s.status = ?";
            $params[] = $status;
        }

        if ($where) {
            $sql .= "WHERE " . implode(' AND ', $where) . " ";
        }
        $sql .= "ORDER BY s.created_at DESC LIMIT 60";

        $stories = $this->db->fetchAll($sql, $params);

        $this->render('search/index', [
            'categories' => $categories,
            'stories' => $stories,
            'keyword' => $keyword,
            'category' => $category,
            'status' => $status,
            'title' => 'Tìm kiếm truyện - ' . APP_NAME
        ]);
    }

    // API Ajax trả về HTML card truyện
    public function ajax() {
        $keyword = trim($this->getQuery('q', ''));
        $category = $this->getQuery('category', '');
        $status = $this->getQuery('status', '');

        $sql = "SELECT s.id, s.title, s.thumbnail, s.status, s.created_at,
            (
                SELECT c.id FROM chapters c WHERE c.story_id = s.id ORDER BY c.id DESC LIMIT 1
            ) AS latest_chapter_id,
            (
                SELECT c.title FROM chapters c WHERE c.story_id = s.id ORDER BY c.id DESC LIMIT 1
            ) AS latest_chapter_title
        FROM stories s ";
        $params = [];
        $where = [];
        if ($category) {
            $sql .= "JOIN story_category sc ON s.id = sc.story_id ";
            $where[] = "sc.category_id = ?";
            $params[] = $category;
        }
        if ($keyword) {
            $where[] = "s.title LIKE ?";
            $params[] = "%$keyword%";
        }
        if ($status) {
            $where[] = "s.status = ?";
            $params[] = $status;
        }
        if ($where) {
            $sql .= "WHERE " . implode(' AND ', $where) . " ";
        }
        $sql .= "ORDER BY s.created_at DESC LIMIT 60";
        $stories = $this->db->fetchAll($sql, $params);
        // Render partial, không layout
        ob_start();
        include VIEWS_PATH . '/search/_story_cards.php';
        $html = ob_get_clean();
        echo $html;
        exit;
    }

    // API autocomplete gợi ý tên truyện
    public function autocomplete() {
        $keyword = trim($this->getQuery('q', ''));
        if (!$keyword) {
            $this->json([]);
        }
        $sql = "SELECT id, title, thumbnail FROM stories WHERE title LIKE ? ORDER BY created_at DESC LIMIT 10";
        $stories = $this->db->fetchAll($sql, ["%$keyword%"]);
        $this->json($stories);
    }
} 