<?php
include('../../common.php');
pe_lead('hook/cache.hook.php');
$pre = dbpre;
//更新ad表
$db->query("ALTER TABLE `{$pre}ad` ADD `ad_state` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '1' COMMENT '广告显示状态' AFTER `ad_position`");
//更新admin表
$db->query("ALTER TABLE `{$pre}admin` ADD `adminlevel_id` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `admin_ltime`");
$db->query("UPDATE `{$pre}admin` SET `adminlevel_id` = '1'");
//更新adminlevel表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}adminlevel` (
	  `adminlevel_id` smallint(5) unsigned NOT NULL auto_increment COMMENT '管理等级id',
	  `adminlevel_name` varchar(20) NOT NULL COMMENT '管理等级名称',
	  `adminlevel_modact` text NOT NULL COMMENT '管理等级权限',
	  PRIMARY KEY  (`adminlevel_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql); 
$db->query("INSERT INTO `{$pre}adminlevel` (`adminlevel_id`, `adminlevel_name`, `adminlevel_modact`) VALUES(1, '总管理员', '')");
//更新cart表
$db->query("ALTER TABLE `{$pre}cart` CHANGE `prorule_id` `prorule_key` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规格id组合'");
//更新category表
$sql = <<<html
	ALTER TABLE `{$pre}category` ADD `category_title` VARCHAR( 100 ) NOT NULL AFTER `category_name` ,
	ADD `category_keys` VARCHAR( 255 ) NOT NULL AFTER `category_title` ,
	ADD `category_desc` VARCHAR( 255 ) NOT NULL AFTER `category_keys`
html;
$db->query($sql);
//更新comment表
$db->query("ALTER TABLE `{$pre}comment` ADD `order_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `product_id`");
//更新huodong表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}huodong` (
	  `huodong_id` int(10) unsigned NOT NULL auto_increment COMMENT '活动自增id',
	  `huodong_name` varchar(30) NOT NULL COMMENT '活动名称',
	  `huodong_tag` varchar(10) NOT NULL COMMENT '活动价格标签',
	  `huodong_atime` int(10) unsigned NOT NULL default '0' COMMENT '活动开始日期',
	  `huodong_stime` int(10) unsigned NOT NULL default '0',
	  `huodong_etime` int(10) unsigned NOT NULL default '0' COMMENT '活动结束日期',
	  PRIMARY KEY  (`huodong_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql); 
//更新huodongdata表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}huodongdata` (
	  `huodongdata_id` int(10) unsigned NOT NULL auto_increment,
	  `huodong_id` int(10) unsigned NOT NULL default '0',
	  `huodong_tag` varchar(10) NOT NULL,
	  `huodong_stime` int(10) unsigned NOT NULL default '0',
	  `huodong_etime` int(10) unsigned NOT NULL default '0',
	  `huodong_money` decimal(10,1) unsigned NOT NULL default '0.0',
	  `product_id` int(10) unsigned NOT NULL default '0',
	  PRIMARY KEY  (`huodongdata_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新iplog表
$db->query("ALTER TABLE `{$pre}iplog` ADD INDEX ( `iplog_ip` )");
$db->query("ALTER TABLE `{$pre}iplog` ADD INDEX ( `iplog_adate` )");
//更新notice表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}notice` (
	  `notice_id` int(10) unsigned NOT NULL auto_increment,
	  `notice_name` varchar(20) NOT NULL COMMENT '通知名称',
	  `notice_mark` varchar(20) NOT NULL COMMENT '通知标识',
	  `notice_obj` varchar(5) NOT NULL COMMENT '通知对象',
	  `notice_emailname` varchar(100) NOT NULL COMMENT '邮件标题',
	  `notice_emailtext` text NOT NULL COMMENT '邮件内容',
	  `notice_state` tinyint(1) unsigned NOT NULL default '0' COMMENT '通知状态',
	  PRIMARY KEY  (`notice_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9;
html;
$db->query($sql);
$sql = <<<html
	INSERT INTO `{$pre}notice` (`notice_id`, `notice_name`, `notice_mark`, `notice_obj`, `notice_emailname`, `notice_emailtext`, `notice_state`) VALUES
	(1, '用户注册', 'reg', 'user', '【注册通知】恭喜您成功注册PHPSHE商城', '<p>\r\n	尊敬的用户：\r\n</p>\r\n<p>\r\n	您好！欢迎您使用PHPSHE商城系统，您的用户名是：{user_name}。\r\n</p>', 1),
	(2, '用户下单', 'order_add', 'user', '【下单通知】您的订单：{order_id}提交成功，请及时付款！', '订单金额：{order_money}\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', 1),
	(3, '订单付款', 'order_pay', 'user', '【付款通知】您的订单：{order_id}已付款，感谢您的购买！', '<p>\r\n	付款金额：{order_money}\r\n</p>\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', 1),
	(4, '订单发货', 'order_send', 'user', '【发货通知】您的订单：{order_id}已发货', '您的订单：{order_id}已发货，快递公司：{order_wl_name}，运单编号：{order_wl_id}<span class="tag_gray fl mar5 mab5" style="line-height:20px;"></span>，如有问题请及时联系！', 1),
	(5, '订单关闭', 'order_close', 'user', '【订单关闭】您的订单：{order_id}已关闭', '订单金额：{order_money}\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', 1),
	(6, '用户下单', 'order_add', 'admin', '【下单通知】网店有新订单：{order_id}', '订单金额：{order_money}\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', 1),
	(7, '订单付款', 'order_pay', 'admin', '【付款通知】网店订单：{order_id}已付款', '<p>\r\n	付款金额：{order_money}\r\n</p>\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>\r\n<p>\r\n	请及时安排发货！\r\n</p>', 1),
	(8, '订单关闭', 'order_close', 'admin', '【订单关闭】网店订单：{order_id}已关闭', '订单金额：{order_money}\r\n<p>\r\n	收货姓名：{user_tname}\r\n</p>\r\n<p>\r\n	联系电话：{user_phone}\r\n</p>\r\n<p>\r\n	收货地址：{user_address}\r\n</p>\r\n<p>\r\n	<br />\r\n</p>', 1);
html;
$db->query($sql);
//更新noticelog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}noticelog` (
	  `noticelog_id` int(10) unsigned NOT NULL auto_increment COMMENT '通知记录id',
	  `noticelog_user` varchar(30) NOT NULL COMMENT '通知对象',
	  `noticelog_name` varchar(100) NOT NULL COMMENT '通知名称',
	  `noticelog_text` text NOT NULL COMMENT '通知内容',
	  `noticelog_atime` int(10) unsigned NOT NULL default '0' COMMENT '加入时间',
	  `noticelog_stime` int(10) unsigned NOT NULL default '0' COMMENT '通知时间',
	  `noticelog_state` tinyint(1) unsigned NOT NULL default '0' COMMENT '通知状态',
	  PRIMARY KEY  (`noticelog_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新order表
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_outid` `order_outid` BIGINT(15) UNSIGNED NOT NULL DEFAULT '0' AFTER `order_id`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_productmoney` `order_product_money` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0'");
$db->query("ALTER TABLE `{$pre}order` ADD `order_quan_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `order_product_money`");
$db->query("ALTER TABLE `{$pre}order` ADD `order_quan_name` VARCHAR( 30 ) NOT NULL AFTER `order_quan_id`");
$db->query("ALTER TABLE `{$pre}order` ADD `order_quan_money` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `order_quan_name`");
$db->query("ALTER TABLE `{$pre}order` ADD `order_point_get` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `order_quan_money`");
$db->query("ALTER TABLE `{$pre}order` ADD `order_point_use` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `order_point_get`");
$db->query("ALTER TABLE `{$pre}order` ADD `order_point_money` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' AFTER `order_point_use`");
$db->query("ALTER TABLE `{$pre}order` ADD `order_ftime` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '完成时间' AFTER `order_stime`");
$db->query("ALTER TABLE `{$pre}order` ADD `order_comment` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0' AFTER `order_payway`");
$db->query("ALTER TABLE `{$pre}order` ADD `order_closetext` VARCHAR( 255 ) NOT NULL COMMENT '订单关闭原因' AFTER `order_text`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_wlid` `order_wl_id` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `order_point_money`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_wlname` `order_wl_name` VARCHAR( 20 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `order_wl_id`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_wlmoney` `order_wl_money` DECIMAL( 5, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' AFTER `order_wl_name`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_id` `order_id` BIGINT( 15 ) UNSIGNED NOT NULL COMMENT '订单id'");
$db->query("ALTER TABLE `{$pre}orderdata` CHANGE `order_id` `order_id` BIGINT( 15 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '订单id'");
$db->query("ALTER TABLE `{$pre}order` DROP PRIMARY KEY");
$db->query("ALTER TABLE `{$pre}order` DROP INDEX `user_id`");
$db->query("ALTER TABLE `{$pre}order` ADD INDEX ( `order_id` )");
$db->query("ALTER TABLE `{$pre}order` ADD INDEX ( `user_id` )");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_state` `order_state` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'notpay' AFTER `order_comment`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_atime` `order_atime` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '下单时间' AFTER `order_wl_money`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_ptime` `order_ptime` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '付款时间' AFTER `order_atime`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_stime` `order_stime` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '发货时间' AFTER `order_ptime`");
$db->query("ALTER TABLE `{$pre}order` CHANGE `order_ftime` `order_ftime` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '完成时间' AFTER `order_stime`");
$db->query("update `{$pre}order` set order_ftime = order_stime where order_state = 'success'");
$db->query("ALTER TABLE `{$pre}orderdata` ADD `product_money_yh` DECIMAL( 10, 1 ) NOT NULL DEFAULT '0.0' AFTER `product_money`");
$db->query("ALTER TABLE `{$pre}orderdata` CHANGE `prorule_id` `prorule_key` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规格id组合'");
//更新pointlog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}pointlog` (
	  `pointlog_id` int(10) unsigned NOT NULL auto_increment,
	  `pointlog_type` varchar(10) NOT NULL COMMENT '积分类型',
	  `pointlog_in` smallint(5) unsigned NOT NULL default '0' COMMENT '积分收入',
	  `pointlog_out` smallint(5) unsigned NOT NULL default '0' COMMENT '积分支出',
	  `pointlog_now` smallint(5) unsigned NOT NULL default '0' COMMENT '当前结余',
	  `pointlog_atime` int(10) unsigned NOT NULL default '0' COMMENT '时间',
	  `pointlog_text` varchar(255) NOT NULL COMMENT '备注',
	  `user_id` int(10) unsigned NOT NULL default '0' COMMENT '用户id',
	  `user_name` varchar(20) NOT NULL COMMENT '用户名',
	  PRIMARY KEY  (`pointlog_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新product表
$db->query("ALTER TABLE `{$pre}product` ADD `product_keys` VARCHAR( 50 ) NOT NULL COMMENT '页面关键词' AFTER `product_text`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_desc` VARCHAR( 255 ) NOT NULL COMMENT '页面描述' AFTER `product_keys`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_mmoney` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '商品市场价' AFTER `product_smoney`");
$db->query("ALTER TABLE `{$pre}product` ADD INDEX ( `product_hd_etime` )");
$db->query("ALTER TABLE `{$pre}product` ADD `product_hd_tag` VARCHAR( 10 ) NOT NULL COMMENT '活动标签' AFTER `product_commentstar`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_hd_stime` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '活动开始时间' AFTER `product_hd_tag`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_hd_etime` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '活动结束时间' AFTER `product_hd_stime`");
$db->query("ALTER TABLE `{$pre}product` ADD `product_point` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '赠送积分' AFTER `product_wlmoney` ");
$db->query("UPDATE `{$pre}product` SET `product_mmoney` = `product_smoney`, `product_smoney` = `product_money`");
$db->query("ALTER TABLE `{$pre}product` CHANGE `product_smoney` `product_smoney` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '商品商城价'");
$db->query("ALTER TABLE `{$pre}product` CHANGE `product_money` `product_money` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '商品真实售价（有活动即活动价）'");
$db->query("ALTER TABLE `{$pre}product` ADD INDEX ( `product_hd_etime` )");
//更新prorule表
$db->query("ALTER TABLE `{$pre}prorule` CHANGE `prorule_id` `prorule_key` VARCHAR( 30 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '规格id组合'");
$db->query("ALTER TABLE `{$pre}prorule` ADD `prorule_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '商品规格id' FIRST,  ADD PRIMARY KEY (`prorule_id`)");
$db->query("ALTER TABLE `{$pre}prorule` CHANGE `product_smoney` `product_mmoney` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '规格市场价'");
$db->query("ALTER TABLE `{$pre}prorule` DROP INDEX `product_id`");
$db->query("ALTER TABLE `{$pre}prorule` ADD INDEX ( `product_id` )");
//更新quan表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}quan` (
	  `quan_id` int(10) unsigned NOT NULL auto_increment COMMENT '优惠券自增id',
	  `quan_key` char(10) NOT NULL,
	  `quan_name` varchar(30) NOT NULL COMMENT '优惠券名称',
	  `quan_money` int(10) unsigned NOT NULL default '0' COMMENT '优惠券面值',
	  `quan_limit` smallint(5) unsigned NOT NULL default '0' COMMENT '优惠券限制条件',
	  `quan_num` int(10) unsigned NOT NULL default '0' COMMENT '优惠券发行量',
	  `quan_num_get` int(10) unsigned NOT NULL default '0',
	  `quan_num_use` int(10) unsigned NOT NULL default '0',
	  `quan_atime` int(10) unsigned NOT NULL default '0' COMMENT '优惠券增加日期',
	  `quan_sdate` date NOT NULL COMMENT '优惠券开始日期',
	  `quan_edate` date NOT NULL COMMENT '优惠券结束日期',
	  `product_id` text NOT NULL COMMENT '商品id',
	  PRIMARY KEY  (`quan_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql); 
//更新quanlog表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}quanlog` (
	  `quanlog_id` int(10) unsigned NOT NULL auto_increment COMMENT '优惠券自增id',
	  `quanlog_atime` int(10) unsigned NOT NULL default '0' COMMENT '领取时间',
	  `quanlog_utime` int(10) unsigned NOT NULL default '0' COMMENT '使用时间',
	  `quanlog_state` tinyint(1) unsigned NOT NULL default '0' COMMENT '0未使用,1已使用,2过期',
	  `quan_id` int(10) unsigned NOT NULL default '0',
	  `quan_key` char(10) NOT NULL,
	  `quan_name` varchar(30) NOT NULL COMMENT '优惠券名称',
	  `quan_money` int(10) unsigned NOT NULL default '0' COMMENT '优惠券面值',
	  `quan_limit` smallint(5) unsigned NOT NULL default '0' COMMENT '优惠券限制条件',
	  `quan_sdate` date NOT NULL COMMENT '优惠券开始日期',
	  `quan_edate` date NOT NULL COMMENT '优惠券结束日期',
	  `product_id` text NOT NULL COMMENT '商品id',
	  `user_id` int(10) unsigned NOT NULL default '0',
	  `user_name` varchar(20) NOT NULL,
	  PRIMARY KEY  (`quanlog_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql); 
//更新setting表
$db->query("INSERT INTO `{$pre}setting` (`setting_key`, `setting_value`) VALUES ('email_admin', ''), ('web_guestbuy', '1'), ('web_hotword', 'PHPSHE,B2C商城系统,简好网络'), ('point_state', '1'), ('point_reg', '10'), ('point_comment', '50'), ('point_login', '2'), ('point_money', '100')");
$db->query("DELETE FROM `{$pre}setting` WHERE `setting_key` = 'web_weibo'");
//更新user表
$db->query("ALTER TABLE `{$pre}user` ADD `user_money` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '账户余额' AFTER `user_pw`");
$db->query("ALTER TABLE `{$pre}user` ADD `user_point` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '账户积分余额' AFTER `user_money`");
$db->query("ALTER TABLE `{$pre}user` ADD `user_point_all` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '累计获得积分' AFTER `user_point`");
$db->query("ALTER TABLE `{$pre}user` ADD `user_ip` CHAR( 15 ) NOT NULL COMMENT '用户注册ip' AFTER `user_address`");
//删除page表
$db->query("DROP TABLE `{$pre}page`");
//更新数据库备份文件命名
$backup_list = pe_dirlist("{$pe['path_root']}data/dbbackup/*");
foreach ((array)$backup_list as $v) {
	$dbname = str_ireplace('-', '', $v);
	@rename("{$pe['path_root']}data/dbbackup/{$v}", "{$pe['path_root']}data/dbbackup/{$dbname}");
}
//更新商品评价数和咨询数
pe_lead('hook/product.hook.php');
$info_list = $db->pe_selectall('product');
foreach ($info_list as $v) {
	product_num('commentnum', $v['product_id']);
	product_num('asknum', $v['product_id']);
}
//更新缓存
cache_write();
die("PHPSHE1.3 -> 1.4版本数据库升级完成，总计耗时0.1秒");
?>