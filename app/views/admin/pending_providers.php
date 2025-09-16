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
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>admin/pending_providers">
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
                <h1 class="h2">Prestadores por Autorizar</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="<?php echo $baseUrl; ?>admin/users" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver a Usuarios
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

            <?php if (empty($pendingProviders)): ?>
                <div class="alert alert-info">
                    <h5><i class="fas fa-info-circle"></i> No hay prestadores pendientes</h5>
                    <p class="mb-0">Actualmente no hay prestadores esperando autorización.</p>
                </div>
            <?php else: ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-user-clock"></i> 
                            Prestadores Pendientes (<?php echo count($pendingProviders); ?>)
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Ciudad</th>
                                        <th>Experiencia</th>
                                        <th>Fecha Registro</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pendingProviders as $provider): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-warning text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                    <div>
                                                        <strong><?php echo htmlspecialchars($provider['name']); ?></strong>
                                                        <?php if (!empty($provider['keywords'])): ?>
                                                            <small class="text-muted d-block">
                                                                <?php echo htmlspecialchars(substr($provider['keywords'], 0, 50)); ?>...
                                                            </small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo htmlspecialchars($provider['email']); ?></td>
                                            <td>
                                                <?php echo htmlspecialchars($provider['phone'] ?? 'No especificado'); ?>
                                            </td>
                                            <td>
                                                <?php echo htmlspecialchars($provider['city'] ?? 'No especificada'); ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?php echo ($provider['experience_years'] ?? 0); ?> años
                                                </span>
                                            </td>
                                            <td>
                                                <?php echo date('d/m/Y', strtotime($provider['created_at'])); ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <form method="POST" action="<?php echo $baseUrl; ?>admin/approve/<?php echo $provider['id']; ?>" class="d-inline">
                                                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                                        <input type="hidden" name="action" value="approve">
                                                        <button type="submit" class="btn btn-sm btn-success" 
                                                                onclick="return confirm('¿Aprobar a este prestador?')">
                                                            <i class="fas fa-check"></i> Aprobar
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="<?php echo $baseUrl; ?>admin/approve/<?php echo $provider['id']; ?>" class="d-inline">
                                                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                                        <input type="hidden" name="action" value="reject">
                                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                                onclick="return confirm('¿Rechazar a este prestador?')">
                                                            <i class="fas fa-times"></i> Rechazar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Help Card -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-info-circle"></i> Información sobre Autorización
                            </h6>
                        </div>
                        <div class="card-body">
                            <p class="mb-2"><strong>Aprobar:</strong> El prestador podrá recibir solicitudes de servicio y aparecer en búsquedas.</p>
                            <p class="mb-0"><strong>Rechazar:</strong> El prestador seguirá activo pero no podrá recibir solicitudes hasta ser aprobado.</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>