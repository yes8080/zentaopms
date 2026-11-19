<?php
public function checkBizUserLimit($type = 'user')
{
    return $this->loadExtension('zentaobiz')->checkBizUserLimit($type);
}

public function getBizUserLimit($type = 'user')
{
    return $this->loadExtension('zentaobiz')->getBizUserLimit($type);
}

public function getByQuery(string $browseType = 'inside', string $query = '', ?object $pager = null, string $orderBy = 'id'): array
{
    return $this->loadExtension('zentaobiz')->getByQuery($browseType, $query, $pager, $orderBy);
}

public function getLeftUsers()
{
    return $this->loadExtension('zentaobiz')->getLeftUsers();
}

public function getAddUserWarning()
{
    return $this->loadExtension('zentaobiz')->getAddUserWarning();
}
