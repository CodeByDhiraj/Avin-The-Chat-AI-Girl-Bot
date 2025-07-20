FROM php:8.2-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy all project files to Apache server root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Create empty replies.db if not exists, then give permission
RUN touch replies.db && chmod -R 777 replies.db

EXPOSE 80
