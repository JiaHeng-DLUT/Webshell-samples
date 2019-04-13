<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['GET']['SAFECODE'] != md5($_G['SET']['KEY'])) {
	ExitJson('安全校验失败');
}

$mailto = $_POST['mailto'];
$mailtitle = $_POST['mailtitle'];
$mailcontent = $_POST['mailcontent'];

sendmail($mailto, $mailtitle, $mailcontent, TRUE);

ExitJson('操作完成', TRUE);
