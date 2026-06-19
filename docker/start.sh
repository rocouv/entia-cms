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

php artisan optimize:clear --no-interaction
php artisan migrate --force --no-interaction

if [ "${ENTIA_RUN_SEEDERS:-false}" = "true" ]; then
    php artisan db:seed --force --no-interaction
fi

php artisan storage:link --force --no-interaction
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

chown -R www-data:www-data /data bootstrap/cache storage database

exec /usr/bin/supervisord -c /etc/supervisord.conf
