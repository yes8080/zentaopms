<?php
namespace zin;

$app = data('app');
$appParams = $app->getParams();
$extra     = zget($appParams, 'extra', '');

$storyModel = $app->control->loadModel('story');
$piID       = 0;
if($extra)
{
    $extra = $storyModel->parseExtra($extra);
    if(isset($extra['piID'])) $piID = $extra['piID'];
}

if($piID)
{
    $createFields = data('fields');
    $type         = data('type');
    $isBranchUR   = isset($createFields['branch']) && $type != 'story';

    $pi       = $storyModel->dao->select('*')->from(TABLE_PI)->where('id')->eq($piID)->fetch();
    $products = $storyModel->dao->select('id,name')->from(TABLE_PRODUCT)->where('id')->in($pi->product)->fetchPairs();
    $default  = $createFields['product']['default'];
    if(!isset($products[$default]))
    {
        $isBranchUR = false;
        $default    = key($products);
    }

    $fields = useFields('story.create');
    $fields->field('product')
        ->hidden(data('product.shadow'))
        ->required()
        ->control('inputGroup')
        ->items(false)
        ->itemBegin('product')->control('picker')->items($products)->value($default)->required(true)->itemEnd()
        ->item($isBranchUR ? field('branch')->control('picker')->boxClass('flex-none')->width('100px')->name('branch')->items($createFields['branch']['options'])->value($createFields['branch']['default']) : null);
}
