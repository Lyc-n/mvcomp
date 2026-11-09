FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader \
    --ignore-platform-reqs

FROM php:8.2-cli

RUN docker-php-ext-install pdo_mysql mysqli \
    && docker-php-ext-enable opcache

COPY deploy/php.ini /usr/local/etc/php/conf.d/zz-app.ini

WORKDIR /var/www

COPY . .
COPY --from=vendor /app/vendor /var/www/vendor

RUN mkdir -p public/img \
    && chown -R www-data:www-data /var/www \
    && chmod -R 0775 public/img

USER www-data

EXPOSE 8000

CMD ["sh", "scripts/start.sh"]
