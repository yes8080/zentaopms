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

$app->dbh->exec("
    INSERT INTO `{$prefix}reqintakeProgress` (feedback,targetType,target,available,status,stage,reason,checkedDate)
    SELECT l.feedback,l.targetType,l.target,
           COALESCE(s.id,b.id,t.id) IS NOT NULL,
           COALESCE(s.status,b.status,t.status,''),
           COALESCE(s.stage,''),
           COALESCE(s.closedReason,b.resolution,''),
           CURRENT_TIMESTAMP
      FROM `{$prefix}reqintakeLink` l
      JOIN `{$prefix}reqintakeFeedback` f ON f.id = l.feedback
      LEFT JOIN `{$prefix}story` s ON s.id = l.target AND s.type = l.targetType AND s.product = f.product AND s.deleted = '0'
      LEFT JOIN `{$prefix}bug` b ON l.targetType = 'bug' AND b.id = l.target AND b.product = f.product AND b.deleted = '0'
      LEFT JOIN `{$prefix}task` t ON l.targetType = 'task' AND t.id = l.target AND t.deleted = '0'
       AND EXISTS (
            SELECT 1 FROM `{$prefix}projectproduct` pp
            JOIN `{$prefix}project` e ON e.id = pp.project AND e.deleted = '0'
            WHERE pp.project = t.execution AND pp.product = f.product
       )
    ON DUPLICATE KEY UPDATE
      available = VALUES(available), status = VALUES(status), stage = VALUES(stage),
      reason = VALUES(reason), checkedDate = VALUES(checkedDate)
");
