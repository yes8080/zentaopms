<?php
public function readExcel(string $module = '', int $pagerID = 1, string $insert = '', string $filter = ''): object|bool
{
    return $this->loadExtension('excel')->readExcel($module, $pagerID, $insert, $filter);
}
