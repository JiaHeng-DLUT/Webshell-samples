<?php
include('../../common.php');
pe_lead('hook/cache.hook.php');
$pre = dbpre;
//更新cart表
$db->query("ALTER TABLE `".dbpre."cart` ADD `prorule_id` VARCHAR( 30 ) NOT NULL COMMENT '规格id组合' AFTER `product_num`");
//更新iplog表
$sql = <<<html
CREATE TABLE IF NOT EXISTS `{$pre}iplog` (
  `iplog_id` int(10) unsigned NOT NULL auto_increment COMMENT 'ip记录id',
  `iplog_ip` char(15) NOT NULL COMMENT 'ip记录ip',
  `iplog_ipname` varchar(20) NOT NULL COMMENT '验证码上传省份',
  `iplog_atime` int(10) unsigned NOT NULL default '0' COMMENT 'ip记录时间',
  `iplog_adate` date NOT NULL COMMENT 'ip记录日期',
  PRIMARY KEY  (`iplog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
html;
$db->query($sql);
//更新orderdata表
$db->query("ALTER TABLE `".dbpre."orderdata` ADD `product_logo` VARCHAR( 200 ) NOT NULL COMMENT '商品logo' AFTER `product_name`");
$db->query("ALTER TABLE `".dbpre."orderdata` CHANGE `product_smoney` `product_money` DECIMAL( 10, 1 ) NOT NULL DEFAULT '0.0'");
$db->query("ALTER TABLE `".dbpre."orderdata` ADD `prorule_id` VARCHAR( 30 ) NOT NULL COMMENT '规格id组合' AFTER `product_num`");
$db->query("ALTER TABLE `".dbpre."orderdata` ADD `prorule_name` VARCHAR( 255 ) NOT NULL COMMENT '规格名称组合' AFTER `prorule_id`");
//更新payway表
$db->query("INSERT INTO `".dbpre."payway` (`payway_id`, `payway_name`, `payway_mark`, `payway_logo`, `payway_model`, `payway_config`, `payway_text`, `payway_order`, `payway_state`) VALUES (NULL, '货到付款', 'cod', 'include/plugin/payway/cod/logo.gif 	', '', '', '送货上门后再收款，支持现金、POS机刷卡、支票支付', '0', '1')");
//更新product表
$db->query("ALTER TABLE `".dbpre."product` CHANGE `product_smoney` `product_money` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '商品商城价'");
$db->query("ALTER TABLE `".dbpre."product` CHANGE `product_mmoney` `product_smoney` DECIMAL( 10, 1 ) UNSIGNED NOT NULL DEFAULT '0.0' COMMENT '商品市场价'");
$db->query("ALTER TABLE `".dbpre."product` MODIFY COLUMN `product_money`  decimal(10,1) UNSIGNED NOT NULL DEFAULT 0.0 COMMENT '商品商城价' AFTER `product_logo`");
$db->query("ALTER TABLE `pe_product` ADD `rule_id` VARCHAR( 30 ) NOT NULL COMMENT '商品规格id' AFTER `category_id`");
//更新prorule表
$sql = <<<html
CREATE TABLE IF NOT EXISTS `{$pre}prorule` (
  `prorule_id` varchar(30) NOT NULL COMMENT '规格id组合',
  `product_money` decimal(10,1) unsigned NOT NULL default '0.0' COMMENT '规格价格',
  `product_num` smallint(5) unsigned NOT NULL default '0' COMMENT '规格数量',
  `product_id` int(10) unsigned NOT NULL default '0' COMMENT '商品id',
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
html;
$db->query($sql);
//更新rule表
$sql = <<<html
CREATE TABLE IF NOT EXISTS `{$pre}rule` (
  `rule_id` smallint(5) unsigned NOT NULL auto_increment COMMENT '规格id',
  `rule_name` varchar(20) NOT NULL COMMENT '规格名称',
  `rule_memo` varchar(20) NOT NULL COMMENT '规格备注',
  PRIMARY KEY  (`rule_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
html;
$db->query($sql);
//更新ruledata表
$sql = <<<html
CREATE TABLE IF NOT EXISTS `{$pre}ruledata` (
  `ruledata_id` smallint(5) unsigned NOT NULL auto_increment COMMENT '规格值id',
  `ruledata_name` varchar(20) NOT NULL COMMENT '规格值名',
  `ruledata_logo` varchar(100) NOT NULL COMMENT '规格值图',
  `ruledata_order` smallint(5) unsigned NOT NULL default '0' COMMENT '规格值排序',
  `rule_id` smallint(5) unsigned NOT NULL default '0' COMMENT '规格id',
  PRIMARY KEY  (`ruledata_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;
html;
$db->query($sql);
cache_write();
die("PHPSHE1.1 -> 1.2版本数据库升级完成，总计耗时0.1秒");
?>