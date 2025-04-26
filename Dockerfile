FROM php:8.2-fpm-bullseye

# Set workdir
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
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Fix .so files that are empty (based on forum solution)
RUN set -ex && \
    for lib in libssl libcrypto libbrotlicommon libbrotlidec libbrotlienc; do \
        rm -f /lib/aarch64-linux-gnu/${lib}.so || true; \
        real=$(find /lib/aarch64-linux-gnu/ -name "${lib}.so.*" | sort -V | tail -n1); \
        [ -n "$real" ] && ln -s "$real" "/lib/aarch64-linux-gnu/${lib}.so"; \
    done

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip

# Install Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Laravel project
COPY . .

# Copy and set permissions for entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Install Laravel dependencies
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/vendor /var/www/html/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

# Healthcheck to ensure PHP-FPM is alive
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost:9000/status || exit 1

# Entrypoint
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]
