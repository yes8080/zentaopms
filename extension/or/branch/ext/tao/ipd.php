<?php
protected function afterMerge(int $productID, int $targetBranch, string $mergedBranches, object $data): bool
{
    return $this->loadExtension('ipd')->afterMerge($productID, $targetBranch, $mergedBranches, $data);
}
