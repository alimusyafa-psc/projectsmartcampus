# #!/bin/bash
# set -e  # Hentikan eksekusi jika ada error

# # Set permission untuk storage dan bootstrap/cache
# chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
# chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
# chown -R www-data:www-data /var/www/html/public
# chmod -R 755 /var/www/html/public
# # Pastikan storage/logs ada
# mkdir -p /var/www/html/storage/logs
# touch /var/www/html/storage/logs/laravel.log
# chown -R www-data:www-data /var/www/html/storage/logs
# chmod -R 775 /var/www/html/storage/logs
# chmod 664 /var/www/html/storage/logs/laravel.log

# # ✅ Pastikan public/assets ada
# mkdir -p /var/www/html/public/assets
# chown -R www-data:www-data /var/www/html/public/assets
# chmod -R 755 /var/www/html/public/assets

# composer require maatwebsite/excel
# composer update maatwebsite/excel

# # Cache config and routes (recommended in production)
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

# composer dump-autoload

# composer show maatwebsite/excel


# # Jalankan perintah utama container
# exec "$@"



#!/bin/bash
set -e

echo "🚀 Starting Laravel application..."

# Create necessary directories
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/public/assets

# Create log file
touch /var/www/html/storage/logs/laravel.log

# Set proper permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public/assets
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/public
chmod 664 /var/www/html/storage/logs/laravel.log

# Generate application key if not exists
if [ ! -f /var/www/html/.env ] || ! grep -q "APP_KEY=" /var/www/html/.env || [ -z "$(grep APP_KEY= /var/www/html/.env | cut -d '=' -f2)" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --no-interaction
fi

# Cache configuration for better performance
echo "⚡ Optimizing Laravel..."
php artisan config:cache --no-interaction || true
php artisan route:cache --no-interaction || true
php artisan view:cache --no-interaction || true

echo "✅ Laravel application ready!"

# Execute the main command
exec "$@"