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
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>admin/users">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/pending_providers">
                            <i class="fas fa-user-clock"></i> Prestadores por Autorizar
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/services">
                            <i class="fas fa-cogs"></i> Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>admin/franchises">
                            <i class="fas fa-building"></i> Franquicias
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Editar Usuario: <?php echo htmlspecialchars($user['name']); ?></h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo $baseUrl; ?>admin/users" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Volver a Usuarios
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

            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-edit"></i> Información del Usuario
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo $baseUrl; ?>admin/users/edit/<?php echo $user['id']; ?>">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nombre Completo *</label>
                                        <input type="text" class="form-control" id="name" name="name" required
                                               value="<?php echo htmlspecialchars($user['name']); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" required
                                               value="<?php echo htmlspecialchars($user['email']); ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                               value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="role" class="form-label">Tipo de Usuario *</label>
                                        <select class="form-select" id="role" name="role" required>
                                            <option value="">Selecciona...</option>
                                            <option value="cliente" <?php echo $user['role'] === 'cliente' ? 'selected' : ''; ?>>
                                                Cliente
                                            </option>
                                            <option value="prestador" <?php echo $user['role'] === 'prestador' ? 'selected' : ''; ?>>
                                                Prestador
                                            </option>
                                            <option value="franquicitario" <?php echo $user['role'] === 'franquicitario' ? 'selected' : ''; ?>>
                                                Franquicitario
                                            </option>
                                            <option value="superadmin" <?php echo $user['role'] === 'superadmin' ? 'selected' : ''; ?>>
                                                Administrador
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Dirección</label>
                                    <textarea class="form-control" id="address" name="address" rows="2"
                                              placeholder="Dirección completa"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Nueva Contraseña</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                               minlength="6" placeholder="Dejar vacío para mantener la actual">
                                        <small class="form-text text-muted">Solo completar si desea cambiar la contraseña</small>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="active" class="form-label">Estado</label>
                                        <select class="form-select" id="active" name="active">
                                            <option value="1" <?php echo $user['is_active'] ? 'selected' : ''; ?>>Activo</option>
                                            <option value="0" <?php echo !$user['is_active'] ? 'selected' : ''; ?>>Inactivo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="<?php echo $baseUrl; ?>admin/users" class="btn btn-secondary me-md-2">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Actualizar Usuario
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-info-circle"></i> Información del Usuario
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <small class="text-muted">ID del Usuario</small>
                                <div class="fw-bold"><?php echo $user['id']; ?></div>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted">Fecha de Registro</small>
                                <div class="fw-bold">
                                    <?php echo $user['created_at'] ? date('d/m/Y H:i', strtotime($user['created_at'])) : 'N/A'; ?>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted">Última Actualización</small>
                                <div class="fw-bold">
                                    <?php echo $user['updated_at'] ? date('d/m/Y H:i', strtotime($user['updated_at'])) : 'N/A'; ?>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted">Email Verificado</small>
                                <div>
                                    <span class="badge bg-<?php echo $user['email_verified'] ? 'success' : 'warning'; ?>">
                                        <?php echo $user['email_verified'] ? 'Verificado' : 'Pendiente'; ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.getElementById('role').addEventListener('change', function() {
    const citySection = document.getElementById('citySection');
    if (this.value === 'prestador') {
        citySection.style.display = 'block';
    } else {
        citySection.style.display = 'none';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    if (roleSelect.value === 'prestador') {
        document.getElementById('citySection').style.display = 'block';
    }
});
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>