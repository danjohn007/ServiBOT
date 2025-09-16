<?php require_once VIEWS_PATH . 'layout/header.php'; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0 my-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="fas fa-robot fa-3x text-primary mb-3"></i>
                        <h2 class="h3 fw-bold">Crear Cuenta</h2>
                        <p class="text-muted">Únete a la comunidad ServiBOT</p>
                    </div>
                    
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="needs-validation" novalidate>
                        <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user"></i> Nombre Completo *
                                </label>
                                <input type="text" 
                                       class="form-control <?php echo isset($errors['name']) ? 'is-invalid' : ''; ?>" 
                                       id="name" 
                                       name="name" 
                                       required
                                       value="<?php echo htmlspecialchars($formData['name'] ?? ''); ?>"
                                       placeholder="Tu nombre completo">
                                <div class="invalid-feedback">
                                    <?php echo $errors['name'] ?? 'El nombre es requerido.'; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email *
                                </label>
                                <input type="email" 
                                       class="form-control <?php echo isset($errors['email']) ? 'is-invalid' : ''; ?>" 
                                       id="email" 
                                       name="email" 
                                       required
                                       value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>"
                                       placeholder="tu@email.com">
                                <div class="invalid-feedback">
                                    <?php echo $errors['email'] ?? 'Ingresa un email válido.'; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">
                                    <i class="fas fa-phone"></i> Teléfono
                                </label>
                                <input type="tel" 
                                       class="form-control" 
                                       id="phone" 
                                       name="phone"
                                       value="<?php echo htmlspecialchars($formData['phone'] ?? ''); ?>"
                                       placeholder="555-123-4567">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">
                                    <i class="fas fa-user-tag"></i> Tipo de Cuenta *
                                </label>
                                <select class="form-select <?php echo isset($errors['role']) ? 'is-invalid' : ''; ?>" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="">Selecciona...</option>
                                    <option value="cliente" <?php echo ($formData['role'] ?? '') === 'cliente' ? 'selected' : ''; ?>>
                                        Cliente - Solicitar servicios
                                    </option>
                                    <option value="prestador" <?php echo ($formData['role'] ?? '') === 'prestador' ? 'selected' : ''; ?>>
                                        Prestador - Ofrecer servicios
                                    </option>
                                </select>
                                <div class="invalid-feedback">
                                    <?php echo $errors['role'] ?? 'Selecciona un tipo de cuenta.'; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- City selection for providers -->
                        <div class="mb-3" id="citySection" style="display: none;">
                            <label for="city" class="form-label">
                                <i class="fas fa-city"></i> Ciudad de Operación *
                            </label>
                            <select class="form-select <?php echo isset($errors['city']) ? 'is-invalid' : ''; ?>" 
                                    id="city" 
                                    name="city">
                                <option value="">Selecciona tu ciudad...</option>
                                <?php 
                                // Get franchises for city selection
                                if (!isset($franchises)) {
                                    require_once MODELS_PATH . 'franchise.php';
                                    $franchiseModel = new Franchise();
                                    $franchises = $franchiseModel->getAll();
                                }
                                foreach ($franchises as $franchise): ?>
                                    <option value="<?php echo htmlspecialchars($franchise['city']); ?>" 
                                            <?php echo ($formData['city'] ?? '') === $franchise['city'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($franchise['city']); ?>
                                    </option>
                                <?php endforeach; ?>
                                <option value="nueva_ciudad" <?php echo ($formData['city'] ?? '') === 'nueva_ciudad' ? 'selected' : ''; ?>>
                                    Nueva ciudad (especificar abajo)
                                </option>
                            </select>
                            <div class="invalid-feedback">
                                <?php echo $errors['city'] ?? 'Selecciona tu ciudad de operación.'; ?>
                            </div>
                        </div>
                        
                        <!-- New city input -->
                        <div class="mb-3" id="newCitySection" style="display: none;">
                            <label for="new_city" class="form-label">
                                <i class="fas fa-plus-circle"></i> Especifica tu ciudad
                            </label>
                            <input type="text" 
                                   class="form-control <?php echo isset($errors['new_city']) ? 'is-invalid' : ''; ?>" 
                                   id="new_city" 
                                   name="new_city"
                                   value="<?php echo htmlspecialchars($formData['new_city'] ?? ''); ?>"
                                   placeholder="Nombre de tu ciudad">
                            <small class="form-text text-muted">
                                Tu registro será revisado por nuestro equipo administrativo.
                            </small>
                            <div class="invalid-feedback">
                                <?php echo $errors['new_city'] ?? 'Especifica el nombre de tu ciudad.'; ?>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">
                                <i class="fas fa-map-marker-alt"></i> Dirección
                            </label>
                            <textarea class="form-control" 
                                      id="address" 
                                      name="address" 
                                      rows="2"
                                      placeholder="Tu dirección completa"><?php echo htmlspecialchars($formData['address'] ?? ''); ?></textarea>
                            <small class="form-text text-muted">
                                Esta información nos ayuda a conectarte con especialistas cercanos.
                            </small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="fas fa-lock"></i> Contraseña *
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?php echo isset($errors['password']) ? 'is-invalid' : ''; ?>" 
                                           id="password" 
                                           name="password" 
                                           required
                                           minlength="6"
                                           placeholder="Mínimo 6 caracteres">
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePasswordView('password', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    <?php echo $errors['password'] ?? 'La contraseña debe tener al menos 6 caracteres.'; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="confirm_password" class="form-label">
                                    <i class="fas fa-lock"></i> Confirmar Contraseña *
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?php echo isset($errors['confirm_password']) ? 'is-invalid' : ''; ?>" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           required
                                           placeholder="Confirma tu contraseña">
                                    <button class="btn btn-outline-secondary" 
                                            type="button" 
                                            onclick="togglePasswordView('confirm_password', this)">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback">
                                    <?php echo $errors['confirm_password'] ?? 'Las contraseñas deben coincidir.'; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input <?php echo isset($errors['terms']) ? 'is-invalid' : ''; ?>" 
                                       id="terms" 
                                       name="terms" 
                                       value="1"
                                       required>
                                <label class="form-check-label" for="terms">
                                    Acepto los 
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">
                                        términos y condiciones
                                    </a> 
                                    y la 
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal">
                                        política de privacidad
                                    </a> *
                                </label>
                                <div class="invalid-feedback">
                                    <?php echo $errors['terms'] ?? 'Debes aceptar los términos y condiciones.'; ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus"></i> Crear Cuenta
                            </button>
                        </div>
                    </form>
                </div>
                
                <div class="card-footer bg-light text-center">
                    <p class="mb-0">
                        ¿Ya tienes cuenta? 
                        <a href="<?php echo $baseUrl; ?>auth/login" class="text-decoration-none fw-bold">
                            Inicia sesión aquí
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Términos y Condiciones</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>1. Uso de la Plataforma</h6>
                <p>Al usar ServiBOT, aceptas proporcionar información veraz y mantener la confidencialidad de tu cuenta.</p>
                
                <h6>2. Servicios</h6>
                <p>ServiBOT conecta clientes con prestadores de servicios independientes. No somos empleadores de los prestadores.</p>
                
                <h6>3. Pagos</h6>
                <p>Los pagos se procesan de forma segura. ServiBOT retiene una comisión por cada transacción completada.</p>
                
                <h6>4. Responsabilidades</h6>
                <p>Los usuarios son responsables de sus acciones en la plataforma y de cumplir con las leyes locales.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Política de Privacidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <h6>Recopilación de Información</h6>
                <p>Recopilamos información necesaria para conectar clientes con prestadores de servicios.</p>
                
                <h6>Uso de la Información</h6>
                <p>Usamos tu información para mejorar nuestros servicios y facilitar conexiones efectivas.</p>
                
                <h6>Protección de Datos</h6>
                <p>Implementamos medidas de seguridad para proteger tu información personal.</p>
                
                <h6>Compartir Información</h6>
                <p>Solo compartimos información necesaria entre clientes y prestadores para facilitar los servicios.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
function togglePasswordView(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (password !== confirmPassword) {
        this.setCustomValidity('Las contraseñas no coinciden');
    } else {
        this.setCustomValidity('');
    }
});

// Handle role selection to show/hide city section
document.getElementById('role').addEventListener('change', function() {
    const citySection = document.getElementById('citySection');
    const newCitySection = document.getElementById('newCitySection');
    const citySelect = document.getElementById('city');
    const newCityInput = document.getElementById('new_city');
    
    if (this.value === 'prestador') {
        citySection.style.display = 'block';
        citySelect.setAttribute('required', 'required');
    } else {
        citySection.style.display = 'none';
        newCitySection.style.display = 'none';
        citySelect.removeAttribute('required');
        newCityInput.removeAttribute('required');
        citySelect.value = '';
        newCityInput.value = '';
    }
});

// Handle city selection to show/hide new city input
document.getElementById('city').addEventListener('change', function() {
    const newCitySection = document.getElementById('newCitySection');
    const newCityInput = document.getElementById('new_city');
    
    if (this.value === 'nueva_ciudad') {
        newCitySection.style.display = 'block';
        newCityInput.setAttribute('required', 'required');
    } else {
        newCitySection.style.display = 'none';
        newCityInput.removeAttribute('required');
        newCityInput.value = '';
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role');
    const citySelect = document.getElementById('city');
    
    // Trigger change events to set initial state
    if (roleSelect.value) {
        roleSelect.dispatchEvent(new Event('change'));
    }
    if (citySelect.value) {
        citySelect.dispatchEvent(new Event('change'));
    }
});
</script>

<?php require_once VIEWS_PATH . 'layout/footer.php'; ?>