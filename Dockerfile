FROM php:8.2-fpm-alpine

# Install dependencies
RUN apk add --no-cache \
    git \
    unzip \
    curl \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    libzip-dev \
    nano \
    mariadb-client \
    pkg-config \
    libtool \
    autoconf \
    gcc \
    make

# Install GD extension with FreeType and JPEG support
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/freetype2 --with-jpeg-dir=/usr/include && \
    docker-php-ext-install gd pdo pdo_mysql mbstring zip

# Install Redis extension
RUN pecl install redis && \
    docker-php-ext-enable redis

# Clean up
RUN rm -rf /var/lib/apt/lists/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#
