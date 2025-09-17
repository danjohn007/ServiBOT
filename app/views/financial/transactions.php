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
                        <a class="nav-link" href="<?php echo $baseUrl; ?>financial">
                            <i class="fas fa-chart-line"></i> Módulo Financiero
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>financial/transactions">
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
                <h1 class="h2">Historial de Transacciones</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="<?php echo $baseUrl; ?>financial" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Dashboard
                        </a>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-list"></i> Todas las Transacciones
                        </h5>
                        <small class="text-muted">
                            Total: <?php echo $totalTransactions; ?> transacciones
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($transactions)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Descripción</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
                                        <th>Referencia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($transactions as $transaction): ?>
                                        <tr>
                                            <td>#<?php echo $transaction['id']; ?></td>
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
                                                    <?php echo $transaction['transaction_type'] === 'ingreso' ? '+' : '-'; ?>$<?php echo number_format($transaction['amount'], 2); ?>
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
                                            <td>
                                                <?php if ($transaction['reference_id']): ?>
                                                    <small class="text-muted">
                                                        <?php echo ucfirst($transaction['reference_type'] ?? 'general'); ?> #<?php echo $transaction['reference_id']; ?>
                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-muted">-</small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                            <nav aria-label="Paginación de transacciones">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo $baseUrl; ?>financial/transactions?page=<?php echo $currentPage - 1; ?>">Anterior</a>
                                    </li>
                                    
                                    <?php for ($i = max(1, $currentPage - 2); $i <= min($totalPages, $currentPage + 2); $i++): ?>
                                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                            <a class="page-link" href="<?php echo $baseUrl; ?>financial/transactions?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="<?php echo $baseUrl; ?>financial/transactions?page=<?php echo $currentPage + 1; ?>">Siguiente</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted">No hay transacciones registradas</h5>
                            <p class="text-muted">Las transacciones aparecerán aquí cuando se registren en el sistema.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>
</div>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>