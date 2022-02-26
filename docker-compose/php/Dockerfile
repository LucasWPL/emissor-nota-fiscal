FROM php:7.4-fpm

EXPOSE 9000

WORKDIR /app

RUN apt-get update -y && apt-get install -y curl git zlib1g-dev libzip-dev unzip
RUN apt-get install -y libxml2-dev openssl
RUN docker-php-ext-install pdo_mysql mysqli dom soap json simplexml

RUN apt-get -y install gcc make autoconf libc-dev pkg-config
RUN apt-get -y install libmcrypt-dev
RUN pecl install --nodeps mcrypt-snapshot

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

CMD ["php-fpm"]