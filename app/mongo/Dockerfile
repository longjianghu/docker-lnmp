FROM mongo:3.4

MAINTAINER Longjianghu <215241062@qq.com>

# 时区设置
ENV TIMEZONE Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone

COPY mongod.cnf /etc/mongod.conf

CMD ["mongod","--config /etc/mongod.conf"]