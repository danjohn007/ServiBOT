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
        
        $this->data['requests'] = $this->getClientRequests();
        
        $this->view('client/requests', $this->data);
    }
    
    /**
     * Create new service request
     */
    public function new_request() {
        $this->data['pageTitle'] = 'Nueva Solicitud de Servicio - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleNewRequest();
        }
        
        $this->data['services'] = $this->getAllServices();
        
        $this->view('client/new_request', $this->data);
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
            
            // Handle password change if provided
            $newPassword = $this->getPost('new_password');
            $confirmPassword = $this->getPost('confirm_password');
            
            if (!empty($newPassword)) {
                if ($newPassword !== $confirmPassword) {
                    $this->data['error'] = 'Las contraseñas no coinciden.';
                    return;
                }
                if (strlen($newPassword) < 6) {
                    $this->data['error'] = 'La contraseña debe tener al menos 6 caracteres.';
                    return;
                }
                $data['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
            }
            
            if ($userModel->update($userId, $data)) {
                // Update session name if changed
                if ($data['name'] !== $_SESSION['user_name']) {
                    $_SESSION['user_name'] = $data['name'];
                }
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
    
    /**
     * Get client's service requests
     */
    private function getClientRequests() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            $clientId = $_SESSION['user_id'];
            
            $stmt = $connection->prepare("
                SELECT sr.*, sc.name as service_name, sc.icon as service_icon,
                       u.name as provider_name
                FROM service_requests sr
                LEFT JOIN service_categories sc ON sr.category_id = sc.id
                LEFT JOIN users u ON sr.provider_id = u.id
                WHERE sr.client_id = ?
                ORDER BY sr.created_at DESC
            ");
            $stmt->execute([$clientId]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Handle new service request
     */
    private function handleNewRequest() {
        $this->validateCsrf();
        
        try {
            $data = [
                'client_id' => $_SESSION['user_id'],
                'category_id' => (int) $this->getPost('category_id'),
                'title' => $this->sanitize($this->getPost('title')),
                'description' => $this->sanitize($this->getPost('description')),
                'urgency' => $this->sanitize($this->getPost('urgency')),
                'address' => $this->sanitize($this->getPost('address')),
                'scheduled_date' => $this->getPost('scheduled_date') ?: null,
                'status' => 'pendiente'
            ];
            
            // Basic validation
            if (empty($data['category_id']) || empty($data['title']) || empty($data['address'])) {
                $this->data['error'] = 'Servicio, título y dirección son requeridos.';
                return;
            }
            
            // Validate scheduled date for programmed requests
            if ($data['urgency'] === 'programado' && empty($data['scheduled_date'])) {
                $this->data['error'] = 'Fecha programada es requerida para servicios programados.';
                return;
            }
            
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                INSERT INTO service_requests 
                (client_id, category_id, title, description, urgency, address, scheduled_date, status)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            if ($stmt->execute(array_values($data))) {
                $this->data['success'] = 'Solicitud de servicio creada exitosamente.';
                
                // Optionally redirect to requests list
                // header('Location: ' . BASE_URL . 'client/requests');
                // exit;
            } else {
                $this->data['error'] = 'Error al crear la solicitud de servicio.';
            }
        } catch (PDOException $e) {
            $this->data['error'] = 'Error al crear la solicitud de servicio.';
        }
    }
}