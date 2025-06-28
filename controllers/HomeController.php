<?php
class HomeController extends Controller {
    
    public function index() {
        // Lấy danh sách truyện mới nhất
        $latestStories = $this->db->fetchAll(
            "SELECT * FROM stories ORDER BY created_at DESC LIMIT 8"
        );
        
        // Lấy danh sách truyện hot
        $hotStories = $this->db->fetchAll(
            "SELECT * FROM stories ORDER BY views DESC LIMIT 8"
        );
        
        // Lấy danh sách thể loại
        $categories = $this->db->fetchAll(
            "SELECT * FROM categories ORDER BY name ASC"
        );
        
        $this->render('home/index', [
            'latestStories' => $latestStories,
            'hotStories' => $hotStories,
            'categories' => $categories,
            'title' => 'Trang chủ - ' . APP_NAME
        ]);
    }
}
?> 