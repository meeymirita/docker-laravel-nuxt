#FROM php:8.2.29-fpm
FROM php:8.4-fpm

# Устанавливаем необходимые пакеты + supervisor
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zlib1g-dev \
    libicu-dev \
    libgmp-dev \
    libjpeg-dev \
    libwebp-dev \
    netcat-openbsd \
    redis-tools \
    supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Устанавливаем расширения PHP
RUN pecl install redis && docker-php-ext-enable redis
RUN docker-php-ext-configure gd --with-jpeg --with-webp
RUN docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd intl gmp sockets
RUN docker-php-ext-enable gd

# Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

# Рабочая директория
WORKDIR /var/www/html

# Копируем конфиг Supervisord
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Копируем entrypoint
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]

# Меняем CMD на Supervisord
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
