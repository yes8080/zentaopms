<?php
/**
 * The ajaxgetdropmenu view file of pi module of ZenTaoPMS.
 *
 * @copyright   Copyright 2023 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @author      Yuting Wang<wangyuting@easycorp.ltd>
 * @package     pi
 * @version     $Id
 * @link        https://www.zentao.net
 */
namespace zin;

$data = array();
foreach($ARTList as $artID => $ART)
{
    $ARTItem = array();
    $ARTItem['type']  = $lang->art->common;
    $ARTItem['text']  = $ART;
    $ARTItem['items'] = array();

    $data['other'][$artID]  = $ARTItem;
    $data['closed'][$artID] = $ARTItem;

    $PIList = zget($PIGroup, $artID, array());
    foreach($PIList as $piID => $PI)
    {
        $item = array();
        $item['id']    = $PI->id;
        $item['text']  = $PI->name;
        $item['keys']  = zget(common::convert2Pinyin(array($PI->name)), $PI->name, '');

        if($PI->status != 'closed')
        {
            $data['other'][$artID]['items'][] = $item;
        }
        else
        {
            $data['closed'][$artID]['items'][] = $item;
        }
    }
}

/* 将分组数据转换为索引数组。Format grouped data to indexed array. */
foreach ($data as $key => $value) $data[$key] = array_values($value);

/**
 * 定义最终的 JSON 数据。
 * Define the final json data.
 */
$json = array();
$json['data']       = $data;
$json['tabs']       = array(array('name' => 'other'), array('name' => 'closed', 'text' => $lang->pi->statusList['closed']));
$json['searchHint'] = $lang->searchAB;
$json['link']       = array('PI' => sprintf($link, '{id}'));
$json['expandName'] = 'closed';
$json['itemType']   = 'PI';

$json['footToolbar']   = array();
if(common::hasPriv('art', 'browse')) $json['footToolbar'][] = array('text' => $lang->pi->viewAllART, 'url' => $this->createLink('art', 'browse'));
if(common::hasPriv('art', 'create')) $json['footToolbar'][] = array('text' => $lang->pi->createART,  'url' => $this->createLink('art', 'create'));

/**
 * 渲染 JSON 字符串并发送到客户端。
 * Render json data to string and send to client.
 */
renderJson($json);
