<?php
$lang->message->common     = '系統通知';
$lang->message->index      = '首頁';
$lang->message->setting    = '設置';
$lang->message->browser    = '系統通知';
$lang->message->blockUser  = '不通知人員';
$lang->message->markUnread = '標為未讀';

$lang->message->typeList['mail']     = '郵件';
$lang->message->typeList['message']  = '系統通知';
$lang->message->typeList['webhook']  = 'Webhook';

$lang->message->browserSetting = new stdclass();
$lang->message->browserSetting->turnon   = '是否打開';
$lang->message->browserSetting->pollTime = '輪詢時間';

$lang->message->browserSetting->pollTimeTip         = '輪詢時間不能小於30秒。';
$lang->message->browserSetting->pollTimePlaceholder = '通知的時間間隔，以秒為單位。';

$lang->message->browserSetting->turnonList[1] = '打開';
$lang->message->browserSetting->turnonList[0] = '關閉';

$lang->message->browserSetting->more    = '更多設置';
$lang->message->browserSetting->show    = '瀏覽器通知';
$lang->message->browserSetting->count   = '計數提醒';
$lang->message->browserSetting->maxDays = '保留天數';

$lang->message->unread = '未讀消息(%s)';
$lang->message->all    = '全部消息';

$lang->message->timeLabel['minute'] = '%s分鐘前';
$lang->message->timeLabel['hour']   = '1小時前';

$lang->message->mention = '%s在%s《%s》中@了你，請及時查看。';

$lang->message->noticeText = new stdclass();
$lang->message->noticeText->opened         = '{actor} 創建了新的{objectType}《{objectTitle}》。';
$lang->message->noticeText->created        = $lang->message->noticeText->opened;
$lang->message->noticeText->added          = $lang->message->noticeText->opened;
$lang->message->noticeText->edited         = '{actor} 編輯了{objectType}《{objectTitle}》的內容。';
$lang->message->noticeText->commented      = '{actor} 在{objectType}《{objectTitle}》下添加了新的備註。';
$lang->message->noticeText->changed        = '{actor} 變更了{objectType}《{objectTitle}》的內容。';
$lang->message->noticeText->submitreview   = '{actor} 提交了{objectType}《{objectTitle}》的評審，請您及時審批。';
$lang->message->noticeText->reviewed       = '您提交的{objectType}《{objectTitle}》已由 {actor} 處理，結果為：{reviewResult}。{reviewComment}';
$lang->message->noticeText->otherreviewed  = '您提交的{objectType}《{objectTitle}》已由 {actor} 處理，結果為：{reviewResult}。';
$lang->message->noticeText->reverted       = '{actor} 將{objectType}《{objectTitle}》回退，請您修改後重新提交。';
$lang->message->noticeText->forwarded      = '{actor} 將{objectType}《{objectTitle}》轉交給了您，請及時處理。';
$lang->message->noticeText->assigned       = '{actor} 將{objectType}《{objectTitle}》指派給了您，請及時處理。';
$lang->message->noticeText->mentioned      = '{actor} 在{objectType}《{objectTitle}》中提到了您，請及時查看。';
$lang->message->noticeText->converttotask  = '{actor} 將{objectType}《{objectTitle}》轉為任務。';
$lang->message->noticeText->totask         = $lang->message->noticeText->converttotask;
$lang->message->noticeText->tobug          = '{actor} 將{objectType}《{objectTitle}》轉為Bug。';
$lang->message->noticeText->frombug        = "{actor} 將Bug轉為{$lang->SRCommon}《{objectTitle}》。";
$lang->message->noticeText->tostory        = "{actor} 將{objectType}《{objectTitle}》轉為{$lang->SRCommon}。";
$lang->message->noticeText->touserstory    = "{actor} 將{objectType}《{objectTitle}》轉為{$lang->URCommon}。";
$lang->message->noticeText->toepic         = "{actor} 將{objectType}《{objectTitle}》轉為{$lang->ERCommon}。";
$lang->message->noticeText->totodo         = '{actor} 將{objectType}《{objectTitle}》轉為待辦。';
$lang->message->noticeText->toticket       = '{actor} 將{objectType}《{objectTitle}》轉為工單。';
$lang->message->noticeText->todemand       = '{actor} 將{objectType}《{objectTitle}》轉為需求池需求。';
$lang->message->noticeText->confirmed      = "{actor}確認了{objectType}《{objectTitle}》的{$lang->SRCommon}變更。";
$lang->message->noticeText->aitaskfinished = '您的數字員工任務《{objectTitle}》已完成。';
$lang->message->noticeText->aitaskfailed   = '您的數字員工任務《{objectTitle}》執行失敗。';
$lang->message->noticeText->minuted        = '{actor}記錄了會議紀要《{objectTitle}》。';
$lang->message->noticeText->generic        = '{actor} {action}{objectType}《{objectTitle}》。';
$lang->message->noticeText->moved          = '{actor} 將看板卡片《{objectTitle}》，';
$lang->message->noticeText->skipColSuffix  = '從 {fromColTitle} 列移動到 {toColTitle} 列。';
$lang->message->noticeText->skipLaneSuffix = '從 {fromLaneTitle}泳道的 {fromColTitle} 列移動到 {toLaneTitle}泳道的 {toColTitle} 列。';
$lang->message->noticeText->ccSuffix       = '您已被抄送。';

