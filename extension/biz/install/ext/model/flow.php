<?php
public function grantPriv(object $data): bool
{
    parent::grantPriv($data);
    if(dao::isError()) return false;
    $this->loadModel('upgrade')->importBuildinModules();
    $this->loadModel('upgrade')->addSubStatus();
    return true;
}
