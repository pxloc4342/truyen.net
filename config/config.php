<?php
// Cấu hình chung cho ứng dụng

// Cấu hình cơ bản
define('APP_NAME', 'Web Truyện Tranh');
define('APP_URL', 'http://localhost/WebTruyenTranh');
define('APP_VERSION', '1.0.0');

// Cấu hình upload
define('UPLOAD_PATH', ROOT_PATH . '/uploads');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_IMAGE_TYPES', ['jpg', 'jpeg', 'png', 'gif']);

// Cấu hình phân trang
define('ITEMS_PER_PAGE', 12);

// Cấu hình session
define('SESSION_LIFETIME', 3600); // 1 giờ

// Cấu hình bảo mật
define('HASH_COST', 12);

// Cấu hình timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Cấu hình error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);
?> 