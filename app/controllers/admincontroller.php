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
        
        if ($this->isPost()) {
            $this->handleNewService();
        }
        
        $this->data['services'] = $this->getAllServices();
        
        $this->view('admin/services', $this->data);
    }
    
    /**
     * Create new user
     */
    public function newuser() {
        $this->data['pageTitle'] = 'Nuevo Usuario - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleNewUser();
        }
        
        $this->data['franchises'] = $this->model('franchise')->getAll();
        
        $this->view('admin/newuser', $this->data);
    }
    
    /**
     * Create new service category
     */
    public function newservice() {
        $this->data['pageTitle'] = 'Nuevo Servicio - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleNewService();
        }
        
        $this->view('admin/newservice', $this->data);
    }
    
    /**
     * Manage franchises
     */
    public function franchises() {
        $this->data['pageTitle'] = 'Gestión de Franquicias - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleNewFranchise();
        }
        
        $this->data['franchises'] = $this->getAllFranchises();
        $this->data['representatives'] = $this->getPotentialRepresentatives();
        
        $this->view('admin/franchises', $this->data);
    }
    
    /**
     * Admin profile management
     */
    public function profile() {
        $this->data['pageTitle'] = 'Mi Perfil - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleProfileUpdate();
        }
        
        $this->data['admin'] = $this->getAdminProfile();
        
        $this->view('admin/profile', $this->data);
    }
    
    /**
     * List pending providers awaiting authorization
     */
    public function pending_providers() {
        $this->data['pageTitle'] = 'Prestadores por Autorizar - ServiBOT';
        
        $this->data['pendingProviders'] = $this->getPendingProviders();
        
        $this->view('admin/pending_providers', $this->data);
    }
    
    /**
     * Approve or reject provider applications
     */
    public function approve($userId = null) {
        if ($userId && $this->isPost()) {
            $action = $this->getPost('action');
            
            if ($action === 'approve') {
                $this->approveProvider($userId);
            } elseif ($action === 'reject') {
                $this->rejectProvider($userId);
            }
        }
        
        $this->redirect('admin/pending_providers');
    }
    
    /**
     * Get all users
     */
    private function getAllUsers() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                SELECT u.id, u.email, u.name, u.role, u.phone, u.is_active, u.created_at,
                       sp.city, sp.is_verified
                FROM users u 
                LEFT JOIN service_providers sp ON u.id = sp.user_id
                ORDER BY u.created_at DESC
            ");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Get pending providers awaiting authorization
     */
    private function getPendingProviders() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                SELECT u.id, u.name, u.email, u.phone, u.address, u.created_at,
                       sp.city, sp.experience_years, sp.keywords, sp.is_verified
                FROM users u
                LEFT JOIN service_providers sp ON u.id = sp.user_id
                WHERE u.role = 'prestador' 
                AND (sp.is_verified = 0 OR sp.is_verified IS NULL)
                AND u.is_active = 1
                ORDER BY u.created_at DESC
            ");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Get all services
     */
    private function getAllServices() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                SELECT * FROM service_categories 
                ORDER BY name ASC
            ");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Get all franchises
     */
    private function getAllFranchises() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                SELECT f.*, u.name as representative_name
                FROM franchises f
                LEFT JOIN users u ON f.representative_id = u.id
                ORDER BY f.city ASC
            ");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Get potential franchise representatives
     */
    private function getPotentialRepresentatives() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                SELECT id, name, email 
                FROM users 
                WHERE role IN ('superadmin', 'prestador') 
                AND is_active = 1
                ORDER BY name ASC
            ");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Handle new user creation
     */
    private function handleNewUser() {
        $this->validateCsrf();
        
        $data = [
            'name' => $this->sanitize($this->getPost('name')),
            'email' => $this->sanitize($this->getPost('email')),
            'role' => $this->sanitize($this->getPost('role')),
            'phone' => $this->sanitize($this->getPost('phone')),
            'address' => $this->sanitize($this->getPost('address')),
            'password' => $this->getPost('password'),
            'is_active' => (int) $this->getPost('active', 1),
            'city' => $this->sanitize($this->getPost('city'))
        ];
        
        // Basic validation
        if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
            $this->data['error'] = 'Nombre, email y contraseña son requeridos.';
            return;
        }
        
        if ($this->userModel->emailExists($data['email'])) {
            $this->data['error'] = 'El email ya está registrado.';
            return;
        }
        
        if ($this->userModel->create($data)) {
            // If provider, create service provider record
            if ($data['role'] === 'prestador' && !empty($data['city'])) {
                $user = $this->userModel->getByEmail($data['email']);
                if ($user) {
                    $this->createProviderProfile($user['id'], $data['city']);
                }
            }
            
            $this->data['success'] = 'Usuario creado exitosamente.';
        } else {
            $this->data['error'] = 'Error al crear el usuario.';
        }
    }
    
    /**
     * Handle new service creation
     */
    private function handleNewService() {
        $this->validateCsrf();
        
        $data = [
            'name' => $this->sanitize($this->getPost('name')),
            'description' => $this->sanitize($this->getPost('description')),
            'icon' => $this->sanitize($this->getPost('icon')),
            'base_price' => (float) $this->getPost('base_price', 0),
            'estimated_duration' => (int) $this->getPost('estimated_duration', 60),
            'is_active' => (int) $this->getPost('active', 1)
        ];
        
        if (empty($data['name'])) {
            $this->data['error'] = 'El nombre del servicio es requerido.';
            return;
        }
        
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                INSERT INTO service_categories (name, description, icon, base_price, estimated_duration, is_active)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            
            if ($stmt->execute([$data['name'], $data['description'], $data['icon'], 
                              $data['base_price'], $data['estimated_duration'], $data['is_active']])) {
                $this->data['success'] = 'Servicio creado exitosamente.';
            } else {
                $this->data['error'] = 'Error al crear el servicio.';
            }
        } catch (PDOException $e) {
            $this->data['error'] = 'Error al crear el servicio.';
        }
    }
    
    /**
     * Handle new franchise creation
     */
    private function handleNewFranchise() {
        $this->validateCsrf();
        
        $data = [
            'name' => $this->sanitize($this->getPost('name')),
            'city' => $this->sanitize($this->getPost('city')),
            'representative_id' => (int) $this->getPost('representative_id') ?: null,
            'is_active' => (int) $this->getPost('active', 1)
        ];
        
        if (empty($data['name']) || empty($data['city'])) {
            $this->data['error'] = 'Nombre y ciudad son requeridos.';
            return;
        }
        
        $franchiseModel = $this->model('franchise');
        
        if ($franchiseModel->create($data)) {
            $this->data['success'] = 'Franquicia creada exitosamente.';
        } else {
            $this->data['error'] = 'Error al crear la franquicia.';
        }
    }
    
    /**
     * Create provider profile for new user
     */
    private function createProviderProfile($userId, $city) {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                INSERT INTO service_providers (user_id, city, is_verified, is_available)
                VALUES (?, ?, 0, 0)
            ");
            
            return $stmt->execute([$userId, $city]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Approve provider
     */
    private function approveProvider($userId) {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            // Activate user account
            $stmt = $connection->prepare("UPDATE users SET is_active = 1 WHERE id = ?");
            $stmt->execute([$userId]);
            
            // Verify provider profile
            $stmt = $connection->prepare("UPDATE service_providers SET is_verified = 1, is_available = 1 WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            $this->data['success'] = 'Prestador aprobado exitosamente.';
        } catch (PDOException $e) {
            $this->data['error'] = 'Error al aprobar el prestador.';
        }
    }
    
    /**
     * Reject provider
     */
    private function rejectProvider($userId) {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            // Keep user inactive and provider unverified
            $stmt = $connection->prepare("UPDATE users SET is_active = 0 WHERE id = ?");
            $stmt->execute([$userId]);
            
            $stmt = $connection->prepare("UPDATE service_providers SET is_verified = 0, is_available = 0 WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            $this->data['success'] = 'Prestador rechazado.';
        } catch (PDOException $e) {
            $this->data['error'] = 'Error al rechazar el prestador.';
        }
    }
    
    /**
     * Get admin profile data
     */
    private function getAdminProfile() {
        try {
            $userModel = $this->model('user');
            return $userModel->getById($_SESSION['user_id']);
        } catch (Exception $e) {
            return null;
        }
    }
    
    /**
     * Handle admin profile update
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
}