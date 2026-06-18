# Handoff Entia CMS

## Estado actual

Entia CMS esta en fase de edicion de secciones y modulos de contenido del MVP. El proyecto usa Laravel 13, Blade, TailwindCSS 4, SQLite y Pest.

Rama actual:

```txt
ui/public-text-layout
```

Ultimo commit base remoto:

```txt
1824e8a ui: ajustar textos publicos
```

Estado del modulo actual:

```txt
Ajustes visuales publicos de textos y layout implementados, commiteados y subidos en ui/public-text-layout.
```

Rama remota:

```txt
origin/ui/public-text-layout
```

Estado de sincronizacion:

```txt
ui/public-text-layout sincronizada con origin/ui/public-text-layout.
```

Pull request:

```txt
https://github.com/rocouv/entia-cms/pull/15
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
- Formularios administrativos por tipo de seccion en Blade, con soporte legacy para `items_text`: `cards` usa `icono|titulo|descripcion`, `faq` usa `pregunta|respuesta` y `gallery` usa `ruta|alt`.
- Render publico en la raiz del sitio (`/` y `/{slug}`).
- Pagina de inicio (`/`) cargada desde la pagina marcada como `is_home` en la base de datos.
- Pagina por slug (`/{slug}`) cargada desde `pages` con `is_published = true`.
- Layout publico en `resources/views/components/layouts/public.blade.php` con navegacion dinamica desde paginas publicadas con `show_in_navigation = true` y footer con datos del sitio.
- Navegacion automatica: ordenada por `sort_order`, usa `navigation_label` o `title`, enlace a `/` para la pagina home.
- Render de secciones por tipo desde `resources/views/sections/`:
  - `hero`: imagen de fondo opcional, titulo, subtitulo y boton CTA.
  - `text-block`: titulo y cuerpo de texto.
  - `image-text`: imagen y texto con posicion izquierda/derecha configurable.
  - `cards`: grilla de tarjetas con icono, titulo y descripcion.
  - `gallery`: grilla de imagenes con efecto hover.
  - `services`: grilla publica de servicios publicados, con filtro opcional por categoria y limite.
  - `projects`: grilla publica de proyectos publicados, con filtro opcional por categoria y limite.
  - `contact`: seccion de contacto con formulario publico real.
  - `faq`: acordeon de preguntas y respuestas.
- Vista faltante no rompe la pagina; solo muestra mensaje de debug en entorno local.
- SEO basico: `meta_title` y `meta_description` desde la pagina o configuracion general.
- Limpieza de dashboard: eliminadas referencias internas de desarrollo (MVP, semanas, roadmap, notas tecnicas) y reemplazadas con descripciones orientadas al usuario final. Indicadores reemplazados por conteos reales de contenido.
- Dashboard editorial con metricas reales de paginas, secciones, media, porcentaje publicado, paginas recientes y media reciente.
- Breadcrumbs configurables en el layout del dashboard, aplicados en media y usuarios.
- Tokens tipograficos faltantes agregados a Tailwind (`display`, `headline-sm`, `label-lg`) para evitar render publico pequeno o sin escala visual.
- Anchos de secciones publicas ajustados para evitar contenido demasiado reducido (`excerpt`, `text_block`, `faq`, `contact`).
- Seeder `DemoContentSeeder` con contenido demo realista para probar render publico.
- Configuracion visual del sitio en `/dashboard/settings` mediante JSON `site_settings.theme`.
- Selector de colores para marca, secundarios, superficies, texto, bordes y errores.
- Selector de tipografia principal: `Inter`, `Roboto`, `Open Sans`, `Montserrat` y `Lato`.
- Componente `resources/views/components/theme-style.blade.php` inyecta variables CSS runtime y Google Fonts dinamico en sitio publico y dashboard.
- Tailwind usa variables CSS `--theme-*` con fallback a la paleta base, por lo que los colores cambian sin recompilar por cliente.
- Paleta de referencia para Diseno Vector probada en tests: rojo energetico `#E31B23`, rojo corporativo `#B81414`, rojo oscuro `#5E0608`, blanco `#FFFFFF`, negro `#000000`, gris carbon `#232323`, fuente `Montserrat`.
- Formularios de secciones por tipo en `resources/views/dashboard/sections/fields/` para `hero`, `text_block`, `image_text`, `cards`, `gallery`, `services`, `projects`, `contact` y `faq`.
- Crear y editar secciones ya muestran solo los campos aplicables al tipo seleccionado, con cambio liviano mediante JavaScript y fieldsets Blade deshabilitados para tipos no activos.
- El formulario nuevo guarda contenido estructurado en `content[...]`; el controlador mantiene compatibilidad con los campos legacy (`content_title`, `items_text`, etc.).
- Galeria ahora guarda imagenes en `content.images`, alineado con el render publico existente, y mantiene compatibilidad al recibir `items_text` legacy.
- Galeria incluye selector visual basico de imagenes desde `media` del sitio actual y filas manuales para rutas adicionales.
- Categorias administrables en `/dashboard/categories`.
- La tabla `categories` guarda `site_id`, `name`, `slug`, `description`, `sort_order`, `is_active` y timestamps.
- Servicios administrables en `/dashboard/services`.
- La tabla `services` guarda `site_id`, `category_id`, `title`, `slug`, `excerpt`, `body`, `image_path`, `is_published`, `is_featured`, `sort_order`, `meta_title`, `meta_description` y timestamps.
- Proyectos administrables en `/dashboard/projects`.
- La tabla `projects` guarda `site_id`, `category_id`, `title`, `slug`, `client_name`, `excerpt`, `body`, `image_path`, `is_published`, `is_featured`, `sort_order`, `meta_title`, `meta_description` y timestamps.
- Slugs de categorias, servicios y proyectos son unicos por sitio.
- Servicios/proyectos pueden asociarse a una categoria opcional del mismo sitio.
- Servicios/proyectos pueden usar imagen principal opcional desde ruta local de media o URL absoluta.
- Rutas publicas agregadas: `/servicios`, `/servicios/{slug}`, `/proyectos` y `/proyectos/{slug}`.
- Las rutas publicas solo muestran servicios/proyectos con `is_published = true`; borradores devuelven 404 en detalle y no aparecen en listados.
- El layout publico `resources/views/components/layouts/public.blade.php` declara props `title` y `metaDescription`, por lo que paginas, servicios y proyectos aplican correctamente titulo y meta description.
- Secciones publicas `services` y `projects` ya muestran registros reales publicados en vez de placeholders.
- Formularios de secciones `services` y `projects` usan selector de categorias activas del sitio actual.
- `DemoContentSeeder` ahora crea categorias, servicios y proyectos demo realistas para Lumina Publicidad.
- Formulario publico de contacto disponible en secciones `contact` cuando `show_form = true`.
- Ruta publica `POST /contacto` agregada con middleware `throttle:3,1`.
- Validacion server-side de contacto mediante `ContactRequest`: nombre, correo y mensaje requeridos; telefono opcional; honeypot `website`.
- Envio de contacto mediante `ContactMailable` usando el mailer configurado en `mail.contact.mailer`, por defecto `resend`.
- Destinatario de contacto desde `CONTACT_TO_EMAIL` o, si no existe, desde `site_settings.contact_email`.
- No se guardan mensajes de contacto en base de datos durante el MVP.
- Errores de envio se registran en logs sin exponer detalles internos al visitante.
- `.env.example` documenta `RESEND_API_KEY`, `CONTACT_FROM_EMAIL`, `CONTACT_FROM_NAME` y `CONTACT_TO_EMAIL`.
- Dependencia `resend/resend-php` instalada para el transport `resend` de Laravel.
- Textos introductorios de `/servicios` y `/proyectos` ampliados para usar el ancho disponible y evitar lineas excesivamente cortas.
- Seccion publica `contact` muestra la informacion arriba y el formulario debajo, manteniendo el texto superior con ancho amplio.

