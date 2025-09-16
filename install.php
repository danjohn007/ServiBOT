<?php
/**
 * ServiBOT Installation Script
 * Automated setup for ServiBOT platform
 */

// Check if already installed
if (file_exists('database/servibot.sqlite') && filesize('database/servibot.sqlite') > 0) {
    echo "⚠️  ServiBOT ya está instalado. Si necesitas reinstalar, elimina database/servibot.sqlite primero.\n";
    echo "   Para continuar: rm database/servibot.sqlite && php install.php\n";
    exit(1);
}

echo "🤖 ServiBOT - Instalador Automático\n";
echo "=====================================\n\n";

// Check PHP requirements
echo "✅ Verificando requisitos...\n";

$requirements = [
    'php_version' => version_compare(PHP_VERSION, '7.4.0', '>='),
    'pdo' => extension_loaded('pdo'),
    'pdo_sqlite' => extension_loaded('pdo_sqlite'),
    'mbstring' => extension_loaded('mbstring'),
    'json' => extension_loaded('json')
];

$errors = [];
foreach ($requirements as $req => $status) {
    if (!$status) {
        $errors[] = $req;
        echo "❌ {$req} - FALTA\n";
    } else {
        echo "✅ {$req} - OK\n";
    }
}

if (!empty($errors)) {
    echo "\n❌ Error: Faltan requisitos necesarios:\n";
    foreach ($errors as $error) {
        echo "   - {$error}\n";
    }
    exit(1);
}

echo "\n✅ Todos los requisitos están disponibles.\n\n";

// Check directories and permissions
echo "📁 Verificando directorios...\n";

$directories = [
    'database' => 'database/',
    'storage' => 'storage/',
    'public' => 'public/'
];

foreach ($directories as $name => $path) {
    if (!is_dir($path)) {
        mkdir($path, 0755, true);
        echo "✅ Creado directorio: {$path}\n";
    } else {
        echo "✅ Directorio existe: {$path}\n";
    }
    
    if (!is_writable($path)) {
        echo "⚠️  Advertencia: {$path} no es escribible. Ejecutar: chmod 755 {$path}\n";
    }
}

// Create SQLite database
echo "\n💾 Configurando base de datos SQLite...\n";

try {
    $pdo = new PDO('sqlite:database/servibot.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create tables
    $sql = "
    CREATE TABLE users (
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
    
    CREATE TABLE service_categories (
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
    
    $pdo->exec($sql);
    echo "✅ Tablas creadas exitosamente.\n";
    
    // Create admin user
    $adminPassword = password_hash('password', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT INTO users (email, password, role, name, phone, address, latitude, longitude) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    $stmt->execute([
        'admin@servibot.com',
        $adminPassword,
        'superadmin',
        'Administrador ServiBOT',
        '555-0100',
        'Oficina Central',
        19.4326,
        -99.1332
    ]);
    
    echo "✅ Usuario administrador creado.\n";
    echo "   Email: admin@servibot.com\n";
    echo "   Contraseña: password\n\n";
    
    // Create sample services
    $services = [
        ['Plomería', 'Servicios de plomería y fontanería', 'fas fa-wrench', 300.00, 120],
        ['Mecánica', 'Reparación de vehículos a domicilio', 'fas fa-car', 500.00, 180],
        ['Medicina', 'Consultas médicas a domicilio', 'fas fa-user-md', 800.00, 60],
        ['Programación', 'Desarrollo y soporte técnico', 'fas fa-code', 1000.00, 240],
        ['Limpieza', 'Servicios de limpieza doméstica', 'fas fa-broom', 200.00, 120],
        ['Entrenamiento', 'Entrenador personal a domicilio', 'fas fa-dumbbell', 400.00, 90],
        ['Enfermería', 'Cuidados de enfermería', 'fas fa-heartbeat', 600.00, 60],
        ['Fletes', 'Servicio de mudanzas y transporte', 'fas fa-truck', 350.00, 180]
    ];
    
    $stmt = $pdo->prepare("
        INSERT INTO service_categories (name, description, icon, base_price, estimated_duration) 
        VALUES (?, ?, ?, ?, ?)
    ");
    
    foreach ($services as $service) {
        $stmt->execute($service);
    }
    
    echo "✅ Servicios de ejemplo creados (" . count($services) . " servicios).\n";
    
} catch (PDOException $e) {
    echo "❌ Error configurando base de datos: " . $e->getMessage() . "\n";
    exit(1);
}

// Check web server configuration
echo "\n🌐 Verificando configuración del servidor...\n";

if (file_exists('.htaccess')) {
    echo "✅ .htaccess principal encontrado.\n";
} else {
    echo "⚠️  .htaccess principal no encontrado.\n";
}

if (file_exists('public/.htaccess')) {
    echo "✅ .htaccess público encontrado.\n";
} else {
    echo "⚠️  public/.htaccess no encontrado.\n";
}

// Test configuration
echo "\n🧪 Probando configuración...\n";

try {
    require_once 'app/config/config.php';
    echo "✅ Configuración cargada correctamente.\n";
    echo "   Base URL detectada: " . BASE_URL . "\n";
    
    $db = Database::getInstance();
    $conn = $db->getConnection();
    
    $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
    $result = $stmt->fetch();
    echo "✅ Conexión a base de datos: OK (" . $result['count'] . " usuarios)\n";
    
    $stmt = $conn->query("SELECT COUNT(*) as count FROM service_categories");
    $result = $stmt->fetch();
    echo "✅ Servicios disponibles: " . $result['count'] . "\n";
    
} catch (Exception $e) {
    echo "❌ Error en pruebas: " . $e->getMessage() . "\n";
    exit(1);
}

// Final instructions
echo "\n🎉 ¡Instalación completada exitosamente!\n";
echo "=========================================\n\n";

echo "📋 Próximos pasos:\n";
echo "1. Inicia el servidor de desarrollo:\n";
echo "   cd public && php -S localhost:8000\n\n";

echo "2. O configura Apache/Nginx para apuntar al directorio del proyecto\n\n";

echo "3. Accede a la aplicación:\n";
echo "   - Página principal: http://localhost:8000/\n";
echo "   - Panel admin: http://localhost:8000/admin\n";
echo "   - Prueba configuración: http://localhost:8000/../test_connection.php\n\n";

echo "4. Credenciales de administrador:\n";
echo "   - Email: admin@servibot.com\n";
echo "   - Contraseña: password\n\n";

echo "⚠️  Importante:\n";
echo "   - Cambia la contraseña del administrador después del primer login\n";
echo "   - Para producción, configura MySQL en app/config/database.php\n";
echo "   - Asegúrate de que mod_rewrite esté habilitado en Apache\n\n";

echo "📚 Documentación completa en README.md\n";
echo "🐛 Reportar problemas: GitHub Issues\n\n";

echo "¡ServiBOT está listo para usar! 🚀\n";
?>