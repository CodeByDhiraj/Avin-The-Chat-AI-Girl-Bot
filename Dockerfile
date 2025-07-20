FROM php:8.2-apache

# Enable Apache mod_rewrite (optional)
RUN a2enmod rewrite

# Copy all project files to Apache server root
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Give permission to SQLite file (important)
RUN chmod -R 777 /var/www/html/replies.db

EXPOSE 80
