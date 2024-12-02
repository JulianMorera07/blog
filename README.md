# Blog Julian

## Descripción
Este proyecto es un sistema básico de gestión de usuarios y posts, desarrollado en Laravel para el backend y HTML/CSS/Jquery para el frontend.

## Características
- Registro y login de usuarios con validación y encriptación de contraseñas.
- Creación y visualización de posts (solo para usuarios autenticados).
- Uso de un frontend simple para interactuar con el sistema.

## Requisitos
- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL (o cualquier base de datos soportada por Laravel)

## Instalación
1. Clona el repositorio:
    ```bash
    git clone https://github.com/JulianMorera07/blog.git
    cd blog
    ```

2. Instala las dependencias de PHP:
    ```bash
    composer install
    ```

3. Instala las dependencias de Node.js:
    ```bash
    npm install
    ```

4. Configura el archivo `.env`:
    - Copia `.env.example` a `.env`:
        ```bash
        cp .env.example .env
        ```
    - Actualiza las credenciales de tu base de datos.

5. Genera la clave de la aplicación:
    ```bash
    php artisan key:generate
    ```

6. Crear y Migra las bases de datos:
    Para esto es importante antes de ejecutar crear las base datos y hacer la conexión en el archivo .env, hecho esto ejecutamos
    ```bash
    php artisan migrate
    ```

7. Sirve la aplicación:
    ```bash
    php artisan serve
    ```
8. Ejecutas en otra terminal el comando:
     ```bash
    npm run dev
    ```

9. Abre el frontend:
    - Una vez hecho el paso 7 y 8 ve a tu navegador favorito ingresa a la IP `127.0.0.1:8000/register` o `127.0.0.1:8000/login` si ya estas registrado.
   
10. Estas son las rutas que se pueden consumir por medio de postman en la IP local `127.0.0.1:8000/api` y por que metodo:
    - `get /categories`
    - `get /posts/{categoryId}`
    - `post /create-posts`
    - `post /create-category`
    - `get /users`
    - `post /create-register`
    - `post /sign-in`
    
11. Estas son las rutas que se pueden consumir por medio de la web en la IP local `127.0.0.1:8000` y por que metodo:
    - `get /posts`
    - `get /register`
    - `get /login`
    
12. Ejecución de los test
    - Para ejecutar los test: `php artisan test`

## Uso
- Accede al formulario de registro y login desde el frontend.
- Visualiza posts desde el frontend o usando herramientas como Postman.

## Autor
- **Julian Cogua Morera**
- [GitHub](https://github.com/JulianMorera07)

