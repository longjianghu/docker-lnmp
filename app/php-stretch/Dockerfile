FROM php:7.2.12-cli-stretch

MAINTAINER Longjianghu <215241062@qq.com>

# 更换国内源
RUN sed -i 's/deb.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list && apt-get update

# 环境配置
ENV TIMEZONE=Asia/Shanghai \
    REDIS_VERSION=4.1.1 \
    MONGODB_VERSION=1.5.2 \
    IMAGICK_VERSION=3.4.3 \
    SWOOLE_VERSION=4.2.7 \
    GEARMAN_VERSION=2.0.5

# 安装基础扩展
RUN apt-get install -y --no-install-recommends git libjpeg62-turbo-dev libpng-dev libfreetype6-dev \
	libzip-dev libgmp-dev libicu-dev libssl-dev libnghttp2-dev libmagickwand-dev libgearman-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/lib/ --with-jpeg-dir=/usr/lib/ -with-png-dir=/usr/lib/ \
    && docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install -j$(nproc) gd zip gmp opcache pdo_mysql mysqli intl pcntl exif sockets

# 安装增强扩展
COPY ./src/* /tmp/
COPY ./composer.phar /usr/local/bin/composer

# Swoole / Gearman
RUN mkdir /tmp/swoole && tar -zxf /tmp/swoole-src-${SWOOLE_VERSION}.tar.gz -C /tmp/swoole --strip-components=1 \
    && ( \
        cd /tmp/swoole \
        && phpize \
        && ./configure --enable-openssl --enable-http2 --enable-sockets --enable-mysqlnd \
        && make -j$(nproc) && make install \
    ) \
    && mkdir /tmp/gearman && tar -zxf /tmp/gearman-${GEARMAN_VERSION}.tar.gz -C /tmp/gearman --strip-components=1 \
    && ( \
        cd /tmp/gearman \
        && phpize \
        && ./configure --with-php-config=/usr/local/bin/php-config \
        && make -j$(nproc) && make install \
    ) \
    && docker-php-ext-enable swoole gearman
	
# Redis / Mongodb / Imagick
RUN pecl install /tmp/redis-${REDIS_VERSION}.tgz \
    && pecl install /tmp/mongodb-${MONGODB_VERSION}.tgz \
    && pecl install /tmp/imagick-${IMAGICK_VERSION}.tgz \
    && docker-php-ext-enable redis mongodb imagick

# 时区设置
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

# 清除垃圾文件
RUN apt-get clean && rm /tmp/* -rf && rm /var/lib/apt/lists/* -rf \
    && chmod a+x /usr/local/bin/composer

EXPOSE 80 8099

CMD ['/bin/sh']