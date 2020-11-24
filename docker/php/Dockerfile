FROM php:fpm

RUN apt-get update && apt-get install -y

RUN apt-get install -y git zlib1g-dev libxml2-dev libzip-dev wget \
    && docker-php-ext-install zip intl mysqli pdo pdo_mysql

RUN curl -sS https://get.symfony.com/cli/installer | bash && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY . /var/www/html
WORKDIR /var/www/html