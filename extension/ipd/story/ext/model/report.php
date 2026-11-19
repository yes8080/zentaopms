<?php
public function getBasicMetrics(array $storyList, object $data, string $type = 'execution'): object
{
    return $this->loadExtension('report')->getBasicMetrics($storyList, $data, $type);
}
public function buildBasicChartConfig(array $storyList, object $data, string $type = 'execution'): array
{
    return $this->loadExtension('report')->buildBasicChartConfig($storyList, $data, $type);
}
public function getProgressMetrics(array $storyList): object
{
    return $this->loadExtension('report')->getProgressMetrics($storyList);
}
public function buildProgressChartConfig(array $storyList): array
{
    return $this->loadExtension('report')->buildProgressChartConfig($storyList);
}
public function getChangedStory(int $storyID, string $begin, string $end): int
{
    return $this->loadExtension('report')->getChangedStory($storyID, $begin, $end);
}

public function getMetricsCount(array $storyList, ?object $data = null, array $items = array()): object
{
    return $this->loadExtension('report')->getMetricsCount($storyList, $data, $items);
}

public function getMetricsChart(array $storyList, array $items = array()): object
{
    return $this->loadExtension('report')->getMetricsChart($storyList, $items);
}