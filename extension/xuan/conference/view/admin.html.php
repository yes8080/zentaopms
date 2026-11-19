<?php

/**
 * The admin view file of conference module of XXB.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Wenrui LI <liwenrui@easycorp.ltd>
 * @package     conference
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php
include $app->getModuleRoot() . 'common/view/header.html.php';
?>
<div class='panel <?php echo $type == 'edit' ? 'edit-mode' : '';?>'>
  <div class="panel-heading">
    <?php echo $lang->conference->common; ?>
  </div>
  <?php if($type == 'edit'):?>
  <form method='post' id='ajaxForm' class="form-ajax conference-form<?php if ($enabled) echo ' conference-enabled'; ?>">
    <div class='panel-body'>
      <div class='form-horizontal-2col'>
        <div class='form-row'>
          <div class='form-group form-group-full'>
            <label><?php echo $lang->conference->enabled; ?></label>
            <div class='conference-field'>
              <?php echo html::radio('enabled', $lang->conference->enableOptions, $enabled ? 'true' : '', "class='checkbox'"); ?>
            </div>
          </div>
        </div>
        <div class='form-row edit-row'>
          <div class='form-group form-group-full'>
            <label><span class='field-required-mark'></span><?php echo $lang->conference->domain; ?></label>
            <div class='conference-field'>
              <?php echo html::input('domain', $domain, "class='form-control' placeholder='{$lang->conference->serverAddrTip}'"); ?>
            </div>
          </div>
        </div>
        <div class='form-row'>
          <div class='form-group form-actions'>
            <?php echo html::submitButton();?>
            <button type="button" class='btn btn-secondary btn-back' onclick="window.location.href='<?php echo $this->createLink('conference', 'admin');?>'"><?php echo $lang->goback;?></button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <?php else:?>
  <div class='read-view'>
    <div class='read-row'>
      <div class='read-label'><?php echo $lang->conference->enabled; ?></div>
      <div class='read-value'><?php echo $enabled ? $lang->on : $lang->off; ?></div>
    </div>
    <?php if($enabled): ?>
    <div class='read-row'>
      <div class='read-label'><?php echo $lang->conference->domain; ?></div>
      <div class='read-value'><?php echo empty($domain) ? $lang->conference->notset : $domain; ?></div>
    </div>
    <?php endif; ?>
    <div class='read-actions'>
      <?php echo html::linkButton('<i class="icon-edit"></i>  ' . $lang->editConfig, helper::createLink('conference', 'admin', 'type=edit'), 'btn btn-primary'); ?>
    </div>
  </div>
  <?php endif; ?>
</div>

<style>
  .edit-row {
    display: none;
  }

  #ajaxForm.conference-enabled .edit-row {
    display: flex;
  }
</style>

<script>
  $(function() {
    function updateDomainVisibility() {
      var isEnabled = $('input[name="enabled"]:checked').val() === 'true';
      $('#ajaxForm').toggleClass('conference-enabled', isEnabled);
      $('.edit-row').toggle(isEnabled);
    }
    
    $('input[name="enabled"]').on('change', updateDomainVisibility);
    // 初始化时设置一次，确保正确显示
    updateDomainVisibility();
  });
</script>
<?php include $app->getModuleRoot() . 'common/view/footer.html.php'; ?>
