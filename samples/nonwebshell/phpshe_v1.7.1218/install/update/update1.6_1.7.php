<?php
set_time_limit(0);
include('../../common.php');
pe_lead('hook/cache.hook.php');
$pre = dbpre;
//更新product表
$db->query("ALTER TABLE `{$pre}product` ADD `product_guid` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `product_id`");
$db->query("ALTER TABLE `{$pre}product` ADD `prokey_type` VARCHAR( 10 ) NOT NULL COMMENT  '点卡发放类型' AFTER  `product_rule`");
$db->query("ALTER TABLE `{$pre}product` ADD `prokey_user` VARCHAR( 50 ) NOT NULL COMMENT  '点卡帐号' AFTER  `prokey_type`");
$db->query("ALTER TABLE `{$pre}product` ADD `prokey_pw` VARCHAR( 50 ) NOT NULL COMMENT  '点卡密码' AFTER  `prokey_user`");
$db->query("ALTER TABLE `{$pre}product` ADD `prokey_edate` DATE NOT NULL COMMENT  '卡点有效期' AFTER  `prokey_pw`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_type` VARCHAR( 10 ) NOT NULL DEFAULT 'normal' COMMENT '商品类型' AFTER `product_guid`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_hd_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '活动id' AFTER  `product_commentstar`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_hd_type` VARCHAR( 10 ) NOT NULL COMMENT  '活动类型' AFTER  `product_hd_id`");
$db->query("ALTER TABLE `{$pre}product` CHANGE `product_hd_id`  `huodong_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '活动id' after `prokey_edate`");
$db->query("ALTER TABLE `{$pre}product` CHANGE `product_hd_type`  `huodong_type` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '活动类型' after `huodong_id`");
$db->query("ALTER TABLE `{$pre}product` CHANGE `product_hd_tag`  `huodong_tag` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '活动标签' after `huodong_type`");
$db->query("ALTER TABLE `{$pre}product` CHANGE `product_hd_stime`  `huodong_stime` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '活动开始时间' after `huodong_tag`");
$db->query("ALTER TABLE `{$pre}product` CHANGE `product_hd_etime`  `huodong_etime` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '活动结束时间' after `huodong_stime`");
$db->query("ALTER TABLE `{$pre}product` DROP INDEX `product_hd_etime`");
$db->query("ALTER TABLE `{$pre}product` ADD INDEX ( `huodong_type` )");
//更新prokey表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}prokey` (
	  `prokey_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `prokey_user` varchar(50) NOT NULL,
	  `prokey_pw` varchar(50) NOT NULL,
	  `prokey_atime` int(10) unsigned NOT NULL DEFAULT '0',
	  `prokey_edate` date NOT NULL,
	  `prokey_state` varchar(10) NOT NULL DEFAULT 'new',
	  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `order_id` bigint(15) unsigned NOT NULL DEFAULT '0',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `user_name` varchar(20) NOT NULL,
	  PRIMARY KEY (`prokey_id`),
	  KEY `prokey_state` (`prokey_state`),
	  KEY `product_id` (`product_id`),
	  KEY `order_id` (`order_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新pintuan表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}pintuan` (
	  `pintuan_id` bigint(15) unsigned NOT NULL AUTO_INCREMENT,
	  `pintuan_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '拼团价',
	  `pintuan_num` smallint(5) unsigned NOT NULL DEFAULT '0',
	  `pintuan_atime` int(10) unsigned NOT NULL DEFAULT '0',
	  `pintuan_stime` int(10) unsigned NOT NULL DEFAULT '0',
	  `pintuan_etime` int(10) unsigned NOT NULL DEFAULT '0',
	  `pintuan_state` varchar(10) NOT NULL DEFAULT 'wtuan',
	  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `product_name` varchar(100) NOT NULL,
	  `product_logo` varchar(100) NOT NULL,
	  `product_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
	  `huodong_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `user_name` varchar(20) NOT NULL,
	  PRIMARY KEY (`pintuan_id`),
	  KEY `pintuan_state` (`pintuan_state`),
	  KEY `product_id` (`product_id`),
	  KEY `huodong_id` (`huodong_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新pintuanlog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}pintuanlog` (
	  `pintuanlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `pintuanlog_atime` int(10) unsigned NOT NULL DEFAULT '0',
	  `pintuan_id` bigint(15) unsigned NOT NULL DEFAULT '0',
	  `order_id` bigint(15) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `user_name` varchar(20) NOT NULL,
	  `user_logo` varchar(100) NOT NULL,
	  PRIMARY KEY (`pintuanlog_id`),
	  KEY `pintuan_id` (`pintuan_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新pointlog表
$db->query("ALTER TABLE `{$pre}pointlog` CHANGE `pointlog_in`  `pointlog_in` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '积分收入'");
$db->query("ALTER TABLE `{$pre}pointlog` CHANGE `pointlog_out`  `pointlog_out` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '积分支出'");
$db->query("ALTER TABLE `{$pre}pointlog` CHANGE `pointlog_now`  `pointlog_now` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '当前结余'");
//更新adminlevel表
$db->query("ALTER TABLE `{$pre}adminlevel` ADD `adminlevel_menumark` TEXT NOT NULL AFTER  `adminlevel_modact`");
//更新cart表
$db->query("DROP TABLE `{$pre}cart`"); 
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}cart` (
	  `cart_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `cart_act` varchar(10) NOT NULL DEFAULT 'cart' COMMENT '购买方式(cart加入购物车/buy立即购买)',
	  `cart_type` varchar(10) NOT NULL,
	  `cart_atime` int(10) unsigned NOT NULL DEFAULT '0',
	  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `product_guid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '唯一id',
	  `product_name` varchar(100) NOT NULL,
	  `product_rule` varchar(255) NOT NULL COMMENT '规格数据集',
	  `product_logo` varchar(100) NOT NULL,
	  `product_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
	  `product_num` smallint(5) unsigned NOT NULL DEFAULT '1',
	  `huodong_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `pintuan_id` bigint(15) unsigned NOT NULL DEFAULT '0',
	  `user_id` varchar(32) NOT NULL,
	  PRIMARY KEY (`cart_id`),
	  KEY `cart_type` (`cart_act`),
	  KEY `product_id` (`product_id`),
	  KEY `product_guid` (`product_guid`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新ad表
$db->query("ALTER TABLE `{$pre}ad` ADD `ad_type` VARCHAR( 10 ) NOT NULL DEFAULT  'pc' COMMENT  '广告类型(pc/h5)' AFTER  `ad_url`");
//更新setting表
$db->query("INSERT INTO `{$pre}setting` (`setting_key`, `setting_value`) VALUES ('wap_logo', ''),('web_checkphone', '1'), ('web_checkemail', '1'), ('wechat_admin_openid', '')");
$setting = $db->pe_select('setting', array('setting_key'=>'web_wlname'));
$web_wlname = $setting['setting_value'] ? unserialize($setting['setting_value']) : array();
$web_wlname = array_filter($web_wlname);
$db->pe_update('setting', array('setting_key'=>'web_wlname'), array('setting_value'=>implode(',', $web_wlname)));
//更新notice表
$db->query("ALTER TABLE `{$pre}notice` CHANGE `notice_mark`  `notice_type` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '通知类型'");
//更新huodong表
$db->query("ALTER TABLE  `{$pre}huodong` CHANGE  `huodong_name`  `huodong_desc` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '活动描述' AFTER `huodong_tag`");
$db->query("ALTER TABLE `{$pre}huodong` ADD `huodong_type` VARCHAR( 10 ) NOT NULL DEFAULT 'zhekou' COMMENT '活动类型(zhekou/pintuan)' AFTER `huodong_tag`");
//更新huodongdata表
$db->query("ALTER TABLE `{$pre}huodongdata` ADD `huodong_type` VARCHAR( 10 ) NOT NULL DEFAULT 'zhekou' COMMENT '活动类型(zhekou/pintuan)' AFTER `huodong_tag`");
$db->query("ALTER TABLE `{$pre}huodongdata` ADD `product_name` VARCHAR( 100 ) NOT NULL AFTER `product_id`");
$db->query("ALTER TABLE `{$pre}huodongdata` ADD `product_logo` VARCHAR( 100 ) NOT NULL AFTER `product_name`");
$db->query("ALTER TABLE `{$pre}huodongdata` ADD `product_smoney` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT  '0.0' AFTER  `product_logo`");
$db->query("ALTER TABLE `{$pre}huodongdata` CHANGE `huodong_money`  `product_money` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT  '0.0' AFTER `product_smoney`");
$db->query("ALTER TABLE `{$pre}huodongdata` CHANGE `huodong_zhe`  `product_zhe` FLOAT UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '折扣率' AFTER `product_money`");
$db->query("ALTER TABLE `{$pre}huodongdata` ADD `product_ptnum` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '拼团人数' AFTER `product_zhe`");
$db->query("update `{$pre}huodongdata` a left join `{$pre}product` b on a.`product_id` = b.`product_id` set a.product_name = b.product_name, a.product_logo = b.product_logo, a.product_smoney = b.product_smoney");
$db->query("update `{$pre}huodongdata` set product_money = product_smoney * product_zhe");
$db->query("ALTER TABLE  `{$pre}huodongdata` ADD INDEX (  `huodong_id` )");
$db->query("ALTER TABLE  `{$pre}huodongdata` ADD INDEX (  `product_id` )");
//更新payway表
$db->query("RENAME TABLE `{$pre}payway` TO  `{$pre}payment`");
$db->query("ALTER TABLE `{$pre}payment` CHANGE `payway_id`  `payment_id` TINYINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT");
$db->query("ALTER TABLE `{$pre}payment` CHANGE `payway_name`  `payment_name` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
$db->query("ALTER TABLE `{$pre}payment` CHANGE `payway_mark`  `payment_type` VARCHAR( 15 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
$db->query("ALTER TABLE `{$pre}payment` CHANGE `payway_logo`  `payment_logo` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
$db->query("ALTER TABLE `{$pre}payment` CHANGE `payway_model`  `payment_model` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
$db->query("ALTER TABLE `{$pre}payment` CHANGE `payway_config`  `payment_config` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
$db->query("ALTER TABLE `{$pre}payment` CHANGE `payway_text`  `payment_desc` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  '支付描述' AFTER `payment_type`");
$db->query("ALTER TABLE `{$pre}payment` CHANGE `payway_order`  `payment_order` TINYINT( 3 ) UNSIGNED NOT NULL DEFAULT  '0'");
$db->query("ALTER TABLE `{$pre}payment` CHANGE `payway_state`  `payment_state` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '1'");
$db->query("ALTER TABLE `{$pre}payment` DROP `payment_logo`");
//更新支付方式model
$info_list = pe_dirlist("{$pe['path_root']}include/plugin/payment/*");	
foreach ($info_list as $v) {
	$info = payment_info($v);
	$payment_model = $info['model'] ? serialize($info['model']) : '';
	$db->pe_update('payment', array('payment_type'=>$v), array('payment_model'=>pe_dbhold($payment_model, 'all')));
}
//更新order表
$db->query("ALTER TABLE `{$pre}order` ADD `order_type` VARCHAR( 10 ) NOT NULL COMMENT '订单类型(fixed/pintuan)' AFTER `order_outid`");
$db->query("ALTER TABLE `{$pre}order` ADD `order_virtual` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '是否虚拟商品订单' AFTER `order_type`");
$db->query("ALTER TABLE `{$pre}order` ADD `huodong_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '活动id' AFTER  `order_closetext`");
$db->query("ALTER TABLE `{$pre}order` ADD `pintuan_id` BIGINT( 15 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '拼团id' AFTER  `huodong_id`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_payway`  `order_payment` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'alipay_js' COMMENT  '支付方式类型'");
$db->query("ALTER TABLE `{$pre}order` ADD `order_payment_name` VARCHAR( 20 ) NOT NULL COMMENT  '支付方式名称' AFTER  `order_payment`");
$db->query("update `{$pre}order` a left join `{$pre}payment` b on a.order_payment = b.payment_type set a.order_payment_name = b.payment_name");
$db->query("update `{$pre}order` set order_type = 'fixed'");
//更新order_pay表
$db->query("ALTER TABLE `{$pre}order_pay` CHANGE `order_payway`  `order_payment` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  'alipay_js' COMMENT  '支付方式类型'");
$db->query("ALTER TABLE `{$pre}order_pay` ADD `order_payment_name` VARCHAR( 20 ) NOT NULL COMMENT  '支付方式名称' AFTER  `order_payment`");
$db->query("update `{$pre}order_pay` a left join `{$pre}payment` b on a.order_payment = b.payment_type set a.order_payment_name = b.payment_name");
//更新orderdata表
$db->query("ALTER TABLE `{$pre}orderdata` ADD `product_rule` VARCHAR( 255 ) NOT NULL AFTER  `product_name`");
$db->query("ALTER TABLE `{$pre}orderdata` ADD `product_allmoney` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' AFTER `product_money_yh`");
$db->query("update `{$pre}orderdata` set product_allmoney = product_money * product_num + product_money_yh, product_rule = prorule_name");
$db->query("ALTER TABLE `{$pre}orderdata` ADD `refund_id` BIGINT( 15 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `product_num`");
$db->query("ALTER TABLE `{$pre}orderdata` ADD `refund_state` VARCHAR( 10 ) NOT NULL AFTER `refund_id`");
$db->query("ALTER TABLE `{$pre}orderdata` CHANGE  `product_money_yh`  `product_jjmoney` DECIMAL( 10, 1 ) NOT NULL DEFAULT  '0.0' COMMENT  '加减价格'");
//更新comment表
$db->query("ALTER TABLE `{$pre}comment` ADD `comment_reply` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '是否回复(0/1)' AFTER  `comment_atime`");
$db->query("ALTER TABLE `{$pre}comment` ADD `comment_reply_text` TEXT NOT NULL COMMENT  '回复内容' AFTER  `comment_reply`");
$db->query("ALTER TABLE `{$pre}comment` ADD `comment_reply_time` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '回复时间' AFTER  `comment_reply_text`");
$db->query("ALTER TABLE `{$pre}comment` CHANGE `order_id`  `order_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT  '订单id' after comment_reply_time");
//更新user表
$db->query("ALTER TABLE `{$pre}user` CHANGE `user_pw` `user_pw` CHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登录密码'");
$db->query("ALTER TABLE `{$pre}user` ADD `user_paypw` CHAR( 32 ) NOT NULL COMMENT '支付密码' AFTER `user_pw`");
//更新userlevel表
$db->query("ALTER TABLE `{$pre}userlevel` CHANGE  `userlevel_up`  `userlevel_up` VARCHAR( 10 ) NOT NULL DEFAULT  'auto' COMMENT  '升级方式(auto自动/hand手动)'");
$db->query("update `{$pre}userlevel` set userlevel_up = 'auto' where userlevel_up = '1'");
$db->query("update `{$pre}userlevel` set userlevel_up = 'hand' where userlevel_up = '0'");
//更新refund表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}refund` (
	  `refund_id` bigint(15) unsigned NOT NULL,
	  `refund_outid` varchar(50) NOT NULL,
	  `refund_type` tinyint(3) unsigned NOT NULL DEFAULT '0',
	  `refund_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
	  `refund_product_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
	  `refund_wl_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
	  `refund_text` varchar(255) NOT NULL COMMENT '订单留言',
	  `refund_tname` varchar(10) NOT NULL,
	  `refund_phone` varchar(30) NOT NULL,
	  `refund_address` varchar(50) NOT NULL,
	  `refund_wl_name` varchar(20) NOT NULL,
	  `refund_wl_id` varchar(20) NOT NULL,
	  `refund_atime` int(10) unsigned NOT NULL DEFAULT '0',
	  `refund_ftime` int(10) unsigned NOT NULL DEFAULT '0',
	  `refund_state` varchar(10) NOT NULL DEFAULT 'wcheck',
	  `refund_pstate` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否付款(0未付款/1已付款)',
	  `refund_presult` varchar(50) NOT NULL,
	  `order_id` varchar(30) NOT NULL COMMENT '订单id',
	  `orderdata_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `product_guid` char(32) NOT NULL,
	  `product_name` varchar(50) NOT NULL,
	  `product_rule` varchar(255) NOT NULL,
	  `product_logo` varchar(200) NOT NULL,
	  `product_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
	  `product_jjmoney` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '商品加减价格',
	  `product_allmoney` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
	  `product_num` smallint(5) unsigned NOT NULL DEFAULT '0',
	  `user_id` int(10) unsigned NOT NULL,
	  `user_name` varchar(20) NOT NULL,
	  KEY `refund_id` (`refund_id`),
	  KEY `order_id` (`order_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
html;
$db->query($sql);
//更新refundlog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}refundlog` (
	  `refundlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `refundlog_atime` int(10) unsigned NOT NULL DEFAULT '0',
	  `refundlog_text` text NOT NULL,
	  `refund_id` bigint(15) unsigned NOT NULL DEFAULT '0',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
	  `user_name` varchar(20) NOT NULL,
	  PRIMARY KEY (`refundlog_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新refund_addr表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}refund_addr` (
	  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `address_order` int(10) unsigned NOT NULL DEFAULT '0',
	  `refund_tname` varchar(10) NOT NULL,
	  `refund_phone` varchar(30) NOT NULL,
	  `refund_address` varchar(100) NOT NULL,
	  PRIMARY KEY (`address_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新sign表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}sign` (
	  `key` varchar(20) NOT NULL,
	  `value` text NOT NULL,
	  KEY `setting_key` (`key`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
html;
$db->query($sql);
$db->query("INSERT INTO `{$pre}sign` (`key`, `value`) VALUES ('sign_state', '0'),('sign_text', ''),('sign_point', '10'),('sign_point_shouci', '10'),('sign_point_lianxu', ''),('sign_point_leiji', '')");
//更新signlog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}signlog` (
	  `signlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
	  `signlog_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '奖励积分',
	  `signlog_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '签到时间',
	  `signlog_adate` date NOT NULL COMMENT '签到日期',
	  `signlog_month` char(7) NOT NULL COMMENT '签到月份',
	  `signlog_lx_day` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '连续签到天数',
	  `signlog_lj_day` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '累计签到天数',
	  `signlog_ip` char(15) NOT NULL COMMENT '签到者ip',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
	  `user_name` varchar(20) NOT NULL COMMENT '用户名',
	  `user_logo` varchar(100) NOT NULL,
	  PRIMARY KEY (`signlog_id`),
	  KEY `signlog_adate` (`signlog_adate`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新signlog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}signlog` (
	  `signlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
	  `signlog_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '奖励积分',
	  `signlog_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '签到时间',
	  `signlog_adate` date NOT NULL COMMENT '签到日期',
	  `signlog_month` char(7) NOT NULL COMMENT '签到月份',
	  `signlog_lx_day` smallint(5) unsigned NOT NULL DEFAULT '1' COMMENT '连续签到天数',
	  `signlog_lj_day` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '累计签到天数',
	  `signlog_ip` char(15) NOT NULL COMMENT '签到者ip',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
	  `user_name` varchar(20) NOT NULL COMMENT '用户名',
	  `user_logo` varchar(100) NOT NULL,
	  PRIMARY KEY (`signlog_id`),
	  KEY `signlog_adate` (`signlog_adate`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新wechat_notice表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}wechat_notice` (
	  `notice_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '通知记录id',
	  `notice_name` varchar(20) NOT NULL,
	  `notice_type` varchar(20) NOT NULL,
	  `notice_obj` varchar(5) NOT NULL,
	  `notice_tpl` varchar(50) NOT NULL,
	  `notice_tplid` varchar(100) NOT NULL,
	  `notice_industry1` varchar(20) NOT NULL DEFAULT 'IT科技',
	  `notice_industry2` varchar(20) NOT NULL DEFAULT '互联网|电子商务',
	  `notice_example` text NOT NULL,
	  `notice_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  PRIMARY KEY (`notice_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
$sql = <<<html
	INSERT INTO `{$pre}wechat_notice` (`notice_id`, `notice_name`, `notice_type`, `notice_obj`, `notice_tpl`, `notice_tplid`, `notice_industry1`, `notice_industry2`, `notice_example`, `notice_state`) VALUES
	(1, '用户下单', 'order_add', 'user', 'OPENTM202297555', '', 'IT科技', '互联网|电子商务', '亲，您的订单已创建成功，请及时付款\r\n订单号：180621101215088\r\n商品名称：iPhoneX 64GB 深空灰色\r\n订购数量：1台\r\n订单总额：5980元\r\n付款方式：微信支付\r\n', 0),
	(2, '订单付款', 'order_pay', 'user', 'OPENTM202183094', '', 'IT科技', '互联网|电子商务', '亲，您的订单已支付成功，正在为您备货，请耐心等待\r\n付款金额：5980元\r\n商品详情：iPhoneX 64GB 深空灰色\r\n支付方式：微信支付\r\n交易单号：180621101215088\r\n交易时间：2018年6月26日 18:36', 0),
	(3, '订单发货', 'order_send', 'user', 'OPENTM410090504', '', 'IT科技', '互联网|电子商务', '亲，您的订单已发货，请注意查收\r\n商品详情：iPhoneX 64GB 深空灰色\r\n发货时间：2018年6月26日 18:36\r\n物流公司：顺丰快递\r\n快递单号：123456789\r\n收货地址：河南省灵宝市新华路简好网络\r\n', 0),
	(4, '订单关闭', 'order_close', 'user', 'OPENTM408744504', '', 'IT科技', '互联网|电子商务', '亲，您的订单已被关闭\r\n商品名称：iPhoneX 64GB 深空灰色\r\n订单编号：180621101215088\r\n关闭原因：超时未付款', 0),
	(5, '用户下单', 'order_add', 'admin', 'OPENTM202297555', '', 'IT科技', '互联网|电子商务', '您好，您收到了一个新订单\r\n订单号：180621101215088\r\n商品名称：iPhoneX 64GB 深空灰色\r\n订购数量：1台\r\n订单总额：5980元\r\n付款方式：微信支付\r\n付款状态：未支付', 0),
	(6, '订单付款', 'order_pay', 'admin', 'OPENTM400255038', '', 'IT科技', '互联网|电子商务', '您好，您有一笔订单收款成功\r\n客户账号：简好网络\r\n订单编号：180621101215088\r\n付款金额：5980元\r\n付款时间：2018年6月26日 18:36\r\n商品信息：iPhoneX 64GB 深空灰色\r\n', 0);
html;
$db->query($sql);
//更新wechat_noticelog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}wechat_noticelog` (
	  `noticelog_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '通知记录id',
	  `noticelog_tpl` varchar(50) NOT NULL,
	  `noticelog_tplid` varchar(100) NOT NULL,
	  `noticelog_name` varchar(100) NOT NULL COMMENT '通知名称',
	  `noticelog_data` text NOT NULL COMMENT '通知内容',
	  `noticelog_url` varchar(100) NOT NULL,
	  `noticelog_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
	  `noticelog_stime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '通知时间',
	  `noticelog_state` varchar(10) NOT NULL DEFAULT 'new' COMMENT '通知状态',
	  `noticelog_error` varchar(50) NOT NULL COMMENT '失败提醒',
	  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
	  `user_name` varchar(20) NOT NULL COMMENT '用户名',
	  `user_wx_openid` varchar(50) NOT NULL,
	  PRIMARY KEY (`noticelog_id`),
	  KEY `noticelog_state` (`noticelog_state`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新yzmlog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}yzmlog` (
	  `yzmlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
	  `yzmlog_user` varchar(30) NOT NULL COMMENT '接受用户',
	  `yzmlog_value` varchar(10) NOT NULL COMMENT '验证码值',
	  `yzmlog_state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '验证码状态(0待验证/1已验证)',
	  `yzmlog_ip` char(15) NOT NULL COMMENT '验证码发送ip',
	  `yzmlog_sessid` varchar(50) NOT NULL COMMENT '发送用户sessionid',
	  `yzmlog_url` varchar(255) NOT NULL COMMENT '发送来源',
	  `yzmlog_checknum` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '验证码检测失败次数',
	  `yzmlog_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '验证码时间',
	  `yzmlog_adate` date NOT NULL,
	  PRIMARY KEY (`yzmlog_id`),
	  KEY `yzmlog_user` (`yzmlog_user`),
	  KEY `yzmlog_adate` (`yzmlog_adate`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//获取支付插件信息
function payment_info($type) {
	global $pe;
	$file = "{$pe['path_root']}include/plugin/payment/{$type}/install.php";
	if (is_file($file)) {
		$info = include($file);
		if ($info['type'] == $type && $info['name']) return $info;	
	}
	return array();
}
//更新prodata表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}prodata` (
	  `product_guid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品规格id',
	  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
	  `product_ruleid` varchar(30) NOT NULL COMMENT '规格id组合',
	  `product_rulename` varchar(50) NOT NULL COMMENT '规格名组合',
	  `product_rule` varchar(255) NOT NULL COMMENT '规格数据集',
	  `product_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '真实售价（有活动即活动价）',
	  `product_smoney` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '商城价',
	  `product_mmoney` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '市场价',
	  `product_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '剩余库存',
	  `product_order` tinyint(3) unsigned NOT NULL DEFAULT '1',
	  PRIMARY KEY (`product_guid`),
	  KEY `product_id` (`product_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
html;
$db->query($sql);
$db->query("insert into `{$pre}prodata` select prorule_id,product_id,prorule_key,prorule_name,'',product_money,product_smoney,product_mmoney,product_num,0 from `{$pre}prorule` order by prorule_id asc");
$product_list = $db->pe_selectall('product', '', 'product_id, product_rule, product_money, product_smoney, product_num');
$prodata_list = $db->index('product_id|product_guid')->pe_selectall('prodata', array('order by'=>'product_guid asc'));
foreach ($product_list as $v) {
	$sql_set = NUll;
	if ($v['product_rule'] && is_array($prodata_list[$v['product_id']])) {
		$rule_list = unserialize($v['product_rule']);
		$ordernum = 1;
		foreach ($prodata_list[$v['product_id']] as $vv) {
			$rulename = $vv['product_rulename'] ? explode(',', $vv['product_rulename']) : array();
			$rule_arr = array();
			foreach ($rule_list as $index=>$rule) {
				$rule_arr[] = array('name'=>$rule['name'], 'value'=>$rulename[$index]);
			}
			$sql_set['product_rule'] = pe_dbhold(serialize($rule_arr), 'all');
			$sql_set['product_order'] = $ordernum++;
			$db->pe_update('prodata', array('product_guid'=>$vv['product_guid']), $sql_set);
		}
	}
	else {
		$sql_set['product_id'] = $v['product_id'];
		$sql_set['product_money'] = $v['product_money'];
		$sql_set['product_smoney'] = $v['product_smoney'];
		$sql_set['product_num'] = $v['product_num'];
		$sql_set['product_order'] = 1;	
		$db->pe_insert('prodata', pe_dbhold($sql_set));
	}
}
$db->pe_update('product', '', "product_money = product_smoney, huodong_id = '', huodong_type = '', huodong_tag = '', huodong_stime = 0, huodong_etime = 0");
$db->pe_update('prodata', '', "product_money = product_smoney");
//删除passpay支付接口
$db->pe_delete('payment', array('payment_type'=>'passpay'));
//更新编码
$db->query("ALTER DATABASE `{$pe['db_name']}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
//更新缓存
cache_write();
//$db->sql();
die("PHPSHE1.6 -> 1.7版本数据库升级完成，共更新".count($db->sql)."条SQL");
?>
