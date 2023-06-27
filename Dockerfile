FROM php:8.2-fpm

WORKDIR /var/www/html

COPY ./app /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get install -y \
        libzip-dev \
        zip \
    && docker-php-ext-install zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

EXPOSE 80

CMD ["apache2-foreground"]