FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite
RUN sed -i 's|/var/www/html/public|/var/www/html|g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's|/var/www/html/public|/var/www/html|g' /etc/apache2/apache2.conf
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html
EXPOSE 80