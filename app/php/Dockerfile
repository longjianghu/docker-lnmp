FROM php:7.2-fpm-alpine

MAINTAINER Longjianghu <215241062@qq.com>

# 更换源
COPY ./source.list /etc/apk/repositories
RUN apk update

# 安装基础扩展
RUN apk add --no-cache --virtual .build-deps tzdata g++ make autoconf libzip libstdc++ gmp libpng libjpeg freetype \
    freetype-dev curl-dev libpng-dev jpeg-dev gmp-dev libzip-dev openssl-dev\
    && docker-php-ext-configure gd --with-freetype-dir=/usr/lib/ --with-jpeg-dir=/usr/lib/ -with-png-dir=/usr/lib/ \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j$(nproc) gd zip curl gmp opcache pdo_mysql mysqli

# 安装增强扩展
COPY ./src/redis-4.0.2.tgz /tmp/redis-4.0.2.tgz
COPY ./src/swoole-4.0.0.tgz /tmp/swoole-4.0.0.tgz
COPY ./src/mongodb-1.5.0.tgz /tmp/mongodb-1.5.0.tgz

COPY ./extensions/tideways.ini /usr/local/etc/php/conf.d
COPY ./extensions/tideways.so /usr/local/lib/php/extensions/no-debug-non-zts-20170718

RUN pecl install /tmp/redis-4.0.2.tgz && pecl install /tmp/swoole-4.0.0.tgz \
    && pecl install /tmp/mongodb-1.5.0.tgz \
    && docker-php-ext-enable redis swoole mongodb

# 时区设置
ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# 清除垃圾文件
RUN rm /var/cache/apk/* -rf \
    && rm /usr/src/* -rf \
    && rm /tmp/* -rf

# Composer
COPY ./composer.phar /usr/bin/composer
RUN chmod a+x /usr/bin/composer && su www-data -c "composer config -g repo.packagist composer https://packagist.phpcomposer.com"
