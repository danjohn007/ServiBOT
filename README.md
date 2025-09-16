# ServiBOT - Plataforma de Servicios a Domicilio

ServiBOT es una plataforma completa para conectar clientes con prestadores de servicios a domicilio. Construida con PHP puro, MySQL/SQLite y Bootstrap 5 para ofrecer una experiencia moderna y confiable.

## 🚀 Características Principales

### Roles de Usuario
- **Superadmin**: Gestión completa del sistema, franquicias, y configuración
- **Cliente**: Solicitar servicios, seguimiento en tiempo real, calificaciones
- **Prestador**: Recibir solicitudes, gestionar disponibilidad, completar servicios

### Funcionalidades Clave
- ✅ Sistema de autenticación con roles
- ✅ Panel de control personalizado por rol
- ✅ Diseño responsivo con Bootstrap 5
- ✅ Base de datos SQLite/MySQL
- ✅ URL amigables y enrutamiento MVC
- ✅ Validación de formularios
- ✅ Sistema de notificaciones
- 🔄 Geolocalización y mapas (próximamente)
- 🔄 Pasarelas de pago (próximamente)
- 🔄 Sistema de calificaciones (próximamente)

## 📋 Requisitos del Sistema

- **PHP**: 7.4 o superior
- **Servidor Web**: Apache con mod_rewrite
- **Base de Datos**: MySQL 5.7+ o SQLite (automático)
- **Extensiones PHP**: 
  - PDO
  - PDO_MYSQL (opcional)
  - PDO_SQLITE
  - mbstring
  - json

## 🛠️ Instalación

### Instalación Rápida

1. **Clona el repositorio**
   ```bash
   git clone https://github.com/danjohn007/ServiBOT.git
   cd ServiBOT
   ```

2. **Configura el servidor web**
   - Apunta tu servidor Apache al directorio del proyecto
   - Asegúrate de que mod_rewrite esté habilitado

3. **Configura la base de datos**
   
   **Opción A: SQLite (Automático - Recomendado para desarrollo)**
   ```bash
   # SQLite se configura automáticamente
   php test_connection.php
   ```

   **Opción B: MySQL**
   ```bash
   # 1. Crear base de datos
   mysql -u root -p
   CREATE DATABASE servibot_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   
   # 2. Ejecutar esquema
   mysql -u root -p servibot_db < database/schema.sql
   mysql -u root -p servibot_db < database/sample_data.sql
   
   # 3. Configurar credenciales en app/config/database.php
   ```

4. **Configurar permisos**
   ```bash
   chmod 755 public/
   chmod 755 storage/
   chmod 755 database/
   chmod 666 database/servibot.sqlite  # si usas SQLite
   ```

5. **Probar la instalación**
   ```bash
   # Usar servidor de desarrollo de PHP
   cd public
   php -S localhost:8000
   
   # O acceder via navegador a tu dominio
   ```

### Configuración Manual de Base de Datos SQLite

Si necesitas configurar manualmente la base de datos SQLite:

```bash
# Crear estructura
sqlite3 database/servibot.sqlite < database/sqlite_schema.sql

# Agregar datos de ejemplo
sqlite3 database/servibot.sqlite "
INSERT INTO users (email, password, role, name, phone) VALUES 
('admin@servibot.com', '\$2y\$10\$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'superadmin', 'Administrador', '555-0100');
"
```

## 🔧 Configuración

### Variables de Configuración

Edita `app/config/database.php` para configurar la conexión a la base de datos:

```php
// Configuración MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'servibot_db');
define('DB_USER', 'tu_usuario');
define('DB_PASS', 'tu_contraseña');
```

### URL Base

La URL base se detecta automáticamente, pero puedes configurarla manualmente en `app/config/config.php`:

```php
define('BASE_URL', 'https://tu-dominio.com/');
```

## 👥 Cuentas por Defecto

### Administrador
- **Email**: admin@servibot.com
- **Contraseña**: password
- **Rol**: Superadmin

### Clientes de Prueba
```sql
-- Puedes crear cuentas de prueba
INSERT INTO users (email, password, role, name) VALUES 
('cliente@test.com', '$2y$10$92IXUNpkjO0rOQ...', 'cliente', 'Cliente Prueba'),
('prestador@test.com', '$2y$10$92IXUNpkjO0rOQ...', 'prestador', 'Prestador Prueba');
```

