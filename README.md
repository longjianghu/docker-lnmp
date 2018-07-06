### 项目说明

LNMP代表的是Linux下Nginx、MySQL、PHP这种网站服务器架构。

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

进入PHP容器内执行

su www-data -c "composer config -g repo.packagist composer https://packagist.phpcomposer.com"

### 构建容器

docker build -t mysql80 ./app/mysql/

docker build -t mongo40 ./app/mongo/

docker build -t php72 ./app/php/

docker build -t redis40 ./app/redis/

docker build -t nginx114 ./app/nginx/

### 容器运行方法

MySQL:

docker run --name mysql80 -p 3306:3306 -v /data/var/etc/mysql/mysqld.cnf:/etc/mysql/mysql.conf.d/mysqld.cnf -v /data/var/lib/mysql:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=123456 -d mysql80

Mongo:

docker run --name mongo40 -p 27017:27017 -v /data/var/lib/mongo:/data/db -e MONGO_INITDB_ROOT_USERNAME=root -e MONGO_INITDB_ROOT_PASSWORD=123456 -d mongo40

Redis:

docker run --name redis40 -p 6379:6379 -v /data/var/etc/redis/redis.conf:/etc/redis.conf -d redis40

PHP:

docker run --name php72 -p 9000:9000 -v /data/var/etc/php/php.ini:/usr/local/etc/php/php.ini -v /data/var/www:/var/www/html -d php72

Nginx:

docker run --name nginx114 -p 80:80 -p 443:443 -v /data/var/www:/var/www/html -v /data/var/etc/nginx/conf.d/:/etc/nginx/conf.d/ -v /data/var/etc/nginx/nginx.conf:/etc/nginx/nginx.conf -v /data/var/log/nginx/:/var/log/nginx/ -d nginx114
