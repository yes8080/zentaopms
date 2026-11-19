<?php
public function getBasicMetrics(array $taskList): object
{
    return $this->loadExtension('report')->getBasicMetrics($taskList);
}

public function buildBasicChartConfig(array $taskList): array
{
    return $this->loadExtension('report')->buildBasicChartConfig($taskList);
}

public function getProgressMetrics(array $taskList, object $data, string $type = 'execution'): object
{
    return $this->loadExtension('report')->getProgressMetrics($taskList, $data, $type);
}

public function buildProgressChartConfig(array $taskList, object $data, string $type = 'execution'): array
{
    return $this->loadExtension('report')->buildProgressChartConfig($taskList, $data, $type);
}

public function getResourceMetrics(array $taskList, object $data, $type = 'execution'): object
{
    return $this->loadExtension('report')->getResourceMetrics($taskList, $data, $type);
}

public function buildResourceChartConfig(array $taskList, object $data, $type = 'execution'): array
{
    return $this->loadExtension('report')->buildResourceChartConfig($taskList, $data, $type);
}

public function getMetricsCount(array $taskList, array $items): object
{
    return $this->loadExtension('report')->getMetricsCount($taskList, $items);
}

public function getMetricsChart(array $taskList, array $items, int $objectID = 0, string $type = 'execution'): object
{
    return $this->loadExtension('report')->getMetricsChart($taskList, $items, $objectID, $type);
}

public function getMetricsTable(array $taskList, array $items, ?object $data = null, string $type = 'execution'): object
{
    return $this->loadExtension('report')->getMetricsTable($taskList, $items, $data, $type);
}

public function processDateLimitForTasks(array $taskList, object $data, string $type): array
{
    return $this->loadExtension('report')->processDateLimitForTasks($taskList, $data, $type);
}

public function getEffortMetrics(array $taskList, array $items, int $objectID = 0, string $type = 'execution'): object
{
    return $this->loadExtension('report')->getEffortMetrics($taskList, $items, $objectID, $type);
}
