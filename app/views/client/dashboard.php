<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4">
                <i class="fas fa-tachometer-alt text-primary"></i>
                Mi Panel de Cliente
            </h1>
            <p class="text-muted">Bienvenido, <?php echo htmlspecialchars($currentUser['name']); ?>. Aquí puedes gestionar tus solicitudes de servicio.</p>
        </div>
    </div>
    
    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card dashboard-card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-plus-circle fa-3x text-primary mb-3"></i>
                    <h5>Solicitar Servicio</h5>
                    <p class="card-text text-muted">Encuentra el especialista que necesitas</p>
                    <a href="<?php echo $baseUrl; ?>services/request" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Nueva Solicitud
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card dashboard-card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-list fa-3x text-success mb-3"></i>
                    <h5>Mis Solicitudes</h5>
                    <p class="card-text text-muted">Revisa el estado de tus servicios</p>
                    <a href="<?php echo $baseUrl; ?>client/requests" class="btn btn-success">
                        <i class="fas fa-list"></i> Ver Solicitudes
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card dashboard-card h-100 text-center">
                <div class="card-body">
                    <i class="fas fa-user-edit fa-3x text-info mb-3"></i>
                    <h5>Mi Perfil</h5>
                    <p class="card-text text-muted">Actualiza tu información personal</p>
                    <a href="<?php echo $baseUrl; ?>client/profile" class="btn btn-info">
                        <i class="fas fa-edit"></i> Editar Perfil
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="row">
        <div class="col-md-8">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-clock"></i>
                        Actividad Reciente
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center py-4">
                        <i class="fas fa-info-circle fa-2x text-muted mb-3"></i>
                        <p class="text-muted">No hay actividad reciente.</p>
                        <a href="<?php echo $baseUrl; ?>services/request" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Solicitar tu primer servicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card dashboard-card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-star"></i>
                        Servicios Populares
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-wrench text-primary me-3"></i>
                        <div>
                            <h6 class="mb-0">Plomería</h6>
                            <small class="text-muted">Desde $300</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-car text-success me-3"></i>
                        <div>
                            <h6 class="mb-0">Mecánica</h6>
                            <small class="text-muted">Desde $500</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-user-md text-info me-3"></i>
                        <div>
                            <h6 class="mb-0">Medicina</h6>
                            <small class="text-muted">Desde $800</small>
                        </div>
                    </div>
                    <a href="<?php echo $baseUrl; ?>services" class="btn btn-outline-primary btn-sm w-100">
                        Ver todos los servicios
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>