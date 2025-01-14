# Sistema de Gestión de Tareas con Usuarios Múltiples - Backend

Este es el backend del Sistema de Gestión de Tareas con Usuarios Múltiples, desarrollado con Laravel 11 y utilizando varias herramientas adicionales como Sanctum para autenticación y Spatie para gestión de permisos.

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado en tu sistema:

- [PHP](https://www.php.net/) >= 8.2
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [Xampp](https://www.apachefriends.org/es/index.html) o [Docker](https://docs.docker.com/desktop/setup/install/windows-install/)

## Instalación con XAMPP

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
    git clone https://github.com/tomassalto/gestion-tareas-backend.git

    cd gestion-tareas-backend/gestion-tareas
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

## Instalación con Docker

1. Iniciar el motor de Docker

2. Clonar repositorio en una nueva carpeta (donde también debe estar el repositorio frontend clonado) y cambiar a la rama "docker-container"

   ```bash
   git clone https://github.com/tomassalto/gestion-tareas-backend.git

   cd gestion-tareas-backend

   git switch docker-container
   ```

3. Move los archivos `docker-compose.yml` y `gestion_tareas.sql` a la carpeta principal donde clonaste los repositorios backend y frontend.

4. Copia el archivo de entorno dentro de la carpeta `gestion-tareas` y configúralo:

   ```bash
   cd gestion-tareas

   cp .env.example .env
   ```

   Configura las credenciales de tu base de datos en el archivo `.env`.

5. En el archivo `.env` la configuración de la base de datos debería verse así:

   ```bash
   DB_CONNECTION=mysql
   DB_HOST=db
   DB_PORT=3306
   DB_DATABASE=gestion_tareas
   DB_USERNAME=user
   DB_PASSWORD=password
   ```

6. Una vez hecho esto, y si en el repositorio frontend ya realizaste los pasos de clonar el repositorio y cambiar a la rama `docker-container`. Regresar a la carpeta principal donde estan los dos repositorios clonados y ejecutar el comando (cuidado: el readme de fronted tiene el mismo paso que este, NO realizar 2 veces)::

   ```bash
    docker-compose up --build
   ```

7. Ingresar a la URL: `http://localhost:5173/apps/template/#/register` para realizar las funcionalidades del sitio.

8. Para poder ingresar a los usuarios creados automaticamente por las seeders de Laravel, abrir MySQL Workbench por ejemplo y crear una nueva conexión con los datos de la imagen, la contraseña es `password`.

   [![image.png](https://i.postimg.cc/RCGR5nK3/image.png)](https://postimg.cc/hhzxVvCg)

9. Buscar la tabla `users`. El primer registro creado tendrá el rol de usuario administrador y los 9 restantes tendra el rol de usuario estandar.

## Paquetes Principales

- **[laravel/sanctum](https://laravel.com/docs/11.x/sanctum):** Para autenticación API.
- **[spatie/laravel-permission](https://spatie.be/docs/laravel-permission):** Para gestión avanzada de permisos y roles.
- **[laravel/breeze](https://laravel.com/docs/11.x/starter-kits#breeze):** Generación de código inicial para autenticación.
