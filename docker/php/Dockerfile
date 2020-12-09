FROM php:fpm

RUN apt-get update && apt-get install -y

RUN apt-get install -y git zlib1g-dev libxml2-dev libzip-dev wget libpq-dev \
    && docker-php-ext-install zip intl mysqli pdo pdo_mysql pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY . /var/www/html
COPY php.ini /usr/local/etc/php/php.ini
WORKDIR /var/www/html