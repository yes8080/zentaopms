<?php
/**
 * The create client view file of setting module of XXB.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Memory <lvtao@cnezsoft.com>
 * @package     client
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<?php $helpSVG = html::svgIcon('help', 12, 12);?>
<form id='ajaxForm' method='post' action='<?php echo inlink('create')?>' class='form-ajax client-edit-form'>
  <div class='form-body'>
    <div class='form-field form-field-required'>
      <label for='version'>
        <span class='field-required-mark'></span><?php echo $lang->client->version?>
      </label>
      <?php echo html::input('version', '', "id='version' class='form-control' autocomplete='off'")?>
    </div>

    <div class='form-field'>
      <label for='desc'><?php echo $lang->client->desc?></label>
      <?php echo html::input('desc', '', "id='desc' class='form-control' autocomplete='off'")?>
    </div>

    <div class='form-field'>
      <label for='changeLog'><?php echo $lang->client->changeLog?></label>
      <?php echo html::textarea('changeLog', '', "id='changeLog' class='form-control' rows='4'")?>
    </div>

    <div class='form-field'>
      <label><?php echo $lang->client->strategy?></label>
      <div class='radio-group'>
        <?php echo html::radio('strategy', $lang->client->strategies, 'optional')?>
      </div>
    </div>

    <div class='form-field form-field-downloads'>
      <label><?php echo $lang->client->links?></label>
      <div class='download-list'>
        <?php foreach($lang->client->zipList as $os => $name):?>
        <div class='download-item'>
          <label for='<?php echo $os;?>'><?php echo $name?></label>
          <?php echo html::input("downloads[{$os}]", '', "id='{$os}' class='form-control' autocomplete='off'")?>
        </div>
        <?php endforeach;?>
      </div>
    </div>

    <div class='form-field'>
      <label>
        <?php echo $lang->client->releaseStatus?>
        <span class='help-icon' title='<?php echo $lang->client->releaseTip;?>'>
          <?php echo $helpSVG;?>
        </span>
      </label>
      <div class='radio-group'>
        <?php echo html::radio('status', $lang->client->status, 'wait')?>
      </div>
    </div>
  </div>
  <div class='form-actions'>
    <?php echo html::submitButton();?>
  </div>
</form>
<?php include '../../common/view/footer.modal.html.php';?>
