<?php
helper::importControl("task");
class myTask extends task
{
    public function create(int $executionID = 0, int $storyID = 0, int $moduleID = 0, int $taskID = 0, int $todoID = 0, string $cardPosition = '', int $bugID = 0, string $type = '')
    {
        parse_str(str_replace(array(',', ' '), array('&', ''), $cardPosition), $extra);
        if(isset($extra['riOperation']) && !empty($_POST)
            && ($this->post->type === 'affair' || $this->post->multiple || $this->post->selectTestStory === 'on'))
        {
            $this->app->loadLang('reqintake');
            return $this->send(array('result' => 'fail', 'message' => $this->lang->reqintake->errors['taskConversionMode']));
        }

        return parent::create($executionID, $storyID, $moduleID, $taskID, $todoID, $cardPosition, $bugID, $type);
    }
}
