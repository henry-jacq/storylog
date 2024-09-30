# Use an official PHP image with Apache
FROM php:8.1-apache

# Install necessary system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    nodejs \
    npm \
    openssl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mbstring zip exif pcntl \
    && docker-php-ext-enable gd pdo_mysql mbstring zip exif pcntl

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable required Apache modules
RUN a2enmod headers rewrite actions expires deflate socache_shmcb ssl

# Set Apache to serve from /var/www/html/public and configure the directory
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|' /etc/apache2/sites-available/000-default.conf \
    && echo "<Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>" >> /etc/apache2/sites-available/000-default.conf

# Copy the application code
WORKDIR /var/www/html
COPY . /var/www/html

# Set ownership and permissions for Apache
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Restart Apache to apply changes
RUN service apache2 restart
