#!/bin/bash
set -e

mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/bootstrap/cache

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

if [ ! -f /var/www/html/.env ]; then
    cp .env.example .env
    echo "Создан файл .env из примера"
fi

echo "Ожидание MySQL..."
while ! nc -z mysql 3306; do
  sleep 1
done
echo "✅ MySQL доступен!"

echo "Ожидание Redis..."
while ! nc -z redis 6379; do
  sleep 1
done
echo "✅ Redis доступен!"

if [ ! -d /var/www/html/vendor ] || [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "Установка Composer зависимостей..."
    composer install --no-dev --optimize-autoloader
fi

echo "Настройка Laravel..."
php artisan storage:link
php artisan key:generate
php artisan migrate --force

echo "✅ Laravel приложение готово!"
exec "$@"
