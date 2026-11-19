<?php
public function getBasicMetrics(array $cases, ?object $data = null, array $stories = array()): object
{
    return $this->loadExtension('report')->getBasicMetrics($cases, $data, $stories);
}
public function buildBasicConfig(array $cases, object $data): array
{
    return $this->loadExtension('report')->buildBasicConfig($cases, $data);
}

public function getMetricsCount(array $cases, ?object $data = null)
{
    return $this->loadExtension('report')->getMetricsCount($cases, $data);
}

public function getMetricsChart(array $cases, ?object $data = null, array $items = array())
{
    return $this->loadExtension('report')->getMetricsChart($cases, $data, $items);
}
