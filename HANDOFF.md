# Handoff Entia CMS

## Estado actual

Entia CMS esta en la fase administrativa base del MVP. El proyecto usa Laravel 13, Blade, TailwindCSS 4, SQLite y Pest.

Rama actual:

```txt
feat/public-render
```

Ultimo commit de feature:

```txt
f282a78 feat: agregar render publico con Blade
```

Rama remota:

```txt
origin/feat/public-render
```

Pull request sugerido por GitHub:

```txt
https://github.com/rocouv/entia-cms/pull/new/feat/public-render
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
- Secciones dinamicas administrables en `/dashboard/pages/{page}/sections`.
- Usuarios autenticados del dashboard pueden listar, crear, editar, ocultar/mostrar y eliminar secciones de una pagina.
- La tabla `sections` guarda `page_id`, `type`, `content` (JSON), `settings` (JSON), `sort_order`, `is_visible` y timestamps.
- Tipos de seccion soportados: `hero`, `text_block`, `image_text`, `cards`, `gallery`, `services`, `projects`, `contact` y `faq`.
- El contenido editable se guarda en JSON `content` y la configuracion visual en JSON `settings`.
- Orden manual con `sort_order` y visibilidad controlada por `is_visible`.
- Formularios amigables por tipo de seccion en Blade, sin constructor visual ni drag and drop todavia.
- Render publico en la raiz del sitio (`/` y `/{slug}`).
- Pagina de inicio (`/`) cargada desde la pagina marcada como `is_home` en la base de datos.
- Pagina por slug (`/{slug}`) cargada desde `pages` con `is_published = true`.
- Layout publico en `resources/views/layouts/public.blade.php` con navegacion dinamica desde paginas publicadas con `show_in_navigation = true` y footer con datos del sitio.
- Navegacion automatica: ordenada por `sort_order`, usa `navigation_label` o `title`, enlace a `/` para la pagina home.
- Render de secciones por tipo desde `resources/views/sections/`:
  - `hero`: imagen de fondo opcional, titulo, subtitulo y boton CTA.
  - `text-block`: titulo y cuerpo de texto.
  - `image-text`: imagen y texto con posicion izquierda/derecha configurable.
  - `cards`: grilla de tarjetas con icono, titulo y descripcion.
  - `gallery`: grilla de imagenes con efecto hover.
  - `services`: placeholder con enlace al dashboard.
  - `projects`: placeholder con enlace al dashboard.
  - `contact`: seccion de contacto con placeholder de formulario.
  - `faq`: acordeon de preguntas y respuestas.
- Vista faltante no rompe la pagina; solo muestra mensaje de debug en entorno local.
- SEO basico: `meta_title` y `meta_description` desde la pagina o configuracion general.

## Verificaciones recientes

Ejecutadas antes de commitear `feat/public-render`:

```bash
composer test
./vendor/bin/pint --test
npm run build
```

Resultado:

- `composer test`: 35 tests pasan.
- `./vendor/bin/pint --test`: pasa.
- `npm run build`: pasa.

## Siguiente paso recomendado

Servicios y proyectos.

Objetivo:

- Crear modulos de administracion para servicios y proyectos.
- Cada modulo con listado, creacion, edicion y eliminacion.
- Render publico en `/servicios` y `/proyectos` con listados.
- Render publico de detalle en `/servicios/{slug}` y `/proyectos/{slug}`.
- Categorias para filtrar servicios y proyectos.

## Pendientes despues de servicios y proyectos

- Servicios y proyectos.
- Formulario publico de contacto con Resend.
- Checklist de despliegue con SQLite, backups, storage persistente y SSL.

## Notas operativas

- `main` remoto ya contiene configuracion general, gestion de usuarios, media, paginas y secciones.
- `feat/public-render` contiene el render publico con Blade.
- Antes del siguiente modulo, crear rama desde `main` actualizado o desde la rama integrada aprobada.
- No commitear `.env`, bases SQLite con datos locales, `vendor`, `node_modules` ni artefactos privados de storage.
- Si se prueba media localmente, ejecutar `php artisan storage:link` si `public/storage` no existe.
