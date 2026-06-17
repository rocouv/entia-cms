# Handoff Entia CMS

## Estado actual

Entia CMS esta en fase de edicion de secciones y modulos de contenido del MVP. El proyecto usa Laravel 13, Blade, TailwindCSS 4, SQLite y Pest.

Rama actual:

```txt
feat/theme-settings
```

Ultimo commit de feature:

```txt
961969c feat: agregar formularios por tipo de seccion
```

Rama remota:

```txt
origin/feat/theme-settings
```

Pull request:

```txt
https://github.com/rocouv/entia-cms/pull/new/feat/theme-settings
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
  - `services`: placeholder con enlace al dashboard.
  - `projects`: placeholder con enlace al dashboard.
  - `contact`: seccion de contacto con placeholder de formulario.
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

## Verificaciones recientes

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

Servicios, proyectos y categorias.

Objetivo:

- Crear modelos, migraciones, factories, controladores y vistas dashboard para `categories`, `services` y `projects`.
- Mantener Blade + TailwindCSS, sin React, Vue, Inertia ni Filament.
- Permitir que administradores y editores gestionen categorias, servicios y proyectos.
- Mantener `site_id` en categorias, servicios y proyectos para compatibilidad monositio/futuro crecimiento.
- Crear slugs normalizados y unicos por sitio para servicios y proyectos.
- Asociar servicios/proyectos a categorias opcionales.
- Incluir imagen principal opcional desde media/ruta para servicios y proyectos.
- Crear render publico de listado y detalle para `/servicios`, `/servicios/{slug}`, `/proyectos` y `/proyectos/{slug}`.
- Actualizar secciones publicas `services` y `projects` para mostrar elementos reales en vez de placeholders.

## Pendientes posteriores

- Formulario publico de contacto con Resend.
- Checklist de despliegue con SQLite, backups, storage persistente y SSL.
- Opcional: si el editor de secciones crece demasiado, extraer carga de partials por tipo a un endpoint liviano que devuelva HTML.

## Notas operativas

- `main` remoto ya contiene configuracion general, gestion de usuarios, media, paginas y secciones.
- `feat/public-render` contiene el render publico con Blade y fue subido al remoto con commit `f88a97f`.
- `feat/theme-settings` contiene configuracion visual de colores/tipografia y fue subido al remoto con commit `a1b0c25`.
- `feat: agregar formularios por tipo de seccion` agrega formularios especificos por tipo y selector basico de media para galeria con commit `961969c`.
- Antes del siguiente modulo, crear rama desde la rama integrada aprobada. Si `feat/theme-settings` aun no fue mergeada, la siguiente rama puede partir de ella para conservar el sistema visual.
- No commitear `.env`, bases SQLite con datos locales, `vendor`, `node_modules` ni artefactos privados de storage.
- Si se prueba media localmente, ejecutar `php artisan storage:link` si `public/storage` no existe.
- Si se actualiza una base existente, ejecutar `php artisan migrate` para agregar `site_settings.theme` antes de guardar configuracion visual.
