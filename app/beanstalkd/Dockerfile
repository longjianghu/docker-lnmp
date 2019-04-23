FROM alpine:3.9

MAINTAINER Longjianghu <215241062@qq.com>

RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories \
    && apk update \
    && apk add --no-cache beanstalkd

EXPOSE 11300

ENTRYPOINT ["/usr/bin/beanstalkd"]