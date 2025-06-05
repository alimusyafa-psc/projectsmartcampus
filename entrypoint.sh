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

# # composer require maatwebsite/excel
# # composer update maatwebsite/excel

# # # Cache config and routes (recommended in production)
# # php artisan config:cache
# # php artisan route:cache
# # php artisan view:cache

# # composer dump-autoload
# composer require nunomaduro/collision --dev

# # Clear cache dulu untuk menghindari error jika ada service provider yang hilang
# php artisan config:clear || true
# php artisan route:clear || true
# php artisan view:clear || true

# # Cache ulang untuk production
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

# # composer show maatwebsite/excel


# # Jalankan perintah utama container
# exec "$@"


# #!/bin/bash
# set -e  # Hentikan eksekusi jika ada error

# # ✅ PERBAIKAN: Konfigurasi PHP-FPM untuk listen di semua interface
# echo "Configuring PHP-FPM to listen on 0.0.0.0:9000..."
# sed -i 's/^listen = .*/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf || \
#     echo "listen = 0.0.0.0:9000" >> /usr/local/etc/php-fpm.d/www.conf

# # Tambahkan konfigurasi tambahan PHP-FPM jika belum ada
# grep -q "listen.owner" /usr/local/etc/php-fpm.d/www.conf || echo "listen.owner = www-data" >> /usr/local/etc/php-fpm.d/www.conf
# grep -q "listen.group" /usr/local/etc/php-fpm.d/www.conf || echo "listen.group = www-data" >> /usr/local/etc/php-fpm.d/www.conf
# grep -q "listen.mode" /usr/local/etc/php-fpm.d/www.conf || echo "listen.mode = 0660" >> /usr/local/etc/php-fpm.d/www.conf

# echo "PHP-FPM configuration updated:"
# grep "listen" /usr/local/etc/php-fpm.d/www.conf

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

# # Install collision for better error handling
# composer require nunomaduro/collision --dev

# # Clear cache dulu untuk menghindari error jika ada service provider yang hilang
# php artisan config:clear || true
# php artisan route:clear || true
# php artisan view:clear || true

# # Cache ulang untuk production
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

# echo "Entrypoint completed. Starting PHP-FPM..."

# # Jalankan perintah utama container
# exec "$@"

#!/bin/bash
set -e

echo "Configuring PHP-FPM to listen on 0.0.0.0:9000..."
sed -i 's/^listen = .*/listen = 0.0.0.0:9000/' /usr/local/etc/php-fpm.d/www.conf || \
    echo "listen = 0.0.0.0:9000" >> /usr/local/etc/php-fpm.d/www.conf

grep -q "listen.owner" /usr/local/etc/php-fpm.d/www.conf || echo "listen.owner = www-data" >> /usr/local/etc/php-fpm.d/www.conf
grep -q "listen.group" /usr/local/etc/php-fpm.d/www.conf || echo "listen.group = www-data" >> /usr/local/etc/php-fpm.d/www.conf
grep -q "listen.mode" /usr/local/etc/php-fpm.d/www.conf || echo "listen.mode = 0660" >> /usr/local/etc/php-fpm.d/www.conf

echo "PHP-FPM configuration updated:"
grep "listen" /usr/local/etc/php-fpm.d/www.conf

# Permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 755 /var/www/html/public

mkdir -p /var/www/html/storage/logs
touch /var/www/html/storage/logs/laravel.log
chown -R www-data:www-data /var/www/html/storage/logs
chmod -R 775 /var/www/html/storage/logs
chmod 664 /var/www/html/storage/logs/laravel.log

mkdir -p /var/www/html/public/assets
chown -R www-data:www-data /var/www/html/public/assets
chmod -R 755 /var/www/html/public/assets

# Clear & Cache Laravel config/routes/views
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Entrypoint completed. Starting PHP-FPM..."

exec "$@"
