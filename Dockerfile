# syntax=docker/dockerfile:1

FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json vite.config.js ./
COPY resources ./resources

RUN npm install -g npm@10 \
    && npm ci \
    && npm run build

FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --optimize-autoloader \
    --prefer-dist

COPY app ./app
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY routes ./routes
COPY artisan ./artisan

RUN composer dump-autoload --no-dev --optimize --no-interaction

FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk add --no-cache \
        bash \
        curl \
        icu-libs \
        libzip \
        nginx \
        sqlite \
        supervisor \
    && apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS \
        icu-dev \
        libzip-dev \
        oniguruma-dev \
        sqlite-dev \
    && docker-php-ext-install \
        intl \
        mbstring \
        opcache \
        pdo \
        pdo_sqlite \
        zip \
    && apk del .build-deps

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build
COPY docker/php.ini /usr/local/etc/php/conf.d/entia.ini
COPY docker/nginx.conf /etc/nginx/http.d/default.conf
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/start.sh /usr/local/bin/entia-start

RUN chmod +x /usr/local/bin/entia-start \
    && mkdir -p \
        /data/database \
        /data/storage/app/public \
        /run/nginx \
        bootstrap/cache \
        storage/app/public \
        storage/framework/cache/data \
        storage/framework/sessions \
        storage/framework/testing \
        storage/framework/views \
        storage/logs \
    && php artisan package:discover --ansi \
    && chown -R www-data:www-data /data bootstrap/cache storage database

EXPOSE 8080

CMD ["entia-start"]
