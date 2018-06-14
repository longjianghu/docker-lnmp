### 项目说明

当前项目仅用于学习目的，请勿用于生产环境。

### 安装 Docker

curl -fsSL https://get.docker.com | bash -s docker --mirror Aliyun

usermod -aG docker  root

systemctl start docker

### 配置加速器

curl -sSL https://get.daocloud.io/daotools/set_mirror.sh | sh -s http://8145ad9d.m.daocloud.io

### 安装 Docker-Compose

yum -y install epel-release python-pip

pip install docker-compose

### 更换 Composer 镜像

composer config -g repo.packagist composer https://packagist.phpcomposer.com

### 构建容器

docker build -t mysql:5.7 ./app/mysql/

docker build -t php-fpm:7.2 ./app/php/

docker build -t redis:3.2 ./app/redis/

docker build -t nginx:1.14 ./app/nginx/

### MySQL容器运行方法

MySQL:

docker run --name mysql -p 3306:3306 -v /data/var/etc/mysql/mysqld.cnf:/etc/mysql/mysql.conf.d/mysqld.cnf -v /data/var/lib/mysql:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=123456 -d mysql:5.7 --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci

Nginx:

docker run --name nginx -p 80:80 -p 443:443 -v /data/var/www:/usr/share/nginx/html -v /data/var/etc/nginx/conf.d/:/etc/nginx/conf.d/  -v /data/var/etc/nginx/nginx.conf:/etc/nginx/nginx.conf -v /data/var/log/nginx/:/var/log/nginx/ --link php-fpm:php-fpm -d nginx:1.14

PHP:

docker run --name php-fpm -p 9000:9000 -v /data/var/etc/php/php.ini:/usr/local/etc/php/php.ini -v /data/var/etc/php/conf.d:/usr/local/etc/php/conf.d -v /data/var/www:/usr/share/nginx/html --link redis:redis -d php-fpm:7.2

Redis:

docker run --name redis -p 6379:6379 -v /data/var/etc/redis/redis.conf:/etc/redis.conf -d redis:4.0 redis-server /etc/redis.conf