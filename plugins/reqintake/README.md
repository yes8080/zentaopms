# 需求池插件开发验证包

适用基线为禅道开源版 22.7。当前验证页供管理员验证收件、负责人分派及状态变更。

在仓库根目录生成 ZIP：

```sh
python3 plugins/reqintake/build.py /tmp/reqintake.zip
unzip -t /tmp/reqintake.zip
```

在隔离的禅道测试实例中，从后台扩展管理本地安装 ZIP。管理员登录后，默认 Compose 的 PATH_INFO 模式使用 `/reqintake-index.html`，GET 路由模式使用 `/index.php?m=reqintake&f=index`。

基线镜像中的扩展目录由 root 拥有。只在一次性测试容器中，可在本地安装前给 PHP 进程开放安装器需要的目录：

```sh
docker compose exec -u root php sh -c 'mkdir -p /var/www/zentao/extension/pkg && chown www-data:www-data /var/www/zentao/extension /var/www/zentao/extension/pkg /var/www/zentao/extension/custom'
```

这些权限和解包后的插件文件位于当前 PHP 容器内，重建后需重新准备。数据库中的安装记录会随数据库卷保留。

验证收件时，先使用未配置负责人的产品登记，确认列表显示实际负责人为提报人并标为待配置。再配置具有该产品访问权限的账号，确认新件分派给该账号。关闭及重开时须填写原因。分别用两个页面打开同一状态，在一个页面修改后，从另一个页面提交并检查是否提示记录已变化。

源码可用以下命令验证能否继承当前基线的框架类：

```sh
php -r 'require "framework/control.class.php"; require "framework/model.class.php"; require "plugins/reqintake/extension/custom/reqintake/control.php"; require "plugins/reqintake/extension/custom/reqintake/model.php";'
```
