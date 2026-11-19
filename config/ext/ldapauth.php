<?php
$filter->user->importldap = new stdclass();
$filter->user->importldap->cookie['pagerUserImportldap'] = 'int';

$config->logonMethods[] = 'ldap.index';
