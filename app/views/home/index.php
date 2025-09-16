<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<!-- Hero Section -->
<section class="hero-section bg-primary text-white py-5">
    <div class="container">
        <div class="row align-items-center min-vh-100">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    <i class="fas fa-robot"></i> ServiBOT
                </h1>
                <p class="lead mb-4">
                    La plataforma más confiable para servicios a domicilio. 
                    Conectamos clientes con los mejores especialistas cerca de ti.
                </p>
                <div class="d-flex gap-3">
                    <?php if (!$currentUser): ?>
                        <a href="<?php echo $baseUrl; ?>auth/register" class="btn btn-light btn-lg">
                            <i class="fas fa-user-plus"></i> Registrarse
                        </a>
                        <a href="<?php echo $baseUrl; ?>services" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-tools"></i> Ver Servicios
                        </a>
                    <?php else: ?>
                        <?php if ($currentUser['role'] === 'cliente'): ?>
                            <a href="<?php echo $baseUrl; ?>services/request" class="btn btn-light btn-lg">
                                <i class="fas fa-plus"></i> Solicitar Servicio
                            </a>
                        <?php elseif ($currentUser['role'] === 'prestador'): ?>
                            <a href="<?php echo $baseUrl; ?>provider/dashboard" class="btn btn-light btn-lg">
                                <i class="fas fa-tachometer-alt"></i> Mi Panel
                            </a>
                        <?php else: ?>
                            <a href="<?php echo $baseUrl; ?>admin" class="btn btn-light btn-lg">
                                <i class="fas fa-cog"></i> Panel Admin
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo $baseUrl; ?>services" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-tools"></i> Ver Servicios
                        </a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="text-center">
                    <i class="fas fa-robot display-1 opacity-75"></i>
                    <div class="mt-4">
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <i class="fas fa-users fa-2x mb-2"></i>
                                    <h6>+1000 Clientes</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <i class="fas fa-star fa-2x mb-2"></i>
                                    <h6>4.8/5 Rating</h6>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="bg-white bg-opacity-10 rounded p-3">
                                    <i class="fas fa-clock fa-2x mb-2"></i>
                                    <h6>24/7 Soporte</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h1 fw-bold">Nuestros Servicios</h2>
            <p class="lead text-muted">Encuentra el especialista perfecto para tus necesidades</p>
        </div>
        
        <div class="row g-4">
            <?php if (!empty($services)): ?>
                <?php foreach ($services as $service): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 service-card">
                            <div class="card-body text-center p-4">
                                <div class="service-icon mb-3">
                                    <i class="<?php echo htmlspecialchars($service['icon']); ?> fa-3x text-primary"></i>
                                </div>
                                <h5 class="card-title"><?php echo htmlspecialchars($service['name']); ?></h5>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($service['description']); ?></p>
                                <div class="price mb-3">
                                    <span class="h4 text-primary">$<?php echo number_format($service['base_price'], 2); ?></span>
                                    <small class="text-muted">desde</small>
                                </div>
                                <a href="<?php echo $baseUrl; ?>services/<?php echo $service['id']; ?>" class="btn btn-outline-primary">
                                    Ver Detalles
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        No hay servicios disponibles en este momento.
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="text-center mt-5">
            <a href="<?php echo $baseUrl; ?>services" class="btn btn-primary btn-lg">
                <i class="fas fa-tools"></i> Ver Todos los Servicios
            </a>
        </div>
    </div>
</section>

<!-- How It Works Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h1 fw-bold">¿Cómo Funciona?</h2>
            <p class="lead text-muted">Obtén el servicio que necesitas en 3 simples pasos</p>
        </div>
        
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <span class="h4 mb-0">1</span>
                    </div>
                    <h5>Solicita el Servicio</h5>
                    <p class="text-muted">Selecciona el tipo de servicio que necesitas y proporciona los detalles de tu solicitud.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <span class="h4 mb-0">2</span>
                    </div>
                    <h5>Conectamos con un Especialista</h5>
                    <p class="text-muted">Nuestro algoritmo encuentra al mejor especialista disponible cerca de tu ubicación.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="step-number bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <span class="h4 mb-0">3</span>
                    </div>
                    <h5>Recibe el Servicio</h5>
                    <p class="text-muted">El especialista llega a tu domicilio y realiza el trabajo. Paga de forma segura al finalizar.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="h1 fw-bold">¿Por Qué Elegir ServiBOT?</h2>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                    <h5>Especialistas Certificados</h5>
                    <p class="text-muted">Todos nuestros prestadores de servicio están verificados y certificados.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                    <h5>Respuesta Rápida</h5>
                    <p class="text-muted">Atención inmediata o programada según tus necesidades.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
                    <h5>Seguimiento en Tiempo Real</h5>
                    <p class="text-muted">Conoce la ubicación del especialista en todo momento.</p>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="text-center">
                    <i class="fas fa-credit-card fa-3x text-primary mb-3"></i>
                    <h5>Pago Seguro</h5>
                    <p class="text-muted">Múltiples opciones de pago seguras y confiables.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>