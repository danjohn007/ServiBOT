<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<!-- Contact Section -->
<section class="py-5 mt-5">
    <div class="container">
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold">
                <i class="fas fa-envelope text-primary"></i> Contáctanos
            </h1>
            <p class="lead text-muted">Estamos aquí para ayudarte. Envíanos un mensaje y te responderemos pronto.</p>
        </div>
        
        <div class="row g-5">
            <div class="col-lg-8">
                <div class="card border-0 shadow">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-paper-plane"></i> Enviar Mensaje
                        </h5>
                    </div>
                    <div class="card-body p-4">
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
                        
                        <form method="POST" action="<?php echo $baseUrl; ?>home/contact">
                            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Nombre Completo *</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="subject" class="form-label">Asunto</label>
                                <select class="form-select" id="subject" name="subject">
                                    <option value="">Selecciona un tema</option>
                                    <option value="soporte_tecnico" <?php echo ($_POST['subject'] ?? '') === 'soporte_tecnico' ? 'selected' : ''; ?>>
                                        Soporte Técnico
                                    </option>
                                    <option value="informacion_servicios" <?php echo ($_POST['subject'] ?? '') === 'informacion_servicios' ? 'selected' : ''; ?>>
                                        Información sobre Servicios
                                    </option>
                                    <option value="prestador_servicios" <?php echo ($_POST['subject'] ?? '') === 'prestador_servicios' ? 'selected' : ''; ?>>
                                        Ser Prestador de Servicios
                                    </option>
                                    <option value="facturacion" <?php echo ($_POST['subject'] ?? '') === 'facturacion' ? 'selected' : ''; ?>>
                                        Facturación y Pagos
                                    </option>
                                    <option value="franquicia" <?php echo ($_POST['subject'] ?? '') === 'franquicia' ? 'selected' : ''; ?>>
                                        Información de Franquicias
                                    </option>
                                    <option value="otros" <?php echo ($_POST['subject'] ?? '') === 'otros' ? 'selected' : ''; ?>>
                                        Otros
                                    </option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label for="message" class="form-label">Mensaje *</label>
                                <textarea class="form-control" id="message" name="message" rows="6" 
                                          placeholder="Describe tu consulta o mensaje..." required><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane"></i> Enviar Mensaje
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Contact Information -->
                <div class="card border-0 shadow mb-4">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0">
                            <i class="fas fa-info-circle"></i> Información de Contacto
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Email</h6>
                                <small class="text-muted">contacto@servibot.com</small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Teléfono</h6>
                                <small class="text-muted">+1 (555) 123-4567</small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Horario de Atención</h6>
                                <small class="text-muted">24/7 - Siempre disponible</small>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center">
                            <div class="bg-warning text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h6 class="mb-0">Ubicación</h6>
                                <small class="text-muted">Servicios en toda la región</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- FAQ -->
                <div class="card border-0 shadow">
                    <div class="card-header bg-warning text-dark">
                        <h6 class="mb-0">
                            <i class="fas fa-question-circle"></i> Preguntas Frecuentes
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="accordion" id="faqAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq1">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                        ¿Cómo funciona ServiBOT?
                                    </button>
                                </h2>
                                <div id="collapse1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <small>
                                            Solo necesitas registrarte, buscar el servicio que necesitas y conectarte con especialistas certificados cerca de ti.
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq2">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                        ¿Los servicios tienen garantía?
                                    </button>
                                </h2>
                                <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <small>
                                            Sí, todos nuestros prestadores de servicios ofrecen garantía en sus trabajos según los términos acordados.
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="faq3">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                        ¿Cómo puedo ser prestador?
                                    </button>
                                </h2>
                                <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        <small>
                                            Regístrate como prestador de servicios, completa tu perfil y nuestro equipo verificará tus credenciales antes de activar tu cuenta.
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>