<?php
class HomeController extends Controller {
    
    public function index() {
        // Get latest stories (6 per row as per design)
        $latestStories = $this->db->fetchAll("
            SELECT s.*, 
                   (SELECT COUNT(*) FROM chapters WHERE story_id = s.id) as chapter_count
            FROM stories s 
            ORDER BY s.created_at DESC 
            LIMIT 12
        ");
        
        // Get featured stories for slider (top viewed stories)
        $featuredStories = $this->db->fetchAll("
            SELECT s.*, 
                   (SELECT COUNT(*) FROM chapters WHERE story_id = s.id) as chapter_count
            FROM stories s 
            ORDER BY s.views DESC, s.created_at DESC 
            LIMIT 8
        ");
        
        $this->render('home/index', [
            'title' => 'Trang chủ - ' . APP_NAME,
            'latestStories' => $latestStories,
            'featuredStories' => $featuredStories
        ]);
    }
}
?> 