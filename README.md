# Docker + Laravel + Nuxt

## Скопировать файлик
cp development.env .env

## Запустить
docker compose up -d
____
## ⚠️ Решение проблем Laravel
# В контейнере Laravel если такая ошибка при первом старте
## The /var/www/html/bootstrap/cache directory must be present and writable.
### docker compose exec laravel chown -R www-data:www-data bootstrap/cache
### docker compose exec laravel chmod -R 775 bootstrap/cache

#### docker compose exec laravel ls -la bootstrap/cache/

____

## 🔥 Тестирование Redis

# Redis test
### docker exec -it lesson-docker.redis redis-cli
#### 127.0.0.1:6379> AUTH secret
#### > OK
#### 127.0.0.1:6379> ping
#### PONG

# если не работает
### Проверить конфигурацию в [database.php](backend/config/database.php)
'redis' => [
'host' => env('REDIS_HOST', 'redis'),  # Должно быть 'redis' (имя контейнера)
'password' => env('REDIS_PASSWORD', null),
'port' => env('REDIS_PORT', 6379),
],

____

## 🌐 Доступ к сервисам

### http://localhost:8080 - Laravel 
### http://localhost:3000 - Nuxt.js 
### http://localhost:15672 - RabbitMQ Management (admin/secret)
### http://localhost:3306 - phpMyAdmin

# Подключение к базе данных
### либо через Data sources
### connection=mysql, host=mysql, port=3306, db=laravel, username=root, password=password

____

## 🗄️ Порты сервисов

### 3307:3306 - MySQL база данных
### 6379:6379 - Redis кэширование
### 5672:5672 - RabbitMQ брокер
### 15672:15672 - RabbitMQ Management
### 8080 - Laravel
### 3000 - Nuxt.js приложение
### 3306 - phpMyAdmin

____

## 🛠 для меня

# Остановить всё
docker compose down

# логи
## docker compose logs -f laravel
## docker compose logs -f nginx
## docker compose logs -f mysql

# Пересобрать контейнеры
docker compose up -d --build

# Проверить статус контейнеров
docker compose ps

____

## 🔧 Конфигурация Laravel

# Войти в контейнер Laravel
docker compose exec laravel bash

# Очистка кэша
docker compose exec laravel php artisan cache:clear
docker compose exec laravel php artisan config:clear
docker compose exec laravel php artisan route:clear
docker compose exec laravel php artisan optimize:clear
____
## 🎯 
# Перезапустить все сервисы
docker compose restart

# Пересборка с очисткой 
docker compose down --volumes --remove-orphans
docker compose up -d --build
