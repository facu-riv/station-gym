# Entrega TPE 2 - Station Gym

## Integrantes
- Gamondi Samuel (samuelgamondi01@gmail.com).
- Rivarola Facundo Uriel (rivarolauriel2002@gmail.com).

## Temática
Sitio web dinámico de un gimnasio donde se listan **actividades** (entrenamientos, clases) clasificadas por **tipos** (por ejemplo: gimnasia, baile).

## Descripción general
El sistema permite:
- Ver todas las actividades y sus categorías.
- Ver las actividades pertenecientes a un tipo.
- Panel de administración con login (`webadmin / admin`) para crear, editar o eliminar actividades y tipos.
- Cargar imágenes por URL.

## Estructura general (MVC)
- `/public/index.php`: Router principal 
- `/app/controllers/`: Controladores de lógica
- `/app/views/`: Vistas HTML con plantillas 
- `/init_db.php`: Crea y llena la base de datos si no existe
- `/config.php`: Parámetros de conexión y BASE_URL

## Instalación
1. Colocar la carpeta del proyecto en `htdocs` o carpeta pública del servidor local.
2. Crear una base vacía (por ejemplo `station_gym`) en phpMyAdmin.
3. Ingresar a `http://localhost/station-gym/public/`.
4. Si la base no existe, se crea automáticamente.
5. Login admin: **usuario:** `webadmin` / **contraseña:** `admin`.

## DER
El siguiente diagrama muestra la relación 1–N entre las entidades principales:
![Diagrama Entidad-Relación](der.jpg)

## Modelo de datos (resumen)
- **tipos**: `id`, `nombre`
- **actividades**: `id`, `nombre`, `descripcion`, `imagen`, `tipo_id`
- **usuarios**: `id`, `username`, `password_hash`, `rol`

Relación: **1 tipo → N actividades**

## Archivo SQL

[Descargar base de datos (station_gym.sql)](station_gym_db.sql)