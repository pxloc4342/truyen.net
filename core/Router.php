<?php
class Router {
    private $routes = [];
    
    public function addRoute($path, $handler) {
        $this->routes[$path] = $handler;
    }
    
    public function dispatch() {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);
        
        // Loại bỏ base path nếu có
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/') {
            $uri = str_replace($basePath, '', $uri);
        }
        
        // Tìm route phù hợp
        foreach ($this->routes as $route => $handler) {
            $pattern = $this->convertRouteToRegex($route);
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Loại bỏ match đầu tiên
                $this->executeHandler($handler, $matches);
                return;
            }
        }
        
        // Không tìm thấy route
        $this->handle404();
    }
    
    private function convertRouteToRegex($route) {
        // Chuyển đổi {id} thành regex pattern
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
        return '#^' . $pattern . '$#';
    }
    
    private function executeHandler($handler, $params = []) {
        list($controller, $method) = explode('@', $handler);
        
        if (!class_exists($controller)) {
            die("Controller {$controller} không tồn tại");
        }
        
        $controllerInstance = new $controller();
        
        if (!method_exists($controllerInstance, $method)) {
            die("Method {$method} không tồn tại trong controller {$controller}");
        }
        
        call_user_func_array([$controllerInstance, $method], $params);
    }
    
    private function handle404() {
        http_response_code(404);
        echo '<h1>404 - Không tìm thấy trang</h1>';
        echo '<p>Trang bạn đang tìm kiếm không tồn tại.</p>';
        echo '<a href="/">Về trang chủ</a>';
    }
}
?> 