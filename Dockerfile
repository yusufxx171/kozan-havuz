# Kozan Havuz – production image for Coolify
# PHP 8.4 + Nginx (serversideup/php), assets built in a separate Node stage.

############################
# 1) Composer dependencies #
############################
FROM serversideup/php:8.4-cli AS vendor
WORKDIR /var/www/html
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --no-autoloader --prefer-dist

######################
# 2) Front-end build #
######################
FROM node:22-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund
COPY resources ./resources
COPY public ./public
COPY vite.config.js ./
# Tailwind scans vendor views (pagination), so they must exist at build time.
COPY --from=vendor /var/www/html/vendor ./vendor
RUN npm run build

##################
# 3) Application #
##################
FROM serversideup/php:8.4-fpm-nginx AS app

USER root
RUN install-php-extensions intl exif gd
USER www-data

WORKDIR /var/www/html

# Laravel automations of the serversideup image (run on every container start):
# migrations, storage:link and config/route/view caching.
ENV PHP_OPCACHE_ENABLE=1 \
    AUTORUN_ENABLED=true \
    AUTORUN_LARAVEL_MIGRATION=true \
    AUTORUN_LARAVEL_STORAGE_LINK=true \
    SSL_MODE=off

COPY --chown=www-data:www-data . .
COPY --chown=www-data:www-data --from=vendor /var/www/html/vendor ./vendor
COPY --chown=www-data:www-data --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize --no-dev \
    && php artisan filament:assets \
    && php artisan package:discover --ansi

EXPOSE 8080
