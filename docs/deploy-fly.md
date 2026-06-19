# Despliegue en Fly.io

Entia puede desplegarse en Fly.io con SQLite usando un volume persistente para la base de datos y los archivos de media.

## Crear app y volume

No ejecutes `fly launch --config ./`: `--config` debe apuntar al archivo `fly.toml`, no al directorio del proyecto. Como este repo ya incluye `fly.toml`, puedes crear la app manualmente y desplegar con esa config.

```bash
fly apps create entia-cms-demo
fly volumes create entia_data --region dfw --size 3 --app entia-cms-demo
```

Actualiza `app = "entia-cms"` en `fly.toml` con el nombre real de la app creada.

Si prefieres usar `launch`, usa el archivo de config explicitamente:

```bash
fly launch --config fly.toml --name entia-cms-demo --region dfw --no-deploy
```

## Configurar secretos

```bash
fly secrets set APP_KEY="base64:..." --app entia-cms-demo
fly secrets set APP_URL="https://entia-cms-demo.fly.dev" --app entia-cms-demo
fly secrets set RESEND_API_KEY="..." --app entia-cms-demo
fly secrets set CONTACT_FROM_EMAIL="contacto@tudominio.com" --app entia-cms-demo
fly secrets set CONTACT_TO_EMAIL="destino@tudominio.com" --app entia-cms-demo
fly secrets set MAIL_FROM_ADDRESS="contacto@tudominio.com" --app entia-cms-demo
fly secrets set MAIL_FROM_NAME="Entia" --app entia-cms-demo
```

Genera `APP_KEY` localmente si no tienes uno:

```bash
php artisan key:generate --show
```

## Primer deploy

```bash
fly deploy --app entia-cms-demo
```

El contenedor ejecuta automáticamente:

- `php artisan migrate --force`
- `php artisan storage:link --force`
- cache de config, rutas y vistas

## Seed inicial opcional

Para crear datos demo y el usuario administrador inicial, activa el seeder solo durante el primer arranque:

```bash
fly secrets set ENTIA_RUN_SEEDERS=true --app entia-cms-demo
fly deploy --app entia-cms-demo
fly secrets unset ENTIA_RUN_SEEDERS --app entia-cms-demo
```

Credenciales por defecto si no defines otras variables:

- Email: `admin@entia.local`
- Password: `password`

Para producción, define antes del seed:

```bash
fly secrets set ENTIA_ADMIN_EMAIL="admin@cliente.com" --app entia-cms-demo
fly secrets set ENTIA_ADMIN_PASSWORD="una-contrasena-segura" --app entia-cms-demo
```

## Persistencia

El volume `entia_data` se monta en `/data` y guarda:

- Base SQLite: `/data/database/database.sqlite`
- Media pública: `/data/storage/app/public`

No uses `release_command` para migraciones con SQLite en Fly.io, porque las migraciones deben correr con el volume montado.

## Backups manuales

```bash
fly ssh console --app entia-cms-demo
sqlite3 /data/database/database.sqlite ".backup '/data/database/backup.sqlite'"
```

Luego descarga el archivo o sincronízalo a un storage externo para backups periódicos.
