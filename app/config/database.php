<?php

/**
 * Database Configuration
 */

// Database credentials - modify these according to your environment
define('DB_HOST', 'localhost');
define('DB_NAME', 'fix360_servibot');
define('DB_USER', 'fix360_servibot');
define('DB_PASS', 'Danjohn007!');
define('DB_CHARSET', 'utf8mb4');

// Database connection class
class Database {
    private static $instance = null;
    private $connection;
    
    private function __construct() {
        try {
            // MySQL connection only
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $this->connection = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch(PDOException $e) {
            // For development/demo purposes, create a mock connection
            $this->createMockConnection();
        }
    }
    
    /**
     * Create mock connection for demonstration
     */
    private function createMockConnection() {
        // Create a simple SQLite connection for demo purposes
        $sqliteFile = dirname(dirname(dirname(__FILE__))) . '/database/demo.sqlite';
        try {
            $this->connection = new PDO("sqlite:" . $sqliteFile, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            
            if (!file_exists($sqliteFile)) {
                $this->createDemoTables();
            }
        } catch(PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Create demo tables for presentation purposes only
     */
    private function createDemoTables() {
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
        
        CREATE TABLE IF NOT EXISTS service_providers (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER NOT NULL,
            service_categories TEXT,
            keywords TEXT,
            experience_years INTEGER DEFAULT 0,
            rating DECIMAL(3, 2) DEFAULT 0.00,
            total_services INTEGER DEFAULT 0,
            availability_schedule TEXT,
            coverage_radius INTEGER DEFAULT 10,
            documents TEXT,
            is_verified INTEGER DEFAULT 0,
            is_available INTEGER DEFAULT 1,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
        ";
        
        $this->connection->exec($sql);
        
        // Insert demo data
        $adminPassword = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("INSERT OR IGNORE INTO users (id, email, password, role, name, phone, address, latitude, longitude) VALUES (1, 'admin@servibot.com', ?, 'superadmin', 'Administrador ServiBOT', '555-0100', 'Oficina Central', 19.4326, -99.1332)");
        $stmt->execute([$adminPassword]);
        
        // Sample provider users
        $providerPassword = password_hash('password', PASSWORD_DEFAULT);
        $stmt = $this->connection->prepare("INSERT OR IGNORE INTO users (id, email, password, role, name, phone, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([2, 'plomero@demo.com', $providerPassword, 'prestador', 'Juan Pérez - Plomero', '555-0201', 'CDMX Centro']);
        $stmt->execute([3, 'mecanico@demo.com', $providerPassword, 'prestador', 'Roberto Martínez - Mecánico', '555-0202', 'CDMX Norte']);
        
        $servicesSql = "INSERT OR IGNORE INTO service_categories (id, name, description, icon, base_price, estimated_duration) VALUES
            (1, 'Plomería', 'Servicios de plomería y fontanería', 'fas fa-wrench', 300.00, 120),
            (2, 'Mecánica', 'Reparación de vehículos a domicilio', 'fas fa-car', 500.00, 180),
            (3, 'Medicina', 'Consultas médicas a domicilio', 'fas fa-user-md', 800.00, 60),
            (4, 'Programación', 'Desarrollo y soporte técnico', 'fas fa-code', 1000.00, 240),
            (5, 'Limpieza', 'Servicios de limpieza doméstica', 'fas fa-broom', 200.00, 120),
            (6, 'Jardinería', 'Mantenimiento de jardines', 'fas fa-seedling', 250.00, 150)";
        $this->connection->exec($servicesSql);
        
        // Sample providers with keywords
        $providersSql = "INSERT OR IGNORE INTO service_providers (user_id, service_categories, keywords, experience_years, rating, total_services) VALUES
            (2, '[1]', 'plomería, fontanería, fugas, instalación, reparación, tubería, baños, cocinas, emergencias, 24 horas', 5, 4.5, 120),
            (3, '[2]', 'mecánica, automotriz, frenos, motor, transmisión, llantas, batería, emergencias, domicilio', 8, 4.8, 200)";
        $this->connection->exec($providersSql);
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
