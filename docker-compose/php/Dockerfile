FROM php:7.4-fpm

EXPOSE 9000

WORKDIR /app

RUN apt-get update && apt-get install -y curl git zlib1g-dev libzip-dev unzip libxml2-dev
RUN docker-php-ext-install pdo_mysql mysqli dom zlib openssl soap json simplexml libxml
RUN pecl install mcrypt &&  docker-php-ext-enable mcrypt


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

CMD ["php-fpm"]