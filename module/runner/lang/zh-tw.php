<?php
$lang->runner->manageRunner = 'Runner管理';
$lang->runner->browse       = 'Runner列表';
$lang->runner->create       = '添加Runner';
$lang->runner->createGuide  = '添加Runner引導頁';
$lang->runner->edit         = '編輯Runner';
$lang->runner->enable       = '啟用';
$lang->runner->disable      = '停用';
$lang->runner->delete       = '刪除Runner';
$lang->runner->changeState  = '啟用/停用Runner';

$lang->runner->name        = '名稱';
$lang->runner->status      = '狀態';
$lang->runner->platOrArch  = '平台/架構';
$lang->runner->plat        = '平台';
$lang->runner->arch        = '架構';
$lang->runner->version     = '版本';
$lang->runner->ip          = 'IP地址';
$lang->runner->package     = '安裝包';
$lang->runner->cmd         = '部署命令';
$lang->runner->copyCmd     = '複製命令';
$lang->runner->copySuccess = '複製成功';
$lang->runner->copyFail    = '瀏覽器不支持複製功能，請手動複製';
$lang->runner->desc        = '描述';
$lang->runner->labels      = '標籤';
$lang->runner->runtime     = '運行方式';

$lang->runner->statusList = array();
$lang->runner->statusList['online']  = '在綫';
$lang->runner->statusList['offline'] = '離線';
$lang->runner->statusList['suspend'] = '停用';

$lang->runner->osList = array();
$lang->runner->osList['linux']   = 'Linux';
$lang->runner->osList['windows'] = 'Windows';

$lang->runner->typeList = array();
$lang->runner->typeList['docker'] = 'Docker';
$lang->runner->typeList['k8s']    = 'Kubernetes';

$lang->runner->archList = array();
$lang->runner->archList['amd64'] = 'amd64';
$lang->runner->archList['arm64'] = 'arm64';

$lang->runner->cmdList = array();
$lang->runner->cmdList['windows'] = <<<EOF
# 注意：請以管理員身份運行 PowerShell，並先切換到目標安裝目錄再執行以下命令
# 1. 下載runner及依賴工具到指定的路徑
powershell -command "Invoke-WebRequest -Uri '%PACKAGE_URL%' -OutFile 'runner-plugin-installer.exe'"

# 2. 賦予執行權限後執行工具安裝
Unblock-File .\\runner-plugin-installer.exe; .\\runner-plugin-installer.exe install

# 3. 安裝服務
.\\install.bat %GITFOX_URL% %GITFOX_TOKEN% %RUNNER_RUNTIME% %RUNNER_LABELS%
EOF;
$lang->runner->cmdList['linux'] = <<<EOF
# 1. 下載runner及依賴工具到指定的路徑
sudo curl --output "runner-plugin-installer" "%PACKAGE_URL%"

# 2. 賦予執行權限後執行工具安裝
sudo chmod +x runner-plugin-installer && sudo ./runner-plugin-installer install

# 3. 安裝服務
sudo gitfox-runner install --url=%GITFOX_URL% --token=%GITFOX_TOKEN% --runtime=%RUNNER_RUNTIME% %RUNNER_LABELS%

# 4. 啟動服務
sudo gitfox-runner start
EOF;
$lang->runner->cmdList['docker'] = <<<'EOF'
docker run -d --name gitfox-runner --restart always
  -v /srv/gitfox-runner/config:/etc/gitfox-runner
  -v /var/run/docker.sock:/var/run/docker.sock
  gitfox/gitfox-runner:latest
EOF;
$lang->runner->cmdList['k8s'] = <<<EOF
# 1. 添加倉庫源
helm repo add gitfox https://hub.qucheng.com/chartrepo/stable

# 2. 安裝
helm install --namespace <NAMESPACE> --name gitfox-runner -f <CONFIG_VALUES_FILE> gitfox/gitfox-runner
EOF;

$lang->runner->notice = new stdclass();
$lang->runner->notice->confirmDelete    = '您確定要刪除該Runner嗎？';
$lang->runner->notice->confirmDisable   = '您確定要停用該Runner嗎？';
$lang->runner->notice->disableDelete    = '在線狀態的Runner不可刪除';
$lang->runner->notice->nameLength       = '名稱不能超過200個字元。';
$lang->runner->notice->descLength       = '描述不能超過500個字元。';
$lang->runner->notice->newLabelsInvalid = '只允許輸入英文、數字、下劃線、點、中橫線、中文';

$lang->runner->apiError = array();
