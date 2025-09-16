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
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/franchises">
                            <i class="fas fa-building"></i> Franquicias
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>admin/profile">
                            <i class="fas fa-user-edit"></i> Mi Perfil
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Mi Perfil de Administrador</h1>
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
                                <i class="fas fa-user-edit"></i> Información del Perfil
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo $baseUrl; ?>admin/profile">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

                                <!-- Basic Information -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Información Básica</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nombre Completo *</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="<?php echo htmlspecialchars($admin['name'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" 
                                                   value="<?php echo htmlspecialchars($admin['email'] ?? ''); ?>" readonly>
                                            <div class="form-text">El email no se puede modificar</div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Teléfono</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" 
                                                   value="<?php echo htmlspecialchars($admin['phone'] ?? ''); ?>">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="role" class="form-label">Rol</label>
                                            <input type="text" class="form-control" value="Administrador" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Dirección</label>
                                        <textarea class="form-control" id="address" name="address" rows="2" 
                                                  placeholder="Dirección de la oficina o domicilio"><?php echo htmlspecialchars($admin['address'] ?? ''); ?></textarea>
                                    </div>
                                </div>

                                <!-- Security Information -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Seguridad</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="new_password" class="form-label">Nueva Contraseña</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" 
                                                   placeholder="Dejar vacío para mantener actual">
                                            <div class="form-text">Mínimo 6 caracteres</div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                                   placeholder="Confirmar nueva contraseña">
                                        </div>
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
                                <i class="fas fa-chart-bar"></i> Información de Cuenta
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Último acceso</span>
                                <span class="badge bg-info">
                                    <?php echo date('d/m/Y H:i'); ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Cuenta creada</span>
                                <span class="badge bg-secondary">
                                    <?php echo date('d/m/Y', strtotime($admin['created_at'] ?? 'now')); ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Estado</span>
                                <span class="badge bg-success">
                                    Activo
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Admin Actions -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-cogs"></i> Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <a href="<?php echo $baseUrl; ?>admin/users" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-users"></i> Gestionar Usuarios
                                </a>
                                <a href="<?php echo $baseUrl; ?>admin/pending_providers" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-user-clock"></i> Prestadores Pendientes
                                </a>
                                <a href="<?php echo $baseUrl; ?>admin/services" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-cogs"></i> Gestionar Servicios
                                </a>
                                <a href="<?php echo $baseUrl; ?>admin/franchises" class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-building"></i> Gestionar Franquicias
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-lightbulb"></i> Consejos de Seguridad
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    Cambia tu contraseña regularmente
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    Usa una contraseña fuerte y única
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    No compartas tus credenciales
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-check text-success"></i>
                                    Cierra sesión al terminar
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Password confirmation validation
document.getElementById('new_password').addEventListener('input', function() {
    const confirmPassword = document.getElementById('confirm_password');
    if (this.value) {
        confirmPassword.required = true;
    } else {
        confirmPassword.required = false;
        confirmPassword.value = '';
    }
});

document.getElementById('confirm_password').addEventListener('input', function() {
    const newPassword = document.getElementById('new_password').value;
    if (this.value !== newPassword) {
        this.setCustomValidity('Las contraseñas no coinciden');
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>