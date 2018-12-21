FROM alpine:3.8

MAINTAINER Longjianghu <215241062@qq.com>

ENV TIMEZONE=Asia/Shanghai \
    GEARMAND_VERSION=1.1.18 \
    GEARMAN_VERSION=2.0.5 \
    SWOOLE_VERSION=4.2.10 \
    MSGPACK_VERSION=2.0.2

COPY ./src/* /tmp/
COPY ./composer.phar /usr/local/bin/composer
COPY ./docker-entrypoint /usr/local/bin/docker-entrypoint.sh

RUN set -xe \
    && sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && apk update \
    && apk add --no-cache --virtual .build-deps \
        file \
        alpine-sdk \
        gperf \
        boost-dev \
        libevent-dev \
        util-linux-dev \
        hiredis-dev \
        libressl-dev \
        nghttp2-dev \
        hiredis-dev \
        pcre-dev \
        tzdata \
    && mkdir -p /tmp/gearmand \
    && tar -xzf /tmp/gearmand-${GEARMAND_VERSION}.tar.gz -C /tmp/gearmand --strip-components=1 \
    && ( \
        cd /tmp/gearmand \
        && patch -p1 < /tmp/libhashkit-common.h.patch \
        && patch -p1 < /tmp/libtest-cmdline.cc.patch \
        && ./configure && make -j$(nproc) && make install \
    ) \
    && apk add php7 \
        php7-intl \
        php7-pcntl \
        php7-openssl \
        php7-sockets \
        php7-dba \
        php7-sqlite3 \
        php7-tokenizer \
        php7-phpdbg \
        php7-litespeed \
        php7-gmp \
        php7-pdo_mysql \
        php7-common \
        php7-xsl \
        php7-imagick \
        php7-mysqlnd \
        php7-enchant \
        php7-pspell \
        php7-redis \
        php7-snmp \
        php7-doc \
        php7-fileinfo \
        php7-mbstring \
        php7-dev \
        php7-xmlrpc \
        php7-embed \
        php7-xmlreader \
        php7-pdo_sqlite \
        php7-exif \
        php7-recode \
        php7-opcache \
        php7-ldap \
        php7-session \
        php7-gd \
        php7-gettext \
        php7-mailparse \
        php7-json \
        php7-xml \
        php7-iconv \
        php7-sysvshm \
        php7-curl \
        php7-shmop \
        php7-odbc \
        php7-phar \
        php7-pdo_pgsql \
        php7-imap \
        php7-pdo_dblib \
        php7-pgsql \
        php7-pdo_odbc \
        php7-zip \
        php7-cgi \
        php7-ctype \
        php7-amqp \
        php7-mcrypt \
        php7-wddx \
        php7-bcmath \
        php7-calendar \
        php7-tidy \
        php7-dom \
        php7-zmq \
        php7-soap \
        php7-apcu \
        php7-zlib \
        php7-ftp \
        php7-sysvsem \
        php7-pdo \
        php7-bz2 \
        php7-mysqli \
        php7-simplexml \
        php7-xmlwriter \
        php7-posix \
        php7-mongodb \
    && ( \
        mkdir -p /tmp/swoole \
        && tar -xf /tmp/swoole-src-${SWOOLE_VERSION}.tar.gz -C /tmp/swoole --strip-components=1 \
        && cd /tmp/swoole \
        && phpize \
        && ./configure --with-php-config=/usr/bin/php-config --enable-async-redis --enable-mysqlnd --enable-openssl --enable-http2 \
        && make -j$(nproc) && make install \
        && echo "extension=swoole.so" > /etc/php7/conf.d/swoole.ini \
    ) \
    && ( \
        mkdir -p /tmp/gearman \
        && tar -xf  /tmp/gearman-${GEARMAN_VERSION}.tar.gz -C /tmp/gearman  --strip-components=1 \
        && cd /tmp/gearman \
        && phpize \
        && ./configure \
        && make -j$(nproc) && make install \
        && echo "extension="gearman.so"" > /etc/php7/conf.d/gearman.ini \
    )\
    && ( \
        mkdir -p /tmp/msgpack \
        && tar -xf  /tmp/msgpack-${MSGPACK_VERSION}.tar.gz -C /tmp/msgpack  --strip-components=1 \
        && cd /tmp/msgpack \
        && phpize \
        && ./configure \
        && make -j$(nproc) && make install \
        && echo "extension="msgpack.so"" > /etc/php7/conf.d/msgpack.ini \
    )\
    && sed -i 's|^upload_max_filesize = 2M$|upload_max_filesize = 20M|' /etc/php7/php.ini \
    && sed -i 's|^post_max_size = 8M$|post_max_size = 20M|' /etc/php7/php.ini \
    && sed -i 's|^;date.timezone =$|date.timezone = Asia/Shanghai|' /etc/php7/php.ini \
    && sed -i 's|^expose_php = On$|expose_php = Off|' /etc/php7/php.ini \
    && ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && apk del .build-deps --purge *-dev && rm /tmp/* -rf

RUN chmod 755 /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

# 清除垃圾文件
RUN rm /var/cache/apk/* -rf \
    && rm /usr/src/* -rf \
    && rm /tmp/* -rf \
    && chmod a+x /usr/local/bin/composer

EXPOSE 80 8099

CMD ['/bin/sh']