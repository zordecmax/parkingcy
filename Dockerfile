# Simple development Dockerfile (PHP 8.2)
# Runs Laravel via built-in PHP server.

FROM php:8.2-cli

# System deps for common Laravel/PHP extensions + Composer tooling
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        zip \
        libonig-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions commonly needed by Laravel apps
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        bcmath \
        exif \
        gd \
        mbstring \
        pdo \
        pdo_mysql \
        zip

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html

# Copy app source (required because Laravel runs post-autoload scripts)
COPY . .

# Laravel expects these directories to exist and be writable
RUN mkdir -p \
        bootstrap/cache \
        storage \
        storage/app \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/framework/testing \
        storage/logs \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R ug+rwx storage bootstrap/cache

# Install PHP dependencies (dev-friendly; can be overridden by bind-mount)
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --no-progress --prefer-dist

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
