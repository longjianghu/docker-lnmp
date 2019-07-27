FROM mysql:8.0.17

MAINTAINER Longjianghu <215241062@qq.com>

# 更换国内源
RUN sed -i 's/deb.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list \
    && sed -i 's/security.debian.org/mirrors.aliyun.com/g' /etc/apt/sources.list

# 时区设置
ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

COPY master.cnf /etc/mysql/conf.d/master.cnf
RUN mkdir /var/log/mysql && chown mysql.mysql -R /var/log/mysql && touch /var/log/mysql/log-slow-queries.log
