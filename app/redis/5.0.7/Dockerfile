FROM redis:5.0.7-alpine

MAINTAINER Longjianghu <215241062@qq.com>

# 更换源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && apk update

# 时区设置
RUN apk add --no-cache --virtual tzdata

ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

CMD ["redis-server","/etc/redis.conf"]

# 清除垃圾文件
RUN apk del --purge *-dev \
    && rm /var/cache/apk/* -rf \
    && rm /usr/src/* -rf