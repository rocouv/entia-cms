# Entia CMS: inicio rápido

Esta guía resume las tareas habituales para editar el sitio sin tener que leer todo el manual.

## Antes de empezar

- Necesitas la dirección del sitio y un usuario habilitado.
- Un **Editor** puede gestionar páginas, secciones, media, categorías, servicios y proyectos.
- Un **Administrador** también puede cambiar la configuración y gestionar usuarios.
- Los cambios publicados se reflejan en el sitio público. Revisa el resultado después de guardar.

## 1. Entrar y salir

1. Abre la dirección del sitio y añade `/login`.
2. Introduce tu correo y contraseña.
3. Selecciona **Entrar al dashboard**.
4. Para terminar, selecciona **Cerrar sesión**.

No existe recuperación de contraseña desde la pantalla de acceso. Si pierdes el acceso, solicita al administrador o al soporte que lo restablezca.

## 2. Crear o editar una página

1. En el menú, abre **Páginas**.
2. Selecciona **Nueva página** o **Editar** en una página existente.
3. Completa el título. El slug se genera automáticamente.
4. Decide si será **Publicada**, si será la **home** y si se mostrará en la navegación.
5. Selecciona **Crear página** o **Guardar cambios**.
6. Abre **Ver sitio** y comprueba el resultado.

La home debe estar publicada. Si la despublicas o la eliminas, la dirección `/` puede quedar sin página de inicio.

## 3. Añadir contenido visual

1. Abre **Media** y selecciona **Subir archivo**.
2. Elige un JPG, PNG, WebP, GIF o PDF de hasta 5 MB.
3. Escribe un texto alternativo descriptivo para las imágenes.
4. Selecciona **Subir archivo**.
5. Desde **Páginas > Secciones**, elige la página y selecciona **Editar** o **Nueva sección**.
6. Selecciona el tipo de sección y completa únicamente sus campos.

No elimines un archivo de Media si está usado por una página, sección, servicio, proyecto o logo. La eliminación es permanente y puede dejar imágenes rotas.

## 4. Publicar un servicio o proyecto

1. Si hace falta, crea primero una **Categoría**.
2. Abre **Servicios** o **Proyectos**.
3. Selecciona **Nuevo servicio** o **Nuevo proyecto**.
4. Completa el título, descripción, categoría e imagen opcionales.
5. Marca **Publicado** cuando el contenido esté revisado.
6. Guarda y comprueba `/servicios` o `/proyectos`.

Un registro en borrador no aparece en el sitio público.

## 5. Revisar antes de publicar

Comprueba siempre:

- Título y textos sin errores.
- Enlaces y botones funcionando.
- Imágenes correctas y con texto alternativo.
- Estado **Publicado** solo cuando el contenido esté listo.
- Vista en ordenador y móvil.
- Página pública correcta desde **Ver sitio**.

## 6. Operaciones que requieren cuidado

- **Eliminar una página** elimina también sus secciones.
- **Eliminar una categoría** deja sus servicios y proyectos sin categoría.
- **Eliminar Media** borra el archivo físico y no tiene deshacer.
- **Importar y exportar contenido** todavía no está disponible.
- La búsqueda del encabezado es visual y todavía no filtra el contenido.

Para campos, permisos, secciones y solución de problemas, consulta el [Manual de usuario](manual-de-usuario.md).
