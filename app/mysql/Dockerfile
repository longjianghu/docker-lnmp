FROM mysql:8.0

MAINTAINER Longjianghu <215241062@qq.com>

# 时区设置
ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

COPY mysqld.cnf /etc/mysql/mysql.conf.d/mysqld.cnf
