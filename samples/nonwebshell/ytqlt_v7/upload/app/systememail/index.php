<?php
if (!defined('puyuetian'))
	exit('403');
/*
 * 有天轻论坛插件
 * 邮件群发插件v1.0
 * 作者：蒲乐天
 */

if ($_G['USER']['ID'] == 1) {
	if (isset($_POST['mailtotype'])) {
		$mailtotype = $_POST['mailtotype'];
		$mailto = $_POST['mailto'];
		$mailtitle = $_POST['mailtitle'];
		$mailcontent = $_POST['mailcontent'];
		$__i = 0;
		if ($mailtitle && $mailcontent) {
			if ($mailtotype == 'all') {
				//发送给全站会员
				$ua = $_G['TABLE']['USER'] -> getDatas(0, 0, "where `email`<>''");
				foreach ($ua as $ua2) {
					$__mail = filter_var($ua2['email'], FILTER_VALIDATE_EMAIL);
					if ($__mail) {
						//sleep(1);
						sendmail($__mail, $mailtitle, $mailcontent);
						$__i++;
					}
				}
				$_G['HTMLCODE']['TIP'] = "成功发送{$__i}封邮件！";
				$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
			} elseif ($mailtotype == 'more' && $mailto) {
				$__mailto = explode(',', $mailto);
				foreach ($__mailto as $__value) {
					$__mail = filter_var($__value, FILTER_VALIDATE_EMAIL);
					if ($__mail) {
						sleep(1);
						sendmail($__mail, $mailtitle, $mailcontent);
						$__i++;
					}
				}
				$_G['HTMLCODE']['TIP'] = "成功发送{$__i}封邮件！";
				$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
			} else {
				$_G['HTMLCODE']['TIP'] = "参数错误！";
				$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
			}
		} else {
			$_G['HTMLCODE']['TIP'] = "邮件标题和内容不能为空！";
			$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
		}
	} else {
		$_G['HTMLCODE']['OUTPUT'] .= template('systememail:index', TRUE);
	}
} else {
	$_G['HTMLCODE']['TIP'] = "您无权使用该插件！";
	$_G['HTMLCODE']['OUTPUT'] .= template('tip', TRUE);
}
