FROM php:8.2-apache
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/0000-default.conf /etc/apache2/sites-available/default-ssl.conf
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html 
RUN chmod -R 755 /var/www/html
