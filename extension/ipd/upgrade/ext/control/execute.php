<?php
/**
 * 该文件只用于覆盖升级，如果删除该文件，升级的时候不能覆盖旧包已有文件，可能引发报错。解决Bug #76617。
 * This file only used for upgrade, if delete this file, upgrade will not cover old package's files, may cause errors.
 */
helper::importControl('upgrade');
class myupgrade extends upgrade
{
    public function execute(string $fromVersion = '')
    {
        parent::execute($fromVersion);
    }
}
