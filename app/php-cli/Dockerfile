FROM php:7.2-cli-alpine3.8

MAINTAINER Longjianghu <215241062@qq.com>

# 更换国内源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/g' /etc/apk/repositories
RUN apk update

ENV REDIS_VERSION 4.1.1
ENV IMAGICK_VERSION 3.4.3
ENV INOTIFY_VERSION 2.0.0
ENV SWOOLE_VERSION 4.1.2

# 安装基础扩展
RUN apk add --no-cache --virtual .build-deps tzdata g++ make autoconf libzip libstdc++ gmp git libpng libjpeg freetype imagemagick \
    freetype-dev libpng-dev jpeg-dev gmp-dev libzip-dev openssl-dev icu-dev imagemagick-dev imagemagick-libs \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/lib/ --with-jpeg-dir=/usr/lib/ -with-png-dir=/usr/lib/ \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j$(nproc) gd zip gmp opcache pdo_mysql mysqli intl pcntl exif

# 安装增强扩展
COPY ./src/* /tmp/
COPY ./composer.phar /usr/local/bin/composer

RUN pecl install /tmp/redis-${REDIS_VERSION}.tgz \
    && pecl install /tmp/swoole-${SWOOLE_VERSION}.tgz \
    && pecl install /tmp/imagick-${IMAGICK_VERSION}.tgz \
    && pecl install /tmp/inotify-${INOTIFY_VERSION}.tgz \
    && docker-php-ext-enable redis swoole imagick inotify

# 时区设置
ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# 清除垃圾文件
RUN rm /var/cache/apk/* -rf \
    && rm /usr/src/* -rf \
    && rm /tmp/* -rf \
    && chmod a+x /usr/local/bin/composer

EXPOSE 80

CMD ["/bin/sh"]
