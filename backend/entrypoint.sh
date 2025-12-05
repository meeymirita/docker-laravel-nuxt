#!/bin/bash
set -e

echo "🔄 Настройка Laravel приложения..."

# ========== ВЫБОР ПРАВИЛЬНОГО SUPERVISORD КОНФИГА ==========
if [ "$APP_ENV" = "production" ]; then
    echo "📋 Используем PRODUCTION supervisord конфиг"
    if [ -f /var/www/html/docker/supervisord.prod.conf ]; then
        cp /var/www/html/docker/supervisord.prod.conf /etc/supervisor/conf.d/supervisord.conf
    else
        echo "⚠️  Production конфиг не найден, используем local"
        cp /var/www/html/docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
    fi
else
    echo "📋 Используем LOCAL supervisord конфиг"
    cp /var/www/html/docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
fi

echo "✅ Supervisord конфиг настроен для $APP_ENV"

# ========== ОСТАЛЬНОЙ КОД (оставляем как есть) ==========
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
mkdir -p /var/www/html/bootstrap/cache
mkdir -p /var/www/html/storage/logs

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

echo "Ожидание RabbitMQ..."
while ! nc -z rabbitmq 5672; do
  sleep 1
done
echo "✅ RabbitMQ доступен!"

if [ ! -d /var/www/html/vendor ] || [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "Установка Composer зависимостей..."
    composer install --no-dev --optimize-autoloader
fi

echo "Настройка Laravel..."
php artisan storage:link
php artisan key:generate
php artisan migrate --force

echo "Laravel приложение готово!"
echo "Запускаем PHP-FPM и Queue Worker через Supervisord..."

# Запускаем Supervisord
exec "$@"
