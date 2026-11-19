<?php
/**
 * The common header view file of workflow module of ZenTaoPMS.
 * @copyright   Copyright 2026 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.zentao.net)
 * @license     ZPL(https://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Hao Sun <sunhao@chandao.com>
 * @package     workflow
 * @link        https://www.zentao.net
 */
namespace zin;

$backLink        = $this->session->workflowList ? $this->session->workflowList : $this->createLink('workflow', 'browseFlow');
$workflowGroupID = (int)$this->session->workflowGroupID;
$workflowGroup   = $this->loadModel('workflowgroup')->getById($workflowGroupID);
$isQuickMode     = $editorMode == 'quick';
$isBuildInFlow   = $flow->buildin;
$isBuildInAction = !empty($currentAction->buildin) && $currentAction->extensionType == 'extend';
$currentModule   = $this->app->getModuleName();
$currentMethod   = $this->app->getMethodName();

$initEditorSteps = function() use ($editorMode, $flow, $workflowGroupID, $lang, $config, $currentModule, $currentMethod)
{
    $stepList = $editorMode == 'quick' ? $lang->workfloweditor->quickSteps : $lang->workfloweditor->advanceSteps;
    $stepItems = [];
    if($flow->buildin)
    {
        unset($stepList['subTable']);
        unset($stepList['label']);
        unset($lang->workfloweditor->moreSettings['setReport']);
        unset($lang->workfloweditor->moreSettings['fulltext']);

        if(in_array($flow->module, $config->workflow->buildin->noApproval)) unset($lang->workfloweditor->moreSettings['approval']);
    }

      if($workflowGroupID > 0)
      {
          unset($lang->workfloweditor->moreSettings['relation']);
          unset($lang->workfloweditor->moreSettings['setValue']);
          unset($lang->workfloweditor->moreSettings['setExport']);
          unset($lang->workfloweditor->moreSettings['setSearch']);
      }

      if($flow->module == 'cm' || $flow->module == 'projectchange')
      {
          unset($lang->workfloweditor->moreSettings['setExport']);
          unset($lang->workfloweditor->moreSettings['setSearch']);
      }

      $stepUrls    = array();
      $currentStep = -1;
      $index       = 0;
      foreach($stepList as $stepItem)
      {
          $subMenu = array();
          if(isset($stepItem['subMenu'])) $subMenu = $stepItem['subMenu'];
          if(isset($stepItem['link']))    $stepItem = $stepItem['link'];

          list($label, $moduleName, $methodName) = explode('|', $stepItem);
          if($methodName == 'more')
          {
              foreach($lang->workfloweditor->moreSettings as $moreSetting)
              {
                  $moreSetting = explode('|', $moreSetting);
                  if($flow->module != 'charter' && $moreSetting[1] == 'workflow' && $moreSetting[2] == 'setapproval' && $config->edition == 'biz') continue;
                  if(commonModel::hasPriv($moreSetting[1], $moreSetting[2]))
                  {
                      $moduleName = $moreSetting[1];
                      $methodName = $moreSetting[2];
                      $stepParams = $moduleName == 'workflow' && $methodName != 'setapproval' ? sprintf($moreSetting[3], $flow->id) : sprintf($moreSetting[3], $flow->module);
                      break;
                  }
              }

              /* Hide more Settings buttons if none have permissions. */
              if($methodName == 'more') continue;
          }
          else
        {
            $stepParams = $flow->type == 'table' ? "module={$flow->parent}" : "module={$flow->module}";
            if(isset($currentAction)) $stepParams .= "&action={$currentAction->action}";
        }

        if($moduleName == 'workflowfield' && $methodName == 'browse') $stepParams .= "&orderBy=order&groupID={$workflowGroupID}";
        $stepUrl = createLink($moduleName, $methodName, $stepParams);

        if($currentModule == 'workflowfield' && $currentMethod == 'browse' && $flow->type == 'table')
        {
            $isCurrentStep = $moduleName == 'workflow' && $methodName == 'browsedb';
        }
        else
        {
            $isCurrentStep = (($currentModule == $moduleName && $currentMethod == $methodName) or (isset($subMenu[$currentModule]) && stripos(",{$subMenu[$currentModule]},", ",{$currentMethod},") !== false));
        }

        $stepItems[] = ['url' => $stepUrl, 'text' => $label, 'className' => $isCurrentStep ? 'active' : 'selected'];

        if($isCurrentStep) $currentStep = $index;

        $stepUrls[] = $stepUrl;

        $index++;
    }
    return [$stepItems, $stepUrls, $currentStep];
};

