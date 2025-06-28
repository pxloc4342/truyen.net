<?php
class MangaController extends Controller {
    private $storyModel;
    
    public function __construct() {
        parent::__construct();
        $this->storyModel = new Story();
    }
    
    public function index() {
        $page = $this->getQuery('page', 1);
        $sort = $this->getQuery('sort', 'latest');
        $limit = ITEMS_PER_PAGE;
        $offset = ($page - 1) * $limit;
        
        // Lấy danh sách truyện theo sắp xếp
        switch ($sort) {
            case 'hot':
                $storyList = $this->storyModel->getHot($limit);
                break;
            case 'views':
                $storyList = $this->storyModel->getAll($limit, $offset);
                break;
            default:
                $storyList = $this->storyModel->getLatest($limit);
                break;
        }
        
        $totalStories = $this->storyModel->count();
        $totalPages = ceil($totalStories / $limit);
        
        $this->render('manga/index', [
            'storyList' => $storyList,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'sort' => $sort,
            'title' => 'Danh sách truyện - ' . APP_NAME
        ]);
    }
    
    public function show($id) {
        $story = $this->storyModel->getById($id);
        
        if (!$story) {
            $this->render('errors/404', [
                'title' => 'Không tìm thấy truyện - ' . APP_NAME
            ]);
            return;
        }
        
        // Tăng lượt xem
        $this->storyModel->incrementViews($id);
        
        // Lấy danh sách chapter
        $chapters = $this->db->fetchAll(
            "SELECT * FROM chapters WHERE story_id = ? ORDER BY chapter_number ASC",
            [$id]
        );
        
        // Lấy thể loại của truyện
        $categories = $this->db->fetchAll(
            "SELECT c.* FROM categories c 
             JOIN story_category sc ON c.id = sc.category_id 
             WHERE sc.story_id = ?",
            [$id]
        );
        
        // Lấy truyện liên quan
        $relatedStories = $this->db->fetchAll(
            "SELECT DISTINCT s.* FROM stories s 
             JOIN story_category sc1 ON s.id = sc1.story_id 
             JOIN story_category sc2 ON sc1.category_id = sc2.category_id 
             WHERE sc2.story_id = ? AND s.id != ? 
             LIMIT 6",
            [$id, $id]
        );
        
        $this->render('manga/show', [
            'story' => $story,
            'chapters' => $chapters,
            'categories' => $categories,
            'relatedStories' => $relatedStories,
            'title' => $story['title'] . ' - ' . APP_NAME
        ]);
    }
    
    public function chapter($storyId, $chapterId) {
        $story = $this->storyModel->getById($storyId);
        $chapter = $this->db->fetch(
            "SELECT * FROM chapters WHERE id = ? AND story_id = ?",
            [$chapterId, $storyId]
        );
        
        if (!$story || !$chapter) {
            $this->render('errors/404', [
                'title' => 'Không tìm thấy chapter - ' . APP_NAME
            ]);
            return;
        }
        
        // Lấy danh sách ảnh của chapter
        $images = $this->db->fetchAll(
            "SELECT * FROM chapter_images WHERE chapter_id = ? ORDER BY image_order ASC",
            [$chapterId]
        );
        
        // Lấy chapter trước và sau
        $prevChapter = $this->db->fetch(
            "SELECT * FROM chapters WHERE story_id = ? AND chapter_number < ? ORDER BY chapter_number DESC LIMIT 1",
            [$storyId, $chapter['chapter_number']]
        );
        
        $nextChapter = $this->db->fetch(
            "SELECT * FROM chapters WHERE story_id = ? AND chapter_number > ? ORDER BY chapter_number ASC LIMIT 1",
            [$storyId, $chapter['chapter_number']]
        );
        
        $this->render('manga/chapter', [
            'story' => $story,
            'chapter' => $chapter,
            'images' => $images,
            'prevChapter' => $prevChapter,
            'nextChapter' => $nextChapter,
            'title' => $story['title'] . ' - Chapter ' . $chapter['chapter_number'] . ' - ' . APP_NAME
        ]);
    }
} 