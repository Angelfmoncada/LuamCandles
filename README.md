# Luam Candles - E-Commerce Platform

Luam Candles es una plataforma de comercio electrónico desarrollada en PHP con arquitectura MVC para la venta de velas artesanales. El sistema incluye gestión de productos, carrito de compras, procesamiento de pagos con PayPal Sandbox, y un panel de administración completo.

## Características

- **Catálogo de Productos**: Visualización de productos con imágenes, descripciones y precios
- **Carrito de Compras**: Gestión completa de productos (agregar, actualizar cantidad, eliminar)
- **Autenticación de Usuarios**: Sistema de registro e inicio de sesión con roles (admin/cliente)
- **Procesamiento de Pagos**: Integración con PayPal Sandbox para pagos seguros
- **Historial de Pedidos**: Los usuarios pueden ver sus pedidos anteriores
- **Panel de Administración**:
  - Gestión de productos (crear, editar, eliminar)
  - Visualización de pedidos
  - Logs de transacciones PayPal
  - Dashboard con estadísticas
- **Protección CSRF**: Tokens de seguridad en formularios
- **Diseño Responsive**: UI moderna con Bootstrap 5.3 y Bootstrap Icons
- **Containerización**: Despliegue completo con Docker

## Tecnologías Utilizadas

### Backend
- **PHP 7.4** (Apache)
- **MySQL 5.7**
- **PDO** para conexiones a base de datos
- **Arquitectura MVC** personalizada sin frameworks

### Frontend
- **Bootstrap 5.3**
- **Bootstrap Icons**
- **JavaScript** (Vanilla JS)
- **PayPal JavaScript SDK**

### DevOps
- **Docker & Docker Compose**
- **PHPMyAdmin** para gestión de base de datos

## Estructura del Proyecto

```
proyectofinalNW/
├── app/
│   ├── config/
│   │   ├── config.php              # Configuración general de la aplicación
│   │   └── Database.php            # Clase de conexión PDO a MySQL
│   ├── controllers/
│   │   ├── Admin.php               # Controlador del panel de administración
│   │   ├── Cart.php                # Controlador del carrito de compras
│   │   ├── Orders.php              # Controlador de pedidos
│   │   ├── Pages.php               # Controlador de páginas públicas
│   │   ├── Payments.php            # Controlador de pagos PayPal
│   │   ├── Products.php            # Controlador de productos
│   │   └── Users.php               # Controlador de autenticación
│   ├── core/
│   │   ├── App.php                 # Router principal de la aplicación
│   │   └── Controller.php          # Controlador base
│   ├── helpers/
│   │   ├── Csrf.php                # Helper para protección CSRF
│   │   ├── Env.php                 # Helper para leer variables .env
│   │   └── session_helper.php      # Funciones de sesión y flash messages
│   ├── models/
│   │   ├── Order.php               # Modelo de pedidos
│   │   ├── Product.php             # Modelo de productos
│   │   └── User.php                # Modelo de usuarios
│   └── views/
│       ├── admin/                  # Vistas del panel admin
│       │   ├── index.php           # Dashboard principal
│       │   ├── details.php         # Detalles de pedidos
│       │   ├── paypal_logs.php     # Logs de PayPal
│       │   └── transacciones.php   # Historial de transacciones
│       ├── auth/
│       │   ├── login.php           # Vista de inicio de sesión
│       │   └── register.php        # Vista de registro
│       ├── cart/
│       │   ├── index.php           # Vista del carrito
│       │   └── checkout.php        # Vista de checkout con PayPal
│       ├── layouts/
│       │   ├── header.php          # Header con Bootstrap CDN
│       │   ├── footer.php          # Footer con scripts
│       │   ├── navbar.php          # Barra de navegación
│       │   └── sidebar.php         # Sidebar del admin
│       ├── orders/
│       │   ├── confirmation.php    # Confirmación de pedido
│       │   ├── details.php         # Detalles de pedido individual
│       │   └── history.php         # Historial de pedidos del usuario
│       ├── pages/
│       │   ├── index.php           # Página principal
│       │   └── about.php           # Página "Nosotros"
│       └── products/
│           ├── index.php           # Catálogo de productos
│           └── show.php            # Detalle de producto individual
├── public/
│   ├── assets/
│   │   └── img/                    # Imágenes de productos
│   ├── css/                        # Hojas de estilo CSS
│   ├── css_src/                    # Archivos LESS fuente
│   ├── imgs/
│   │   └── hero/                   # Imágenes hero del inicio
│   ├── .htaccess                   # Configuración Apache
│   └── index.php                   # Punto de entrada de la aplicación
├── .env                            # Variables de entorno
├── docker-compose.yml              # Configuración de servicios Docker
├── Dockerfile                      # Imagen personalizada PHP + Apache
├── setup.sql                       # Script de inicialización de BD
└── README.md                       # Este archivo

```

## Prerequisitos

