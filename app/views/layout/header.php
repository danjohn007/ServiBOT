<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'ServiBOT - Servicios a Domicilio'; ?></title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo $assetsUrl; ?>css/style.css" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo $assetsUrl; ?>images/favicon.png">
    
    <meta name="description" content="ServiBOT - Plataforma de servicios a domicilio. Encuentra especialistas cerca de ti.">
    <meta name="keywords" content="servicios, domicilio, plomería, mecánica, medicina, programación">
    <meta name="author" content="ServiBOT">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo $baseUrl; ?>">
                <i class="fas fa-robot"></i> ServiBOT
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>services">
                            <i class="fas fa-tools"></i> Servicios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>home/about">
                            <i class="fas fa-info-circle"></i> Acerca de
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $baseUrl; ?>home/contact">
                            <i class="fas fa-envelope"></i> Contacto
                        </a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <?php if ($currentUser): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($currentUser['name']); ?>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if ($currentUser['role'] === 'superadmin'): ?>
                                    <li><a class="dropdown-item" href="<?php echo $baseUrl; ?>admin"><i class="fas fa-cog"></i> Panel Admin</a></li>
                                <?php elseif ($currentUser['role'] === 'cliente'): ?>
                                    <li><a class="dropdown-item" href="<?php echo $baseUrl; ?>client/dashboard"><i class="fas fa-tachometer-alt"></i> Mi Panel</a></li>
                                    <li><a class="dropdown-item" href="<?php echo $baseUrl; ?>client/requests"><i class="fas fa-list"></i> Mis Solicitudes</a></li>
                                <?php elseif ($currentUser['role'] === 'prestador'): ?>
                                    <li><a class="dropdown-item" href="<?php echo $baseUrl; ?>provider/dashboard"><i class="fas fa-tachometer-alt"></i> Mi Panel</a></li>
                                    <li><a class="dropdown-item" href="<?php echo $baseUrl; ?>provider/requests"><i class="fas fa-briefcase"></i> Mis Servicios</a></li>
                                <?php endif; ?>
                                <?php if ($currentUser['role'] === 'cliente'): ?>
                                    <li><a class="dropdown-item" href="<?php echo $baseUrl; ?>client/profile"><i class="fas fa-user-edit"></i> Mi Perfil</a></li>
                                <?php elseif ($currentUser['role'] === 'prestador'): ?>
                                    <li><a class="dropdown-item" href="<?php echo $baseUrl; ?>provider/profile"><i class="fas fa-user-edit"></i> Mi Perfil</a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?php echo $baseUrl; ?>admin/profile"><i class="fas fa-user-edit"></i> Mi Perfil</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?php echo $baseUrl; ?>auth/logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $baseUrl; ?>auth/login">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $baseUrl; ?>auth/register">
                                <i class="fas fa-user-plus"></i> Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <main class="main-content"><?php echo "\n"; ?>