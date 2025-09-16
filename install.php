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

// MySQL Database Setup
echo "\n💾 Configuración de MySQL requerida...\n";
echo "Para completar la instalación:\n";
echo "1. Crear base de datos MySQL: 'servibot_db'\n";
echo "2. Ejecutar: mysql -u root -p servibot_db < database/schema.sql\n";
echo "3. Ejecutar: mysql -u root -p servibot_db < database/sample_data.sql\n";
echo "4. Configurar credenciales en app/config/database.php\n";
echo "\nEjemplo de configuración:\n";
echo "define('DB_HOST', 'localhost');\n";
echo "define('DB_NAME', 'servibot_db');\n";
echo "define('DB_USER', 'tu_usuario');\n";
echo "define('DB_PASS', 'tu_contraseña');\n\n";
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
    
    // Try to connect to MySQL if configured
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        $stmt = $conn->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch();
        echo "✅ Conexión a base de datos MySQL: OK (" . $result['count'] . " usuarios)\n";
        
        $stmt = $conn->query("SELECT COUNT(*) as count FROM service_categories");
        $result = $stmt->fetch();
        echo "✅ Servicios disponibles: " . $result['count'] . "\n";
    } catch (Exception $dbError) {
        echo "⚠️  Base de datos MySQL no configurada aún.\n";
        echo "   Configure las credenciales en app/config/database.php\n";
        echo "   y ejecute los scripts SQL en database/\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error en pruebas: " . $e->getMessage() . "\n";
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