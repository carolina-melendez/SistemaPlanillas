FROM php:8.2-apache

EXPOSE 80

# Install dependencies
RUN apt-get update -y && apt-get -y install curl libpq-dev zlib1g-dev libpng-dev libzip-dev
#&& apt-get -y install git zlib1g-dev libpng-dev libzip-dev curl nano
RUN docker-php-ext-install pgsql pdo pdo_pgsql gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Enable mod_rewrite
RUN a2enmod rewrite


# Copy Apache configuration and PHP configuration
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
# COPY php.ini "$PHP_INI_DIR/php.ini"

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /app

# Copy source code
COPY . /app

# Copy .env file
COPY .env /app/.env

# Ensure deploy.sh is executable
RUN chmod +x /app/deploy.sh

# Set environment variable for Composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Run the deploy script and then start Apache
CMD ["/bin/bash", "-c", "/app/deploy.sh && a2enmod rewrite"]
 