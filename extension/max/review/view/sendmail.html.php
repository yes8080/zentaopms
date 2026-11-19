<?php
/**
 * The mail file of review module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 禅道软件（青岛）有限公司(ZenTao Software (Qingdao) Co., Ltd. www.cnezsoft.com)
 * @license     ZPL(http://zpl.pub/page/zplv12.html) or AGPL(https://www.gnu.org/licenses/agpl-3.0.en.html)
 * @author      Jia Fu <fujia@cnezsoft.com>
 * @package     review
 * @version     $Id: sendmail.html.php 867 2010-06-17 09:32:58Z yuren_@126.com $
 * @link        https://www.zentao.net
 */
?>
<?php
$this->app->loadLang('review');
$mailTitle = 'Review #' . $object->id . ' ' . zget($object, 'title', '');

/* 评审操作把意见写在动态 comment 里，邮件页脚会标成「备注」，这里改成评审意见展示。 */
/* During the review process, opinions are recorded in comments. The email footer should be updated to display the actual review opinions.*/
$reviewOpinion  = zget($object, 'opinion', '');
$isAssessAction = isset($action->action) && ($action->action == 'approvalreview' || $action->action == 'reviewed');
if($isAssessAction && !empty($action->comment))
{
    if($reviewOpinion === '') $reviewOpinion = $action->comment;
    $action->comment = '';
}
?>
<?php include $this->app->getModuleRoot() . 'common/view/mail.header.html.php';?>
<tr>
  <td>
    <table cellpadding='0' cellspacing='0' width='600' style='border: none; border-collapse: collapse;'>
      <tr>
        <td style='padding: 10px; background-color: #F8FAFE; border: none; font-size: 14px; font-weight: 500; border-bottom: 1px solid #e5e5e5;'>
          <?php echo html::a($domain . helper::createLink('review', 'view', "reviewID=$object->id", 'html'), $mailTitle, '', "style='color: #333; text-decoration: underline;'");?>
        </td>
      </tr>
    </table>
  </td>
</tr>
<tr>
  <td style='padding: 10px; border: none;'>
    <fieldset style='border: 1px solid #e5e5e5'>
      <legend style='color: #114f8e'><?php echo $this->lang->review->object;?></legend>
      <div style='padding:5px;'>
        <?php
        $category = zget($object, 'category', '');
        if($category !== '' && isset($this->lang->baseline->objectList))
        {
            echo zget($this->lang->baseline->objectList, $category, zget($object, 'title', $category));
        }
        else
        {
            echo zget($object, 'title', $category);
        }
        ?>
      </div>
    </fieldset>
  </td>
</tr>
<?php if(!empty($reviewOpinion)):?>
<tr>
  <td style='padding: 10px; border: none;'>
    <fieldset style='border: 1px solid #e5e5e5'>
      <legend style='color: #114f8e'><?php echo $this->lang->review->finalOpinion;?></legend>
      <div style='padding:5px;'><?php echo $reviewOpinion;?></div>
    </fieldset>
  </td>
</tr>
<?php endif;?>
<?php include $this->app->getModuleRoot() . 'common/view/mail.footer.html.php';?>
