<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>provider/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Panel Principal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>provider/profile">
                            <i class="fas fa-user-edit"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>provider/requests">
                            <i class="fas fa-clipboard-list"></i> Mis Servicios
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Mi Perfil de Prestador</h1>
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
                            <form method="POST" action="<?php echo $baseUrl; ?>provider/profile">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">

                                <!-- Basic Information -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Información Básica</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="name" class="form-label">Nombre Completo *</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="<?php echo htmlspecialchars($provider['name'] ?? ''); ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="phone" class="form-label">Teléfono *</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" 
                                                   value="<?php echo htmlspecialchars($provider['phone'] ?? ''); ?>" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Dirección de Servicio</label>
                                        <textarea class="form-control" id="address" name="address" rows="2" 
                                                  placeholder="Área donde ofreces tus servicios"><?php echo htmlspecialchars($provider['address'] ?? ''); ?></textarea>
                                    </div>
                                </div>

                                <!-- Professional Information -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Información Profesional</h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="experience_years" class="form-label">Años de Experiencia</label>
                                            <select class="form-select" id="experience_years" name="experience_years">
                                                <option value="0" <?php echo ($provider['experience_years'] ?? 0) == 0 ? 'selected' : ''; ?>>Nuevo</option>
                                                <option value="1" <?php echo ($provider['experience_years'] ?? 0) == 1 ? 'selected' : ''; ?>>1 año</option>
                                                <option value="2" <?php echo ($provider['experience_years'] ?? 0) == 2 ? 'selected' : ''; ?>>2 años</option>
                                                <option value="3" <?php echo ($provider['experience_years'] ?? 0) == 3 ? 'selected' : ''; ?>>3 años</option>
                                                <option value="4" <?php echo ($provider['experience_years'] ?? 0) == 4 ? 'selected' : ''; ?>>4 años</option>
                                                <option value="5" <?php echo ($provider['experience_years'] ?? 0) == 5 ? 'selected' : ''; ?>>5 años</option>
                                                <option value="10" <?php echo ($provider['experience_years'] ?? 0) >= 10 ? 'selected' : ''; ?>>10+ años</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="coverage_radius" class="form-label">Radio de Cobertura (km)</label>
                                            <select class="form-select" id="coverage_radius" name="coverage_radius">
                                                <option value="5" <?php echo ($provider['coverage_radius'] ?? 10) == 5 ? 'selected' : ''; ?>>5 km</option>
                                                <option value="10" <?php echo ($provider['coverage_radius'] ?? 10) == 10 ? 'selected' : ''; ?>>10 km</option>
                                                <option value="15" <?php echo ($provider['coverage_radius'] ?? 10) == 15 ? 'selected' : ''; ?>>15 km</option>
                                                <option value="20" <?php echo ($provider['coverage_radius'] ?? 10) == 20 ? 'selected' : ''; ?>>20 km</option>
                                                <option value="30" <?php echo ($provider['coverage_radius'] ?? 10) == 30 ? 'selected' : ''; ?>>30 km</option>
                                                <option value="50" <?php echo ($provider['coverage_radius'] ?? 10) >= 50 ? 'selected' : ''; ?>>50+ km</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Service Categories -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Categorías de Servicios</h6>
                                    <div class="row">
                                        <?php 
                                        $selectedCategories = json_decode($provider['service_categories'] ?? '[]', true) ?: [];
                                        foreach ($categories as $category): 
                                        ?>
                                            <div class="col-md-6 col-lg-4 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           id="category_<?php echo $category['id']; ?>" 
                                                           name="service_categories[]" 
                                                           value="<?php echo $category['id']; ?>"
                                                           <?php echo in_array($category['id'], $selectedCategories) ? 'checked' : ''; ?>>
                                                    <label class="form-check-label" for="category_<?php echo $category['id']; ?>">
                                                        <i class="<?php echo htmlspecialchars($category['icon']); ?>"></i>
                                                        <?php echo htmlspecialchars($category['name']); ?>
                                                    </label>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>

                                <!-- Keywords -->
                                <div class="mb-4">
                                    <h6 class="text-muted border-bottom pb-2">Palabras Clave</h6>
                                    <div class="mb-3">
                                        <label for="keywords" class="form-label">
                                            Especialidades y Palabras Clave
                                            <small class="text-muted">(separa con comas)</small>
                                        </label>
                                        <textarea class="form-control" id="keywords" name="keywords" rows="3"
                                                  placeholder="Ejemplo: fontanería, instalación, reparación, emergencias, 24 horas, baños, cocinas, fugas"><?php echo htmlspecialchars($provider['keywords'] ?? ''); ?></textarea>
                                        <div class="form-text">
                                            <i class="fas fa-info-circle"></i>
                                            Estas palabras clave ayudarán a los clientes a encontrarte cuando busquen servicios específicos.
                                            Incluye servicios, especialidades, herramientas y términos relacionados con tu trabajo.
                                        </div>
                                    </div>
                                    
                                    <!-- Keywords suggestions -->
                                    <div class="mb-3">
                                        <small class="text-muted">Sugerencias comunes:</small>
                                        <div class="mt-2">
                                            <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1" onclick="addKeyword('emergencias')">emergencias</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1" onclick="addKeyword('24 horas')">24 horas</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1" onclick="addKeyword('instalación')">instalación</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1" onclick="addKeyword('reparación')">reparación</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1" onclick="addKeyword('mantenimiento')">mantenimiento</button>
                                            <button type="button" class="btn btn-outline-secondary btn-sm me-1 mb-1" onclick="addKeyword('domicilio')">domicilio</button>
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
                                <i class="fas fa-chart-bar"></i> Estadísticas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Calificación</span>
                                <span class="badge bg-warning">
                                    <?php echo number_format($provider['rating'] ?? 0, 1); ?> ⭐
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span>Servicios Completados</span>
                                <span class="badge bg-success">
                                    <?php echo $provider['total_services'] ?? 0; ?>
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span>Estado</span>
                                <span class="badge bg-<?php echo ($provider['is_available'] ?? 1) ? 'success' : 'secondary'; ?>">
                                    <?php echo ($provider['is_available'] ?? 1) ? 'Disponible' : 'No Disponible'; ?>
                                </span>
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
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    Completa toda tu información para aparecer mejor en búsquedas
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    Usa palabras clave específicas de tu servicio
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check text-success"></i>
                                    Mantén actualizada tu información de contacto
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
function addKeyword(keyword) {
    const keywordsField = document.getElementById('keywords');
    const currentKeywords = keywordsField.value.trim();
    
    if (currentKeywords && !currentKeywords.endsWith(',')) {
        keywordsField.value = currentKeywords + ', ' + keyword;
    } else {
        keywordsField.value = currentKeywords + keyword;
    }
}
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>