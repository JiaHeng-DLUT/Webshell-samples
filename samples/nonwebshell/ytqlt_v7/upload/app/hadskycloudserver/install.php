<?php
if (!defined('puyuetian'))
	exit('403');

if ($_G['USER']['ID'] == 1) {
	$zds = explode(',', 'qqopenid,wxopenid,weibo_uid,baidu_userid,weixin_openids');

	foreach ($zds as $zd) {
		//检测该字段是否存在
		if (!$_G['TABLE']['USER'] -> getColumns($zd)) {
			mysql_query("ALTER TABLE `{$_G['MYSQL']['PREFIX']}user` ADD `{$zd}` text null");
		}
	}

	//建表
	if (!$_G['TABLE']['APP_HADSKYCLOUDSERVER_CLOUDPAY_RECORD']) {
		mysql_query("CREATE TABLE `{$_G['MYSQL']['PREFIX']}app_hadskycloudserver_cloudpay_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hs_id` bigint(20) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `rmb` int(11) NOT NULL DEFAULT '0',
  `tiandou` int(11) NOT NULL DEFAULT '0',
  `createtime` int(11) NOT NULL DEFAULT '0',
  `finishtime` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	}
	//云短信表
	if (!$_G['TABLE']['APP_PUYUETIAN_SMS_RECORD']) {
		mysql_query("CREATE TABLE `{$_G['MYSQL']['PREFIX']}app_puyuetian_sms_record` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `pn` varchar(11) NOT NULL,
 `ip` varchar(255) NOT NULL,
 `date` int(8) NOT NULL,
 `state` varchar(255) NOT NULL DEFAULT 'no',
 `msg` text,
 `datetime` datetime NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	}
	//微信扫码登录建表
	if (!$_G['TABLE']['APP_HADSKYCLOUDSERVER_WEIXINLOGIN_RECORD']) {
		mysql_query("CREATE TABLE `{$_G['MYSQL']['PREFIX']}app_hadskycloudserver_weixinlogin_record` (
 `id` bigint(20) NOT NULL AUTO_INCREMENT,
 `uid` bigint(20) NOT NULL DEFAULT '0',
 `openid` varchar(255) NOT NULL DEFAULT '',
 `idcode` varchar(255) NOT NULL DEFAULT '',
 `regtime` int(11) NOT NULL DEFAULT '0',
 `logtime` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8");
	}
}
exit();
