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


# FROM php:8.2-fpm-bullseye

# # Set working directory
# WORKDIR /var/www/html

# # Install system dependencies
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
#     netcat \
#  && apt-get clean && rm -rf /var/lib/apt/lists/*

# # Fix .so files (ARM)
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

# # Install PHP extensions
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
#     docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip

# # Install Redis PHP extension
# RUN pecl install redis && docker-php-ext-enable redis

# # Install Composer globally
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # ✅ Copy composer files first for better caching
# COPY composer.json composer.lock ./

# # ✅ Install composer dependencies (including maatwebsite/excel)
# RUN composer install --prefer-dist --no-interaction --no-progress --no-scripts

# # ✅ Copy ALL project files
# COPY . .

# # ✅ Install additional packages if needed
# RUN composer require maatwebsite/excel --no-interaction --prefer-dist || echo "Package already installed"

# # ✅ Run composer scripts after copying files
# RUN composer run-script post-autoload-dump --no-interaction || true

# # Set ownership
# RUN chown -R www-data:www-data /var/www/html/vendor /var/www/html/storage /var/www/html/bootstrap/cache

# # Copy entrypoint script and set permission
# COPY entrypoint.sh /entrypoint.sh
# RUN chmod +x /entrypoint.sh

# # Set correct permissions for Laravel
# RUN chown -R www-data:www-data /var/www/html && \
#     find /var/www/html -type f -exec chmod 644 {} \; && \
#     find /var/www/html -type d -exec chmod 755 {} \; && \
#     chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# # Expose PHP-FPM port
# EXPOSE 9000

# # Healthcheck
# HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
#     CMD php-fpm -t || exit 1

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
    netcat \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

# Fix .so symlinks for ARM compatibility
RUN set -ex && \
    for lib in libssl libcrypto libbrotlicommon libbrotlidec libbrotlienc; do \
        rm -f /lib/aarch64-linux-gnu/${lib}.so || true; \
        real=$(find /lib/aarch64-linux-gnu/ -name "${lib}.so.*" | sort -V | tail -n1 || true); \
        [ -n "$real" ] && ln -s "$real" "/lib/aarch64-linux-gnu/${lib}.so" || echo "Library $lib not found, skipping"; \
    done

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip

# Install Redis PHP extension
RUN pecl install redis && docker-php-ext-enable redis

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy only composer files (cache optimization)
COPY composer.json composer.lock ./

# Run composer update and install production dependencies
RUN composer update --no-dev --prefer-dist --no-interaction --no-progress && \
    composer install --no-dev --prefer-dist --no-interaction --no-progress

# Copy the full Laravel project
COPY . .

# Optimize autoload
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# Fix Laravel permissions
RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# Copy and make entrypoint executable
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose FPM port
EXPOSE 9000

# Healthcheck
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD php-fpm -t || exit 1

# Entrypoint and default command
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]
