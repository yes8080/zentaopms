<?php
public function afterCreate(object $task, array $taskIdList, int $bugID, int $todoID): bool
{
    return $this->loadExtension('feedback')->afterCreate($task, $taskIdList, $bugID, $todoID);
}

public function afterUpdate(object $oldTask, object $task): void
{
    $this->loadExtension('feedback')->afterUpdate($oldTask, $task);
}

public static function isClickable(object $task, string $action): bool
{
    $action = strtolower($action);
    if($action == 'batchcreate' && empty($task->team) && empty($task->mode) && !in_array($task->status, array('closed', 'cancel'))) return true;

    return parent::isClickable($task, $action);
}

public function getParentTaskPairs(int $executionID, string $appendIdList = '', int $taskID = 0): array
{
    return $this->loadExtension('feedback')->getParentTaskPairs($executionID, $appendIdList, $taskID);
}
