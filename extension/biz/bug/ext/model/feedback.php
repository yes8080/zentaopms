<?php
public function create(object $bug, string $from = ''): int|false
{
    return $this->loadExtension('feedback')->create($bug, $from);
}

public function getByID(int $bugID, bool $setImgSize = false): object|false
{
    return $this->loadExtension('feedback')->getById($bugID, $setImgSize);
}
