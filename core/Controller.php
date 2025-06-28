<?php
class Controller {
    protected $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    protected function render($view, $data = [], $useLayout = true) {
        // Extract data thành biến
        extract($data);
        
        // Bắt đầu output buffering
        ob_start();
        
        // Include view file
        $viewFile = VIEWS_PATH . '/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            die("View {$view} không tồn tại");
        }
        
        // Lấy nội dung và xóa buffer
        $content = ob_get_clean();
        
        if ($useLayout) {
            // Include layout
            $layoutFile = VIEWS_PATH . '/layouts/main.php';
            if (file_exists($layoutFile)) {
                include $layoutFile;
            } else {
                echo $content;
            }
        } else {
            echo $content;
        }
    }
    
    protected function renderPartial($view, $data = []) {
        extract($data);
        
        $viewFile = VIEWS_PATH . '/' . $view . '.php';
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            die("View {$view} không tồn tại");
        }
    }
    
    protected function redirect($url) {
        header("Location: {$url}");
        exit;
    }
    
    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    protected function getPost($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return isset($_POST[$key]) ? $_POST[$key] : $default;
    }
    
    protected function getQuery($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }
    
    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $rule) {
            $value = isset($data[$field]) ? $data[$field] : '';
            
            if (strpos($rule, 'required') !== false && empty($value)) {
                $errors[$field] = "Trường {$field} là bắt buộc";
            }
            
            if (strpos($rule, 'email') !== false && !empty($value) && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "Email không hợp lệ";
            }
            
            if (strpos($rule, 'min:') !== false) {
                preg_match('/min:(\d+)/', $rule, $matches);
                $min = $matches[1];
                if (strlen($value) < $min) {
                    $errors[$field] = "Trường {$field} phải có ít nhất {$min} ký tự";
                }
            }
        }
        
        return $errors;
    }
}
?> 