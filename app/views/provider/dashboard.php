<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>provider/dashboard">
                            <i class="fas fa-tachometer-alt"></i> Panel Principal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>provider/profile">
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
                <h1 class="h2">Panel de Prestador</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="<?php echo $baseUrl; ?>provider/profile" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-user-edit"></i> Editar Perfil
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Bienvenido a tu Panel de Prestador</h5>
                        </div>
                        <div class="card-body">
                            <p class="lead">
                                Desde aquí puedes gestionar tu perfil profesional, ver solicitudes de servicios
                                y administrar tu disponibilidad.
                            </p>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card bg-primary text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="card-title">Solicitudes Pendientes</h6>
                                                    <h3 class="mb-0">0</h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-clock fa-2x opacity-75"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="card bg-success text-white">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h6 class="card-title">Servicios Completados</h6>
                                                    <h3 class="mb-0">0</h3>
                                                </div>
                                                <div class="align-self-center">
                                                    <i class="fas fa-check-circle fa-2x opacity-75"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6>Próximos Pasos:</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <i class="fas fa-user-edit text-primary me-2"></i>
                                        Completa tu perfil profesional
                                    </div>
                                    <a href="<?php echo $baseUrl; ?>provider/profile" class="btn btn-sm btn-primary">
                                        Completar
                                    </a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <i class="fas fa-tags text-info me-2"></i>
                                        Agrega palabras clave para ser encontrado fácilmente
                                    </div>
                                    <a href="<?php echo $baseUrl; ?>provider/profile" class="btn btn-sm btn-info">
                                        Agregar
                                    </a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <i class="fas fa-star text-warning me-2"></i>
                                        Selecciona las categorías de servicios que ofreces
                                    </div>
                                    <a href="<?php echo $baseUrl; ?>provider/profile" class="btn btn-sm btn-warning">
                                        Configurar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Estado de Disponibilidad</h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-toggle-on fa-3x text-success"></i>
                            </div>
                            <h6>Disponible</h6>
                            <p class="text-muted">Los clientes pueden encontrarte y solicitar tus servicios</p>
                            <button class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-toggle-off"></i> Cambiar Estado
                            </button>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h6 class="card-title mb-0">Consejos Rápidos</h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    <small>Mantén tu perfil completo y actualizado</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    <small>Responde rápidamente a las solicitudes</small>
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-lightbulb text-warning"></i>
                                    <small>Usa palabras clave específicas de tu servicio</small>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>