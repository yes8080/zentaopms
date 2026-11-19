<?php
public function checkBlockPriv(string $type)
{
    return $this->loadExtension('zentaomax')->checkBlockPriv($type);
}
