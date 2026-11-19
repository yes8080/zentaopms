<?php
public function setMenu(int $productID = 0, string|int $branch = '', string $extra = ''): bool
{
    return $this->loadExtension('web')->setMenu($productID, $branch, $extra);
}
