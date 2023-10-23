FROM php:8.1-fpm-alpine

RUN apk update && apk add --no-cache freetype-dev libjpeg-turbo-dev libpng-dev libzip-dev zlib-dev  supervisor imagemagick-dev zip libpq-dev nginx bash  && \
docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg && \
docker-php-ext-install gd exif zip pdo pdo_pgsql

ADD ./_docker/app/php/php.ini /usr/local/etc/php/conf.d

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json ./
COPY composer.lock ./

RUN composer install --no-autoloader

COPY ./_docker/app/.env ./
ADD ./_docker/app/workers/*.conf /etc/supervisor/conf.d/
COPY ./_docker/app/supervisord.conf /etc/supervisord.conf
COPY --chown=www-data:www-data . .

EXPOSE 80

CMD composer dump-autoload && \
    php artisan key:generate && \
    php artisan migrate && \
    php artisan db:seed && \
    /usr/bin/supervisord -c /etc/supervisord.conf && \
    php-fpm
