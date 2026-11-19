<?php
/**
 * The batch create view file of flow module of ZenTaoPMS.
 * @copyright   Copyright 2009-2024 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Gang Liu <liugang@easycorp.ltd>
 * @package     flow
 * @link        https://www.zentao.net
 */
namespace zin;
include 'header.html.php';

$items = $this->flowZen->buildBatchFormItems($fields);
$batchData = array();
foreach((array)$dataList as $row)
{
    if(is_object($row)) $batchData[] = $row;
}

formBatchPanel
(
    set::mode('add'),
    set::title($title),
    set::url($actionURL),
    set::items($items),
    set::rowsCount(!empty($dataList) ? count($dataList) : $this->config->flow->batchCreateRow),
    !empty($batchData) ? set::data($batchData) : null
);

html($formulaScript);
