FROM php:7.2-fpm-alpine

MAINTAINER Longjianghu <215241062@qq.com>

# 更换源
COPY ./source.list /etc/apk/repositories
RUN apk update

# 时区设置
ENV TIMEZONE Asia/Shanghai

RUN apk add tzdata
RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime
RUN echo $TIMEZONE > /etc/timezone

# Composer
COPY ./composer.phar /usr/bin/composer
RUN composer config -g repo.packagist composer https://packagist.phpcomposer.com

# 安装扩展
RUN docker-php-ext-install mbstring opcache pdo pdo_mysql mysqli
RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev gmp-dev && \
    docker-php-ext-configure gd \
      --with-gd \
      --with-freetype-dir=/usr/include/ \
      --with-png-dir=/usr/include/ \
      --with-jpeg-dir=/usr/include/ \
      --with-zlib-dir=/usr && \
        docker-php-ext-install -j$(nproc) gd zip gmp && \
apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev gmp-dev

# PECL 安装扩展
RUN pecl install redis-4.0.2 swoole-2.2.0 \
   && docker-php-ext-enable redis swoole

# 设置工作目录
WORKDIR /usr/share/nginx/html