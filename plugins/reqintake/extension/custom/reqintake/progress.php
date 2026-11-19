<?php
namespace ReqIntake;

function reconcileProgress(\dbh $database, string $prefix, array $types = [], int $target = 0): void
{
    $filter = '';
    $parameters = [];
    if($types && $target > 0)
    {
        $placeholders = implode(',', array_fill(0, count($types), '?'));
        $filter = "WHERE l.targetType IN ($placeholders) AND l.target = ?";
        $parameters = [...$types, $target];
    }

    $statement = $database->prepare("
    INSERT INTO `{$prefix}reqintakeProgress` (feedback,targetType,target,available,status,stage,reason,checkedDate)
    SELECT l.feedback,l.targetType,l.target,
           COALESCE(s.id,b.id,t.id) IS NOT NULL,
           COALESCE(s.status,b.status,t.status,''),
           COALESCE(s.stage,''),
           COALESCE(s.closedReason,b.resolution,t.closedReason,''),
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
    $filter
    ON DUPLICATE KEY UPDATE
      available = VALUES(available), status = VALUES(status), stage = VALUES(stage),
      reason = VALUES(reason), checkedDate = VALUES(checkedDate)
");
    $statement->execute($parameters);
}
