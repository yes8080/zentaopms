/* 计划完成同上时，把上一行执行日历的周六、周日上班设置带到当前行。 */
window.applyDittoSchedule = function($schedule)
{
    const $row   = $schedule.closest('tr');
    const $endTd = $row.find('td[data-name="endBox"], td[data-name="end"]');
    if($endTd.attr('data-ditto') !== 'on') return;

    const $prev = $row.prev('tr');
    if(!$prev.length) return;

    const prevRaw = $prev.find('input[name^=schedule]').val();
    if(!prevRaw) return;

    let prevSchedule = null;
    try
    {
        prevSchedule = JSON.parse(prevRaw);
    }
    catch(e)
    {
        return;
    }
    if(!prevSchedule || typeof prevSchedule.workDays === 'undefined') return;

    let schedule;
    try
    {
        schedule = JSON.parse($schedule.val() || '{}');
    }
    catch(e)
    {
        return;
    }
    if(!schedule || typeof schedule !== 'object' || Array.isArray(schedule)) return;

    schedule.workDays = prevSchedule.workDays;
    if(prevSchedule.begin)        schedule.begin        = prevSchedule.begin;
    if(prevSchedule.end)          schedule.end          = prevSchedule.end;
    if(prevSchedule.calendar)     schedule.calendar     = prevSchedule.calendar;
    if(prevSchedule.minWorkHours) schedule.minWorkHours = prevSchedule.minWorkHours;
    if(prevSchedule.maxWorkHours) schedule.maxWorkHours = prevSchedule.maxWorkHours;
    $schedule.val(JSON.stringify(schedule));
};

window.updateWorkDays = function($obj)
{
    if($obj.length && $obj.val())
    {
        const schedule = JSON.parse($obj.val());
        $obj.closest('tr').find('input[name^=days]').val(Object.keys(schedule.calendar || {}).length);
    }

    const $next = $obj.closest('tr').next('tr');
    if(!$next.length) return;
    if($next.find('td[data-name="endBox"], td[data-name="end"]').attr('data-ditto') !== 'on') return;

    const begin = $next.find('input[name^=begin]').val();
    const end   = $next.find('input[name^=end]').val();
    if(!begin || !end || (typeof longTime !== 'undefined' && end === longTime)) return;

    const $schedule = $next.find('input[name^=schedule]');
    const projectID = $next.find('.btn-calendar').data('project');
    const $enabled  = $next.find('input[type=checkbox][name^="enabled"]');
    if($enabled.length && !$enabled.prop('checked')) return;
    if(window.generateSchedule) window.generateSchedule('end', $schedule, projectID, begin, end);
};

/* 重新启用时按当前起止日期补算日历。子阶段的勾选由 changeEnabled 同步，这里一并处理。 */
window.syncStageCalendar = function($row)
{
    const $enabled = $row.find('input[type=checkbox][name^="enabled"]');
    const $btn     = $row.find('.btn-calendar');
    if($enabled.length && !$enabled.prop('checked'))
    {
        $btn.addClass('disabled');
        return;
    }

    const begin = $row.find('input[name^=begin]').val();
    const end   = $row.find('input[name^=end]').val();
    if(!begin || !end || (typeof longTime !== 'undefined' && end === longTime) || begin > end)
    {
        $btn.addClass('disabled');
        return;
    }

    $btn.removeClass('disabled');
    const $schedule = $row.find('input[name^=schedule]');
    const projectID = $btn.data('project');
    if(window.generateSchedule) window.generateSchedule('end', $schedule, projectID, begin, end);
};

$(document).off('change', '[name^="enabled"]').on('change', '[name^="enabled"]', function()
{
    const $row = $(this).closest('tr');
    window.syncStageCalendar($row);

    let $next = $row.next();
    while($next.length && $next.attr('data-level') != '0')
    {
        window.syncStageCalendar($next);
        $next = $next.next();
    }
});

function installDittoSchedule()
{
    if(!window.generateSchedule)
    {
        installDittoSchedule.retry = (installDittoSchedule.retry || 0) + 1;
        if(installDittoSchedule.retry > 50) return;
        setTimeout(installDittoSchedule, 100);
        return;
    }
    if(window.generateSchedule.dittoWrapped) return;

    const originGenerateSchedule = window.generateSchedule;
    const wrapped = function(objectType, $schedule, projectID, begin, end)
    {
        /* 开始大于完成时日期还不合法，先不带上一行的周六、周日，也不重算。日期合法后再带上并按当前行重新生成。 */
        if(begin && end && begin > end) return false;
        /* 未启用的阶段不参与排期，改日期和刷新下一行都在这里拦住。 */
        if($schedule && $schedule.length)
        {
            const $enabled = $schedule.closest('tr').find('input[type=checkbox][name^="enabled"]');
            if($enabled.length && !$enabled.prop('checked')) return false;
        }
        if(/^(begin|end)(\[|$)/.test(String(objectType)) && $schedule && $schedule.length) window.applyDittoSchedule($schedule);
        return originGenerateSchedule.call(this, objectType, $schedule, projectID, begin, end);
    };
    wrapped.dittoWrapped = true;
    window.generateSchedule = wrapped;
}
$(installDittoSchedule);
