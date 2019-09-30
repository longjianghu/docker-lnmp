FROM swoft:1.0

MAINTAINER Longjianghu <215241062@qq.com>

ENV TIMEZONE=Asia/Shanghai \
    PHP_VERSION=72 \
    SWOOLE_TRACHER_INI=/etc/php7/conf.d/swoole_tracker.ini

COPY ./src/* /tmp/
COPY ./docker-entrypoint /usr/local/bin/docker-entrypoint.sh

RUN set -xe \
    && ( \
        mkdir -p /tmp/swoole-tracker \
        && tar -xf /tmp/swoole-tracker.tar.gz -C /tmp/swoole-tracker --strip-components=1 \
        && cd /tmp/swoole-tracker && ./deploy_env.sh www.swoole-cloud.com \
        && php_dir=$(php -r "echo @ini_get("extension_dir").PHP_EOL;") \
        && cp ./swoole_tracker${PHP_VERSION}.so $php_dir/swoole_tracker.so \
        && echo "extension=swoole_tracker.so" > ${SWOOLE_TRACHER_INI} \
        && echo "apm.enable=1" >> ${SWOOLE_TRACHER_INI} \
        && echo "apm.sampling_rate=10" >> ${SWOOLE_TRACHER_INI} \
        && echo "apm.enable_memcheck=1" >> ${SWOOLE_TRACHER_INI} \
    ) \
    && rm /tmp/* -rf

WORKDIR /data

RUN chmod 755 /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 80 9501 18306 18307 18308

CMD ["/bin/sh"]