## 📁 Estructura del Proyecto

```
ServiBOT/
├── .htaccess                 # Redirección a public/
├── README.md                # Este archivo
├── test_connection.php      # Prueba de configuración
├── app/
│   ├── config/             # Configuración
│   │   ├── config.php      # Configuración general
│   │   └── database.php    # Configuración de BD
│   ├── controllers/        # Controladores MVC
│   │   ├── basecontroller.php
│   │   ├── homecontroller.php
│   │   ├── authcontroller.php
│   │   ├── admincontroller.php
│   │   ├── clientcontroller.php
│   │   └── providercontroller.php
│   ├── models/             # Modelos de datos
│   │   └── user.php
│   └── views/              # Vistas/Templates
│       ├── layout/         # Plantillas base
│       ├── home/           # Páginas públicas
│       ├── auth/           # Autenticación
│       ├── admin/          # Panel administración
│       ├── client/         # Panel cliente
│       ├── provider/       # Panel prestador
│       └── errors/         # Páginas de error
├── public/                 # Directorio público
│   ├── index.php          # Punto de entrada
│   ├── .htaccess          # Configuración Apache
│   └── assets/            # Recursos estáticos
│       ├── css/           # Estilos CSS
│       ├── js/            # JavaScript
│       └── images/        # Imágenes
├── database/              # Base de datos
│   ├── schema.sql         # Esquema MySQL
│   ├── sample_data.sql    # Datos de ejemplo
│   └── servibot.sqlite    # Base de datos SQLite
└── storage/               # Almacenamiento
    ├── logs/              # Archivos de log
    └── cache/             # Cache temporal
```

## 🌐 URLs del Sistema

### Páginas Públicas
- `/` - Página de inicio
- `/auth/login` - Iniciar sesión
- `/auth/register` - Registrarse
- `/services` - Catálogo de servicios

### Paneles de Usuario
- `/admin` - Panel de administración
- `/client/dashboard` - Panel del cliente
- `/provider/dashboard` - Panel del prestador

### Herramientas
- `/test_connection.php` - Prueba de configuración

## 🔐 Seguridad

- Passwords hasheados con `password_hash()`
- Protección CSRF en formularios
- Validación de entrada de datos
- Sesiones seguras
- SQL preparado (PDO)
- Sanitización de datos

## 🐛 Solución de Problemas

### Error de Conexión a Base de Datos
```bash
# Verificar configuración
php test_connection.php

# Verificar permisos SQLite
ls -la database/servibot.sqlite
chmod 666 database/servibot.sqlite
```

### Error 404 en URLs
```bash
# Verificar mod_rewrite
sudo a2enmod rewrite
sudo systemctl restart apache2

# Verificar .htaccess
cat .htaccess
cat public/.htaccess
```

### Problemas de Permisos
```bash
# Configurar permisos correctos
chmod -R 755 public/
chmod -R 775 storage/
chmod -R 775 database/
```

## 📚 Desarrollo

### Agregar Nuevos Controladores
1. Crear archivo en `app/controllers/`
2. Extender `BaseController`
3. Implementar métodos de acción
4. Crear vistas correspondientes

### Agregar Nuevos Modelos
1. Crear archivo en `app/models/`
2. Implementar métodos CRUD
3. Usar PDO para consultas

### Personalizar Diseño
- Editar `public/assets/css/style.css`
- Modificar plantillas en `app/views/layout/`
- Usar clases de Bootstrap 5

## 🤝 Contribuir

1. Fork del proyecto
2. Crear rama para feature (`git checkout -b feature/nueva-funcionalidad`)
3. Commit cambios (`git commit -am 'Agregar nueva funcionalidad'`)
4. Push a la rama (`git push origin feature/nueva-funcionalidad`)
5. Crear Pull Request

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver archivo `LICENSE` para más detalles.

## 📞 Soporte

- **Issues**: GitHub Issues
- **Email**: contacto@servibot.com
- **Documentación**: Wiki del proyecto

---

**ServiBOT** - Conectando especialistas con clientes de manera eficiente y segura.
