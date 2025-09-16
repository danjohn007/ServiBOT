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
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>admin/newservice">
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
                <h1 class="h2">Crear Nueva Categoría de Servicio</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="<?php echo $baseUrl; ?>admin/services" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Servicios
                        </a>
                    </div>
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
                                <i class="fas fa-plus-circle"></i> Información del Servicio
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo $baseUrl; ?>admin/newservice">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

                                <!-- Basic Information -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Información Básica</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nombre del Servicio *</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   placeholder="Ej. Plomería, Mecánica, Medicina" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="icon" class="form-label">Icono *</label>
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <i id="icon-preview" class="fas fa-tools"></i>
                                                </span>
                                                <input type="text" class="form-control" id="icon" name="icon" 
                                                       value="fas fa-tools" placeholder="Clase de FontAwesome" required>
                                            </div>
                                            <div class="form-text">
                                                Visita <a href="https://fontawesome.com/icons" target="_blank">FontAwesome</a> para ver iconos disponibles
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" 
                                                  placeholder="Describe el tipo de servicios que incluye esta categoría"></textarea>
                                    </div>
                                </div>

                                <!-- Pricing Information -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Información de Precios</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="base_price" class="form-label">Precio Base (MXN)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">$</span>
                                                <input type="number" class="form-control" id="base_price" name="base_price" 
                                                       min="0" step="0.01" placeholder="0.00">
                                            </div>
                                            <div class="form-text">
                                                Precio de referencia para esta categoría de servicio
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="estimated_duration" class="form-label">Duración Estimada (minutos)</label>
                                            <input type="number" class="form-control" id="estimated_duration" name="estimated_duration" 
                                                   min="15" step="15" value="60" placeholder="60">
                                            <div class="form-text">
                                                Tiempo promedio estimado para completar el servicio
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Estado</h6>
                                    
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                        <label class="form-check-label" for="is_active">
                                            Servicio activo
                                        </label>
                                        <div class="form-text">
                                            Si está desactivado, los usuarios no podrán solicitar este tipo de servicio
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="<?php echo $baseUrl; ?>admin/services" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Crear Servicio
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Icon Preview -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-eye"></i> Vista Previa del Icono
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="service-icon-preview mb-3">
                                <i id="large-icon-preview" class="fas fa-tools fa-4x text-primary"></i>
                            </div>
                            <p class="text-muted">
                                Así se verá el icono en la aplicación
                            </p>
                        </div>
                    </div>

                    <!-- Common Icons -->
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-icons"></i> Iconos Comunes
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-4 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="selectIcon('fas fa-wrench')">
                                        <i class="fas fa-wrench"></i><br><small>Plomería</small>
                                    </button>
                                </div>
                                <div class="col-4 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="selectIcon('fas fa-car')">
                                        <i class="fas fa-car"></i><br><small>Mecánica</small>
                                    </button>
                                </div>
                                <div class="col-4 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="selectIcon('fas fa-user-md')">
                                        <i class="fas fa-user-md"></i><br><small>Medicina</small>
                                    </button>
                                </div>
                                <div class="col-4 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="selectIcon('fas fa-code')">
                                        <i class="fas fa-code"></i><br><small>Programación</small>
                                    </button>
                                </div>
                                <div class="col-4 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="selectIcon('fas fa-broom')">
                                        <i class="fas fa-broom"></i><br><small>Limpieza</small>
                                    </button>
                                </div>
                                <div class="col-4 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="selectIcon('fas fa-seedling')">
                                        <i class="fas fa-seedling"></i><br><small>Jardinería</small>
                                    </button>
                                </div>
                                <div class="col-4 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="selectIcon('fas fa-paint-brush')">
                                        <i class="fas fa-paint-brush"></i><br><small>Pintura</small>
                                    </button>
                                </div>
                                <div class="col-4 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="selectIcon('fas fa-hammer')">
                                        <i class="fas fa-hammer"></i><br><small>Carpintería</small>
                                    </button>
                                </div>
                                <div class="col-4 text-center">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="selectIcon('fas fa-bolt')">
                                        <i class="fas fa-bolt"></i><br><small>Electricidad</small>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tips -->
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">
                                <i class="fas fa-lightbulb"></i> Consejos
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    Usa nombres descriptivos y claros
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    Establece precios competitivos
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    Elige iconos representativos
                                </li>
                                <li class="mb-0">
                                    <i class="fas fa-check text-success"></i>
                                    Proporciona descripciones útiles
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
function selectIcon(iconClass) {
    document.getElementById('icon').value = iconClass;
    updateIconPreview();
}

function updateIconPreview() {
    const iconInput = document.getElementById('icon');
    const iconClass = iconInput.value || 'fas fa-tools';
    
    // Update small preview
    const smallPreview = document.getElementById('icon-preview');
    smallPreview.className = iconClass;
    
    // Update large preview
    const largePreview = document.getElementById('large-icon-preview');
    largePreview.className = iconClass + ' fa-4x text-primary';
}

// Update icon preview when typing
document.getElementById('icon').addEventListener('input', updateIconPreview);

// Initialize icon preview
updateIconPreview();
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>