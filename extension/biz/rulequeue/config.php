<?php
$config->rulequeue = new stdClass();
$config->rulequeue->dtable = new stdClass();

global $lang;
$config->rulequeue->dtable->fieldList['id']['title']    = $lang->idAB;
$config->rulequeue->dtable->fieldList['id']['name']     = 'id';
$config->rulequeue->dtable->fieldList['id']['type']     = 'checkID';
$config->rulequeue->dtable->fieldList['id']['sortType'] = true;
$config->rulequeue->dtable->fieldList['id']['checkbox'] = false;
$config->rulequeue->dtable->fieldList['id']['width']    = '80';
$config->rulequeue->dtable->fieldList['id']['required'] = true;

$config->rulequeue->dtable->fieldList['log']['title']    = $lang->rulequeue->log;
$config->rulequeue->dtable->fieldList['log']['name']     = 'log';
$config->rulequeue->dtable->fieldList['log']['type']     = 'text';
$config->rulequeue->dtable->fieldList['log']['sortType'] = true;

$config->rulequeue->dtable->fieldList['status']['title']    = $lang->rulequeue->status;
$config->rulequeue->dtable->fieldList['status']['name']     = 'status';
$config->rulequeue->dtable->fieldList['status']['type']     = 'status';
$config->rulequeue->dtable->fieldList['status']['sortType'] = true;
$config->rulequeue->dtable->fieldList['status']['width']    = '80';
$config->rulequeue->dtable->fieldList['status']['map']      = $lang->rulequeue->statusList;

$config->rulequeue->dtable->fieldList['triggeredBy']['title']    = $lang->rulequeue->triggeredBy;
$config->rulequeue->dtable->fieldList['triggeredBy']['name']     = 'triggeredBy';
$config->rulequeue->dtable->fieldList['triggeredBy']['type']     = 'user';
$config->rulequeue->dtable->fieldList['triggeredBy']['sortType'] = true;

$config->rulequeue->dtable->fieldList['triggeredDate']['title']    = $lang->rulequeue->triggeredDate;
$config->rulequeue->dtable->fieldList['triggeredDate']['name']     = 'triggeredDate';
$config->rulequeue->dtable->fieldList['triggeredDate']['type']     = 'date';
$config->rulequeue->dtable->fieldList['triggeredDate']['sortType'] = true;

$config->rulequeue->dtable->fieldList['executedTime']['title']    = $lang->rulequeue->executedTime;
$config->rulequeue->dtable->fieldList['executedTime']['name']     = 'executedTime';
$config->rulequeue->dtable->fieldList['executedTime']['type']     = 'datetime';
$config->rulequeue->dtable->fieldList['executedTime']['sortType'] = true;

$config->rulequeue->defaultStatusList = array('product' => 'normal', 'project' => 'wait', 'execution' => 'wait', 'story' => 'active', 'epic' => 'active', 'requirement' => 'active', 'task' => 'wait', 'bug' => 'active', 'testcase' => 'normal');
$config->rulequeue->editorFields      = array('desc', 'spec', 'steps');
