# Dockerfile
FROM php:latest
# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpq-dev \
    unzip \
    libsodium-dev
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql sodium
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Set working directory
WORKDIR /var/www
# Copy existing application directory contents
COPY ./app/2πR/ .
# Install PHP dependencies
RUN composer install --no-scripts
# Expose port 8000
EXPOSE 8000
# Start Symfony server
# Run migrations and start Symfony server
CMD composer install && php bin/console doctrine:migrations:migrate --no-interaction && php -S 0.0.0.0:8000 -t public
