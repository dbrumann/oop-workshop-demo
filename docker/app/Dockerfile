FROM dunglas/frankenphp:latest

RUN pecl install xdebug \
    && install-php-extensions pdo_mysql intl opcache \
    && docker-php-ext-enable xdebug pdo_mysql

COPY xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
