FROM composer:latest as composer
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --prefer-dist --no-scripts --no-dev --no-autoloader && \
    composer clear-cache
COPY . .
RUN composer dump-autoload --no-scripts --no-dev --optimize

# Depending on the composer you use, you may be required to use a different php version.
FROM php:8.2-apache
