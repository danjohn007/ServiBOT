-- Sample data for ServiBOT

USE servibot_db;

-- Insert sample users
INSERT INTO users (email, password, role, name, phone, address, latitude, longitude) VALUES
-- Superadmin
('admin@servibot.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin', 'Administrador ServiBOT', '555-0100', 'Oficina Central', 19.4326, -99.1332),

-- Clients
('cliente1@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente', 'María González', '555-0101', 'Av. Reforma 123, CDMX', 19.4200, -99.1300),
('cliente2@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cliente', 'Carlos López', '555-0102', 'Calle Madero 456, CDMX', 19.4350, -99.1400),

-- Service Providers
('plomero1@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'prestador', 'Juan Pérez', '555-0201', 'Colonia Centro, CDMX', 19.4300, -99.1350),
('mecanico1@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'prestador', 'Roberto Martínez', '555-0202', 'Narvarte, CDMX', 19.4100, -99.1500),
('doctor1@email.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'prestador', 'Dra. Ana Rodríguez', '555-0203', 'Roma Norte, CDMX', 19.4150, -99.1600);

-- Insert service categories
INSERT INTO service_categories (name, description, icon, base_price, estimated_duration) VALUES
('Plomería', 'Servicios de plomería y fontanería', 'fas fa-wrench', 300.00, 120),
('Mecánica', 'Reparación de vehículos a domicilio', 'fas fa-car', 500.00, 180),
('Medicina', 'Consultas médicas a domicilio', 'fas fa-user-md', 800.00, 60),
('Programación', 'Desarrollo y soporte técnico', 'fas fa-code', 1000.00, 240),
('Limpieza', 'Servicios de limpieza doméstica', 'fas fa-broom', 200.00, 120),
('Entrenamiento', 'Entrenador personal a domicilio', 'fas fa-dumbbell', 400.00, 90),
('Enfermería', 'Cuidados de enfermería', 'fas fa-heartbeat', 600.00, 60),
('Fletes', 'Servicio de mudanzas y transporte', 'fas fa-truck', 350.00, 180);

-- Insert service providers
INSERT INTO service_providers (user_id, service_categories, experience_years, rating, total_services, availability_schedule, coverage_radius, documents, is_verified) VALUES
(4, '[1]', 5, 4.5, 120, '{"lunes": "08:00-18:00", "martes": "08:00-18:00", "miercoles": "08:00-18:00", "jueves": "08:00-18:00", "viernes": "08:00-18:00", "sabado": "08:00-14:00"}', 15, '["cedula_profesional.pdf", "certificacion_plomeria.pdf"]', true),
(5, '[2]', 8, 4.8, 200, '{"lunes": "07:00-19:00", "martes": "07:00-19:00", "miercoles": "07:00-19:00", "jueves": "07:00-19:00", "viernes": "07:00-19:00", "sabado": "07:00-15:00"}', 20, '["licencia_mecanico.pdf", "certificacion_automotriz.pdf"]', true),
(6, '[3, 7]', 12, 4.9, 80, '{"lunes": "09:00-20:00", "martes": "09:00-20:00", "miercoles": "09:00-20:00", "jueves": "09:00-20:00", "viernes": "09:00-20:00"}', 25, '["cedula_medica.pdf", "especialidad_medicina_general.pdf"]', true);

-- Insert sample service requests
INSERT INTO service_requests (client_id, provider_id, category_id, title, description, urgency, address, latitude, longitude, status, price, additional_info) VALUES
(2, 4, 1, 'Fuga de agua en cocina', 'Hay una fuga importante debajo del fregadero', 'prioritario', 'Av. Reforma 123, CDMX', 19.4200, -99.1300, 'completado', 450.00, '{"tipo_fuga": "tuberia", "ubicacion": "cocina", "urgencia_nivel": "alta"}'),
(3, 5, 2, 'Revisión de frenos', 'El auto hace ruido al frenar', 'normal', 'Calle Madero 456, CDMX', 19.4350, -99.1400, 'en_servicio', 600.00, '{"vehiculo": "sedan", "año": "2018", "problema": "frenos"}'),
(2, 6, 3, 'Consulta médica general', 'Revisión médica de rutina', 'programado', 'Av. Reforma 123, CDMX', 19.4200, -99.1300, 'asignado', 800.00, '{"tipo_consulta": "general", "sintomas": "revision_rutina"}');

-- Insert tracking records
INSERT INTO service_tracking (request_id, status, notes) VALUES
(1, 'pendiente', 'Solicitud recibida'),
(1, 'asignado', 'Asignado a Juan Pérez'),
(1, 'en_camino', 'El técnico está en camino'),
(1, 'en_servicio', 'Iniciando reparación'),
(1, 'completado', 'Fuga reparada exitosamente'),
(2, 'pendiente', 'Solicitud recibida'),
(2, 'asignado', 'Asignado a Roberto Martínez'),
(2, 'en_camino', 'El mecánico está en camino'),
(2, 'en_servicio', 'Revisando el vehículo'),
(3, 'pendiente', 'Solicitud recibida'),
(3, 'asignado', 'Asignado a Dra. Ana Rodríguez');

-- Insert ratings
INSERT INTO ratings (request_id, client_id, provider_id, rating, review) VALUES
(1, 2, 4, 5, 'Excelente servicio, muy profesional y rápido');

-- Insert payments
INSERT INTO payments (request_id, client_id, provider_id, amount, platform_fee, payment_method, payment_status) VALUES
(1, 2, 4, 450.00, 45.00, 'tarjeta', 'completado');

-- Insert sample notifications
INSERT INTO notifications (user_id, title, message, type, related_id) VALUES
(2, 'Servicio completado', 'Tu solicitud de plomería ha sido completada', 'success', 1),
(4, 'Nuevo pago recibido', 'Has recibido un pago de $405.00', 'success', 1),
(3, 'Técnico en camino', 'El mecánico Roberto está en camino a tu ubicación', 'info', 2),
(5, 'Nueva solicitud asignada', 'Se te ha asignado una nueva solicitud de servicio', 'info', 2);

-- Update provider ratings based on reviews
UPDATE service_providers sp 
SET rating = (
    SELECT AVG(r.rating) 
    FROM ratings r 
    WHERE r.provider_id = sp.user_id
),
total_services = (
    SELECT COUNT(*) 
    FROM service_requests sr 
    WHERE sr.provider_id = sp.user_id AND sr.status = 'completado'
);