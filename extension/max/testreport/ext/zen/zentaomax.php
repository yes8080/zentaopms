<?php
public function assignTesttaskReportData(int $objectID, string $begin = '', string $end = '', int $productID = 0, ?object $task = null, string $method = 'create'): array
{
    return $this->loadExtension('zentaomax')->assignTesttaskReportData($objectID, $begin, $end, $productID, $task, $method);
}

public function assignProjectReportDataForCreate(int $objectID, string $objectType, string $extra, string $begin = '', string $end = '', int $executionID = 0): array
{
    return $this->loadExtension('zentaomax')->assignProjectReportDataForCreate($objectID, $objectType, $extra, $begin, $end, $executionID);
}

public function buildReportDataForView(object $report): array
{
    return $this->loadExtension('zentaomax')->buildReportDataForView($report);
}
