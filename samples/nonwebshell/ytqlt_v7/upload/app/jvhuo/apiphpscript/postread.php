<?php
if (!defined('puyuetian'))
	exit('403');

$uid = explode(',', $_G['SET']['APP_JVHUO_POSTUIDS']);
shuffle($uid);
$uid = Cnum($uid[0], 0, TRUE, 1);
if (!$uid) {
	ExitJson('发帖用户UID设置有误');
}
$bkid = Cnum($_G['SET']['APP_JVHUO_POSTBKID'], 0, TRUE, 1);
if (!$bkid) {
	ExitJson('发帖至版块ID设置有误');
}
$data = json_decode($_POST['data'], TRUE);
$title = $data['title'];
$content = $data['content'];
$gid = Cnum($data['id']);
if (!$title || !$content || !$gid) {
	ExitJson('参数错误');
}

$_G['TEMP'] = $data;
$_G['TEMP']['class'] = '';
$class = json_decode($data['class'], TRUE);
foreach ($class as $key => $value) {
	$_G['TEMP']['class'] .= '<b> · </b>' . $value['title'] . '，单价<font class="pk-text-danger">' . ($value['price'] / 100) . '元</font>，库存<font class="pk-text-primary">' . $value['inventory'] . '件</font>';
}
$_G['TEMP']['freight'] /= 100;
$_G['TEMP']['type'] = $data['type'] == 'sw' ? '实物' : '虚拟';
$_G['TEMP']['image'] = json_decode($_G['TEMP']['image'], TRUE);
foreach ($_G['TEMP']['image'] as $key => $value) {
	if (!filter_var($value, FILTER_VALIDATE_URL)) {
		$_G['TEMP']['image'][$key] = 'https://www.jvhuo.com/' . $value;
	}
}
//内容内的图片处理
$images = getHtmlImages($_G['TEMP']['content'], 0);
$_ls = array();
foreach ($images as $key => $value) {
	if (!filter_var($value['src'], FILTER_VALIDATE_URL) && !InArray($_ls, $value['src'])) {
		$_ls[] = $value['src'];
		$_G['TEMP']['content'] = str_replace($value['src'], 'https://www.jvhuo.com/' . $value['src'], $_G['TEMP']['content']);
	}
}

$array = array();
$id = $_G['TABLE']['READ'] -> getId(array('jvhuo_gid' => $gid));
$array['id'] = $id;
$array['sortid'] = $bkid;
$array['uid'] = $uid;
$array['label'] = $_G['SET']['APP_JVHUO_POSTLABEL'];
$array['title'] = $title;
$array['content'] = template('jvhuo:postread-template1', TRUE);
$array['postip'] = getClientInfos('ip');
$array['jvhuo_gid'] = $gid;
$array['del'] = $array['readlevel'] = 0;
$array['posttime'] = $array['activetime'] = time();
if (!($_G['TABLE']['READ'] -> newData($array))) {
	ExitJson(sqlError());
}
if (!$id) {
	$id = $_G['TABLE']['READ'] -> getId("WHERE `sortid`='{$bkid}' AND `uid`='{$uid}' ORDER BY `id` DESC");
}
ExitJson($id, TRUE);
