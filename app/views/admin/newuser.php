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
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>admin/newuser">
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
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Crear Nuevo Usuario</h1>
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
                                <i class="fas fa-user-plus"></i> Información del Usuario
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo $baseUrl; ?>admin/newuser">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Nombre Completo *</label>
                                        <input type="text" class="form-control" id="name" name="name" required
                                               value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" class="form-control" id="email" name="email" required
                                               value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Teléfono</label>
                                        <input type="tel" class="form-control" id="phone" name="phone"
                                               value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="role" class="form-label">Tipo de Usuario *</label>
                                        <select class="form-select" id="role" name="role" required>
                                            <option value="">Selecciona...</option>
                                            <option value="cliente" <?php echo ($formData['role'] ?? '') === 'cliente' ? 'selected' : ''; ?>>
                                                Cliente
                                            </option>
                                            <option value="prestador" <?php echo ($formData['role'] ?? '') === 'prestador' ? 'selected' : ''; ?>>
                                                Prestador
                                            </option>
                                            <option value="superadmin" <?php echo ($formData['role'] ?? '') === 'superadmin' ? 'selected' : ''; ?>>
                                                Administrador
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Dirección</label>
                                    <textarea class="form-control" id="address" name="address" rows="2"
                                              placeholder="Dirección completa"><?php echo htmlspecialchars($formData['address'] ?? ''); ?></textarea>
                                </div>

                                <!-- City selection for providers -->
                                <div class="mb-3" id="citySection" style="display: none;">
                                    <label for="city" class="form-label">Ciudad de Operación</label>
                                    <select class="form-select" id="city" name="city">
                                        <option value="">Selecciona ciudad...</option>
                                        <?php foreach ($franchises as $franchise): ?>
                                            <option value="<?php echo htmlspecialchars($franchise['city']); ?>"
                                                    <?php echo ($formData['city'] ?? '') === $franchise['city'] ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($franchise['city']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Contraseña *</label>
                                        <input type="password" class="form-control" id="password" name="password" required
                                               minlength="6" placeholder="Mínimo 6 caracteres">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="active" class="form-label">Estado</label>
                                        <select class="form-select" id="active" name="active">
                                            <option value="1" <?php echo ($formData['active'] ?? '1') === '1' ? 'selected' : ''; ?>>
                                                Activo
                                            </option>
                                            <option value="0" <?php echo ($formData['active'] ?? '') === '0' ? 'selected' : ''; ?>>
                                                Inactivo
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="<?php echo $baseUrl; ?>admin/users" class="btn btn-secondary me-md-2">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Crear Usuario
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
                                <i class="fas fa-info-circle"></i> Información Importante
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-lightbulb"></i> Tipos de Usuario</h6>
                                <ul class="mb-0">
                                    <li><strong>Cliente:</strong> Puede solicitar servicios</li>
                                    <li><strong>Prestador:</strong> Puede ofrecer servicios</li>
                                    <li><strong>Administrador:</strong> Acceso completo al sistema</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle"></i> Prestadores</h6>
                                <p class="mb-0">Los prestadores requieren seleccionar una ciudad de operación para poder ser asignados a servicios.</p>
                            </div>

                            <div class="alert alert-success">
                                <h6><i class="fas fa-shield-alt"></i> Seguridad</h6>
                                <p class="mb-0">Las contraseñas se encriptan automáticamente por seguridad.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
// Show/hide city section based on role
document.getElementById('role').addEventListener('change', function() {
    const citySection = document.getElementById('citySection');
    const citySelect = document.getElementById('city');
    
    if (this.value === 'prestador') {
        citySection.style.display = 'block';
        citySelect.setAttribute('required', 'required');
    } else {
        citySection.style.display = 'none';
        citySelect.removeAttribute('required');
        citySelect.value = '';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    if (roleSelect.value) {
        roleSelect.dispatchEvent(new Event('change'));
    }
});
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>