- **Docker** (v20.10+)
- **Docker Compose** (v2.0+)
- Cuenta de **PayPal Sandbox** (para pruebas de pago)

## Instalación y Configuración

### 1. Clonar el Repositorio

```bash
git clone <repository-url>
cd proyectofinalNW
```

### 2. Configurar Variables de Entorno

El archivo `.env` ya está configurado con valores por defecto. Verifica y ajusta si es necesario:


```

**Importante**: Para habilitar pagos, debes configurar tus credenciales de PayPal Sandbox.

### 3. Construir y Levantar los Contenedores

```bash
# Construir la imagen
docker-compose build

# Levantar los servicios
docker-compose up -d
```

Esto iniciará tres servicios:
- **app**: Servidor web PHP 7.4 con Apache (Puerto: 8081)
- **db**: Base de datos MySQL 5.7 (Puerto: 3306)
- **phpmyadmin**: Administrador de BD (Puerto: 8082)

### 4. Verificar el Estado de los Contenedores

```bash
docker-compose ps
```

Todos los servicios deben estar en estado "Up".

### 5. Inicializar la Base de Datos

La base de datos se inicializa automáticamente con el archivo `setup.sql` al crear el contenedor por primera vez. Este script crea:

- Tabla `users` (usuarios del sistema)
- Tabla `products` (catálogo de productos)
- Tabla `orders` (pedidos realizados)
- Tabla `order_details` (items de cada pedido)
- Tabla `paypal_logs` (logs de transacciones PayPal)
- Tabla `transacciones` (registro de pagos completados)
- Datos de ejemplo (productos y usuario admin)

## Acceso a la Aplicación

### URLs de Acceso

- **Aplicación Web**: http://localhost:8081
- **mysql**: http://localhost:8082
  - Usuario: `root`
  - Contraseña: `root`

### Credenciales por Defecto

**Usuario Administrador**:
- Email: `admin@luamcandles.com`
- Contraseña: `admin123`

**Usuario Cliente** (ejemplo):
- Puedes crear uno desde http://localhost:8081/users/register

## Uso de la Aplicación

### Para Clientes

1. **Registrarse**: Ir a "Registrarse" en la navbar
2. **Navegar Productos**: Ver el catálogo en la página principal
3. **Añadir al Carrito**: Hacer clic en "Añadir al Carrito" en cualquier producto
4. **Ver Carrito**: Clic en el icono del carrito (muestra cantidad de items)
5. **Realizar Compra**:
   - Ir al carrito y hacer clic en "Proceder al Pago"
   - Ingresar dirección de envío
   - Completar el pago con PayPal Sandbox
6. **Ver Pedidos**: Acceder a "Mis Pedidos" desde el menú de usuario

### Para Administradores

1. **Iniciar Sesión**: Usar las credenciales de admin
2. **Acceder al Panel**: Clic en "Panel Admin" en el dropdown del usuario
3. **Gestionar Productos**:
   - Ver todos los productos
   - Agregar nuevos productos
   - Editar productos existentes
   - Eliminar productos
4. **Ver Pedidos**: Revisar todos los pedidos del sistema
5. **Logs PayPal**: Monitorear transacciones y errores de PayPal
6. **Transacciones**: Ver historial completo de pagos





### Cuentas de Prueba PayPal

En el PayPal Developer Dashboard, encontrarás cuentas sandbox de prueba:
- **Business Account**: Para recibir pagos
- **Personal Account**: Para realizar pagos

Puedes usar estas cuentas para simular transacciones completas.

## Base de Datos

### Estructura de Tablas Principales

**users**
- `id`, `name`, `email`, `password`, `role` (admin/user), `created_at`

**products**
- `id`, `name`, `description`, `price`, `stock`, `image`, `created_at`

**orders**
- `id`, `user_id`, `total_amount`, `shipping_address`, `payment_method`, `transaction_id`, `status`, `created_at`

**order_details**
- `id`, `order_id`, `product_id`, `quantity`, `price`

**paypal_logs**
- `id`, `order_id`, `transaction_id`, `event_type`, `response`, `created_at`

**transacciones**
- `id`, `transaction_id`, `cliente_nombre`, `cliente_email`, `monto`, `estado`, `paypal_data`, `created_at`

## Comandos Docker Útiles


## Seguridad

- **Protección CSRF**: Todos los formularios incluyen tokens CSRF
- **Passwords Hasheados**: Se usa `password_hash()` de PHP
- **Preparación de Consultas**: PDO con prepared statements previene SQL injection
- **Validación de Sesiones**: Verificación de autenticación en rutas protegidas
- **Sanitización de Entradas**: Filtrado de datos POST con `filter_input_array()`


### Rutas

El sistema de rutas funciona con URL amigables:
- `/` → Página principal (productos)
- `/users/login` → Inicio de sesión
- `/users/register` → Registro
- `/cart` → Carrito de compras
- `/orders/checkout` → Checkout
- `/orders/history` → Historial de pedidos
- `/admin` → Panel administrativo