div
(
    setID('editorNav'),
    setClass('row items-center justify-between relative'),
    div
    (
        setID('editorNavLeft'),
        btn
        (
            set::type('ghost'),
            set::icon('angle-left'),
            set::url($backLink),
            $flow->name . ($workflowGroup ? " ({$lang->workflowgroup->template} : {$workflowGroup->name}) " : '')
        )
    ),
    div
    (
        setID('editorNavCenter'),
        setClass('absolute center inset-0 pointer-events-none'),
        strong
        (
            setClass('text-md'),
            $isQuickMode ? $lang->workfloweditor->quickEditor :  $lang->workfloweditor->advanceEditor
        )
    ),
    div
    (
        setID('editorNavRight'),
        $isQuickMode ? btn
        (
            set::type('primary'),
            set::url('#switchConfirmModal'),
            setData('toggle', 'modal'),
            sprintf($lang->workfloweditor->switchTo, $lang->workfloweditor->advanceEditor)
        ) : null,
        !$isQuickMode ? btn
        (
            set::type('primary'),
            set::url(createLink('workflow', 'ui', "module={$flow->module}&action=create&groupID={$workflowGroupID}")),
            sprintf($lang->workfloweditor->switchTo, $lang->workfloweditor->quickEditor)
        ) : null
    )
);

if($isQuickMode)
{
    modal
    (
        setID('switchConfirmModal'),
        set::size('sm'),
        p(html($lang->workfloweditor->switchConfirmMessage)),
        div
        (
            setClass('toolbar gap-3 mt-4 justify-center'),
            btn
            (
                set::type('primary'),
                set::url(createLink('workflowfield', 'browse', "module={$flow->module}&orderBy=order&groupID={$workflowGroupID}")),
                $lang->workfloweditor->confirmSwitch
            ),
            btn
            (
                setData('dismiss', 'modal'),
                $lang->workfloweditor->cancelSwitch
            )
        )
    );
}

css('#header{display:none!important}');

list($stepItems, $stepUrls, $currentStep) = $initEditorSteps();
div
(
    setID('editorMenu'),
    setClass('shadow ring p-3 canvas rounded mt-2 row items-center justify-between relative'),
    div
    (
        setID('editorMenuLeft'),
        ($currentStep > 0 && isset($stepUrls[$currentStep - 1])) ? btn
        (
            setClass('prevStep'),
            set::type('primary'),
            set::url($stepUrls[$currentStep - 1]),
            $lang->workfloweditor->prevStep
        ) : null
    ),
    div
    (
        setID('editorSteps'),
        setClass('absolute inset-0 pointer-events-none flex-1 center editor-steps-' . $editorMode),
        nav(setClass('pointer-events-auto'), set::type('steps'), set::items($stepItems))
    ),
    div
    (
        setID('editorMenuRight'),
        setClass('toolbar gap-3'),
        $isQuickMode && $isBuildInAction ? btn
        (
            setID('restoreDefaultBtn'),
            setClass('btn-wide'),
            $lang->workfloweditor->restoreDefault,
            setData('toggle', 'modal'),
            setData('target', '#confirmRestoreModal')
        ) : null,
        $isQuickMode ? btn
        (
            setID('saveBtn'),
            setClass('btn-wide'),
            $lang->save,
            on::click()->call('window.saveFields')
        ) : null,
        ($currentStep == count($stepItems) - 1 and !$isBuildInFlow and $workflowGroupID == 0) ? btn
        (
            setClass('btn-wide'),
            set::type('primary'),
            set::url(createLink('workflow', 'release', "id={$flow->id}")),
            setData('toggle', 'modal'),
            $lang->workflow->release
        ) : null,
        isset($stepUrls[$currentStep + 1]) ? btn
        (
            setClass('btn-wide'),
            set::type('primary'),
            set::url($stepUrls[$currentStep + 1]),
            $lang->workfloweditor->nextStep
        ) : null
    )
);

if($isQuickMode)
{
    modal
    (
        setID('confirmReleaseModal'),
        p(html($lang->workfloweditor->confirmReleaseMessage)),
        div
        (
            setClass('toolbar gap-3 mt-4 justify-center'),
            btn
            (
                set::type('primary'),
                set::url(createLink('workflowfield', 'release', "module={$flow->module}")),
                $lang->workfloweditor->enterToAdvance
            ),
            btn
            (
                set::type('secondary'),
                set::url(createLink('workflow', 'browse', "id={$flow->id}")),
                $lang->workfloweditor->continueRelease
            )
        )
    );
}

if($isQuickMode && $isBuildInAction)
{
    modal
    (
        setID('confirmRestoreModal'),
        set::size('sm'),
        p(html(sprintf($lang->workfloweditor->confirmRestore, $currentAction->name))),
        div
        (
            setClass('toolbar gap-3 mt-4 justify-center'),
            btn
            (
                setID('confirmRestoreBtn'),
                set::type('primary'),
                set::btnType('button'),
                $lang->workfloweditor->confirmRestoreBtn
            ),
            btn
            (
                setData('dismiss', 'modal'),
                $lang->cancel
            )
        )
    );
}
