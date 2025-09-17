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
                        <a class="nav-link" href="<?php echo $baseUrl; ?>client/new_request">
                            <i class="fas fa-plus-circle"></i> Nueva Solicitud
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>client/requests">
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
                <h1 class="h2">Mis Solicitudes de Servicio</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="<?php echo $baseUrl; ?>client/new_request" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Nueva Solicitud
                        </a>
                    </div>
                </div>
            </div>

            <!-- Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <select class="form-select" id="statusFilter">
                                <option value="">Todos los estados</option>
                                <option value="pendiente">Pendiente</option>
                                <option value="asignado">Asignado</option>
                                <option value="en_camino">En camino</option>
                                <option value="en_servicio">En servicio</option>
                                <option value="completado">Completado</option>
                                <option value="cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="serviceFilter">
                                <option value="">Todos los servicios</option>
                                <option value="plomeria">Plomería</option>
                                <option value="mecanica">Mecánica</option>
                                <option value="medicina">Medicina</option>
                                <option value="programacion">Programación</option>
                                <option value="limpieza">Limpieza</option>
                                <option value="jardineria">Jardinería</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="dateFilter" placeholder="Filtrar por fecha">
                        </div>
                        <div class="col-md-3">
                            <button type="button" class="btn btn-outline-secondary" onclick="clearFilters()">
                                <i class="fas fa-times"></i> Limpiar Filtros
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requests List -->
            <div class="row" id="requestsList">
                <!-- Demo request 1 -->
                <div class="col-12 mb-3">
                    <div class="card request-card" data-status="pendiente" data-service="plomeria">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <div class="service-icon bg-primary text-white rounded-circle me-3">
                                            <i class="fas fa-wrench"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1">Reparación de tubería de cocina</h5>
                                            <p class="text-muted mb-2">Fuga en la tubería bajo el fregadero, necesita reparación urgente.</p>
                                            <div class="row text-sm">
                                                <div class="col-sm-6">
                                                    <i class="fas fa-calendar text-muted me-1"></i>
                                                    <small>15 Nov 2024, 10:30 AM</small>
                                                </div>
                                                <div class="col-sm-6">
                                                    <i class="fas fa-map-marker-alt text-muted me-1"></i>
                                                    <small>Col. Roma Norte, CDMX</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="mb-2">
                                        <span class="badge bg-warning text-dark fs-6">Pendiente</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="h5 text-primary">$450.00</strong>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewRequest(1)">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger" onclick="cancelRequest(1)">
                                            <i class="fas fa-times"></i> Cancelar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Demo request 2 -->
                <div class="col-12 mb-3">
                    <div class="card request-card" data-status="completado" data-service="limpieza">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <div class="service-icon bg-success text-white rounded-circle me-3">
                                            <i class="fas fa-broom"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1">Limpieza profunda de casa</h5>
                                            <p class="text-muted mb-2">Limpieza completa de casa de 3 recámaras, baños y áreas comunes.</p>
                                            <div class="row text-sm">
                                                <div class="col-sm-6">
                                                    <i class="fas fa-calendar text-muted me-1"></i>
                                                    <small>10 Nov 2024, 8:00 AM</small>
                                                </div>
                                                <div class="col-sm-6">
                                                    <i class="fas fa-user text-muted me-1"></i>
                                                    <small>María González - ⭐ 4.8</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="mb-2">
                                        <span class="badge bg-success fs-6">Completado</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="h5 text-success">$800.00</strong>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewRequest(2)">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="rateService(2)">
                                            <i class="fas fa-star"></i> Calificar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Demo request 3 -->
                <div class="col-12 mb-3">
                    <div class="card request-card" data-status="en_servicio" data-service="mecanica">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="d-flex align-items-start">
                                        <div class="service-icon bg-info text-white rounded-circle me-3">
                                            <i class="fas fa-car"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1">Cambio de frenos</h5>
                                            <p class="text-muted mb-2">Cambio de pastillas y discos de freno traseros - Honda Civic 2018.</p>
                                            <div class="row text-sm">
                                                <div class="col-sm-6">
                                                    <i class="fas fa-calendar text-muted me-1"></i>
                                                    <small>16 Nov 2024, 2:00 PM</small>
                                                </div>
                                                <div class="col-sm-6">
                                                    <i class="fas fa-user text-muted me-1"></i>
                                                    <small>Roberto Martínez - ⭐ 4.9</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="mb-2">
                                        <span class="badge bg-info fs-6">En Servicio</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong class="h5 text-info">$1,200.00</strong>
                                    </div>
                                    <div class="btn-group">
                                        <button class="btn btn-sm btn-outline-primary" onclick="viewRequest(3)">
                                            <i class="fas fa-eye"></i> Ver
                                        </button>
                                        <button class="btn btn-sm btn-success" onclick="trackService(3)">
                                            <i class="fas fa-map-marker-alt"></i> Seguir
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div class="text-center py-5 d-none" id="emptyState">
                <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No tienes solicitudes de servicio</h5>
                <p class="text-muted">¡Solicita tu primer servicio ahora!</p>
                <a href="<?php echo $baseUrl; ?>services/request" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nueva Solicitud
                </a>
            </div>
        </main>
    </div>
