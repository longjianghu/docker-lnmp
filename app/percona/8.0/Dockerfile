FROM percona:8.0

LABEL maintainer="Longjianghu <215241062@qq.com>"

# 时区设置
ENV TIMEZONE=Asia/Shanghai
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone