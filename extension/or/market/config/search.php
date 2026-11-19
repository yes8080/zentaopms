<?php
global $lang;

$config->market->search['module'] = 'market';
$config->market->search['fields']['id']          = $lang->idAB;
$config->market->search['fields']['name']        = $lang->market->name;
$config->market->search['fields']['industry']    = $lang->market->industry;
$config->market->search['fields']['scale']       = $lang->market->scale;
$config->market->search['fields']['maturity']    = $lang->market->maturity;
$config->market->search['fields']['speed']       = $lang->market->speed;
$config->market->search['fields']['competition'] = $lang->market->competition;
$config->market->search['fields']['ppm']         = $lang->market->ppm;
$config->market->search['fields']['strategy']    = $lang->market->strategy;
$config->market->search['fields']['openedDate']  = $lang->market->openedDate;
$config->market->search['fields']['desc']        = $lang->market->desc;

$config->market->search['params']['id']          = array('operator' => '=',       'control' => 'input',  'values' => '');
$config->market->search['params']['name']        = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->market->search['params']['industry']    = array('operator' => 'include', 'control' => 'input',  'values' => '');
$config->market->search['params']['scale']       = array('operator' => '=',       'control' => 'input',  'values' => '');
$config->market->search['params']['maturity']    = array('operator' => '=',       'control' => 'select', 'values' => $lang->market->maturityList);
$config->market->search['params']['speed']       = array('operator' => '=',       'control' => 'select', 'values' => $lang->market->speedList);
$config->market->search['params']['competition'] = array('operator' => '=',       'control' => 'select', 'values' => $lang->market->competitionList);
$config->market->search['params']['ppm']         = array('operator' => '=',       'control' => 'select', 'values' => $lang->market->ppmList);
$config->market->search['params']['strategy']    = array('operator' => '=',       'control' => 'select', 'values' => $lang->market->strategyList);
$config->market->search['params']['openedDate']  = array('operator' => '=',       'control' => 'date',   'values' => '');
$config->market->search['params']['desc']        = array('operator' => 'include', 'control' => 'input',  'values' => '');
