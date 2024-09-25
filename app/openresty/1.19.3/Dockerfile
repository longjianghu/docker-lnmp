FROM openresty/openresty:1.19.3.1-0-alpine

LABEL maintainer="Longjianghu <215241062@qq.com>"

# 更换源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories && apk update

# 调整配置文件
COPY ./nginx.conf  /usr/local/openresty/nginx/conf/nginx.conf

# 时区设置
RUN apk add --no-cache tzdata

ENV TIMEZONE=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
	&& mkdir /var/log/nginx -p