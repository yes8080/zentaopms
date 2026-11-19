<?php
/**
 * The model file of calendar module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2012 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     business(商业软件)
 * @author      Memory <lvtao@cnezsoft.com>
 * @package     calendar
 * @version     $Id$
 * @link        http://www.zentao.net
 */
public function getUserStoryPairs(string $account, int $limit = 10, string $type = 'story', array|string $skipProductIDList = array(), int|string|array $appendStoryID = 0): array
{
    return $this->loadExtension('calendar')->getUserStoryPairs($account, $limit, $type, $skipProductIDList, $appendStoryID);
}
