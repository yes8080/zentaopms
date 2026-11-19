<?php
public function getBuildPairs(array|int $productIdList, string|int $branch = 'all', string $params = 'noterminate, nodone', int $objectID = 0, string $objectType = 'execution', string|int $buildIdList = '', bool $replace = true, int $system = 0): array
{
    return $this->loadExtension('zentaomax')->getBuildPairs($productIdList, $branch, $params, $objectID, $objectType, $buildIdList, $replace, $system);
}
