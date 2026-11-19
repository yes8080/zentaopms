<?php
$config->admin->menuModuleGroup['feature']['custom|set'][]      = 'demand';
$config->admin->menuModuleGroup['feature']['custom|set'][]      = 'charter';
$config->admin->menuModuleGroup['feature']['custom|set'][]      = 'market';
$config->admin->menuModuleGroup['feature']['custom|required'][] = 'demand';

$config->admin->navsGroup['feature']['demand'] = ',demand,';
$config->admin->navsGroup['feature']['charter'] = ',charter,';

$config->admin->menuGroup['system'] = array_values(array_diff($config->admin->menuGroup['system'], array('custom|mode', 'cron', 'ldap', 'custom|libreoffice')));
