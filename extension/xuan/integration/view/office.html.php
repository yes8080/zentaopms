<?php
/**
 * The office view file of integration module of XXB.
 *
 * @copyright   Copyright 2009-2023 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd., www.zentao.net)
 * @license     ZOSL (https://zpl.pub/page/zoslv1.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     integration
 * @version     $Id$
 * @link        https://xuanim.com
 */
?>
<?php include '../../common/view/header.html.php';?>
<div class='panel <?php echo $type == 'edit' ? 'edit-mode' : '';?>'>
  <div class='panel-heading'>
    <strong><?php echo $lang->integration->office;?></strong>
  </div>
  <?php if($type == 'edit'):?>
  <form method="post" id="office-ajax-form" class="form-ajax office-form">
    <div class='panel-body'>
      <div class='form-horizontal-2col'>
        <div class='form-row'>
          <div class='form-group form-group-full'>
            <label><?php echo $lang->integration->switch; ?></label>
            <div class='office-field'>
              <?php
              if($officeEnabled !== '0' && $officeEnabled !== '1') $officeEnabled = '0';
              echo html::radio('officeEnabled', $lang->integration->switchList, $officeEnabled);
              ?>
            </div>
          </div>
        </div>
        <div class='form-row edit-row'>
          <div class='form-group form-group-full'>
            <label><?php echo $lang->integration->type; ?></label>
            <div class='office-field'>
              <?php echo html::radio('officeType', array('collaboraOffice' => $lang->integration->collaboraOffice, 'onlyOffice' => $lang->integration->onlyOffice), isset($officeType) ? $officeType : 'collaboraOffice', "class='checkbox'"); ?>
            </div>
          </div>
        </div>
        <div class='form-row edit-row collaboraOffice-row'>
          <div class='form-group form-group-full'>
            <label><span class='field-required-mark'></span><?php echo $lang->integration->collaboraPath; ?></label>
            <div class='office-field'>
              <?php echo html::input('collaboraPath', isset($collaboraPath) ? $collaboraPath : '', "class='form-control' autocomplete='off' placeholder='{$lang->integration->placeholder->collaboraOffice}'"); ?>
            </div>
          </div>
        </div>
        <div class='form-row edit-row onlyOffice-row'>
          <div class='form-group form-group-full'>
            <label><span class='field-required-mark'></span><?php echo $lang->integration->onlyOfficePath; ?></label>
            <div class='office-field'>
              <?php echo html::input('onlyOfficePath', isset($onlyOfficePath) ? $onlyOfficePath : '', "class='form-control' autocomplete='off' placeholder='{$lang->integration->placeholder->onlyOffice}'"); ?>
            </div>
          </div>
        </div>
        <div class='form-row'>
          <div class='form-group form-actions'>
            <?php echo html::submitButton();?>
            <button type="button" class='btn btn-secondary btn-back' onclick="window.location.href='<?php echo $this->createLink('integration', 'office');?>'"><?php echo $lang->goback;?></button>
          </div>
        </div>
      </div>
    </div>
  </form>
  <?php else:?>
  <div class='read-view'>
    <div class='read-row'>
      <div class='read-label'><?php echo $lang->integration->switch; ?></div>
      <div class='read-value'><?php echo $officeEnabled == '1' ? $lang->on : $lang->off; ?></div>
    </div>
    <?php if($officeEnabled == '1'): ?>
    <div class='read-row'>
      <div class='read-label'><?php echo $lang->integration->type; ?></div>
      <div class='read-value'><?php echo (isset($officeType) && $officeType == 'onlyOffice') ? $lang->integration->onlyOffice : $lang->integration->collaboraOffice; ?></div>
    </div>
    <?php if(isset($officeType) && $officeType == 'onlyOffice'): ?>
    <div class='read-row'>
      <div class='read-label'><?php echo $lang->integration->onlyOfficePath; ?></div>
      <div class='read-value'><?php echo empty($onlyOfficePath) ? '-' : $onlyOfficePath; ?></div>
    </div>
    <?php else: ?>
    <div class='read-row'>
      <div class='read-label'><?php echo $lang->integration->collaboraPath; ?></div>
      <div class='read-value'><?php echo empty($collaboraPath) ? '-' : $collaboraPath; ?></div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
    <div class='read-actions'>
      <?php echo html::linkButton('<i class="icon-edit"></i>  ' . $lang->editConfig, helper::createLink('integration', 'office', 'type=edit'), 'btn btn-primary'); ?>
    </div>
  </div>
  <?php endif; ?>
</div>

<script>
$(function()
{
  $.setAjaxForm('#office-ajax-form');

  function updateOfficeFieldsVisibility() {
    var enabledValue = $('input[name="officeEnabled"]:checked').val();
    var isEnabled = enabledValue === '1' || enabledValue === 1;
    var officeType = $('input[name="officeType"]:checked').val() || 'collaboraOffice';

    // 根据启用状态显示/隐藏"类型"行
    if (isEnabled) {
      $('.type-row').show();
    } else {
      $('.type-row').hide();
    }

    // 根据启用状态和选择的类型显示/隐藏对应的地址输入框
    if (isEnabled) {
      if (officeType === 'onlyOffice') {
        $('.onlyOffice-row').show();
        $('.collaboraOffice-row').hide();
      } else {
        $('.collaboraOffice-row').show();
        $('.onlyOffice-row').hide();
      }
    } else {
      // 如果未启用，隐藏所有地址输入框
      $('.collaboraOffice-row').hide();
      $('.onlyOffice-row').hide();
    }
  }

  // 绑定事件监听器
  $('input[name="officeEnabled"]').on('change', updateOfficeFieldsVisibility);
  $('input[name="officeType"]').on('change', updateOfficeFieldsVisibility);

  // 页面加载时立即执行一次，确保初始状态正确
  updateOfficeFieldsVisibility();
});
</script>
<?php include '../../common/view/footer.html.php';?>
