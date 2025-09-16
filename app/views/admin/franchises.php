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
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/services">
                            <i class="fas fa-cogs"></i> Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/newservice">
                            <i class="fas fa-plus-circle"></i> Nuevo Servicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>admin/franchises">
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
                <h1 class="h2">Gestión de Franquicias</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newFranchiseModal">
                        <i class="fas fa-plus"></i> Nueva Franquicia
                    </button>
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

            <!-- Franchise Stats -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-building fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Total Franquicias</h5>
                                    <h3 class="mb-0"><?php echo isset($franchises) ? count($franchises) : 0; ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-check-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Activas</h5>
                                    <h3 class="mb-0">
                                        <?php 
                                        echo isset($franchises) ? count(array_filter($franchises, function($franchise) { 
                                            return $franchise['is_active']; 
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
                                    <h5 class="card-title">Inactivas</h5>
                                    <h3 class="mb-0">
                                        <?php 
                                        echo isset($franchises) ? count(array_filter($franchises, function($franchise) { 
                                            return !$franchise['is_active']; 
                                        })) : 0; 
                                        ?>
                                    </h3>
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
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Representantes</h5>
                                    <h3 class="mb-0">
                                        <?php 
                                        echo isset($representatives) ? count($representatives) : 0; 
                                        ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Franchises List -->
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list"></i> Lista de Franquicias
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($franchises)): ?>
                        <div class="row g-4">
                            <?php foreach ($franchises as $franchise): ?>
                                <div class="col-md-6 col-lg-4">
                                    <div class="card h-100 franchise-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="franchise-avatar">
                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                        <i class="fas fa-building fa-lg"></i>
                                                    </div>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-edit"></i> Editar</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-chart-bar"></i> Estadísticas</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="fas fa-users"></i> Ver Usuarios</a></li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <?php if ($franchise['is_active']): ?>
                                                            <li><a class="dropdown-item text-warning" href="#"><i class="fas fa-pause"></i> Desactivar</a></li>
                                                        <?php else: ?>
                                                            <li><a class="dropdown-item text-success" href="#"><i class="fas fa-play"></i> Activar</a></li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            <h5 class="card-title"><?php echo htmlspecialchars($franchise['name']); ?></h5>
                                            <p class="card-text text-muted small">
                                                <i class="fas fa-map-marker-alt"></i> 
                                                <?php echo htmlspecialchars($franchise['location']); ?>
                                            </p>
                                            
                                            <?php if (!empty($franchise['representative_name'])): ?>
                                                <div class="mb-2">
                                                    <small class="text-muted">Representante:</small><br>
                                                    <strong><?php echo htmlspecialchars($franchise['representative_name']); ?></strong>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="row text-center border-top pt-3">
                                                <div class="col-6">
                                                    <h6 class="text-primary mb-1">
                                                        <?php echo $franchise['coverage_radius'] ?? 'N/A'; ?>km
                                                    </h6>
                                                    <small class="text-muted">Cobertura</small>
                                                </div>
                                                <div class="col-6">
                                                    <h6 class="mb-1">
                                                        <span class="badge bg-<?php echo $franchise['is_active'] ? 'success' : 'secondary'; ?>">
                                                            <?php echo $franchise['is_active'] ? 'Activa' : 'Inactiva'; ?>
                                                        </span>
                                                    </h6>
                                                    <small class="text-muted">Estado</small>
                                                </div>
                                            </div>
                                            
                                            <?php if (isset($franchise['created_at'])): ?>
                                                <div class="mt-2 text-center">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar"></i> 
                                                        Creada: <?php echo date('d/m/Y', strtotime($franchise['created_at'])); ?>
                                                    </small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="fas fa-building fa-4x text-muted"></i>
                            </div>
                            <h5 class="text-muted">No hay franquicias registradas</h5>
                            <p class="text-muted">Comienza creando tu primera franquicia para expandir el negocio.</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newFranchiseModal">
                                <i class="fas fa-plus"></i> Crear Primera Franquicia
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- New Franchise Modal -->
<div class="modal fade" id="newFranchiseModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-building"></i> Nueva Franquicia
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo $baseUrl; ?>admin/franchises">
                <div class="modal-body">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="franchise_name" class="form-label">Nombre de la Franquicia *</label>
                            <input type="text" class="form-control" id="franchise_name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="franchise_location" class="form-label">Ubicación *</label>
                            <input type="text" class="form-control" id="franchise_location" name="location" required>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="coverage_radius" class="form-label">Radio de Cobertura (km)</label>
                            <select class="form-select" id="coverage_radius" name="coverage_radius">
                                <option value="10">10 km</option>
                                <option value="15">15 km</option>
                                <option value="20" selected>20 km</option>
                                <option value="30">30 km</option>
                                <option value="50">50 km</option>
                                <option value="100">100 km</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="representative_id" class="form-label">Representante</label>
                            <select class="form-select" id="representative_id" name="representative_id">
                                <option value="">Seleccionar representante (opcional)</option>
                                <?php if (!empty($representatives)): ?>
                                    <?php foreach ($representatives as $representative): ?>
                                        <option value="<?php echo $representative['id']; ?>">
                                            <?php echo htmlspecialchars($representative['name']); ?> 
                                            (<?php echo htmlspecialchars($representative['email']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="franchise_description" class="form-label">Descripción</label>
                        <textarea class="form-control" id="franchise_description" name="description" rows="3" 
                                  placeholder="Descripción opcional de la franquicia"></textarea>
                    </div>
                    
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">
                            Franquicia activa
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Crear Franquicia
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.franchise-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.franchise-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
</style>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>