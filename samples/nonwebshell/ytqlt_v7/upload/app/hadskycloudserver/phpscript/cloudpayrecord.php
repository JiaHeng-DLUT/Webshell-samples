<?php
if (!defined('puyuetian'))
	exit('403');

if (!$_G['USER']['ID']) {
	header('Location:index.php?c=login&referer=' . urlencode($_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']));
	exit();
}

$sql = 'order by `id` desc';
if ($_G['USER']['ID'] != 1) {
	$sql = "where `uid`={$_G['USER']['ID']} order by `id` desc";
}
$_G['TEMP']['PAGE'] = Cnum($_G['GET']['PAGE'], 1, TRUE, 1);
$_G['TEMP']['NUM'] = 50;
$_G['TEMP']['HTML'] = '';
$datas = $_G['TABLE']['APP_HADSKYCLOUDSERVER_CLOUDPAY_RECORD'] -> getDatas(($_G['TEMP']['PAGE'] - 1) * $_G['TEMP']['NUM'], $_G['TEMP']['NUM'], $sql);
foreach ($datas as $data) {
	$_G['TEMP']['HTML'] .= "<tr>
	<td>{$data['hs_id']}</td>
	<td>{$data['uid']}</td>
	<td>{$data['rmb']}</td>
	<td>{$data['tiandou']}</td>
	<td>" . date('Y-m-d H:i:s', $data['createtime']) . "</td>
	<td>" . date('Y-m-d H:i:s', $data['finishtime']) . "</td>
	<td class='pk-text-success'>交易成功</td>
</tr>";
}
$_G['HTMLCODE']['OUTPUT'] .= template('hadskycloudserver:cloudpayrecord', TRUE);
