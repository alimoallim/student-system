FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libxml2-dev \
    libonig-dev \
    libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip

# Copy composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app
COPY backend /var/www

# Install Laravel dependencies
RUN composer install

# Copy nginx config
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

# Fix permissions
RUN chown -R www-data:www-data /var/www

# Expose port
EXPOSE 80

# Start services
CMD service nginx start && php-fpm
