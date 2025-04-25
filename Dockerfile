FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies efficiently
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

# Install Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel project (excluding vendor to keep the image light)
COPY . .

# Copy entrypoint.sh into the container and make it executable
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Install dependencies with Composer
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Set correct permissions for vendor and cache directories
RUN chown -R www-data:www-data /var/www/html/vendor /var/www/html/bootstrap/cache

# Expose PHP-FPM Port
EXPOSE 9000

# Healthcheck to ensure PHP-FPM is running
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost:9000/status || exit 1

# Set entrypoint for file permissions
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]
