/**
 * 确认下架智能体。
 * Confirm unpublishing a prompt.
 *
 * 智能体被已上架工序使用时，服务端返回该回调，由前端弹出确认框；
 * 用户确定后带 confirmed 标记重新提交，服务端才会真正下架智能体与关联工序。
 *
 * @param  int    promptID
 * @param  string notice
 * @access public
 * @return void
 */
window.confirmAiAgentUnpublish = function(promptID, notice)
{
    $.ajaxSubmit(
    {
        url:     $.createLink('ai', 'promptUnpublish', 'prompt=' + promptID),
        data:    {confirmed: 1},
        confirm: {message: notice, icon: 'icon-exclamation-sign', iconClass: 'warning-pale rounded-full icon-2x'}
    });
};
