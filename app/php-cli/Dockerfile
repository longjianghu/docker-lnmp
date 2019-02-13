FROM php:7.3.0-cli-alpine3.8

MAINTAINER Longjianghu <215241062@qq.com>

# 更换国内源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && apk update

# 环境配置
ENV TIMEZONE=Asia/Shanghai \
    GEARMAND_VERSION=1.1.18 \
    GEARMAN_VERSION=2.0.5 \
    REDIS_VERSION=4.1.1 \
    MONGODB_VERSION=1.5.2 \
    IMAGICK_VERSION=3.4.3 \
    SWOOLE_VERSION=4.2.13

# 安装扩展
COPY ./src/* /tmp/
COPY ./composer.phar /usr/local/bin/composer

RUN set -xe \
    && apk add --no-cache --virtual .build-deps tzdata g++ make autoconf git \
    freetype-dev libpng-dev jpeg-dev gmp-dev libzip-dev openssl-dev icu-dev nghttp2-dev imagemagick-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/lib/ --with-jpeg-dir=/usr/lib/ -with-png-dir=/usr/lib/ \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j$(nproc) gd zip gmp opcache pdo_mysql mysqli intl pcntl exif sockets \
    && mkdir /tmp/swoole && tar -zxf /tmp/swoole-src-${SWOOLE_VERSION}.tar.gz -C /tmp/swoole --strip-components=1 \
    && ( \
        cd /tmp/swoole \
        && phpize \
        && ./configure --enable-openssl --enable-http2 --enable-sockets --enable-mysqlnd \
        && make -j$(nproc) && make install \
        && rm /tmp/swoole* -rf \
    ) \
    && pecl install /tmp/redis-${REDIS_VERSION}.tgz \
    && pecl install /tmp/mongodb-${MONGODB_VERSION}.tgz \
    && pecl install /tmp/imagick-${IMAGICK_VERSION}.tgz \
    && docker-php-ext-enable swoole redis mongodb imagick \
    && apk del --purge *-dev

# 时区设置
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# 清除垃圾文件
RUN rm /var/cache/apk/* -rf \
    && rm /usr/src/* -rf \
    && rm /tmp/* -rf \
    && chmod a+x /usr/local/bin/composer

EXPOSE 80 8099

CMD ['/bin/sh']
