<?php
if($actionID <= 0) return false;
$action = $this->getById($actionID);
if(!$action || $action->action != 'deleted') return false;
if($action->objectType == 'user')
{
    $user = $this->dao->select('*')->from(TABLE_USER)->where('id')->eq($action->objectID)->fetch();
    if($this->loadModel('user')->checkBizUserLimit()) return $this->app->control->sendError($this->lang->user->noticeUserLimit);
}

if($action->objectType == 'aiskill')
{
    $skill = $this->dao->select('*')->from(TABLE_AI_SKILL)->where('id')->eq($action->objectID)->fetch();
    if(!$skill) return false;

    $this->dao->begin();
    $this->dao->update(TABLE_AI_SKILL)->set('deleted')->eq('0')->where('id')->eq($action->objectID)->exec();
    if(dao::isError())
    {
        $this->dao->rollBack();
        return false;
    }

    $apiSkill = null;
    if(!empty($skill->skillID) && ($skill->type == 'public' || empty($skill->fromID)))
    {
        $this->app->loadLang('ai');

        $fileModel = $this->loadModel('file');
        $files     = $fileModel->getByObject('aiskill', (int)$skill->id);
        if(empty($files))
        {
            dao::$errors[] = $this->lang->ai->skills->tips->emptyFile;
            $this->dao->rollBack();
            return false;
        }

        $sourceFile = reset($files);
        if(empty($sourceFile->realPath) || !is_file($sourceFile->realPath))
        {
            dao::$errors[] = $this->lang->fail;
            $this->dao->rollBack();
            return false;
        }

        $uploadTmp = tempnam(sys_get_temp_dir(), 'aiskill_');
        if($uploadTmp === false || !copy($sourceFile->realPath, $uploadTmp))
        {
            if($uploadTmp !== false && is_file($uploadTmp)) @unlink($uploadTmp);
            dao::$errors[] = $this->lang->fail;
            $this->dao->rollBack();
            return false;
        }

        $oldFiles = $_FILES;
        $_FILES   = array(
            'files' => array(
                'name'     => array($sourceFile->title),
                'type'     => array('application/zip'),
                'tmp_name' => array($uploadTmp),
                'error'    => array(0),
                'size'     => array((int)filesize($uploadTmp))
            )
        );

        $apiSkill = clone $skill;
        $aiBiz    = $this->loadModel('ai')->loadExtension('zentaobiz');
        if(!$aiBiz->createSkillByApi($apiSkill) || dao::isError())
        {
            $_FILES = $oldFiles;
            @unlink($uploadTmp);
            $this->dao->rollBack();
            return false;
        }

        $_FILES = $oldFiles;
        @unlink($uploadTmp);
    }

    $this->dao->update(TABLE_ACTION)->set('extra')->eq(actionModel::BE_UNDELETED)->where('id')->eq($actionID)->exec();
    if(!dao::isError()) $this->create($action->objectType, $action->objectID, 'undeleted');
    if(dao::isError())
    {
        if($apiSkill && !empty($apiSkill->skillID)) $this->loadModel('ai')->deleteSkillByApi($apiSkill->skillID);
        $this->dao->rollBack();
        return false;
    }

    if(!$this->dao->commit())
    {
        if($apiSkill && !empty($apiSkill->skillID)) $this->loadModel('ai')->deleteSkillByApi($apiSkill->skillID);
        $this->dao->rollBack();
        return false;
    }

    return true;
}
