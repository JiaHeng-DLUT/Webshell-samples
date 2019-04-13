<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['USER']['ID'] != 1) {
	ExitJson('无权操作');
}

$data = GetPostData("http://www.hadsky.com/index.php?c=app&a=zhanzhang:index6&s=getcloudservernodes&domain={$_G['SYSTEM']['DOMAIN']}&sitekey=" . md5($_G['SET']['APP_HADSKYCLOUDSERVER_SITEKEY']) . "&rnd={$_G['RND']}", false, 5);
$json = json_decode($data, TRUE);
if (!$json) {
	ExitJson('同步失败，无法连接服务器');
}
if ($json['state'] != 'ok') {
	ExitJson($json['datas']['msg']);
}
$nodes = json_decode($json['datas']['msg'], TRUE);
if (!$nodes) {
	ExitJson('同步失败，数据格式错误');
}

$id = $_G['TABLE']['SET'] -> getId(array('setname' => 'app_hadskycloudserver_nodes'));

if (!$_G['TABLE']['SET'] -> newData(array('id' => $id, 'setname' => 'app_hadskycloudserver_nodes', 'setvalue' => json_encode($nodes)))) {
	ExitJson(mysql_error());
}
ExitJson($nodes, TRUE);
