<?php
public function create(object $design): bool|int
{
    return $this->loadExtension('relation')->create($design);
}
public function update(int $designID = 0, ?object $design = null): bool|array
{
    return $this->loadExtension('relation')->update($designID, $design);
}
