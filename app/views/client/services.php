<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>client/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Panel Principal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>services/request">
                            <i class="fas fa-plus-circle"></i> Nueva Solicitud
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>client/requests">
                            <i class="fas fa-list"></i> Mis Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>client/services">
                            <i class="fas fa-search"></i> Ver Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>client/profile">
                            <i class="fas fa-user-edit"></i> Mi Perfil
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Servicios Disponibles</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="<?php echo $baseUrl; ?>services/request" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Solicitar Servicio
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </span>
                                <input type="text" class="form-control" id="searchServices" 
                                       placeholder="Buscar servicios...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="priceFilter">
                                <option value="">Todos los precios</option>
                                <option value="0-500">$0 - $500</option>
                                <option value="500-1000">$500 - $1,000</option>
                                <option value="1000-2000">$1,000 - $2,000</option>
                                <option value="2000+">$2,000+</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="durationFilter">
                                <option value="">Toda duración</option>
                                <option value="0-60">Menos de 1 hora</option>
                                <option value="60-120">1-2 horas</option>
                                <option value="120-240">2-4 horas</option>
                                <option value="240+">Más de 4 horas</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Services Grid -->
            <div class="row g-4" id="servicesGrid">
                <?php if (empty($services)): ?>
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <h5><i class="fas fa-info-circle"></i> No hay servicios disponibles</h5>
                            <p class="mb-0">Actualmente no hay categorías de servicios configuradas.</p>
                        </div>
                    </div>
                <?php else: ?>
                    <?php foreach ($services as $service): ?>
                        <div class="col-md-6 col-lg-4 service-card" 
                             data-name="<?php echo strtolower($service['name']); ?>"
                             data-price="<?php echo $service['base_price']; ?>"
                             data-duration="<?php echo $service['estimated_duration']; ?>">
                            <div class="card h-100 service-item">
                                <div class="card-body text-center">
                                    <div class="service-icon mb-3">
                                        <i class="<?php echo htmlspecialchars($service['icon']); ?> fa-3x text-primary"></i>
                                    </div>
                                    <h5 class="card-title"><?php echo htmlspecialchars($service['name']); ?></h5>
                                    <p class="card-text text-muted">
                                        <?php echo htmlspecialchars($service['description'] ?: 'Servicio profesional de ' . $service['name']); ?>
                                    </p>
                                    
                                    <div class="service-details mb-3">
                                        <div class="row text-sm">
                                            <div class="col-6">
                                                <div class="text-muted">
                                                    <i class="fas fa-dollar-sign"></i> Desde
                                                </div>
                                                <strong class="text-success">
                                                    $<?php echo number_format($service['base_price'], 0); ?>
                                                </strong>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-muted">
                                                    <i class="fas fa-clock"></i> Duración
                                                </div>
                                                <strong class="text-info">
                                                    <?php 
                                                    $hours = floor($service['estimated_duration'] / 60);
                                                    $minutes = $service['estimated_duration'] % 60;
                                                    if ($hours > 0) {
                                                        echo $hours . 'h';
                                                        if ($minutes > 0) echo ' ' . $minutes . 'm';
                                                    } else {
                                                        echo $minutes . 'm';
                                                    }
                                                    ?>
                                                </strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <div class="d-grid gap-2">
                                        <a href="<?php echo $baseUrl; ?>services/request?category=<?php echo $service['id']; ?>" 
                                           class="btn btn-primary">
                                            <i class="fas fa-plus"></i> Solicitar Ahora
                                        </a>
                                        <button class="btn btn-outline-info btn-sm" 
                                                onclick="showServiceDetails(<?php echo $service['id']; ?>)">
                                            <i class="fas fa-info-circle"></i> Más Información
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Popular Services Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <h3 class="h4 mb-4">
                        <i class="fas fa-fire text-warning"></i>
                        Servicios Más Populares
                    </h3>
                </div>
            </div>
            
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card border-warning">
                        <div class="card-body text-center">
                            <i class="fas fa-wrench fa-2x text-warning mb-2"></i>
                            <h6>Plomería de Emergencia</h6>
                            <p class="small text-muted mb-2">Servicio 24/7 para fugas y obstrucciones</p>
                            <span class="badge bg-warning text-dark">Más Solicitado</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-success">
                        <div class="card-body text-center">
                            <i class="fas fa-broom fa-2x text-success mb-2"></i>
                            <h6>Limpieza Profunda</h6>
                            <p class="small text-muted mb-2">Limpieza completa para hogares y oficinas</p>
                            <span class="badge bg-success">Mejor Valorado</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body text-center">
                            <i class="fas fa-car fa-2x text-info mb-2"></i>
                            <h6>Mecánica a Domicilio</h6>
                            <p class="small text-muted mb-2">Reparaciones automotrices en tu ubicación</p>
                            <span class="badge bg-info">Rápido</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h5>
                                <i class="fas fa-question-circle text-primary"></i>
                                ¿Cómo solicitar un servicio?
                            </h5>
                            <div class="row">
                                <div class="col-md-3 text-center mb-3">
                                    <div class="step-icon bg-primary text-white rounded-circle mx-auto mb-2">1</div>
                                    <h6>Elige el Servicio</h6>
                                    <p class="small">Selecciona la categoría que necesitas</p>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="step-icon bg-primary text-white rounded-circle mx-auto mb-2">2</div>
                                    <h6>Proporciona Detalles</h6>
                                    <p class="small">Describe lo que necesitas y tu ubicación</p>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="step-icon bg-primary text-white rounded-circle mx-auto mb-2">3</div>
                                    <h6>Recibe Cotizaciones</h6>
                                    <p class="small">Los prestadores te enviarán sus propuestas</p>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="step-icon bg-primary text-white rounded-circle mx-auto mb-2">4</div>
                                    <h6>Confirma y Disfruta</h6>
                                    <p class="small">Elige al mejor prestador y recibe el servicio</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Service Details Modal -->
