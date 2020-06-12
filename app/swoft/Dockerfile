FROM alpine:3.11

MAINTAINER Longjianghu <215241062@qq.com>

ENV TIMEZONE=Asia/Shanghai \
    SWOOLE_VERSION=4.5.2 \
    MSGPACK_VERSION=2.0.3 \
    NSQ_VERSION=3.5.0 \
    MONGO_VERSION=1.7.4

COPY ./src/* /tmp/
COPY ./composer.phar /usr/local/bin/composer
COPY ./swoftcli.phar /usr/local/bin/swoftcli
COPY ./docker-entrypoint /usr/local/bin/docker-entrypoint.sh

RUN set -xe \
    && sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && apk update \
    && apk add --no-cache --virtual .build-deps g++ make libressl-dev openssl-dev libevent-dev \
    && apk add php7 \
        php7-dev \ 
        php7-bcmath \
        php7-bz2 \
        php7-calendar \
        php7-common \
        php7-ctype \
        php7-curl \
        php7-dba \
        php7-doc \
        php7-dom \
        php7-embed \
        php7-enchant \
        php7-exif \
        php7-fileinfo \
        php7-fpm \
        php7-ftp \
        php7-gd \
        php7-gettext \
        php7-gmp \
        php7-iconv \
        php7-imap \
        php7-intl \
        php7-json \
        php7-ldap \
        php7-litespeed \
        php7-mbstring \
        php7-mysqli \
        php7-mysqlnd \
        php7-odbc \
        php7-opcache \
        php7-openssl \
        php7-pcntl \
        php7-pdo \
        php7-pdo_dblib \
        php7-pdo_mysql \
        php7-pdo_odbc \
        php7-pdo_pgsql \
        php7-pdo_sqlite \
        php7-pear \
        php7-pgsql \
        php7-phar \
        php7-phpdbg \
        php7-posix \
        php7-pspell \
        php7-recode \
        php7-session \
        php7-shmop \
        php7-simplexml \
        php7-soap \
        php7-sockets \
        php7-sodium \
        php7-sqlite3 \
        php7-sysvmsg \
        php7-sysvsem \
        php7-sysvshm \
        php7-tidy \
        php7-tokenizer \
        php7-wddx \
        php7-xml \
        php7-xmlreader \
        php7-xmlrpc \
        php7-xmlwriter \
        php7-xsl \
        php7-zip \
        php7-redis \
        php7-imagick \
        php7-memcached \
        && pecl install /tmp/mongodb-${MONGO_VERSION}.tgz \
        && ( \
            mkdir -p /tmp/swoole \
            && tar -xf /tmp/swoole-src-${SWOOLE_VERSION}.tar.gz -C /tmp/swoole --strip-components=1 \
            && cd /tmp/swoole \
            && phpize \
            && ./configure --with-php-config=/usr/bin/php-config --enable-openssl --enable-http2 --enable-sockets --enable-mysqlnd \
            && make -j$(nproc) && make install \
            && echo "extension=swoole.so" > /etc/php7/conf.d/swoole.ini \
        ) \
        && ( \
            mkdir -p /tmp/php-nsq \
            && tar -xf /tmp/php-nsq-${NSQ_VERSION}.tar.gz -C /tmp/php-nsq --strip-components=1 \
            && cd /tmp/php-nsq \
            && phpize \
            && ./configure && make -j$(nproc) && make install \
            && echo "extension=nsq.so" > /etc/php7/conf.d/nsq.ini \
        ) \
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
        && apk del .build-deps --purge *-dev \
        && apk add tzdata libevent libressl git \
        && rm /var/cache/apk/* -rf \
        && rm /usr/src/* -rf \
        && rm /tmp/* -rf \
        && chmod a+x /usr/local/bin/composer \
        && chmod a+x /usr/local/bin/swoftcli

WORKDIR /data

RUN chmod a+x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 18306 18307 18308

CMD ["/bin/sh"]