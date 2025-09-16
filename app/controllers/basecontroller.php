<?php

/**
 * Base Controller
 * All controllers extend from this class
 */

class BaseController {
    protected $data = [];
    
    public function __construct() {
        // Initialize common data
        $this->data['baseUrl'] = BASE_URL;
        $this->data['assetsUrl'] = ASSETS_PATH;
        $this->data['currentUser'] = getCurrentUser();
        $this->data['csrfToken'] = csrfToken();
    }
    
    /**
     * Load a view file
     */
    protected function view($viewFile, $data = []) {
        // Merge controller data with view data
        $data = array_merge($this->data, $data);
        
        // Extract data to variables
        extract($data);
        
        // Include the view file
        $viewPath = VIEWS_PATH . $viewFile . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("View file not found: $viewPath");
        }
    }
    
    /**
     * Load a model
     */
    protected function model($modelName) {
        $modelFile = MODELS_PATH . strtolower($modelName) . '.php';
        if (file_exists($modelFile)) {
            require_once $modelFile;
            $modelClass = ucfirst($modelName);
            return new $modelClass();
        } else {
            die("Model file not found: $modelFile");
        }
    }
    
    /**
     * Redirect to another URL
     */
    protected function redirect($url) {
        redirect($url);
    }
    
    /**
     * Return JSON response
     */
    protected function json($data, $status = 200) {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Validate CSRF token
     */
    protected function validateCsrf() {
        $token = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($token)) {
            $this->json(['error' => 'Invalid CSRF token'], 403);
        }
    }
    
    /**
     * Check if request is POST
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Check if request is GET
     */
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    /**
     * Get POST data
     */
    protected function getPost($key = null, $default = null) {
        if ($key === null) {
            return $_POST;
        }
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Get GET data
     */
    protected function getGet($key = null, $default = null) {
        if ($key === null) {
            return $_GET;
        }
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Sanitize input
     */
    protected function sanitize($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitize'], $input);
        }
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}