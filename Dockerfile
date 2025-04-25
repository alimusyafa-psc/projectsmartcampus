# Use the official PHP 8.2 FPM image as a base image
FROM php:8.2-fpm

# Set the working directory in the container
WORKDIR /var/www/html

# Install required system dependencies and PHP extensions
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

# Copy the Laravel project files into the container
COPY . .

# Copy the entrypoint.sh script into the container and make it executable
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Install Laravel dependencies using Composer
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Set the correct permissions for the vendor and cache directories
RUN chown -R www-data:www-data /var/www/html/vendor /var/www/html/bootstrap/cache

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Define a healthcheck to ensure PHP-FPM is running
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost:9000/status || exit 1

# Set the entrypoint for file permissions and run PHP-FPM
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]
