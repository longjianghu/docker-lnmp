FROM nginx:1.15.5-alpine

MAINTAINER Longjianghu <215241062@qq.com>

# 更换源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/g' /etc/apk/repositories
RUN apk update

# 时区设置
RUN apk add --no-cache --virtual tzdata

ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone
