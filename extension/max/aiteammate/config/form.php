<?php
global $app;

$config->aiteammate->form = new stdclass();

$config->aiteammate->form->create = array();
$config->aiteammate->form->create['name']        = array('required' => true, 'type' => 'string');
$config->aiteammate->form->create['role']        = array('required' => true, 'type' => 'string');
$config->aiteammate->form->create['agents']      = array('required' => true, 'type' => 'array', 'filter' => 'join');
$config->aiteammate->form->create['llm']         = array('required' => false, 'type' => 'string');
$config->aiteammate->form->create['desc']        = array('required' => false, 'type' => 'string', 'default' => '');
$config->aiteammate->form->create['klibs']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->aiteammate->form->create['avatar']      = array('required' => false, 'type' => 'string');
$config->aiteammate->form->create['createdBy']   = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->aiteammate->form->create['createdDate'] = array('required' => false, 'type' => 'datetime',   'default' => helper::now());

$config->aiteammate->form->edit = array();
$config->aiteammate->form->edit['name']       = array('required' => true, 'type' => 'string');
$config->aiteammate->form->edit['role']       = array('required' => true, 'type' => 'string');
$config->aiteammate->form->edit['agents']     = array('required' => true, 'type' => 'array', 'filter' => 'join');
$config->aiteammate->form->edit['llm']        = array('required' => false, 'type' => 'string');
$config->aiteammate->form->edit['desc']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->aiteammate->form->edit['klibs']      = array('required' => false, 'type' => 'string', 'default' => '');
$config->aiteammate->form->edit['avatar']     = array('required' => false, 'type' => 'string');
$config->aiteammate->form->edit['editedBy']   = array('required' => false, 'type' => 'string', 'default' => isset($app->user->account) ? $app->user->account : '');
$config->aiteammate->form->edit['editedDate'] = array('required' => false, 'type' => 'datetime', 'default' => helper::now());

$config->aiteammate->form->cropAvatar = array();
$config->aiteammate->form->cropAvatar['originWidth']  = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['originHeight'] = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['scaleWidth']   = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['scaleHeight']  = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['width']        = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['height']       = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['left']         = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['top']          = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['right']        = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['bottom']       = array('required' => false, 'type' => 'int',  'default' => 0);
$config->aiteammate->form->cropAvatar['scaled']       = array('required' => false, 'type' => 'bool', 'default' => false);

$config->aiteammate->form->assign = array();
$config->aiteammate->form->assign['noticeTime']  = array('required' => true, 'type' => 'string', 'filter' => 'trim');
$config->aiteammate->form->assign['afterSaving'] = array('type' => 'string', 'filter' => 'trim');
