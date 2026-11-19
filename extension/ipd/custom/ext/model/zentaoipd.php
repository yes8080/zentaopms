<?php
public function setStoryGrade(string $module, array $data): bool
{
    return $this->loadExtension('zentaoipd')->setStoryGrade($module, $data);
}
