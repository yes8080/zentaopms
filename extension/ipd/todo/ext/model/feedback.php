<?php
public function create(object $todo): int|false
{
    return $this->loadExtension('feedback')->create($todo);
}
