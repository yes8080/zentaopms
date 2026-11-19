<?php
/**
 * 智能体下架的二次确认改为由服务端动态判断。
 * The confirmation of unpublishing a prompt is decided by the server dynamically.
 *
 * 只有「有已上架工序使用了该智能体」时才需要确认，且提示文案里要带上工序名称，
 * 静态的 data-confirm 无法满足，因此去掉它，改由 promptUnpublish 返回 callback 弹窗。
 */
unset($config->ai->actionList['promptunpublish']['data-confirm']);
