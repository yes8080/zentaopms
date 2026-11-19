<?php
$lang->deliverable->name            = '交付物類型';
$lang->deliverable->title           = '交付物名稱';
$lang->deliverable->version         = '版本號';
$lang->deliverable->versionStatus   = '版本狀態';
$lang->deliverable->module          = '所屬分類';
$lang->deliverable->desc            = '描述';
$lang->deliverable->createdByAB     = '創建者';
$lang->deliverable->createdBy       = '由誰創建';
$lang->deliverable->createdDate     = '創建日期';
$lang->deliverable->lastEditedBy    = '最後修改';
$lang->deliverable->lastEditedDate  = '最後修改日期';
$lang->deliverable->template        = '引用模板';
$lang->deliverable->files           = '上傳模板';
$lang->deliverable->activity        = '所屬活動';
$lang->deliverable->addActivity     = '添加活動';
$lang->deliverable->trimmable       = '是否可裁剪';
$lang->deliverable->trimRule        = '裁剪準則';
$lang->deliverable->when            = '檢查環節';
$lang->deliverable->batchCheck      = '設置檢查環節';
$lang->deliverable->required        = '是否必須提交';
$lang->deliverable->or              = '或';
$lang->deliverable->basicInfo       = '基本信息';
$lang->deliverable->selectDoc       = '請選擇文檔模板';
$lang->deliverable->whenClose       = '關閉時';
$lang->deliverable->moduleSetting   = '分類設置';
$lang->deliverable->status          = '狀態';
$lang->deliverable->reviewStatus    = '評審狀態';
$lang->deliverable->toEdit          = '去關聯';
$lang->deliverable->isBaseline      = '是否為基線';
$lang->deliverable->submitedBy      = '由誰提交';
$lang->deliverable->baseline        = '所屬基線';
$lang->deliverable->baselineVersion = '基線版本號';
$lang->deliverable->allStage        = '所有環節關閉時';

$lang->deliverable->createByTemplate   = '從模板創建';
$lang->deliverable->selectDocInProject = '請選擇項目中已發佈且你可查看的文檔。';

$lang->deliverable->browse  = '瀏覽交付物類型列表';
$lang->deliverable->create  = '新建交付物類型';
$lang->deliverable->edit    = '編輯交付物類型';
$lang->deliverable->delete  = '刪除交付物類型';
$lang->deliverable->enable  = '啟用交付物類型';
$lang->deliverable->disable = '停用交付物類型';
$lang->deliverable->view    = '查看交付物類型詳情';

$lang->deliverable->createAbbr       = '新建';
$lang->deliverable->createTitle      = '新建交付物類型';
$lang->deliverable->editTitle        = '編輯交付物類型';
$lang->deliverable->batchCreate      = '批量新建';
$lang->deliverable->batchCreateTitle = '批量新建交付物類型';
$lang->deliverable->batchEdit        = '批量編輯';
$lang->deliverable->batchEditTitle   = '批量編輯交付物類型';
$lang->deliverable->batchDelete      = '批量刪除交付物類型';
$lang->deliverable->batchEnable      = '批量啟用交付物類型';
$lang->deliverable->batchDisable     = '批量停用交付物類型';
$lang->deliverable->enableTip        = '啟用';
$lang->deliverable->disableTip       = '停用';

$lang->deliverable->moduleLang = new stdclass();
$lang->deliverable->moduleLang->common         = '分類維護';
$lang->deliverable->moduleLang->manage         = '分類維護';
$lang->deliverable->moduleLang->module         = '分類';
$lang->deliverable->moduleLang->name           = '分類名稱';
$lang->deliverable->moduleLang->create         = '創建分類';
$lang->deliverable->moduleLang->edit           = '編輯分類';
$lang->deliverable->moduleLang->repeatName     = '分類名“ %s” 已經存在！';
$lang->deliverable->moduleLang->confirmDelete  = '您確定要刪除該分類嗎？';
$lang->deliverable->moduleLang->shouldNotBlank = '分類名不能為空格！';

$lang->deliverable->abbr = new stdclass();
$lang->deliverable->abbr->template = '模板';

$lang->deliverable->trimmableList['0']  = '不可裁剪';
$lang->deliverable->trimmableList['1']  = '可裁剪';

$lang->deliverable->requiredList['0'] = '選擇提交';
$lang->deliverable->requiredList['1'] = '必須提交';
$lang->deliverable->requiredList['2'] = '必須提交且評審通過';