$lang->message->noticeText->extend['submitreview']['cc']     = '{actor} 提交了{objectType}《{objectTitle}》的評審，您已被抄送。';
$lang->message->noticeText->extend['submitreview']['other']  = '{actor} 提交了{objectType}《{objectTitle}》的評審。';
$lang->message->noticeText->extend['reviewed']['cc']         = '{submitter} 提交的{objectType}《{objectTitle}》已由 {actor} 處理，結果為：{reviewResult}。{reviewComment}您已被抄送。';
$lang->message->noticeText->extend['reviewed']['other']      = '{submitter} 提交的{objectType}《{objectTitle}》已由 {actor} 處理，結果為：{reviewResult}。{reviewComment}';
$lang->message->noticeText->extend['otherreviewed']['cc']    = '{submitter} 提交的{objectType}《{objectTitle}》已由 {actor} 處理，結果為：{reviewResult}。您已被抄送。';
$lang->message->noticeText->extend['otherreviewed']['other'] = '{submitter} 提交的{objectType}《{objectTitle}》已由 {actor} 處理，結果為：{reviewResult}。';
$lang->message->noticeText->extend['reverted']['cc']         = '{actor} 將{objectType}《{objectTitle}》回退，您已被抄送。';
$lang->message->noticeText->extend['forwarded']['cc']        = '{actor} 將{objectType}《{objectTitle}》轉交給 {assignedTo} 處理，您已被抄送。';
$lang->message->noticeText->extend['assigned']['cc']         = '{actor} 將{objectType}《{objectTitle}》指派給了{assignedTo}，您已被抄送。';
$lang->message->noticeText->extend['assigned']['other']      = '{actor} 將{objectType}《{objectTitle}》指派給了{assignedTo}。';

