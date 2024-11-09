FROM php:8.2-apache

RUN apt-get update && apt-get install -y libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    git \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype \
    && docker-php-ext-install mysqli gd

RUN pecl install redis && docker-php-ext-enable redis

RUN a2enmod rewrite authz_groupfile

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /server
COPY composer.json /server

RUN composer install

EXPOSE 80