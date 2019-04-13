<?php
include('../../common.php');
pe_lead('hook/cache.hook.php');
$pre = dbpre;
//更新brand表
$sql = <<<html
CREATE TABLE IF NOT EXISTS `{$pre}brand` (
  `brand_id` smallint(5) unsigned NOT NULL auto_increment,
  `brand_name` varchar(30) NOT NULL,
  `brand_logo` varchar(255) NOT NULL COMMENT '品牌图片',
  `brand_text` varchar(255) NOT NULL COMMENT '品牌介绍',
  `brand_word` char(1) NOT NULL COMMENT '品牌首字母',
  `brand_order` smallint(5) unsigned NOT NULL default '0',
  PRIMARY KEY  (`brand_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
//更新class表
$db->query("ALTER TABLE `".dbpre."class` ADD `class_type` VARCHAR( 10 ) NOT NULL DEFAULT 'news' COMMENT '分类类型' AFTER `class_name`");
$db->query("INSERT INTO `".dbpre."class`(`class_name`,`class_type`,`class_order`) VALUES('用户指南','help','0'),('配送方式','help','0'),('售后服务','help','0'),('关于我们','help','0')");
//更新comment表
$db->query("ALTER TABLE `".dbpre."comment` ADD `comment_star` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '5' COMMENT '评价星级' AFTER `comment_id`");
//更新menu表
$sql = <<<html
CREATE TABLE IF NOT EXISTS `{$pre}menu` (
  `menu_id` smallint(5) unsigned NOT NULL auto_increment COMMENT '导航id',
  `menu_name` varchar(20) NOT NULL COMMENT '导航名称',
  `menu_type` char(3) NOT NULL default 'sys' COMMENT '导航类型',
  `menu_url` varchar(50) NOT NULL COMMENT '导航链接',
  `menu_order` smallint(5) unsigned NOT NULL default '0' COMMENT '导航排序',
  PRIMARY KEY  (`menu_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;
html;
$db->query($sql);
$db->query("INSERT INTO `".dbpre."menu` (`menu_name`, `menu_type`, `menu_url`, `menu_order`) VALUES ('简好科技官网', 'diy', 'http://www.phpshe.com', 1)");
//更新payway表
$sql = <<<html
INSERT INTO `{$pre}payway` (`payway_id`, `payway_name`, `payway_mark`, `payway_logo`, `payway_model`, `payway_config`, `payway_text`, `payway_order`, `payway_state`) VALUES(4, '网银在线', 'ebank', '', 'a:2:{s:8:"ebank_id";a:2:{s:4:"name";s:9:"商户号";s:9:"form_type";s:4:"text";}s:9:"ebank_md5";a:2:{s:4:"name";s:9:"MD5私钥";s:9:"form_type";s:4:"text";}}', 'a:2:{s:8:"ebank_id";s:0:"";s:9:"ebank_md5";s:0:"";}', '网银在线（www.chinabank.com.cn）全面支持全国19家银行的信用卡及借记卡实现网上支付。', 0, 1);
html;
$db->query($sql);
$db->query("UPDATE `".dbpre."payway` SET `payway_name` = '线下转账/汇款' WHERE `pe_payway`.`payway_id` =2;");
//更新product表
$db->query("ALTER TABLE `".dbpre."product` CHANGE `product_logo` `product_logo` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '商品logo'");
$db->query("ALTER TABLE `".dbpre."product` ADD `product_commentrate` VARCHAR( 10 ) NOT NULL COMMENT '商品评价比例' AFTER `product_commentnum`, ADD `product_commentstar` INT( 10 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '商品评价星级' AFTER `product_commentrate`");
$db->query("ALTER TABLE `".dbpre."product` ADD `brand_id` SMALLINT( 5 ) UNSIGNED NOT NULL DEFAULT '0' COMMENT '品牌id' AFTER `category_id`");
$db->query("ALTER TABLE `".dbpre."product` ADD INDEX ( `brand_id` )");
//更新prorule表
$db->query("ALTER TABLE `".dbpre."prorule` CHANGE `product_money` `product_money` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '规格商城价'");
$db->query("ALTER TABLE `".dbpre."prorule` ADD `product_smoney` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '规格市场价' AFTER `product_money`");
//更新setting表
$db->query("INSERT INTO `".dbpre."setting` (`setting_key`, `setting_value`) VALUES ('email_smtp', ''), ('email_port', ''), ('email_name', ''), ('email_pw', ''), ('email_nname', '')");
$sql = <<<html
INSERT INTO `{$pre}setting` (`setting_key`, `setting_value`) VALUES ('web_wlname', 'a:15:{i:0;s:12:"顺丰快递";i:1;s:12:"申通快递";i:2;s:12:"圆通快递";i:3;s:12:"韵达快递";i:4;s:12:"中通快递";i:5;s:12:"天天快递";i:6;s:9:"宅急送";i:7;s:9:"EMS快递";i:8;s:12:"百事汇通";i:9;s:12:"全峰快递";i:10;s:12:"德邦物流";i:11;s:0:"";i:12;s:0:"";i:13;s:0:"";i:14;s:0:"";}');
html;
$db->query($sql);
cache_write();
die("PHPSHE1.2 -> 1.3版本数据库升级完成，总计耗时0.1秒");
?>