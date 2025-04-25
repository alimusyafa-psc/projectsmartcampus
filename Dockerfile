FROM php:8.2-fpm

# Set work directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    nano \
    mariadb-client \
    && apt-get clean

# Pastikan direktori php-src ada
RUN mkdir -p /usr/src/php/ext && \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/freetype2 --with-jpeg-dir=/usr/include && \
    docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip

# Install Redis extension
RUN pecl install redis && \
    docker-php-ext-enable redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Laravel project (tanpa vendor agar ringan)
COPY . .

# Copy entrypoint script dan set izin eksekusi
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Install Laravel dependencies menggunakan Composer
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/vendor /var/www/html/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

# Healthcheck untuk memastikan PHP-FPM berjalan
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost:9000/status || exit 1

# Gunakan entrypoint untuk mengatur izin file
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]
