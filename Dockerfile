FROM ubuntu:latest

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update && \
    apt-get install -y \
    sudo \
    nginx \
    php-fpm \
    php8.1 \
    php8.1-cli \
    php8.1-common \
    php8.1-curl \
    php8.1-mbstring \
    php8.1-mysql \
    php8.1-xml \
    php8.1-zip \
    php8.1-gd \
    php8.1-redis \
    php-pear \
    php-dev \
    php-xdebug \
    composer \
    mysql-client \
    redis-server \
    nodejs \
    npm \
    yarn && \
    rm -rf /var/lib/apt/lists/*

RUN mkdir -p /run/php/

COPY ./nginx/nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www/html

RUN echo "xdebug.mode=coverage" >> /etc/php/8.1/mods-available/xdebug.ini && \
    echo "xdebug.start_with_request=yes" >> /etc/php/8.1/mods-available/xdebug.ini && \
    sed -i 's/^listen =.*/listen = 9000/' /etc/php/8.1/fpm/pool.d/www.conf

EXPOSE 9000

CMD ["/usr/sbin/php-fpm8.1", "--nodaemonize"]
