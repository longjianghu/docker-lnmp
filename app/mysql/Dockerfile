FROM mysql:5.7

MAINTAINER Longjianghu <215241062@qq.com>

# 更换源
COPY ./source.list /etc/apk/repositories
RUN apk update

# 时区设置
RUN apk add --no-cache --virtual tzdata

ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

COPY mysqld.cnf /etc/mysql/mysql.conf.d/mysqld.cnf