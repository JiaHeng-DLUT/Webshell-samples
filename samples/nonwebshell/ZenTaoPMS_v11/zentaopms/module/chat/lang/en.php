<?php
$lang->chat->settings = 'Xuanxuan Settings';
$lang->chat->debug    = 'Debug';

$lang->chat->version     = 'Version';
$lang->chat->xxbLang     = 'Server Lang';
$lang->chat->key         = 'Secret';
$lang->chat->systemGroup = 'System';
$lang->chat->url         = 'URL';
$lang->chat->createKey   = 'New';
$lang->chat->connector   = ', ';
$lang->chat->viewDebug   = 'View Debug';
$lang->chat->log         = 'Log';

$lang->chat->debugStatus[1] = 'On';
$lang->chat->debugStatus[0] = 'Off';

$lang->chat->xxdServer       = 'Zentao Server';
$lang->chat->createKey       = 'New';
$lang->chat->downloadXXD     = 'Download XXD';
$lang->chat->listenIP        = 'Listen IP';
$lang->chat->chatPort        = 'Chat Port';
$lang->chat->uploadFileSize  = 'File Size';
$lang->chat->downloadPackage = 'Full Package';
$lang->chat->downloadConfig  = 'Only Config';
$lang->chat->changeSetting   = 'Change Setting';

$lang->chat->notAdmin         = 'You are not admin of chat.';
$lang->chat->notSystemChat    = 'It is not a system chat.';
$lang->chat->notGroupChat     = 'It is not a group chat.';
$lang->chat->notPublic        = 'It is not a public chat.';
$lang->chat->cantChat         = 'No rights to chat.';
$lang->chat->chatHasDismissed = 'The chat group has been dismissed.';
$lang->chat->needLogin        = 'You need login first.';
$lang->chat->notExist         = 'Chat do not exist.';
$lang->chat->changeRenameTo   = 'Rename chat to ';
$lang->chat->multiChats       = 'Messages belong to different chats.';
$lang->chat->notInGroup       = 'You are not in this chat group.';
$lang->chat->errorKey         = 'The key should be a 32 byte string including letters or numbers.';
$lang->chat->debugTips        = 'Xuanxuan is working.<br>%s with administrator to get more information.';
$lang->chat->noLogFile        = 'No log file.';
$lang->chat->noFopen          = 'Function fopen disabled. Find the following file to see log : %s.';
$lang->chat->defaultKey       = 'Do not use default <strong>key</strong>.';

$lang->chat->xxdServerTip   = 'XXD server address contains protocol and host and port，such as http://192.168.1.35 or http://www.backend.com, that can not be 127.0.0.1.';
$lang->chat->xxdServerEmpty = 'XXD server address is empty.';
$lang->chat->xxdServerError = 'XXD server address can not be 127.0.0.1.';
$lang->chat->xxdSchemeError = 'Server address should started with http:// or https://.';
$lang->chat->xxdPortError   = 'Server address should contain valid port and the default is <strong>11443</strong>.';

$lang->chat->broadcast = new stdclass();
$lang->chat->broadcast->createChat  = '@%s created the group **[%s](#/chats/groups/%s)**.';
$lang->chat->broadcast->joinChat    = '@%s joined.';
$lang->chat->broadcast->quitChat    = '@%s quited.';
$lang->chat->broadcast->renameChat  = '@%s renamed the group to **[%s](#/chats/groups/%s)**.';
$lang->chat->broadcast->inviteUser  = '@%s invited %s to join.';
$lang->chat->broadcast->dismissChat = '@%s dismissed the group.';

$lang->chat->xxd = new stdclass();
$lang->chat->xxd->os             = 'OS';
$lang->chat->xxd->ip             = 'Listen IP';
$lang->chat->xxd->chatPort       = 'Chat Port';
$lang->chat->xxd->commonPort     = 'Common Port';
$lang->chat->xxd->isHttps        = 'Ishttps';
$lang->chat->xxd->uploadFileSize = 'File Size';
$lang->chat->xxd->maxOnlineUser  = 'Max Online User Counts';
$lang->chat->xxd->sslcrt         = 'SSL Crt';
$lang->chat->xxd->sslkey         = 'SSL Key';
$lang->chat->xxd->max            = 'Max';

$lang->chat->httpsOptions['on']  = 'Enable';
$lang->chat->httpsOptions['off'] = 'Disable';

$lang->chat->placeholder = new stdclass();
$lang->chat->placeholder->xxd = new stdclass();
$lang->chat->placeholder->xxd->ip             = 'Listen to the server IP address, Default 0.0.0.0';
$lang->chat->placeholder->xxd->chatPort       = 'The port on which the chat client communicates';
$lang->chat->placeholder->xxd->commonPort     = 'Generic port used for client login verification and for file upload and download';
$lang->chat->placeholder->xxd->isHttps        = 'Enable https';
$lang->chat->placeholder->xxd->uploadFileSize = 'Upload file size';
$lang->chat->placeholder->xxd->maxOnlineUser  = 'Maximum number of user online';
$lang->chat->placeholder->xxd->sslcrt         = 'Copy the certificate content here';
$lang->chat->placeholder->xxd->sslkey         = 'Copy the certificate key here';

$lang->chat->notify = new stdclass();
$lang->chat->notify->setReceiver = 'Not set receiver type, it must be users or chat group.';
$lang->chat->notify->setGroup    = 'Should set chat group.';
$lang->chat->notify->setUserList = 'Should set user list.';
$lang->chat->notify->setSender   = 'Should set sender info.';

$lang->chat->osList['win_i386']      = 'Windows_i386';
$lang->chat->osList['win_x86_64']    = 'Windows_x86_64';
$lang->chat->osList['linux_i386']    = 'Linux_i386';
$lang->chat->osList['linux_x86_64']  = 'Linux_x86_64';
$lang->chat->osList['darwin_x86_64'] = 'macOS';
