# 禅道 22.7 Docker 部署

从仓库源码构建 PHP-FPM 和 Nginx，数据库使用 MySQL 8.4。镜像包含开源反馈模块。

## 首次运行

在仓库根目录创建仅本机可读的 `.env`，为两个数据库账号分别生成随机密码。建议使用 `openssl rand -hex 24`，方便直接填写安装向导。

```dotenv
MYSQL_DATABASE=zentao
MYSQL_USER=zentao
MYSQL_PASSWORD=填写应用数据库密码
MYSQL_ROOT_PASSWORD=填写另一个随机密码
ZENTAO_PORT=8080
```

```sh
docker compose up -d --build
```

打开 `http://127.0.0.1:8080/install.php`。数据库主机填 `mysql`，端口填 `3306`，数据库名、用户名和密码填写 `.env` 中对应的应用账号配置。表前缀使用默认值 `zt_`。完成安装并创建管理员后，从主导航进入 **反馈**。若没有可选产品，先创建产品。

默认只监听本机。需要局域网访问时可在 `.env` 设置 `ZENTAO_BIND=0.0.0.0`。

## 数据与重建

三个命名卷分别保存数据库、安装生成的 `config/my.php` 和上传文件。更新代码后再次执行 `docker compose up -d --build` 可以保留这些卷。备份时同时保存数据库和上传文件。原官方一体化镜像的 `/data` 目录结构不同，迁移现有站点时应导出数据库并迁移上传文件。

`.env` 中的 MySQL 初始化变量只在数据库卷为空时生效。已有数据库应按 MySQL 的账号管理流程修改密码，并同步禅道配置。
