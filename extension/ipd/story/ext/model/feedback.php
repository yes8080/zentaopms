<?php
public function create(object $story, int $executionID = 0, int $bugID = 0, string $extra = '', int $todoID = 0): int|false
{
    return $this->loadExtension('feedback')->create($story, $executionID, $bugID, $extra, $todoID);
}

public function update(int $storyID, object $story, string|bool $comment = ''): bool|int
{
    return $this->loadExtension('feedback')->update($storyID, $story, $comment);
}

public function change(int $storyID, object $story): array|false
{
    return $this->loadExtension('feedback')->change($storyID, $story);
}

public function recallChange(int $storyID): void
{
    $this->loadExtension('feedback')->recallChange($storyID);
}

public function getByID(int $storyID, int $version = 0, bool $setImgSize = false): object|false
{
    return $this->loadExtension('feedback')->getById($storyID, $version, $setImgSize);
}

public function relieveTwins(int $productID, int $storyID): bool
{
    return $this->loadExtension('feedback')->relieveTwins($productID, $storyID);
}

public function getExecutionStories(int|array $executionID = 0, int $productID = 0, string $orderBy = 't1.`order`_desc', string $browseType = 'byModule', string $param = '0', string $storyType = 'story', array|string $excludeStories = '', object|null $pager = null): array
{
    return $this->loadExtension('feedback')->getExecutionStories($executionID, $productID, $orderBy, $browseType, $param, $storyType, $excludeStories, $pager);
}
