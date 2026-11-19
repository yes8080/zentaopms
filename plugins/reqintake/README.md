# 需求池插件开发验证包

适用基线为禅道开源版 22.7。当前验证页供管理员验证收件、负责人分派及状态变更。

在仓库根目录生成 ZIP：

```sh
python3 plugins/reqintake/build.py /tmp/reqintake.zip
unzip -t /tmp/reqintake.zip
```

在隔离的禅道测试实例中，从后台扩展管理本地安装 ZIP。管理员登录后访问 `index.php?m=reqintake&f=index`（使用 GET 路由模式）。

验证收件时，先使用未配置负责人的产品登记，确认列表显示实际负责人为提报人并标为待配置。再配置具有该产品访问权限的账号，确认新件分派给该账号。关闭及重开时须填写原因。分别用两个页面打开同一状态，在一个页面修改后，从另一个页面提交并检查是否提示记录已变化。

源码可用以下命令验证能否继承当前基线的框架类：

```sh
php -r 'require "framework/control.class.php"; require "framework/model.class.php"; require "plugins/reqintake/extension/custom/reqintake/control.php"; require "plugins/reqintake/extension/custom/reqintake/model.php";'
```
