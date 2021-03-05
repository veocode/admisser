FROM php:7.3-apache

ENV TERM=xterm

# SYSTEM SETUP
RUN apt-get update -y
RUN apt-get install -y --no-install-recommends apt-utils \
    && apt-get install -y sendmail \
    && apt-get install -y libpng-dev \
    && apt-get install -y libjpeg62-turbo-dev \
    && apt-get install -y libfreetype6-dev \
    && apt-get install -y libxml2-dev \
    && apt-get install -y libzip-dev \
    && apt-get install -y libmcrypt-dev \
    && apt-get install -y libicu-dev \
    && apt-get install -y zlib1g-dev \
    && apt-get install -y git

# APACHE SETUP
RUN a2enmod rewrite
RUN service apache2 restart

# PHP EXTENSIONS
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install opcache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install zip
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(nproc) gd
RUN pecl install xdebug && docker-php-ext-enable xdebug

# CUSTOM CONF DIRECTORY
RUN mkdir /opt/custom.conf

# PHP CONFIGURATION LINKS
RUN mkdir /opt/custom.conf/php
COPY ./services/php/php.ini /opt/custom.conf/php/php.ini
WORKDIR /usr/local/etc/php
RUN ln -s /opt/custom.conf/php/php.ini php.ini

# APACHE CONFIGURATION LINKS
RUN mkdir /opt/custom.conf/apache
COPY ./services/apache/conf/ /opt/custom.conf/apache/
WORKDIR /etc/apache2
RUN rm -f apache2.conf \
    sites-available/000-default.conf
RUN ln -s /opt/custom.conf/apache/apache2.conf apache2.conf
RUN ln -s /opt/custom.conf/apache/site.conf sites-available/000-default.conf

# INSTALLING COMPOSER
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# GENERATING SSH KEYS
RUN cat /dev/zero | ssh-keygen -q -N ""

# SET FINAL WORKING DIRECTORY
WORKDIR /var/www/html
