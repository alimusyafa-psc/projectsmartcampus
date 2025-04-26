FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    nano \
    zip \
    libpq-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    mariadb-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Laravel project (pastikan .dockerignore kamu benar agar tidak copy vendor/cache yang besar)
COPY . .

# Copy entrypoint script dan beri permission
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Install Laravel dependencies
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Set proper permissions for Laravel storage & cache
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port untuk PHP-FPM
EXPOSE 9000

# Healthcheck untuk PHP-FPM
HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
  CMD curl --fail http://localhost:9000 || exit 1

# Jalankan entrypoint script
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]
