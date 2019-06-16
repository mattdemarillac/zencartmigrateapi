FROM php:7.1-apache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN pecl install xdebug-2.7.0
RUN docker-php-ext-enable xdebug
COPY . /var/www/html
RUN echo "xdebug.remote_enable=1" >> /usr/local/etc/php/php.ini
VOLUME . /var/www/html
EXPOSE 80