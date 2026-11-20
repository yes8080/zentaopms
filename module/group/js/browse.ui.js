/**
 * 提示并删除分组。
 * Delete group with tips.
 *
 * @param  int    groupID
 * @param  string groupName
 * @access public
 * @return void
 */
window.confirmDelete = function(groupID, groupName)
{
    zui.Modal.confirm(deleteGroupMessage.replace('%s', groupName)).then((res) =>
    {
        if(res) $.ajaxSubmit({method: 'POST', data: {csrfToken: groupCsrfToken}, url: $.createLink('group', 'delete', 'groupID=' + groupID)});
    });
}
