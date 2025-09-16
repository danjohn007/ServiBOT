<?php

/**
 * ServiBOT - Home Services Platform
 * Main entry point
 */

// Include configuration
require_once '../app/config/config.php';

class Router {
    private $controller;
    private $action;
    private $params = [];
    
    public function __construct() {
        $this->parseUrl();
        $this->dispatch();
    }
    
    private function parseUrl() {
        // Get the request URI and clean it
        $requestUri = $_SERVER['REQUEST_URI'];
        
        // Remove base URL path from request URI
        $basePath = parse_url(BASE_URL, PHP_URL_PATH);
        if ($basePath && strpos($requestUri, $basePath) === 0) {
            $requestUri = substr($requestUri, strlen($basePath));
        }
        
        // Remove query string
        $requestUri = strtok($requestUri, '?');
        
        // Remove leading/trailing slashes
        $requestUri = trim($requestUri, '/');
        
        // Parse URL segments
        $segments = $requestUri ? explode('/', $requestUri) : [];
        
        $this->controller = !empty($segments[0]) ? $segments[0] : DEFAULT_CONTROLLER;
        $this->action = !empty($segments[1]) ? $segments[1] : DEFAULT_ACTION;
        $this->params = array_slice($segments, 2);
    }
    
    private function dispatch() {
        // Build controller class name
        $controllerClass = ucfirst($this->controller) . 'Controller';
        $controllerFile = CONTROLLERS_PATH . strtolower($this->controller) . 'controller.php';
        
        // Check if controller file exists
        if (file_exists($controllerFile)) {
            require_once $controllerFile;
            
            // Check if controller class exists
            if (class_exists($controllerClass)) {
                $controllerInstance = new $controllerClass();
                
                // Check if action method exists
                if (method_exists($controllerInstance, $this->action)) {
                    // Call the action with parameters
                    call_user_func_array(
                        [$controllerInstance, $this->action], 
                        $this->params
                    );
                } else {
                    $this->show404();
                }
            } else {
                $this->show404();
            }
        } else {
            $this->show404();
        }
    }
    
    private function show404() {
        http_response_code(404);
        require_once VIEWS_PATH . 'errors/404.php';
    }
}

// Start the application
new Router();