$lang->deliverable->statusList['enabled']  = '啟用';
$lang->deliverable->statusList['disabled'] = '停用';

$lang->deliverable->versionStatusList['latest']  = '最新';
$lang->deliverable->versionStatusList['updated'] = '有更新';

$lang->deliverable->baselineList['0'] = '否';
$lang->deliverable->baselineList['1'] = '是';

$lang->deliverable->confirmDelete     = '將同步刪除交付物評審流程及檢查清單，是否繼續？';
$lang->deliverable->summary           = '本頁共有%s個交付物';
$lang->deliverable->exceededCountTip  = '每個交付物只能上傳一個檔案';
$lang->deliverable->deleteTip         = '只能刪除部分交付物類型。以下內置的交付物類型，無法刪除：%s';
$lang->deliverable->confirmEnableTip  = '您確定要執行啟用操作嗎？';
$lang->deliverable->notSetActivityTip = '只能啟用部分交付物類型。以下交付物類型未設置“所屬分類”或“所屬活動”或“檢查環節”，無法啟用：%s';
$lang->deliverable->confirmDisable    = '您確定要執行停用操作嗎？';

$lang->deliverable->featureBar['browse']['all'] = '全部';

$lang->deliverable->addedDoc    = '新增交付物文檔：%s';
$lang->deliverable->deletedDoc  = '刪除交付物文檔：%s';
$lang->deliverable->addedFile   = '新增交付物附件：%s';
$lang->deliverable->deletedFile = '刪除交付物附件：%s';
$lang->deliverable->renamedFile = '重命名交付物附件：%s -> %s';
$lang->deliverable->renamedDoc  = '重命名交付物文檔：%s -> %s';

$lang->deliverable->stageMustBeSelected  = '請至少選擇一個交付物的檢查環節！';
$lang->deliverable->deleteModuleConfirm  = '無法刪除包含交付物類型的分類。';
$lang->deliverable->confirmEnable        = '該交付物未設置“所屬分類”或“所屬活動”或“檢查環節”，請設置後再啟用。';
$lang->deliverable->builtinConfirm       = '內置交付物禁止修改';
$lang->deliverable->batchCheckBuiltinTip = '內置交付物類型會自動提交，不支持設置“任務關閉時檢查”。';
$lang->deliverable->otherBatchTip        = '“其他”類型交付物不支持批量操作。';
$lang->deliverable->trimableNotice       = '交付物類型的“可裁剪”屬性受所屬活動的裁剪屬性約束';
$lang->deliverable->whenNotice           = "1.後台為交付物類型勾選某一關閉檢查層級後，前台在該層級關閉時觸發交付物校驗；未勾選的層級不觸發校驗。
2.當前層級關閉時，校驗當前層級已提交的交付物是否滿足該層級配置的檢查條件；不滿足時提示，並阻止關閉。
3.同一交付物類型配置多個檢查層級時，上級關閉除校驗當前層級交付物外，還需歸集對應下級已提交的交付物，並統一按上級檢查條件校驗。
4.下級已提交交付物時，允許在上級繼續提交同類型交付物；新增交付物按上級檢查條件校驗。
5.下級未提交交付物時，上級提供同類型交付物的補交入口；如上級檢查條件要求提交，則補交並滿足條件後方可關閉。
6.上級歸集的下級交付物或在上級補充提交的交付物不滿足上級檢查條件時，均不得關閉上級。";

$lang->deliverable->buildinModule['plan']   = '計劃類';
$lang->deliverable->buildinModule['story']  = '需求類';
$lang->deliverable->buildinModule['design'] = '設計類';
$lang->deliverable->buildinModule['test']   = '測試類';
$lang->deliverable->buildinModule['other']  = '其他類';

$lang->deliverable->action = new stdclass();
$lang->deliverable->action->enabled  = array('main' => '$date, 由 <strong>$actor</strong> 啟用。');
$lang->deliverable->action->disabled = array('main' => '$date, 由 <strong>$actor</strong> 停用。');

$lang->deliverable->taskCloseCheck      = '任務關閉時檢查';
$lang->deliverable->executionCloseCheck = '執行關閉時檢查';
$lang->deliverable->projectCloseCheck   = '項目關閉時檢查';
$lang->deliverable->source              = '來源';
$lang->deliverable->taskType            = '任務類型';
$lang->deliverable->placeholderTaskType = '請選擇任務類型';
$lang->deliverable->placeholderStage    = '請選擇階段';
