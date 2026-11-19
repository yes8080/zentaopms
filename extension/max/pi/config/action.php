<?php
global $lang, $app;
$config->pi->actionList = array();

$config->pi->actionList['edit']['icon'] = 'edit';
$config->pi->actionList['edit']['text'] = $lang->pi->edit;
$config->pi->actionList['edit']['hint'] = $lang->pi->edit;
$config->pi->actionList['edit']['url']  = array('module' => 'pi', 'method' => 'edit', 'params' => 'id={id}');

$config->pi->actionList['editCard']['icon']        = 'edit';
$config->pi->actionList['editCard']['text']        = $lang->pi->editCard;
$config->pi->actionList['editCard']['hint']        = $lang->pi->editCard;
$config->pi->actionList['editCard']['url']         = array('module' => 'pi', 'method' => 'editCard', 'params' => 'id={id}');
$config->pi->actionList['editCard']['data-toggle'] = 'modal';

$config->pi->actionList['close']['icon']        = 'off';
$config->pi->actionList['close']['text']        = $lang->pi->close;
$config->pi->actionList['close']['hint']        = $lang->pi->close;
$config->pi->actionList['close']['url']         = array('module' => 'pi', 'method' => 'close', 'params' => 'id={id}');
$config->pi->actionList['close']['data-toggle'] = 'modal';

$config->pi->actionList['activate']['icon']        = 'magic';
$config->pi->actionList['activate']['text']        = $lang->pi->activate;
$config->pi->actionList['activate']['hint']        = $lang->pi->activate;
$config->pi->actionList['activate']['url']         = array('module' => 'pi', 'method' => 'activate', 'params' => 'id={id}');
$config->pi->actionList['activate']['className']   = 'ajax-submit';
$config->pi->actionList['activate']['data-toggle'] = 'modal';

$config->pi->actionList['activateCard']['icon']        = 'magic';
$config->pi->actionList['activateCard']['text']        = $lang->pi->activateCard;
$config->pi->actionList['activateCard']['hint']        = $lang->pi->activateCard;
$config->pi->actionList['activateCard']['url']         = array('module' => 'pi', 'method' => 'activateCard', 'params' => 'id={id}');
$config->pi->actionList['activateCard']['data-toggle'] = 'modal';

$config->pi->actionList['finishCard']['icon']      = 'checked';
$config->pi->actionList['finishCard']['text']      = $lang->pi->finishCard;
$config->pi->actionList['finishCard']['hint']      = $lang->pi->finishCard;
$config->pi->actionList['finishCard']['url']       = array('module' => 'pi', 'method' => 'finishCard', 'params' => 'id={id}');
$config->pi->actionList['finishCard']['className'] = 'ajax-submit';

$config->pi->actionList['delete']['icon']      = 'trash';
$config->pi->actionList['delete']['text']      = $lang->pi->delete;
$config->pi->actionList['delete']['hint']      = $lang->pi->delete;
$config->pi->actionList['delete']['url']       = array('module' => 'pi', 'method' => 'delete', 'params' => 'id={id}');
$config->pi->actionList['delete']['className'] = 'ajax-submit';
