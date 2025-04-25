FROM php:8.2-fpm

# Set Workdir
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    libpq-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    nano \
    mariadb-client

# Ensure the PHP source directory exists and configure PHP extensions
RUN mkdir -p /usr/src/php && docker-php-ext-configure gd --with-freetype --with-jpeg

# Install PHP extensions
RUN docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mbstring zip

# Install Redis extension
RUN pecl install redis
RUN docker-php-ext-enable redis

# Clean up apt cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy Laravel project
COPY . .

# Copy entrypoint.sh
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Install Composer dependencies
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html/vendor /var/www/html/bootstrap/cache

# Expose PHP-FPM port
EXPOSE 9000

# Healthcheck to ensure PHP-FPM is running
HEALTHCHECK --interval=30s --timeout=3s \
    CMD curl -f http://localhost:9000/status || exit 1

# Use entrypoint for file permissions setup
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm", "-R"]
