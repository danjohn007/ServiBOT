<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>dashboard">
                            <i class="fas fa-tachometer-alt"></i> Panel Principal
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>financial">
                            <i class="fas fa-chart-line"></i> Módulo Financiero
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>financial/transactions">
                            <i class="fas fa-list"></i> Transacciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>financial/reports">
                            <i class="fas fa-file-chart-line"></i> Reportes
                        </a>
                    </li>
                    <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'superadmin' || $_SESSION['role'] === 'franquicitario')): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>financial/add_transaction">
                            <i class="fas fa-plus"></i> Nueva Transacción
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Módulo Financiero</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="<?php echo $baseUrl; ?>financial/reports" class="btn btn-outline-primary">
                            <i class="fas fa-file-alt"></i> Generar Reporte
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

            <!-- Financial Summary Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-arrow-up fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Ingresos del Mes</h5>
                                    <h3 class="mb-0">$<?php echo number_format($financialSummary['monthly']['income'], 2); ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-arrow-down fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Egresos del Mes</h5>
                                    <h3 class="mb-0">$<?php echo number_format($financialSummary['monthly']['expenses'], 2); ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-percentage fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Comisiones</h5>
                                    <h3 class="mb-0">$<?php echo number_format($financialSummary['monthly']['commissions'], 2); ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-dark">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-balance-scale fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="card-title">Balance Mensual</h5>
                                    <h3 class="mb-0">$<?php echo number_format($financialSummary['monthly']['income'] - $financialSummary['monthly']['expenses'], 2); ?></h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-clock"></i> Transacciones Recientes
                        </h5>
                        <a href="<?php echo $baseUrl; ?>financial/transactions" class="btn btn-sm btn-outline-primary">
                            Ver Todas
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentTransactions)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Descripción</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentTransactions as $transaction): ?>
                                        <tr>
                                            <td><?php echo date('d/m/Y H:i', strtotime($transaction['transaction_date'])); ?></td>
                                            <td>
                                                <?php 
                                                $typeClass = [
                                                    'ingreso' => 'success',
                                                    'egreso' => 'danger',
                                                    'comision' => 'info',
                                                    'reembolso' => 'warning'
                                                ];
                                                $typeLabel = [
                                                    'ingreso' => 'Ingreso',
                                                    'egreso' => 'Egreso',
                                                    'comision' => 'Comisión',
                                                    'reembolso' => 'Reembolso'
                                                ];
                                                ?>
                                                <span class="badge bg-<?php echo $typeClass[$transaction['transaction_type']]; ?>">
                                                    <?php echo $typeLabel[$transaction['transaction_type']]; ?>
                                                </span>
                                            </td>
                                            <td><?php echo htmlspecialchars($transaction['description'] ?? 'Sin descripción'); ?></td>
                                            <td>
                                                <span class="fw-bold <?php echo $transaction['transaction_type'] === 'ingreso' ? 'text-success' : 'text-danger'; ?>">
                                                    $<?php echo number_format($transaction['amount'], 2); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                $statusClass = [
                                                    'pendiente' => 'warning',
                                                    'completado' => 'success',
                                                    'cancelado' => 'danger'
                                                ];
                                                $statusLabel = [
                                                    'pendiente' => 'Pendiente',
                                                    'completado' => 'Completado',
                                                    'cancelado' => 'Cancelado'
                                                ];
                                                ?>
                                                <span class="badge bg-<?php echo $statusClass[$transaction['status']]; ?>">
                                                    <?php echo $statusLabel[$transaction['status']]; ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay transacciones registradas</h5>
                            <p class="text-muted">Las transacciones aparecerán aquí cuando se registren.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>