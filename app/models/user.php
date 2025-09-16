<?php

/**
 * User Model
 * Handles user-related database operations
 */

class User {
    private $db;
    
    public function __construct() {
        $database = Database::getInstance();
        $this->db = $database->getConnection();
    }
    
    /**
     * Create a new user
     */
    public function create($data) {
        try {
            $sql = "INSERT INTO users (email, password, role, name, phone, address, latitude, longitude) 
                    VALUES (:email, :password, :role, :name, :phone, :address, :latitude, :longitude)";
            
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([
                ':email' => $data['email'],
                ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
                ':role' => $data['role'],
                ':name' => $data['name'],
                ':phone' => $data['phone'] ?? null,
                ':address' => $data['address'] ?? null,
                ':latitude' => $data['latitude'] ?? null,
                ':longitude' => $data['longitude'] ?? null
            ]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Find user by email
     */
    public function findByEmail($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email AND is_active = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Find user by ID
     */
    public function findById($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id AND is_active = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            return $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Verify user password
     */
    public function verifyPassword($password, $hash) {
        return password_verify($password, $hash);
    }
    
    /**
     * Update user information
     */
    public function update($id, $data) {
        try {
            $fields = [];
            $params = [':id' => $id];
            
            foreach ($data as $key => $value) {
                if ($key !== 'id' && $value !== null) {
                    $fields[] = "$key = :$key";
                    $params[":$key"] = $value;
                }
            }
            
            if (empty($fields)) {
                return false;
            }
            
            $sql = "UPDATE users SET " . implode(', ', $fields) . ", updated_at = CURRENT_TIMESTAMP WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute($params);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Check if email exists
     */
    public function emailExists($email, $excludeId = null) {
        try {
            $sql = "SELECT id FROM users WHERE email = :email";
            $params = [':email' => $email];
            
            if ($excludeId) {
                $sql .= " AND id != :exclude_id";
                $params[':exclude_id'] = $excludeId;
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);
            
            return $stmt->fetch() !== false;
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Get users by role
     */
    public function getByRole($role, $limit = null) {
        try {
            $sql = "SELECT * FROM users WHERE role = :role AND is_active = 1 ORDER BY created_at DESC";
            
            if ($limit) {
                $sql .= " LIMIT :limit";
            }
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':role', $role);
            
            if ($limit) {
                $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
            }
            
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Get user statistics
     */
    public function getStats() {
        try {
            $sql = "SELECT 
                        role,
                        COUNT(*) as count
                    FROM users 
                    WHERE is_active = 1 
                    GROUP BY role";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            
            $stats = [];
            while ($row = $stmt->fetch()) {
                $stats[$row['role']] = $row['count'];
            }
            
            return $stats;
        } catch (PDOException $e) {
            return [];
        }
    }
    
    /**
     * Deactivate user
     */
    public function deactivate($id) {
        try {
            $sql = "UPDATE users SET is_active = 0, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Activate user
     */
    public function activate($id) {
        try {
            $sql = "UPDATE users SET is_active = 1, updated_at = CURRENT_TIMESTAMP WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
    
    /**
     * Update last login
     */
    public function updateLastLogin($id) {
        try {
            $sql = "UPDATE users SET updated_at = CURRENT_TIMESTAMP WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            return false;
        }
    }
}