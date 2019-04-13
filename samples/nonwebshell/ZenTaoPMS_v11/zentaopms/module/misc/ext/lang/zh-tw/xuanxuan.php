<?php
$lang->misc->client = new stdclass();
$lang->misc->client->version     = '客戶端版本';
$lang->misc->client->os          = '操作系統';
$lang->misc->client->download    = '下載';
$lang->misc->client->downloading = '正在獲取安裝包:';
$lang->misc->client->downloaded  = '成功獲取安裝包';
$lang->misc->client->setting     = '正在設置配置信息';
$lang->misc->client->setted      = '成功設置配置信息';

$lang->misc->client->osList['win64']   = 'Windows 64位';
$lang->misc->client->osList['win32']   = 'Windows 32位';
$lang->misc->client->osList['linux64'] = 'Linux 64位';
$lang->misc->client->osList['linux32'] = 'Linux 32位';
$lang->misc->client->osList['mac']     = 'Mac版';

$lang->misc->client->errorInfo = new stdclass();
$lang->misc->client->errorInfo->downloadError  = '獲取安裝包失敗';
$lang->misc->client->errorInfo->configError    = '配置用戶信息失敗';
$lang->misc->client->errorInfo->manualOpt      = '請從 %s 手動獲取安裝包。';
$lang->misc->client->errorInfo->dirNotExist    = '客戶端下載存儲路徑 <span class="code text-red">%s</span> 不存在，請創建該目錄。';
$lang->misc->client->errorInfo->dirNotWritable = '客戶端下載存儲路徑 <span class="code text-red">%s</span> 不可寫 <br />linux下面請執行命令：<span class="code text-red">sudo chmod 777 %s</span>來修正';

