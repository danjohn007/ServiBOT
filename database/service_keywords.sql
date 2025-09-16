-- ========================================
-- SQL para inserción de palabras clave a los servicios de los prestadores
-- ServiBOT - Sistema de gestión de servicios a domicilio
-- ========================================

-- Actualizar palabras clave para prestadores existentes de plomería
UPDATE service_providers 
SET keywords = 'plomería, fontanería, fugas, instalación, reparación, tubería, baños, cocinas, emergencias, 24 horas, destapado, desagües, calentador, agua, presión, válvulas, llaves, grifos, mingitorio, inodoro, lavabo, regadera, fuga de gas, calefacción'
WHERE service_categories LIKE '%1%'; -- Categoría 1 = Plomería

-- Actualizar palabras clave para prestadores existentes de mecánica
UPDATE service_providers 
SET keywords = 'mecánica, automotriz, frenos, motor, transmisión, llantas, batería, emergencias, domicilio, aire acondicionado, radiador, aceite, filtros, bujías, correa, clutch, suspensión, dirección, escape, carburador, inyección, diagnóstico, grúa'
WHERE service_categories LIKE '%2%'; -- Categoría 2 = Mecánica

-- Insertar palabras clave por categorías de servicio

-- Medicina a domicilio
INSERT OR IGNORE INTO service_providers (user_id, service_categories, keywords, experience_years, rating, total_services, is_verified, is_available, city)
SELECT 
    u.id,
    '[3]',
    'medicina, consulta médica, doctor, enfermería, inyecciones, curaciones, toma de signos vitales, presión arterial, glicemia, primeros auxilios, emergencias médicas, adulto mayor, pediatría, medicina general, domicilio, telemedicina',
    CASE WHEN u.id % 3 = 0 THEN 10 ELSE 5 END,
    4.2,
    50,
    0,
    1,
    'Ciudad de México'
FROM users u 
WHERE u.role = 'prestador' 
AND u.id NOT IN (SELECT user_id FROM service_providers WHERE service_categories LIKE '%3%')
LIMIT 2;

-- Programación y soporte técnico
INSERT OR IGNORE INTO service_providers (user_id, service_categories, keywords, experience_years, rating, total_services, is_verified, is_available, city)
SELECT 
    u.id,
    '[4]',
    'programación, desarrollo web, aplicaciones móviles, soporte técnico, computadoras, reparación PC, instalación software, configuración, redes, wifi, antivirus, respaldo datos, diseño web, bases de datos, domicilio, remoto, consultoría',
    CASE WHEN u.id % 4 = 0 THEN 8 ELSE 6 END,
    4.5,
    75,
    0,
    1,
    'Guadalajara'
FROM users u 
WHERE u.role = 'prestador' 
AND u.id NOT IN (SELECT user_id FROM service_providers WHERE service_categories LIKE '%4%')
LIMIT 2;

-- Limpieza doméstica
INSERT OR IGNORE INTO service_providers (user_id, service_categories, keywords, experience_years, rating, total_services, is_verified, is_available, city)
SELECT 
    u.id,
    '[5]',
    'limpieza, aseo, limpieza profunda, desinfección, lavado, aspirado, cocina, baños, ventanas, pisos, alfombras, muebles, oficinas, mudanzas, post construcción, doméstica, comercial, ecológica, productos naturales',
    3,
    4.3,
    100,
    0,
    1,
    'Monterrey'
FROM users u 
WHERE u.role = 'prestador' 
AND u.id NOT IN (SELECT user_id FROM service_providers WHERE service_categories LIKE '%5%')
LIMIT 3;

-- Jardinería y paisajismo
INSERT OR IGNORE INTO service_providers (user_id, service_categories, keywords, experience_years, rating, total_services, is_verified, is_available, city)
SELECT 
    u.id,
    '[6]',
    'jardinería, paisajismo, poda, césped, plantas, riego, fertilización, diseño jardines, mantenimiento, árboles, arbustos, flores, huerto, compost, plagas, fumigación, jardineros, domicilio, exterior, terrazas',
    4,
    4.4,
    60,
    0,
    1,
    'Puebla'
FROM users u 
WHERE u.role = 'prestador' 
AND u.id NOT IN (SELECT user_id FROM service_providers WHERE service_categories LIKE '%6%')
LIMIT 2;

-- ========================================
-- Insertar nuevas categorías de servicio con palabras clave
-- ========================================

-- Electricidad
INSERT OR IGNORE INTO service_categories (id, name, description, icon, base_price, estimated_duration, is_active) 
VALUES (7, 'Electricidad', 'Servicios eléctricos y instalaciones', 'fas fa-bolt', 400.00, 90, 1);

