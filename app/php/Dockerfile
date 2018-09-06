FROM php:7.2-fpm-alpine3.8

MAINTAINER Longjianghu <215241062@qq.com>

# 更换国内源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/g' /etc/apk/repositories
RUN apk update

ENV REDIS_VERSION 4.1.1
ENV MONGODB_VERSION 1.5.2
ENV IMAGICK_VERSION 3.4.3
ENV SWOOLE_VERSION 4.1.2

# 安装基础扩展
RUN apk add --no-cache --virtual .build-deps tzdata g++ make autoconf libzip libstdc++ gmp libpng libjpeg freetype imagemagick \
    freetype-dev libpng-dev jpeg-dev gmp-dev libzip-dev openssl-dev icu-dev imagemagick-dev imagemagick-libs \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/lib/ --with-jpeg-dir=/usr/lib/ -with-png-dir=/usr/lib/ \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j$(nproc) gd zip gmp opcache pdo_mysql mysqli intl pcntl exif

# 安装增强扩展
COPY ./src/* /tmp/
COPY ./composer.phar /usr/bin/composer

RUN pecl install /tmp/redis-${REDIS_VERSION}.tgz \
    && pecl install /tmp/swoole-${SWOOLE_VERSION}.tgz \
    && pecl install /tmp/mongodb-${MONGODB_VERSION}.tgz \
    && pecl install /tmp/imagick-${IMAGICK_VERSION}.tgz \
    && docker-php-ext-enable redis swoole mongodb imagick

# Tideways(PHP性能监控)
COPY ./extensions/tideways.ini /usr/local/etc/php/conf.d
COPY ./extensions/tideways.so /usr/local/lib/php/extensions/no-debug-non-zts-20170718

# 时区设置
ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# 清除垃圾文件
RUN rm /var/cache/apk/* -rf \
    && rm /usr/src/* -rf \
    && rm /tmp/* -rf \
    RUN chmod a+x /usr/bin/composer