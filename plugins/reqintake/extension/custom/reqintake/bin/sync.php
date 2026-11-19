<?php
/* Reconcile linked native work from the operating system scheduler. */
if(PHP_SAPI !== 'cli') exit(1);

$root = dirname(__DIR__, 4);
chdir($root);
require 'framework/router.class.php';
require 'framework/control.class.php';
require 'framework/model.class.php';
require 'framework/helper.class.php';

$app = router::createApp('pms', $root, 'router');
if(empty($app->config->installed)) exit(1);

$prefix = $app->config->db->prefix;
$installed = $app->dbh->prepare("SELECT status FROM `{$prefix}extension` WHERE code = ?");
$installed->execute(array('reqintake'));
if($installed->fetchColumn() !== 'installed') exit(0);
$installed->closeCursor();

require_once dirname(__DIR__) . '/progress.php';
\ReqIntake\reconcileProgress($app->dbh, $prefix);
