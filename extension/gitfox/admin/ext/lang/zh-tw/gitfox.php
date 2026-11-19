<?php
global $config;

if($config->vision == 'gitfox')
{
    unset($lang->admin->menuList->switch);
    unset($lang->admin->menuList->workflow);
    unset($lang->admin->menuList->approvalFlow);
    unset($lang->admin->menuList->feature);
    unset($lang->admin->menuList->message);
    unset($lang->admin->menuList->extension);
    unset($lang->admin->menuList->dev);
    unset($lang->admin->menuList->convert);
    unset($lang->admin->menuList->adminregister);

    /* GitFox獨立版不展示重建索引菜單。*/
    unset($lang->admin->menuList->system['subMenu']['buildindex']);
    unset($lang->admin->menuList->system['subMenu']['mode']);
    unset($lang->admin->menuList->system['subMenu']['xuanxuan']);
    unset($lang->admin->menuList->system['menuOrder']['5']);
    unset($lang->admin->menuList->system['menuOrder']['20']);
    unset($lang->admin->menuList->system['menuOrder']['50']);

    $lang->admin->menuList->branchType['name']  = $lang->devops->branchType;
    $lang->admin->menuList->branchType['desc']  = '維護代碼庫分支類型及命名規則。';
    $lang->admin->menuList->branchType['link']  = 'repobranchtype|browse|';
    $lang->admin->menuList->branchType['icon']  = 'code-fork';
    $lang->admin->menuList->branchType['bg']    = 'primary';
    $lang->admin->menuList->branchType['order'] = 75;

    $lang->admin->menuList->service['name']  = $lang->provider->common;
    $lang->admin->menuList->service['desc']  = '配置代碼庫關聯的服務。';
    $lang->admin->menuList->service['link']  = 'provider|browse|';
    $lang->admin->menuList->service['icon']  = 'cog';
    $lang->admin->menuList->service['bg']    = 'primary';
    $lang->admin->menuList->service['order'] = 80;

    $lang->admin->menuList->runner['name']  = $lang->runner->common;
    $lang->admin->menuList->runner['desc']  = '管理流水綫執行節點。';
    $lang->admin->menuList->runner['link']  = 'runner|browse|';
    $lang->admin->menuList->runner['icon']  = 'run-alt';
    $lang->admin->menuList->runner['bg']    = 'primary';
    $lang->admin->menuList->runner['order'] = 85;

    $lang->admin->zentaoUsed = '您已使用gitfox';
    $lang->admin->zentaoInfo = 'gitfox信息';

    $lang->admin->officialAccount = '官方服務號';
    $lang->admin->followUs        = '掃碼關注服務號';
    $lang->admin->followUsContent = '隨時查看gitfox動態，也可獲取幫助支持';
}
