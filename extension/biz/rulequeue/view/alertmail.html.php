<?php
/**
 * The alert mail template of rulequeue module.
 *
 * @copyright   Copyright 2009-2025 禅道软件（青岛）集团有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Sunguangming<sunguangming@chandao.com>
 * @package     biz
 * @link        https://www.zentao.net
 */
?>
<?php include $this->app->getModuleRoot() . 'common/view/mail.header.html.php';?>
<tr>
  <td>
    <table cellpadding='0' cellspacing='0' style='width: 100%; border: none; border-collapse: collapse;'>
      <tr>
        <td style='padding: 10px; background-color: #F8FAFE; border: none; font-size: 14px; font-weight: 500; border-bottom: 1px solid #e5e5e5;'><?php echo date('Y-m-d');?></td>
        <td style='width: 40px; text-align: right; background-color: #F8FAFE; border: none; vertical-align: top; padding: 10px; border-bottom: 1px solid #e5e5e5;'><?php if(!empty($url)) echo html::a(rtrim($url, '/') . $this->config->webRoot, rtrim($url, '/') . $this->config->webRoot, '', 'target="_blank"');?></td>
      </tr>
    </table>
  </td>
</tr>

<?php foreach($sections as $section):?>
<tr>
  <td style='padding: 10px; border: none;'>
    <h5 style='margin: 8px 0; font-size: 14px;'><?php echo $section->subtitle;?></h5>
    <table cellpadding='0' cellspacing='0' style='width: 100%; border: 1px solid #e5e5e5; margin-bottom: 15px; border-collapse: collapse; font-size: 13px;'>
      <tr>
        <th style='width: 50px; border: 1px solid #e5e5e5; background-color: #f5f5f5; padding: 5px;'><?php echo $this->lang->rulequeue->alert->idAB;?></th>
        <th style='border: 1px solid #e5e5e5; background-color: #f5f5f5; padding: 5px;'><?php echo $section->titleLabel;?></th>
        <th style='width: 120px; border: 1px solid #e5e5e5; background-color: #f5f5f5; padding: 5px;'><?php echo $section->columnLabel;?></th>
      </tr>
      <?php foreach($section->rows as $row):?>
      <tr>
        <td style='padding: 5px; text-align: center; border: 1px solid #e5e5e5;'><?php echo $row->id;?></td>
        <td style='padding: 5px; border: 1px solid #e5e5e5;'>
          <?php
          if(!empty($row->link))
          {
              echo html::a($row->link, $row->title, '', 'target="_blank"');
          }
          else
          {
              echo $row->title;
          }
          ?>
        </td>
        <td style='padding: 5px; text-align: center; border: 1px solid #e5e5e5;'><?php echo $row->value;?></td>
      </tr>
      <?php endforeach;?>
    </table>
  </td>
</tr>
<?php endforeach;?>

<?php include $this->app->getModuleRoot() . 'common/view/mail.footer.html.php';?>
