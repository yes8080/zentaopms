<?php
public function bind(): object|false
{
    return $this->loadExtension('zentaobiz')->bind();
}

public function createUser(object $data): array
{
    return $this->loadExtension('zentaobiz')->createUser($data);
}
