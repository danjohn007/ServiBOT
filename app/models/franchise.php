<?php

class Franchise {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Get all active franchises
     */
    public function getAll() {
        try {
            $sql = "SELECT * FROM franchises WHERE is_active = 1 ORDER BY city ASC";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Get franchise by ID
     */
    public function getById($id) {
        try {
            $sql = "SELECT * FROM franchises WHERE id = :id AND is_active = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Get franchise by city
     */
    public function getByCity($city) {
        try {
            $sql = "SELECT * FROM franchises WHERE city = :city AND is_active = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':city' => $city]);
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Create new franchise
     */
    public function create($data) {
        try {
            $sql = "INSERT INTO franchises (name, city, representative_id, is_active) 
                    VALUES (:name, :city, :representative_id, :is_active)";
            
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                ':name' => $data['name'],
                ':city' => $data['city'],
                ':representative_id' => $data['representative_id'] ?? null,
                ':is_active' => $data['is_active'] ?? 1
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Check if user can approve providers for a city
     */
    public function canApproveForCity($userId, $city) {
        try {
            // Admin can approve anywhere
            $userModel = new User();
            $user = $userModel->getById($userId);
            if ($user && $user['role'] === 'superadmin') {
                return true;
            }
            
            // Check if user is representative of franchise in this city
            $sql = "SELECT id FROM franchises WHERE city = :city AND representative_id = :user_id AND is_active = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':city' => $city, ':user_id' => $userId]);
            
            return $stmt->fetch() !== false;
        } catch (PDOException $e) {
            return false;
        }
    }
}