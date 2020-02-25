FROM longjianghu/swoft:1.2.2

MAINTAINER Longjianghu <215241062@qq.com>

ENV TIMEZONE=Asia/Shanghai \
    PHP_VERSION=73 \
    SWOOLE_TRACHER_INI=/etc/php7/conf.d/swoole_tracker.ini

COPY ./src/* /tmp/
COPY ./docker-entrypoint /usr/local/bin/docker-entrypoint.sh

RUN set -xe \
    && cd /tmp && chmod +x ./swoole-tracker-install.sh \
    && sh swoole-tracker-install.sh \
    && php_dir=$(php -r "echo @ini_get("extension_dir").PHP_EOL;") \
    && cp /tmp/swoole-tracker/swoole_tracker${PHP_VERSION}.so $php_dir/swoole_tracker.so \
    && echo "extension=swoole_tracker.so" > ${SWOOLE_TRACHER_INI} \
    && echo "apm.enable=1" >> ${SWOOLE_TRACHER_INI} \
    && echo "apm.sampling_rate=10" >> ${SWOOLE_TRACHER_INI} \
    && echo "apm.enable_memcheck=1" >> ${SWOOLE_TRACHER_INI} \
    && rm /tmp/* -rf

RUN chmod a+x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 18306 18307 18308

CMD ["/bin/sh"]