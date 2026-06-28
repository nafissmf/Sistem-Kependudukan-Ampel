FROM php:8.3-fpm-alpine

# Extension yang dibutuhkan aplikasi ini:
# - pdo_mysql: koneksi MySQL
# - gd: tidak wajib (QR pakai backend SVG/bacon, bukan GD), tapi dibiarkan
#   ada untuk kebutuhan manipulasi gambar lain (resize foto, dll)
# - zip: dibutuhkan maatwebsite/excel untuk baca/tulis .xlsx
# - intl: dibutuhkan beberapa fitur lokalisasi tanggal Carbon
RUN apk add --no-cache \
        bash \
        libzip-dev \
        icu-dev \
        freetype-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pdo_mysql gd zip intl bcmath \
    && apk del --no-cache libzip-dev icu-dev freetype-dev libpng-dev libjpeg-turbo-dev

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock* ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

COPY . .
RUN composer dump-autoload --optimize \
    && php artisan storage:link || true

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]
