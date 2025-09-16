<?php

require_once 'basecontroller.php';

class ClientController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        // Check if user is client
        checkRole(['cliente']);
    }
    
    /**
     * Client dashboard
     */
    public function dashboard() {
        $this->data['pageTitle'] = 'Mi Panel - ServiBOT';
        
        $this->view('client/dashboard', $this->data);
    }
    
    /**
     * Client requests
     */
    public function requests() {
        $this->data['pageTitle'] = 'Mis Solicitudes - ServiBOT';
        
        $this->view('client/requests', $this->data);
    }
    
    /**
     * Browse all services
     */
    public function services() {
        $this->data['pageTitle'] = 'Servicios Disponibles - ServiBOT';
        
        $this->data['services'] = $this->getAllServices();
        
        $this->view('client/services', $this->data);
    }
    
    /**
     * Client profile management
     */
    public function profile() {
        $this->data['pageTitle'] = 'Mi Perfil - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleProfileUpdate();
        }
        
        $this->data['client'] = $this->getClientProfile();
        
        $this->view('client/profile', $this->data);
    }
    
    /**
     * Get client profile data
     */
    private function getClientProfile() {
        try {
            $userModel = $this->model('user');
            return $userModel->getById($_SESSION['user_id']);
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Handle profile update
     */
    private function handleProfileUpdate() {
        $this->validateCsrf();
        
        try {
            $userModel = $this->model('user');
            $userId = $_SESSION['user_id'];
            
            $data = [
                'name' => $this->sanitize($this->getPost('name')),
                'phone' => $this->sanitize($this->getPost('phone')),
                'address' => $this->sanitize($this->getPost('address'))
            ];
            
            if ($userModel->update($userId, $data)) {
                $this->data['success'] = 'Perfil actualizado correctamente.';
            } else {
                $this->data['error'] = 'Error al actualizar el perfil. Intenta nuevamente.';
            }
            
        } catch (Exception $e) {
            $this->data['error'] = 'Error al actualizar el perfil. Intenta nuevamente.';
        }
    }
    
    /**
     * Get all available services
     */
    private function getAllServices() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                SELECT id, name, description, icon, base_price, estimated_duration
                FROM service_categories 
                WHERE is_active = 1
                ORDER BY name ASC
            ");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
}