## Verificaciones recientes

Ajustes visuales publicos de textos y contacto:

```bash
./vendor/bin/pest tests/Feature/ContactTest.php tests/Feature/ServiceManagementTest.php tests/Feature/ProjectManagementTest.php
npm run build
git diff --check
```

Resultado:

- `./vendor/bin/pest tests/Feature/ContactTest.php tests/Feature/ServiceManagementTest.php tests/Feature/ProjectManagementTest.php`: 20 tests pasan, 83 assertions.
- `npm run build`: pasa.
- `git diff --check`: pasa.

Modulo formulario publico de contacto con Resend:

```bash
./vendor/bin/pest tests/Feature/ContactTest.php
./vendor/bin/pest tests/Feature
./vendor/bin/pint
npm run build
```

Resultado:

- `./vendor/bin/pest tests/Feature/ContactTest.php`: 6 tests pasan, 28 assertions.
- `./vendor/bin/pest tests/Feature`: 66 tests pasan, 275 assertions.
- `./vendor/bin/pint`: pasa, 101 archivos formateados/revisados.
- `npm run build`: pasa.

Modulo servicios, proyectos y categorias:

```bash
./vendor/bin/pest tests/Feature
./vendor/bin/pint --test
npm run build
```

Resultado:

- `./vendor/bin/pest tests/Feature`: 60 tests pasan, 247 assertions.
- `./vendor/bin/pint --test`: pasa, 97 archivos revisados.
- `npm run build`: pasa.

