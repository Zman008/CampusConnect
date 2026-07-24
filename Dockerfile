FROM php:8.3-cli

# Install system deps + PHP extensions Laravel needs
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libsqlite3-dev sqlite3 \
    && docker-php-ext-install pdo pdo_sqlite zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app code
COPY . .

# Install PHP deps
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Prepare sqlite db, storage link, cache config
RUN mkdir -p database && touch database/database.sqlite \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Run migrations then start the built-in server on Render's expected port
CMD php artisan migrate --force \
    && php artisan storage:link || true \
    && php artisan config:cache \
    && php artisan serve --host 0.0.0.0 --port 10000
