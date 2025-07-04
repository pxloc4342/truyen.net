<?php
class Story {
    private $db;
    private $table = 'stories';
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function getAll($limit = null, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} ORDER BY id ASC";
        if ($limit) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        return $this->db->fetchAll($sql);
    }
    
    public function getById($id) {
        return $this->db->fetch(
            "SELECT * FROM {$this->table} WHERE id = ?",
            [$id]
        );
    }
    
    public function getByCategory($categoryId, $limit = null, $offset = 0) {
        $sql = "SELECT s.* FROM {$this->table} s 
                JOIN story_category sc ON s.id = sc.story_id 
                WHERE sc.category_id = ? 
                ORDER BY s.created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        
        return $this->db->fetchAll($sql, [$categoryId]);
    }
    
    public function search($keyword, $limit = null, $offset = 0) {
        $sql = "SELECT * FROM {$this->table} 
                WHERE title LIKE ? OR description LIKE ? 
                ORDER BY created_at DESC";
        
        if ($limit) {
            $sql .= " LIMIT {$limit} OFFSET {$offset}";
        }
        
        $keyword = "%{$keyword}%";
        return $this->db->fetchAll($sql, [$keyword, $keyword]);
    }
    
    public function getHot($limit = 8, $status = '', $categoryId = '') {
        $params = [];
        $where = [];
        $join = '';
        if ($status) {
            $where[] = 's.status = ?';
            $params[] = $status;
        }
        if ($categoryId) {
            $join .= ' JOIN story_category sc ON s.id = sc.story_id ';
            $where[] = 'sc.category_id = ?';
            $params[] = $categoryId;
        }
        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
        $sql = "SELECT s.*, 
                (SELECT c.id FROM chapters c WHERE c.story_id = s.id ORDER BY c.chapter_number DESC, c.id DESC LIMIT 1) AS latest_chapter_id,
                (SELECT c.chapter_number FROM chapters c WHERE c.story_id = s.id ORDER BY c.chapter_number DESC, c.id DESC LIMIT 1) AS latest_chapter_number
            FROM stories s
            $join
            $whereSql
            ORDER BY s.views DESC, s.created_at DESC
            LIMIT $limit";
        return $this->db->fetchAll($sql, $params);
    }
    
    public function getLatest($limit = 8) {
        return $this->db->fetchAll(
            "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT ?",
            [$limit]
        );
    }
    
    public function create($data) {
        return $this->db->insert($this->table, $data);
    }
    
    public function update($id, $data) {
        return $this->db->update($this->table, $data, 'id = ?', [$id]);
    }
    
    public function delete($id) {
        return $this->db->delete($this->table, 'id = ?', [$id]);
    }
    
    public function incrementViews($id) {
        return $this->db->query(
            "UPDATE {$this->table} SET views = views + 1 WHERE id = ?",
            [$id]
        );
    }
    
    public function count() {
        $result = $this->db->fetch("SELECT COUNT(*) as count FROM {$this->table}");
        return $result['count'];
    }
    
    public function countByCategory($categoryId) {
        $result = $this->db->fetch(
            "SELECT COUNT(*) as count FROM {$this->table} s 
             JOIN story_category sc ON s.id = sc.story_id 
             WHERE sc.category_id = ?",
            [$categoryId]
        );
        return $result['count'];
    }
    
    // Lấy truyện mới cập nhật, có thể lọc theo trạng thái và thể loại, sắp xếp theo chapter mới nhất
    public function getLatestWithFilter($status = '', $categoryId = '', $limit = 30, $offset = 0) {
        $params = [];
        $where = [];
        $join = '';
        if ($status) {
            $where[] = 's.status = ?';
            $params[] = $status;
        }
        if ($categoryId) {
            $join .= ' JOIN story_category sc ON s.id = sc.story_id ';
            $where[] = 'sc.category_id = ?';
            $params[] = $categoryId;
        }
        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
        $sql = "SELECT s.*, 
                (SELECT c.id FROM chapters c WHERE c.story_id = s.id ORDER BY c.chapter_number DESC, c.id DESC LIMIT 1) AS latest_chapter_id,
                (SELECT c.chapter_number FROM chapters c WHERE c.story_id = s.id ORDER BY c.chapter_number DESC, c.id DESC LIMIT 1) AS latest_chapter_number
            FROM stories s
            $join
            $whereSql
            ORDER BY latest_chapter_number DESC, s.created_at DESC
            LIMIT $limit OFFSET $offset";
        return $this->db->fetchAll($sql, $params);
    }
} 