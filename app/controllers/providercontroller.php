<?php

require_once 'basecontroller.php';

class ProviderController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        // Check if user is provider
        checkRole(['prestador']);
    }
    
    /**
     * Provider dashboard
     */
    public function dashboard() {
        $this->data['pageTitle'] = 'Mi Panel - ServiBOT';
        
        $this->view('provider/dashboard', $this->data);
    }
    
    /**
     * Provider requests
     */
    public function requests() {
        $this->data['pageTitle'] = 'Mis Servicios - ServiBOT';
        
        $this->view('provider/requests', $this->data);
    }
    
    /**
     * Provider profile management
     */
    public function profile() {
        $this->data['pageTitle'] = 'Mi Perfil - ServiBOT';
        
        if ($this->isPost()) {
            $this->handleProfileUpdate();
        }
        
        $this->data['provider'] = $this->getProviderProfile();
        $this->data['categories'] = $this->getServiceCategories();
        
        $this->view('provider/profile', $this->data);
    }
    
    /**
     * Get provider profile data
     */
    private function getProviderProfile() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $userId = $_SESSION['user_id'];
            
            $stmt = $connection->prepare("
                SELECT sp.*, u.name, u.email, u.phone, u.address 
                FROM service_providers sp
                RIGHT JOIN users u ON sp.user_id = u.id
                WHERE u.id = ?
            ");
            $stmt->execute([$userId]);
            
            $result = $stmt->fetch();
            
            // If no provider record exists, create a basic one
            if (!$result || !$result['user_id']) {
                $this->createProviderProfile($userId);
                $stmt->execute([$userId]);
                $result = $stmt->fetch();
            }
            
            return $result;
        } catch (PDOException $e) {
            return null;
        }
    }
    
    /**
     * Create basic provider profile
     */
    private function createProviderProfile($userId) {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                INSERT INTO service_providers (user_id, service_categories, keywords, experience_years, coverage_radius)
                VALUES (?, '[]', '', 0, 10)
            ");
            $stmt->execute([$userId]);
        } catch (PDOException $e) {
            // Handle error silently
        }
    }
    
    /**
     * Get all service categories
     */
    private function getServiceCategories() {
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $stmt = $connection->prepare("
                SELECT id, name, description, icon
                FROM service_categories
                WHERE is_active = 1
                ORDER BY name
            ");
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Handle profile update
     */
    private function handleProfileUpdate() {
        $this->validateCsrf();
        
        try {
            $db = Database::getInstance();
            $connection = $db->getConnection();
            
            $userId = $_SESSION['user_id'];
            $keywords = $this->sanitize($this->getPost('keywords'));
            $serviceCategories = $this->getPost('service_categories', []);
            $experienceYears = (int) $this->getPost('experience_years', 0);
            $coverageRadius = (int) $this->getPost('coverage_radius', 10);
            
            // Update user basic info
            $name = $this->sanitize($this->getPost('name'));
            $phone = $this->sanitize($this->getPost('phone'));
            $address = $this->sanitize($this->getPost('address'));
            
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
            }
            
            // Start transaction
            $connection->beginTransaction();
            
            // Update user basic info with or without password
            if (!empty($newPassword)) {
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                $stmt = $connection->prepare("
                    UPDATE users 
                    SET name = ?, phone = ?, address = ?, password = ?, updated_at = CURRENT_TIMESTAMP
                    WHERE id = ?
                ");
                $stmt->execute([$name, $phone, $address, $hashedPassword, $userId]);
            } else {
                $stmt = $connection->prepare("
                    UPDATE users 
                    SET name = ?, phone = ?, address = ?, updated_at = CURRENT_TIMESTAMP
                    WHERE id = ?
                ");
                $stmt->execute([$name, $phone, $address, $userId]);
            }
            
            // Update session name if changed
            if ($name !== $_SESSION['user_name']) {
                $_SESSION['user_name'] = $name;
            }
            
            // Ensure provider profile exists before updating
            $providerExists = $connection->prepare("SELECT user_id FROM service_providers WHERE user_id = ?");
            $providerExists->execute([$userId]);
            
            if (!$providerExists->fetch()) {
                $this->createProviderProfile($userId);
            }
            
            // Update provider-specific info
            $serviceCategoriesJson = json_encode(array_map('intval', $serviceCategories));
            
            $stmt = $connection->prepare("
                UPDATE service_providers 
                SET keywords = ?, service_categories = ?, experience_years = ?, 
                    coverage_radius = ?, updated_at = CURRENT_TIMESTAMP
                WHERE user_id = ?
            ");
            $stmt->execute([$keywords, $serviceCategoriesJson, $experienceYears, $coverageRadius, $userId]);
            
            // Commit transaction
            $connection->commit();
            
            $this->data['success'] = 'Perfil actualizado correctamente.';
            
        } catch (PDOException $e) {
            // Rollback transaction on error
            if ($connection->inTransaction()) {
                $connection->rollback();
            }
            // Log error for debugging (in production, log this properly)
            error_log("Provider profile update error: " . $e->getMessage());
            $this->data['error'] = 'Error al actualizar el perfil. Intenta nuevamente.';
        }
    }
}