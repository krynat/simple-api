FROM php:7.4-apache

WORKDIR /var/www/html

COPY ./app /var/www/html

RUN docker-php-ext-install mysqli pdo pdo_mysql

EXPOSE 80

CMD ["apache2-foreground"]