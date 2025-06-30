<?php
class Chapter {
    private $db;
    private $table = 'chapters';

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getById($id) {
        return $this->db->fetch("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function getByStoryId($story_id) {
        return $this->db->fetchAll("SELECT * FROM {$this->table} WHERE story_id = ? ORDER BY id ASC", [$story_id]);
    }

    public function create($data) {
        return $this->db->insert($this->table, $data);
    }
} 