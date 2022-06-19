FROM php:8.0.2

RUN apt-get update -y && apt-get install -y openssl zip unzip git libpng-dev
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev 

RUN docker-php-ext-install pdo pdo_mysql exif gd

WORKDIR /app/backend

COPY . .

RUN composer install

EXPOSE 8000

CMD php artisan serve --host:127.0.0.1