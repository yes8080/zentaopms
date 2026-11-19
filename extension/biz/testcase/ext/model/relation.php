<?php
public function create(object $case): bool|int
{
    return $this->loadExtension('relation')->create($case);
}
public function update(object $case, object $oldCase, array $testtasks = array()): bool|array
{
    return $this->loadExtension('relation')->update($case, $oldCase, $testtasks);
}
