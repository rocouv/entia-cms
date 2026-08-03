#!/usr/bin/env sh
set -eu

mkdir -p \
    /data/database \
    /data/storage/app/public \
    bootstrap/cache \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/testing \
    storage/framework/views \
    storage/logs

if [ ! -f /data/database/database.sqlite ]; then
    touch /data/database/database.sqlite
fi

rm -f database/database.sqlite
ln -s /data/database/database.sqlite database/database.sqlite

rm -rf storage/app/public
ln -s /data/storage/app/public storage/app/public

if [ -z "${APP_KEY:-}" ] || [ "${APP_KEY}" = "base64:" ]; then
    if [ -s /data/.app_key ]; then
        APP_KEY="$(tr -d '\r\n' < /data/.app_key)"
    else
        APP_KEY="$(php artisan key:generate --show --no-interaction)"
        umask 077
        printf '%s' "$APP_KEY" > /data/.app_key
    fi

    export APP_KEY
fi

php artisan migrate --force --no-interaction
php artisan optimize:clear --except=cache --no-interaction

seed_mode="${ENTIA_RUN_SEEDERS:-auto}"

if [ "$seed_mode" = "auto" ]; then
    site_state="$(php artisan tinker --execute='echo \App\Models\Site::query()->exists() ? "existing" : "empty";' 2>/dev/null | tr -d '\r\n')"

    if [ "$site_state" = "empty" ]; then
        seed_mode="true"
    else
        seed_mode="false"
    fi
fi

if [ "$seed_mode" = "true" ]; then
    php artisan db:seed --force --no-interaction
fi

php artisan storage:link --force --no-interaction
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

chown -R www-data:www-data /data bootstrap/cache storage database

exec /usr/bin/supervisord -c /etc/supervisord.conf
