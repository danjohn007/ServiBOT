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
                        <a class="nav-link" href="<?php echo $baseUrl; ?>financial/reports">
                            <i class="fas fa-file-chart-line"></i> Reportes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="<?php echo $baseUrl; ?>financial/add_transaction">
                            <i class="fas fa-plus"></i> Nueva Transacción
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Nueva Transacción</h1>
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
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-plus-circle"></i> Registrar Transacción
                            </h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="<?php echo $baseUrl; ?>financial/add_transaction">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="transaction_type" class="form-label">Tipo de Transacción *</label>
                                        <select class="form-select" id="transaction_type" name="transaction_type" required>
                                            <option value="">Selecciona tipo...</option>
                                            <option value="ingreso">Ingreso</option>
                                            <option value="egreso">Egreso</option>
                                            <option value="comision">Comisión</option>
                                            <option value="reembolso">Reembolso</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="amount" class="form-label">Monto *</label>
                                        <div class="input-group">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" id="amount" name="amount" 
                                                   required step="0.01" min="0" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Descripción *</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" 
                                              required placeholder="Describe la transacción..."></textarea>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="<?php echo $baseUrl; ?>financial" class="btn btn-secondary">
                                        Cancelar
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Registrar Transacción
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
                                <i class="fas fa-info-circle"></i> Información
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6><i class="fas fa-lightbulb"></i> Tipos de Transacción</h6>
                                <ul class="mb-0 small">
                                    <li><strong>Ingreso:</strong> Dinero que entra (ventas, pagos recibidos)</li>
                                    <li><strong>Egreso:</strong> Dinero que sale (gastos, compras)</li>
                                    <li><strong>Comisión:</strong> Comisiones cobradas o pagadas</li>
                                    <li><strong>Reembolso:</strong> Devoluciones de dinero</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle"></i> Importante</h6>
                                <p class="mb-0 small">
                                    Solo usuarios con permisos de administrador o franquicitario pueden 
                                    registrar transacciones manualmente. Todas las transacciones quedan 
                                    registradas en el sistema.
                                </p>
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
    const transactionTypeSelect = document.getElementById('transaction_type');
    const amountInput = document.getElementById('amount');
    
    // Update input styling based on transaction type
    transactionTypeSelect.addEventListener('change', function() {
        const amountGroup = amountInput.parentElement;
        amountGroup.classList.remove('border-success', 'border-danger', 'border-info', 'border-warning');
        
        switch (this.value) {
            case 'ingreso':
                amountGroup.classList.add('border-success');
                break;
            case 'egreso':
                amountGroup.classList.add('border-danger');
                break;
            case 'comision':
                amountGroup.classList.add('border-info');
                break;
            case 'reembolso':
                amountGroup.classList.add('border-warning');
                break;
        }
    });
});
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>