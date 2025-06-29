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
        $story = $storyModel->getById($id);
        
        if (!$story) {
            $this->render('errors/404', [
                'title' => 'Không tìm thấy truyện'
            ]);
            return;
        }
        
        $this->render('stories/show', [
            'story' => $story,
            'title' => $story['title']
        ]);
    }
} 