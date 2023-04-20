# Specify the base image
FROM php:7.4-apache

# Set the working directory
WORKDIR /var/www/html

# Copy the application files to the container
COPY . /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Expose the port
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
