    </main>
    
    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-robot"></i> ServiBOT</h5>
                    <p>Tu plataforma de confianza para servicios a domicilio. Conectamos clientes con los mejores especialistas.</p>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                
                <div class="col-md-2">
                    <h6>Enlaces</h6>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo $baseUrl; ?>" class="text-light text-decoration-none">Inicio</a></li>
                        <li><a href="<?php echo $baseUrl; ?>services" class="text-light text-decoration-none">Servicios</a></li>
                        <li><a href="<?php echo $baseUrl; ?>home/about" class="text-light text-decoration-none">Acerca de</a></li>
                        <li><a href="<?php echo $baseUrl; ?>home/contact" class="text-light text-decoration-none">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h6>Servicios</h6>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light text-decoration-none">Plomería</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Mecánica</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Medicina</a></li>
                        <li><a href="#" class="text-light text-decoration-none">Programación</a></li>
                    </ul>
                </div>
                
                <div class="col-md-3">
                    <h6>Contacto</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone"></i> +52 442 351 5156</li>
                        <li><i class="fas fa-envelope"></i>servibot@fix360.app</li>
                        <li><a href="mailto:servibot@fix360.app" class="text-light text-decoration-none">servibot@fix360.app</a></li>
                        <li><i class="fas fa-map-marker-alt"></i> Querétaro, México</li>
                    </ul>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> ServiBOT. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light text-decoration-none me-3">Política de Privacidad</a>
                    <a href="#" class="text-light text-decoration-none">Términos de Servicio</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="<?php echo $assetsUrl; ?>js/main.js"></script>
    
    <!-- Additional scripts can be added here -->
    <?php if (isset($additionalScripts)): ?>
        <?php foreach ($additionalScripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>
