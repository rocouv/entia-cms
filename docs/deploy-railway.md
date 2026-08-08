# Despliegue en Railway

Entia incluye `railway.toml` y `Dockerfile.railway` para que Railway use el contenedor correcto y compruebe el endpoint `/up` automaticamente.

## Configuracion del servicio

Conecta el repositorio `rocouv/entia-cms` y usa la rama `main`. Railway toma desde el repositorio:

- `railway.toml` para la configuracion de build y health check.
- `Dockerfile.railway` para compilar PHP, assets, Nginx y Supervisor.
- `docker/start.sh` para migraciones, bootstrap inicial y caches.

No hace falta configurar un start command manual. El Dockerfile ejecuta `entia-start`.

## Volume persistente

Crea un Volume de Railway montado en:

```txt
/data
```

El volumen conserva:

- `/data/database/database.sqlite`
- `/data/storage/app/public`

Sin este volumen, la base SQLite y los archivos de media se pierden al crear una nueva instancia o desplegar una nueva imagen.

## Variables requeridas

Configura estas variables en Railway. Los secretos no se guardan en Git:

```env
APP_ENV=production
APP_DEBUG=false
# APP_KEY=base64:...  # opcional; si se omite se genera en /data/.app_key
APP_URL=https://tu-dominio.up.railway.app
PORT=8080

DB_CONNECTION=sqlite
DB_DATABASE=/data/database/database.sqlite
DB_BUSY_TIMEOUT=5000
DB_JOURNAL_MODE=wal
DB_SYNCHRONOUS=full
LOG_CHANNEL=stderr
LOG_LEVEL=info
CACHE_STORE=file
SESSION_DRIVER=database
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=public
```

Si defines `APP_KEY` en Railway, esa clave tiene prioridad. Si la omites, `docker/start.sh` genera una clave en el primer arranque y la guarda en `/data/.app_key`. Los reinicios y redeploys reutilizan esa misma clave mientras el Volume de Railway permanezca montado en `/data`.

Para generar una clave manualmente:

```bash
php artisan key:generate --show
```

Tambien agrega las variables de correo si usaras el formulario de contacto:

```env
RESEND_API_KEY=...
CONTACT_FROM_EMAIL=...
CONTACT_FROM_NAME=...
CONTACT_TO_EMAIL=...
MAIL_FROM_ADDRESS=...
MAIL_FROM_NAME=...
```

No dejes `CACHE_STORE=database` definido en Railway. El valor recomendado para este despliegue es `file`.

No elimines el archivo `/data/.app_key` ni el Volume asociado: hacerlo generaria una clave nueva y cerraria las sesiones existentes.

## Bootstrap inicial

Al arrancar, `docker/start.sh` ejecuta solamente las migraciones incrementales y las caches. Nunca ejecuta seeders ni crea datos automaticamente.

Antes del primer deploy configura estas variables con datos reales:

```env
ENTIA_ADMIN_NAME=Administrador
ENTIA_ADMIN_EMAIL=admin@tu-dominio.com
ENTIA_ADMIN_PASSWORD=una-contrasena-de-al-menos-12-caracteres
ENTIA_CLIENT_NAME=Nombre del cliente
ENTIA_SITE_NAME=Nombre del sitio
```

Despues del primer deploy ejecuta una unica vez desde Railway:

```bash
railway shell
php artisan entia:install
```

El comando crea roles, cliente, sitio, configuracion y administrador, pero no crea paginas, servicios, proyectos, categorias ni contenido demo. Rechaza contrasenas debiles y no vuelve a modificar una instalacion existente.

Para contenido demo local, ejecuta `php artisan db:seed --class=DemoContentSeeder` de forma explicita. Nunca configures un seeder en el arranque de produccion.

Si Railway arranca una version de produccion sin un volumen montado en `/data`, el contenedor termina con un error intencional para evitar que se cree una base temporal y se pierda la informacion.

## Verificacion

- `/up` debe responder correctamente para el health check.
- `/` debe mostrar la home.
- `/login` debe mostrar el acceso administrativo.
- `/dashboard` debe requerir autenticacion.
- Un redeploy debe conservar los registros y archivos del volumen.
- La configuracion de Backups del volumen debe tener al menos una periodicidad diaria.
