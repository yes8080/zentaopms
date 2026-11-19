<?php
namespace zin;

class aiProcedureEntry extends wg
{
    protected static array $defineProps = array
    (
        'objectType' => 'string',
        'objectID'   => 'int',
    );

    protected mixed $procedureRun = null;

    protected ?array $procedures = null;

    protected function created()
    {
        parent::created();

        global $app;
        $objectType = $this->prop('objectType');
        $objectID   = (int)$this->prop('objectID');
        if(empty($objectType) || empty($objectID)) return null;

        $app->control->loadModel('aiprocedure');

        $modules = $this->getModules($objectType, $objectID);
        $this->procedures   = $app->control->aiprocedure->getActiveProceduresByModule($modules);
        $this->procedureRun = $app->control->aiprocedure->getRunningProcedureRun($objectType, $objectID);

        /* 工序被下架或删除后，进行中的运行实例仍需展示，用户可从原入口跑完整个工序。 */
        if(empty($this->procedures) && empty($this->procedureRun)) return null;
    }

    protected function buildProcedureRun(object $run)
    {
        return div
        (
            setClass('ai-procedure-run'),
            div(setClass('text-md font-bold mb-2'), $run->procedureName),
            self::buildSteps($run->steps, (int)$run->currentStep),
        );
    }

    protected function buildProcedureList(array $procedures, string $objectType, int $objectID)
    {
        global $lang;

        return div
        (
            setClass('ai-procedure-list flex flex-wrap gap-4'),
            style::marginTop(0),
            array_map(function($procedure) use ($objectType, $objectID, $lang)
            {
                return div
                (
                    setClass('ai-procedure-list-item my-2 border border-strong rounded-full pl-3 pr-1.5 py-1.5 flex items-center'),
                    div
                    (
                        setClass('overflow-hidden text-ellipsis whitespace-nowrap'),
                        setStyle('max-width', '120px'),
                        set::title($procedure->name),
                        $procedure->name
                    ),
                    btn
                    (
                        set::type('primary size-sm rounded-full ml-2'),
                        set::text($lang->aiprocedure->start),
                        on::click()->call('window.top.runProcedureInWorkbenchPanel', $procedure->id, $objectType, $objectID)
                    )
                );
            }, $procedures),
        );
    }

    protected function build()
    {
        global $lang;

        $procedures = $this->procedures;
        $run        = $this->procedureRun;
        if(empty($procedures) && empty($run)) return null;

        $objectType = $this->prop('objectType');
        $objectID   = (int)$this->prop('objectID');

        return div
        (
            setClass('detail-sections canvas shadow rounded px-6 py-4'),
            div
            (
                setClass('ai-procedure-toolbar flex items-center justify-between'),
                div(setClass('text-md font-bold mb-2'), $lang->aiprocedure->common),
                hasPriv('aiprocedure', 'history') ? btn
                (
                    set::icon('history'),
                    set::type('ghost text-primary'),
                    set::url(createLink('aiprocedure', 'history', "objectType={$objectType}&objectID={$objectID}")),
                    set::text($lang->aiprocedure->viewHistory),
                    setData('toggle', 'modal')
                ) : null
            ),
            $run ? $this->buildProcedureRun($run) : $this->buildProcedureList($procedures, $objectType, $objectID)
        );
    }

    /**
     * 获取工序显示位置匹配列表。
     * Get matched procedure modules.
     *
     * @param  string $objectType
     * @return array
     */
    protected function getModules(string $objectType, int $objectID = 0): array
    {
        global $app;

        if($objectType === 'story' && $objectID > 0)
        {
            $story = $app->control->loadModel('story')->getByID($objectID);
            if($story && !empty($story->type)) return array($story->type);
        }

        return array($objectType);
    }

    /**
     * 构建工序步骤工具栏。
     * Build procedure steps toolbar.
     *
     * @param  array $steps
     * @param  int   $currentStepID
     * @return string
     */
    public static function buildSteps(array $steps, ?int $currentStepID = null)
    {
        if(empty($steps)) return null;

        /* Sort steps by order. */
        usort($steps, function($a, $b) {return $a->order - $b->order;});

        $items = [];
        $currentStep = null;
        foreach($steps as $index => $step)
        {
            $isCurrent     = $currentStepID && $currentStepID == $step->id;
            $beforeCurrent = !$currentStep && !$isCurrent && $currentStepID;
            if($isCurrent && !$currentStep) $currentStep = $step;

            $items[$index] = [];
            $items[$index]['text']      = $step->name;
            $items[$index]['hint']      = $step->name;
            $items[$index]['iconClass'] = 'index';

            if($beforeCurrent)
            {
                $items[$index]['icon']      = 'check text-success w-5 h-5 rounded-full bg-success-pale border border-strong center';
                $items[$index]['className'] = 'primary-pale ring ring-dark';
            }
            else
            {
                $items[$index]['icon']      = wg(span(
                    setClass('w-5 h-5 rounded-full bg-gray-100 border border-strong center', $isCurrent ? 'text-fore'  : ''),
                    setStyle('font-style', 'normal'),
                    $index + 1
                ));
            }

            if($isCurrent)
            {
                $items[$index]['className'] = 'primary ring ring-dark';
            }
        }
        return toolbar
        (
            setClass('ai-procedure-steps overflow-auto px-px py-px pb-2'),
            set::gap(8),
            set::btnClass('rounded-full size-md pointer-events-none'),
            set::btnProps(['style' => ['padding-left' => '4px']]),
            set::items(array_values($items)),
            css(
                '.ai-procedure-steps > .btn + .btn::after {content: " "; display: block; height: 1px; left: -29px; position: absolute; top: 50%; width: 25px; background-color: var(--color-gray-400);}',
                '.ai-procedure-steps > .btn > .text {overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 120px;}'
            )
        );
    }
}
