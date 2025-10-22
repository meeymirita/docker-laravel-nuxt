скопировать [development.env](development.env) и вставить просто env

____
# В контейнере Laravel если 
### The /var/www/html/bootstrap/cache directory must be present and writable.
#### chown -R www-data:www-data bootstrap/cache 
#### chmod -R 775 bootstrap/cache
#### ls -la bootstrap/cache/

# Redis test
###  docker exec -it lesson-docker.redis redis-cli
#### 127.0.0.1:6379> AUTH secret -> secret -> пароль в [development.env](development.env)
#### > OK
#### 127.0.0.1:6379> ping
#### PONG
#### если не работает
#### [database.php](backend/config/database.php) 'host' => env('REDIS_HOST', 'redis'),