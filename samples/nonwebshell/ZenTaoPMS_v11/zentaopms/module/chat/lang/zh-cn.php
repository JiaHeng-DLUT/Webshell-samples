<?php
$lang->chat->settings = '喧喧设置';
$lang->chat->debug    = '调试功能';

$lang->chat->version     = '版本';
$lang->chat->xxbLang     = '服务器端语言';
$lang->chat->key         = '密钥';
$lang->chat->systemGroup = '系统';
$lang->chat->url         = '访问地址';
$lang->chat->createKey   = '重新生成密钥';
$lang->chat->connector   = '、';
$lang->chat->viewDebug   = '查看调试信息';
$lang->chat->log         = '日志';

$lang->chat->debugStatus[1] = '启用';
$lang->chat->debugStatus[0] = '不启用';

$lang->chat->xxdServer       = '喧喧服务器';
$lang->chat->createKey       = '重新生成密钥';
$lang->chat->downloadXXD     = '下载XXD服务端';
$lang->chat->listenIP        = '监听IP';
$lang->chat->chatPort        = '客户端通讯端口';
$lang->chat->uploadFileSize  = '上传文件大小';
$lang->chat->downloadPackage = '下载完整包';
$lang->chat->downloadConfig  = '只下载配置文件';
$lang->chat->changeSetting   = '修改配置';

$lang->chat->notAdmin         = '不是系统管理员。';
$lang->chat->notSystemChat    = '不是系统会话。';
$lang->chat->notGroupChat     = '不是多人会话。';
$lang->chat->notPublic        = '不是公开会话。';
$lang->chat->cantChat         = '没有发言权限。';
$lang->chat->chatHasDismissed = '讨论组已被解散';
$lang->chat->needLogin        = '用户没有登录。';
$lang->chat->notExist         = '会话不存在。';
$lang->chat->changeRenameTo   = '将会话名称更改为';
$lang->chat->multiChats       = '消息不属于同一个会话。';
$lang->chat->notInGroup       = '用户不在此讨论组内。';
$lang->chat->errorKey         = '<strong>密钥</strong> 应该为数字或字母的组合，长度为32位。';
$lang->chat->defaultKey       = '请勿使用默认<strong>密钥</strong>。';
$lang->chat->debugTips        = '喧喧已经可以使用。<br>使用管理员账号%s并访问此页面，可以查看更多debug信息。';
$lang->chat->noLogFile        = '没有日志文件。';
$lang->chat->noFopen          = '未启用fopen函数，请按以下路径自行查看日志文件：%s。';

$lang->chat->xxdServerTip   = 'XXD服务器地址为完整的协议+地址+端口，示例：http://192.168.1.35 或 http://www.backend.com ，不能使用127.0.0.1。';
$lang->chat->xxdServerEmpty = 'XXD服务器地址为空。';
$lang->chat->xxdServerError = 'XXD服务器地址不能为 127.0.0.1。';
$lang->chat->xxdSchemeError = '服务器地址应该以<strong>http://</strong>或<strong>https://</strong>开头。';
$lang->chat->xxdPortError   = '服务器地址应该包含有效的端口号，默认为<strong>11443</strong>。';

$lang->chat->broadcast = new stdclass();
$lang->chat->broadcast->createChat  = '@%s 创建了讨论组 **[%s](#/chats/groups/%s)**。';
$lang->chat->broadcast->joinChat    = '@%s 加入了讨论组。';
$lang->chat->broadcast->quitChat    = '@%s 退出了当前讨论组。';
$lang->chat->broadcast->renameChat  = '@%s 将讨论组名称更改为 **[%s](#/chats/groups/%s)**。';
$lang->chat->broadcast->inviteUser  = '@%s 邀请 %s 加入了讨论组。';
$lang->chat->broadcast->dismissChat = '@%s 解散了当前讨论组。';

$lang->chat->xxd = new stdclass();
$lang->chat->xxd->os             = '操作系统';
$lang->chat->xxd->ip             = '监听IP';
$lang->chat->xxd->chatPort       = '客户端通讯端口';
$lang->chat->xxd->commonPort     = '通用端口';
$lang->chat->xxd->isHttps        = '启用https';
$lang->chat->xxd->uploadFileSize = '上传文件大小';
$lang->chat->xxd->maxOnlineUser  = '最大在线人数';
$lang->chat->xxd->sslcrt         = '证书内容';
$lang->chat->xxd->sslkey         = '证书私钥';
$lang->chat->xxd->max            = '最大';

$lang->chat->httpsOptions['on']  = '启用';
$lang->chat->httpsOptions['off'] = '不启用';

$lang->chat->placeholder = new stdclass();
$lang->chat->placeholder->xxd = new stdclass();
$lang->chat->placeholder->xxd->ip             = '监听的服务器ip地址，没有特殊需要直接填写0.0.0.0';
$lang->chat->placeholder->xxd->chatPort       = '与聊天客户端通讯的端口';
$lang->chat->placeholder->xxd->commonPort     = '通用端口，该端口用于客户端登录时验证，以及文件上传下载使用';
$lang->chat->placeholder->xxd->isHttps        = '启用https';
$lang->chat->placeholder->xxd->uploadFileSize = '上传文件的大小';
$lang->chat->placeholder->xxd->maxOnlineUser  = '最大在线人数';
$lang->chat->placeholder->xxd->sslcrt         = '请将证书内容复制到此处';
$lang->chat->placeholder->xxd->sslkey         = '请将证书密钥复制到此处';

$lang->chat->notify = new stdclass();
$lang->chat->notify->setReceiver = '没有设置接收者类型，只能是用户或者是某个讨论组。';
$lang->chat->notify->setGroup    = '应当设置接收讨论组。';
$lang->chat->notify->setUserList = '应当设置接收者用户列表。';
$lang->chat->notify->setSender   = '应当设置发送方信息。';

$lang->chat->osList['win_i386']      = 'Windows 32位';
$lang->chat->osList['win_x86_64']    = 'Windows 64位';
$lang->chat->osList['linux_i386']    = 'Linux 32位';
$lang->chat->osList['linux_x86_64']  = 'Linux 64位';
$lang->chat->osList['darwin_x86_64'] = 'macOS';
