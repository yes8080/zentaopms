<?php
global $config;

if($config->vision == 'gitfox')
{
    $lang->group->organization = '組織';

    $lang->mainNav->organization = "{$lang->group->organization}|company|dynamic|";
}
