# Use the official PHP image as a base
FROM php:8.2.12-fpm

RUN echo "deb http://deb.debian.org/debian/ buster main" >> /etc/apt/sources.list \
    && echo "deb http://security.debian.org/debian-security buster/updates main" >> /etc/apt/sources.list \
    && echo "deb http://deb.debian.org/debian/ buster-updates main" >> /etc/apt/sources.list

# Install necessary extensions and dependencies
RUN apt-get update && apt-get install -y \
    nginx \
    cron \
    supervisor \
    git \
    zip \
    unzip \
    libpcre3-dev \
    curl \
    libgd-dev \
    libmagickwand-dev \
    libssl-dev \
    libpq-dev \
    libmemcached-dev \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install phalcon

# Enable Phalcon extension
RUN echo "extension=phalcon.so" > /usr/local/etc/php/conf.d/50-phalcon.ini

# Install additional PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV PATH="${PATH}:/root/.composer/vendor/bin"

RUN git clone https://github.com/phalcon/phalcon-devtools.git /usr/local/phalcon-devtools

# Make Phalcon DevTools globally accessible
RUN ln -s /usr/local/phalcon-devtools/phalcon /usr/local/bin/phalcon \
    && chmod +x /usr/local/phalcon-devtools/phalcon

# Copy Nginx configuration and entrypoint script
COPY docker/nginx/default.conf /etc/nginx/sites-enabled/default
COPY docker/nginx/entrypoint.sh /etc/entrypoint.sh
RUN apt-get update && apt-get install -y dos2unix \
    && dos2unix /etc/entrypoint.sh \
    && chmod +x /etc/entrypoint.sh


COPY docker/nginx/supervisord.conf /etc/supervisor.conf

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

COPY ./var/cache /var/www/html/app/cache
RUN chmod -R 777 /var/www/html/app/cache
# Expose ports
EXPOSE 80 443

# Set entrypoint
ENTRYPOINT ["/etc/entrypoint.sh"]