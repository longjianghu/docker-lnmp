### Docker 简介
Docker 是基于GO语言实现的开源容器项目，现在主流的Linux系统都支持Docker,Docker 的构想是想要实现“Build,Ship and Run Any App, Anywhere”,即通过对应用的封装（Packaging）、分发（Distribution）、部署（Deployment）、运行（Runtime）生命周期进行管理，达到应用组件“一次封装，到处运行”的目的。
简单的来说，可以将Docker容器理解为一种轻量级的沙盒（sandbox）.每个容器运行着一个应用，不同的容器相互隔离，容器之间也可以通过网络互相通信。且容器的创建和停止都十分快速，几乎跟创建和终止原生应用一致。

### 为什么使用docker

1. 开发人员可以使用镜像来快速构建一套标准的开发环境

2. 一次创建与配置，之后可以在任意地方，任意时间让应用正常的运行

3. 高效的资源利用，docker 容器不需要额外的虚拟化管理程序（虚拟机）

4. 加速本地的开发和构建流程，容器可以在开发环境构建，然后轻松地提交到测试环境，并最终进入生产环境

### 安装 Docker-Compose

yum -y install epel-release python-pip

pip install docker-compose

### 更换 Composer 镜像

composer config -g repo.packagist composer https://packagist.phpcomposer.com

### 构建容器

docker build -t mysql:5.7 .

docker build -t php-fpm:7.2 .

docker build -t redis:4.0 .

### MySQL容器运行方法

MySQL:

docker run --name mysql -p 3306:3306 -v /data/var/etc/mysql:/etc/mysql/conf.d -v /data/var/lib/mysql:/var/lib/mysql -v /data/var/log/mysql:/var/log/mysql -e MYSQL_ROOT_PASSWORD=123456 -d mysql:5.7 --character-set-server=utf8mb4 --collation-server=utf8mb4_unicode_ci

Nginx:

docker run --name nginx -p 80:80 -p 443:443 -v /data/var/www:/usr/share/nginx/html -v /data/var/etc/nginx/conf.d/:/etc/nginx/conf.d/  -v /data/var/etc/nginx/nginx.conf:/etc/nginx/nginx.conf -v /data/var/log/nginx/:/var/log/nginx/ -d nginx:1.14-alpine

PHP:

docker run --name php-fpm -p 9000:9000 -v /data/var/etc/php:/usr/local/etc/php/conf.d -v /data/var/www:/usr/share/nginx/html -d php-fpm:7.2

Redis:

docker run --name redis -p 6379:6379 -v /data/var/etc/redis/redis.conf:/etc/redis.conf -d redis:4.0
