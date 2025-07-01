<?php
class ChapterImage {
    private $db;
    public function __construct() {
        require_once __DIR__ . '/../core/Database.php';
        $this->db = Database::getInstance();
    }
    // Thêm 1 ảnh vào chapter
    public function addImage($chapter_id, $image_path, $sort_order = 0) {
        $this->db->query("INSERT INTO chapter_images (chapter_id, image_path, sort_order) VALUES (?, ?, ?)", [$chapter_id, $image_path, $sort_order]);
        return true;
    }
    // Lấy danh sách ảnh theo chapter
    public function getImagesByChapter($chapter_id) {
        return $this->db->fetchAll("SELECT * FROM chapter_images WHERE chapter_id = ? ORDER BY sort_order ASC, id ASC", [$chapter_id]);
    }
    // Xoá toàn bộ ảnh của 1 chapter
    public function deleteByChapter($chapter_id) {
        $this->db->query("DELETE FROM chapter_images WHERE chapter_id = ?", [$chapter_id]);
        return true;
    }
    // Lấy 1 ảnh theo id
    public function getImageById($id) {
        return $this->db->fetch("SELECT * FROM chapter_images WHERE id = ?", [$id]);
    }
    // Xoá 1 ảnh theo id
    public function deleteById($id) {
        $this->db->query("DELETE FROM chapter_images WHERE id = ?", [$id]);
        return true;
    }
    // Lấy số thứ tự lớn nhất của ảnh trong 1 chapter
    public function getMaxOrder($chapter_id) {
        $row = $this->db->fetch("SELECT MAX(sort_order) as max_order FROM chapter_images WHERE chapter_id = ?", [$chapter_id]);
        return $row ? (int)$row['max_order'] : 0;
    }
} 