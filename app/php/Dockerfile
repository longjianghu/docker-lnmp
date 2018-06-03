FROM php:7.2-fpm-alpine

MAINTAINER Longjianghu <215241062@qq.com>

# 更换源
COPY ./source.list /etc/apk/repositories
RUN apk update

# 安装扩展
RUN apk add --no-cache --virtual .build-deps bash bash-completion tzdata g++ make autoconf freetype \
    libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev gmp-dev && \
    docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
    --with-zlib-dir=/usr && docker-php-ext-install -j$(nproc) gd zip gmp opcache pdo_mysql mysqli \
	&& pecl install redis-4.0.2 swoole-2.2.0 \
    && docker-php-ext-enable redis swoole

# 时区设置
ENV TIMEZONE Asia/Chongqing
RUN echo ${TIMEZONE} > /etc/timezone

# 清除垃圾文件
RUN apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev gmp-dev .build-deps \
        && rm /var/cache/apk/* -rf \
        && rm /usr/src/* -rf \
        && rm /tmp/* -rf

# Composer
COPY ./composer.phar /usr/bin/composer

# 设置工作目录
WORKDIR /usr/share/nginx/html