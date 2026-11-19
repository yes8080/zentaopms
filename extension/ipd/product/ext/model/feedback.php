<?php
public function getStories(int|array $productID, string $branch, string $browseType, int $queryID, int $moduleID, string $type = 'story', string $sort = 'id_desc', object|null $pager = null): array
{
    return $this->loadExtension('feedback')->getStories($productID, $branch, $browseType, $queryID, $moduleID, $type, $sort, $pager);
}
