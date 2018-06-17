FROM php:7.2-fpm-alpine

MAINTAINER Longjianghu <215241062@qq.com>

# 更换源
COPY ./source.list /etc/apk/repositories
RUN apk update

# 安装基础扩展
RUN apk add --no-cache --virtual .build-deps tzdata g++ make autoconf freetype \
    libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev gmp-dev libzip-dev imagemagick-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ -with-png-dir=/usr/include/ \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j$(nproc) gd zip gmp opcache pdo_mysql mysqli

# 安装增强扩展
COPY ./src/redis-4.0.2.tgz /tmp/redis-4.0.2.tgz
COPY ./src/swoole-4.0.0.tgz /tmp/swoole-4.0.0.tgz
COPY ./src/mongodb-1.4.4.tgz /tmp/mongodb-1.4.4.tgz
COPY ./src/imagick-3.4.3.tgz /tmp/imagick-3.4.3.tgz

RUN pecl install /tmp/redis-4.0.2.tgz && pecl install /tmp/swoole-4.0.0.tgz \
    && pecl install /tmp/mongodb-1.4.4.tgz && pecl install /tmp/imagick-3.4.3.tgz \
    && docker-php-ext-enable redis swoole mongodb imagick

# 时区设置
ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# 清除垃圾文件
RUN apk del .build-deps tzdata \
    && rm /var/cache/apk/* -rf \
    && rm /usr/src/* -rf \
    && rm /tmp/* -rf

# 设置工作目录
WORKDIR /usr/share/nginx/html

# Composer
COPY ./composer.phar /usr/bin/composer
RUN chmod a+x /usr/bin/composer
