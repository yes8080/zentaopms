<?php
/**
 * The batchEdit view file of feedback module of ZenTaoPMS.
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Yuting Wang <wangyuting@easycorp.ltd>
 * @package     feedback
 * @link        https://www.zentao.net
 */
namespace zin;
jsVar('modules', $moduleList);

$items = array();
$items['id']         = array('name' => 'id',         'label' => $lang->idAB,                 'control' => 'index',  'width' => '50px');
$items['product']    = array('name' => 'product',    'label' => $lang->feedback->product,    'control' => 'picker', 'width' => '200px', 'required' => true, 'items' => $products);
$items['module']     = array('name' => 'module',     'label' => $lang->feedback->module,     'control' => 'picker', 'width' => '200px', 'value' => '0',     'items' => array('0' => '/'));
$items['title']      = array('name' => 'title',      'label' => $lang->feedback->title,      'control' => 'input',  'width' => '200px', 'required' => true);
$items['assignedTo'] = array('name' => 'assignedTo', 'label' => $lang->feedback->assignedTo, 'control' => 'picker', 'width' => '160px', 'items' => $users);

formBatchPanel
(
    set::title($lang->feedback->batchEdit),
    set::mode('edit'),
    set::data(array_values($feedbacks)),
    set::onRenderRow(jsRaw('renderRowData')),
    set::items($items),
    on::change('[data-name="product"]', 'changeProduct')
);

render();

