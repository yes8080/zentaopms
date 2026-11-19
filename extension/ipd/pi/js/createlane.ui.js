window.initColorPicker = function(){
    colorList.forEach(function(color)
    {
        var itemClass = color.toUpperCase() == $('input[name=color]').val().toUpperCase() ? 'color-picker-item checked' : 'color-picker-item';
        var colorItem = "<div class='" + itemClass  + "' data-color='" + color  + "' style='background: " + color  + "'>";
        colorItem += "<i class='icon icon-check'></i>";
        colorItem += "</div>";
        $('#color-picker').append(colorItem);
    });
}

initColorPicker();

$(function(){
    $('#color-picker').on('click', '.color-picker-item', function(){
        var color = $(this).attr('data-color');
        $('input[name=color]').val(color);
        $(this).addClass('checked');
        $(this).siblings().removeClass('checked');
    })
})
