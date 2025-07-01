<?php

class StoryController extends Controller {
    
    public function index() {
        $storyModel = new Story();
        $stories = $storyModel->getAllStories();
        
        $this->render('stories/index', [
            'stories' => $stories,
            'title' => 'Danh sách truyện'
        ]);
    }
    
    public function show($id) {
        $storyModel = new Story();
        require_once MODELS_PATH . '/Chapter.php';
        $chapterModel = new Chapter();
        $story = $storyModel->getById($id);
        if (!$story) {
            $this->render('errors/404', [
                'title' => 'Không tìm thấy truyện'
            ]);
            return;
        }
        $chapters = $chapterModel->getByStoryId($id);
        $this->render('stories/show', [
            'story' => $story,
            'chapters' => $chapters,
            'title' => $story['title']
        ]);
    }

    public function chapter($story_id, $chapter_id) {
        require_once MODELS_PATH . '/Story.php';
        require_once MODELS_PATH . '/Chapter.php';
        require_once MODELS_PATH . '/ChapterImage.php';
        $storyModel = new Story();
        $chapterModel = new Chapter();
        $chapterImageModel = new ChapterImage();
        $story = $storyModel->getById($story_id);
        $chapter = $chapterModel->getById($chapter_id);
        if (!$story || !$chapter) {
            $this->render('errors/404', ['title' => 'Không tìm thấy chương']);
            return;
        }
        // Lấy nội dung chapter
        $chapterContent = htmlspecialchars($chapter['content']);
        // Lấy chapter trước/sau
        $chapters = $chapterModel->getByStoryId($story_id);
        $prevChapter = $nextChapter = null;
        foreach ($chapters as $idx => $ch) {
            if ($ch['id'] == $chapter_id) {
                $prevChapter = $chapters[$idx-1] ?? null;
                $nextChapter = $chapters[$idx+1] ?? null;
                break;
            }
        }
        // Lấy danh sách ảnh chapter
        $chapterImages = $chapterImageModel->getImagesByChapter($chapter_id);
        $this->render('stories/chapter', [
            'story' => $story,
            'chapter' => $chapter,
            'chapterContent' => $chapterContent,
            'prevChapter' => $prevChapter,
            'nextChapter' => $nextChapter,
            'chapters' => $chapters,
            'chapterImages' => $chapterImages
        ]);
    }
} 