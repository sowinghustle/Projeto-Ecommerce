FROM php:7.4-apache

# Enable .htaccess overrides
RUN a2enmod rewrite headers

# Add mysql and pdo support
RUN docker-php-ext-install mysqli pdo_mysql
