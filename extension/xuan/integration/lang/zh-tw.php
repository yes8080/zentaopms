<?php
$lang->integration->common     = '整合';
$lang->integration->switch     = 'Office整合功能';
$lang->integration->switchList = array('不啟用', '啟用');

$lang->integration->type = '類型';

$lang->integration->office        = 'Office 整合';
$lang->integration->collaboraOffice     = 'Collabora Online';
$lang->integration->collaboraPath = 'Collabora 地址';
$lang->integration->onlyOffice    = 'Only Office';
$lang->integration->onlyOfficePath = 'Only Office 地址';

$lang->integration->error = new stdclass();
$lang->integration->error->cannotConnectToCollabora = '無法連接到 Collabora Online，請檢查 Collabora Online 是否正確配置，或者網絡是否暢通。';
$lang->integration->error->cannotConnectToOnlyOffice = '無法連接到 Only Office，請檢查 Only Office 是否正確配置，或者網絡是否暢通。';
$lang->integration->error->collaboraPathRequired = '啟用 Collabora Online 時，Collabora 地址不能為空。';
$lang->integration->error->onlyOfficePathRequired = '啟用 Only Office 時，Only Office 地址不能為空。';
$lang->integration->error->officeNotEnabled         = '服務端尚未開啟 Office 整合。';
$lang->integration->error->userNotFoundForRequest   = '無法找到該請求對應的用戶。';
$lang->integration->error->fileNotFoundForRequest   = '無法找到該請求對應的檔案。';
$lang->integration->error->filePreviewNotSupported  = '不支持預覽該檔案。';
$lang->integration->error->buildIdentifierFail      = '參數有誤，無法預覽。';

$lang->integration->placeholder = new stdclass();
$lang->integration->placeholder->collaboraOffice = '填寫 Collabora Online 的 URL，如 https://192.168.1.2:9980';
$lang->integration->placeholder->onlyOffice = '填寫 Only Office 的 URL，如 https://192.168.1.2';
