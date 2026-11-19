<?php
public function fetchTesttaskList(int $productID, string $branch = '', int $projectID = 0, string $unit = 'no', string $scope = '', string $status = '', string $begin = '', string $end = '', string $browseType = 'all', int $queryID = 0, string $orderBy = '', ?object $pager = null): array
{
    return $this->loadExtension('zentaomax')->fetchTesttaskList($productID, $branch, $projectID, $unit, $scope, $status, $begin, $end, $browseType, $queryID, $orderBy, $pager);
}
