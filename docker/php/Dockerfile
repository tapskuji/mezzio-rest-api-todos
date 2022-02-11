# This Dockerfile will install
# mysql, xdebug, vim, git, composer (dependences),
# set the root directory to /var/www and
# expose /var/www/public to the world

FROM php:7.2-apache

RUN apt-get update \
 && apt-get install -y vim git zlib1g-dev mariadb-client libzip-dev \
 && docker-php-ext-install zip mysqli pdo_mysql \
 && pecl install xdebug-2.6.0 \
 && docker-php-ext-enable xdebug \
 && a2enmod rewrite \
 && sed -i 's!/var/www/html!/var/www/public!g' /etc/apache2/sites-available/000-default.conf \
 && mv /var/www/html /var/www/public \
 && curl -sS https://getcomposer.org/installer \
  | php -- --version=2.0.11 --install-dir=/usr/local/bin --filename=composer \
 && echo "AllowEncodedSlashes On" >> /etc/apache2/apache2.conf

COPY docker/php/20-xdebug.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /var/www
