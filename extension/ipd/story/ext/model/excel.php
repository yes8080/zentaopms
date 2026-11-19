<?php
public function setListValue($productID, $branch = 0)
{
    return $this->loadExtension('excel')->setListValue($productID, $branch);
}

public function createFromImport($productID, $branch = 0, $type = 'story', $projectID = 0)
{
    return $this->loadExtension('excel')->createFromImport($productID, $branch, $type, $projectID);
}

public function replaceURLang(string $type): void
{
    $this->loadExtension('excel')->replaceURLang($type);
}
