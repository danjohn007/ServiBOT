<?php

/**
 * Database Configuration
 */

// Database credentials - modify these according to your environment
define('DB_HOST', 'localhost');
define('DB_NAME', 'servibot_db');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Database connection class
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            // Try SQLite for development/testing first, then MySQL
            $sqliteFile = dirname(dirname(dirname(__FILE__))) . '/database/servibot.sqlite';
            
            if (file_exists($sqliteFile) || !extension_loaded('mysql')) {
                $dsn = "sqlite:" . $sqliteFile;
                $this->connection = new PDO($dsn, null, null, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]);
                
                // Enable foreign keys for SQLite
                $this->connection->exec('PRAGMA foreign_keys = ON');
                
                if (!file_exists($sqliteFile)) {
                    $this->createSQLiteTables();
                }
            } else {
                // MySQL connection
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
                $this->connection = new PDO($dsn, DB_USER, DB_PASS, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);
            }
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Create SQLite tables for development
     */
    private function createSQLiteTables() {
        try {
            $sql = "
            CREATE TABLE IF NOT EXISTS users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                email VARCHAR(255) UNIQUE NOT NULL,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(20) NOT NULL,
                name VARCHAR(255) NOT NULL,
                phone VARCHAR(20),
                address TEXT,
                latitude DECIMAL(10, 8),
                longitude DECIMAL(11, 8),
                profile_image VARCHAR(255),
                is_active INTEGER DEFAULT 1,
                email_verified INTEGER DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            
            CREATE TABLE IF NOT EXISTS service_categories (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name VARCHAR(255) NOT NULL,
                description TEXT,
                icon VARCHAR(255),
                base_price DECIMAL(10, 2) DEFAULT 0,
                estimated_duration INTEGER DEFAULT 60,
                is_active INTEGER DEFAULT 1,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            ";
            
            $this->connection->exec($sql);
            
            // Insert sample data
            $adminPassword = password_hash('password', PASSWORD_DEFAULT);
            $insertSql = "
            INSERT OR IGNORE INTO users (id, email, password, role, name, phone, address, latitude, longitude) VALUES
            (1, 'admin@servibot.com', ?, 'superadmin', 'Administrador ServiBOT', '555-0100', 'Oficina Central', 19.4326, -99.1332);
            
            INSERT OR IGNORE INTO service_categories (id, name, description, icon, base_price, estimated_duration) VALUES
            (1, 'Plomería', 'Servicios de plomería y fontanería', 'fas fa-wrench', 300.00, 120),
            (2, 'Mecánica', 'Reparación de vehículos a domicilio', 'fas fa-car', 500.00, 180),
            (3, 'Medicina', 'Consultas médicas a domicilio', 'fas fa-user-md', 800.00, 60),
            (4, 'Programación', 'Desarrollo y soporte técnico', 'fas fa-code', 1000.00, 240);
            ";
            
            $stmt = $this->connection->prepare("INSERT OR IGNORE INTO users (id, email, password, role, name, phone, address, latitude, longitude) VALUES (1, 'admin@servibot.com', ?, 'superadmin', 'Administrador ServiBOT', '555-0100', 'Oficina Central', 19.4326, -99.1332)");
            $stmt->execute([$adminPassword]);
            
            $servicesSql = "INSERT OR IGNORE INTO service_categories (id, name, description, icon, base_price, estimated_duration) VALUES
                (1, 'Plomería', 'Servicios de plomería y fontanería', 'fas fa-wrench', 300.00, 120),
                (2, 'Mecánica', 'Reparación de vehículos a domicilio', 'fas fa-car', 500.00, 180),
                (3, 'Medicina', 'Consultas médicas a domicilio', 'fas fa-user-md', 800.00, 60),
                (4, 'Programación', 'Desarrollo y soporte técnico', 'fas fa-code', 1000.00, 240)";
            $this->connection->exec($servicesSql);
            
        } catch (PDOException $e) {
            error_log("Database creation error: " . $e->getMessage());
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->connection;
    }
    
    // Prevent cloning
    private function __clone() {}
    
    // Prevent unserialization
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}