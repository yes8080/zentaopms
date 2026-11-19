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

已安装插件后，可在使用简体中文和 GET 路由的隔离实例中运行 HTTP 回归。先建立名为 `Smoke Product` 的测试产品，并保持未配置负责人；测试会产生一条反馈并执行状态流转。

```sh
python3 plugins/reqintake/tests/smoke.py http://127.0.0.1:8097 /path/to/test-admin-password
```

管理员可在禅道权限组中为普通账号授予需求池的列表和详情权限。列表权限包括登记反馈，用户只能查看有权访问的产品。实际负责人可办理已分派的反馈，临时跟进人和其他用户无权变更状态。负责人配置仍由管理员管理。

从开发版 0.1.0 升到 0.2.0 前，请在维护窗口用数据库管理工具执行 `db/install.sql`。如果实例使用其他表前缀，先把脚本中的 `zt_reqintake` 改为实际前缀加 `reqintake`。该脚本只创建缺失的表；确认关联表存在后再上传 ZIP 并升级。首次安装由禅道执行建表脚本。

可重复传入 `--target TYPE ID` 来检查已存在的同产品原生单据是否能从反馈详情关联，以及原生详情能否返回反馈。类型支持 `story`、`requirement`、`epic`、`bug` 和 `task`。执行任务的执行必须关联该测试产品。

0.3.0 增加了后台进度核对表。升级前仍需执行当前版本的 `db/install.sql`。在禅道应用根目录手动运行一次核对命令，成功后可由部署环境的调度服务定时调用。Compose 中可用：

```sh
docker compose exec -T -u www-data php php extension/custom/reqintake/bin/sync.php
```

命令只在插件处于已安装状态时更新快照。详情仍读取单据当前状态，并显示最近后台核对时间。单据的进度不会改变反馈的办理状态。

0.4.0 增加反馈修订记录。升级前执行本版 `db/install.sql` 创建修订表。负责人或管理员可在未关闭反馈的详情中修改标题、描述、客户和渠道；详情保留初次提交和历次修订。
