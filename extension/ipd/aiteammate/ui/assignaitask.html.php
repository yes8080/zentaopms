<?php
namespace zin;

$fnBuildFields = function() use ($lang, $agentFields, $config)
{
    $fields = [];
    foreach($agentFields as $id => $field)
    {
        $multiple = $field->type == 'checkbox';
        $type     = $field->type;
        if($type == 'radio' || $type == 'checkbox') $type = 'picker';
        if(!empty($field->options))
        {
            $field->options = explode(',', $field->options);
            $field->options = array_combine($field->options, $field->options);
        }

        $fields[] = formGroup
        (
            set::label($field->name),
            set::labelProps(array('title' => $field->name)),
            set::name('field' . $field->id),
            set::required($field->required),
            set::control(['control' => $type, 'items' => $field->options, 'placeholder' => $field->placeholder, 'multiple' => $multiple]),
        );
    }

    return $fields;
};

$fromForm = !empty($this->view->fromForm);

$avatar   = $teammate->avatar;
$noAvatar = empty($avatar);
if($noAvatar) $avatar = $app->config->webRoot . 'static/zentaoaipro/ai-teammate-default.png';
if(strpos($avatar, $app->config->webRoot) !== 0) $avatar = $app->config->webRoot . $avatar;
unset($lang->aiteammate->optionsAfterSaving[$from === 'global' ? '2' : '3']);
foreach($config->aiteammate->timeOptions as $value) $lang->aiteammate->noticeTimeOptions[1]['items'][] = ['text' => $value, 'value' => $value];
formPanel
(
    set::title($lang->aiteammate->assignedTo),
    set::actions([
        ['text' => $lang->aiteammate->back, 'class' => 'secondary', 'url' => inlink('assignagent', "teammateID=$teammate->id&objectType=$objectType&objectID=$objectID&pageInfo=$pageInfo&from=$from"), 'data-dismiss' => 'modal', 'data-toggle' => 'modal', 'data-size' => 'sm'],
        ['text' => $lang->save, 'type' => 'primary', 'btnType' => 'submit'],
    ]),
    div
    (
        setClass('flex gap-4'),
        avatar
        (
            $noAvatar ? setStyle(array('filter' => 'hue-rotate(' . (($teammate->id * 53) % 360) . 'deg)')) : setStyle(['min-width' => '32px']),
            set::src($avatar),
            set::text($teammate->name),
            set::size('32'),
        ),
        div
        (
            setClass('col gap-3'),
            div
            (
                setClass('bg-primary-50 text-fore p-4 mb-1'),
                setStyle(['border-radius' => '10px', 'border-top-left-radius' => '0']),
                sprintf($lang->aiteammate->tips->assignAITask, $agent->name)
            ),
            $fnBuildFields(),
            formGroup
            (
                set::label($lang->aiteammate->noticeTime),
                set::required(true),
                picker
                (
                    set::tree(),
                    set::search(false),
                    set::name('noticeTime'),
                    set::items($lang->aiteammate->noticeTimeOptions),
                    set::required(true),
                )
            ),
            formGroup
            (
                set::label($lang->aiteammate->afterSaving),
                radioList
                (
                    set::name('afterSaving'),
                    set::items($lang->aiteammate->optionsAfterSaving),
                    set::value($from == 'global' ? '3' : '2'),
                    set::inline(true)
                ),
            ),
            $fromForm ? input(set::type('hidden'), set::name('formSchema')) : null,
            $fromForm ? input(set::type('hidden'), set::name('formPageUrl')) : null,
        )
    )
);