</div>

<!-- Service Rating Modal -->
<div class="modal fade" id="ratingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Calificar Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <h6>¿Cómo fue tu experiencia?</h6>
                    <div class="star-rating" id="starRating">
                        <i class="fas fa-star" data-rating="1"></i>
                        <i class="fas fa-star" data-rating="2"></i>
                        <i class="fas fa-star" data-rating="3"></i>
                        <i class="fas fa-star" data-rating="4"></i>
                        <i class="fas fa-star" data-rating="5"></i>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="reviewText" class="form-label">Comentario (opcional)</label>
                    <textarea class="form-control" id="reviewText" rows="3" placeholder="Comparte tu experiencia..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" onclick="submitRating()">Enviar Calificación</button>
            </div>
        </div>
    </div>
</div>

<style>
.service-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.request-card {
    transition: all 0.2s ease;
    border: 1px solid #e9ecef;
}

.request-card:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border-color: #0d6efd;
}

.star-rating {
    font-size: 2rem;
}

.star-rating i {
    color: #ddd;
    cursor: pointer;
    margin: 0 2px;
    transition: color 0.2s;
}

.star-rating i:hover,
.star-rating i.active {
    color: #ffc107;
}
</style>

<script>
function clearFilters() {
    document.getElementById('statusFilter').value = '';
    document.getElementById('serviceFilter').value = '';
    document.getElementById('dateFilter').value = '';
    filterRequests();
}

function filterRequests() {
    const statusFilter = document.getElementById('statusFilter').value;
    const serviceFilter = document.getElementById('serviceFilter').value;
    const cards = document.querySelectorAll('.request-card');
    let visibleCount = 0;
    
    cards.forEach(card => {
        const cardStatus = card.getAttribute('data-status');
        const cardService = card.getAttribute('data-service');
        
        let showCard = true;
        
        if (statusFilter && cardStatus !== statusFilter) {
            showCard = false;
        }
        
        if (serviceFilter && cardService !== serviceFilter) {
            showCard = false;
        }
        
        if (showCard) {
            card.parentElement.classList.remove('d-none');
            visibleCount++;
        } else {
            card.parentElement.classList.add('d-none');
        }
    });
    
    document.getElementById('emptyState').classList.toggle('d-none', visibleCount > 0);
}

function viewRequest(requestId) {
    alert(`Ver detalles de solicitud #${requestId}`);
}

function cancelRequest(requestId) {
    if (confirm('¿Estás seguro de cancelar esta solicitud?')) {
        alert(`Solicitud #${requestId} cancelada`);
    }
}

function trackService(requestId) {
    alert(`Seguimiento en tiempo real de solicitud #${requestId}`);
}

function rateService(requestId) {
    const modal = new bootstrap.Modal(document.getElementById('ratingModal'));
    modal.show();
}

function submitRating() {
    const rating = document.querySelectorAll('.star-rating i.active').length;
    const review = document.getElementById('reviewText').value;
    
    if (rating === 0) {
        alert('Por favor selecciona una calificación');
        return;
    }
    
    alert(`Calificación enviada: ${rating} estrellas`);
    bootstrap.Modal.getInstance(document.getElementById('ratingModal')).hide();
}

// Add event listeners
document.getElementById('statusFilter').addEventListener('change', filterRequests);
document.getElementById('serviceFilter').addEventListener('change', filterRequests);

// Star rating functionality
document.querySelectorAll('.star-rating i').forEach(star => {
    star.addEventListener('mouseover', function() {
        const rating = parseInt(this.getAttribute('data-rating'));
        document.querySelectorAll('.star-rating i').forEach((s, index) => {
            s.classList.toggle('active', index < rating);
        });
    });
    
    star.addEventListener('click', function() {
        const rating = parseInt(this.getAttribute('data-rating'));
        document.querySelectorAll('.star-rating i').forEach((s, index) => {
            s.classList.toggle('active', index < rating);
        });
    });
});
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>