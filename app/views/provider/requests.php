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
                        <a class="nav-link" href="<?php echo $baseUrl; ?>provider/profile">
                            <i class="fas fa-user-edit"></i> Mi Perfil
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>provider/requests">
                            <i class="fas fa-clipboard-list"></i> Mis Servicios
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Mis Solicitudes de Servicio</h1>
            </div>

            <div class="text-center py-5">
                <i class="fas fa-clipboard-list fa-4x text-muted mb-4"></i>
                <h3>No tienes solicitudes de servicio aún</h3>
                <p class="text-muted mb-4">
                    Una vez que completes tu perfil y los clientes comiencen a solicitar tus servicios, 
                    aparecerán aquí.
                </p>
                <a href="<?php echo $baseUrl; ?>provider/profile" class="btn btn-primary">
                    <i class="fas fa-user-edit"></i> Completar Mi Perfil
                </a>
            </div>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>