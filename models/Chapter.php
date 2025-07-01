<?php
class Chapter {
    private $db;
    private $table = 'chapters';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM chapters WHERE id = ?", [$id]);
    }

    public function getByStoryId($story_id) {
        return $this->db->fetchAll("SELECT * FROM {$this->table} WHERE story_id = ? ORDER BY id ASC", [$story_id]);
    }

    public function create($data) {
        return $this->db->insert($this->table, $data);
    }

    public function getMaxChapterNumber($story_id) {
        $row = $this->db->fetch("SELECT MAX(chapter_number) as max_num FROM {$this->table} WHERE story_id = ?", [$story_id]);
        return $row && $row['max_num'] !== null ? (int)$row['max_num'] : 0;
    }

    public function update($id, $data) {
        $fields = array_keys($data);
        $set = implode(' = ?, ', $fields) . ' = ?';
        $sql = "UPDATE {$this->table} SET {$set} WHERE id = ?";
        $params = array_values($data);
        $params[] = $id;
        return $this->db->query($sql, $params);
    }
} 