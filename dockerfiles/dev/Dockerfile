FROM php:7.2-apache
#RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install pdo_mysql
RUN apt-get update -y && apt-get install -y sendmail libpng-dev
RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev 
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install gd

RUN a2enmod rewrite headers
RUN chown -R www-data /var/www/html
RUN usermod -u 1000 www-data

# XDEBUG FOR DEV DEBUG
RUN pecl install -f xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini;