<?php
if (!defined('puyuetian'))
	exit('403');

if (!$_G['USER']['ID']) {
	exit(json_encode(array('state' => 'no', 'msg' => '请登录')));
}
if (!$_G['GET']['UID'] || $_G['GET']['UID'] == $_G['USER']['ID']) {
	exit(json_encode(array('state' => 'no', 'msg' => '不能自己给自己发消息')));
}
$content = Cstr($_POST['content'], FALSE, FALSE, 1, Cnum($_G['SET']['POSTMESSAGEMAXNUM'], 255, TRUE, 1));
if (!$content) {
	if (!$_POST['content']) {
		$str = '内容为空';
	} else {
		$str = '消息内容超出了最大限制';
	}
	exit(json_encode(array('state' => 'no', 'msg' => $str)));
}
$ss = time() - Cnum(JsonData($_G['USER']['DATA'], 'lasttimemessageposttime')) - 5;
if ($ss < 0) {
	exit(json_encode(array('state' => 'no', 'msg' => '操作太快，请稍后一会再操作')));
}
//检测消息是否包含违禁词
$wjcs = $_G['SET']['BANPOSTWORDS'];
if ($wjcs) {
	$wjcs = explode(',', $wjcs);
	foreach ($wjcs as $w) {
		if ($w) {
			if (strpos(str_replace(array("\n", "\r", "\r\n", "\t", " ", "&nbsp;"), '', strip_tags($content)), $w) !== FALSE) {
				exit(json_encode(array('state' => 'no', 'msg' => '您发送的消息包含违禁词，无法发送')));
			}
		}
	}
}
$udata = $_G['TABLE']['USER'] -> getData($_G['GET']['UID']);
if (!$udata) {
	exit(json_encode(array('state' => 'no', 'msg' => '不存在的用户')));
}
if (strpos($udata['friends'], "_{$_G['USER']['ID']}_") === FALSE) {
	NewMessage($_G['GET']['UID'], '陌生人<a class="pk-text-bold" target="_blank" href="index.php?c=center&uid=' . $_G['USER']['ID'] . '">[' . $_G['USER']['NICKNAME'] . ']</a>：' . strip_tags($content), 0, 2);
} else {
	NewMessage($_G['GET']['UID'], $content, $_G['USER']['ID']);
}
//记录最后一次发布时间
$array['id'] = $_G['USER']['ID'];
$array['data'] = JsonData($_G['USER']['DATA'], 'lasttimemessageposttime', time());
$_G['TABLE']['USER'] -> newData($array);
exit(json_encode(array('state' => 'ok', 'msg' => '发送成功')));
