<?php
public function getMetricsCount(array $executionList, array $items = array()): object
{
    return $this->loadExtension('report')->getMetricsCount($executionList, $items);
}

public function getMetricsChart(array $executionList, array $items = array()): object
{
    return $this->loadExtension('report')->getMetricsChart($executionList, $items);
}

public function getMetricsTable(array $executionList, object $project, array $items = array()): object
{
    return $this->loadExtension('report')->getMetricsTable($executionList, $project, $items);
}