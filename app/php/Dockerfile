FROM php:7.2-fpm-alpine

MAINTAINER Longjianghu <215241062@qq.com>

# 更换源
COPY ./source.list /etc/apk/repositories
RUN apk update

# 时区设置
ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# 安装基础扩展
RUN apk add --no-cache --virtual .build-deps g++ make autoconf freetype \
    libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev gmp-dev libzip-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ -with-png-dir=/usr/include/ \
    && docker-php-ext-configure zip --with-libzip \
	&& docker-php-ext-install -j$(nproc) gd zip gmp opcache pdo_mysql mysqli

# 安装增强扩展
COPY ./src/redis-4.0.2.tgz /tmp/redis-4.0.2.tgz
COPY ./src/swoole-4.0.0.tgz /tmp/swoole-4.0.0.tgz

RUN pecl install /tmp/redis-4.0.2.tgz && pecl install /tmp/swoole-4.0.0.tgz \
	&& docker-php-ext-enable redis swoole

# 清除垃圾文件
RUN rm /var/cache/apk/* -rf \
	&& rm /usr/src/* -rf \
	&& rm /tmp/* -rf

# 设置工作目录
WORKERDIR /usr/share/nginx/html

# Composer
COPY ./composer.phar /usr/bin/composer
RUN chmod a+x /usr/bin/composer
