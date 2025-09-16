<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<!-- Search Results Header -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo $baseUrl; ?>">Inicio</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Resultados de Búsqueda</li>
                    </ol>
                </nav>
                
                <!-- Search Form -->
                <div class="row mb-4">
                    <div class="col-12">
                        <form action="<?php echo $baseUrl; ?>search" method="GET" class="d-flex gap-2">
                            <div class="flex-grow-1">
                                <input type="text" name="q" class="form-control form-control-lg" 
                                       placeholder="¿Qué servicio necesitas a domicilio?" 
                                       value="<?php echo htmlspecialchars($query); ?>">
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </form>
                    </div>
                </div>
                
                <?php if (!empty($query)): ?>
                    <h1 class="h3 mb-0">
                        Resultados para: "<strong><?php echo htmlspecialchars($query); ?></strong>"
                    </h1>
                    <p class="text-muted">
                        <?php 
                        $totalResults = count($results) + count($categories) + count($providers);
                        echo $totalResults; 
                        ?> resultado<?php echo $totalResults != 1 ? 's' : ''; ?> encontrado<?php echo $totalResults != 1 ? 's' : ''; ?>
                    </p>
                <?php else: ?>
                    <h1 class="h3 mb-0">Buscar Servicios</h1>
                    <p class="text-muted">Encuentra el especialista perfecto para tus necesidades</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- Search Results -->
<section class="py-5">
    <div class="container">
        <?php if (!empty($query)): ?>
            
            <!-- Service Categories Results -->
            <?php if (!empty($categories)): ?>
                <div class="mb-5">
                    <h3 class="h4 mb-4">
                        <i class="fas fa-list-ul text-primary"></i> Categorías de Servicios
                    </h3>
                    <div class="row g-4">
                        <?php foreach ($categories as $category): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0 service-card">
                                    <div class="card-body text-center p-4">
                                        <div class="service-icon mb-3">
                                            <i class="<?php echo htmlspecialchars($category['icon'] ?? 'fas fa-tools'); ?> fa-3x text-primary"></i>
                                        </div>
                                        <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                                        <p class="card-text text-muted"><?php echo htmlspecialchars($category['description']); ?></p>
                                        <div class="price mb-3">
                                            <span class="h5 text-primary">$<?php echo number_format($category['base_price'], 2); ?></span>
                                            <small class="text-muted">desde</small>
                                        </div>
                                        <a href="<?php echo $baseUrl; ?>services/<?php echo $category['id']; ?>" class="btn btn-outline-primary">
                                            Ver Detalles
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- Providers Results -->
            <?php if (!empty($providers)): ?>
                <div class="mb-5">
                    <h3 class="h4 mb-4">
                        <i class="fas fa-users text-primary"></i> Especialistas Encontrados
                    </h3>
                    <div class="row g-4">
                        <?php foreach ($providers as $provider): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm border-0">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                            <div>
                                                <h6 class="card-title mb-0"><?php echo htmlspecialchars($provider['name']); ?></h6>
                                                <div class="text-muted">
                                                    <?php if ($provider['rating'] > 0): ?>
                                                        <i class="fas fa-star text-warning"></i>
                                                        <?php echo number_format($provider['rating'], 1); ?>
                                                        <small>(<?php echo $provider['total_services']; ?> servicios)</small>
                                                    <?php else: ?>
                                                        <small>Nuevo especialista</small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <?php if (!empty($provider['keywords'])): ?>
                                            <div class="mb-3">
                                                <small class="text-muted">Especialidades:</small>
                                                <div class="mt-1">
                                                    <?php 
                                                    $keywords = array_slice(explode(',', $provider['keywords']), 0, 3);
                                                    foreach ($keywords as $keyword): 
                                                    ?>
                                                        <span class="badge bg-light text-dark me-1"><?php echo htmlspecialchars(trim($keyword)); ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($provider['address'])): ?>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <?php echo htmlspecialchars($provider['address']); ?>
                                                </small>
                                            </p>
                                        <?php endif; ?>
                                        
                                        <div class="d-flex gap-2">
                                            <?php if (!empty($provider['phone'])): ?>
                                                <a href="tel:<?php echo $provider['phone']; ?>" class="btn btn-outline-primary btn-sm flex-grow-1">
                                                    <i class="fas fa-phone"></i> Llamar
                                                </a>
                                            <?php endif; ?>
                                            <a href="<?php echo $baseUrl; ?>provider/profile/<?php echo $provider['id']; ?>" class="btn btn-primary btn-sm flex-grow-1">
                                                Ver Perfil
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- No Results -->
            <?php if (empty($categories) && empty($providers)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-search fa-4x text-muted mb-4"></i>
                    <h3>No se encontraron resultados</h3>
                    <p class="text-muted mb-4">
                        No pudimos encontrar servicios o especialistas que coincidan con tu búsqueda 
                        "<strong><?php echo htmlspecialchars($query); ?></strong>".
                    </p>
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6>Sugerencias para mejorar tu búsqueda:</h6>
                                    <ul class="text-start">
                                        <li>Verifica la ortografía de las palabras</li>
                                        <li>Usa términos más generales (ej: "plomero" en lugar de "plomero de emergencia")</li>
                                        <li>Intenta con sinónimos o palabras relacionadas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <a href="<?php echo $baseUrl; ?>services" class="btn btn-primary">
                            <i class="fas fa-tools"></i> Ver Todos los Servicios
                        </a>
                    </div>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- Welcome Search Page -->
            <div class="text-center py-5">
                <i class="fas fa-search fa-4x text-primary mb-4"></i>
                <h2>Encuentra el Servicio Perfecto</h2>
                <p class="lead text-muted mb-5">
                    Usa el buscador para encontrar especialistas y servicios cerca de ti
                </p>
                
                <!-- Popular Searches -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h5 class="mb-3">Búsquedas populares:</h5>
                        <div class="d-flex flex-wrap justify-content-center gap-2">
                            <a href="<?php echo $baseUrl; ?>search?q=plomería" class="badge bg-light text-dark text-decoration-none p-2">
                                Plomería
                            </a>
                            <a href="<?php echo $baseUrl; ?>search?q=electricista" class="badge bg-light text-dark text-decoration-none p-2">
                                Electricista
                            </a>
                            <a href="<?php echo $baseUrl; ?>search?q=limpieza" class="badge bg-light text-dark text-decoration-none p-2">
                                Limpieza
                            </a>
                            <a href="<?php echo $baseUrl; ?>search?q=jardinería" class="badge bg-light text-dark text-decoration-none p-2">
                                Jardinería
                            </a>
                            <a href="<?php echo $baseUrl; ?>search?q=mecánico" class="badge bg-light text-dark text-decoration-none p-2">
                                Mecánico
                            </a>
                            <a href="<?php echo $baseUrl; ?>search?q=carpintería" class="badge bg-light text-dark text-decoration-none p-2">
                                Carpintería
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>