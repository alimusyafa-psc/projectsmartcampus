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
#  && apt-get clean && rm -rf /var/lib/apt/lists/*

# # Install PHP extensions
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
#     docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip

# # Install Redis PHP extension
# RUN pecl install redis && docker-php-ext-enable redis

# # Install Composer globally
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # ✅ Copy ALL project files first
# COPY . .

# # ✅ THEN install composer dependencies
# RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

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


# FROM php:8.2-fpm-bullseye

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
#  && apt-get clean && rm -rf /var/lib/apt/lists/*

# # Install PHP extensions
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
#     docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip

# # Install Redis PHP extension
# RUN pecl install redis && docker-php-ext-enable redis

# # Install Composer globally
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Copy project files
# COPY . .

# # Install composer dependencies including dev (optional, for development images)
# RUN composer install --no-interaction --no-progress --prefer-dist --no-scripts

# # Set proper permissions
# RUN chown -R www-data:www-data /var/www/html/vendor /var/www/html/storage /var/www/html/bootstrap/cache

# # Cache Laravel config, route, view (optional, only if .env exists and production)
# RUN php artisan config:cache && php artisan route:cache && php artisan view:cache || echo "Skipping cache due to missing .env"

# # Copy entrypoint script and make executable
# COPY entrypoint.sh /entrypoint.sh
# RUN chmod +x /entrypoint.sh

# # Final permissions to project files
# RUN chown -R www-data:www-data /var/www/html && \
#     find /var/www/html -type f -exec chmod 644 {} \; && \
#     find /var/www/html -type d -exec chmod 755 {} \; && \
#     chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# EXPOSE 9000

# HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
#     CMD php-fpm -t || exit 1

# ENTRYPOINT ["/entrypoint.sh"]
# CMD ["php-fpm", "-R"]


FROM php:8.3-fpm

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

# Install Composer dari image resmi
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
    CMD curl -f http://localhost:9000/status || exit 1

# Gunakan entrypoint untuk mengatur izin file
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]