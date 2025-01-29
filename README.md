# API REST Tienda

## Descripción

Esta es una API RESTful desarrollada en PHP siguiendo el patrón MVC. Implementa autenticación con JWT para los métodos que modifican datos y permite la gestión de productos y fabricantes. Además, la API está desplegada en un **VPS con Ubuntu y Apache**.

## Características principales 🚀

- Uso del patrón MVC con Namespaces y Autoloader de Composer.
- Autenticación con **JWT**.
- Validaciones de datos.
- Endpoints para gestionar productos y fabricantes.
- Seguridad controlando la autenticación a través del token almacenado en la base de datos.
- Desplegado en un servidor VPS con **Ubuntu y Apache**.

## Instalación 🔧

1. Clonar el repositorio:
   ```sh
   git clone https://github.com/dsmdev-tech/API-REST-Tienda.git
   cd tu_repositorio
   ```
2. Instalar dependencias con Composer:
   ```sh
   composer install
   ```
3. Crear la base de datos.
4. Configura el acceso a la base de datos en el archivo config.php.
5. Configurar Apache para que el dominio apunte al **public/** del proyecto.
6. Dar permisos adecuados a la carpeta de logs y caché.
7. Iniciar el servidor Apache y probar la API. 🚀

## Endpoints disponibles 📡

### **Autenticación**

- **Registro:** `POST /auth/signup`
- **Login:** `POST /auth/login`
- **Logout:** `POST /auth/logout`

### **Productos**

- **Obtener todos los productos:** `GET /products`
- **Obtener un producto:** `GET /products/{id}`
- **Insertar un producto:** `POST /products` 🔒 (requiere JWT)
- **Actualizar un producto:** `PUT /products/{id}` 🔒 (requiere JWT)
- **Eliminar un producto:** `DELETE /products/{id}` 🔒 (requiere JWT)

### **Fabricantes**

- **Obtener todos los fabricantes:** `GET /manufacturers`

## Seguridad 🔑

- Los métodos **POST, PUT y DELETE** requieren autenticación mediante un token JWT.
- Los tokens se almacenan en la base de datos y se verifican en cada petición.

## Despliegue en VPS 🌍

- Servidor: **Ubuntu + Apache**
- Base de datos: **MySQL**
- Configuración en **Virtual Host** para servir la API correctamente.

##

##

