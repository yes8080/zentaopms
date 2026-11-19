<?php
/**
 * 设置设计导航。
 * Set design menu.
 *
 * @param  int    $projectID
 * @param  int    $productID
 * @param  string $type
 * @access public
 * @return void
 */
public function setMenu(int $projectID, int $productID = 0, string $type = ''): void
{
    $this->loadExtension('zentaomax')->setMenu($projectID, $productID, $type);
}
