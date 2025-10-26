FROM docker.io/php:8.2.29-fpm

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
    netcat-openbsd

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Установка Redis через PECL
RUN pecl install redis && docker-php-ext-enable redis

RUN docker-php-ext-configure gd --with-jpeg --with-webp

COPY --from=docker.io/composer:2.8.12 /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install zip pdo_mysql mbstring exif pcntl bcmath gd intl gmp sockets

RUN docker-php-ext-enable gd

WORKDIR /var/www/html

COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm", "-F"]
