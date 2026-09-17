FROM node:20-slim AS assets
WORKDIR /var/www
COPY package*.json ./
RUN npm install
COPY resources ./resources
COPY vite.config.js ./
COPY public ./public
RUN npm run build

FROM php:8.4-cli

# Install Litestream for real-time SQLite syncing to Cloudflare R2
ADD https://github.com/benbjohnson/litestream/releases/download/v0.3.13/litestream-v0.3.13-linux-amd64.tar.gz /tmp/litestream.tar.gz
RUN tar -C /usr/local/bin -xzf /tmp/litestream.tar.gz

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

# Bring in compiled frontend assets (manifest.json + built css/js)
COPY --from=assets /var/www/public/build ./public/build

# Avoid Composer OOM on free-tier build machines, skip dev/test deps
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist

# Prepare sqlite db, storage link, cache config
RUN mkdir -p database && touch database/database.sqlite \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 10000

# Restore the database from R2, then run migrations and replicate while serving Laravel
CMD litestream restore -v -if-replica-exists -o /var/www/database/database.sqlite "s3://${AWS_BUCKET}/db?endpoint=${AWS_ENDPOINT}&region=us-east-1&forcePathStyle=true" \
    && php artisan migrate --force \
    && sqlite3 /var/www/database/database.sqlite "CREATE TABLE IF NOT EXISTS sessions (id VARCHAR(255) PRIMARY KEY NOT NULL, user_id INTEGER NULL, ip_address VARCHAR(45) NULL, user_agent TEXT NULL, payload TEXT NOT NULL, last_activity INTEGER NOT NULL); CREATE INDEX IF NOT EXISTS sessions_user_id_index ON sessions (user_id); CREATE INDEX IF NOT EXISTS sessions_last_activity_index ON sessions (last_activity);" \
    && php artisan storage:link || true \
    && php artisan config:cache \
    && litestream replicate -exec "php artisan serve --host 0.0.0.0 --port 10000" /var/www/database/database.sqlite "s3://${AWS_BUCKET}/db?endpoint=${AWS_ENDPOINT}&region=us-east-1&forcePathStyle=true"
