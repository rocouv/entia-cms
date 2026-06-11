# Handoff Entia CMS

## Estado actual

Entia CMS esta en la fase administrativa base del MVP. El proyecto usa Laravel 13, Blade, TailwindCSS 4, SQLite y Pest.

Rama actual:

```txt
feat/pages-management
```

Ultimo commit de feature:

```txt
99f3c5c feat: agregar gestion de paginas
```

Rama remota:

```txt
origin/feat/pages-management
```

Pull request sugerido por GitHub:

```txt
https://github.com/rocouv/entia-cms/pull/new/feat/pages-management
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
- Paginas administrables en `/dashboard/pages`.
- Usuarios autenticados del dashboard pueden listar, crear, editar y eliminar paginas.
- La tabla `pages` guarda `site_id`, `title`, `slug`, `excerpt`, `body`, `is_home`, `is_published`, `show_in_navigation`, `navigation_label`, `sort_order`, `meta_title` y `meta_description`.
- El slug se normaliza automaticamente desde el titulo si queda vacio.
- El slug es unico por sitio.
- Solo una pagina puede quedar marcada como home por sitio.

## Verificaciones recientes

Ejecutadas antes de commitear `feat/pages-management`:

```bash
composer test
./vendor/bin/pint --test
npm run build
```

Resultado:

- `composer test`: 28 tests pasan.
- `./vendor/bin/pint --test`: pasa.
- `npm run build`: pasa.
- `php artisan migrate`: migracion `pages` aplicada localmente.

## Siguiente paso recomendado

Implementar secciones dinamicas del dashboard.

Objetivo:

- Crear modulo de secciones asociado a paginas.
- Permitir listar secciones de una pagina.
- Permitir crear, editar, ocultar/mostrar y eliminar secciones.
- Soportar orden manual con `sort_order`.
- Guardar contenido editable en JSON `content` y configuracion visual/comportamiento en JSON `settings`.
- Empezar con tipos iniciales simples: `hero`, `text_block`, `image_text`, `cards`, `gallery`, `services`, `projects`, `contact` y `faq`.
- Preparar las vistas Blade futuras para render publico por tipo, sin implementar todavia el render publico completo.

Alcance sugerido para el primer corte:

- Migracion `sections` con `page_id`, `type`, `content`, `settings`, `sort_order`, `is_visible` y timestamps.
- Modelo `Section` con relacion a `Page`, casts JSON/booleanos y helper para nombre legible del tipo si aporta claridad.
- Factory `SectionFactory`.
- Controller simple en `app/Http/Controllers/Dashboard/SectionController.php`.
- Form Requests para crear y actualizar secciones.
- Rutas anidadas bajo paginas: `/dashboard/pages/{page}/sections`.
- Vistas Blade `index`, `create` y `edit` en `resources/views/dashboard/sections`.
- Formularios simples por tipo usando Blade, sin constructor visual.
- Tests Feature con Pest para acceso, creacion, edicion, visibilidad, orden, pertenencia a pagina y bloqueo de usuarios no autenticados.

Decisiones para mantener:

- No crear tablas separadas por cada tipo de seccion durante el MVP.
- No crear constructor visual ni drag and drop todavia.
- No renderizar secciones publicamente todavia salvo que la feature lo pida explicitamente; primero cerrar administracion.
- Mantener formularios amigables para usuarios no tecnicos.
- Mantener compatibilidad SQLite/MySQL y evitar SQL especifico del motor.

## Pendientes despues de secciones

- Render publico con Blade.
- Servicios y proyectos.
- Formulario publico de contacto con Resend.
- Checklist de despliegue con SQLite, backups, storage persistente y SSL.

## Notas operativas

- `main` remoto ya contiene configuracion general, gestion de usuarios y media.
- Antes del siguiente modulo, crear rama desde `origin/main` o desde la rama integrada aprobada.
- No commitear `.env`, bases SQLite con datos locales, `vendor`, `node_modules` ni artefactos privados de storage.
- Si se prueba media localmente, ejecutar `php artisan storage:link` si `public/storage` no existe.
