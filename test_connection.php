<?php
/**
 * ServiBOT Connection Test
 * This file tests database connection and base URL configuration
 */

require_once 'app/config/config.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ServiBOT - Test de Conexión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .test-card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .status-success { color: #28a745; }
        .status-error { color: #dc3545; }
        .status-warning { color: #ffc107; }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-center mb-4">
                    <h1 class="display-4">
                        <i class="fas fa-robot text-primary"></i>
                        ServiBOT
                    </h1>
                    <p class="lead">Test de Configuración del Sistema</p>
                </div>

                <!-- Base URL Test -->
                <div class="card test-card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5><i class="fas fa-link"></i> Configuración de URL Base</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>URL Base Detectada:</strong><br>
                                <code><?php echo BASE_URL; ?></code>
                            </div>
                            <div class="col-md-6">
                                <strong>Estado:</strong>
                                <span class="status-success">
                                    <i class="fas fa-check-circle"></i> Configurado correctamente
                                </span>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Rutas del Sistema:</strong>
                            </div>
                            <div class="col-md-8">
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-folder"></i> App: <code><?php echo APP_PATH; ?></code></li>
                                    <li><i class="fas fa-folder"></i> Vistas: <code><?php echo VIEWS_PATH; ?></code></li>
                                    <li><i class="fas fa-folder"></i> Assets: <code><?php echo ASSETS_PATH; ?></code></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Database Connection Test -->
                <div class="card test-card mb-4">
                    <div class="card-header bg-info text-white">
                        <h5><i class="fas fa-database"></i> Conexión a Base de Datos</h5>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            $db = Database::getInstance();
                            $connection = $db->getConnection();
                            
                            // Test connection
                            $stmt = $connection->query("SELECT 1");
                            $result = $stmt->fetch();
                            
                            echo '<div class="alert alert-success" role="alert">
                                    <i class="fas fa-check-circle"></i>
                                    <strong>¡Conexión exitosa!</strong> La base de datos está funcionando correctamente.
                                  </div>';
                            
                            // Show database info
                            $stmt = $connection->query("SELECT VERSION() as version");
                            $version = $stmt->fetch();
                            
                            echo '<div class="row">
                                    <div class="col-md-6">
                                        <strong>Servidor:</strong> ' . DB_HOST . '<br>
                                        <strong>Base de Datos:</strong> ' . DB_NAME . '<br>
                                        <strong>Usuario:</strong> ' . DB_USER . '
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Versión MySQL:</strong> ' . $version['version'] . '<br>
                                        <strong>Charset:</strong> ' . DB_CHARSET . '
                                    </div>
                                  </div>';
                            
                            // Check if tables exist
                            echo '<hr><h6>Estado de las Tablas:</h6>';
                            $tables = ['users', 'service_categories', 'service_providers', 'service_requests'];
                            echo '<div class="row">';
                            
                            foreach ($tables as $table) {
                                try {
                                    $stmt = $connection->query("SELECT COUNT(*) as count FROM $table");
                                    $count = $stmt->fetch();
                                    echo '<div class="col-md-3 mb-2">
                                            <span class="status-success">
                                                <i class="fas fa-check"></i> ' . $table . ' (' . $count['count'] . ')
                                            </span>
                                          </div>';
                                } catch (PDOException $e) {
                                    echo '<div class="col-md-3 mb-2">
                                            <span class="status-error">
                                                <i class="fas fa-times"></i> ' . $table . ' (No existe)
                                            </span>
                                          </div>';
                                }
                            }
                            echo '</div>';
                            
                        } catch (PDOException $e) {
                            echo '<div class="alert alert-danger" role="alert">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Error de conexión:</strong> ' . $e->getMessage() . '
                                  </div>';
                            
                            echo '<div class="alert alert-info" role="alert">
                                    <strong>Para configurar la base de datos:</strong><br>
                                    1. Crear la base de datos: <code>' . DB_NAME . '</code><br>
                                    2. Ejecutar el archivo: <code>database/schema.sql</code><br>
                                    3. Ejecutar el archivo: <code>database/sample_data.sql</code>
                                  </div>';
                        }
                        ?>
                    </div>
                </div>

                <!-- System Info -->
                <div class="card test-card mb-4">
                    <div class="card-header bg-success text-white">
                        <h5><i class="fas fa-info-circle"></i> Información del Sistema</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Versión PHP:</strong> <?php echo PHP_VERSION; ?><br>
                                <strong>Servidor Web:</strong> <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'Desconocido'; ?><br>
                                <strong>Sistema Operativo:</strong> <?php echo PHP_OS; ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Zona Horaria:</strong> <?php echo date_default_timezone_get(); ?><br>
                                <strong>Fecha/Hora:</strong> <?php echo date('Y-m-d H:i:s'); ?><br>
                                <strong>Versión App:</strong> <?php echo APP_VERSION; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="text-center">
                    <a href="<?php echo BASE_URL; ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-home"></i> Ir al Sistema
                    </a>
                    <a href="<?php echo BASE_URL; ?>install" class="btn btn-secondary btn-lg">
                        <i class="fas fa-download"></i> Instalación
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>