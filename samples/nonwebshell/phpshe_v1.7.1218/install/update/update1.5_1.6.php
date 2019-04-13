<?php
include('../../common.php');
pe_lead('hook/cache.hook.php');
$pre = dbpre;
//更新cart表
$db->query("ALTER TABLE `{$pre}cart` ADD `cart_type` VARCHAR( 4 ) NOT NULL DEFAULT 'cart' COMMENT '购买类型(cart加入购物车/buy立即购买)' AFTER `cart_id`");
//更新comment表
$db->query("ALTER TABLE `{$pre}comment` ADD `comment_logo` TEXT NOT NULL COMMENT '评价晒图' AFTER `comment_text`");
$db->query("ALTER TABLE `{$pre}comment` ADD `user_logo` VARCHAR( 100 ) NOT NULL COMMENT '用户头像' AFTER `user_name`");
//更新express表
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}express` (
	  `express_id` smallint(5) unsigned NOT NULL auto_increment COMMENT '快递模板id',
	  `express_name` varchar(30) NOT NULL COMMENT '快递模板名',
	  `express_logo` varchar(100) NOT NULL COMMENT '快递模板logo',
	  `express_tag` text NOT NULL COMMENT '快递模板信息',
	  `express_width` int(10) unsigned NOT NULL,
	  `express_height` int(10) unsigned NOT NULL,
	  `express_width_px` int(10) unsigned NOT NULL default '0' COMMENT '像素宽',
	  `express_height_px` int(10) unsigned NOT NULL default '0' COMMENT '像素高',
	  `express_x` int(10) unsigned NOT NULL default '0' COMMENT 'x轴偏移量',
	  `express_y` int(10) unsigned NOT NULL default '0' COMMENT 'y轴偏移量',
	  `express_atime` int(10) unsigned NOT NULL default '0' COMMENT '添加时间',
	  `express_state` tinyint(1) unsigned NOT NULL default '1' COMMENT '启用状态',
	  `express_order` tinyint(3) unsigned NOT NULL default '255',
	  PRIMARY KEY  (`express_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新huodongdata表
$db->query("ALTER TABLE `{$pre}huodongdata` ADD `huodong_zhe` FLOAT UNSIGNED NOT NULL DEFAULT '0' COMMENT '折扣率' AFTER `huodong_etime`");
$db->query("TRUNCATE TABLE `{$pre}huodongdata`");
//更新product表
$db->query("ALTER TABLE `{$pre}product` CHANGE `product_name` `product_name` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品名称'");
$db->query("ALTER TABLE `{$pre}product` CHANGE `product_order` `product_order` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '10000' COMMENT '商品排序'");
$db->query("UPDATE `{$pre}product` set product_order = 10000 where product_order = 255");
//更新prorule表
$db->query("ALTER TABLE `{$pre}prorule` ADD `product_smoney` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '商城价' AFTER `product_money`");
$db->query("ALTER TABLE `{$pre}prorule` CHANGE `product_money` `product_money` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '商品商城价（有活动即活动价）'");
$db->query("UPDATE `{$pre}prorule` SET product_smoney = product_money");
//更新quan表
$db->query("ALTER TABLE `{$pre}quan` DROP `quan_key`");
$db->query("ALTER TABLE `{$pre}quan` ADD `quan_type` VARCHAR( 10 ) NOT NULL DEFAULT 'online' COMMENT '发放方式(online线上领取/offline线下发放)' AFTER `quan_name`");
//更新quanlog表
$db->query("ALTER TABLE `{$pre}quanlog` ADD INDEX ( `quanlog_state` )");
$db->query("ALTER TABLE `{$pre}quanlog` ADD INDEX ( `quan_id` )");
$db->query("ALTER TABLE `{$pre}quanlog` ADD INDEX ( `quan_key` )");
$db->query("ALTER TABLE `{$pre}quanlog` ADD INDEX ( `user_id` )");
//更新setting表
$db->query("INSERT INTO `{$pre}setting` (`setting_key`, `setting_value`) VALUES ('tg_state', '0'), ('tg_fc1', '0.05'), ('tg_fc2', '0.03'), ('tg_fc3', '0.02')");
//更新tguser表	
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}tguser` (
	  `tg_id` int(10) unsigned NOT NULL auto_increment COMMENT '自增id',
	  `tguser_id` int(10) unsigned NOT NULL default '0' COMMENT '推广用户id',
	  `tguser_name` varchar(20) NOT NULL COMMENT '推广用户名',
	  `tguser_level` tinyint(1) unsigned NOT NULL default '0' COMMENT '推广层级关系',
	  `user_id` int(10) unsigned NOT NULL default '0' COMMENT '用户id',
	  `user_name` varchar(20) NOT NULL COMMENT '用户名',
	  `user_atime` int(10) unsigned NOT NULL default '0' COMMENT '注册时间',
	  PRIMARY KEY  (`tg_id`),
	  KEY `tguser_id` (`tguser_id`),
	  KEY `user_id` (`user_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新user表
$db->query("ALTER TABLE `{$pre}user` ADD `user_money_cost` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '总消费额' AFTER `user_money`");
$db->query("ALTER TABLE `{$pre}user` ADD `user_money_tg` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '推广总收益' AFTER `user_money_cost`");
$db->query("ALTER TABLE `{$pre}user` ADD `userlevel_id` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '用户等级id' AFTER `user_wx_openid`");
$db->query("ALTER TABLE `{$pre}user` ADD `tguser_id` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '推广用户id' AFTER `userlevel_id`");
$db->query("ALTER TABLE `{$pre}user` ADD `tguser_name` VARCHAR( 20 ) NOT NULL COMMENT '推广用户名' AFTER `tguser_id`");
$db->query("ALTER TABLE `{$pre}user` ADD INDEX ( `tguser_id` )");
$db->query("UPDATE `{$pre}user` SET userlevel_id = 1");
//更新userlevel表	
$sql = <<<html
	CREATE TABLE IF NOT EXISTS `{$pre}userlevel` (
	  `userlevel_id` smallint(5) unsigned NOT NULL auto_increment COMMENT '自增id',
	  `userlevel_name` varchar(10) NOT NULL COMMENT '用户组名',
	  `userlevel_value` int(10) unsigned NOT NULL default '0' COMMENT '用户组最大值',
	  `userlevel_logo` varchar(100) NOT NULL COMMENT '用户组图标',
	  `userlevel_zhe` decimal(3,2) unsigned NOT NULL default '0.00' COMMENT '折扣率',
	  `userlevel_up` tinyint(1) unsigned NOT NULL default '1' COMMENT '自动升级(0否/1是)',
	  PRIMARY KEY  (`userlevel_id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;
html;
$db->query($sql);
$db->query("INSERT INTO `{$pre}userlevel` VALUES('1','注册用户','0','','1.00','1')");
//更新编码
$db->query("ALTER DATABASE `{$pe['db_name']}` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
//更新缓存
cache_write();
//$db->sql();
die("PHPSHE1.5 -> 1.6版本数据库升级完成，共更新".count($db->sql)."条SQL");
?>