Migracion local aplicada para crear tablas del modulo:

```bash
php artisan migrate
```

Resultado:

- `2026_06_10_000009_create_categories_table`: ran.
- `2026_06_10_000010_create_services_table`: ran.
- `2026_06_10_000011_create_projects_table`: ran.
- Confirmado con `php artisan migrate:status` y `Schema::hasTable(...)` para `categories`, `services` y `projects`.

Seeder demo ejecutado localmente para poblar ejemplos:

```bash
php artisan db:seed --class=DemoContentSeeder
```

Resultado:

- `categories`: 3 registros demo.
- `services`: 3 registros demo.
- `projects`: 3 registros demo.
- Confirmado con conteos Eloquent y listados de slugs desde Tinker.

Verificaciones anteriores de aplicacion:

Ejecutadas despues de implementar formularios por tipo de seccion:

```bash
./vendor/bin/pest tests/Feature
./vendor/bin/pint --test
npm run build
```

Resultado:

- `./vendor/bin/pest tests/Feature`: 39 tests pasan, 168 assertions.
- `./vendor/bin/pint --test`: pasa.
- `npm run build`: pasa.

Nota: `composer test` no es el comando recomendado actualmente porque la configuracion intenta ejecutar `tests/Unit` y esa carpeta no existe. Usar `./vendor/bin/pest tests/Feature` hasta corregir la configuracion de Pest o crear `tests/Unit`.

Migracion local aplicada para probar guardado de tema:

```bash
php artisan migrate
```

La migracion `2026_06_10_000008_add_theme_to_site_settings_table` agrega `site_settings.theme`. Si no se ejecuta, guardar colores/tipografia falla porque la columna no existe.

## Siguiente paso recomendado

Checklist de despliegue con SQLite, backups, storage persistente y SSL.

Objetivo:

- Documentar despliegue inicial con SQLite.
- Definir storage persistente para media y base SQLite.
- Agregar checklist de backups.
- Cubrir dominio real del cliente, SSL y variables de entorno requeridas.
- Dejar claro el camino futuro para migrar a MySQL si el proyecto crece.

## Pendientes posteriores

- Opcional: si el editor de secciones crece demasiado, extraer carga de partials por tipo a un endpoint liviano que devuelva HTML.

## Notas operativas

- `main` remoto ya contiene configuracion general, gestion de usuarios, media, paginas, secciones, tema visual y formularios por tipo de seccion.
- `feat/public-render` contiene el render publico con Blade y fue subido al remoto con commit `f88a97f`.
- `feat/theme-settings` contiene configuracion visual de colores/tipografia y fue subido al remoto con commit `a1b0c25`.
- `feat: agregar formularios por tipo de seccion` agrega formularios especificos por tipo y selector basico de media para galeria con commit `961969c`.
- `319d6cf docs: actualizar handoff de secciones` ya estaba sincronizado con `origin/feat/theme-settings` antes de esta actualizacion documental.
- Pull request `feat/theme-settings` hacia `main`: https://github.com/rocouv/entia-cms/pull/11, integrado en `main` con commit `7361e31`.
- Rama previa de trabajo: `feat/services-projects`, creada desde `origin/main`.
- `feat/services-projects` agrega categorias, servicios, proyectos, dashboard CRUD, rutas publicas y secciones publicas reales con commit `56f1859`.
- Pull request activo de `feat/services-projects` hacia `main`: https://github.com/rocouv/entia-cms/pull/12
- Rama previa de trabajo: `feat/contact-resend`, creada desde `feat/services-projects`, con commit `5047016`.
- Pull request activo de `feat/contact-resend` hacia `feat/services-projects`: https://github.com/rocouv/entia-cms/pull/13
- Rama actual de trabajo: `ui/public-text-layout`, creada desde `feat/contact-resend`, con commit `1824e8a`.
- Pull request activo de `ui/public-text-layout` hacia `feat/contact-resend`: https://github.com/rocouv/entia-cms/pull/15
- Para envio real de contacto, configurar `RESEND_API_KEY` y `CONTACT_TO_EMAIL` o definir correo de contacto en configuracion del sitio.
- No commitear `.env`, bases SQLite con datos locales, `vendor`, `node_modules` ni artefactos privados de storage.
- Si se prueba media localmente, ejecutar `php artisan storage:link` si `public/storage` no existe.
- Si se actualiza una base existente, ejecutar `php artisan migrate` para crear `categories`, `services` y `projects` ademas de migraciones previas.
