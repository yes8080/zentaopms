window.saveAvatar = function(e, data)
{
    $.ajaxSubmit({
        url: $.createLink('aiteammate', 'cropAvatar', 'imageID=' + imageID + '&teammateID=' + teammateID),
        data: data
    });
};
