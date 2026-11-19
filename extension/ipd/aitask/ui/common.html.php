<?php
namespace zin;

$buildTaskResults = function($task) use ($lang)
{
    $results = $task->result;
    if(is_string($results)) $results = json_decode($results, true);

    if(empty($results))
    {
        $response = isset($task->response) ? $task->response : '';
        $content  = is_object($response) ? ($response->content ?? '') : $response;
        if(empty($content)) return $lang->aitask->noResults;

        return div
        (
            setClass('ai-task-result-list space-y-2'),
            div
            (
                setClass('ring rounded pt-1 pb-2 px-3 overflow-y-auto markdown-content article ai-markdown-content'),
                style::maxHeight('500px'),
                zui::markdown
                (
                    set::content($content),
                    set::highlight(),
                    set::htmlSandbox()
                )
            )
        );
    }

    $agentsData       = is_string($task->agentsData) ? json_decode($task->agentsData, true) : (array)$task->agentsData;
    $formSchemaFields = !empty($agentsData['_formSchema']['fields']) ? $agentsData['_formSchema']['fields'] : array();
    $baseData         = array();

    if(!empty($formSchemaFields))
    {
        foreach($formSchemaFields as $name => $field)
        {
            if(isset($field['currentValue'])) $baseData[$name] = $field['currentValue'];
        }
    }

    $baseDataJson = empty($baseData) ? '' : json_encode($baseData, JSON_UNESCAPED_UNICODE);
    $views        = [];

    foreach($results as $result)
    {
        $name = isset($result['name']) ? $result['name'] : null;
        if(is_null($name)) $name = $result['type'] == 'task-fail' ? $this->lang->aichat->toolResults['fail'] : $this->lang->aichat->toolResults['complete'];

        $formLocation = $result['formLocation'] ?? '';
        $parts        = explode('.', $result['targetForm'] ?? '');

        if(!empty($formLocation)) $targetUrl = $formLocation;
        elseif(!empty($parts[0]) && !empty($parts[1]) && !empty($result['objectID']))
        {
            $urlParams = $parts[0] . 'ID=' . $result['objectID'];
            $targetUrl = helper::createLink($parts[0], $parts[1], $urlParams);
        }
        else $targetUrl = '';

        if($baseDataJson)
        {
            $result['formLocation'] = $targetUrl;
            $onTargetForm = jsRaw("function(loc, data, callback) { parent.openPageForm('{$targetUrl}', Array.isArray(data) ? data : Object.assign({$baseDataJson}, data || {}), callback); }");
        }
        else
        {
            $result['formLocation'] = $targetUrl;
            $onTargetForm = jsRaw('parent.openPageForm');
        }

        $views[] = div
        (
            setClass('ring rounded pt-1 pb-2 px-3'),
            div
            (
                setClass('mb-2 row items-center gap-2'),
                icon($result['type'] == 'task-fail' ? 'alert text-danger' : 'check-circle text-success'),
                $name
            ),
            zui::ZentaoAgentResult
            (
                set($result),
                set::onOpenTargetForm($onTargetForm)
            ),
            empty($result['data']) && !empty($task->response) ? div
            (
                setClass('mt-2 overflow-y-auto markdown-content article ai-markdown-content'),
                style::maxHeight('500px'),
                zui::markdown
                (
                    set::content(is_object($task->response) ? ($task->response->content ?? '') : $task->response),
                    set::highlight(),
                    set::htmlSandbox()
                )
            ) : null
        );
    }
    return div
    (
        setClass('ai-task-result-list space-y-2'),
        $views
    );
};
