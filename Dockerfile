FROM php:7.4-apache

# Install Apache
RUN apt-get update && \
    apt-get install -y apache2

# Enable Apache modules
RUN a2enmod rewrite && \
    a2enmod headers

# Update Apache configuration
COPY docker/apache2.conf /etc/apache2/sites-available/000-default.conf

# Set the working directory
WORKDIR /var/www/html

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
EXPOSE 80

# Start Apache
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
