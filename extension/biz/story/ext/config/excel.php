<?php
$config->story->listFields     = "module,branch,plan,source,pri,reviewedBy,needReview,reviewer,category";
$config->story->sysListFields  = "module,plan";
$config->story->templateFields = "product,branch,module,plan,source,sourceNote,level,title,spec,verify,keywords,pri,estimate,category,reviewer";

$config->story->form->showimport = array();
$config->story->form->showimport['id']         = array('required' => false, 'type' => 'int',    'base' => true);
$config->story->form->showimport['branch']     = array('required' => false, 'type' => 'int',    'default' => 0);
$config->story->form->showimport['module']     = array('required' => false, 'type' => 'int',    'default' => 0);
$config->story->form->showimport['plan']       = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
$config->story->form->showimport['source']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->story->form->showimport['sourceNote'] = array('required' => false, 'type' => 'string', 'default' => '');
$config->story->form->showimport['level']      = array('required' => false, 'type' => 'int',    'default' => 0);
$config->story->form->showimport['title']      = array('required' => true,  'type' => 'string', 'filter'  => 'trim');
$config->story->form->showimport['spec']       = array('required' => false, 'type' => 'string', 'default' => '');
$config->story->form->showimport['verify']     = array('required' => false, 'type' => 'string', 'default' => '');
$config->story->form->showimport['keywords']   = array('required' => false, 'type' => 'string', 'default' => '');
$config->story->form->showimport['pri']        = array('required' => false, 'type' => 'int',    'default' => 3);
$config->story->form->showimport['estimate']   = array('required' => false, 'type' => 'float',  'default' => 0);
$config->story->form->showimport['category']   = array('required' => false, 'type' => 'string', 'default' => '');
$config->story->form->showimport['reviewer']   = array('required' => false, 'type' => 'array',  'default' => array(''), 'filter' => 'join');
