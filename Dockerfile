
# Use an official PHP runtime as a parent image
FROM php:7.4-fpm

# Set working directory
WORKDIR /var/www/html

# Copy application files to working directory
COPY . .

# Install required extensions
RUN apt-get update && apt-get install -y \
        libzip-dev \
        && docker-php-ext-install zip pdo_mysql git 

# Set environment variables
ENV DB_HOST=db
ENV DB_PORT=3306
ENV DB_DATABASE=my_db
ENV DB_USERNAME=my_user
ENV DB_PASSWORD=my_password

# Run database migrations
RUN php artisan migrate

# Expose the port
EXPOSE 80

CMD ["php-fpm"]
