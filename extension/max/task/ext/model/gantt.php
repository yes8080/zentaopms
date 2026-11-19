<?php
public function start(object $oldTask, object $task): false|array
{
    return $this->loadExtension('gantt')->start($oldTask, $task);
}

public function finish(object $oldTask, object $task): bool|array
{
    return $this->loadExtension('gantt')->finish($oldTask, $task);
}

public function checkDepend($taskID, $action = 'begin')
{
    return $this->loadExtension('gantt')->checkDepend($taskID, $action);
}

public function checkWorkhour(object $task, array $workhour): false|array
{
    return $this->loadExtension('gantt')->checkWorkhour($task, $workhour);
}

public function cancel(object $oldTask, object $task, array $output = array()): bool
{
    return $this->loadExtension('gantt')->cancel($oldTask, $task, $output);
}

public function afterBatchUpdate(array $tasks, array $oldTasks = array()): bool
{
    return $this->loadExtension('gantt')->afterBatchUpdate($tasks, $oldTasks);
}
