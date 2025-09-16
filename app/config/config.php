<?php

/**
 * Application Configuration
 */

// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Auto-detect base URL
function getBaseUrl() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $script = $_SERVER['SCRIPT_NAME'];
    $path = dirname($script);
    
    // Remove /public from path if present
    $path = str_replace('/public', '', $path);
    
    return $protocol . $host . rtrim($path, '/') . '/';
}

// Define constants
define('BASE_URL', getBaseUrl());
define('APP_NAME', 'ServiBOT');
define('APP_VERSION', '1.0.0');

// Application paths
define('APP_PATH', dirname(dirname(__FILE__)) . '/');
define('VIEWS_PATH', APP_PATH . 'views/');
define('MODELS_PATH', APP_PATH . 'models/');
define('CONTROLLERS_PATH', APP_PATH . 'controllers/');
define('PUBLIC_PATH', dirname(APP_PATH) . '/public/');
define('ASSETS_PATH', BASE_URL . 'public/assets/');
define('UPLOADS_PATH', BASE_URL . 'public/uploads/');

// Security settings
define('PASSWORD_SALT', 'ServiBot_2024_Salt_Key_#123');
define('SESSION_TIMEOUT', 3600); // 1 hour

// Application settings
define('DEFAULT_CONTROLLER', 'home');
define('DEFAULT_ACTION', 'index');

// Timezone
date_default_timezone_set('America/Mexico_City');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database configuration
require_once 'database.php';

// Autoloader function
function autoload($className) {
    $modelFile = MODELS_PATH . strtolower($className) . '.php';
    $controllerFile = CONTROLLERS_PATH . strtolower($className) . '.php';
    
    if (file_exists($modelFile)) {
        require_once $modelFile;
    } elseif (file_exists($controllerFile)) {
        require_once $controllerFile;
    }
}

spl_autoload_register('autoload');

// Helper functions
function redirect($url) {
    header('Location: ' . BASE_URL . ltrim($url, '/'));
    exit;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function getCurrentUser() {
    if (isLoggedIn()) {
        return [
            'id' => $_SESSION['user_id'],
            'email' => $_SESSION['user_email'] ?? '',
            'role' => $_SESSION['user_role'] ?? '',
            'name' => $_SESSION['user_name'] ?? ''
        ];
    }
    return null;
}

function checkRole($allowedRoles) {
    if (!isLoggedIn()) {
        redirect('auth/login');
    }
    
    $currentRole = $_SESSION['user_role'] ?? '';
    if (!in_array($currentRole, $allowedRoles)) {
        redirect('home');
    }
}

function csrfToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}