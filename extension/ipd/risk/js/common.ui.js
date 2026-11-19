function computeIndex(event)
{
    if(config.currentMethod == 'batchcreate' || config.currentMethod == 'batchedit')
    {
        $row        = $(event.target).closest('tr');
        $impact      = $row.find('input[name^=impact]');
        $probability = $row.find('input[name^=probability]');
        $rate        = $row.find('input[name^=rate]');
        $pri         = $row.find('input[name^=pri]');

    }
    else
    {
        $impact      = $('input[name=impact]');
        $probability = $('input[name=probability]');
        $rate        = $('input[name=rate]');
        $pri         = $('input[name=pri]');
    }

    let impact      = $impact.val();
    let probability = $probability.val();
    let rate = parseInt(impact * probability);
    let pri  = 2;

    if(0 <= rate && rate <= 5)   pri = 3;
    if(5 < rate && rate <= 12)   pri = 2;
    if(15 <= rate && rate <= 25) pri = 1;

    $rate.val(rate);
    $pri.zui('priPicker').$.setValue(pri);
}
