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
                        <a class="nav-link" href="<?php echo $baseUrl; ?>financial/transactions">
                            <i class="fas fa-list"></i> Transacciones
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>financial/reports">
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
                <h1 class="h2">Reportes Financieros</h1>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <a href="<?php echo $baseUrl; ?>financial" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Volver al Dashboard
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

            <div class="row">
                <div class="col-lg-4">
                    <!-- Generate New Report -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-plus-circle"></i> Generar Nuevo Reporte
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo $baseUrl; ?>financial/reports">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                
                                <div class="mb-3">
                                    <label for="report_type" class="form-label">Tipo de Reporte *</label>
                                    <select class="form-select" id="report_type" name="report_type" required>
                                        <option value="">Selecciona tipo...</option>
                                        <option value="semanal">Reporte Semanal</option>
                                        <option value="mensual">Reporte Mensual</option>
                                        <option value="anual">Reporte Anual</option>
                                        <option value="personalizado">Personalizado</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Fecha Inicio *</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>

                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Fecha Fin *</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-chart-bar"></i> Generar Reporte
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <!-- Existing Reports -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-history"></i> Reportes Generados
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($reports)): ?>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>ID</th>
                                                <th>Tipo</th>
                                                <th>Período</th>
                                                <th>Ingresos</th>
                                                <th>Egresos</th>
                                                <th>Ganancia Neta</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($reports as $report): ?>
                                                <tr>
                                                    <td>#<?php echo $report['id']; ?></td>
                                                    <td>
                                                        <span class="badge bg-primary">
                                                            <?php echo ucfirst($report['report_type']); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?php echo date('d/m/Y', strtotime($report['start_date'])); ?> - 
                                                            <?php echo date('d/m/Y', strtotime($report['end_date'])); ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <span class="text-success fw-bold">
                                                            $<?php echo number_format($report['total_income'], 2); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="text-danger fw-bold">
                                                            $<?php echo number_format($report['total_expenses'], 2); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold <?php echo $report['net_profit'] >= 0 ? 'text-success' : 'text-danger'; ?>">
                                                            $<?php echo number_format($report['net_profit'], 2); ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php 
                                                        $statusClass = [
                                                            'generando' => 'warning',
                                                            'completado' => 'success',
                                                            'error' => 'danger'
                                                        ];
                                                        $statusLabel = [
                                                            'generando' => 'Generando',
                                                            'completado' => 'Completado',
                                                            'error' => 'Error'
                                                        ];
                                                        ?>
                                                        <span class="badge bg-<?php echo $statusClass[$report['status']]; ?>">
                                                            <?php echo $statusLabel[$report['status']]; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if ($report['status'] === 'completado'): ?>
                                                            <div class="btn-group btn-group-sm">
                                                                <button class="btn btn-outline-primary" title="Ver Detalles" onclick="viewReport(<?php echo $report['id']; ?>)">
                                                                    <i class="fas fa-eye"></i>
                                                                </button>
                                                                <button class="btn btn-outline-success" title="Descargar PDF" onclick="downloadReport(<?php echo $report['id']; ?>)">
                                                                    <i class="fas fa-download"></i>
                                                                </button>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                                    <h5 class="text-muted">No hay reportes generados</h5>
                                    <p class="text-muted">Genera tu primer reporte financiero usando el formulario de la izquierda.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reportTypeSelect = document.getElementById('report_type');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    
    // Auto-fill dates based on report type
    reportTypeSelect.addEventListener('change', function() {
        const today = new Date();
        let startDate, endDate;
        
        switch (this.value) {
            case 'semanal':
                startDate = new Date(today.getTime() - (7 * 24 * 60 * 60 * 1000));
                endDate = today;
                break;
            case 'mensual':
                startDate = new Date(today.getFullYear(), today.getMonth(), 1);
                endDate = new Date(today.getFullYear(), today.getMonth() + 1, 0);
                break;
            case 'anual':
                startDate = new Date(today.getFullYear(), 0, 1);
                endDate = new Date(today.getFullYear(), 11, 31);
                break;
            default:
                return;
        }
        
        startDateInput.value = startDate.toISOString().split('T')[0];
        endDateInput.value = endDate.toISOString().split('T')[0];
    });
});

function viewReport(reportId) {
    // Implement view report functionality
    alert('Ver reporte #' + reportId + ' - Funcionalidad en desarrollo');
}

function downloadReport(reportId) {
    // Implement download report functionality
    alert('Descargar reporte #' + reportId + ' - Funcionalidad en desarrollo');
}
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>