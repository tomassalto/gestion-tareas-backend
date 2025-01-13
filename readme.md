# Sistema de Gestión de Tareas con Usuarios Múltiples - Backend

Este es el backend del Sistema de Gestión de Tareas con Usuarios Múltiples, desarrollado con Laravel 11 y utilizando varias herramientas adicionales como Sanctum para autenticación y Spatie para gestión de permisos.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado en tu sistema:

- [PHP](https://www.php.net/) >= 8.2
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [Xampp](https://www.apachefriends.org/es/index.html)

## Instalación

1. Crear una carpeta dentro de la carpeta "htdocs" del Xampp. Donde clonaremos el frontend y el backend. Dejo un ejemplo debajo:

   ```bash
   C:/xampp/htdocs/sistema-tareas
   ```

2. Clona el repositorio frontend (si aun no lo has hecho):

     ```bash
      git clone https://github.com/tomassalto/sistema-gestion-tareas-frontend.git
   
      cd sistema-gestion-tareas-frontend/template-reactjs-modernizacion
      ```

3. Clona el repositorio backend:

     ```bash
      git clone https://github.com/tomassalto/sistema-gestion-tareas-backend.git
   
      cd sistema-gestion-tareas-backend/gestion-tareas
      ```

4. Tener instalada esta extension para levantar el proyecto:
   ```bash
   sudo apt install php-xml xampp
   ```
5. Instala las dependencias de PHP:

   ```bash
   composer install
   ```

6. Copia el archivo de entorno y configúralo:

   ```bash
   cp .env.example .env
   ```

   Configura las credenciales de tu base de datos en el archivo `.env`.

7. Genera la clave de la aplicación:

   ```bash
   php artisan key:generate
   ```

8. En el archivo `.env` la configuración de la base de datos debería verse así:

   ```bash
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gestion_tareas
   DB_USERNAME=root
   DB_PASSWORD=
   ```

9. Abre un programa o gestor de base de datos, como MySQL Workbench o phpMyAdmin, y crea una base de datos llamada gestion_tareas. Para lenguaje SQL la linea de comandos sería:

```bash
CREATE DATABASE gestion_tareas;
```

10. Ejecuta las migraciones y los seeders:

```bash
php artisan migrate --seed
```

11. Levanta el servidor de desarrollo:

    ```bash
    php artisan serve
    ```

El backend estará disponible en `http://127.0.0.1:8000`.

## Paquetes Principales

- **[laravel/sanctum](https://laravel.com/docs/11.x/sanctum):** Para autenticación API.
- **[spatie/laravel-permission](https://spatie.be/docs/laravel-permission):** Para gestión avanzada de permisos y roles.
- **[laravel/breeze](https://laravel.com/docs/11.x/starter-kits#breeze):** Generación de código inicial para autenticación.
