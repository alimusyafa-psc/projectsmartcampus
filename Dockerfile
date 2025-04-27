# FROM php:8.2-fpm-bullseye

# # Set workdir
# WORKDIR /var/www/html

# # Install dependencies
# RUN apt-get update && apt-get install -y --no-install-recommends \
#     git \
#     unzip \
#     curl \
#     libpq-dev \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     libonig-dev \
#     libzip-dev \
#     zip \
#     nano \
#     mariadb-client \
#  && apt-get clean && rm -rf /var/lib/apt/lists/*

# # Fix .so files that are empty (based on forum solution)
# RUN set -ex && \
#     for lib in libssl libcrypto libbrotlicommon libbrotlidec libbrotlienc; do \
#         rm -f /lib/aarch64-linux-gnu/${lib}.so || true; \
#         real=$(find /lib/aarch64-linux-gnu/ -name "${lib}.so.*" | sort -V | tail -n1 || true); \
#         if [ -n "$real" ] && [ -f "$real" ]; then \
#             ln -s "$real" "/lib/aarch64-linux-gnu/${lib}.so"; \
#         else \
#             echo "Library $lib not found, skipping symlink"; \
#         fi; \
#     done


# # Configure and install PHP extensions
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
#     docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip

# # Install Redis extension
# RUN pecl install redis && docker-php-ext-enable redis

# # Install Composer
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Copy Laravel project
# COPY . .

# # Copy and set permissions for entrypoint
# COPY entrypoint.sh /entrypoint.sh
# RUN chmod +x /entrypoint.sh

# # Install Laravel dependencies
# RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# # Set correct permissions
# RUN chown -R www-data:www-data /var/www/html/vendor /var/www/html/bootstrap/cache

# # Expose PHP-FPM port
# EXPOSE 9000

# # Healthcheck to ensure PHP-FPM is alive
# HEALTHCHECK --interval=30s --timeout=3s \
#     CMD curl -f http://localhost:9000/status || exit 1

# # Entrypoint
# ENTRYPOINT ["/entrypoint.sh"]
# CMD ["php-fpm", "-R"]



FROM php:8.2-fpm-bullseye

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
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

# Fix .so files that are empty (for ARM architectures sometimes)
RUN set -ex && \
    for lib in libssl libcrypto libbrotlicommon libbrotlidec libbrotlienc; do \
        rm -f /lib/aarch64-linux-gnu/${lib}.so || true; \
        real=$(find /lib/aarch64-linux-gnu/ -name "${lib}.so.*" | sort -V | tail -n1 || true); \
        if [ -n "$real" ] && [ -f "$real" ]; then \
            ln -s "$real" "/lib/aarch64-linux-gnu/${lib}.so"; \
        else \
            echo "Library $lib not found, skipping symlink"; \
        fi; \
    done

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip

# Install Redis PHP extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy only composer files first (to leverage docker layer cache)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Copy the entire application
COPY . .

# Copy entrypoint script and give permissions
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Set correct permissions for Laravel
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

# Healthcheck to make sure PHP-FPM is up
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD php-fpm -t || exit 1

# Set entrypoint
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]
