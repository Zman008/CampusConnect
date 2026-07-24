FROM php:8.3-cli

# Install system deps needed to build PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libsqlite3-dev sqlite3 \
    libonig-dev libxml2-dev libcurl4-openssl-dev \
    && rm -rf /var/lib/apt/lists/*

# Use the extension installer script (handles compiling + enabling reliably)
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/

# Install every extension Laravel + common packages need
RUN install-php-extensions pdo pdo_sqlite zip mbstring xml dom curl fileinfo bcmath ctype tokenizer

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy app code
COPY . .

# Avoid Composer OOM on free-tier build machines, skip dev/test deps
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

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