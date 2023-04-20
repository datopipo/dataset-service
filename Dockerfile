# Base image
FROM php:7.4-apache

# Update packages and install necessary dependencies
RUN apt-get update && \
    apt-get install -y \
        git \
        zip \
        unzip \
        libmcrypt-dev \
        libjpeg-dev \
        libpng-dev \
        libfreetype6-dev \
        libbz2-dev \
        libzip-dev \
        libonig-dev \
        libxml2-dev \
        libcurl4-openssl-dev \
        libssl-dev \
        mysql-client \
        && docker-php-ext-install \
        pdo_mysql \
        bcmath \
        ctype \
        fileinfo \
        json \
        mbstring \
        xml \
        curl \
        zip

# Set working directory
WORKDIR /com.docker.devenvironments.code

# Copy the Laravel app to the working directory
COPY . .

# Copy the .env.example file to .env and set necessary variables
RUN cp .env.example .env \
    && sed -i 's/DB_HOST=127.0.0.1/DB_HOST=mysql/' .env \
    && sed -i 's/DB_DATABASE=laravel/DB_DATABASE=dataset/' .env \
    && sed -i 's/DB_USERNAME=root/DB_USERNAME=root/' .env \
    && sed -i 's/DB_PASSWORD=/DB_PASSWORD=2013/' .env

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies
RUN composer install --no-dev --no-scripts --no-autoloader && \
    composer dump-autoload --no-dev --optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Run migrations
RUN php artisan migrate

# Expose port 80 for Apache
EXPOSE 8000

# Start Apache and serve the Laravel app
CMD php artisan serve --host=127.0.0.1 --port=8000
