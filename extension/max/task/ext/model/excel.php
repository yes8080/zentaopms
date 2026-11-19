<?php
public function createFromImport($tasks)
{
    return $this->loadExtension('excel')->createFromImport($tasks);
}

public function processDatas4Task($taskData)
{
    return $this->loadExtension('excel')->processDatas4Task($taskData);
}

public function getKanbanLanePairs(int $executionID)
{
    return $this->loadExtension('excel')->getKanbanLanePairs($executionID);
}
