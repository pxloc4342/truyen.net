<?php
class CategoryController extends Controller {
    public function show($id) {
        // Lấy thông tin thể loại
        $category = $this->db->fetch("SELECT * FROM categories WHERE id = ?", [$id]);
        if (!$category) {
            $this->render('errors/404', ['title' => 'Không tìm thấy thể loại']);
            return;
        }
        // Lấy filter
        $status = isset($_GET['status']) ? $_GET['status'] : '';
        $filterCategory = isset($_GET['category']) ? $_GET['category'] : '';
        $params = [$id];
        $where = 'sc.category_id = ?';
        if ($status) {
            $where .= ' AND s.status = ?';
            $params[] = $status;
        }
        if ($filterCategory) {
            $where .= ' AND sc.category_id = ?';
            $params[] = $filterCategory;
        }
        $stories = $this->db->fetchAll("SELECT s.*, 
            (SELECT c.id FROM chapters c WHERE c.story_id = s.id ORDER BY c.chapter_number DESC, c.id DESC LIMIT 1) AS latest_chapter_id,
            (SELECT c.chapter_number FROM chapters c WHERE c.story_id = s.id ORDER BY c.chapter_number DESC, c.id DESC LIMIT 1) AS latest_chapter_number
            FROM stories s
            JOIN story_category sc ON s.id = sc.story_id
            WHERE $where
            GROUP BY s.id
            ORDER BY latest_chapter_number DESC, s.created_at DESC
        ", $params);
        // Lấy danh sách thể loại cho bộ lọc
        $categories = $this->db->fetchAll("SELECT id, name FROM categories ORDER BY name ASC");
        $this->render('stories/index', [
            'stories' => $stories,
            'title' => 'Truyện ' . $category['name'],
            'categoryName' => $category['name'],
            'categoryId' => $id,
            'categories' => $categories,
            'status' => $status,
            'category' => $filterCategory
        ]);
    }
} 