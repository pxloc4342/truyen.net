<?php
class AdminChapterController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->requireAdmin();
    }

    // Danh sách chương của một truyện
    public function index($story_id) {
        $story = $this->db->fetch("SELECT * FROM stories WHERE id = ?", [$story_id]);
        if (!$story) $this->redirect('/admin/stories');
        $chapters = $this->db->fetchAll("SELECT * FROM chapters WHERE story_id = ? ORDER BY chapter_number ASC", [$story_id]);
        $this->render('admin/chapters/index', [
            'story' => $story,
            'chapters' => $chapters,
            'title' => 'Quản lý chương - ' . $story['title']
        ]);
    }

    // Thêm chương mới
    public function create($story_id) {
        $story = $this->db->fetch("SELECT * FROM stories WHERE id = ?", [$story_id]);
        if (!$story) $this->redirect('/admin/stories');
        $errors = [];
        if ($this->isPost()) {
            $title = $this->getPost('title');
            $content = $this->getPost('content');
            $chapter_number = $this->getPost('chapter_number');
            $errors = $this->validate([
                'title' => $title,
                'chapter_number' => $chapter_number
            ], [
                'title' => 'required',
                'chapter_number' => 'required'
            ]);
            if (empty($errors)) {
                $this->db->insert('chapters', [
                    'story_id' => $story_id,
                    'title' => $title,
                    'content' => $content,
                    'chapter_number' => $chapter_number
                ]);
                $this->redirect('/admin/chapters/' . $story_id);
            }
        }
        $this->render('admin/chapters/create', [
            'story' => $story,
            'errors' => $errors,
            'title' => 'Thêm chương mới - ' . $story['title']
        ]);
    }

    // Sửa chương
    public function edit($id) {
        $chapter = $this->db->fetch("SELECT * FROM chapters WHERE id = ?", [$id]);
        if (!$chapter) $this->redirect('/admin/stories');
        $story = $this->db->fetch("SELECT * FROM stories WHERE id = ?", [$chapter['story_id']]);
        $errors = [];
        if ($this->isPost()) {
            $title = $this->getPost('title');
            $content = $this->getPost('content');
            $chapter_number = $this->getPost('chapter_number');
            $errors = $this->validate([
                'title' => $title,
                'chapter_number' => $chapter_number
            ], [
                'title' => 'required',
                'chapter_number' => 'required'
            ]);
            if (empty($errors)) {
                $this->db->update('chapters', [
                    'title' => $title,
                    'content' => $content,
                    'chapter_number' => $chapter_number
                ], 'id = ?', [$id]);
                $this->redirect('/admin/chapters/' . $chapter['story_id']);
            }
        }
        $this->render('admin/chapters/edit', [
            'story' => $story,
            'chapter' => $chapter,
            'errors' => $errors,
            'title' => 'Sửa chương - ' . $story['title']
        ]);
    }

    // Xóa chương
    public function delete($id) {
        $chapter = $this->db->fetch("SELECT * FROM chapters WHERE id = ?", [$id]);
        if ($chapter) {
            $this->db->query("DELETE FROM chapters WHERE id = ?", [$id]);
            $this->redirect('/admin/chapters/' . $chapter['story_id']);
        } else {
            $this->redirect('/admin/stories');
        }
    }

    // Middleware kiểm tra đăng nhập admin
    private function requireAdmin() {
        if (!isset($_SESSION['admin_id'])) {
            $this->redirect('/admin/login');
        }
    }
} 