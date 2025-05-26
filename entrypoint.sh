#!/bin/bash
set -e  # Hentikan eksekusi jika ada error

# Set permission untuk storage dan bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/public
chmod -R 755 /var/www/html/public
# Pastikan storage/logs ada
mkdir -p /var/www/html/storage/logs
touch /var/www/html/storage/logs/laravel.log
chown -R www-data:www-data /var/www/html/storage/logs
chmod -R 775 /var/www/html/storage/logs
chmod 664 /var/www/html/storage/logs/laravel.log

# ✅ Pastikan public/assets ada
mkdir -p /var/www/html/public/assets
chown -R www-data:www-data /var/www/html/public/assets
chmod -R 755 /var/www/html/public/assets

composer dump-autoload

# Cache config and routes (recommended in production)
php artisan config:cache
php artisan route:cache
php artisan view:cache


# Jalankan perintah utama container
exec "$@"