<div class="modal fade" id="serviceModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalles del Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="serviceModalBody">
                <!-- Service details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="requestServiceBtn">
                    <i class="fas fa-plus"></i> Solicitar Servicio
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.service-item {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.service-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    border-color: #0d6efd;
}

.service-icon {
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.step-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
}
</style>

<script>
function filterServices() {
    const searchTerm = document.getElementById('searchServices').value.toLowerCase();
    const priceFilter = document.getElementById('priceFilter').value;
    const durationFilter = document.getElementById('durationFilter').value;
    const serviceCards = document.querySelectorAll('.service-card');
    
    serviceCards.forEach(card => {
        const serviceName = card.getAttribute('data-name');
        const servicePrice = parseFloat(card.getAttribute('data-price'));
        const serviceDuration = parseInt(card.getAttribute('data-duration'));
        
        let showCard = true;
        
        // Search filter
        if (searchTerm && !serviceName.includes(searchTerm)) {
            showCard = false;
        }
        
        // Price filter
        if (priceFilter) {
            if (priceFilter === '0-500' && servicePrice > 500) showCard = false;
            if (priceFilter === '500-1000' && (servicePrice < 500 || servicePrice > 1000)) showCard = false;
            if (priceFilter === '1000-2000' && (servicePrice < 1000 || servicePrice > 2000)) showCard = false;
            if (priceFilter === '2000+' && servicePrice < 2000) showCard = false;
        }
        
        // Duration filter
        if (durationFilter) {
            if (durationFilter === '0-60' && serviceDuration > 60) showCard = false;
            if (durationFilter === '60-120' && (serviceDuration < 60 || serviceDuration > 120)) showCard = false;
            if (durationFilter === '120-240' && (serviceDuration < 120 || serviceDuration > 240)) showCard = false;
            if (durationFilter === '240+' && serviceDuration < 240) showCard = false;
        }
        
        card.style.display = showCard ? 'block' : 'none';
    });
}

function showServiceDetails(serviceId) {
    // This would normally fetch service details from the server
    const modal = new bootstrap.Modal(document.getElementById('serviceModal'));
    
    // Mock service details
    const serviceDetails = `
        <div class="text-center mb-4">
            <i class="fas fa-wrench fa-3x text-primary"></i>
            <h4 class="mt-2">Servicio Profesional</h4>
        </div>
        <div class="row">
            <div class="col-md-6">
                <h6>¿Qué incluye?</h6>
                <ul>
                    <li>Diagnóstico profesional</li>
                    <li>Reparación o instalación</li>
                    <li>Garantía del trabajo</li>
                    <li>Limpieza del área</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h6>Información del servicio</h6>
                <p><strong>Precio desde:</strong> $300</p>
                <p><strong>Duración:</strong> 1-2 horas</p>
                <p><strong>Disponibilidad:</strong> 24/7</p>
                <p><strong>Garantía:</strong> 30 días</p>
            </div>
        </div>
    `;
    
    document.getElementById('serviceModalBody').innerHTML = serviceDetails;
    document.getElementById('requestServiceBtn').onclick = () => {
        window.location.href = '<?php echo $baseUrl; ?>services/request?category=' + serviceId;
    };
    
    modal.show();
}

// Add event listeners
document.getElementById('searchServices').addEventListener('input', filterServices);
document.getElementById('priceFilter').addEventListener('change', filterServices);
document.getElementById('durationFilter').addEventListener('change', filterServices);
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>