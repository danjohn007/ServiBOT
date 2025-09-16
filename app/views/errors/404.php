<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página no encontrada - ServiBOT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 text-center">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-5">
                        <i class="fas fa-robot fa-5x text-primary mb-4"></i>
                        <h1 class="display-1 fw-bold text-primary">404</h1>
                        <h2 class="h3 mb-3">Página no encontrada</h2>
                        <p class="text-muted mb-4">
                            Lo sentimos, la página que buscas no existe o ha sido movida.
                        </p>
                        <div class="d-flex gap-3 justify-content-center">
                            <a href="<?php echo BASE_URL; ?>" class="btn btn-primary">
                                <i class="fas fa-home"></i> Volver al Inicio
                            </a>
                            <a href="<?php echo BASE_URL; ?>services" class="btn btn-outline-primary">
                                <i class="fas fa-tools"></i> Ver Servicios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>