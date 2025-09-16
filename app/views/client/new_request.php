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
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>client/new_request">
                            <i class="fas fa-plus-circle"></i> Nueva Solicitud
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>client/requests">
                            <i class="fas fa-list"></i> Mis Solicitudes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>client/services">
                            <i class="fas fa-search"></i> Ver Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>financial">
                            <i class="fas fa-chart-line"></i> Financiero
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
                <h1 class="h2">Nueva Solicitud de Servicio</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <a href="<?php echo $baseUrl; ?>client/requests" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left"></i> Ver Mis Solicitudes
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
                                <i class="fas fa-tools"></i> Detalles del Servicio
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo $baseUrl; ?>client/new_request">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Tipo de Servicio *</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="">Selecciona un servicio...</option>
                                        <?php foreach ($services as $service): ?>
                                            <option value="<?php echo $service['id']; ?>" 
                                                    data-price="<?php echo $service['base_price']; ?>"
                                                    data-duration="<?php echo $service['estimated_duration']; ?>">
                                                <?php echo htmlspecialchars($service['name']); ?> 
                                                - $<?php echo number_format($service['base_price'], 2); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="title" class="form-label">Título de la Solicitud *</label>
                                    <input type="text" class="form-control" id="title" name="title" required
                                           placeholder="Ej: Reparación de grifo en cocina">
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción Detallada</label>
                                    <textarea class="form-control" id="description" name="description" rows="4"
                                              placeholder="Describe el problema o servicio que necesitas..."></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="urgency" class="form-label">Urgencia *</label>
                                        <select class="form-select" id="urgency" name="urgency" required>
                                            <option value="">Selecciona urgencia...</option>
                                            <option value="normal">Normal</option>
                                            <option value="prioritario">Prioritario (+25% costo)</option>
                                            <option value="programado">Programado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3" id="scheduled_date_section" style="display: none;">
                                        <label for="scheduled_date" class="form-label">Fecha Programada</label>
                                        <input type="datetime-local" class="form-control" id="scheduled_date" name="scheduled_date">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="address" class="form-label">Dirección del Servicio *</label>
                                    <textarea class="form-control" id="address" name="address" rows="2" required
                                              placeholder="Dirección completa donde se realizará el servicio"></textarea>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="<?php echo $baseUrl; ?>client/requests" class="btn btn-secondary">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Enviar Solicitud
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
                                <i class="fas fa-info-circle"></i> Información del Servicio
                            </h6>
                        </div>
                        <div class="card-body">
                            <div id="service-info" style="display: none;">
                                <div class="mb-3">
                                    <small class="text-muted">Precio Base</small>
                                    <div class="fw-bold text-success" id="service-price">$0.00</div>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted">Duración Estimada</small>
                                    <div class="fw-bold" id="service-duration">0 minutos</div>
                                </div>
                            </div>
                            
                            <div class="alert alert-info">
                                <h6><i class="fas fa-lightbulb"></i> Consejos</h6>
                                <ul class="mb-0 small">
                                    <li><strong>Descripción:</strong> Proporciona detalles específicos</li>
                                    <li><strong>Urgencia:</strong> Los servicios prioritarios tienen costo adicional</li>
                                    <li><strong>Programado:</strong> Ideal para mantenimientos regulares</li>
                                    <li><strong>Dirección:</strong> Incluye referencias o puntos de ubicación</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    const urgencySelect = document.getElementById('urgency');
    const scheduledDateSection = document.getElementById('scheduled_date_section');
    const serviceInfo = document.getElementById('service-info');
    const servicePrice = document.getElementById('service-price');
    const serviceDuration = document.getElementById('service-duration');
    
    // Show/hide scheduled date based on urgency
    urgencySelect.addEventListener('change', function() {
        if (this.value === 'programado') {
            scheduledDateSection.style.display = 'block';
            document.getElementById('scheduled_date').required = true;
        } else {
            scheduledDateSection.style.display = 'none';
            document.getElementById('scheduled_date').required = false;
        }
    });
    
    // Show service information when service is selected
    categorySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            const price = selectedOption.dataset.price;
            const duration = selectedOption.dataset.duration;
            
            servicePrice.textContent = '$' + parseFloat(price).toFixed(2);
            serviceDuration.textContent = duration + ' minutos';
            serviceInfo.style.display = 'block';
        } else {
            serviceInfo.style.display = 'none';
        }
    });
});
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>