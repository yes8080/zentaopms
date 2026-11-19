<?php
$lang->block->summary->welcome = 'gitfox已陪伴您%s';

$lang->block->welcome->reviewByMe = '與我相關';

$lang->block->welcome->reviewList['reviewByMe']      = '待我評審';
$lang->block->welcome->reviewList['myCreatedReview'] = '我發起的評審';
$lang->block->welcome->reviewList['myIssue']         = '待我解決的問題';

$lang->block->modules['ppm'] = new stdclass();
$lang->block->modules['ppm']->availableBlocks['reviewbyme']        = '待我評審';
$lang->block->modules['ppm']->availableBlocks['reviewcreatedbyme'] = '我創建的評審';

$lang->block->titleList['reviewbyme']        = '待我評審';
$lang->block->titleList['reviewcreatedbyme'] = '我創建的評審';

$lang->block->reviewbyme = new stdclass();
$lang->block->reviewbyme->featureBar['all']      = '全部';
$lang->block->reviewbyme->featureBar['pending']  = '待評審';
$lang->block->reviewbyme->featureBar['reviewed'] = '已評審';

$lang->block->reviewcreatedbyme = new stdclass();
$lang->block->reviewcreatedbyme->featureBar['all']    = '全部';
$lang->block->reviewcreatedbyme->featureBar['opened'] = '開放中';
$lang->block->reviewcreatedbyme->featureBar['merged'] = '已合併';
$lang->block->reviewcreatedbyme->featureBar['closed'] = '已關閉';

$lang->block->teamachievement->commits        = '代碼提交次數';
$lang->block->teamachievement->createdReviews = '發起的評審數';
$lang->block->teamachievement->mergedReviews  = '合併的評審數';
$lang->block->teamachievement->resolvedIssues = '解決的問題數';

$lang->block->zentaoDynamic              = 'gitfox動態';
$lang->block->titleList['zentaodynamic'] = 'gitfox動態';

$lang->block->moduleList = array
(
    'ppm'             => $lang->devops->ppm,
    'welcome'         => $lang->block->welcome->common,
    'zentaodynamic'   => $lang->block->zentaoDynamic,
    'teamachievement' => $lang->block->teamAchievement,
    'dynamic'         => $lang->block->dynamic,
    'html'            => $lang->block->html
);

$lang->block->default['full']['my'] = array
(
    array('title' => '歡迎總覽',     'module' => 'welcome',         'code' => 'welcome',          'width' => '2'),
    array('title' => '待我評審',     'module' => 'ppm',             'code' => 'reviewbyme',       'width' => '2', 'params' => array('count' => '20')),
    array('title' => '我創建的評審', 'module' => 'ppm',             'code' => 'reviewcreatedbyme','width' => '2', 'params' => array('count' => '20')),
    array('title' => 'gitfox動態',   'module' => 'zentaodynamic',   'code' => 'zentaodynamic',    'width' => '1'),
    array('title' => '最新動態',     'module' => 'dynamic',         'code' => 'dynamic',          'width' => '1'),
    array('title' => '團隊成就',     'module' => 'teamachievement', 'code' => 'teamachievement',  'width' => '1')
);
