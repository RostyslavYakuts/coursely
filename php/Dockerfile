FROM php:8.4-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
    libzip-dev \
    libssl-dev \
    libmagickwand-dev \
    imagemagick \
    curl \
    gnupg \
    unzip \
    cron \
    git \
 && docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    zip \
    gd \
 && pecl install imagick xdebug \
 && docker-php-ext-enable imagick xdebug

# Node 18
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
 && apt-get install -y nodejs \
 && npm install -g wrangler

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/html