-- Carpintería
INSERT OR IGNORE INTO service_categories (id, name, description, icon, base_price, estimated_duration, is_active) 
VALUES (8, 'Carpintería', 'Trabajos en madera y muebles', 'fas fa-hammer', 350.00, 180, 1);

-- Pintura
INSERT OR IGNORE INTO service_categories (id, name, description, icon, base_price, estimated_duration, is_active) 
VALUES (9, 'Pintura', 'Pintura de interiores y exteriores', 'fas fa-paint-roller', 300.00, 240, 1);

-- Belleza y estética
INSERT OR IGNORE INTO service_categories (id, name, description, icon, base_price, estimated_duration, is_active) 
VALUES (10, 'Belleza', 'Servicios de belleza a domicilio', 'fas fa-cut', 250.00, 120, 1);

-- ========================================
-- Insertar prestadores para las nuevas categorías
-- ========================================

-- Electricistas
INSERT OR IGNORE INTO service_providers (user_id, service_categories, keywords, experience_years, rating, total_services, is_verified, is_available, city)
VALUES 
(1, '[7]', 'electricidad, electricista, instalaciones eléctricas, cableado, interruptores, contactos, lámparas, ventiladores, tableros, cortocircuitos, emergencias eléctricas, 110v, 220v, domicilio, seguridad eléctrica', 7, 4.6, 150, 0, 1, 'Ciudad de México');

-- Carpinteros
INSERT OR IGNORE INTO service_providers (user_id, service_categories, keywords, experience_years, rating, total_services, is_verified, is_available, city)
VALUES 
(2, '[8]', 'carpintería, carpintero, muebles, madera, reparación muebles, closets, cocinas integrales, puertas, marcos, barnizado, lijado, ensamble, medidas, domicilio, restauración', 6, 4.5, 80, 0, 1, 'Guadalajara');

-- Pintores
INSERT OR IGNORE INTO service_providers (user_id, service_categories, keywords, experience_years, rating, total_services, is_verified, is_available, city)
VALUES 
(3, '[9]', 'pintura, pintor, interior, exterior, casas, departamentos, oficinas, colores, acabados, texturas, impermeabilización, resanes, brocha, rodillo, domicilio, presupuesto', 5, 4.4, 90, 0, 1, 'Monterrey');

-- Servicios de belleza
INSERT OR IGNORE INTO service_providers (user_id, service_categories, keywords, experience_years, rating, total_services, is_verified, is_available, city)
VALUES 
(1, '[10]', 'belleza, estética, corte cabello, peinado, maquillaje, manicure, pedicure, facial, cejas, pestañas, domicilio, novias, eventos, cuidado personal, tratamientos', 4, 4.7, 200, 0, 1, 'Cancún');

-- ========================================
-- Consultas útiles para búsqueda por palabras clave
-- ========================================

-- Buscar prestadores por palabra clave
-- SELECT sp.*, u.name, u.phone, sc.name as service_name 
-- FROM service_providers sp
-- JOIN users u ON sp.user_id = u.id
-- JOIN service_categories sc ON JSON_EXTRACT(sp.service_categories, '$[0]') = sc.id
-- WHERE sp.keywords LIKE '%palabra_clave%' 
-- AND sp.is_verified = 1 
-- AND sp.is_available = 1
-- AND u.is_active = 1;

-- Buscar prestadores por ciudad
-- SELECT sp.*, u.name, u.phone 
-- FROM service_providers sp
-- JOIN users u ON sp.user_id = u.id
-- WHERE sp.city = 'Ciudad de México' 
-- AND sp.is_verified = 1 
-- AND sp.is_available = 1;

-- Estadísticas de palabras clave más comunes
-- SELECT 
--     TRIM(keyword) as keyword,
--     COUNT(*) as frequency
-- FROM (
--     SELECT 
--         TRIM(SUBSTR(keywords, instr(',' || keywords, ',') + 1, 
--              CASE WHEN instr(keywords, ',') > 0 
--                   THEN instr(keywords, ',') - 1 
--                   ELSE LENGTH(keywords) END)) as keyword
--     FROM service_providers
--     WHERE keywords IS NOT NULL
-- ) 
-- GROUP BY keyword 
-- ORDER BY frequency DESC;

-- ========================================
-- Índices para optimizar búsquedas
-- ========================================

-- Crear índice para búsquedas por palabras clave
CREATE INDEX IF NOT EXISTS idx_service_providers_keywords ON service_providers(keywords);

-- Crear índice para búsquedas por ciudad
CREATE INDEX IF NOT EXISTS idx_service_providers_city ON service_providers(city);

-- Crear índice compuesto para búsquedas complejas
CREATE INDEX IF NOT EXISTS idx_service_providers_active ON service_providers(is_verified, is_available, city);