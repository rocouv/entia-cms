# Entia CMS

Entia CMS es un gestor de contenido para administrar sitios públicos desde un dashboard protegido. Permite crear y publicar páginas, secciones, media, categorías, servicios y proyectos.

## Funcionalidades

- Autenticación administrativa con perfiles **Administrador** y **Editor**.
- Páginas con slug, publicación, home, navegación y campos SEO.
- Secciones dinámicas: Hero, texto, imagen y texto, tarjetas, galería, servicios, proyectos, contacto y preguntas frecuentes.
- Biblioteca Media para imágenes y PDF de hasta 5 MB.
- Categorías, servicios y proyectos con publicación, destacados, orden e imágenes.
- Configuración general del cliente, sitio, contacto, SEO, logo, tipografía y colores.
- Formulario público de contacto con limitación de envíos y transporte de correo configurable.
- Despliegue preparado para Railway con SQLite persistente.

## Stack

- Laravel 13 y PHP 8.4.
- Blade y Tailwind CSS 4.
- Vite 8.
- SQLite.
- Pest para pruebas y Laravel Pint para formato.

## Requisitos

- PHP 8.4 o superior.
- Composer.
- Node.js y npm.
- SQLite habilitado para PHP.

## Instalación local

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
npm install
npm run build
```

Configura en `.env` la conexión SQLite y, para crear la primera cuenta, las variables `ENTIA_ADMIN_NAME`, `ENTIA_ADMIN_EMAIL`, `ENTIA_ADMIN_PASSWORD`, `ENTIA_CLIENT_NAME` y `ENTIA_SITE_NAME`. La contraseña inicial debe tener al menos 12 caracteres.

```bash
php artisan entia:install
```

Para cargar contenido ficticio únicamente en desarrollo:

```bash
php artisan db:seed --class=DemoContentSeeder
```

No ejecutes el seeder demo en producción.

## Desarrollo

```bash
composer dev
```

El comando inicia el servidor Laravel, el listener de colas, los logs y Vite. También puedes ejecutar solo `php artisan serve` y `npm run dev`.

## Pruebas y formato

```bash
./vendor/bin/pest tests/Feature
./vendor/bin/pint --test
npm run build
```

El comando `composer test` puede intentar cargar `tests/Unit`, que no existe actualmente. Para este proyecto usa la suite de Feature indicada arriba.

## Documentación para clientes

La documentación está en español y separada por nivel de detalle:

- [Guía de inicio rápido](docs/inicio-rapido.md): tareas habituales para comenzar.
- [Manual completo de usuario](docs/manual-de-usuario.md): permisos, módulos, campos, publicación, eliminación y problemas frecuentes.
- [Despliegue en Railway](docs/deploy-railway.md): operación técnica del entorno productivo.

Para regenerar los PDF desde los archivos Markdown:

```bash
composer docs
```

Los archivos resultantes se guardan en `docs/generated/`.

## Limitaciones conocidas del MVP

- No hay importación ni exportación de contenido.
- No hay papelera, historial editorial ni recuperación de contraseña desde la interfaz.
- La búsqueda del encabezado todavía no filtra contenido.
- El formulario de contacto no guarda mensajes dentro del dashboard.
- Eliminar Media puede romper referencias a imágenes existentes; eliminar una página también elimina sus secciones.

Consulta el [manual de usuario](docs/manual-de-usuario.md) antes de realizar eliminaciones o cambios de publicación.

## Despliegue

Entia incluye `Dockerfile.railway`, `railway.toml` y un script de arranque para Railway. La base SQLite y los archivos Media deben conservarse en un volumen persistente montado en `/data`.

Consulta [docs/deploy-railway.md](docs/deploy-railway.md) para variables, instalación inicial, correo, backups y verificaciones.

## Seguridad

- No subas `.env`, contraseñas, claves API, bases SQLite con datos reales ni archivos de Media privados.
- Mantén `APP_DEBUG=false` en producción.
- Usa contraseñas únicas y elimina las variables temporales de recuperación después de utilizarlas.
- Configura backups del volumen de producción.
