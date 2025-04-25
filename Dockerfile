FROM php:8.2-fpm

# Set Workdir
WORKDIR /var/www/html

# Install dependencies secara efisien
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    nano \
    mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer from the official Composer image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Salin Laravel project (tanpa vendor agar ringan)
COPY . .

# Salin entrypoint.sh ke dalam container dan beri izin eksekusi
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Install dependencies dengan Composer
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Pastikan vendor dan cache memiliki izin yang benar
RUN chown -R www-data:www-data /var/www/html/vendor /var/www/html/bootstrap/cache

# Expose PHP-FPM Port
EXPOSE 9000

# Healthcheck untuk memastikan PHP-FPM berjalan
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -s http://localhost:9000/status || exit 1

# Gunakan entrypoint untuk mengatur izin file
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]
