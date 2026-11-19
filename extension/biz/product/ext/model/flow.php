<?php
public function getProductLink(string $module, string $method, string $extra = '', bool $branch = false): string
{
    return $this->loadExtension('flow')->getProductLink($module, $method, $extra, $branch);
}
