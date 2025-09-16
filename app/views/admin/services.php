<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/users">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/pending_providers">
                            <i class="fas fa-user-clock"></i> Prestadores por Autorizar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/newuser">
                            <i class="fas fa-user-plus"></i> Nuevo Usuario
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>admin/services">
                            <i class="fas fa-cogs"></i> Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/newservice">
                            <i class="fas fa-plus-circle"></i> Nuevo Servicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/franchises">
                            <i class="fas fa-building"></i> Franquicias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/profile">
                            <i class="fas fa-user-edit"></i> Mi Perfil
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Gestión de Servicios</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo $baseUrl; ?>admin/newservice" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nuevo Servicio
                    </a>
                </div>
            </div>

            <?php if (isset($success)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Services Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-tools fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Total Servicios</h5>
                                    <h3 class="mb-0"><?php echo isset($services) ? count($services) : 0; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Activos</h5>
                                    <h3 class="mb-0">
                                        <?php 
                                        echo isset($services) ? count(array_filter($services, function($service) { 
                                            return $service['is_active']; 
                                        })) : 0; 
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-pause-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Inactivos</h5>
                                    <h3 class="mb-0">
                                        <?php 
                                        echo isset($services) ? count(array_filter($services, function($service) { 
                                            return !$service['is_active']; 
                                        })) : 0; 
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-dollar-sign fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Precio Promedio</h5>
                                    <h3 class="mb-0">
                                        $<?php 
                                        if (isset($services) && !empty($services)) {
                                            $avgPrice = array_sum(array_column($services, 'base_price')) / count($services);
                                            echo number_format($avgPrice, 0);
                                        } else {
                                            echo '0';
                                        }
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list"></i> Categorías de Servicios
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($services)): ?>
                        <div class="row g-4">
                            <?php foreach ($services as $service): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 service-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="service-icon">
                                                    <i class="<?php echo htmlspecialchars($service['icon']); ?> fa-2x text-primary"></i>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit"></i> Editar</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-chart-bar"></i> Estadísticas</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <?php if ($service['is_active']): ?>
                                                            <li><a class="dropdown-item text-warning" href="#"><i class="fas fa-pause"></i> Desactivar</a></li>
                                                        <?php else: ?>
                                                            <li><a class="dropdown-item text-success" href="#"><i class="fas fa-play"></i> Activar</a></li>
                                                        <?php endif; ?>
                                                        <li><a class="dropdown-item text-danger" href="#"><i class="fas fa-trash"></i> Eliminar</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <h5 class="card-title"><?php echo htmlspecialchars($service['name']); ?></h5>
                                            <p class="card-text text-muted small"><?php echo htmlspecialchars($service['description']); ?></p>
                                            
                                            <div class="row text-center border-top pt-3">
                                                <div class="col-6">
                                                    <h6 class="text-primary mb-1">$<?php echo number_format($service['base_price'], 2); ?></h6>
                                                    <small class="text-muted">Precio Base</small>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="mb-1">
                                                        <span class="badge bg-<?php echo $service['is_active'] ? 'success' : 'secondary'; ?>">
                                                            <?php echo $service['is_active'] ? 'Activo' : 'Inactivo'; ?>
                                                        </span>
                                                    </h6>
                                                    <small class="text-muted">Estado</small>
                                                </div>
                                            </div>
                                            
                                            <?php if (isset($service['estimated_duration'])): ?>
                                                <div class="mt-2 text-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-clock"></i> 
                                                        Duración estimada: <?php echo $service['estimated_duration']; ?> min
                                                    </small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="mt-4 text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-outline-success" onclick="toggleAllServices(true)">
                                    <i class="fas fa-play"></i> Activar Todos
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="toggleAllServices(false)">
                                    <i class="fas fa-pause"></i> Desactivar Todos
                                </button>
                                <a href="<?php echo $baseUrl; ?>admin/newservice" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Nuevo Servicio
                                </a>
                            </div>
                        </div>
                        
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-tools fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No hay servicios disponibles</h5>
                            <p class="text-muted">Comienza creando tu primera categoría de servicio.</p>
                            <a href="<?php echo $baseUrl; ?>admin/newservice" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Crear Primer Servicio
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
function toggleAllServices(activate) {
    // This would implement the functionality to activate/deactivate all services
    const action = activate ? 'activar' : 'desactivar';
    if (confirm(`¿Estás seguro de que quieres ${action} todos los servicios?`)) {
        // Implementation would go here
        console.log(`Toggle all services: ${activate}`);
    }
}
</script>

<style>
.service-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.service-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.service-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>