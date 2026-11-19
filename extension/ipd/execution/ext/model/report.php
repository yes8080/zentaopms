<?php
public function getBugBasicMetrics(array $bugs, ?object $data, string $type = 'execution'): object
{
    return $this->loadExtension('report')->getBugBasicMetrics($bugs, $data, $type);
}
public function buildBasicBugConfig(array $bugs, object $data, string $type = 'execution'): array
{
    return $this->loadExtension('report')->buildBasicBugConfig($bugs, $data, $type);
}
public function getBugProgressMetrics(array $bugs, object $data, string $type = 'execution'): object
{
    return $this->loadExtension('report')->getBugProgressMetrics($bugs, $data, $type);
}
public function buildProgressBugConfig(array $bugs, object $data, string $type = 'execution'): array
{
    return $this->loadExtension('report')->buildProgressBugConfig($bugs, $data, $type);
}
public function processUserStats(array $userPairs, array $userData): array
{
    return $this->loadExtension('report')->processUserStats($userPairs, $userData);
}

public function getBugMetricsCount(array $bugs, ?object $data = null, array $items = array())
{
    return $this->loadExtension('report')->getBugMetricsCount($bugs, $data, $items);
}

public function getBugMetricsChart(array $bugs, array $items = array(), ?object $data = null, string $objectType = 'execution')
{
    return $this->loadExtension('report')->getBugMetricsChart($bugs, $items, $data, $objectType);
}
