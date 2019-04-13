<?php
include('../../common.php');
pe_lead('hook/cache.hook.php');
$pre = dbpre;
//更新ad表
$db->query("ALTER TABLE `{$pre}ad` ADD `category_id` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '分类id' AFTER `ad_order`");
//更新ask表
$sql = <<<html
	ALTER TABLE `{$pre}ask` ADD `product_name` VARCHAR( 50 ) NOT NULL COMMENT '商品名称' AFTER `product_id` ,
	ADD `product_logo` VARCHAR( 100 ) NOT NULL COMMENT '商品logo' AFTER `product_name`
html;
$db->query($sql);
$db->query("update `{$pre}ask` a left join `{$pre}product` b on a.`product_id` = b.product_id set a.product_name = b.product_name, a.product_logo = b.product_logo");
//更新cart表
$db->query("DROP TABLE `{$pre}cart`");	
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}cart` (
	  `cart_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `cart_atime` int(10) unsigned NOT NULL DEFAULT '0',
	  `product_guid` char(32) NOT NULL COMMENT '唯一id',
	  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `product_num` smallint(5) unsigned NOT NULL DEFAULT '1',
	  `prorule_key` varchar(30) NOT NULL COMMENT '规格id组合',
	  `user_id` varchar(32) NOT NULL,
	  PRIMARY KEY (`cart_id`),
	  KEY `product_id` (`product_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新cashout表	
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}cashout` (
	  `cashout_id` int(10) unsigned NOT NULL auto_increment,
	  `cashout_money` decimal(10,1) unsigned NOT NULL default '0.0',
	  `cashout_fee` decimal(5,1) unsigned NOT NULL default '0.0' COMMENT '提现手续费',
	  `cashout_atime` int(10) unsigned NOT NULL default '0',
	  `cashout_ptime` int(10) unsigned NOT NULL default '0' COMMENT '结算日期',
	  `cashout_state` tinyint(1) unsigned NOT NULL default '0',
	  `cashout_ip` char(15) NOT NULL COMMENT '用户ip',
	  `cashout_bankname` varchar(20) NOT NULL,
	  `cashout_banknum` varchar(50) NOT NULL,
	  `cashout_banktname` varchar(10) NOT NULL,
	  `cashout_bankaddress` varchar(50) NOT NULL,
	  `user_id` int(10) unsigned NOT NULL default '0',
	  `user_name` varchar(30) NOT NULL,
	  PRIMARY KEY  (`cashout_id`),
	  KEY `user_id` (`user_id`),
	  KEY `cashout_state` (`cashout_state`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新getpw表	
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}getpw` (
	  `getpw_id` int(10) unsigned NOT NULL auto_increment,
	  `getpw_token` char(32) NOT NULL,
	  `getpw_state` tinyint(1) unsigned NOT NULL default '0',
	  `getpw_atime` int(10) unsigned NOT NULL default '0' COMMENT '绑定日期',
	  `user_id` int(10) unsigned NOT NULL default '0',
	  `user_name` varchar(20) NOT NULL,
	  PRIMARY KEY  (`getpw_id`),
	  KEY `getpw_token` (`getpw_token`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新comment表
$sql = <<<html
	ALTER TABLE `{$pre}comment` ADD `product_name` VARCHAR( 50 ) NOT NULL COMMENT '商品名称' AFTER `product_id` ,
	ADD `product_logo` VARCHAR( 100 ) NOT NULL COMMENT '商品logo' AFTER `product_name`
html;
$db->query($sql);
$db->query("update `{$pre}comment` a left join `{$pre}product` b on a.`product_id` = b.product_id set a.product_name = b.product_name, a.product_logo = b.product_logo");
//更新getpw表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}getpw` (
	  `getpw_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `getpw_token` char(32) NOT NULL,
	  `getpw_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  `getpw_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '绑定日期',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `user_name` varchar(20) NOT NULL,
	  PRIMARY KEY (`getpw_id`),
	  KEY `getpw_token` (`getpw_token`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql); 
//更新huodongdata表
$db->query("ALTER TABLE `{$pre}huodongdata` change `huodong_money` `huodong_money` decimal(10,1) UNSIGNED NOT NULL DEFAULT 0.0 AFTER `huodong_etime`");
//更新menu表
$db->query("ALTER TABLE `{$pre}menu` ADD `menu_target` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '1' COMMENT '新标签打开' AFTER `menu_url`");
//更新moneylog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}moneylog` (
	  `moneylog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `moneylog_type` varchar(10) NOT NULL,
	  `moneylog_in` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '收入',
	  `moneylog_out` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '支出',
	  `moneylog_now` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '当前结余',
	  `moneylog_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
	  `moneylog_text` varchar(255) NOT NULL,
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
	  `user_name` varchar(20) NOT NULL COMMENT '用户名',
	  PRIMARY KEY (`moneylog_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新notice表
$db->query("DROP TABLE `{$pre}notice`");
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}notice` (
	  `notice_id` int(10) unsigned NOT NULL auto_increment,
	  `notice_name` varchar(20) NOT NULL COMMENT '通知名称',
	  `notice_mark` varchar(20) NOT NULL COMMENT '通知标识',
	  `notice_obj` varchar(5) NOT NULL COMMENT '通知对象',
	  `notice_sms_text` varchar(255) NOT NULL,
	  `notice_sms_state` tinyint(1) unsigned NOT NULL default '1',
	  `notice_email_name` varchar(100) NOT NULL COMMENT '邮件标题',
	  `notice_email_text` text NOT NULL COMMENT '邮件内容',
	  `notice_email_state` tinyint(1) unsigned NOT NULL default '0' COMMENT '通知状态',
	  PRIMARY KEY  (`notice_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;
html;
$db->query($sql);
$sql = <<<html
	INSERT INTO `{$pre}notice` (`notice_id`, `notice_name`, `notice_mark`, `notice_obj`, `notice_sms_text`, `notice_sms_state`, `notice_email_name`, `notice_email_text`, `notice_email_state`) VALUES
	(1, '用户下单', 'order_add', 'user', '下单通知：订单{order_id}提交成功，请及时付款！', 1, '下单通知：订单{order_id}提交成功，请及时付款！', '<p>\r\n	订单金额：{order_money}元\r\n</p>\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', 1),
	(2, '订单付款', 'order_pay', 'user', '付款通知：订单{order_id}付款成功，祝您生活愉快！', 1, '付款通知：订单{order_id}付款成功，祝您生活愉快！', '<p>\r\n	订单金额：{order_money}元\r\n</p>\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', 1),
	(3, '订单发货', 'order_send', 'user', '发货通知：订单{order_id}已发货，请注意接收！', 1, '发货通知：订单{order_id}已发货，请注意接收！', '<p>\r\n	快递公司：{order_wl_name}，运单编号：{order_wl_id}<span class="tag_gray fl mar5 mab5" style="line-height:20px;"></span>，如有问题请及时联系！\r\n</p>', 1),
	(4, '订单关闭', 'order_close', 'user', '关闭通知：订单{order_id}已关闭，原因：{order_closetext}', 1, '关闭通知：订单{order_id}已关闭，原因：{order_closetext}', '订单金额：{order_money}元\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', 1),
	(5, '用户下单', 'order_add', 'admin', '新订单通知：{order_id}，金额：{order_money}元，姓名：{user_tname}，电话：{user_phone}，请注意查看！', 1, '新订单通知：{order_id}，金额：{order_money}元，姓名：{user_tname}，电话：{user_phone}，请注意查看！', '<p>\r\n	订单金额：{order_money}元\r\n</p>\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>', 1),
	(6, '订单付款', 'order_pay', 'admin', '付款通知：订单{order_id}付款成功，请及时安排发货！', 1, '付款通知：订单{order_id}付款成功，请及时安排发货！', '<p>\r\n	订单金额：{order_money}元\r\n</p>\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>', 1);
html;
$db->query($sql);
//更新noticelog表
$info = $db->num_rows($db->query("desc `{$pre}noticelog` `noticelog_type`"));
if ($info) {
	$db->query("ALTER TABLE `{$pre}noticelog` DROP `noticelog_type`");
}
$db->query("ALTER TABLE `{$pre}noticelog` ADD `noticelog_type` VARCHAR( 5 ) NOT NULL DEFAULT 'email' AFTER `noticelog_id`");
$info = $db->num_rows($db->query("desc `{$pre}noticelog` `noticelog_adate`"));
if ($info) {
	$db->query("ALTER TABLE `{$pre}noticelog` DROP `noticelog_adate`");
	$db->query("ALTER TABLE `{$pre}noticelog` DROP `noticelog_ip`");	
	$db->query("ALTER TABLE `{$pre}noticelog` DROP `noticelog_url`");	
	$db->query("ALTER TABLE `{$pre}noticelog` DROP `noticelog_sessid`");
	$db->query("ALTER TABLE `{$pre}noticelog` DROP `noticelog_yzmvalue`");
	$db->query("ALTER TABLE `{$pre}noticelog` DROP `noticelog_yzmstate`");
	$db->query("ALTER TABLE `{$pre}noticelog` DROP `noticelog_yzmcheck`");
}
$db->query("ALTER TABLE `{$pre}noticelog` ADD `noticelog_error` VARCHAR( 50 ) NOT NULL COMMENT '失败提醒' AFTER `noticelog_state`");
$db->query("ALTER TABLE `{$pre}noticelog` ADD INDEX ( `noticelog_state` )");
$db->query("ALTER TABLE `{$pre}noticelog` CHANGE `noticelog_state` `noticelog_state` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'new' COMMENT '通知状态'");
$db->query("UPDATE `{$pre}noticelog` set noticelog_state = 'new' where noticelog_state = 0");
$db->query("UPDATE `{$pre}noticelog` set noticelog_state = 'success' where noticelog_state = 1");
//更新order表
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_outid` `order_outid` VARCHAR( 50 ) NOT NULL COMMENT '第三方支付订单号'");
$db->query("update `{$pre}order` set order_outid = '' where order_outid = 0");
$sql = <<<html
	ALTER TABLE `{$pre}order` ADD `order_pstate` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '付款状态' AFTER `order_state` ,
	ADD `order_sstate` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发货状态' AFTER `order_pstate` 
html;
$db->query($sql);
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_state` `order_state` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'wpay'");
$db->query("ALTER TABLE `{$pre}order` ADD `order_name` VARCHAR( 50 ) NOT NULL AFTER `order_outid`");
$db->query("update `{$pre}order` set order_pstate = 1 where order_ptime > 0");
$db->query("update `{$pre}order` set order_sstate = 1 where order_stime > 0");
$db->query("update `{$pre}order` set order_state = 'wpay' where `order_state` = 'notpay' and `order_payway` != 'cod'");
$db->query("update `{$pre}order` set order_state = 'wsend' where (`order_state` = 'paid' or (`order_state` = 'notpay' and `order_payway` = 'cod'))");
$db->query("update `{$pre}order` set order_state = 'wget' where order_state = 'send'");
//更新orderdata表
$db->query("ALTER TABLE `{$pre}orderdata` ADD `product_guid` CHAR( 32 ) NOT NULL COMMENT '唯一id' AFTER `order_id`");
$db->query("update `{$pre}orderdata` set `product_guid` = md5(concat(product_id, ',', replace(prorule_key, '-', ',')))");
$db->query("ALTER TABLE `{$pre}orderdata` DROP `prorule_id`");
//更新order_pay表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}order_pay` (
	  `order_id` varchar(25) NOT NULL COMMENT '订单id',
	  `order_outid` varchar(50) NOT NULL,
	  `order_name` varchar(50) NOT NULL,
	  `order_money` decimal(10,1) unsigned NOT NULL default '0.0' COMMENT '订单金额',
	  `order_state` varchar(10) NOT NULL default 'wpay',
	  `order_payway` varchar(10) NOT NULL default 'alipay',
	  `order_atime` int(10) unsigned NOT NULL default '0' COMMENT '下单时间',
	  `order_ptime` int(10) unsigned NOT NULL default '0' COMMENT '付款时间',
	  `order_pstate` tinyint(1) unsigned NOT NULL default '0' COMMENT '付款状态',
	  `user_id` int(10) unsigned NOT NULL,
	  `user_name` varchar(20) NOT NULL,
	  KEY `order_id` (`order_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
html;
$db->query($sql); 
//更新payway表
$info_list = $db->index('payway_mark')->pe_selectall('payway');
$db->query("TRUNCATE TABLE `{$pre}payway`");
$sql = <<<html
	INSERT INTO `{$pre}payway` (`payway_id`, `payway_name`, `payway_mark`, `payway_logo`, `payway_model`, `payway_config`, `payway_text`, `payway_order`, `payway_state`) VALUES
	(1, '余额支付', 'balance', 'include/plugin/payway/balance/logo.gif', '', '', '使用帐户余额支付，只有会员才能使用。', 0, 1),
	(2, '支付宝', 'alipay', 'include/plugin/payway/alipay/logo.gif', 'a:3:{s:11:"alipay_name";a:2:{s:4:"name";s:15:"支付宝账户";s:9:"form_type";s:4:"text";}s:10:"alipay_pid";a:2:{s:4:"name";s:18:"合作者身份Pid";s:9:"form_type";s:4:"text";}s:10:"alipay_key";a:2:{s:4:"name";s:18:"安全校验码Key";s:9:"form_type";s:4:"text";}}', 'a:3:{s:11:"alipay_name";s:0:"";s:10:"alipay_pid";s:0:"";s:10:"alipay_key";s:0:"";}', '即时到帐接口，买家交易金额直接转入卖家支付宝账户。', 0, 1),
	(3, '微信支付', 'wechat', 'include/plugin/payway/wechat/logo.gif', 'a:4:{s:12:"wechat_appid";a:2:{s:4:"name";s:5:"AppID";s:9:"form_type";s:4:"text";}s:16:"wechat_appsecret";a:2:{s:4:"name";s:9:"AppSecret";s:9:"form_type";s:4:"text";}s:12:"wechat_mchid";a:2:{s:4:"name";s:9:"商户号";s:9:"form_type";s:4:"text";}s:10:"wechat_key";a:2:{s:4:"name";s:9:"API密钥";s:9:"form_type";s:4:"text";}}', 'a:4:{s:12:"wechat_appid";s:0:"";s:16:"wechat_appsecret";s:0:"";s:12:"wechat_mchid";s:0:"";s:10:"wechat_key";s:0:"";}', '用户使用微信扫码支付', 0, 1),
	(4, '云支付', 'passpay', 'include/plugin/payway/passpay/logo.gif', 'a:3:{s:12:"passpay_name";a:2:{s:4:"name";s:18:"云通付商户号";s:9:"form_type";s:4:"text";}s:11:"passpay_pid";a:2:{s:4:"name";s:12:"云通付Pid";s:9:"form_type";s:4:"text";}s:11:"passpay_key";a:2:{s:4:"name";s:12:"云通付Key";s:9:"form_type";s:4:"text";}}', 'a:3:{s:12:"passpay_name";s:0:"";s:11:"passpay_pid";s:0:"";s:11:"passpay_key";s:0:"";}', '云通付（www.passpay.net）适合个人/团体快速接入支付功能，含支付宝/微信支付/网银等渠道', 0, 1),
	(5, '转账汇款', 'bank', 'include/plugin/payway/bank/logo.gif', 'a:1:{s:9:"bank_text";a:2:{s:4:"name";s:12:"收款信息";s:9:"form_type";s:8:"textarea";}}', 'a:1:{s:9:"bank_text";s:159:"请将款项汇款至以下账户：\r\n建设银行 621700254000005xxxx 刘某\r\n工商银行 621700254000005xxxx 刘某\r\n农业银行 621700254000005xxxx 刘某";}', '通过线下汇款方式支付，汇款帐号：建设银行 621700254000005xxxx 刘某', 0, 1),
	(6, '货到付款', 'cod', 'include/plugin/payway/cod/logo.gif', '', '', '送货上门后再收款，支持现金、POS机刷卡、支票支付', 0, 1);
html;
$db->query($sql);
foreach ($info_list as $k=>$v) {
	$payway_config = '';
	if ($k == 'alipay') {
		$old = unserialize($v['payway_config']);
		$payway_config['alipay_name'] = $old['alipay_name'];
		$payway_config['alipay_pid'] = $old['alipay_pid'];	
		$payway_config['alipay_key'] = $old['alipay_key'];
		$payway_config = serialize($payway_config);
	}
	elseif ($k == 'wechat' or $k == 'bank') {
		$payway_config = $v['payway_config'];
	}
	if ($payway_config) {
		$db->pe_update('payway', array('payway_mark'=>$k), array('payway_config'=>$payway_config));	
	}
}
//更新pointlog表
$db->pe_update('pointlog', array('pointlog_type'=>array('reg', 'comment', 'order_get')), array('pointlog_type'=>'give'));
$db->pe_update('pointlog', array('pointlog_type'=>'order_use'), array('pointlog_type'=>'order_pay'));
$db->pe_update('pointlog', array('pointlog_type'=>'order_back'), array('pointlog_type'=>'give'));
//更新product表
$db->query("ALTER TABLE `{$pre}product` ADD `product_order` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT '255' COMMENT '商品排序' AFTER `product_atime`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_rule` TEXT NOT NULL COMMENT '规格数据集' AFTER `product_istuijian`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_album` TEXT NOT NULL COMMENT '商品相册' AFTER `product_logo`");
$db->query("update `{$pre}product` set `product_album` = `product_logo`");
$cache_rule = cache::get('rule');
$cache_ruledata = cache::get('ruledata');
$info_list = $db->pe_selectall('product', "and rule_id != ''");
foreach ($info_list as $v) {
	$product_rule = $arr = $ruledata_list = '';
	$prorule_list = $db->pe_selectall('prorule', array('product_id'=>$v['product_id']));
	foreach ($prorule_list as $vv) {
		foreach (explode(',', $vv['prorule_key']) as $vvv) {
			$rule_id = $cache_ruledata[$vvv]['rule_id'];
			$ruledata_id = $cache_ruledata[$vvv]['ruledata_id'];
			$ruledata_name = $cache_ruledata[$vvv]['ruledata_name'];
			$ruledata_list[$rule_id][$ruledata_id] = $ruledata_name;
		}
	}
	foreach (explode(',', $v['rule_id']) as $vv) {
		$arr['id'] = $cache_rule[$vv]['rule_id'];
		$arr['name'] = $cache_rule[$vv]['rule_name'];
		$arr_list = '';
		foreach ($ruledata_list[$vv] as $kkk=>$vvv) {
			$arr_list[] = array('id'=>$kkk, 'name'=>$vvv);
		}
		$arr['list'] = $arr_list;
		$product_rule[] = $arr;
	}
	$product_rule = serialize($product_rule);
	$db->pe_update('product', array('product_id'=>$v['product_id']), array('product_rule'=>$product_rule));
}
//更新prorule表
$db->query("ALTER TABLE `{$pre}prorule` ADD `prorule_name` VARCHAR( 50 ) NOT NULL COMMENT '规格名组合' AFTER `prorule_key`");
$info_list = $db->pe_selectall('prorule');
foreach ($info_list as $v) {
	$prorule_name = '';
	foreach (explode(',', $v['prorule_key']) as $vv) {
		$prorule_name[] = $cache_ruledata[$vv]['ruledata_name'];
	}
	$prorule_name = implode(',', $prorule_name);
	$db->pe_update('prorule', array('prorule_id'=>$v['prorule_id']), array('prorule_name'=>$prorule_name));
}
//更新setting表
$db->query("INSERT INTO `{$pre}setting` (`setting_key`, `setting_value`) VALUES ('email_ssl', '0'), ('sms_key', ''), ('sms_sign', '简好网络'), ('sms_admin', ''), ('cashout_min', '100'), ('cashout_fee', ''),('web_qrcode', '')");
if (!$db->pe_num('setting', array('setting_key'=>'wechat_appid'))) {
	$db->query("INSERT INTO `{$pre}setting` (`setting_key`, `setting_value`) VALUES ('wechat_appid', ''), ('wechat_appsecret', ''), ('wechat_token', ''), ('wechat_access_token', ''), ('wechat_menu', ''), ('wechat_rssadd', 'hellow')");
}
//更新useraddr表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}useraddr` (
	  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `address_province` varchar(20) NOT NULL,
	  `address_city` varchar(20) NOT NULL,
	  `address_area` varchar(20) NOT NULL,
	  `address_text` varchar(100) NOT NULL,
	  `address_atime` int(10) unsigned NOT NULL DEFAULT '0',
	  `address_default` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `user_name` varchar(20) NOT NULL,
	  `user_tname` varchar(10) NOT NULL,
	  `user_phone` char(11) NOT NULL,
	  PRIMARY KEY (`address_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新userbank表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}userbank` (
	  `userbank_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `userbank_name` varchar(20) NOT NULL,
	  `userbank_num` varchar(50) NOT NULL,
	  `userbank_type` varchar(10) NOT NULL COMMENT '银行标识',
	  `userbank_tname` varchar(10) NOT NULL COMMENT '账户姓名',
	  `userbank_address` varchar(50) NOT NULL,
	  `userbank_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '绑定日期',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `user_name` varchar(20) NOT NULL,
	  PRIMARY KEY (`userbank_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
html;
$db->query($sql); 
//更新user表
$db->query("ALTER TABLE `{$pre}user` ADD `user_logo` VARCHAR( 100 ) NOT NULL AFTER `user_pw`");
$db->query("ALTER TABLE `{$pre}user` ADD `user_ordernum` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `user_address`");
$info = $db->num_rows($db->query("desc `{$pre}user` `user_wx_openid`"));
if (!$info) {
	$db->query("ALTER TABLE `{$pre}user` ADD `user_wx_openid` VARCHAR( 50 ) NOT NULL AFTER `user_ip`");
}
$info = $db->num_rows($db->query("desc `{$pre}user` `user_city`"));
if ($info) {
	$db->query("ALTER TABLE `{$pre}user` DROP `user_city`");
}
$db->query("ALTER TABLE `{$pre}user` ADD INDEX ( `user_name` )");
$db->query("ALTER TABLE `{$pre}user` ADD INDEX ( `user_wx_openid` )");
//更新缓存
cache_write();
//$db->sql();
die("PHPSHE1.4 -> 1.5版本数据库升级完成，共更新".count($db->sql)."条SQL");
?>