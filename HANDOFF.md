# Handoff Entia CMS

## Estado actual

Entia CMS esta en la fase administrativa base del MVP. El proyecto usa Laravel 13, Blade, TailwindCSS 4, SQLite y Pest.

Rama actual:

```txt
feat/media-library
```

Ultimo commit de feature:

```txt
dc23272 feat: agregar biblioteca de media
```

Rama remota:

```txt
origin/feat/media-library
```

Pull request sugerido por GitHub:

```txt
https://github.com/rocouv/entia-cms/pull/new/feat/media-library
```

## Funcionalidades implementadas

- Base Laravel con autenticacion administrativa.
- Roles iniciales: `administrador` y `editor`.
- Dashboard protegido en `/dashboard`.
- Configuracion general del sitio en `/dashboard/settings`.
- Gestion de usuarios en `/dashboard/users`.
- Administradores pueden crear editores.
- Administradores pueden editar informacion de cualquier usuario: nombre, correo y contrasena opcional.
- Administradores pueden eliminar usuarios editores.
- Administradores no pueden eliminar usuarios administradores desde la pantalla de usuarios.
- Editores no pueden acceder a configuracion critica ni gestion de usuarios.
- Media basica en `/dashboard/media`.
- Usuarios autenticados del dashboard pueden listar, subir y eliminar media.
- Los archivos se guardan en disco `public`, dentro de `storage/app/public/media`.
- La tabla `media` guarda `site_id`, `user_id`, `disk`, `path`, `original_name`, `mime_type`, `size` y `alt_text`.
- Las URLs publicas de media usan `asset('storage/...')` para respetar el host/puerto actual del request.

## Verificaciones recientes

Ejecutadas antes de publicar `feat/media-library`:

```bash
composer test
./vendor/bin/pint --test
npm run build
```

Resultado:

- `composer test`: 21 tests pasan.
- `./vendor/bin/pint --test`: pasa.
- `npm run build`: pasa.
- `php artisan migrate`: migracion `media` aplicada localmente.

## Siguiente paso recomendado

Implementar paginas administrables del dashboard.

Objetivo:

- Crear modulo `/dashboard/pages`.
- Permitir listar, crear, editar y eliminar paginas.
- Soportar pagina home administrable con `is_home`.
- Soportar publicacion con `is_published`.
- Soportar navegacion publica con `show_in_navigation`, `navigation_label` y `sort_order`.
- Preparar campos SEO basicos: `meta_title` y `meta_description`.
- Dejar la base lista para asociar secciones dinamicas en el siguiente paso.

Alcance sugerido para el primer corte:

- Migracion `pages` con `site_id`, `title`, `slug`, `excerpt`, `body` nullable, `is_home`, `is_published`, `show_in_navigation`, `navigation_label`, `sort_order`, `meta_title`, `meta_description` y timestamps.
- Modelo `Page` con relacion a `Site`, casts booleanos y helpers/scopes simples si aportan claridad.
- Factory `PageFactory`.
- Controller simple en `app/Http/Controllers/Dashboard/PageController.php`.
- Form Requests para crear y actualizar paginas.
- Vistas Blade `index`, `create` y `edit` en `resources/views/dashboard/pages`.
- Ruta protegida bajo `auth` en `/dashboard/pages`.
- Tests Feature con Pest para acceso, creacion, edicion, validacion de slug unico por sitio y bloqueo de usuarios no autenticados.

Decisiones para mantener:

- No implementar secciones dentro del primer corte de paginas; las secciones van en la siguiente feature.
- No crear constructor visual ni drag and drop todavia.
- No renderizar paginas publicas todavia salvo que la feature lo pida explicitamente; primero cerrar administracion.
- Mantener `slug` manual o derivado de titulo de forma simple, sin resolver multisitio por dominio.
- Mantener compatibilidad SQLite/MySQL y evitar SQL especifico del motor.

## Pendientes despues de paginas

- Secciones dinamicas.
- Render publico con Blade.
- Servicios y proyectos.
- Formulario publico de contacto con Resend.
- Checklist de despliegue con SQLite, backups, storage persistente y SSL.

## Notas operativas

- `main` remoto ya contiene configuracion general y gestion de usuarios.
- Antes del siguiente modulo, crear rama desde `origin/main` o desde la rama integrada aprobada.
- No commitear `.env`, bases SQLite con datos locales, `vendor`, `node_modules` ni artefactos privados de storage.
- Si se prueba media localmente, ejecutar `php artisan storage:link` si `public/storage` no existe.
