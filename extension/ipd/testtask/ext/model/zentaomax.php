<?php
public function create(object $testtask): int|false
{
    return $this->loadExtension('zentaomax')->create($testtask);
}

public function update(object $task, object $oldTask): array|bool
{
    return $this->loadExtension('zentaomax')->update($task, $oldTask);
}

public function getProductTasks(int $productID, string $branch = 'all', string $type = '', string $begin = '', string $end = '', string $browseType = 'all', int $queryID = 0, string $orderBy = 'id_desc', ?object $pager = null): array
{
    return $this->loadExtension('zentaomax')->getProductTasks($productID, $branch, $type, $begin, $end, $browseType, $queryID, $orderBy, $pager);
}

public function getProjectTasks(int $projectID, int $productID = 0, string $type = 'all', int $param = 0, string $orderBy = 'id_desc', ?object $pager = null, string $status = ''): array
{
    return $this->loadExtension('zentaomax')->getProjectTasks($projectID, $productID, $type, $param, $orderBy, $pager, $status);
}

public function getExecutionTasks(int $executionID, int $productID = 0, string $objectType = 'execution', string $type = 'all', int $param = 0, string $orderBy = 'id_desc', ?object $pager = null): array
{
    return $this->loadExtension('zentaomax')->getExecutionTasks($executionID, $productID, $objectType, $type, $param, $orderBy, $pager);
}

public function getByUser(string $account, ?object $pager = null, string $orderBy = 'id_desc', string $type = '', int $queryID = 0): array
{
    return $this->loadExtension('zentaomax')->getByUser($account, $pager, $orderBy, $type, $queryID);
}

public function getLinkableCases(int $productID, object $task, string $type = 'all', int $param = 0, ?object $pager = null): array
{
    return $this->loadExtension('zentaomax')->getLinkableCases($productID, $task, $type, $param, $pager);
}

public function getTaskProducts(int $taskID): array
{
    return $this->loadExtension('zentaomax')->getTaskProducts($taskID);
}

public function appendProductGroup(array $tasks): array
{
    return $this->loadExtension('zentaomax')->appendProductGroup($tasks);
}

public static function createTestTaskLink($type, $module, $parent, $extra): object|false
{
    $taskID = $extra['taskID'];

    $data = new stdclass();
    $data->id     = $module->id;
    $data->parent = $module->parent ? $module->parent : $parent;
    $data->name   = $module->name;
    $data->url    = helper::createLink('testtask', 'cases', "taskID=$taskID&type=byModule&module={$module->id}");
    return $data;
}
