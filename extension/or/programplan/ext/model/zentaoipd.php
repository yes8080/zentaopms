<?php
public function create(array $plans, $projectID = 0, $productID = 0, $parentID = 0, $syncData = 0): bool
{
    return $this->loadExtension('zentaoipd')->create($plans, $projectID, $productID, $parentID, $syncData);
}
