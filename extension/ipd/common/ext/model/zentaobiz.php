<?php
public function checkExtLicense(string $ext, string $checkDate = ''): bool
{
    return $this->loadExtension('zentaobiz')->checkExtLicense($ext, $checkDate);
}
