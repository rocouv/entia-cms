# Manual de usuario de Entia CMS

**Versión:** MVP editorial
**Audiencia:** administradores y editores de sitios gestionados con Entia

Entia CMS permite administrar el contenido de un sitio público desde un dashboard protegido. Este manual está organizado por tareas: puedes leer la guía rápida y volver aquí únicamente cuando necesites un detalle.

## Índice

- [1. Conceptos básicos](#1-conceptos-básicos)
- [2. Acceso y perfiles](#2-acceso-y-perfiles)
- [3. Dashboard y navegación](#3-dashboard-y-navegación)
- [4. Flujo recomendado de publicación](#4-flujo-recomendado-de-publicación)
- [5. Páginas](#5-páginas)
- [6. Secciones](#6-secciones)
- [7. Media](#7-media)
- [8. Categorías](#8-categorías)
- [9. Servicios](#9-servicios)
- [10. Proyectos](#10-proyectos)
- [11. Configuración del sitio](#11-configuración-del-sitio)
- [12. Usuarios](#12-usuarios)
- [13. Eliminaciones y consecuencias](#13-eliminaciones-y-consecuencias)
- [14. Funciones no disponibles](#14-funciones-no-disponibles)
- [15. Problemas frecuentes](#15-problemas-frecuentes)
- [16. Checklist editorial](#16-checklist-editorial)

## 1. Conceptos básicos

### Página

Una página es una dirección del sitio, por ejemplo Inicio, Nosotros o Contacto. Contiene información base y una o varias secciones.

### Sección

Una sección es un bloque visual dentro de una página. Entia admite: **Hero**, **Bloque de texto**, **Imagen y texto**, **Tarjetas**, **Galería**, **Servicios**, **Proyectos**, **Contacto** y **Preguntas frecuentes**.

### Media

Media es la biblioteca de archivos del sitio. Las imágenes pueden reutilizarse escribiendo su ruta en una sección, servicio, proyecto o configuración del sitio.

### Borrador, publicación y visibilidad

- Una página, servicio o proyecto en **Borrador** se guarda, pero no aparece públicamente.
- Una sección **Oculta** se conserva en el dashboard, pero no se muestra en la página.
- Una categoría **Oculta** deja de aparecer en selectores editoriales; no oculta automáticamente sus servicios o proyectos ya publicados.
- **Destacado** ordena servicios y proyectos destacados antes que los demás; no los publica por sí mismo.

## 2. Acceso y perfiles

### Iniciar sesión

1. Abre `/login`.
2. Escribe tu correo y contraseña.
3. Opcionalmente marca **Mantener sesión iniciada**.
4. Selecciona **Entrar al dashboard**.

Si aparece un error, revisa el correo y vuelve a escribir la contraseña. El correo se conserva para facilitar el segundo intento, pero la contraseña no.

### Cerrar sesión

Selecciona **Cerrar sesión** en la parte superior del dashboard. Hazlo especialmente si utilizas un ordenador compartido.

### Permisos

| Tarea | Administrador | Editor |
|---|---:|---:|
| Dashboard | Sí | Sí |
| Páginas y secciones | Sí | Sí |
| Media | Sí | Sí |
| Categorías, servicios y proyectos | Sí | Sí |
| Configuración | Sí | No |
| Crear y gestionar usuarios | Sí | No |

La interfaz puede mostrar enlaces de **Configuración** y **Usuarios** a un Editor, pero esas pantallas están protegidas y responderán con acceso denegado. No es un error de la cuenta.

Entia no incluye registro público, verificación de correo ni cambio de contraseña desde el dashboard. Solicita al Administrador o al soporte cualquier cambio de acceso.

## 3. Dashboard y navegación

El menú lateral contiene:

- **Dashboard:** resumen de páginas, secciones, media y publicación.
- **Configuración:** datos del cliente, sitio, contacto, SEO y apariencia. Solo Administradores.
- **Páginas:** crear y editar páginas.
- **Secciones:** se accede desde la página correspondiente.
- **Media:** subir y eliminar archivos.
- **Categorías:** organizar servicios y proyectos.
- **Servicios:** administrar el catálogo de servicios.
- **Proyectos:** administrar casos o trabajos realizados.
- **Usuarios:** crear y editar Editores. Solo Administradores.
- **Ver sitio:** abre el sitio público.

El campo **Buscar contenido...** del encabezado es actualmente visual y no ejecuta búsquedas.

## 4. Flujo recomendado de publicación

Para reducir errores, trabaja en este orden:

1. Sube y revisa las imágenes en **Media**.
2. Crea las categorías necesarias.
3. Crea servicios y proyectos como borradores.
4. Crea o edita la página.
5. Ordena sus secciones y comprueba su visibilidad.
6. Revisa el sitio público en una pestaña nueva.
7. Publica solo los elementos terminados.
8. Comprueba nuevamente ordenador, móvil, enlaces y formularios.

Cada listado muestra un mensaje de confirmación después de crear, modificar o eliminar un registro. Si el formulario muestra errores, corrige los campos indicados y vuelve a guardar.

## 5. Páginas

### Crear una página

1. Abre **Páginas > Nueva página**.
2. Completa **Título**. Es obligatorio.
3. Revisa **Slug**. Si lo dejas vacío, se genera desde el título.
4. Añade un **Extracto** y **Contenido base** si corresponde.
5. Completa **Meta title** y **Meta description** para buscadores si tienes esos textos preparados.
6. Marca **Publicada** para hacerla visible.
7. Marca **Mostrar en navegación** para incluirla en el menú público.
8. Usa **Etiqueta** para mostrar un nombre corto en la navegación.
9. Usa **Orden** para decidir su posición. Un número menor aparece antes.
10. Marca **Usar como home** únicamente en la página que debe responder en `/`.
11. Selecciona **Crear página**.

El slug se normaliza automáticamente: se convierten mayúsculas y espacios, y se eliminan acentos. Debe ser único dentro del sitio. Evita slugs reservados como `servicios`, `proyectos` y `login`.

### Editar una página

1. Abre **Páginas**.
2. Selecciona **Editar**.
3. Modifica únicamente lo necesario.
4. Comprueba especialmente **Publicada**, **Usar como home** y **Mostrar en navegación**.
5. Selecciona **Guardar cambios**.
6. Usa **Ver sitio** para verificar la página.

### Eliminar una página

Desde el listado, selecciona **Eliminar** y confirma la acción del navegador. La eliminación es permanente y elimina todas las secciones de la página. No existe papelera ni deshacer.

## 6. Secciones

### Abrir las secciones de una página

1. Abre **Páginas**.
2. En la fila elegida, selecciona **Secciones**.
3. Usa **Nueva sección** para crear un bloque o **Editar** para cambiar uno existente.

### Campos comunes

- **Tipo:** determina los campos que se muestran.
- **Visible:** decide si el bloque se renderiza en el sitio público.
- **Orden:** controla la posición dentro de la página.
- **Variante:** valor visual opcional definido por el diseño.
- **Espaciado:** valor visual opcional definido por el diseño.

Cuando cambias el tipo, Entia muestra únicamente los campos aplicables. Completa la información y selecciona **Crear sección** o **Guardar cambios**.

### Tipos de sección

| Tipo | Uso | Campos principales |
|---|---|---|
| Hero | Presentación principal | Título, subtítulo, imagen, botón y enlace |
| Bloque de texto | Texto libre | Título y cuerpo |
| Imagen y texto | Contenido dividido | Título, cuerpo, imagen y posición |
| Tarjetas | Beneficios o servicios breves | Título, icono, título y descripción por tarjeta |
| Galería | Grupo de imágenes | Imágenes de Media o rutas manuales, alt y opciones de imagen |
| Servicios | Listado automático | Título, categoría y límite de resultados |
| Proyectos | Listado automático | Título, categoría y límite de resultados |
| Contacto | Información y formulario | Título, texto y mostrar formulario |
| Preguntas frecuentes | Dudas comunes | Pregunta y respuesta por elemento |

### Imágenes de secciones

Las opciones disponibles son:

- **Opacidad:** de 0 a 100 por ciento.
- **Posición focal:** nueve posiciones, como centro o esquina.
- **Ajuste:** `cover`, `contain`, `fill` o `none`.

En galerías puedes seleccionar imágenes existentes de Media o añadir una ruta manual. Usa texto alternativo que describa la imagen y su propósito.

### Tarjetas y preguntas frecuentes

Selecciona **Agregar tarjeta** o añade filas de preguntas según el tipo. Elimina una fila únicamente cuando estés seguro: los índices se renumeran al guardar.

## 7. Media

### Subir un archivo

1. Abre **Media > Subir archivo**.
2. Selecciona un archivo JPG, JPEG, PNG, WebP, GIF o PDF.
3. Respeta el límite de 5 MB.
4. Añade **Texto alternativo** para las imágenes.
5. Selecciona **Subir archivo**.

Media permite previsualizar imágenes, abrir archivos y consultar nombre, tipo y tamaño.

### Reutilizar una imagen

En galerías y algunos campos de imagen, selecciona el archivo desde el catálogo visual. En servicios, proyectos, logos y otros campos puede ser necesario usar la ruta del archivo o una URL absoluta.

### Eliminar un archivo

Eliminar Media borra el registro y el archivo físico. Entia no comprueba todas las referencias existentes, por lo que una imagen utilizada en otra parte puede dejar de mostrarse. Verifica primero dónde se usa y conserva una copia si es importante.

## 8. Categorías

### Crear o modificar

1. Abre **Categorías**.
2. Selecciona **Nueva categoría** o **Editar**.
3. Completa **Nombre**.
4. Revisa el **Slug**, la descripción, el orden y el estado **Activa**.
5. Guarda.

Las categorías sirven para organizar servicios y proyectos y aparecen como opciones al configurar las secciones correspondientes.

### Eliminar

Los servicios y proyectos no se eliminan al borrar una categoría: quedan como **Sin categoría**. Las secciones automáticas que apuntaban a esa categoría pueden dejar de mostrar resultados. Reasigna primero el contenido si la categoría está en uso.

## 9. Servicios

### Crear o modificar

1. Abre **Servicios**.
2. Selecciona **Nuevo servicio** o **Editar**.
3. Completa el **Título**.
4. Revisa el **Slug** generado.
5. Añade extracto, descripción, categoría, imagen y orden.
6. Marca **Destacado** si debe ordenarse antes que los demás.
7. Marca **Publicado** cuando esté listo.
8. Completa los campos SEO si corresponde.
9. Guarda y verifica `/servicios` y el detalle del servicio.

Los servicios publicados pueden aparecer en el listado general y en secciones de tipo **Servicios**. El límite de esas secciones admite entre 1 y 24 resultados.

**Advertencia del MVP:** al editar un servicio, revisa nuevamente las opciones de su imagen antes de guardar, porque el MVP actual puede no conservar esos ajustes en una actualización.

### Eliminar

La eliminación es permanente. El archivo de imagen asociado no se elimina automáticamente del almacenamiento, por lo que conviene revisar Media por separado si se necesita limpiar archivos.

## 10. Proyectos

### Crear o modificar

El flujo es equivalente al de servicios:

1. Abre **Proyectos**.
2. Selecciona **Nuevo proyecto** o **Editar**.
3. Completa título, cliente, extracto, descripción y categoría.
4. Añade imagen y orden si corresponde.
5. Marca **Destacado** y **Publicado** según sea necesario.
6. Completa SEO y guarda.
7. Verifica `/proyectos` y el detalle público.

Los proyectos en borrador no aparecen en listados ni en su URL de detalle.

**Advertencia del MVP:** revisa los ajustes de imagen después de editar un proyecto, por la misma limitación de actualización existente en servicios.

## 11. Configuración del sitio

Esta pantalla es exclusiva del Administrador.

### Datos y contacto

En **Configuración** puedes modificar nombre del cliente, razón social, correos, teléfonos, nombre del sitio, dominio, frase descriptiva, dirección y datos públicos de contacto.

### Listados

Puedes cambiar el título y subtítulo de las páginas públicas de **Servicios** y **Proyectos**. Estos campos controlan el texto de presentación de sus listados.

### Logo

El logo puede apuntar a una imagen de Media o a una URL. Antes de eliminar la imagen elegida, reemplaza el logo por otro valor.

### SEO

- **Meta title:** título de la pestaña y resultado de búsqueda.
- **Meta description:** resumen de la página para buscadores.

Escribe textos claros, específicos y diferentes para las páginas importantes.

### Tema visual

La configuración del sitio incluye una tipografía y colores para marca, superficies, texto, bordes y errores. La **Paleta del tablero** es independiente de la apariencia pública. Los cambios se reflejan automáticamente al guardar.

La opción **Sitio activo** existe en el formulario, pero en el MVP actual no bloquea el acceso público. No la uses como mecanismo de mantenimiento o privacidad.

## 12. Usuarios

Solo un Administrador puede abrir **Usuarios**.

### Crear un Editor

1. Selecciona **Nuevo editor**.
2. Completa nombre y correo.
3. Introduce una contraseña de al menos 8 caracteres y confírmala.
4. Selecciona **Crear editor**.

El rol se asigna automáticamente como **Editor** y no se elige desde el formulario.

### Editar un usuario

Un Administrador puede cambiar nombre, correo y contraseña. La contraseña es opcional al editar: si se deja vacía, se conserva la actual. El rol aparece como solo lectura.

### Eliminar un usuario

Solo se pueden eliminar usuarios con rol Editor. Los Administradores no se eliminan desde esta pantalla. La eliminación no tiene deshacer.

## 13. Eliminaciones y consecuencias

Antes de eliminar, confirma si el registro se utiliza en otra parte.

| Elemento | Consecuencia |
|---|---|
| Página | Elimina permanentemente sus secciones; si era home, `/` puede quedar sin contenido. |
| Sección | Deja de aparecer en la página pública. |
| Media | Borra el archivo físico; las referencias pueden romperse. |
| Categoría | Servicios y proyectos quedan sin categoría; secciones filtradas pueden quedar vacías. |
| Servicio | Elimina el registro; su archivo asociado puede permanecer almacenado. |
| Proyecto | Elimina el registro; su archivo asociado puede permanecer almacenado. |
| Editor | Elimina la cuenta y no tiene deshacer. |

Entia no incluye papelera, restauración ni confirmación avanzada. Para cambios importantes, realiza una copia o solicita asistencia antes de eliminar.

## 14. Funciones no disponibles

El MVP actual no ofrece:

- Importación de contenido desde CSV, Excel u otro CMS.
- Exportación de páginas, secciones o catálogos.
- Papelera, restauración o historial editorial.
- Bandeja de mensajes de contacto dentro del dashboard.
- Recuperación de contraseña por correo.
- Búsqueda funcional desde el encabezado.

El formulario público de contacto sí puede enviar correos al destinatario configurado, pero los mensajes no se guardan en Entia.

## 15. Problemas frecuentes

### No puedo entrar

Confirma la dirección, el correo y la contraseña. Si la cuenta no existe, un Administrador debe crearla. Si la contraseña se perdió, contacta al soporte: no hay recuperación desde la interfaz.

### Un Editor ve Configuración, pero recibe acceso denegado

Es el comportamiento esperado del MVP. Configuración y Usuarios están reservados al Administrador.

### La página no aparece públicamente

Revisa que la página esté **Publicada**, que el slug sea correcto y que no esté intentando usar una ruta reservada. Comprueba también que sus secciones estén **Visibles**.

### Un servicio o proyecto no aparece

Revisa **Publicado**, categoría, orden y el límite de la sección automática. Un borrador no aparece en el sitio público.

### Una imagen dejó de mostrarse

Comprueba que el archivo siga existiendo en Media y que su ruta o URL no haya cambiado. No elimines archivos que todavía estén referenciados.

### No se reciben mensajes del formulario de contacto

El destinatario y el servicio de correo deben estar configurados por el equipo técnico. El formulario está limitado a tres envíos por minuto y por dirección IP.

### Guardé cambios, pero no veo el resultado

Recarga el sitio público, comprueba que el registro esté publicado y revisa los mensajes de validación. Si el problema continúa, conserva la URL, el usuario, la hora y una captura para soporte.

## 16. Checklist editorial

Antes de cerrar una tarea, confirma:

- [ ] El registro tiene un título claro.
- [ ] El slug es legible y no usa una ruta reservada.
- [ ] El texto fue revisado.
- [ ] Las imágenes son correctas y tienen texto alternativo.
- [ ] Los enlaces fueron probados.
- [ ] El estado de publicación es intencional.
- [ ] La sección tiene el orden y visibilidad correctos.
- [ ] El resultado fue comprobado en el sitio público.
- [ ] No se eliminó ningún archivo que siga siendo utilizado.

Si una operación puede afectar muchas páginas o archivos, detente y consulta al Administrador o al soporte antes de continuar.