$lang->message->noticeTitle = new stdclass();
$lang->message->noticeTitle->opened         = '新的{objectType}已創建';
$lang->message->noticeTitle->created        = $lang->message->noticeTitle->opened;
$lang->message->noticeTitle->added          = $lang->message->noticeTitle->opened;
$lang->message->noticeTitle->edited         = '{objectType}信息已更新';
$lang->message->noticeTitle->commented      = '{objectType}有新備註';
$lang->message->noticeTitle->changed        = '{objectType}發生變更';
$lang->message->noticeTitle->submitreview   = '{objectType}提交評審';
$lang->message->noticeTitle->reviewed       = '{objectType}評審結果通知';
$lang->message->noticeTitle->reverted       = '項目評審已回退';
$lang->message->noticeTitle->forwarded      = '項目評審已轉交';
$lang->message->noticeTitle->assigned       = '您被指派處理{objectType}';
$lang->message->noticeTitle->mentioned      = '有人在{objectType}中提到了您';
$lang->message->noticeTitle->converttotask  = '{objectType}已轉為任務';
$lang->message->noticeTitle->totask         = $lang->message->noticeTitle->converttotask;
$lang->message->noticeTitle->tobug          = '{objectType}已轉為Bug';
$lang->message->noticeTitle->frombug        = "Bug已轉為{$lang->SRCommon}";
$lang->message->noticeTitle->tostory        = "{objectType}已轉為{$lang->SRCommon}";
$lang->message->noticeTitle->touserstory    = "{objectType}已轉為{$lang->URCommon}";
$lang->message->noticeTitle->toepic         = "{objectType}已轉為{$lang->ERCommon}";
$lang->message->noticeTitle->totodo         = '{objectType}已轉為待辦';
$lang->message->noticeTitle->toticket       = '{objectType}已轉為工單';
$lang->message->noticeTitle->todemand       = '{objectType}已轉為需求池需求';
$lang->message->noticeTitle->confirmed      = "{$lang->SRCommon}變更已確認";
$lang->message->noticeTitle->aitaskfinished = '數字員工任務完成';
$lang->message->noticeTitle->aitaskfailed   = '數字員工任務執行失敗';
$lang->message->noticeTitle->generic        = '{objectType}已{action}';
$lang->message->noticeTitle->minuted        = $lang->message->noticeTitle->generic;

$lang->message->noticeTitle->extend['assigned']['cc']    = '{assignedTo}被指派處理{objectType}';
$lang->message->noticeTitle->extend['assigned']['other'] = $lang->message->noticeTitle->extend['assigned']['cc'];

$lang->message->reviewResultList['pass']    = '通過';
$lang->message->reviewResultList['reject']  = '不通過';
$lang->message->reviewResultList['revert']  = '撤銷';
$lang->message->reviewResultList['clarify'] = '有待明確';

$lang->message->reviewCommentTemplate = '審批意見：%s。';

$lang->message->notice = new stdclass();
$lang->message->notice->allMarkRead = '一鍵已讀';
$lang->message->notice->clearRead   = '清空已讀';

$lang->message->error = new stdclass();
$lang->message->error->maxDaysFormat  = '保留天數只能填寫正整數';
$lang->message->error->maxDaysValue   = '保留天數不能小於0。';

$lang->message->label = new stdclass();
$lang->message->label->created      = '創建';
$lang->message->label->opened       = '創建';
$lang->message->label->changed      = '變更';
$lang->message->label->releaseddoc  = '發佈';
$lang->message->label->edited       = '編輯';
$lang->message->label->assigned     = '指派';
$lang->message->label->closed       = '關閉';
$lang->message->label->deleted      = '刪除';
$lang->message->label->undeleted    = '還原';
$lang->message->label->commented    = '備註';
$lang->message->label->activated    = '激活';
$lang->message->label->resolved     = '解決';
$lang->message->label->submitreview = '提交評審';
$lang->message->label->reviewed     = '評審';
$lang->message->label->confirmed    = "確認{$lang->SRCommon}";
$lang->message->label->frombug      = "轉{$lang->SRCommon}";
$lang->message->label->started      = '開始';
$lang->message->label->delayed      = '延期';
$lang->message->label->suspended    = '掛起';
$lang->message->label->finished     = '完成';
$lang->message->label->paused       = '暫停';
$lang->message->label->canceled     = '取消';
$lang->message->label->restarted    = '繼續';
$lang->message->label->blocked      = '阻塞';
$lang->message->label->bugconfirmed = '確認';
$lang->message->label->compilepass  = '構建通過';
$lang->message->label->compilefail  = '構建失敗';
$lang->message->label->archived     = '歸檔';
$lang->message->label->restore      = '還原';
$lang->message->label->moved        = '移動';
$lang->message->label->nearing      = '到期提醒';
$lang->message->label->published    = '發佈';
$lang->message->label->changestatus = '修改發佈狀態';
$lang->message->label->mentioned    = '@通知';
