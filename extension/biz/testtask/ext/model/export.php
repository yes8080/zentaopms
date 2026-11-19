<?php
public function getBugInfo(int $taskID, int $productID)
{
    return $this->loadExtension('export')->getBugInfo($taskID, $productID);
}
