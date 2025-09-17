<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">
                <i class="fas fa-tachometer-alt text-primary"></i>
                Panel de Administración
            </h1>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card dashboard-card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-primary text-white me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Total Usuarios</h5>
                            <h3 class="mb-0 text-primary">
                                <?php echo array_sum($userStats); ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card dashboard-card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-success text-white me-3">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Clientes</h5>
                            <h3 class="mb-0 text-success">
                                <?php echo $userStats['cliente'] ?? 0; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card dashboard-card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-info text-white me-3">
                            <i class="fas fa-tools"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Prestadores</h5>
                            <h3 class="mb-0 text-info">
                                <?php echo $userStats['prestador'] ?? 0; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card dashboard-card stats-card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon bg-warning text-white me-3">
                            <i class="fas fa-cog"></i>
                        </div>
                        <div>
                            <h5 class="card-title mb-1">Administradores</h5>
                            <h3 class="mb-0 text-warning">
                                <?php echo $userStats['superadmin'] ?? 0; ?>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Management Cards -->
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i>
                        Gestión de Usuarios
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Administra usuarios, roles y permisos del sistema.</p>
                    <div class="d-flex gap-2">
                        <a href="<?php echo $baseUrl; ?>admin/users" class="btn btn-primary">
                            <i class="fas fa-list"></i> Ver Usuarios
                        </a>
                        <a href="<?php echo $baseUrl; ?>admin/pending_providers" class="btn btn-warning">
                            <i class="fas fa-user-clock"></i> Prestadores por Autorizar
                        </a>
                        <a href="<?php echo $baseUrl; ?>admin/users/create" class="btn btn-outline-primary">
                            <i class="fas fa-plus"></i> Nuevo Usuario
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-tools"></i>
                        Gestión de Servicios
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Configura tipos de servicios, precios y características.</p>
                    <div class="d-flex gap-2">
                        <a href="<?php echo $baseUrl; ?>admin/services" class="btn btn-success">
                            <i class="fas fa-list"></i> Ver Servicios
                        </a>
                        <a href="<?php echo $baseUrl; ?>admin/services/create" class="btn btn-outline-success">
                            <i class="fas fa-plus"></i> Nuevo Servicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-bar"></i>
                        Reportes y Analytics
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Visualiza estadísticas y reportes del sistema.</p>
                    <div class="d-flex gap-2">
                        <a href="<?php echo $baseUrl; ?>admin/reports" class="btn btn-info">
                            <i class="fas fa-chart-line"></i> Ver Reportes
                        </a>
                        <a href="<?php echo $baseUrl; ?>admin/analytics" class="btn btn-outline-info">
                            <i class="fas fa-analytics"></i> Analytics
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card dashboard-card h-100">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-cogs"></i>
                        Configuración
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Configura parámetros del sistema y franquicias.</p>
                    <div class="d-flex gap-2">
                        <a href="<?php echo $baseUrl; ?>admin/settings" class="btn btn-warning text-dark">
                            <i class="fas fa-cog"></i> Configuración
                        </a>
                        <a href="<?php echo $baseUrl; ?>admin/franchises" class="btn btn-outline-warning">
                            <i class="fas fa-building"></i> Franquicias
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Financial Module Section -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card dashboard-card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line"></i>
                        Módulo Financiero
                    </h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Accede al módulo financiero para gestionar transacciones, reportes y análisis financieros.</p>
                    <div class="d-flex gap-2">
                        <a href="<?php echo $baseUrl; ?>financial" class="btn btn-success">
                            <i class="fas fa-chart-bar"></i> Dashboard Financiero
                        </a>
                        <a href="<?php echo $baseUrl; ?>financial/transactions" class="btn btn-outline-success">
                            <i class="fas fa-list"></i> Ver Transacciones
                        </a>
                        <a href="<?php echo $baseUrl; ?>financial/reports" class="btn btn-outline-success">
                            <i class="fas fa-file-chart-line"></i> Reportes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>