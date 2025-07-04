<?php
if (
    $_SERVER['REQUEST_URI'] === '/WebTruyenTranh/auth.php' ||
    $_SERVER['REQUEST_URI'] === '/auth.php'
) {
    require __DIR__ . '/auth.php';
    exit;
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Entry point cho ứng dụng MVC
session_start();

// Định nghĩa các hằng số
define('ROOT_PATH', __DIR__);
define('MODELS_PATH', ROOT_PATH . '/models');
define('VIEWS_PATH', ROOT_PATH . '/views');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('CORE_PATH', ROOT_PATH . '/core');
define('CONFIG_PATH', ROOT_PATH . '/config');

// Autoloader đơn giản
spl_autoload_register(function ($class) {
    $paths = [
        CONTROLLERS_PATH . '/',
        MODELS_PATH . '/',
        CORE_PATH . '/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Load cấu hình
require_once CONFIG_PATH . '/database.php';
require_once CONFIG_PATH . '/config.php';

// Khởi tạo Router
$router = new Router();

// Định nghĩa các routes
$router->addRoute('/', 'HomeController@index');
$router->addRoute('/truyen', 'StoryController@index');
$router->addRoute('/truyen/{id}', 'StoryController@show');
$router->addRoute('/truyen/{story_id}/chuong/{chapter_id}', 'StoryController@chapter');
$router->addRoute('/the-loai', 'CategoryController@index');
$router->addRoute('/the-loai/{id}', 'CategoryController@show');
$router->addRoute('/tim-kiem', 'SearchController@index');
$router->addRoute('/tim-kiem/ajax', 'SearchController@ajax');
$router->addRoute('/tim-kiem/autocomplete', 'SearchController@autocomplete');
$router->addRoute('/dang-nhap', 'AuthController@login');
$router->addRoute('/dang-ky', 'AuthController@register');
$router->addRoute('/dang-xuat', 'AuthController@logout');

// Admin routes
$router->addRoute('/admin/logout', 'AdminController@logout');
$router->addRoute('/admin/dashboard', 'AdminController@dashboard');
$router->addRoute('/admin/stories', 'AdminStoryController@index');
$router->addRoute('/admin/stories/create', 'AdminStoryController@create');
$router->addRoute('/admin/stories/edit/{id}', 'AdminStoryController@edit');
$router->addRoute('/admin/stories/delete/{id}', 'AdminStoryController@delete');
$router->addRoute('/admin/categories', 'AdminCategoryController@index');
$router->addRoute('/admin/categories/create', 'AdminCategoryController@create');
$router->addRoute('/admin/categories/edit/{id}', 'AdminCategoryController@edit');
$router->addRoute('/admin/categories/delete/{id}', 'AdminCategoryController@delete');

// Thêm route cho quản lý chapter
$router->addRoute('/admin/chapters', 'AdminChapterController@index');
$router->addRoute('/admin/chapters/create', 'AdminChapterController@create');
$router->addRoute('/admin/chapters/store', 'AdminChapterController@store');
$router->addRoute('/admin/chapters/story/{story_id}', 'AdminChapterController@listChapters');
$router->addRoute('/admin/chapters/edit/{id}', 'AdminChapterController@edit');
$router->addRoute('/admin/chapters/update/{id}', 'AdminChapterController@update');

// Thêm route mới '/truyen-de-xuat' trỏ đến StoryController@allSuggested
$router->addRoute('/truyen-de-xuat', 'StoryController@allSuggested');

// Thêm route '/truyen-hot' trỏ đến StoryController@hot
$router->addRoute('/truyen-hot', 'StoryController@hot');

// Xử lý request
$router->dispatch();
?> 