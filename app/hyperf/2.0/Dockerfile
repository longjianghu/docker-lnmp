FROM hyperf/hyperf:7.4-alpine-v3.11-swoole

LABEL maintainer="Longjianghu <215241062@qq.com>"

COPY ./docker-entrypoint /usr/local/bin/docker-entrypoint.sh

WORKDIR /data

RUN chmod a+x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]

EXPOSE 9501 9502

CMD ["php", "/data/bin/hyperf.php", "start"]