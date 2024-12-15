FROM composer:2.4.1 AS composer

FROM php:8.2.22-apache AS build

RUN apt-get update && apt-get -y install \
    git \
    unzip \
    libzip-dev \
    vim \
    net-tools \
    iputils-ping \
    nano

RUN a2enmod rewrite

RUN docker-php-ext-install zip \
    pcntl \
    sockets \
    pdo_mysql \
    pcntl

RUN apt-get clean && \
    rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY ./docker/config/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY ./src .

RUN composer install
RUN chown -R www-data:www-data .

CMD ["bash", "-c", "apache2-foreground"]

