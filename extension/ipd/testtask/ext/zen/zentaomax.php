<?php
public function assignForCases(object $product, object $testtask, array $runs, array $scenes, int $moduleID, string $browseType, int $param, string $orderBy, object $pager): void
{
    $this->loadExtension('zentaomax')->assignForCases($product, $testtask, $runs, $scenes, $moduleID, $browseType, $param, $orderBy, $pager);
}

public function setDropMenu(int $productID, object $task)
{
    $this->loadExtension('zentaomax')->setDropMenu($productID, $task);
}

public function setMenu(int $productID, int|string $branch, int $projectID, int $executionID,  ?object $testtask = null)
{
    $this->loadExtension('zentaomax')->setMenu($productID, $branch, $projectID, $executionID, $testtask);
}
