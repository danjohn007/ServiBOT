<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>client/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Panel Principal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>client/requests">
                            <i class="fas fa-list"></i> Mis Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>client/profile">
                            <i class="fas fa-user"></i> Mi Perfil
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Mi Perfil de Cliente</h1>
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-edit"></i> Información Personal
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo $baseUrl; ?>client/profile">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

                                <!-- Basic Information -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Información Básica</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nombre Completo *</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="<?php echo htmlspecialchars($client['name'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" 
                                                   value="<?php echo htmlspecialchars($client['email'] ?? ''); ?>" 
                                                   readonly disabled>
                                            <small class="form-text text-muted">El email no se puede modificar</small>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" 
                                               value="<?php echo htmlspecialchars($client['phone'] ?? ''); ?>"
                                               placeholder="555-123-4567">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Dirección</label>
                                        <textarea class="form-control" id="address" name="address" rows="3"
                                                  placeholder="Tu dirección completa para recibir servicios"><?php echo htmlspecialchars($client['address'] ?? ''); ?></textarea>
                                        <small class="form-text text-muted">
                                            Esta dirección se usará como ubicación predeterminada para tus solicitudes de servicio.
                                        </small>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save"></i> Guardar Cambios
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Profile Stats -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-chart-bar"></i> Estadísticas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-12 mb-3">
                                    <div class="border-bottom pb-2">
                                        <h4 class="text-primary mb-0">0</h4>
                                        <small class="text-muted">Solicitudes Totales</small>
                                    </div>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="border-bottom pb-2">
                                        <h4 class="text-success mb-0">0</h4>
                                        <small class="text-muted">Servicios Completados</small>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h4 class="text-warning mb-0">0</h4>
                                    <small class="text-muted">Solicitudes Pendientes</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Información de Cuenta
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <strong>Tipo de cuenta:</strong> 
                                    <span class="badge bg-info">Cliente</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Estado:</strong> 
                                    <span class="badge bg-success">Activa</span>
                                </li>
                                <li class="mb-2">
                                    <strong>Miembro desde:</strong> 
                                    <?php 
                                    $createdAt = $client['created_at'] ?? '';
                                    if ($createdAt) {
                                        echo date('d/m/Y', strtotime($createdAt));
                                    } else {
                                        echo 'N/A';
                                    }
                                    ?>
                                </li>
                            </ul>

                            <div class="mt-3">
                                <h6 class="text-muted">Próximamente:</h6>
                                <ul class="list-unstyled small">
                                    <li><i class="fas fa-star text-warning"></i> Sistema de calificaciones</li>
                                    <li><i class="fas fa-heart text-danger"></i> Prestadores favoritos</li>
                                    <li><i class="fas fa-history text-info"></i> Historial detallado</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>