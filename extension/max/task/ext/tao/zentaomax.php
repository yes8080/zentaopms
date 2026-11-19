<?php
public function autoUpdateTaskByStatus(object $task, object|null $childTask, string $status) :void
{
    $this->loadExtension('zentaomax')->autoUpdateTaskByStatus($task, $childTask, $status);
}
