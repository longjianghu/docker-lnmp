FROM php:7.2.12-fpm-alpine3.8

MAINTAINER Longjianghu <215241062@qq.com>

# 更换国内源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && apk update

ENV TIMEZONE Asia/Shanghai
ENV REDIS_VERSION 4.1.1
ENV MONGODB_VERSION 1.5.2
ENV IMAGICK_VERSION 3.4.3
ENV SWOOLE_VERSION 4.2.6

# 安装基础扩展
RUN apk add --no-cache --virtual .build-deps tzdata g++ make autoconf git \
    freetype-dev libpng-dev jpeg-dev gmp-dev libzip-dev openssl-dev icu-dev nghttp2-dev imagemagick-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/lib/ --with-jpeg-dir=/usr/lib/ -with-png-dir=/usr/lib/ \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j$(nproc) gd zip gmp opcache pdo_mysql mysqli intl pcntl exif sockets

# 安装增强扩展
COPY ./src/* /tmp/
COPY ./composer.phar /usr/local/bin/composer

# Swoole
RUN mkdir /tmp/swoole && tar -zxf /tmp/swoole-src-${SWOOLE_VERSION}.tar.gz -C /tmp/swoole --strip-components=1 \
    && ( \
        cd /tmp/swoole \
        && phpize \
        && ./configure --enable-coroutine --enable-openssl --enable-http2 --enable-async-redis --enable-sockets --enable-mysqlnd \
        && make -j$(nproc) && make install \
    ) \
    && docker-php-ext-enable swoole

# Redis / Mongodb / Imagick
RUN pecl install /tmp/redis-${REDIS_VERSION}.tgz \
    && pecl install /tmp/mongodb-${MONGODB_VERSION}.tgz \
    && pecl install /tmp/imagick-${IMAGICK_VERSION}.tgz \
    && docker-php-ext-enable redis mongodb imagick

# Tideways
COPY ./extensions/ini/tideways.ini /usr/local/etc/php/conf.d/
COPY ./extensions/so/tideways.so /usr/local/lib/php/extensions/no-debug-non-zts-20170718/

# 时区设置
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# 清除垃圾文件
RUN apk del --purge *-dev \
    && rm /var/cache/apk/* -rf \
    && rm /usr/src/* -rf \
    && rm /tmp/* -rf \
    && chmod a+x /usr/local/bin/composer