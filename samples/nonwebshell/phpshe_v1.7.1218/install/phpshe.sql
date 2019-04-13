DROP TABLE IF EXISTS `{dbpre}ad`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}ad` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ad_logo` varchar(100) NOT NULL,
  `ad_url` varchar(100) NOT NULL,
  `ad_type` varchar(10) NOT NULL DEFAULT 'pc' COMMENT '广告类型(pc/h5)',
  `ad_position` varchar(15) NOT NULL,
  `ad_state` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '广告显示状态',
  `ad_order` int(10) unsigned NOT NULL DEFAULT '0',
  `category_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '分类id',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}ad` VALUES('18','data/attachment/2018-08/20180812190436q.jpg','','pc','index_jdt','1','3','0'),
('12','data/attachment/2018-08/20180812190103b.jpg','','pc','index_jdt','1','0','0'),
('16','data/attachment/2018-06/20180621172627w.jpg','','h5','index_jdt','1','0','0'),
('17','data/attachment/2018-08/20180812190305q.jpg','','pc','index_jdt','1','0','0');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}admin`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}admin` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理id',
  `admin_name` varchar(20) NOT NULL COMMENT '管理名',
  `admin_pw` varchar(32) NOT NULL COMMENT '管理密码',
  `admin_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理注册时间',
  `admin_ltime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '管理上次登录时间',
  `adminlevel_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}admin` VALUES('1','admin','21232f297a57a5a743894a0e4a801fc3','1269059337','1534420207','1');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}adminlevel`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}adminlevel` (
  `adminlevel_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '管理等级id',
  `adminlevel_name` varchar(20) NOT NULL COMMENT '管理等级名称',
  `adminlevel_modact` text NOT NULL COMMENT '管理等级权限',
  `adminlevel_menumark` text NOT NULL,
  PRIMARY KEY (`adminlevel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}adminlevel` VALUES('1','总管理员','','');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}article`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `article_name` varchar(100) NOT NULL,
  `article_text` text NOT NULL,
  `article_atime` int(10) unsigned NOT NULL DEFAULT '0',
  `article_clicknum` int(10) unsigned NOT NULL DEFAULT '0',
  `class_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`article_id`),
  KEY `class_id` (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}article` VALUES('1','关于简好','<p>
	<br />
</p>
<p style=\"color:#333333;font-family:微软雅黑;font-size:14px;background-color:#FFFFFF;\">
	灵宝简好网络科技有限公司，优秀的互联网平台与服务提供商，八年网站设计与开发经验，专业从事互联网软件开发等网络技术服务。自公司成立以来，简好网络始终秉承“产品简单好用，用心服务客户”的核心经营理念，在自主研发的创新之路稳健前行。&nbsp;
</p>
<p style=\"color:#333333;font-family:微软雅黑;font-size:14px;background-color:#FFFFFF;\">
	<br />
严谨的程序开发人员、专业的美工设计、良好的服务让我们在竞争激烈的互联网行业中蓬勃发展。通过我们多年在上百个不同行业领域的项目历练，加之对 各行业、各类型客户需求的理解，抛开炒作与虚夸，以一贯低调、踏实、诚信的风格为企、事业单位提供更好更实用的一站式网站建设服务！
</p>
<p style=\"color:#333333;font-family:微软雅黑;font-size:14px;background-color:#FFFFFF;\">
	<br />
简好网络坚信质量和信誉是我们存在的基石。我们注重客户提出的每个要求并充分考虑每一个细节，积极做好服务，不断地完善自己，通过不懈的努力，我们把每一 位客户都做成了朋友，感谢你们对简好网络的信任与支持，这种信任与支持激励着我们提供更优质的服务。在所有新老客户面前，我们都很乐意朴实的跟您接触，深 入的了解您的企业，每一次倾心的合作，都是一个全新的体会和挑战，我们随时与您同在。
</p>
<p style=\"color:#333333;font-family:微软雅黑;font-size:14px;background-color:#FFFFFF;\">
	<br />
</p>
<p style=\"color:#333333;font-family:微软雅黑;font-size:14px;background-color:#FFFFFF;\">
	详情请访问：<a href=\"http://www.phpshe.com/\" target=\"_blank\"><strong><span style=\"color:#E53333;\">简好网络官方网站</span></strong></a> 
</p>
<p>
	<br />
</p>
<p>
	<br />
</p>
<p>
	<a href=\"http://www.phpshe.com\" target=\"_blank\"><strong><span style=\"color:#E53333;\"></span></strong></a> 
</p>','1272676320','975','1'),
('2','PHPSHE B2C商城系统v1.7版演示站上线','<p>
	<strong>更新内容：</strong> 
</p>
<p>
	[新增]php7+版本支持
</p>
[新增]https支持<br />
[新增]领券中心<br />
[新增]折扣专题<br />
[新增]拼团专题<br />
[新增]签到有礼<br />
[新增]虚拟商品，支持固定卡密和批量导入卡密<br />
[新增]微信h5支付<br />
[新增]支付宝h5支付<br />
[新增]订单退款/退货+退货地址<br />
[新增]短信+邮件注册/短信+邮件找回密码<br />
[新增]总后台一键会员登录<br />
[新增]手动添加推荐人<br />
[新增]分销推荐人层级手动变更<br />
[新增]微信模板消息通知<br />
[新增]余额支付密码<br />
[新增]评价回复<br />
[优化]H5版界面及用户体验<br />
[优化]重新设计购物车和立即购买模块，算法更加严谨<br />
[优化]规格设计<br />
[优化]短信/邮件通知<br />
[优化]pc版界面在移动端显示不全<br />
[优化]微信头像显示黑色<br />
[优化]支付方式变更为插件形式安装<br />
<p>
	[优化]其他500多项细节优化
</p>
<p>
	<br />
</p>
<p>
	演示地址：<a href=\"http://www.phpshe.com/demo/phpshe/\" target=\"_blank\"><span style=\"color:#337FE5;\">http://www.phpshe.com/demo/phpshe/</span></a> 
</p>
<p>
	后台地址：<a href=\"http://www.phpshe.com/demo/phpshe/admin.php\" target=\"_blank\"><span style=\"color:#337FE5;\">http://www.phpshe.com/demo/phpshe/admin.php</span></a> 
</p>
<p>
	帐号密码：admin&nbsp;&nbsp;&nbsp;&nbsp; admin
</p>
<p>
	<br />
</p>
<p align=\"center\">
	页面预览：
</p>
<p align=\"center\">
	<img src=\"http://phpshe.com/data/attachment/2018-08/20180813122755o.jpg\" alt=\"\" title=\"\" width=\"750\" height=\"2482\" align=\"\" /> 
</p>
<p align=\"center\">
	<br />
</p>
<p align=\"center\">
	<img src=\"http://phpshe.com/data/attachment/2018-08/20180813122658m.jpg\" alt=\"\" title=\"\" width=\"750\" height=\"4261\" align=\"\" /> 
</p>
<p align=\"center\">
	<br />
</p>
<p align=\"center\">
	<img src=\"http://phpshe.com/data/attachment/2018-08/20180813122617s.jpg\" alt=\"\" title=\"\" width=\"750\" height=\"652\" align=\"\" /> 
</p>
<p align=\"center\">
	<br />
</p>
<p align=\"center\">
	<img src=\"http://phpshe.com/data/attachment/2018-08/20180813122857o.png\" alt=\"\" title=\"\" width=\"200\" height=\"356\" align=\"\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <img src=\"http://phpshe.com/data/attachment/2018-08/20180813122928i.jpg\" alt=\"\" title=\"\" width=\"200\" height=\"356\" align=\"\" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=\"http://phpshe.com/data/attachment/2018-08/20180813123003g.png\" alt=\"\" title=\"\" width=\"200\" height=\"356\" align=\"\" /> 
</p>','1335856260','905','1'),
('5','购物指南','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406563800','54','4'),
('6','支付方式','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564160','58','4'),
('7','常见问题','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564160','42','4'),
('8','配送时间及运费','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564220','294','5'),
('9','验货与签收','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564220','175','5'),
('10','订单查询','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564280','32','5'),
('11','售后政策','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564280','63','6'),
('12','退货说明','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564400','4','6'),
('13','取消订单','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564460','13','6'),
('14','公司简介','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564520','148','7'),
('15','联系我们','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564520','39','7'),
('16','诚聘英才','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1406564580','61','7'),
('17','货到付款','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1490769480','63','12'),
('18','在线支付','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1490769540','14','12'),
('19','邮局汇款','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1490769540','18','12'),
('20','公司转账','<a target=\"_blank\" href=\"http://www.phpshe.com\" title=\"PHPSHE/haoshop商城系统\">请在此填写相关内容</a>','1490769540','0','12');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}ask`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}ask` (
  `ask_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ask_text` text NOT NULL,
  `ask_atime` int(10) unsigned NOT NULL DEFAULT '0',
  `ask_replytext` text NOT NULL,
  `ask_replytime` int(10) unsigned NOT NULL DEFAULT '0',
  `ask_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL,
  `product_name` varchar(50) NOT NULL COMMENT '商品名称',
  `product_logo` varchar(100) NOT NULL COMMENT '商品logo',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(20) NOT NULL,
  `user_ip` char(15) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`ask_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}brand`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}brand` (
  `brand_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(30) NOT NULL,
  `brand_logo` varchar(255) NOT NULL COMMENT '品牌图片',
  `brand_text` varchar(255) NOT NULL COMMENT '品牌介绍',
  `brand_word` char(1) NOT NULL COMMENT '品牌首字母',
  `brand_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}cart`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}cart` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}cashout`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}cashout` (
  `cashout_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cashout_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
  `cashout_fee` decimal(5,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '提现手续费',
  `cashout_atime` int(10) unsigned NOT NULL DEFAULT '0',
  `cashout_ptime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '结算日期',
  `cashout_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cashout_ip` char(15) NOT NULL COMMENT '用户ip',
  `cashout_bankname` varchar(20) NOT NULL,
  `cashout_banknum` varchar(50) NOT NULL,
  `cashout_banktname` varchar(10) NOT NULL,
  `cashout_bankaddress` varchar(50) NOT NULL,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(30) NOT NULL,
  PRIMARY KEY (`cashout_id`),
  KEY `user_id` (`user_id`),
  KEY `cashout_state` (`cashout_state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}category`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}category` (
  `category_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `category_pid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `category_name` varchar(30) NOT NULL,
  `category_title` varchar(100) NOT NULL,
  `category_keys` varchar(255) NOT NULL,
  `category_desc` varchar(255) NOT NULL,
  `category_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}class`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}class` (
  `class_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(30) NOT NULL,
  `class_type` varchar(10) NOT NULL DEFAULT 'news' COMMENT '分类类型',
  `class_order` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}class` VALUES('1','网站公告','news','0'),
('2','新闻动态','news','1'),
('3','相关知识','news','2'),
('4','用户指南','help','1'),
('5','配送方式','help','2'),
('6','售后服务','help','4'),
('7','关于我们','help','5'),
('12','支付方式','help','3'),
('13','技术新闻','news','3');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}collect`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}collect` (
  `collect_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `collect_atime` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`collect_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}comment`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}comment` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '留言id',
  `comment_star` tinyint(1) unsigned NOT NULL DEFAULT '5' COMMENT '评价星级',
  `comment_text` text NOT NULL COMMENT '留言内容',
  `comment_logo` text NOT NULL COMMENT '评价晒图',
  `comment_atime` int(10) NOT NULL DEFAULT '0' COMMENT '留言时间',
  `comment_reply` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否回复(0/1)',
  `comment_reply_text` text NOT NULL COMMENT '回复内容',
  `comment_reply_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '回复时间',
  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `product_id` int(10) unsigned NOT NULL,
  `product_name` varchar(50) NOT NULL COMMENT '商品名称',
  `product_logo` varchar(100) NOT NULL COMMENT '商品logo',
  `user_id` int(10) unsigned NOT NULL COMMENT '接受方用户id',
  `user_name` varchar(20) NOT NULL,
  `user_logo` varchar(100) NOT NULL COMMENT '用户头像',
  `user_ip` char(15) NOT NULL DEFAULT '0.0.0.0',
  PRIMARY KEY (`comment_id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}express`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}express` (
  `express_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '快递模板id',
  `express_name` varchar(30) NOT NULL COMMENT '快递模板名',
  `express_logo` varchar(100) NOT NULL COMMENT '快递模板logo',
  `express_tag` text NOT NULL COMMENT '快递模板信息',
  `express_width` int(10) unsigned NOT NULL,
  `express_height` int(10) unsigned NOT NULL,
  `express_width_px` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '像素宽',
  `express_height_px` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '像素高',
  `express_x` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'x轴偏移量',
  `express_y` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'y轴偏移量',
  `express_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '添加时间',
  `express_state` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '启用状态',
  `express_order` tinyint(3) unsigned NOT NULL DEFAULT '255',
  PRIMARY KEY (`express_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}getpw`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}getpw` (
  `getpw_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `getpw_token` char(32) NOT NULL,
  `getpw_state` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `getpw_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '绑定日期',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(20) NOT NULL,
  PRIMARY KEY (`getpw_id`),
  KEY `getpw_token` (`getpw_token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}huodong`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}huodong` (
  `huodong_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '活动自增id',
  `huodong_tag` varchar(10) NOT NULL COMMENT '活动价格标签',
  `huodong_type` varchar(10) NOT NULL DEFAULT 'zhekou' COMMENT '活动类型(zhekou/pintuan)',
  `huodong_desc` varchar(30) NOT NULL COMMENT '活动描述',
  `huodong_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动开始日期',
  `huodong_stime` int(10) unsigned NOT NULL DEFAULT '0',
  `huodong_etime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动结束日期',
  PRIMARY KEY (`huodong_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}huodongdata`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}huodongdata` (
  `huodongdata_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `huodong_id` int(10) unsigned NOT NULL DEFAULT '0',
  `huodong_tag` varchar(10) NOT NULL,
  `huodong_type` varchar(10) NOT NULL COMMENT '活动类型(zhekou/pintuan)',
  `huodong_stime` int(10) unsigned NOT NULL DEFAULT '0',
  `huodong_etime` int(10) unsigned NOT NULL DEFAULT '0',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0',
  `product_name` varchar(100) NOT NULL,
  `product_logo` varchar(100) NOT NULL,
  `product_smoney` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
  `product_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
  `product_zhe` float unsigned NOT NULL DEFAULT '0' COMMENT '折扣率',
  `product_ptnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '拼团人数',
  PRIMARY KEY (`huodongdata_id`),
  KEY `huodong_id` (`huodong_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}iplog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}iplog` (
  `iplog_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ip记录id',
  `iplog_ip` char(15) NOT NULL COMMENT 'ip记录ip',
  `iplog_ipname` varchar(20) NOT NULL COMMENT '验证码上传省份',
  `iplog_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT 'ip记录时间',
  `iplog_adate` date NOT NULL COMMENT 'ip记录日期',
  PRIMARY KEY (`iplog_id`),
  KEY `iplog_ip` (`iplog_ip`),
  KEY `iplog_adate` (`iplog_adate`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}iplog` VALUES('1','::1','','1534420197','2018-08-16');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}link`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}link` (
  `link_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '友情链接id',
  `link_name` varchar(50) NOT NULL COMMENT '友情链接名称',
  `link_url` varchar(100) NOT NULL COMMENT '友情链接url',
  `link_order` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '友情链接排序',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}link` VALUES('1','简好网络官方网站','http://www.phpshe.com','1'),
('2','PHPSHE商城系统','http://www.phpshe.com/phpshe','2');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}menu`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}menu` (
  `menu_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '导航id',
  `menu_name` varchar(20) NOT NULL COMMENT '导航名称',
  `menu_type` char(3) NOT NULL DEFAULT 'sys' COMMENT '导航类型',
  `menu_url` varchar(50) NOT NULL COMMENT '导航链接',
  `menu_target` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '新标签打开',
  `menu_order` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '导航排序',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}menu` VALUES('1','品牌专区','sys','brand-list','0','1'),
('2','领券中心','sys','quan-list','0','2'),
('3','限时折扣','sys','huodong-zhekou','0','3'),
('4','限时拼团','sys','huodong-pintuan','0','4'),
('5','简好网络','diy','http://www.phpshe.com/','1','5'),
('6','购买授权','diy','http://www.phpshe.com/phpshe','1','6');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}moneylog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}moneylog` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}notice`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}notice` (
  `notice_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notice_name` varchar(20) NOT NULL COMMENT '通知名称',
  `notice_type` varchar(20) NOT NULL COMMENT '通知类型',
  `notice_obj` varchar(5) NOT NULL COMMENT '通知对象',
  `notice_sms_text` varchar(255) NOT NULL,
  `notice_sms_state` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `notice_email_name` varchar(100) NOT NULL COMMENT '邮件标题',
  `notice_email_text` text NOT NULL COMMENT '邮件内容',
  `notice_email_state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '通知状态',
  PRIMARY KEY (`notice_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}notice` VALUES('1','用户下单','order_add','user','下单通知：订单{order_id}提交成功，请及时付款！','0','下单通知：订单{order_id}提交成功，请及时付款！','<p>
	订单金额：{order_money}元
</p>
<p>
	收货姓名：{user_tname}
</p>
<p>
	联系电话：{user_phone}
</p>
<p>
	收货地址：{user_address}
</p>
<p>
	<br />
</p>','0'),
('2','订单付款','order_pay','user','付款通知：订单{order_id}付款成功，祝您生活愉快！','0','付款通知：订单{order_id}付款成功，祝您生活愉快！','<p>
	订单金额：{order_money}元
</p>
<p>
	收货姓名：{user_tname}
</p>
<p>
	联系电话：{user_phone}
</p>
<p>
	收货地址：{user_address}
</p>
<p>
	<br />
</p>','0'),
('3','订单发货','order_send','user','发货通知：订单{order_id}已发货，请注意接收！','0','发货通知：订单{order_id}已发货，请注意接收！','<p>
	快递公司：{order_wl_name}，运单编号：{order_wl_id}<span class=\"tag_gray fl mar5 mab5\" style=\"line-height:20px;\"></span>，如有问题请及时联系！
</p>','0'),
('4','订单关闭','order_close','user','关闭通知：订单{order_id}已关闭，原因：{order_closetext}','0','关闭通知：订单{order_id}已关闭，原因：{order_closetext}','订单金额：{order_money}元
<p>
	收货姓名：{user_tname}
</p>
<p>
	联系电话：{user_phone}
</p>
<p>
	收货地址：{user_address}
</p>
<p>
	<br />
</p>','0'),
('5','用户下单','order_add','admin','新订单通知：{order_id}，金额：{order_money}元，姓名：{user_tname}，电话：{user_phone}，备注：{order_text}，请注意查看！','0','新订单通知：{order_id}，金额：{order_money}元，姓名：{user_tname}，电话：{user_phone}，请注意查看！','<p>
	订单金额：{order_money}元
</p>
<p>
	收货姓名：{user_tname}
</p>
<p>
	联系电话：{user_phone}
</p>
<p>
	收货地址：{user_address}
</p>','0'),
('6','订单付款','order_pay','admin','付款通知：订单{order_id}付款成功，请及时安排发货！','0','付款通知：订单{order_id}付款成功，请及时安排发货！','<p>
	订单金额：{order_money}元
</p>
<p>
	收货姓名：{user_tname}
</p>
<p>
	联系电话：{user_phone}
</p>
<p>
	收货地址：{user_address}
</p>','0');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}noticelog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}noticelog` (
  `noticelog_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '通知记录id',
  `noticelog_type` varchar(5) NOT NULL DEFAULT 'email',
  `noticelog_user` varchar(30) NOT NULL COMMENT '通知对象',
  `noticelog_name` varchar(100) NOT NULL COMMENT '通知名称',
  `noticelog_text` text NOT NULL COMMENT '通知内容',
  `noticelog_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '录入时间',
  `noticelog_stime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '通知时间',
  `noticelog_state` varchar(10) NOT NULL DEFAULT 'new' COMMENT '通知状态',
  `noticelog_error` varchar(50) NOT NULL COMMENT '失败提醒',
  PRIMARY KEY (`noticelog_id`),
  KEY `noticelog_state` (`noticelog_state`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}order`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}order` (
  `order_id` bigint(15) unsigned NOT NULL COMMENT '订单id',
  `order_outid` varchar(50) NOT NULL COMMENT '第三方支付订单号',
  `order_type` varchar(10) NOT NULL COMMENT '订单类型(fixed/pintuan)',
  `order_virtual` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否虚拟商品订单',
  `order_name` varchar(50) NOT NULL,
  `order_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '订单金额',
  `order_product_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
  `order_quan_id` int(10) unsigned NOT NULL DEFAULT '0',
  `order_quan_name` varchar(30) NOT NULL,
  `order_quan_money` int(10) unsigned NOT NULL DEFAULT '0',
  `order_point_get` smallint(5) unsigned NOT NULL DEFAULT '0',
  `order_point_use` smallint(5) unsigned NOT NULL DEFAULT '0',
  `order_point_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
  `order_wl_id` varchar(20) NOT NULL,
  `order_wl_name` varchar(20) NOT NULL,
  `order_wl_money` decimal(5,1) unsigned NOT NULL DEFAULT '0.0',
  `order_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `order_ptime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '付款时间',
  `order_stime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发货时间',
  `order_ftime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '完成时间',
  `order_payment` varchar(10) NOT NULL DEFAULT 'alipay_js' COMMENT '支付方式类型',
  `order_payment_name` varchar(20) NOT NULL COMMENT '支付方式名称',
  `order_comment` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `order_state` varchar(10) NOT NULL DEFAULT 'wpay',
  `order_pstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '付款状态',
  `order_sstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '发货状态',
  `order_text` varchar(255) NOT NULL COMMENT '订单留言',
  `order_closetext` varchar(255) NOT NULL COMMENT '订单关闭原因',
  `huodong_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动id',
  `pintuan_id` bigint(15) unsigned NOT NULL DEFAULT '0' COMMENT '拼团id',
  `user_id` int(10) unsigned NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `user_tname` varchar(10) NOT NULL,
  `user_phone` char(11) NOT NULL COMMENT '用户手机',
  `user_tel` varchar(20) NOT NULL,
  `user_address` varchar(255) NOT NULL COMMENT '用户地址',
  KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}order_pay`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}order_pay` (
  `order_id` varchar(25) NOT NULL COMMENT '订单id',
  `order_outid` varchar(50) NOT NULL,
  `order_name` varchar(50) NOT NULL,
  `order_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '订单金额',
  `order_state` varchar(10) NOT NULL DEFAULT 'wpay',
  `order_payment` varchar(10) NOT NULL DEFAULT 'alipay_js' COMMENT '支付方式类型',
  `order_payment_name` varchar(20) NOT NULL COMMENT '支付方式名称',
  `order_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '下单时间',
  `order_ptime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '付款时间',
  `order_pstate` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '付款状态',
  `user_id` int(10) unsigned NOT NULL,
  `user_name` varchar(20) NOT NULL,
  KEY `order_id` (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}orderdata`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}orderdata` (
  `orderdata_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单数据id',
  `order_id` bigint(15) unsigned NOT NULL DEFAULT '0' COMMENT '订单id',
  `product_guid` char(32) NOT NULL COMMENT '唯一id',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  `product_name` varchar(50) NOT NULL COMMENT '订单名称',
  `product_rule` varchar(255) NOT NULL,
  `product_logo` varchar(200) NOT NULL COMMENT '商品logo',
  `product_money` decimal(10,1) NOT NULL DEFAULT '0.0',
  `product_jjmoney` decimal(10,1) NOT NULL DEFAULT '0.0' COMMENT '加减价格',
  `product_allmoney` decimal(10,1) unsigned NOT NULL DEFAULT '0.0',
  `product_num` smallint(5) unsigned NOT NULL,
  `refund_id` bigint(15) unsigned NOT NULL DEFAULT '0',
  `refund_state` varchar(10) NOT NULL,
  `prorule_key` varchar(30) NOT NULL COMMENT '规格id组合',
  `prorule_name` varchar(255) NOT NULL COMMENT '规格名称组合',
  PRIMARY KEY (`orderdata_id`),
  KEY `order_id` (`order_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}payment`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}payment` (
  `payment_id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `payment_name` varchar(10) NOT NULL,
  `payment_type` varchar(15) NOT NULL,
  `payment_desc` varchar(255) NOT NULL COMMENT '支付描述',
  `payment_model` text NOT NULL,
  `payment_config` text NOT NULL,
  `payment_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `payment_state` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`payment_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}payment` VALUES('1','余额支付','balance','使用帐户余额支付，只有会员才能使用。','','','0','1'),
('2','支付宝','alipay','即时到帐接口，买家交易金额直接转入卖家支付宝账户。','a:5:{s:10:\"alipay_pid\";a:2:{s:4:\"name\";s:18:\"合作者身份Pid\";s:4:\"type\";s:4:\"text\";}s:10:\"alipay_key\";a:2:{s:4:\"name\";s:18:\"安全校验码Key\";s:4:\"type\";s:4:\"text\";}s:12:\"alipay_appid\";a:2:{s:4:\"name\";s:20:\"支付宝应用APPid\";s:4:\"type\";s:4:\"text\";}s:17:\"alipay_public_key\";a:2:{s:4:\"name\";s:15:\"支付宝公钥\";s:4:\"type\";s:8:\"textarea\";}s:21:\"alipay_my_private_key\";a:2:{s:4:\"name\";s:15:\"开发者私钥\";s:4:\"type\";s:8:\"textarea\";}}','a:5:{s:10:\"alipay_pid\";s:0:\"\";s:10:\"alipay_key\";s:0:\"\";s:12:\"alipay_appid\";s:0:\"\";s:17:\"alipay_public_key\";s:0:\"\";s:21:\"alipay_my_private_key\";s:0:\"\";}','0','1'),
('3','微信支付','wechat','用户使用微信扫码支付','a:3:{s:12:\"wechat_appid\";a:2:{s:4:\"name\";s:14:\"开发者AppID\";s:4:\"type\";s:4:\"text\";}s:12:\"wechat_mchid\";a:2:{s:4:\"name\";s:9:\"商户号\";s:4:\"type\";s:4:\"text\";}s:10:\"wechat_key\";a:2:{s:4:\"name\";s:9:\"API密钥\";s:4:\"type\";s:4:\"text\";}}','a:3:{s:12:\"wechat_appid\";s:0:\"\";s:12:\"wechat_mchid\";s:0:\"\";s:10:\"wechat_key\";s:0:\"\";}','0','1'),
('4','转账汇款','bank','通过线下汇款方式支付，汇款帐号：建设银行 621700254000005xxxx 刘某某','a:1:{s:9:\"bank_text\";a:2:{s:4:\"name\";s:12:\"收款信息\";s:4:\"type\";s:8:\"textarea\";}}','a:1:{s:9:\"bank_text\";s:168:\"请将款项汇款至以下账户：
建设银行 621700254000005xxxx 刘某某
工商银行 621700254000005xxxx 刘某某
农业银行 621700254000005xxxx 刘某某\";}','0','1'),
('5','货到付款','cod','送货上门后再收款，支持现金、POS机刷卡、支票支付','','','0','1');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}pintuan`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}pintuan` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}pintuanlog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}pintuanlog` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}pointlog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}pointlog` (
  `pointlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pointlog_type` varchar(10) NOT NULL COMMENT '积分类型',
  `pointlog_in` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分收入',
  `pointlog_out` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '积分支出',
  `pointlog_now` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '当前结余',
  `pointlog_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '时间',
  `pointlog_text` varchar(255) NOT NULL COMMENT '备注',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_name` varchar(20) NOT NULL COMMENT '用户名',
  PRIMARY KEY (`pointlog_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}prodata`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}prodata` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}product`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}product` (
  `product_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `product_guid` int(10) unsigned NOT NULL DEFAULT '0',
  `product_type` varchar(10) NOT NULL DEFAULT 'normal' COMMENT '商品类型',
  `product_name` varchar(100) NOT NULL COMMENT '商品名称',
  `product_text` text NOT NULL COMMENT '商品描述',
  `product_keys` varchar(50) NOT NULL COMMENT '页面关键词',
  `product_desc` varchar(255) NOT NULL COMMENT '页面描述',
  `product_logo` varchar(100) NOT NULL COMMENT '商品logo',
  `product_album` text NOT NULL COMMENT '商品相册',
  `product_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '商品商城价（有活动即活动价）',
  `product_smoney` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '商品商城价',
  `product_mmoney` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '商品市场价',
  `product_wlmoney` decimal(5,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '商品物流价',
  `product_point` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '赠送积分',
  `product_mark` varchar(20) NOT NULL COMMENT '商品货号',
  `product_weight` decimal(7,2) NOT NULL COMMENT '商品尺寸',
  `product_state` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '商品状态',
  `product_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品发布时间',
  `product_order` smallint(5) unsigned NOT NULL DEFAULT '10000' COMMENT '商品排序',
  `product_num` smallint(5) unsigned NOT NULL COMMENT '商品库存数',
  `product_sellnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品销售数',
  `product_clicknum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品点击数',
  `product_collectnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品收藏数',
  `product_asknum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品咨询数',
  `product_commentnum` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品评价数',
  `product_commentrate` varchar(10) NOT NULL COMMENT '商品评价比例',
  `product_commentstar` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品评价星级',
  `product_istuijian` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `product_rule` text NOT NULL COMMENT '规格数据集',
  `prokey_type` varchar(10) NOT NULL COMMENT '点卡发放类型',
  `prokey_user` varchar(50) NOT NULL COMMENT '点卡帐号',
  `prokey_pw` varchar(50) NOT NULL COMMENT '点卡密码',
  `prokey_edate` date NOT NULL COMMENT '卡点有效期',
  `huodong_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动id',
  `huodong_type` varchar(10) NOT NULL COMMENT '活动类型',
  `huodong_tag` varchar(10) NOT NULL COMMENT '活动标签',
  `huodong_stime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动开始时间',
  `huodong_etime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '活动结束时间',
  `category_id` smallint(5) unsigned NOT NULL COMMENT '商品分类id',
  `brand_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '品牌id',
  `rule_id` varchar(30) NOT NULL COMMENT '商品规格id',
  PRIMARY KEY (`product_id`),
  KEY `category_id` (`category_id`),
  KEY `brand_id` (`brand_id`),
  KEY `huodong_type` (`huodong_type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}prokey`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}prokey` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}prorule`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}prorule` (
  `prorule_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品规格id',
  `prorule_key` varchar(30) NOT NULL COMMENT '规格id组合',
  `prorule_name` varchar(50) NOT NULL COMMENT '规格名组合',
  `product_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '商品商城价（有活动即活动价）',
  `product_smoney` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '商城价',
  `product_mmoney` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '规格市场价',
  `product_num` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '规格数量',
  `product_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品id',
  PRIMARY KEY (`prorule_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}quan`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}quan` (
  `quan_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '优惠券自增id',
  `quan_name` varchar(30) NOT NULL COMMENT '优惠券名称',
  `quan_type` varchar(10) NOT NULL DEFAULT 'online' COMMENT '发放方式(online线上领取/offline线下发放)',
  `quan_money` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券面值',
  `quan_limit` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券限制条件',
  `quan_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券发行量',
  `quan_num_get` int(10) unsigned NOT NULL DEFAULT '0',
  `quan_num_use` int(10) unsigned NOT NULL DEFAULT '0',
  `quan_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券增加日期',
  `quan_sdate` date NOT NULL COMMENT '优惠券开始日期',
  `quan_edate` date NOT NULL COMMENT '优惠券结束日期',
  `product_id` text NOT NULL COMMENT '商品id',
  PRIMARY KEY (`quan_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}quanlog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}quanlog` (
  `quanlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '优惠券自增id',
  `quanlog_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '领取时间',
  `quanlog_utime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '使用日期',
  `quanlog_state` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '0未使用,1已使用,2过期',
  `quan_id` int(10) unsigned NOT NULL DEFAULT '0',
  `quan_key` char(10) NOT NULL,
  `quan_name` varchar(30) NOT NULL COMMENT '优惠券名称',
  `quan_money` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券面值',
  `quan_limit` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '优惠券限制条件',
  `quan_sdate` date NOT NULL COMMENT '优惠券开始日期',
  `quan_edate` date NOT NULL COMMENT '优惠券结束日期',
  `product_id` text NOT NULL COMMENT '商品id',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(20) NOT NULL,
  PRIMARY KEY (`quanlog_id`),
  KEY `quanlog_state` (`quanlog_state`),
  KEY `quan_id` (`quan_id`),
  KEY `quan_key` (`quan_key`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}refund`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}refund` (
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
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}refund_addr`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}refund_addr` (
  `address_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `address_order` int(10) unsigned NOT NULL DEFAULT '0',
  `refund_tname` varchar(10) NOT NULL,
  `refund_phone` varchar(30) NOT NULL,
  `refund_address` varchar(100) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}refundlog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}refundlog` (
  `refundlog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `refundlog_atime` int(10) unsigned NOT NULL DEFAULT '0',
  `refundlog_text` text NOT NULL,
  `refund_id` bigint(15) unsigned NOT NULL DEFAULT '0',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `user_name` varchar(20) NOT NULL,
  PRIMARY KEY (`refundlog_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}rule`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}rule` (
  `rule_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '规格id',
  `rule_name` varchar(20) NOT NULL COMMENT '规格名称',
  `rule_memo` varchar(20) NOT NULL COMMENT '规格备注',
  PRIMARY KEY (`rule_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}ruledata`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}ruledata` (
  `ruledata_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '规格值id',
  `ruledata_name` varchar(20) NOT NULL COMMENT '规格值名',
  `ruledata_logo` varchar(100) NOT NULL COMMENT '规格值图',
  `ruledata_order` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '规格值排序',
  `rule_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '规格id',
  PRIMARY KEY (`ruledata_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}setting`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}setting` (
  `setting_key` varchar(50) NOT NULL,
  `setting_value` text NOT NULL,
  KEY `setting_key` (`setting_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}setting` VALUES('web_title','PHPSHE B2C商城系统演示站'),
('web_keywords','免费商城系统,网上商城系统,多用户商城系统,分销商城系统,微信商城系统,商城源码,手机移动商城系统,b2b2c商城系统,网店系统,购物系统,php商城系统,phpshe,简好网络'),
('web_description','PHPSHE网上商城系统具备电商零售业务所需的所有基本功能，以其安全稳定、简单易用、高效专业等优势赢得了用户的广泛好评，为用户提供了一个低成本、高效率的网上商城建设方案。'),
('web_copyright','2008-2018 简好网络'),
('web_tpl','default'),
('web_logo','data/attachment/2017-05/20170509110941s.jpg'),
('web_qrcode','data/attachment/2017-05/20170503193748z.jpg'),
('web_phone','15839823500'),
('web_qq','76265959'),
('web_icp','豫ICP备17013559号-1'),
('web_guestbuy','0'),
('web_hotword','PHPSHE,B2C商城系统,简好网络'),
('web_tongji',''),
('web_wlname','顺丰快递,申通快递,圆通快递,韵达快递,中通快递,天天快递,宅急送,EMS快递,百事汇通,全峰快递,德邦物流'),
('wechat_admin_openid',''),
('wap_logo','data/attachment/2017-05/20170530182823g.png'),
('email_smtp',''),
('email_port',''),
('email_ssl','1'),
('email_name',''),
('email_pw',''),
('email_nname',''),
('email_admin',''),
('sms_key',''),
('sms_admin',''),
('sms_sign',''),
('point_state','1'),
('point_reg','10'),
('point_comment','50'),
('point_login','0');
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}setting` VALUES('point_money','100'),
('cashout_min','10'),
('cashout_fee','0.01'),
('wechat_appid',''),
('wechat_appsecret',''),
('wechat_token',''),
('wechat_rssadd',''),
('wechat_access_token',''),
('wechat_menu',''),
('tg_state','1'),
('tg_fc1','0.05'),
('tg_fc2','0.03'),
('tg_fc3','0.02'),
('web_checkphone','0'),
('web_checkemail','0');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}sign`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}sign` (
  `key` varchar(20) NOT NULL,
  `value` text NOT NULL,
  KEY `setting_key` (`key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}sign` VALUES('sign_state','0'),
('sign_text',''),
('sign_point','10'),
('sign_point_shouci','10'),
('sign_point_lianxu',''),
('sign_point_leiji','');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}signlog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}signlog` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}tguser`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}tguser` (
  `tg_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `tguser_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推广用户id',
  `tguser_name` varchar(20) NOT NULL COMMENT '推广用户名',
  `tguser_level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '推广层级关系',
  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  `user_name` varchar(20) NOT NULL COMMENT '用户名',
  `user_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '注册时间',
  PRIMARY KEY (`tg_id`),
  KEY `tguser_id` (`tguser_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}user`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户id',
  `user_name` varchar(20) NOT NULL COMMENT '用户名',
  `user_pw` char(32) NOT NULL COMMENT '登录密码',
  `user_paypw` char(32) NOT NULL COMMENT '支付密码',
  `user_logo` varchar(100) NOT NULL,
  `user_money` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '账户余额',
  `user_money_cost` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '总消费额',
  `user_money_tg` decimal(10,1) unsigned NOT NULL DEFAULT '0.0' COMMENT '推广总收益',
  `user_point` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '账户积分余额',
  `user_point_all` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '累计获得积分',
  `user_tname` varchar(10) NOT NULL COMMENT '用户姓名',
  `user_phone` char(11) NOT NULL COMMENT '用户手机',
  `user_tel` varchar(20) NOT NULL COMMENT '固定电话',
  `user_qq` varchar(10) NOT NULL COMMENT '用户QQ',
  `user_email` varchar(30) NOT NULL COMMENT '用户email',
  `user_atime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户注册时间',
  `user_ltime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户上次登录时间',
  `user_address` varchar(255) NOT NULL COMMENT '用户地址',
  `user_ordernum` int(10) unsigned NOT NULL DEFAULT '0',
  `user_ip` char(15) NOT NULL COMMENT '用户注册ip',
  `user_wx_openid` varchar(50) NOT NULL,
  `userlevel_id` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '用户等级id',
  `tguser_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '推广用户id',
  `tguser_name` varchar(20) NOT NULL COMMENT '推广用户名',
  PRIMARY KEY (`user_id`),
  KEY `user_name` (`user_name`),
  KEY `user_wx_openid` (`user_wx_openid`),
  KEY `tguser_id` (`tguser_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}useraddr`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}useraddr` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}userbank`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}userbank` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}userlevel`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}userlevel` (
  `userlevel_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `userlevel_name` varchar(10) NOT NULL COMMENT '用户组名',
  `userlevel_value` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户组最大值',
  `userlevel_logo` varchar(100) NOT NULL COMMENT '用户组图标',
  `userlevel_zhe` decimal(3,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '折扣率',
  `userlevel_up` varchar(10) NOT NULL DEFAULT 'auto' COMMENT '升级方式(auto自动/hand手动)',
  PRIMARY KEY (`userlevel_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}userlevel` VALUES('1','普通用户','0','','1.00','auto');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}wechat_notice`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}wechat_notice` (
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
INSERT INTO `{dbpre}wechat_notice` VALUES('1','用户下单','order_add','user','OPENTM202297555','','IT科技','互联网|电子商务','亲，您的订单已创建成功，请及时付款
订单号：180621101215088
商品名称：iPhoneX 64GB 深空灰色
订购数量：1台
订单总额：5980元
付款方式：微信支付
','0'),
('2','订单付款','order_pay','user','OPENTM202183094','','IT科技','互联网|电子商务','亲，您的订单已支付成功，正在为您备货，请耐心等待
付款金额：5980元
商品详情：iPhoneX 64GB 深空灰色
支付方式：微信支付
交易单号：180621101215088
交易时间：2018年6月26日 18:36','0'),
('3','订单发货','order_send','user','OPENTM410090504','','IT科技','互联网|电子商务','亲，您的订单已发货，请注意查收
商品详情：iPhoneX 64GB 深空灰色
发货时间：2018年6月26日 18:36
物流公司：顺丰快递
快递单号：123456789
收货地址：河南省灵宝市新华路简好网络
','0'),
('4','订单关闭','order_close','user','OPENTM408744504','','IT科技','互联网|电子商务','亲，您的订单已被关闭
商品名称：iPhoneX 64GB 深空灰色
订单编号：180621101215088
关闭原因：超时未付款','0'),
('5','用户下单','order_add','admin','OPENTM202297555','','IT科技','互联网|电子商务','您好，您收到了一个新订单
订单号：180621101215088
商品名称：iPhoneX 64GB 深空灰色
订购数量：1台
订单总额：5980元
付款方式：微信支付
付款状态：未支付','0'),
('6','订单付款','order_pay','admin','OPENTM400255038','','IT科技','互联网|电子商务','您好，您有一笔订单收款成功
客户账号：简好网络
订单编号：180621101215088
付款金额：5980元
付款时间：2018年6月26日 18:36
商品信息：iPhoneX 64GB 深空灰色
','0');
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}wechat_noticelog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}wechat_noticelog` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*#####################@ pe_cutsql @#####################*/
DROP TABLE IF EXISTS `{dbpre}yzmlog`;
/*#####################@ pe_cutsql @#####################*/
CREATE TABLE `{dbpre}yzmlog` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
