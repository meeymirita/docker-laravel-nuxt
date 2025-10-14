#!/bin/bash
set -e

chown -R www-data:www-data /var/www/html/storage
cd /var/www/html && cp .env.example .env

echo "Ожидание MySQL..."
while ! nc -z mysql 3306; do
  sleep 1
done
echo "MySQL доступен!"

cd /var/www/html && composer install && php artisan storage:link && php artisan key:generate && php artisan migrate

exec "$@"
