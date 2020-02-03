FROM php:7.2-fpm

RUN apt-get update

RUN apt-get install -y zlib1g-dev libpng-dev && docker-php-ext-install pdo_mysql \
&& docker-php-ext-install zip \
&& docker-php-ext-configure gd --with-zlib-dir \
&& docker-php-ext-install gd

RUN curl --insecure https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer

WORKDIR /var/www/books