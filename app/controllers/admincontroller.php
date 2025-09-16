<?php

require_once 'basecontroller.php';

class AdminController extends BaseController {
    private $userModel;
    
    public function __construct() {
        parent::__construct();
        // Check if user is superadmin
        checkRole(['superadmin']);
        $this->userModel = $this->model('user');
    }
    
    /**
     * Admin dashboard
     */
    public function index() {
        $this->data['pageTitle'] = 'Panel de Administración - ServiBOT';
        
        // Get statistics
        $this->data['userStats'] = $this->userModel->getStats();
        
        $this->view('admin/dashboard', $this->data);
    }
    
    /**
     * Manage users
     */
    public function users() {
        $this->data['pageTitle'] = 'Gestión de Usuarios - ServiBOT';
        
        // Get all users
        $this->data['users'] = $this->getAllUsers();
        
        $this->view('admin/users', $this->data);
    }
    
    /**
     * Manage services
     */
    public function services() {
        $this->data['pageTitle'] = 'Gestión de Servicios - ServiBOT';
        
        $this->view('admin/services', $this->data);
    }
    
    /**
     * Get all users
     */
    private function getAllUsers() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                SELECT id, email, name, role, phone, is_active, created_at
                FROM users 
                ORDER BY created_at DESC
            ");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}