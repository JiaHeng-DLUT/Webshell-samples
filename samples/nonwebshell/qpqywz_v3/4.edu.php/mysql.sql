DROP TABLE IF EXISTS `sl_admin`;
CREATE TABLE IF NOT EXISTS `sl_admin` (
  `A_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `A_login` text,
  `A_pwd` text,
  `A_part` text,
  `A_textauth` text,
  `A_newsauth` text,
  `A_productauth` text,
  `A_formauth` text,
  `A_bbsauth` text,
  `A_type` int(11) DEFAULT '0',
  PRIMARY KEY (`A_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
insert into `sl_admin`(`A_id`,`A_login`,`A_pwd`,`A_part`,`A_textauth`,`A_newsauth`,`A_productauth`,`A_formauth`,`A_bbsauth`,`A_type`) values('12','admin','7fef6171469e80d32c0559f88b377245','1|1|1|1|1|1|1|1|1|1|1|1|1|1|1','all','all','all','all','all','1');
DROP TABLE IF EXISTS `sl_bbs`;
CREATE TABLE IF NOT EXISTS `sl_bbs` (
  `B_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `B_sort` int(11) DEFAULT '0',
  `B_title` text,
  `B_content` text,
  `B_time` datetime DEFAULT NULL,
  `B_mid` int(11) DEFAULT '0',
  `B_view` int(11) DEFAULT '0',
  `B_sub` int(11) DEFAULT '0',
  `B_sh` int(11) DEFAULT '0',
  PRIMARY KEY (`B_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
insert into `sl_bbs`(`B_id`,`B_sort`,`B_title`,`B_content`,`B_time`,`B_mid`,`B_view`,`B_sub`,`B_sh`) values('1','1','第一篇帖子','第一篇帖子内容','2018-01-01 00:00:00','7','0','0','0');
DROP TABLE IF EXISTS `sl_bsort`;
CREATE TABLE IF NOT EXISTS `sl_bsort` (
  `S_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `S_title` text,
  `S_content` text,
  `S_pic` text,
  `S_order` int(11) DEFAULT '0',
  `S_lv` int(11) DEFAULT '0',
  `S_sh` int(11) DEFAULT '0',
  `S_hide` int(11) DEFAULT '0',
  PRIMARY KEY (`S_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
insert into `sl_bsort`(`S_id`,`S_title`,`S_content`,`S_pic`,`S_order`,`S_lv`,`S_sh`,`S_hide`) values('1','默认板块','默认板块介绍','images/nopic.png','0','0','0','0');
DROP TABLE IF EXISTS `sl_collection`;
CREATE TABLE IF NOT EXISTS `sl_collection` (
  `C_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `C_title` text,
  `C_url` text,
  `C_titlestart` text,
  `C_titleend` text,
  `C_contentstart` text,
  `C_contentend` text,
  `C_start` text,
  `C_end` text,
  `C_pic` int(11) DEFAULT '0',
  `C_nsort` int(11) DEFAULT '0',
  `C_code` text,
  PRIMARY KEY (`C_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
insert into `sl_collection`(`C_id`,`C_title`,`C_url`,`C_titlestart`,`C_titleend`,`C_contentstart`,`C_contentend`,`C_start`,`C_end`,`C_pic`,`C_nsort`,`C_code`) values('1','新浪新闻采集','http://roll.news.sina.com.cn/news/gnxw/gdxw1/index.shtml','<div class=\"page-header\">','</div>','<!-- 窄通 end -->','<!-- 吸顶导航结束定位标记 -->','<ul class=\"list_009\">','</ul>','0','1','utf-8');
DROP TABLE IF EXISTS `sl_comment`;
CREATE TABLE IF NOT EXISTS `sl_comment` (
  `C_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `C_content` text,
  `C_mid` int(11) DEFAULT '0',
  `C_sub` int(11) DEFAULT '0',
  `C_sh` int(11) DEFAULT '0',
  `C_page` text,
  `C_time` datetime DEFAULT NULL,
  PRIMARY KEY (`C_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `sl_config`;
CREATE TABLE IF NOT EXISTS `sl_config` (
  `C_title` text,
  `C_keywords` text,
  `C_content` text,
  `C_logo` text,
  `C_template` text,
  `C_code` text,
  `C_foot` text,
  `C_logox` int(11) DEFAULT '0',
  `C_logoy` int(11) DEFAULT '0',
  `C_ico` text,
  `C_qq` text,
  `C_qqon` int(11) DEFAULT '0',
  `C_mobile` text,
  `C_first` int(11) DEFAULT '0',
  `C_admin` text,
  `C_version` text,
  `C_wtitle` text,
  `C_wcode` text,
  `C_wtoken` text,
  `C_alipay` text,
  `C_alipayid` text,
  `C_alipaykey` text,
  `C_QQid` text,
  `C_QQkey` text,
  `C_email` text,
  `C_mpwd` text,
  `C_fenxiang` text,
  `C_html` int(11) DEFAULT '0',
  `C_dir` text,
  `C_domain` text,
  `C_wap` text,
  `C_wx_appid` text,
  `C_wx_mchid` text,
  `C_wx_key` text,
  `C_wx_appsecret` text,
  `C_alipayon` text,
  `C_wxpayon` text,
  `C_bankon` text,
  `C_test` text,
  `C_time` datetime DEFAULT NULL,
  `C_close` int(11) DEFAULT '0',
  `C_lang` text,
  `C_delang` int(11) DEFAULT '0',
  `C_qq1` int(11) DEFAULT '0',
  `C_qq2` int(11) DEFAULT '0',
  `C_qq3` int(11) DEFAULT '0',
  `C_qq4` int(11) DEFAULT '0',
  `C_1yuan` int(11) DEFAULT '0',
  `C_sign` int(11) DEFAULT '0',
  `C_Invitation` int(11) DEFAULT '0',
  `C_data` int(11) DEFAULT '0',
  `C_gift` text,
  `C_gifton` int(11) DEFAULT '0',
  `C_np` int(11) DEFAULT '0',
  `C_pp` int(11) DEFAULT '0',
  `C_pid` text,
  `C_npage` int(11) DEFAULT '0',
  `C_ppage` int(11) DEFAULT '0',
  `C_balanceon` text,
  `C_member` int(11) DEFAULT '0',
  `C_top` int(11) DEFAULT '0',
  `C_mark` int(11) DEFAULT '0',
  `C_m_position` int(11) DEFAULT '0',
  `C_m_text` text,
  `C_m_font` text,
  `C_m_size` int(11) DEFAULT '0',
  `C_m_color` text,
  `C_m_logo` text,
  `C_m_width` int(11) DEFAULT '0',
  `C_m_height` int(11) DEFAULT '0',
  `C_m_transparent` int(11) DEFAULT '0',
  `C_7PID` text,
  `C_7PKEY` text,
  `C_7CID1` text,
  `C_7CID2` text,
  `C_ds1` int(11) DEFAULT '0',
  `C_ds2` int(11) DEFAULT '0',
  `C_ds3` int(11) DEFAULT '0',
  `C_tp` int(11) DEFAULT '0',
  `C_7money` text,
  `C_sort` int(11) DEFAULT '0',
  `C_tag` text,
  `C_id` int(11) NOT NULL DEFAULT '0',
  `C_1yuan2` int(11) DEFAULT '0',
  `C_tomoney` int(11) DEFAULT '0',
  `C_tofen` int(11) DEFAULT '0',
  `C_tx` int(11) DEFAULT '0',
  `C_tomoney_rate` double DEFAULT '0',
  `C_tofen_rate` double DEFAULT '0',
  `C_tx_rate` double DEFAULT '0',
  `C_db` text,
  `C_psh` int(11) DEFAULT '0',
  `C_qqkj` int(11) DEFAULT '0',
  `C_wxkj` int(11) DEFAULT '0',
  `C_translate` int(11) DEFAULT '0',
  `C_authcode` text,
  `C_memberbg` text,
  `C_weibo` text,
  `C_flag` text,
  `C_hotwords` text,
  `C_nsorttitle` text,
  `C_nsortentitle` text,
  `C_psorttitle` text,
  `C_psortentitle` text,
  `C_need` text,
  `C_codeid` text,
  `C_codekey` text,
  `C_smssign` text,
  `C_userid` text,
  `C_paypal` text,
  `C_paypalon` text,
  `C_wxapplogo` text,
  `C_wxappno` text,
  `C_wxapptabbar` text,
  `C_wxappID` text,
  `C_wxappSecret` text,
  `C_wxcolor` text,
  `C_langtitle` text,
  `C_reg1` int(11) DEFAULT '0',
  `C_reg2` int(11) DEFAULT '0',
  `C_reg3` int(11) DEFAULT '0',
  `C_langtag` text,
  `C_kfon` int(11) DEFAULT '0',
  `C_osson` int(11) DEFAULT '0',
  `C_oss_id` text,
  `C_oss_key` text,
  `C_bucket` text,
  `C_region` text,
  `C_regon` int(11) DEFAULT '0',
  `C_kefuyun` text,
  `C_langcode` text,
  `C_beian` text,
  `C_postage` double DEFAULT '0',
  `C_baoyou` double DEFAULT '0',
  `C_td` int(11) DEFAULT '0',
  `C_nd` int(11) DEFAULT '0',
  `C_pd` int(11) DEFAULT '0',
  `C_rate` double DEFAULT '0',
  PRIMARY KEY (`C_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
insert into `sl_config`(`C_title`,`C_keywords`,`C_content`,`C_logo`,`C_template`,`C_code`,`C_foot`,`C_logox`,`C_logoy`,`C_ico`,`C_qq`,`C_qqon`,`C_mobile`,`C_first`,`C_admin`,`C_version`,`C_wtitle`,`C_wcode`,`C_wtoken`,`C_alipay`,`C_alipayid`,`C_alipaykey`,`C_QQid`,`C_QQkey`,`C_email`,`C_mpwd`,`C_fenxiang`,`C_html`,`C_dir`,`C_domain`,`C_wap`,`C_wx_appid`,`C_wx_mchid`,`C_wx_key`,`C_wx_appsecret`,`C_alipayon`,`C_wxpayon`,`C_bankon`,`C_test`,`C_time`,`C_close`,`C_lang`,`C_delang`,`C_qq1`,`C_qq2`,`C_qq3`,`C_qq4`,`C_1yuan`,`C_sign`,`C_Invitation`,`C_data`,`C_gift`,`C_gifton`,`C_np`,`C_pp`,`C_pid`,`C_npage`,`C_ppage`,`C_balanceon`,`C_member`,`C_top`,`C_mark`,`C_m_position`,`C_m_text`,`C_m_font`,`C_m_size`,`C_m_color`,`C_m_logo`,`C_m_width`,`C_m_height`,`C_m_transparent`,`C_7PID`,`C_7PKEY`,`C_7CID1`,`C_7CID2`,`C_ds1`,`C_ds2`,`C_ds3`,`C_tp`,`C_7money`,`C_sort`,`C_tag`,`C_id`,`C_1yuan2`,`C_tomoney`,`C_tofen`,`C_tx`,`C_tomoney_rate`,`C_tofen_rate`,`C_tx_rate`,`C_db`,`C_psh`,`C_qqkj`,`C_wxkj`,`C_translate`,`C_authcode`,`C_memberbg`,`C_weibo`,`C_flag`,`C_hotwords`,`C_nsorttitle`,`C_nsortentitle`,`C_psorttitle`,`C_psortentitle`,`C_need`,`C_codeid`,`C_codekey`,`C_smssign`,`C_userid`,`C_paypal`,`C_paypalon`,`C_wxapplogo`,`C_wxappno`,`C_wxapptabbar`,`C_wxappID`,`C_wxappSecret`,`C_wxcolor`,`C_langtitle`,`C_reg1`,`C_reg2`,`C_reg3`,`C_langtag`,`C_kfon`,`C_osson`,`C_oss_id`,`C_oss_key`,`C_bucket`,`C_region`,`C_regon`,`C_kefuyun`,`C_langcode`,`C_beian`,`C_postage`,`C_baoyou`,`C_td`,`C_nd`,`C_pd`,`C_rate`) values('您的网站名称/l/Your Website','关键词1,关键词2,关键词3,关键词4,关键词5/l/keyword1,keyword2','请用一段语句通顺的话来描述您的网站定位，字数不超过200字。/l/your website description','media/20171024200350660.png','s95','','COPYRIGHT © 2009-2011,WWW.YOURNAME.COM,ALL RIGHTS RESERVED版权所有 © 您的公司名称/l/copayright','10','0','media/20151019095214828.png','12345678|售前咨询,987654321|售后服务,11223344|加盟代理,taobao|淘宝客服/l/12345678|QQ','1','010-10086|010-10010','0','admin','build20150810','你的微信公众号','media/20150921144410012.jpg','weixin','XXX@qq.com','2088XXXXXXXXX','1234567890','1234567890','1234567890','XXXXX@qq.com','XXXXX','<div class=\"bshare-custom\"><a title=\"分享到QQ空间\" class=\"bshare-qzone\"></a><a title=\"分享到新浪微博\" class=\"bshare-sinaminiblog\"></a><a title=\"分享到人人网\" class=\"bshare-renren\"></a><a title=\"分享到腾讯微博\" class=\"bshare-qqmb\"></a><a title=\"分享到网易微博\" class=\"bshare-neteasemb\"></a><a title=\"更多平台\" class=\"bshare-more bshare-more-icon more-style-addthis\"></a><span class=\"BSHARE_COUNT bshare-share-count\">0</span></div><script type=\"text/javascript\" charset=\"utf-8\" src=\"http://static.bshare.cn/b/buttonLite.js#style=-1&uuid=&pophcol=2&lang=zh\"></script><script type=\"text/javascript\" charset=\"utf-8\" src=\"http://static.bshare.cn/b/bshareC0.js\"></script>','0','/','empty','w95','wxXXXXXXXXXX','1234567890','1234567890','1234567890','true','true','true','7A6ReMQ2Wy','2018-12-12 10:17:38','0','0','0','1','1','1','1','100','10','100','100','10000@5元话费,20000@数据线,50000@U盘','1','1','1','','10','10','true','1','1','0','4','水印文字','宋体','15','#ff0000','media/20151019094721842.png','100','50','50','','','','','0','0','0','1','1@2@5@10@20@50','1','等,请你,女孩,如果,人生,想起','1','100','0','0','0','0.01','100','5','mysql','0','0','0','0','1','media/20171019002457251.jpg','#','cn,uk,tw','搜索热词1,搜索热词2,搜索热词3/l/搜索热词1,搜索热词2,搜索热词3(en)','新闻中心/l/news center','news/l/news','产品中心/l/Product center','product/l/product','','','','网站简称','','','true','','p1','','','','','简体中文,繁體中文,English','1','1','1','cn,cht,en','0','0','','','','','0','','php','','10','99','0','0','0','6.91');
DROP TABLE IF EXISTS `sl_contact`;
CREATE TABLE IF NOT EXISTS `sl_contact` (
  `C_title` text,
  `C_entitle` text,
  `C_content` text,
  `C_address` text,
  `C_zb` text,
  `C_map` text,
  `C_keywords` text,
  `C_description` text,
  `C_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`C_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
insert into `sl_contact`(`C_title`,`C_entitle`,`C_content`,`C_address`,`C_zb`,`C_map`,`C_keywords`,`C_description`,`C_id`) values('联系我们/l/contact us','contact us/l/contact us','地址：上海市xx区xx路xx广场x号<br />电话：86-021-xxxxxxxx<br />传真：86-021-xxxxxxxxxxxxxxxx<br />邮箱：xxxxxxxxx@qq.com<br />网址：www.xxxxxx.com<br />/l/Address：XX Road, XX Road, XX District, Shanghai City<br />Telephpne：86-021-xxxxxxxx<br />Fax：86-021-xxxxxxxxxxxxxxxx<br />E-mail：xxxxxxxxx@qq.com<br />Website：www.xxxxxx.com','上海市xx区xx路xx广场x号楼xx号/l/XX Road, XX Road, XX District, Shanghai City','116.376098,39.966935','baidu','','','1');
DROP TABLE IF EXISTS `sl_content`;
CREATE TABLE IF NOT EXISTS `sl_content` (
  `C_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `C_title` text,
  `C_bz` text,
  `C_content` text,
  `C_type` text,
  `C_fid` int(11) DEFAULT '0',
  `C_order` int(11) DEFAULT '0',
  PRIMARY KEY (`C_id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('19','如何称呼您/l/How do i address you','/l/How do i address you','/l/null','text','7','1');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('20','准备哪天过来/l/Ready to come over','/l/Ready to come over','/l/null','date','7','2');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('21','大致时间段/l/Approximate time period','大致时间段/l/大致时间段','8-10点|10-12点|12-14点|14-16点|16-18点/l/8-10|10-12|12-14|14-16|16-18','option','7','3');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('22','指定哪位技师/l/Specify which technician','/l/Specify which technician','/l/null','text','7','4');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('23','联系电话/l/Contact number','/l/Contact number','/l/null','text','7','5');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('24','其他要求/l/Other requirements','/l/Other requirements','/l/null','area','7','6');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('25','您的姓名/l/Your name','/l/Your name','/l/null','text','8','1');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('26','联系电话/l/Contact number','/l/Contact number','/l/null','text','8','2');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('27','哪天来唱/l/Which day to sing','/l/Which day to sing','/l/null','date','8','3');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('28','哪个时间段来/l/Which time period','/l/Which time period','下午（1点-6点）|晚上（6点-午夜12点）|后半夜（午夜12点-凌晨6点）/l/Afternoon|Night|Late at night','option','8','4');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('29','房型/l/layout of a house or an apartment','/l/layout of a house or an apartment','迷你包|小包|中包|大包|豪华包|VIP包/l/Mini Bag|Parcel|In the bag|Bag|Deluxe Package|VIP','radio','8','5');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('30','备注/l/Remarks','/l/Remarks','/l/null','area','8','6');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('31','姓名/l/Name','姓名/l/姓名','姓名/l/姓名','text','9','1');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('32','学校/l/School','/l/School','/l/null','text','9','2');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('33','手机/l/MobilePhone','/l/MobilePhone','/l/null','text','9','3');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('34','邮箱/l/E-mail','/l/E-mail','/l/null','text','9','4');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('35','学历/l/Education','学历/l/学历','初中|高中|大学本科|硕士研究生|博士研究生/l/Junior middle school|high school|Undergraduate college|Graduate student|Doctoral students','radio','9','5');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('36','毕业日期/l/E-mail','/l/E-mail','/l/null','date','9','6');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('37','应聘职位/l/Apply for position','应聘职位/l/应聘职位','职位1|职位2|职位3|职位4/l/position1|position2|position3|position4','option','9','7');
insert into `sl_content`(`C_id`,`C_title`,`C_bz`,`C_content`,`C_type`,`C_fid`,`C_order`) values('38','上传简历/l/Upload resume','允许格式为jpg,png,gif,rar,doc,pdf,ppt/l/Upload resume','/l/null','pic','9','8');
DROP TABLE IF EXISTS `sl_event`;
CREATE TABLE IF NOT EXISTS `sl_event` (
  `E_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `E_type` text,
  `E_content` text,
  `E_title` text,
  PRIMARY KEY (`E_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
insert into `sl_event`(`E_id`,`E_type`,`E_content`,`E_title`) values('1','articles','T2,T1','关于我们');
insert into `sl_event`(`E_id`,`E_type`,`E_content`,`E_title`) values('2','articles','F9,F8,F7','人才招聘');
insert into `sl_event`(`E_id`,`E_type`,`E_content`,`E_title`) values('3','articles','P89,P88,P87,P86,P84,P83,P82,P81','最新产品');
insert into `sl_event`(`E_id`,`E_type`,`E_content`,`E_title`) values('4','articles','T1,C,G','联系我们');
insert into `sl_event`(`E_id`,`E_type`,`E_content`,`E_title`) values('5','text','未识别您发的消息，请等待人工为您回复☺','未匹配到关键词');
insert into `sl_event`(`E_id`,`E_type`,`E_content`,`E_title`) values('6','articles','推送网站目录','推送网站目录');
DROP TABLE IF EXISTS `sl_form`;
CREATE TABLE IF NOT EXISTS `sl_form` (
  `F_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `F_title` text,
  `F_entitle` text,
  `F_bz` text,
  `F_yz` int(11) DEFAULT '0',
  `F_module` text,
  `F_pic` text,
  `F_description` text,
  `F_keywords` text,
  `F_pagetitle` text,
  `F_type` int(11) DEFAULT '0',
  `F_qsort` int(11) DEFAULT '0',
  `F_cq` int(11) DEFAULT '0',
  PRIMARY KEY (`F_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
insert into `sl_form`(`F_id`,`F_title`,`F_entitle`,`F_bz`,`F_yz`,`F_module`,`F_pic`,`F_description`,`F_keywords`,`F_pagetitle`,`F_type`,`F_qsort`,`F_cq`) values('7','防伪查询/l/Service appointment','aaa/l/Service appointment','/l/(en)','0','f001','media/form_bg.jpg','/l/(en)','查询/l/查询(en)','防伪查询/l/防伪查询(en)','1','1','0');
insert into `sl_form`(`F_id`,`F_title`,`F_entitle`,`F_bz`,`F_yz`,`F_module`,`F_pic`,`F_description`,`F_keywords`,`F_pagetitle`,`F_type`,`F_qsort`,`F_cq`) values('8','KTV房间预定/l/KTV room reservation','bbb/l/KTV room reservation','','0','f001','media/form_bg.jpg','','','','0','0','0');
insert into `sl_form`(`F_id`,`F_title`,`F_entitle`,`F_bz`,`F_yz`,`F_module`,`F_pic`,`F_description`,`F_keywords`,`F_pagetitle`,`F_type`,`F_qsort`,`F_cq`) values('9','简历提交/l/Resume submission','ccc/l/Resume submission','招聘相关公告可以放在这里','0','f001','media/form_bg.jpg','','','','0','0','0');
DROP TABLE IF EXISTS `sl_guestbook`;
CREATE TABLE IF NOT EXISTS `sl_guestbook` (
  `G_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `G_title` text,
  `G_name` text,
  `G_phone` text,
  `G_email` text,
  `G_Msg` text,
  `G_sh` int(11) DEFAULT '0',
  `G_time` datetime DEFAULT NULL,
  `G_reply` text,
  PRIMARY KEY (`G_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
insert into `sl_guestbook`(`G_id`,`G_title`,`G_name`,`G_phone`,`G_email`,`G_Msg`,`G_sh`,`G_time`,`G_reply`) values('8','咨询产品','张三','18712345678','4645645@qq.com','咨询产品价格及加盟方式。','1','2015-09-29 10:18:11','产品价格详见价格列表加盟方式为免费加盟谢谢您的咨询');
insert into `sl_guestbook`(`G_id`,`G_title`,`G_name`,`G_phone`,`G_email`,`G_Msg`,`G_sh`,`G_time`,`G_reply`) values('10','标题','昵称','13333333333','10086@QQ.com','留言内容','1','2015-09-30 11:08:40','回复');
insert into `sl_guestbook`(`G_id`,`G_title`,`G_name`,`G_phone`,`G_email`,`G_Msg`,`G_sh`,`G_time`,`G_reply`) values('14','留言测试-标题','留言测试-姓名','15555555555','test@test.com','留言测试-内容','1','2015-10-24 12:40:59','留言测试-内容回复');
DROP TABLE IF EXISTS `sl_invoice`;
CREATE TABLE IF NOT EXISTS `sl_invoice` (
  `I_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `I_company` text,
  `I_no` text,
  `I_list` text,
  `I_sh` int(11) DEFAULT '0',
  `I_money` int(11) DEFAULT '0',
  `I_time` datetime DEFAULT NULL,
  `I_mid` int(11) DEFAULT '0',
  PRIMARY KEY (`I_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `sl_link`;
CREATE TABLE IF NOT EXISTS `sl_link` (
  `L_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `L_title` text,
  `L_url` text,
  `L_pic` text,
  `L_sort` int(11) DEFAULT '0',
  PRIMARY KEY (`L_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('1','百度/l/baidu','http://www.baidu.com','media/20150921155457342.png','1');
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('2','sogou搜索/l/sogou','http://www.sogou.com','media/20150921155449747.png','1');
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('3','360搜索/l/360','http://www.haosou.com','media/20150921155427473.png','1');
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('4','soso搜索/l/soso','http://www.soso.com','media/20150921155407355.png','1');
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('6','腾讯网/l/tecent','http://www.qq.com','media/20151019100956845.png','1');
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('7','新浪网/l/sina','http://www.sina.com','media/20151019101025246.png','1');
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('8','网易/l/163','http://www.163.com','media/20151019101105262.png','1');
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('9','淘宝网/l/taobao','http://www.taobaoc.om','media/20151019101130000.png','1');
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('12','企业建站/l/s-cms','http://www.s-cms.cn','media/scms.png','1');
insert into `sl_link`(`L_id`,`L_title`,`L_url`,`L_pic`,`L_sort`) values('13','在线客服系统/l/kefuyun','https://shanling.top','media/kefuyun.png','1');
DROP TABLE IF EXISTS `sl_list`;
CREATE TABLE IF NOT EXISTS `sl_list` (
  `L_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `L_type` int(11) DEFAULT '0',
  `L_time` datetime DEFAULT NULL,
  `L_mid` int(11) DEFAULT '0',
  `L_title` text,
  `L_change` double DEFAULT '0',
  `L_no` text,
  `L_sh` int(11) DEFAULT '0',
  PRIMARY KEY (`L_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `sl_log`;
CREATE TABLE IF NOT EXISTS `sl_log` (
  `L_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `L_user` text,
  `L_action` text,
  `L_ip` text,
  `L_location` text,
  `L_time` datetime DEFAULT NULL,
  PRIMARY KEY (`L_id`)
) ENGINE=MyISAM AUTO_INCREMENT=166 DEFAULT CHARSET=utf8;
insert into `sl_log`(`L_id`,`L_user`,`L_action`,`L_ip`,`L_location`,`L_time`) values('164','admin','清空日志','::1','本地本地本地','2018-08-18 17:26:07');
insert into `sl_log`(`L_id`,`L_user`,`L_action`,`L_ip`,`L_location`,`L_time`) values('165','','登录后台成功','::1','','2018-12-12 10:17:44');
DROP TABLE IF EXISTS `sl_lsort`;
CREATE TABLE IF NOT EXISTS `sl_lsort` (
  `S_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `S_title` text,
  `S_order` int(11) DEFAULT '0',
  PRIMARY KEY (`S_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
insert into `sl_lsort`(`S_id`,`S_title`,`S_order`) values('1','友情链接/l/友情链接(en)','0');
DROP TABLE IF EXISTS `sl_lv`;
CREATE TABLE IF NOT EXISTS `sl_lv` (
  `L_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `L_discount` int(11) DEFAULT '0',
  `L_title` text,
  `L_fen` int(11) DEFAULT '0',
  `L_order` int(11) DEFAULT '0',
  PRIMARY KEY (`L_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
insert into `sl_lv`(`L_id`,`L_discount`,`L_title`,`L_fen`,`L_order`) values('1','100','普通会员','0','0');
insert into `sl_lv`(`L_id`,`L_discount`,`L_title`,`L_fen`,`L_order`) values('2','95','铜牌会员','100','1');
insert into `sl_lv`(`L_id`,`L_discount`,`L_title`,`L_fen`,`L_order`) values('3','90','银牌会员','200','2');
insert into `sl_lv`(`L_id`,`L_discount`,`L_title`,`L_fen`,`L_order`) values('4','85','金牌会员','300','3');
insert into `sl_lv`(`L_id`,`L_discount`,`L_title`,`L_fen`,`L_order`) values('5','80','钻石会员','400','4');
DROP TABLE IF EXISTS `sl_member`;
CREATE TABLE IF NOT EXISTS `sl_member` (
  `M_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `M_login` text,
  `M_pwd` text,
  `M_email` text,
  `M_QQ` text,
  `M_mobile` text,
  `M_add` text,
  `M_pic` text,
  `M_fen` int(11) DEFAULT '0',
  `M_name` text,
  `M_code` text,
  `M_qqid` text,
  `M_regtime` datetime DEFAULT NULL,
  `M_pwdcode` text,
  `M_genkey` text,
  `M_lv` int(11) DEFAULT '0',
  `M_money` double DEFAULT '0',
  `M_subscribe` int(11) DEFAULT '0',
  `M_from` int(11) DEFAULT '0',
  `M_vip` int(11) DEFAULT '0',
  `M_viptime` text,
  `M_viplong` int(11) DEFAULT '0',
  `M_need` text,
  `M_info` text,
  PRIMARY KEY (`M_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
insert into `sl_member`(`M_id`,`M_login`,`M_pwd`,`M_email`,`M_QQ`,`M_mobile`,`M_add`,`M_pic`,`M_fen`,`M_name`,`M_code`,`M_qqid`,`M_regtime`,`M_pwdcode`,`M_genkey`,`M_lv`,`M_money`,`M_subscribe`,`M_from`,`M_vip`,`M_viptime`,`M_viplong`,`M_need`,`M_info`) values('6','未提供','37A6259CC0C1DAE299A7866489DFF0BD','null','1','1','1','member.jpg','0','1','1','','2011-11-11 00:00:00','','','1','0','0','0','0','','0','','');
insert into `sl_member`(`M_id`,`M_login`,`M_pwd`,`M_email`,`M_QQ`,`M_mobile`,`M_add`,`M_pic`,`M_fen`,`M_name`,`M_code`,`M_qqid`,`M_regtime`,`M_pwdcode`,`M_genkey`,`M_lv`,`M_money`,`M_subscribe`,`M_from`,`M_vip`,`M_viptime`,`M_viplong`,`M_need`,`M_info`) values('7','admin','7FEF6171469E80D32C0559F88B377245','10086@qq.com','留言测试-标题','15567896789','XX省XX市XX区XX号','member.jpg','0','姓名','100000','','2011-11-11 00:00:00','','','1','0','0','0','0','','0','','');
insert into `sl_member`(`M_id`,`M_login`,`M_pwd`,`M_email`,`M_QQ`,`M_mobile`,`M_add`,`M_pic`,`M_fen`,`M_name`,`M_code`,`M_qqid`,`M_regtime`,`M_pwdcode`,`M_genkey`,`M_lv`,`M_money`,`M_subscribe`,`M_from`,`M_vip`,`M_viptime`,`M_viplong`,`M_need`,`M_info`) values('8','入戏太深','C34874DEB10E54993F2161F37E057B1C','anchen@qq.com','1','1','1','member.jpg','0','1','1','','2011-11-11 00:00:00','','','1','0','0','0','0','','0','','');
insert into `sl_member`(`M_id`,`M_login`,`M_pwd`,`M_email`,`M_QQ`,`M_mobile`,`M_add`,`M_pic`,`M_fen`,`M_name`,`M_code`,`M_qqid`,`M_regtime`,`M_pwdcode`,`M_genkey`,`M_lv`,`M_money`,`M_subscribe`,`M_from`,`M_vip`,`M_viptime`,`M_viplong`,`M_need`,`M_info`) values('9','user','5F4DCC3B5AA765D61D8327DEB882CF99','anchen@qq.com','1','1','1','member.jpg','0','1','1','','2011-11-11 00:00:00','','','1','0','0','0','0','','0','','');
insert into `sl_member`(`M_id`,`M_login`,`M_pwd`,`M_email`,`M_QQ`,`M_mobile`,`M_add`,`M_pic`,`M_fen`,`M_name`,`M_code`,`M_qqid`,`M_regtime`,`M_pwdcode`,`M_genkey`,`M_lv`,`M_money`,`M_subscribe`,`M_from`,`M_vip`,`M_viptime`,`M_viplong`,`M_need`,`M_info`) values('15','Anchen','C34874DEB10E54993F2161F37E057B1C','anchen@qq.com','1','1','1','member.jpg','0','1','1','','2011-11-11 00:00:00','','','1','0','0','0','0','','0','','');
insert into `sl_member`(`M_id`,`M_login`,`M_pwd`,`M_email`,`M_QQ`,`M_mobile`,`M_add`,`M_pic`,`M_fen`,`M_name`,`M_code`,`M_qqid`,`M_regtime`,`M_pwdcode`,`M_genkey`,`M_lv`,`M_money`,`M_subscribe`,`M_from`,`M_vip`,`M_viptime`,`M_viplong`,`M_need`,`M_info`) values('16','撑一把纸仐','C34874DEB10E54993F2161F37E057B1C','anchen@qq.com','1','1','1','member.jpg','0','1','1','','2011-11-11 00:00:00','','','1','0','0','0','0','','0','','');
DROP TABLE IF EXISTS `sl_menu`;
CREATE TABLE IF NOT EXISTS `sl_menu` (
  `U_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `U_title` text,
  `U_entitle` text,
  `U_sub` int(11) DEFAULT '0',
  `U_order` int(11) DEFAULT '0',
  `U_type` text,
  `U_typeid` int(11) DEFAULT '0',
  `U_hide` int(11) DEFAULT '0',
  `U_url` text,
  `U_ico` text,
  `U_color` text,
  `U_template` text,
  `U_bg` text,
  PRIMARY KEY (`U_id`)
) ENGINE=MyISAM AUTO_INCREMENT=67 DEFAULT CHARSET=utf8;
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('1','网站首页/l/Home','index/l/Home','0','1','index','1','0','','home','#FF9C00','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('7','联系我们/l/contact','contact/l/contact','0','10','contact','1','0','','map-o','#55AA66','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('13','在线留言/l/guestbook','guestbook/l/guestbook','7','2','guestbook','1','0','','envelope-o','#AA7755','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('14','万能表单/l/form','form/l/form','0','9','form','9','0','','share-alt','#4D61B3','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('25','简历提交/l/Resume','Resume/l/Resume','14','3','form','9','0','','sticky-note-o','#006600','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('26','KTV预定/l/KTV','KTV/l/KTV','14','2','form','8','0','','sticky-note-o','#AAa755','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('27','防伪查询/l/Service','Query/l/Service','14','1','form','7','0','','sticky-note-o','#A3BB44','form.html','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('36','联系方式/l/Contact','Contact/l/Contact','7','1','contact','1','0','','map-marker','#ff9900','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('41','学校概况/l/学校概况(en)','General situation of school/l/General situation of school(en)','0','2','text','2','0','','bars','#a83232','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('42','学校简介/l/学校简介(en)','School profiles/l/School profiles(en)','41','1','text','2','0','','bars','#5557a6','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('43','办学理念/l/办学理念(en)','School running idea/l/School running idea(en)','41','2','text','13','0','','bars','#31248a','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('44','组织机构/l/组织机构(en)','Organization/l/Organization(en)','41','3','text','14','0','','bars','#546b80','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('45','校长寄语/l/校长寄语(en)','President&apos;s message/l/President&apos;s message(en)','41','4','text','1','0','','bars','#3c7871','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('46','德语视窗/l/德语视窗(en)','German windows/l/German windows(en)','0','3','news','99','0','','bars','#ab2e2e','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('47','德育活动/l/德育活动(en)','Moral education activities/l/Moral education activities(en)','46','1','news','1','0','','bars','#b33232','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('48','心理健康/l/心理健康(en)','Mental health/l/Mental health(en)','46','2','news','104','0','','bars','#8f2929','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('49','艺术天地/l/艺术天地(en)','Art world/l/Art world(en)','46','3','news','105','0','','bars','#9a1cba','news.html','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('50','教研教学/l/教研教学(en)','Teaching research/l/Teaching research(en)','0','4','news','100','0','','bars','#993b3b','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('51','教研动态/l/教研动态(en)','Teaching research trends/l/Teaching research trends(en)','50','1','news','7','0','','bars','#5e5ea8','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('52','教学成果/l/教学成果(en)','Teaching achievement/l/Teaching achievement(en)','50','2','news','106','0','','bars','#cc3131','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('53','外语特色/l/外语特色(en)','Foreign language characteristics/l/Foreign language characteristics(en)','0','5','news','107','0','','bars','#a35353','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('54','外语教研/l/外语教研(en)','Foreign language teaching and research/l/Foreign language teaching and research(en)','53','1','news','108','0','','bars','#992e2e','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('55','外语活动/l/外语活动(en)','Foreign language activities/l/Foreign language activities(en)','53','2','news','109','0','','bars','#a84f4f','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('56','英文佳作/l/英文佳作(en)','English excellent works/l/English excellent works(en)','53','3','news','110','0','','bars','#643b8f','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('57','国际交流/l/国际交流(en)','international exchange/l/international exchange(en)','0','6','product','6','0','','bars','#1f3161','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('58','友好学校/l/友好学校(en)','Friendship school/l/Friendship school(en)','57','1','product','7','0','','bars','#4b9481','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('59','来访外访/l/来访外访(en)','Visiting abroad/l/Visiting abroad(en)','57','2','product','8','0','','bars','#3fab95','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('60','学子风采/l/学子风采(en)','Scholar mien/l/Scholar mien(en)','0','7','product','1','0','','bars','#644cc7','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('61','状元金榜/l/状元金榜(en)','Jinbang champion/l/Jinbang champion(en)','60','1','product','2','0','','bars','#ba2222','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('62','校园之星/l/校园之星(en)','Campus star/l/Campus star(en)','60','2','product','3','0','','bars','#665cad','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('63','杰出校友/l/杰出校友(en)','Outstanding alumni/l/Outstanding alumni(en)','60','3','product','4','0','','bars','#c22e2e','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('64','学校资讯/l/学校资讯(en)','School information/l/School information(en)','0','8','news','111','0','','bars','#912d2d','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('65','学校公告/l/学校公告(en)','School bulletin/l/School bulletin(en)','64','1','news','112','0','','bars','#745bb3','','');
insert into `sl_menu`(`U_id`,`U_title`,`U_entitle`,`U_sub`,`U_order`,`U_type`,`U_typeid`,`U_hide`,`U_url`,`U_ico`,`U_color`,`U_template`,`U_bg`) values('66','新闻动态/l/新闻动态(en)','News information/l/News information(en)','64','2','news','113','0','','bars','#b85454','','');
DROP TABLE IF EXISTS `sl_news`;
CREATE TABLE IF NOT EXISTS `sl_news` (
  `N_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `N_title` text,
  `N_content` text,
  `N_date` datetime DEFAULT NULL,
  `N_author` text,
  `N_view` int(11) DEFAULT '0',
  `N_sort` int(11) DEFAULT '0',
  `N_pic` text,
  `N_order` int(11) DEFAULT '0',
  `N_short` text,
  `N_top` int(11) DEFAULT '0',
  `N_sh` int(11) DEFAULT '0',
  `N_lv` int(11) DEFAULT '0',
  `N_keywords` text,
  `N_description` text,
  `N_link` text,
  `N_pagetitle` text,
  `N_tag` text,
  `N_color` text,
  `N_strong` int(11) DEFAULT '0',
  `N_type` int(11) DEFAULT '0',
  `N_file` text,
  `N_job` text,
  `N_hide` text,
  `N_hideon` int(11) DEFAULT '0',
  `N_hidetype` text,
  `N_hideintro` text,
  `N_price` text,
  `N_video` text,
  `N_team` text,
  `N_teamid` int(11) DEFAULT '0',
  `N_teaminfo` int(11) DEFAULT '0',
  `N_like` int(11) DEFAULT '0',
  PRIMARY KEY (`N_id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8;
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('26','感恩成长，梦想启航/l/感恩成长，梦想启航(en)','<div style=\"box-sizing:border-box;\">	&nbsp;“多年师生情，今昔恨别离。满堂祝福语，只赠学子行”。2017年6月9日下午，成都市实验外国语学校隆重举办了高2017届成人仪式暨毕业典礼，本次活动以“感恩成长，梦想启航”为主题，描绘了对高三学子未来的美好憧憬与无限期盼。</div><div style=\"box-sizing:border-box;\">	<br style=\"box-sizing:border-box;\" />成都市实验外国语学校校长王建伟，副校长雷从树，校长助理张黎明、刘元华，教科室主任龙祖元，学生管理处主任唐军，学生处副主任易明朝、韩公汉以及高三全体师生、家长共同出席，见证了这庄严而重要的一刻。雷从树副校长和胡岷老师主持了本次仪式。</div><div style=\"box-sizing:border-box;\">	<br style=\"box-sizing:border-box;\" />伴随着悠扬的乐曲声，高2017届的学子们牵着家人的手，在高三全体老师的掌声和祝福中一一走过成人门，沿着红毯走上主席台。我校王建伟校长为每个高三学子颁发《中国人民共和国宪法》，班主任则为学子们颁发极具纪念意义的毕业照，各班学生代表向大家介绍每一位迈过成人门、迈向人生新篇章的同学……<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	随后，升国旗、奏唱国歌。王建伟校长为高三学子送去了由衷的祝福，也提出的殷切的希望，希望同学们带上一份“责任”，带上一份“理想”，带上一份“感恩”，不惧艰难，不畏风霜，不怕挑战，心怀感恩，勇敢地去担当、去追求，信心满满的走向未来。教师代表蒲伟老师发言，饱含祝福的语言中透露着对高三学子的不舍，但更多的是期待他们在新的人生道路上越走越好。尤其令人感动的是由高三家委会的家长们带来的原创诗朗诵《致花儿与少年》，“你呱呱落地，是我们的第一次相见，窗外夏日炎炎，亦或冬日凄寒。你的到来在于我们都是春天！那么明亮，那么温暖!我们怎么也弄不明白，这么小小的你，怎会给我们注入了如此磅礴的力量，以及永无止境的期盼”，一字一句，饱含深情，凝聚着家长对孩子们沉甸甸的祝福和深沉的爱。接着学生代表陈可欣发言，她的发言里有掩藏不住的蓬勃朝气，也充分展示了优秀的实外学子奋发向上的精神风貌，在他们十八岁毕业之际，为自己交出了傲人成长清单。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	饱含深情与祝福的发言之后，是来自学长、学弟以及同窗好友的祝福。来自高三的优秀学子蒋昱晗同学献唱《跟你走》，来自高二的陈瑞楷同学献唱《不说再见》，悠扬的歌声中饱含着对于学校、对于老师、对于同学的不舍，在这些不舍中，高三学子集体合唱《那些年》，记忆我们一起度过的美好校园时光，回忆我们美好的同窗之情……<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	高2017届成人仪式暨毕业典礼让即将成年的学子们感受到了来自学校、老师、家长等各个方面的关爱，带着这份关爱也让他们更加坚定的去书写人生的新篇章，在感动的泪水中，学子们表达了对老师、对家长的无限感激。最后，全体师生一起放飞纸飞机，感恩成长，让青春的梦想杨帆启航！</div>/l/<div style=\"box-sizing:border-box;\">	&nbsp;“多年师生情，今昔恨别离。满堂祝福语，只赠学子行”。2017年6月9日下午，成都市实验外国语学校隆重举办了高2017届成人仪式暨毕业典礼，本次活动以“感恩成长，梦想启航”为主题，描绘了对高三学子未来的美好憧憬与无限期盼。</div><div style=\"box-sizing:border-box;\">	<br style=\"box-sizing:border-box;\" />成都市实验外国语学校校长王建伟，副校长雷从树，校长助理张黎明、刘元华，教科室主任龙祖元，学生管理处主任唐军，学生处副主任易明朝、韩公汉以及高三全体师生、家长共同出席，见证了这庄严而重要的一刻。雷从树副校长和胡岷老师主持了本次仪式。</div><div style=\"box-sizing:border-box;\">	<br style=\"box-sizing:border-box;\" />伴随着悠扬的乐曲声，高2017届的学子们牵着家人的手，在高三全体老师的掌声和祝福中一一走过成人门，沿着红毯走上主席台。我校王建伟校长为每个高三学子颁发《中国人民共和国宪法》，班主任则为学子们颁发极具纪念意义的毕业照，各班学生代表向大家介绍每一位迈过成人门、迈向人生新篇章的同学……<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	随后，升国旗、奏唱国歌。王建伟校长为高三学子送去了由衷的祝福，也提出的殷切的希望，希望同学们带上一份“责任”，带上一份“理想”，带上一份“感恩”，不惧艰难，不畏风霜，不怕挑战，心怀感恩，勇敢地去担当、去追求，信心满满的走向未来。教师代表蒲伟老师发言，饱含祝福的语言中透露着对高三学子的不舍，但更多的是期待他们在新的人生道路上越走越好。尤其令人感动的是由高三家委会的家长们带来的原创诗朗诵《致花儿与少年》，“你呱呱落地，是我们的第一次相见，窗外夏日炎炎，亦或冬日凄寒。你的到来在于我们都是春天！那么明亮，那么温暖!我们怎么也弄不明白，这么小小的你，怎会给我们注入了如此磅礴的力量，以及永无止境的期盼”，一字一句，饱含深情，凝聚着家长对孩子们沉甸甸的祝福和深沉的爱。接着学生代表陈可欣发言，她的发言里有掩藏不住的蓬勃朝气，也充分展示了优秀的实外学子奋发向上的精神风貌，在他们十八岁毕业之际，为自己交出了傲人成长清单。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	饱含深情与祝福的发言之后，是来自学长、学弟以及同窗好友的祝福。来自高三的优秀学子蒋昱晗同学献唱《跟你走》，来自高二的陈瑞楷同学献唱《不说再见》，悠扬的歌声中饱含着对于学校、对于老师、对于同学的不舍，在这些不舍中，高三学子集体合唱《那些年》，记忆我们一起度过的美好校园时光，回忆我们美好的同窗之情……<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	高2017届成人仪式暨毕业典礼让即将成年的学子们感受到了来自学校、老师、家长等各个方面的关爱，带着这份关爱也让他们更加坚定的去书写人生的新篇章，在感动的泪水中，学子们表达了对老师、对家长的无限感激。最后，全体师生一起放飞纸飞机，感恩成长，让青春的梦想杨帆启航！</div>(en)','2017-10-24 20:48:05','admin','100','1','images/nopic.png','0','	&nbsp;“多年师生情，今昔恨别离。满堂祝福语，只赠学子行”。2017年6月9日下午，成都市实验外国语学校隆重举办了高2017届成人仪式暨毕业典礼，本次活动以“感恩成长，梦想启航”为主题，描绘了对高三学子未来的美好憧憬与无限期盼。	成都市实验外国语学校校长王建伟，副校长雷从树，校长助理张黎明、刘元华，教科室主任龙祖元，学生管理处主任唐军，学生处副主任易明朝、韩公汉以及高三全体师生、家长共同出席/l/	&nbsp;“多年师生情，今昔恨别离。满堂祝福语，只赠学子行”。2017年6月9日下午，成都市实验外国语学校隆重举办了高2017届成人仪式暨毕业典礼，本次活动以“感恩成长，梦想启航”为主题，描绘了对高三学子未来的美好憧憬与无限期盼。	成都市实验外国语学校校长王建伟，副校长雷从树，校长助理张黎明、刘元华，教科室主任龙祖元，学生管理处主任唐军，学生处副主任易明朝、韩公汉以及高三全体师生、家长共同出席(en)','0','0','0','启航,梦想/l/启航,梦想(en)','	&nbsp;“多年师生情，今昔恨别离。满堂祝福语，只赠学子行”。2017年6月9日下午，成都市实验外国语学校隆重举办了高2017届成人仪式暨毕业典礼，本次活动以“感恩成长，梦想启航”为主题，描绘了对高三学子未来的美好憧憬与无限期盼。	成都市实验外国语学校校长王建伟，副校长雷从树，校长助理张黎明、刘元华，教科室主任龙祖元，学生管理处主任唐军，学生处副主任易明朝、韩公汉以及高三全体师生、家长共同出席/l/	&nbsp;“多年师生情，今昔恨别离。满堂祝福语，只赠学子行”。2017年6月9日下午，成都市实验外国语学校隆重举办了高2017届成人仪式暨毕业典礼，本次活动以“感恩成长，梦想启航”为主题，描绘了对高三学子未来的美好憧憬与无限期盼。	成都市实验外国语学校校长王建伟，副校长雷从树，校长助理张黎明、刘元华，教科室主任龙祖元，学生管理处主任唐军，学生处副主任易明朝、韩公汉以及高三全体师生、家长共同出席(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('27','学生心理问题的发现与早期介入/l/学生心理问题的发现与早期介入(en)','<div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	为贯彻王校长“特色立校，德育为先”的办学思想，践行学校“人文开放，和谐发展，构建学习型班主任队伍”的德育理念，加强班主任队伍的专业化建设，成都市实验外国语学校于2017年4月26日开展“班主任论坛”活动。本次论坛邀请了拥有丰富带班经验的杨震国老师为班主任做有关“学生心理问题的发现与早期介入”的分享。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 学生心理的健康发展一直是班主任关注的重点，本次论坛杨震国老师从学生心理问题产生原因，学生产生心理问题时的表现以及学生心理问题的早期介入这三个方面和班主任们做了分享。精彩的发言，切合实际的方法，杨老师在论坛上分享满满的干货，引起了广泛共鸣，赢得了所有年级主任、班主任的一致好评。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;text-align:center;\">	<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 谈及学生心理问题产生的原因，杨老师从学生个人、家庭、群体以及阶段性因素进行了分析。学生的学习、人际关系、性格、对自身的要求、缺乏家庭的关爱等都会让学生感受到压力，从而造成心理问题。其中家庭因素占首要位置，家长对孩子的期待，对孩子的教育方式、对孩子的关心程度等都会影响孩子心理健康的发展，杨老师主张班主任多与家长沟通，帮助家长理解“家不是说理的地方，而是孩子爱的港湾”。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 学生一旦出现心理问题就会有一系列的表现形式，轻度的少语、独处等；中度的考前综合症，睡眠困难等；重度的厌学、妄想症等都在提示着学生的心理出现了问题，及时的关注到这些表现形式也有利于学生心理问题的减轻和解决。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 最后，杨老师就学生心理问题的早期介入提供了一些切实可行的方法。做好预防工作，鼓励学生正确的面对压力与挫折，在平时就做好学生的心理辅导，增强学生应对挫折的能力；以真诚的态度对学生及时开导，做好考后谈心工作，给学生以心理的抚慰，促进学生正视成绩；为学生提供一些认识问题的角度和解决办法，帮助学生解决学习、生活中的困难，如：针对考前焦虑，邀请学生列举自己面临的问题，并制定计划逐一解决，即使考前没解决完，考后依旧可以继续解决，帮助学生正视困难。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 除此之外，还可以寻求一些帮助。在家庭方面，多与家长沟通聊天，家长在教导孩子的过程中也会遇到很多问题，班主任多与家长沟通，不仅能够更好的了解学生的情况，同时也可以分享教育经验，缓解学生的压力，促进正能量在家庭中的传递；其次，促进同辈互助，构建互助友爱的班级氛围。邀请班上同学分享学习方法，关爱班级中一些交流困难的学生，既有利于班级氛围的构建，让学生感受到集体的关爱，也能够培养学生的责任意识。除了家庭及同学的帮助，心理咨询师也能够很好的帮助到学生，班主任要帮助同学树立正确的对于心理咨询的认识，让学生了解寻求心理咨询师的帮助是非常正常的。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 杨老师的分享从多个角度让我们对学生的心理有了更深的了解，也学习到了很多学生心理问题早期介入的方法。促进学生身心的健康发展也是实外一直奋斗的目标，相信通过不断地学习，实外的班主任队伍也会建设得越来越好！</div>/l/<div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	为贯彻王校长“特色立校，德育为先”的办学思想，践行学校“人文开放，和谐发展，构建学习型班主任队伍”的德育理念，加强班主任队伍的专业化建设，成都市实验外国语学校于2017年4月26日开展“班主任论坛”活动。本次论坛邀请了拥有丰富带班经验的杨震国老师为班主任做有关“学生心理问题的发现与早期介入”的分享。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 学生心理的健康发展一直是班主任关注的重点，本次论坛杨震国老师从学生心理问题产生原因，学生产生心理问题时的表现以及学生心理问题的早期介入这三个方面和班主任们做了分享。精彩的发言，切合实际的方法，杨老师在论坛上分享满满的干货，引起了广泛共鸣，赢得了所有年级主任、班主任的一致好评。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;text-align:center;\">	<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 谈及学生心理问题产生的原因，杨老师从学生个人、家庭、群体以及阶段性因素进行了分析。学生的学习、人际关系、性格、对自身的要求、缺乏家庭的关爱等都会让学生感受到压力，从而造成心理问题。其中家庭因素占首要位置，家长对孩子的期待，对孩子的教育方式、对孩子的关心程度等都会影响孩子心理健康的发展，杨老师主张班主任多与家长沟通，帮助家长理解“家不是说理的地方，而是孩子爱的港湾”。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 学生一旦出现心理问题就会有一系列的表现形式，轻度的少语、独处等；中度的考前综合症，睡眠困难等；重度的厌学、妄想症等都在提示着学生的心理出现了问题，及时的关注到这些表现形式也有利于学生心理问题的减轻和解决。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 最后，杨老师就学生心理问题的早期介入提供了一些切实可行的方法。做好预防工作，鼓励学生正确的面对压力与挫折，在平时就做好学生的心理辅导，增强学生应对挫折的能力；以真诚的态度对学生及时开导，做好考后谈心工作，给学生以心理的抚慰，促进学生正视成绩；为学生提供一些认识问题的角度和解决办法，帮助学生解决学习、生活中的困难，如：针对考前焦虑，邀请学生列举自己面临的问题，并制定计划逐一解决，即使考前没解决完，考后依旧可以继续解决，帮助学生正视困难。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 除此之外，还可以寻求一些帮助。在家庭方面，多与家长沟通聊天，家长在教导孩子的过程中也会遇到很多问题，班主任多与家长沟通，不仅能够更好的了解学生的情况，同时也可以分享教育经验，缓解学生的压力，促进正能量在家庭中的传递；其次，促进同辈互助，构建互助友爱的班级氛围。邀请班上同学分享学习方法，关爱班级中一些交流困难的学生，既有利于班级氛围的构建，让学生感受到集体的关爱，也能够培养学生的责任意识。除了家庭及同学的帮助，心理咨询师也能够很好的帮助到学生，班主任要帮助同学树立正确的对于心理咨询的认识，让学生了解寻求心理咨询师的帮助是非常正常的。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp; &nbsp; &nbsp; &nbsp; 杨老师的分享从多个角度让我们对学生的心理有了更深的了解，也学习到了很多学生心理问题早期介入的方法。促进学生身心的健康发展也是实外一直奋斗的目标，相信通过不断地学习，实外的班主任队伍也会建设得越来越好！</div>(en)','2017-10-24 20:48:35','admin','100','104','images/nopic.png','0','	为贯彻王校长“特色立校，德育为先”的办学思想，践行学校“人文开放，和谐发展，构建学习型班主任队伍”的德育理念，加强班主任队伍的专业化建设，成都市实验外国语学校于2017年4月26日开展“班主任论坛”活动。本次论坛邀请了拥有丰富带班经验的杨震国老师为班主任做有关“学生心理问题的发现与早期介入”的分享。&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp; 学生心理的健康发展一直是班主/l/	为贯彻王校长“特色立校，德育为先”的办学思想，践行学校“人文开放，和谐发展，构建学习型班主任队伍”的德育理念，加强班主任队伍的专业化建设，成都市实验外国语学校于2017年4月26日开展“班主任论坛”活动。本次论坛邀请了拥有丰富带班经验的杨震国老师为班主任做有关“学生心理问题的发现与早期介入”的分享。&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp; 学生心理的健康发展一直是班主(en)','0','0','0','介入,早期,发现,心理问题/l/介入,早期,发现,心理问题(en)','	为贯彻王校长“特色立校，德育为先”的办学思想，践行学校“人文开放，和谐发展，构建学习型班主任队伍”的德育理念，加强班主任队伍的专业化建设，成都市实验外国语学校于2017年4月26日开展“班主任论坛”活动。本次论坛邀请了拥有丰富带班经验的杨震国老师为班主任做有关“学生心理问题的发现与早期介入”的分享。&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp; 学生心理的健康发展一直是班主/l/	为贯彻王校长“特色立校，德育为先”的办学思想，践行学校“人文开放，和谐发展，构建学习型班主任队伍”的德育理念，加强班主任队伍的专业化建设，成都市实验外国语学校于2017年4月26日开展“班主任论坛”活动。本次论坛邀请了拥有丰富带班经验的杨震国老师为班主任做有关“学生心理问题的发现与早期介入”的分享。&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp; 学生心理的健康发展一直是班主(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('28','青春飞扬，活力无限/l/青春飞扬，活力无限(en)','<div style=\"box-sizing:border-box;\">	&nbsp;青春是多彩而美好的，在这阳光灿烂的日子里，成都市实验外国语学校全体高三学生齐聚操场，举行趣味运动会。学校希望通过趣味运动会的开展，不仅让即将面临高考的学子们缓解学习上的压力，更是让他们在趣味活动中彰显活动，增强团队凝聚力，促进高三学子身心的调节，让他们以饱满的姿态，自信的迎接高考的到来。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	&nbsp; &nbsp; &nbsp; &nbsp; 趣味运动会共分四个环节，以接力的形式进行，利用动静结合的方式帮助学生调节心态，充分调动了他们的运动天分和思维能力。首先进行的便是穿针引线。穿针引线不仅考验着学生的动手能力，更是锻炼他们面对困难时的沉着冷静。第二项是夹玻璃球，这项活动更多的是锻炼学生在紧张情况下的动手以及眼手协调能力。第三项即是跳绳，让学生们全身心的动起来，甩掉压力。第四项是乒乓球的搬运工，这是一项非常考验技术的活动，需要学生们掌握好技巧，一气呵成。操场上，各班学子互相帮忙，有的帮忙摆绳，有的协助往纸杯中倒水，有的像团队后面参赛的成员传授技巧……大家在互帮互助中共同完成一个个挑战，在操场上挥洒汗水，展露笑颜，飞扬青春，展示他们的青春活力。</div>/l/<div style=\"box-sizing:border-box;\">	&nbsp;青春是多彩而美好的，在这阳光灿烂的日子里，成都市实验外国语学校全体高三学生齐聚操场，举行趣味运动会。学校希望通过趣味运动会的开展，不仅让即将面临高考的学子们缓解学习上的压力，更是让他们在趣味活动中彰显活动，增强团队凝聚力，促进高三学子身心的调节，让他们以饱满的姿态，自信的迎接高考的到来。<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	&nbsp; &nbsp; &nbsp; &nbsp; 趣味运动会共分四个环节，以接力的形式进行，利用动静结合的方式帮助学生调节心态，充分调动了他们的运动天分和思维能力。首先进行的便是穿针引线。穿针引线不仅考验着学生的动手能力，更是锻炼他们面对困难时的沉着冷静。第二项是夹玻璃球，这项活动更多的是锻炼学生在紧张情况下的动手以及眼手协调能力。第三项即是跳绳，让学生们全身心的动起来，甩掉压力。第四项是乒乓球的搬运工，这是一项非常考验技术的活动，需要学生们掌握好技巧，一气呵成。操场上，各班学子互相帮忙，有的帮忙摆绳，有的协助往纸杯中倒水，有的像团队后面参赛的成员传授技巧……大家在互帮互助中共同完成一个个挑战，在操场上挥洒汗水，展露笑颜，飞扬青春，展示他们的青春活力。</div>(en)','2017-10-24 20:49:12','admin','100','1','images/nopic.png','0','	&nbsp;青春是多彩而美好的，在这阳光灿烂的日子里，成都市实验外国语学校全体高三学生齐聚操场，举行趣味运动会。学校希望通过趣味运动会的开展，不仅让即将面临高考的学子们缓解学习上的压力，更是让他们在趣味活动中彰显活动，增强团队凝聚力，促进高三学子身心的调节，让他们以饱满的姿态，自信的迎接高考的到来。&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp; 趣味运动会共分四个环节，以接/l/	&nbsp;青春是多彩而美好的，在这阳光灿烂的日子里，成都市实验外国语学校全体高三学生齐聚操场，举行趣味运动会。学校希望通过趣味运动会的开展，不仅让即将面临高考的学子们缓解学习上的压力，更是让他们在趣味活动中彰显活动，增强团队凝聚力，促进高三学子身心的调节，让他们以饱满的姿态，自信的迎接高考的到来。&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp; 趣味运动会共分四个环节，以接(en)','0','0','0','无限,活力/l/无限,活力(en)','	&nbsp;青春是多彩而美好的，在这阳光灿烂的日子里，成都市实验外国语学校全体高三学生齐聚操场，举行趣味运动会。学校希望通过趣味运动会的开展，不仅让即将面临高考的学子们缓解学习上的压力，更是让他们在趣味活动中彰显活动，增强团队凝聚力，促进高三学子身心的调节，让他们以饱满的姿态，自信的迎接高考的到来。&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp; 趣味运动会共分四个环节，以接/l/	&nbsp;青春是多彩而美好的，在这阳光灿烂的日子里，成都市实验外国语学校全体高三学生齐聚操场，举行趣味运动会。学校希望通过趣味运动会的开展，不仅让即将面临高考的学子们缓解学习上的压力，更是让他们在趣味活动中彰显活动，增强团队凝聚力，促进高三学子身心的调节，让他们以饱满的姿态，自信的迎接高考的到来。&nbsp;	&nbsp; &nbsp; &nbsp; &nbsp; 趣味运动会共分四个环节，以接(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('29','我校2017年新教师上岗培训/l/我校2017年新教师上岗培训(en)','<div style=\"box-sizing:border-box;\">	每年暑假我校都会迎来一批新教师的加入。这中间有不少刚从校园走出的优秀大学生。新生力量的增加使我校在未来的教育教学上有着无限活力与多样风格。而不同的发展平台也促使教师要尽快适应新环境，不断提高自我学习能力，不断提高自我要求。</div><div style=\"box-sizing:border-box;\">	<br style=\"box-sizing:border-box;\" />为使新进教师更好了解我校办学理念、校园文化、历史传承从而更好的融入实外集体，真正成为一个实外人，我校22日进行了新教师集中通识培训。会上，王校长围绕“生生不息、实外精神传承”的主题做了讲话，对新教师们致欢迎词。校领导为新教师们进行了学校外语特色介绍，并做了“教师的专业与成长”和“教师的职业规范等”培训，同时邀请了两位优秀的青年教师王未杪和王鹏分享了他们在实外的成长经历。从讲座后的互动活动中，我们知道新教师对自己选择的未来有了更多的认识和信心。</div><div style=\"box-sizing:border-box;\">	<br style=\"box-sizing:border-box;\" />23日，由各教研组备课组具体安排，各校领导分工到组，我校对新教师们进行了分学科岗前培训。实外作为一个优秀的集体，二十年来在学科建设和备课组活动中形成了各自的基本共识和教学理念。且各教研组、备课组人才辈出，每一位优秀的教师都不吝把自己的教学与学习经验无私分享，不吝把自己学习提升的道路和方法指给新人。他们介绍实外学生群体各方面情况，介绍本组学科教学理念教学追求，举例示范，故事分享。他们用自己的不断学习带动组内成员共同提高，用自己做榜样来影响一群刚入职的人，实外教研组的老师们就是这样无私与高尚，而结果就是，这一个组都变得强大，这一群人一起走得更远。</div>/l/<div style=\"box-sizing:border-box;\">	每年暑假我校都会迎来一批新教师的加入。这中间有不少刚从校园走出的优秀大学生。新生力量的增加使我校在未来的教育教学上有着无限活力与多样风格。而不同的发展平台也促使教师要尽快适应新环境，不断提高自我学习能力，不断提高自我要求。</div><div style=\"box-sizing:border-box;\">	<br style=\"box-sizing:border-box;\" />为使新进教师更好了解我校办学理念、校园文化、历史传承从而更好的融入实外集体，真正成为一个实外人，我校22日进行了新教师集中通识培训。会上，王校长围绕“生生不息、实外精神传承”的主题做了讲话，对新教师们致欢迎词。校领导为新教师们进行了学校外语特色介绍，并做了“教师的专业与成长”和“教师的职业规范等”培训，同时邀请了两位优秀的青年教师王未杪和王鹏分享了他们在实外的成长经历。从讲座后的互动活动中，我们知道新教师对自己选择的未来有了更多的认识和信心。</div><div style=\"box-sizing:border-box;\">	<br style=\"box-sizing:border-box;\" />23日，由各教研组备课组具体安排，各校领导分工到组，我校对新教师们进行了分学科岗前培训。实外作为一个优秀的集体，二十年来在学科建设和备课组活动中形成了各自的基本共识和教学理念。且各教研组、备课组人才辈出，每一位优秀的教师都不吝把自己的教学与学习经验无私分享，不吝把自己学习提升的道路和方法指给新人。他们介绍实外学生群体各方面情况，介绍本组学科教学理念教学追求，举例示范，故事分享。他们用自己的不断学习带动组内成员共同提高，用自己做榜样来影响一群刚入职的人，实外教研组的老师们就是这样无私与高尚，而结果就是，这一个组都变得强大，这一群人一起走得更远。</div>(en)','2017-10-24 20:50:17','admin','100','7','images/nopic.png','0','	每年暑假我校都会迎来一批新教师的加入。这中间有不少刚从校园走出的优秀大学生。新生力量的增加使我校在未来的教育教学上有着无限活力与多样风格。而不同的发展平台也促使教师要尽快适应新环境，不断提高自我学习能力，不断提高自我要求。	为使新进教师更好了解我校办学理念、校园文化、历史传承从而更好的融入实外集体，真正成为一个实外人，我校22日进行了新教师集中通识培训。会上，王校长围绕“生生不息、实外精神传承”/l/	每年暑假我校都会迎来一批新教师的加入。这中间有不少刚从校园走出的优秀大学生。新生力量的增加使我校在未来的教育教学上有着无限活力与多样风格。而不同的发展平台也促使教师要尽快适应新环境，不断提高自我学习能力，不断提高自我要求。	为使新进教师更好了解我校办学理念、校园文化、历史传承从而更好的融入实外集体，真正成为一个实外人，我校22日进行了新教师集中通识培训。会上，王校长围绕“生生不息、实外精神传承”(en)','0','0','0','培训,上岗,教师/l/培训,上岗,教师(en)','	每年暑假我校都会迎来一批新教师的加入。这中间有不少刚从校园走出的优秀大学生。新生力量的增加使我校在未来的教育教学上有着无限活力与多样风格。而不同的发展平台也促使教师要尽快适应新环境，不断提高自我学习能力，不断提高自我要求。	为使新进教师更好了解我校办学理念、校园文化、历史传承从而更好的融入实外集体，真正成为一个实外人，我校22日进行了新教师集中通识培训。会上，王校长围绕“生生不息、实外精神传承”/l/	每年暑假我校都会迎来一批新教师的加入。这中间有不少刚从校园走出的优秀大学生。新生力量的增加使我校在未来的教育教学上有着无限活力与多样风格。而不同的发展平台也促使教师要尽快适应新环境，不断提高自我学习能力，不断提高自我要求。	为使新进教师更好了解我校办学理念、校园文化、历史传承从而更好的融入实外集体，真正成为一个实外人，我校22日进行了新教师集中通识培训。会上，王校长围绕“生生不息、实外精神传承”(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('30','野外紧急避震必知技巧/l/野外紧急避震必知技巧(en)','<span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">地震来临之前有什么预防措施吗?下面是出国留学网小编为您带来的“野外紧急避震必知技巧”的最新资讯，很多精彩请锁定出国留学网实用资料栏目。 　　<br /></span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">1.在郊外遇到地震时，尽量找空旷的地带躲避，远离山脚、陡崖等危险地带。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">2.当遇到山崩、滑坡日寸，应沿斜坡横向水平方向撤离，躲在结实的障碍物或地洶、地坎下。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">3.正在野外的人，要迅速离开河边、水坝或桥梁，防止地震时河岸坍塌、堤坝跨塌。要避开山脚、陡崖，以防山崩、滚石、滑坡、泥石流等，如遇山崩、滑坡，要迅速向滚石两侧躲避，切不可顺着滚石方向往山下跑;不能到桥下、隧道里避震，以免塌方造成伤亡。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">4.迅速离开山边、水边等危险环境。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">5.避开危险物、高耸或悬挂的物品变压器、电线杆、路灯等;广告牌、吊车等。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">6.不要乱跑,避开人多的地方,不能随便返回室内。 　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">三大原则 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">原则一：因地制宜，正确抉择。是住平房还是住楼房，地震发生在白天还是晚上，房子是不是坚固，室内有没有避震空间，你所处的位置离房门远近，室外是否开阔、安全。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">原则二：行动果断、切忌犹豫。避震能否成功，就在千钧一发之际，决不能瞻前顾后，犹豫不决。如住平房避震时，更要行动果断，或就近躲避，或紧急外出，切勿往返。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">原则三：伏而待定，不可疾出。古人在《地震录》里曾记载：\"卒然闻变，不可疾出，伏而待定，纵有覆巢，可冀完卵\"，意思就是说，发生地震时，不要急着跑出室外，而应抓紧求生时间寻找合适的避震场所，采取蹲下或坐下的方式，静待地震过去，这样即使房屋倒塌，人亦可安然无恙。</span>/l/<span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">地震来临之前有什么预防措施吗?下面是出国留学网小编为您带来的“野外紧急避震必知技巧”的最新资讯，很多精彩请锁定出国留学网实用资料栏目。 　　<br /></span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">1.在郊外遇到地震时，尽量找空旷的地带躲避，远离山脚、陡崖等危险地带。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">2.当遇到山崩、滑坡日寸，应沿斜坡横向水平方向撤离，躲在结实的障碍物或地洶、地坎下。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">3.正在野外的人，要迅速离开河边、水坝或桥梁，防止地震时河岸坍塌、堤坝跨塌。要避开山脚、陡崖，以防山崩、滚石、滑坡、泥石流等，如遇山崩、滑坡，要迅速向滚石两侧躲避，切不可顺着滚石方向往山下跑;不能到桥下、隧道里避震，以免塌方造成伤亡。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">4.迅速离开山边、水边等危险环境。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">5.避开危险物、高耸或悬挂的物品变压器、电线杆、路灯等;广告牌、吊车等。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">6.不要乱跑,避开人多的地方,不能随便返回室内。 　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">三大原则 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">原则一：因地制宜，正确抉择。是住平房还是住楼房，地震发生在白天还是晚上，房子是不是坚固，室内有没有避震空间，你所处的位置离房门远近，室外是否开阔、安全。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">原则二：行动果断、切忌犹豫。避震能否成功，就在千钧一发之际，决不能瞻前顾后，犹豫不决。如住平房避震时，更要行动果断，或就近躲避，或紧急外出，切勿往返。 　　</span><br style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\" /><span style=\"color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">原则三：伏而待定，不可疾出。古人在《地震录》里曾记载：\"卒然闻变，不可疾出，伏而待定，纵有覆巢，可冀完卵\"，意思就是说，发生地震时，不要急着跑出室外，而应抓紧求生时间寻找合适的避震场所，采取蹲下或坐下的方式，静待地震过去，这样即使房屋倒塌，人亦可安然无恙。</span>(en)','2017-10-24 20:50:30','admin','100','106','images/nopic.png','0','地震来临之前有什么预防措施吗?下面是出国留学网小编为您带来的“野外紧急避震必知技巧”的最新资讯，很多精彩请锁定出国留学网实用资料栏目。 　　1.在郊外遇到地震时，尽量找空旷的地带躲避，远离山脚、陡崖等危险地带。 　　2.当遇到山崩、滑坡日寸，应沿斜坡横向水平方向撤离，躲在结实的障碍物或地洶、地坎下。 　　3.正在野外的人，要迅速离开河边、水坝或桥梁，防止地震时河岸坍塌、堤坝跨塌。要避开山脚、陡崖，/l/地震来临之前有什么预防措施吗?下面是出国留学网小编为您带来的“野外紧急避震必知技巧”的最新资讯，很多精彩请锁定出国留学网实用资料栏目。 　　1.在郊外遇到地震时，尽量找空旷的地带躲避，远离山脚、陡崖等危险地带。 　　2.当遇到山崩、滑坡日寸，应沿斜坡横向水平方向撤离，躲在结实的障碍物或地洶、地坎下。 　　3.正在野外的人，要迅速离开河边、水坝或桥梁，防止地震时河岸坍塌、堤坝跨塌。要避开山脚、陡崖，(en)','0','0','0','技巧/l/技巧(en)','地震来临之前有什么预防措施吗?下面是出国留学网小编为您带来的“野外紧急避震必知技巧”的最新资讯，很多精彩请锁定出国留学网实用资料栏目。 　　1.在郊外遇到地震时，尽量找空旷的地带躲避，远离山脚、陡崖等危险地带。 　　2.当遇到山崩、滑坡日寸，应沿斜坡横向水平方向撤离，躲在结实的障碍物或地洶、地坎下。 　　3.正在野外的人，要迅速离开河边、水坝或桥梁，防止地震时河岸坍塌、堤坝跨塌。要避开山脚、陡崖，/l/地震来临之前有什么预防措施吗?下面是出国留学网小编为您带来的“野外紧急避震必知技巧”的最新资讯，很多精彩请锁定出国留学网实用资料栏目。 　　1.在郊外遇到地震时，尽量找空旷的地带躲避，远离山脚、陡崖等危险地带。 　　2.当遇到山崩、滑坡日寸，应沿斜坡横向水平方向撤离，躲在结实的障碍物或地洶、地坎下。 　　3.正在野外的人，要迅速离开河边、水坝或桥梁，防止地震时河岸坍塌、堤坝跨塌。要避开山脚、陡崖，(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('31','公务员面试技巧：克服当众说话的恐惧感/l/公务员面试技巧：克服当众说话的恐惧感(en)','爱默森曾说过：“恐惧较之世上任何事物更能击溃人类。”人类最害怕的三件事中，当众演讲居然超过死亡位居榜首。而当众说话与当众演讲并没有太过于本质的区别，公务员面试不仅要当众说话而且结果直接关系个人的职业发展，因此面试时的紧张与恐惧任何人都难以避免。下面将帮助大家调整紧张状态与恐惧感，从而在面试中脱颖而出。 　　<br style=\"box-sizing:border-box;\" /><div style=\"box-sizing:border-box;\">	<br /></div><br style=\"box-sizing:border-box;\" />一、要有自信 　　自信首先是要相信自己的能力，参加公务员面试的考生都是战胜几十人、几百人甚至是几千人的勇士，面对千人大战敢战即是勇，能胜便是智，因此要充分认识到自身的长处;其次，要明白面试与笔试的区别，通过简单的测试发现自身问题，对症下药，最大程度弥补自身不足;再次，不要给自己过多的压力，太注重成败，要明白这只是人生中的一次尝试;最后，面试过程中注意与考官进行眼神交流。大多数考生在未系统学习前，不敢直视面试官的眼睛。其实这已经暴露出你的不自信。偌大的考场只有考生一个人表演，一举一动考官尽收眼底，适当增加与考官的眼神交流，能增加考生的气场。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />二、要多做练习 　　所谓熟能生巧，尽可能熟悉考试的模式、内容、流程。大多数时候人们的紧张恐惧感源于未知，源于对考场的不熟悉。通过系统化学习面试的主要内容，从本质上提升面试竞争力;尽量多找些同伴一起模拟练习，习惯在人多的场合说话，并提前考虑面试时可能出现的各种突发状况，提前想好应对方法。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />三、多做积极的心理暗示 　　面试前要习惯多给自己积极的心理暗示，如果出现紧张情绪，告诉自己，一定可以的，用言语暗示“沉着”、“冷静”、 “停止紧张”，同时进行有规律的深呼吸，尽量放松肌肉，使血液循环减慢，以减弱身体的紧张状态，直到紧张情况缓解。同时也可以把考官想象得更友善一些，他们大多比考生年长，把面试看成是与长者的聊天即可。也可以把自己的紧张感直接说出来，告知考官你的想法，这样的话语往往也能有效缓解恐惧心理。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />北京公务员面试其实远没有大家想得那么可怕，只要大家踏踏实实备考，多加练习，转变思想，一定能一举成“公”。/l/爱默森曾说过：“恐惧较之世上任何事物更能击溃人类。”人类最害怕的三件事中，当众演讲居然超过死亡位居榜首。而当众说话与当众演讲并没有太过于本质的区别，公务员面试不仅要当众说话而且结果直接关系个人的职业发展，因此面试时的紧张与恐惧任何人都难以避免。下面将帮助大家调整紧张状态与恐惧感，从而在面试中脱颖而出。 　　<br style=\"box-sizing:border-box;\" /><div style=\"box-sizing:border-box;\">	<br /></div><br style=\"box-sizing:border-box;\" />一、要有自信 　　自信首先是要相信自己的能力，参加公务员面试的考生都是战胜几十人、几百人甚至是几千人的勇士，面对千人大战敢战即是勇，能胜便是智，因此要充分认识到自身的长处;其次，要明白面试与笔试的区别，通过简单的测试发现自身问题，对症下药，最大程度弥补自身不足;再次，不要给自己过多的压力，太注重成败，要明白这只是人生中的一次尝试;最后，面试过程中注意与考官进行眼神交流。大多数考生在未系统学习前，不敢直视面试官的眼睛。其实这已经暴露出你的不自信。偌大的考场只有考生一个人表演，一举一动考官尽收眼底，适当增加与考官的眼神交流，能增加考生的气场。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />二、要多做练习 　　所谓熟能生巧，尽可能熟悉考试的模式、内容、流程。大多数时候人们的紧张恐惧感源于未知，源于对考场的不熟悉。通过系统化学习面试的主要内容，从本质上提升面试竞争力;尽量多找些同伴一起模拟练习，习惯在人多的场合说话，并提前考虑面试时可能出现的各种突发状况，提前想好应对方法。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />三、多做积极的心理暗示 　　面试前要习惯多给自己积极的心理暗示，如果出现紧张情绪，告诉自己，一定可以的，用言语暗示“沉着”、“冷静”、 “停止紧张”，同时进行有规律的深呼吸，尽量放松肌肉，使血液循环减慢，以减弱身体的紧张状态，直到紧张情况缓解。同时也可以把考官想象得更友善一些，他们大多比考生年长，把面试看成是与长者的聊天即可。也可以把自己的紧张感直接说出来，告知考官你的想法，这样的话语往往也能有效缓解恐惧心理。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />北京公务员面试其实远没有大家想得那么可怕，只要大家踏踏实实备考，多加练习，转变思想，一定能一举成“公”。(en)','2017-10-24 20:50:59','admin','101','106','images/nopic.png','0','爱默森曾说过：“恐惧较之世上任何事物更能击溃人类。”人类最害怕的三件事中，当众演讲居然超过死亡位居榜首。而当众说话与当众演讲并没有太过于本质的区别，公务员面试不仅要当众说话而且结果直接关系个人的职业发展，因此面试时的紧张与恐惧任何人都难以避免。下面将帮助大家调整紧张状态与恐惧感，从而在面试中脱颖而出。 　　	一、要有自信 　　自信首先是要相信自己的能力，参加公务员面试的考生都是战胜几十人、几百人甚/l/爱默森曾说过：“恐惧较之世上任何事物更能击溃人类。”人类最害怕的三件事中，当众演讲居然超过死亡位居榜首。而当众说话与当众演讲并没有太过于本质的区别，公务员面试不仅要当众说话而且结果直接关系个人的职业发展，因此面试时的紧张与恐惧任何人都难以避免。下面将帮助大家调整紧张状态与恐惧感，从而在面试中脱颖而出。 　　	一、要有自信 　　自信首先是要相信自己的能力，参加公务员面试的考生都是战胜几十人、几百人甚(en)','0','0','0','恐惧,说话,当众,克服,面试技巧,公务员/l/恐惧,说话,当众,克服,面试技巧,公务员(en)','爱默森曾说过：“恐惧较之世上任何事物更能击溃人类。”人类最害怕的三件事中，当众演讲居然超过死亡位居榜首。而当众说话与当众演讲并没有太过于本质的区别，公务员面试不仅要当众说话而且结果直接关系个人的职业发展，因此面试时的紧张与恐惧任何人都难以避免。下面将帮助大家调整紧张状态与恐惧感，从而在面试中脱颖而出。 　　	一、要有自信 　　自信首先是要相信自己的能力，参加公务员面试的考生都是战胜几十人、几百人甚/l/爱默森曾说过：“恐惧较之世上任何事物更能击溃人类。”人类最害怕的三件事中，当众演讲居然超过死亡位居榜首。而当众说话与当众演讲并没有太过于本质的区别，公务员面试不仅要当众说话而且结果直接关系个人的职业发展，因此面试时的紧张与恐惧任何人都难以避免。下面将帮助大家调整紧张状态与恐惧感，从而在面试中脱颖而出。 　　	一、要有自信 　　自信首先是要相信自己的能力，参加公务员面试的考生都是战胜几十人、几百人甚(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('32','销售技巧：换位思考从消费者角度出发/l/销售技巧：换位思考从消费者角度出发(en)','1、要想钓到鱼，就得像鱼一样思考，而不是像渔夫那样思考。换句话说，要把东西卖给客户，你就必须知道客户在想什么，需要什么。 　　<br style=\"box-sizing:border-box;\" />2、一个专业的销售人员，想提高自己的销售业绩，就必须站在客户的角度想问题。 　　<br style=\"box-sizing:border-box;\" />3、以客户为中心，把客户最关心的东西放在最前面是一种经营战略，客户关心什么，你就要注意什么。 　　<br style=\"box-sizing:border-box;\" />4、骗子的手段千变万化，但万变不离其宗，只要牢记：A:天下没有免费的午餐，天下不会掉下馅饼 B：不见兔子不撒鹰，问客户一些产品的专业话题。 　　<br style=\"box-sizing:border-box;\" />5、你的话越简练就越有吸引力，紧紧抓住客户的心理才是最重要的，客户需要的是实实在在的信息，而不是销售废话。 　　<br style=\"box-sizing:border-box;\" />6、别自以为什么都懂，把客户当笨蛋白痴。 　　<br style=\"box-sizing:border-box;\" />7、假如这是你的钱，你会怎么做。 　　<br style=\"box-sizing:border-box;\" />8、销售人员最直接的目的就是从客户的口袋里掏钱。 　　<br style=\"box-sizing:border-box;\" />9、给客户讲解价值给价格重要。 　　<br style=\"box-sizing:border-box;\" />10、只有一句话，告诉客户：你花钱购买和不买相比，不买的损失更大，利益是相对的，权衡利弊，客户不是傻瓜。如果客户对你的推销不感兴趣，那么原因可能有两个：他们没有意识到不买的损失;他们对你不够信任，不想与你分享他们的痛楚。/l/1、要想钓到鱼，就得像鱼一样思考，而不是像渔夫那样思考。换句话说，要把东西卖给客户，你就必须知道客户在想什么，需要什么。 　　<br style=\"box-sizing:border-box;\" />2、一个专业的销售人员，想提高自己的销售业绩，就必须站在客户的角度想问题。 　　<br style=\"box-sizing:border-box;\" />3、以客户为中心，把客户最关心的东西放在最前面是一种经营战略，客户关心什么，你就要注意什么。 　　<br style=\"box-sizing:border-box;\" />4、骗子的手段千变万化，但万变不离其宗，只要牢记：A:天下没有免费的午餐，天下不会掉下馅饼 B：不见兔子不撒鹰，问客户一些产品的专业话题。 　　<br style=\"box-sizing:border-box;\" />5、你的话越简练就越有吸引力，紧紧抓住客户的心理才是最重要的，客户需要的是实实在在的信息，而不是销售废话。 　　<br style=\"box-sizing:border-box;\" />6、别自以为什么都懂，把客户当笨蛋白痴。 　　<br style=\"box-sizing:border-box;\" />7、假如这是你的钱，你会怎么做。 　　<br style=\"box-sizing:border-box;\" />8、销售人员最直接的目的就是从客户的口袋里掏钱。 　　<br style=\"box-sizing:border-box;\" />9、给客户讲解价值给价格重要。 　　<br style=\"box-sizing:border-box;\" />10、只有一句话，告诉客户：你花钱购买和不买相比，不买的损失更大，利益是相对的，权衡利弊，客户不是傻瓜。如果客户对你的推销不感兴趣，那么原因可能有两个：他们没有意识到不买的损失;他们对你不够信任，不想与你分享他们的痛楚。(en)','2017-10-24 20:51:24','admin','100','108','images/nopic.png','0','1、要想钓到鱼，就得像鱼一样思考，而不是像渔夫那样思考。换句话说，要把东西卖给客户，你就必须知道客户在想什么，需要什么。 　　2、一个专业的销售人员，想提高自己的销售业绩，就必须站在客户的角度想问题。 　　3、以客户为中心，把客户最关心的东西放在最前面是一种经营战略，客户关心什么，你就要注意什么。 　　4、骗子的手段千变万化，但万变不离其宗，只要牢记：A:天下没有免费的午餐，天下不会掉下馅饼 B：/l/1、要想钓到鱼，就得像鱼一样思考，而不是像渔夫那样思考。换句话说，要把东西卖给客户，你就必须知道客户在想什么，需要什么。 　　2、一个专业的销售人员，想提高自己的销售业绩，就必须站在客户的角度想问题。 　　3、以客户为中心，把客户最关心的东西放在最前面是一种经营战略，客户关心什么，你就要注意什么。 　　4、骗子的手段千变万化，但万变不离其宗，只要牢记：A:天下没有免费的午餐，天下不会掉下馅饼 B：(en)','0','0','0','出发,角度,消费者,思考,换位/l/出发,角度,消费者,思考,换位(en)','1、要想钓到鱼，就得像鱼一样思考，而不是像渔夫那样思考。换句话说，要把东西卖给客户，你就必须知道客户在想什么，需要什么。 　　2、一个专业的销售人员，想提高自己的销售业绩，就必须站在客户的角度想问题。 　　3、以客户为中心，把客户最关心的东西放在最前面是一种经营战略，客户关心什么，你就要注意什么。 　　4、骗子的手段千变万化，但万变不离其宗，只要牢记：A:天下没有免费的午餐，天下不会掉下馅饼 B：/l/1、要想钓到鱼，就得像鱼一样思考，而不是像渔夫那样思考。换句话说，要把东西卖给客户，你就必须知道客户在想什么，需要什么。 　　2、一个专业的销售人员，想提高自己的销售业绩，就必须站在客户的角度想问题。 　　3、以客户为中心，把客户最关心的东西放在最前面是一种经营战略，客户关心什么，你就要注意什么。 　　4、骗子的手段千变万化，但万变不离其宗，只要牢记：A:天下没有免费的午餐，天下不会掉下馅饼 B：(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('33','写好网络推广文的六大技巧/l/写好网络推广文的六大技巧(en)','1、目的决定标题写法 　　<br style=\"box-sizing:border-box;\" />标题是十分重要的，必须要吸引公众注意力。但是这也要因情况而异。不能因为哗众取宠而失去公信力。如果你的内容不是用户需要的，标题再好，用户也没有阅读的兴趣。但是软文标题中加入品牌词，就可以达到传播品牌的作用。即使用户没有点击，但是服务和产品已经被用户看到。<br style=\"box-sizing:border-box;\" />　　<br style=\"box-sizing:border-box;\" />2、第一段要写好 　　<br style=\"box-sizing:border-box;\" />如果看完了第一段，没有兴趣和动力看第二段了，那么你就将失去了一次营销的机会。第一段要起到的是一个引子的作用，吸引用户继续阅读后面的文字。研究发现，一个网络用户，如果看到了你的软文的前25%，不觉得讨厌，那么绝大多数人，都会把你的软文从头到尾看完。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />3、简洁、简洁再简洁 　　<br style=\"box-sizing:border-box;\" />发软文不是为了做科普，而是要立即见到效益。在这个信息爆炸的社会，谁也没有耐心仔细看一篇无聊的广告。如果你没有特别的点子吸引人看下去，那么最好的策略就是用最简单的句子，简洁的排版，让对方一眼就找到关心的内容。<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />4、能留电话的话，别留网址 　　<br style=\"box-sizing:border-box;\" />如果网址和电话只能;留一下，那最好只留下电话。当然，电话和网址都需要留，那就都留下好了。总之，不要高估了网友的智商，点击超链虽然可以直接跳转相关页面，但并不是每个人都知道，也不是每个人都愿意。但是打电话应该谁都会。所以如果能用打电话解决的问题，谁肯再花时间浏览你的网站呢? 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />5、SEO优化很重要 　　<br style=\"box-sizing:border-box;\" />软文营销的流量不是你发出去就有的，事实上，我们文章的流量，大多数来自搜索引擎的排名，但是每天你在发软文，你的许多竞争对手也在发软文做营销啊，所以你得琢磨一下，每次发布后，如何优化你的文章?比如关键词设置等，让网友更方便找到你。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />6、选择行业相关的网站 　　<br style=\"box-sizing:border-box;\" />发布在流量越大的门户网站就一定效果好吗?不一定，最好是选择与行业相关的大型网站。一般专业性的网站的受众相对也更精准一些。/l/1、目的决定标题写法 　　<br style=\"box-sizing:border-box;\" />标题是十分重要的，必须要吸引公众注意力。但是这也要因情况而异。不能因为哗众取宠而失去公信力。如果你的内容不是用户需要的，标题再好，用户也没有阅读的兴趣。但是软文标题中加入品牌词，就可以达到传播品牌的作用。即使用户没有点击，但是服务和产品已经被用户看到。<br style=\"box-sizing:border-box;\" />　　<br style=\"box-sizing:border-box;\" />2、第一段要写好 　　<br style=\"box-sizing:border-box;\" />如果看完了第一段，没有兴趣和动力看第二段了，那么你就将失去了一次营销的机会。第一段要起到的是一个引子的作用，吸引用户继续阅读后面的文字。研究发现，一个网络用户，如果看到了你的软文的前25%，不觉得讨厌，那么绝大多数人，都会把你的软文从头到尾看完。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />3、简洁、简洁再简洁 　　<br style=\"box-sizing:border-box;\" />发软文不是为了做科普，而是要立即见到效益。在这个信息爆炸的社会，谁也没有耐心仔细看一篇无聊的广告。如果你没有特别的点子吸引人看下去，那么最好的策略就是用最简单的句子，简洁的排版，让对方一眼就找到关心的内容。<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />4、能留电话的话，别留网址 　　<br style=\"box-sizing:border-box;\" />如果网址和电话只能;留一下，那最好只留下电话。当然，电话和网址都需要留，那就都留下好了。总之，不要高估了网友的智商，点击超链虽然可以直接跳转相关页面，但并不是每个人都知道，也不是每个人都愿意。但是打电话应该谁都会。所以如果能用打电话解决的问题，谁肯再花时间浏览你的网站呢? 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />5、SEO优化很重要 　　<br style=\"box-sizing:border-box;\" />软文营销的流量不是你发出去就有的，事实上，我们文章的流量，大多数来自搜索引擎的排名，但是每天你在发软文，你的许多竞争对手也在发软文做营销啊，所以你得琢磨一下，每次发布后，如何优化你的文章?比如关键词设置等，让网友更方便找到你。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />6、选择行业相关的网站 　　<br style=\"box-sizing:border-box;\" />发布在流量越大的门户网站就一定效果好吗?不一定，最好是选择与行业相关的大型网站。一般专业性的网站的受众相对也更精准一些。(en)','2017-10-24 20:51:45','admin','100','109','images/nopic.png','0','1、目的决定标题写法 　　标题是十分重要的，必须要吸引公众注意力。但是这也要因情况而异。不能因为哗众取宠而失去公信力。如果你的内容不是用户需要的，标题再好，用户也没有阅读的兴趣。但是软文标题中加入品牌词，就可以达到传播品牌的作用。即使用户没有点击，但是服务和产品已经被用户看到。　　2、第一段要写好 　　如果看完了第一段，没有兴趣和动力看第二段了，那么你就将失去了一次营销的机会。第一段要起到的是一个/l/1、目的决定标题写法 　　标题是十分重要的，必须要吸引公众注意力。但是这也要因情况而异。不能因为哗众取宠而失去公信力。如果你的内容不是用户需要的，标题再好，用户也没有阅读的兴趣。但是软文标题中加入品牌词，就可以达到传播品牌的作用。即使用户没有点击，但是服务和产品已经被用户看到。　　2、第一段要写好 　　如果看完了第一段，没有兴趣和动力看第二段了，那么你就将失去了一次营销的机会。第一段要起到的是一个(en)','0','0','0','技巧,六大,网络推广/l/技巧,六大,网络推广(en)','1、目的决定标题写法 　　标题是十分重要的，必须要吸引公众注意力。但是这也要因情况而异。不能因为哗众取宠而失去公信力。如果你的内容不是用户需要的，标题再好，用户也没有阅读的兴趣。但是软文标题中加入品牌词，就可以达到传播品牌的作用。即使用户没有点击，但是服务和产品已经被用户看到。　　2、第一段要写好 　　如果看完了第一段，没有兴趣和动力看第二段了，那么你就将失去了一次营销的机会。第一段要起到的是一个/l/1、目的决定标题写法 　　标题是十分重要的，必须要吸引公众注意力。但是这也要因情况而异。不能因为哗众取宠而失去公信力。如果你的内容不是用户需要的，标题再好，用户也没有阅读的兴趣。但是软文标题中加入品牌词，就可以达到传播品牌的作用。即使用户没有点击，但是服务和产品已经被用户看到。　　2、第一段要写好 　　如果看完了第一段，没有兴趣和动力看第二段了，那么你就将失去了一次营销的机会。第一段要起到的是一个(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('34','教师必备：适用于多个场合的20分钟讲课技巧/l/教师必备：适用于多个场合的20分钟讲课技巧(en)','几乎每个教师都经历过“20分钟的讲课”，比如说在学校参加教师技能大赛，应聘教师试讲等，基本上都是20分钟的讲课。这20分钟的讲课很重要，是决定你能否制胜的关键。因此，就要研究20分钟讲课的技巧。<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />这涉及到语言、板书、PPT以及三者的有机结合;讲课内容的选择及导入;符合认知规律的讲课思路;学思结合的教学方法等。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />1. 语言、板书、PPT以及三者的有机结合 　　<br style=\"box-sizing:border-box;\" />讲课有激情，语言精确 ，语调抑、扬、顿、挫， 注意高、低、快、慢、轻、重、缓、急。 　　<br style=\"box-sizing:border-box;\" />板书要体现：鲜明的层次性;知识脉络清晰;概括主要内容。注意版面设计合理，字迹工整。一个成功的板书设计，就是一个微型教案。 　　<br style=\"box-sizing:border-box;\" />PPT文字表达醒目;内容精炼，高度概括关键、重点内容页面设计和谐美观、布局合理;文字、图表、音频、视频、动画配合恰当，符合讲课主题;色彩搭配合理、协调;内容的进入与讲课进度同步。 　　<br style=\"box-sizing:border-box;\" />良好的语言艺术、工整的板书、醒目的PPT以及三者的有机结合是讲好课的基本功。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />2. 讲课内容的选择 　　<br style=\"box-sizing:border-box;\" />讲课内容的选择是参加教师技能大赛讲课的重点，讲课内容选的好，就是成功的一半。选择讲课内容的原则：能够充分展示你的讲课才能。因此，在选择内容时要注意：内容的完整性，有一定的知识深度;说理性强，有严密的逻辑系统性;便于运用学思结合的教学方法，即启发式、讨论式等。另外，要适当考虑案例教学。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />3. 内容导入 　　<br style=\"box-sizing:border-box;\" />新内容多用生动而精彩的案例导入，这个案例可以涉及社会关注的热点，可以涉及现代高科技，也可以涉及生产、生活实际。通过案例指出新内容要解决的问题，应该使听着的求知欲望立刻升级，调动听者的学习积极性。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />4. 讲课内容条理清晰，符合认知规律 　　<br style=\"box-sizing:border-box;\" />这一点就是要把讲课的内容按照认知规律依次详细分解成若干个最小单元，形成自己的层次分明、具有严密逻辑系统性的讲课思路。符合认知规律的教学思路好比：数学公式的推导;一道几何题的证明;登楼的楼梯，一个台阶一个台阶连续向上。其优点是有利于启发式、讨论式教学，学生易懂易学。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />5. 运用启发式教学，注意学思结合 　　<br style=\"box-sizing:border-box;\" />讲课要体现启发、诱导，引导学生边学边思考，使之生动活泼、主动地进行学习，启发的原则是从学生现有的认知水平出发，遵循“最近发展区”的原则。如果你的讲课思路符合认知规律，你的的启发、诱导很容易成功。这种教学方法的优点就是能够培养学生分析问题和解决问题的能力。/l/几乎每个教师都经历过“20分钟的讲课”，比如说在学校参加教师技能大赛，应聘教师试讲等，基本上都是20分钟的讲课。这20分钟的讲课很重要，是决定你能否制胜的关键。因此，就要研究20分钟讲课的技巧。<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />这涉及到语言、板书、PPT以及三者的有机结合;讲课内容的选择及导入;符合认知规律的讲课思路;学思结合的教学方法等。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />1. 语言、板书、PPT以及三者的有机结合 　　<br style=\"box-sizing:border-box;\" />讲课有激情，语言精确 ，语调抑、扬、顿、挫， 注意高、低、快、慢、轻、重、缓、急。 　　<br style=\"box-sizing:border-box;\" />板书要体现：鲜明的层次性;知识脉络清晰;概括主要内容。注意版面设计合理，字迹工整。一个成功的板书设计，就是一个微型教案。 　　<br style=\"box-sizing:border-box;\" />PPT文字表达醒目;内容精炼，高度概括关键、重点内容页面设计和谐美观、布局合理;文字、图表、音频、视频、动画配合恰当，符合讲课主题;色彩搭配合理、协调;内容的进入与讲课进度同步。 　　<br style=\"box-sizing:border-box;\" />良好的语言艺术、工整的板书、醒目的PPT以及三者的有机结合是讲好课的基本功。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />2. 讲课内容的选择 　　<br style=\"box-sizing:border-box;\" />讲课内容的选择是参加教师技能大赛讲课的重点，讲课内容选的好，就是成功的一半。选择讲课内容的原则：能够充分展示你的讲课才能。因此，在选择内容时要注意：内容的完整性，有一定的知识深度;说理性强，有严密的逻辑系统性;便于运用学思结合的教学方法，即启发式、讨论式等。另外，要适当考虑案例教学。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />3. 内容导入 　　<br style=\"box-sizing:border-box;\" />新内容多用生动而精彩的案例导入，这个案例可以涉及社会关注的热点，可以涉及现代高科技，也可以涉及生产、生活实际。通过案例指出新内容要解决的问题，应该使听着的求知欲望立刻升级，调动听者的学习积极性。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />4. 讲课内容条理清晰，符合认知规律 　　<br style=\"box-sizing:border-box;\" />这一点就是要把讲课的内容按照认知规律依次详细分解成若干个最小单元，形成自己的层次分明、具有严密逻辑系统性的讲课思路。符合认知规律的教学思路好比：数学公式的推导;一道几何题的证明;登楼的楼梯，一个台阶一个台阶连续向上。其优点是有利于启发式、讨论式教学，学生易懂易学。 　　<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />5. 运用启发式教学，注意学思结合 　　<br style=\"box-sizing:border-box;\" />讲课要体现启发、诱导，引导学生边学边思考，使之生动活泼、主动地进行学习，启发的原则是从学生现有的认知水平出发，遵循“最近发展区”的原则。如果你的讲课思路符合认知规律，你的的启发、诱导很容易成功。这种教学方法的优点就是能够培养学生分析问题和解决问题的能力。(en)','2017-10-24 20:53:32','admin','100','110','images/nopic.png','0','几乎每个教师都经历过“20分钟的讲课”，比如说在学校参加教师技能大赛，应聘教师试讲等，基本上都是20分钟的讲课。这20分钟的讲课很重要，是决定你能否制胜的关键。因此，就要研究20分钟讲课的技巧。这涉及到语言、板书、PPT以及三者的有机结合;讲课内容的选择及导入;符合认知规律的讲课思路;学思结合的教学方法等。 　　1. 语言、板书、PPT以及三者的有机结合 　　讲课有激情，语言精确 ，语调抑、扬、顿/l/几乎每个教师都经历过“20分钟的讲课”，比如说在学校参加教师技能大赛，应聘教师试讲等，基本上都是20分钟的讲课。这20分钟的讲课很重要，是决定你能否制胜的关键。因此，就要研究20分钟讲课的技巧。这涉及到语言、板书、PPT以及三者的有机结合;讲课内容的选择及导入;符合认知规律的讲课思路;学思结合的教学方法等。 　　1. 语言、板书、PPT以及三者的有机结合 　　讲课有激情，语言精确 ，语调抑、扬、顿(en)','0','0','0','技巧,讲课,分钟,场合,多个,适用于/l/技巧,讲课,分钟,场合,多个,适用于(en)','几乎每个教师都经历过“20分钟的讲课”，比如说在学校参加教师技能大赛，应聘教师试讲等，基本上都是20分钟的讲课。这20分钟的讲课很重要，是决定你能否制胜的关键。因此，就要研究20分钟讲课的技巧。这涉及到语言、板书、PPT以及三者的有机结合;讲课内容的选择及导入;符合认知规律的讲课思路;学思结合的教学方法等。 　　1. 语言、板书、PPT以及三者的有机结合 　　讲课有激情，语言精确 ，语调抑、扬、顿/l/几乎每个教师都经历过“20分钟的讲课”，比如说在学校参加教师技能大赛，应聘教师试讲等，基本上都是20分钟的讲课。这20分钟的讲课很重要，是决定你能否制胜的关键。因此，就要研究20分钟讲课的技巧。这涉及到语言、板书、PPT以及三者的有机结合;讲课内容的选择及导入;符合认知规律的讲课思路;学思结合的教学方法等。 　　1. 语言、板书、PPT以及三者的有机结合 　　讲课有激情，语言精确 ，语调抑、扬、顿(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('35','带着seo思维选域名 建站就成功了一半/l/带着seo思维选域名 建站就成功了一半(en)','<div style=\"box-sizing:border-box;\">	对于网站来说，域名的选择尤为重要，有些人就不太在意这些，认为网站内容才是关键，这域名随便找个品牌拼音就成了。其实，域名的挑选还有不少名堂，织梦教程网高端网站建设中，常常会带着seo思维去选域名。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(1)优先考虑品牌</div><div style=\"box-sizing:border-box;\">	好的域名并不会把行业词放在里面，就拿百度来说，字面上看与“搜索引擎”毫无关联，可就是国内搜索领域的龙头老大。可见，品牌名称与行业名称来得更重要，有些大公司就是根据品牌词来确定域名的。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(2)域名的续费周期</div><div style=\"box-sizing:border-box;\">	其实，域名的续费周期对网站排名有一定的影响。客观来说，域名续费的周期越长，则说明站长花费在站点上的时间就越长，可见并不是一个垃圾站，可能是一个高质量网站。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(3)域名的后缀</div><div style=\"box-sizing:border-box;\">	部分域名天生就能给网站带来高权重，比如大家熟悉的.gov/.edu。当然了，只有符合条件的才可以注册这种域名。我们可以选择国际通用的，比如.net/.com/.cn等等。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(4)域名的出生时间</div><div style=\"box-sizing:border-box;\">	一个老域名比较值钱，域名注册的越早，对网站排名越有利。这就是为什么有些站长喜欢购买老域名来建站的原因。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(5)首次收录时间</div><div style=\"box-sizing:border-box;\">	有过seo优化经验的朋友们应该清楚，域名第一次被搜索引擎收录非常重要。有些老域名没有解析，搜索引擎就不会收录其中的内容。虽然无法知道搜索引擎收录域名的确切时间，但可以使用互联网档案馆来查询网站的历史内容，比较有参考价值。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(6)域名中包含关键词</div><div style=\"box-sizing:border-box;\">	对于英文站来说，通常会根据关键词来选购域名，会对谷歌排名有一定的影响。因为关键词形式的域名本身就有提升排名的效果，当有人转载文章时，无形之中就做了该关键词的锚文本。</div>/l/<div style=\"box-sizing:border-box;\">	对于网站来说，域名的选择尤为重要，有些人就不太在意这些，认为网站内容才是关键，这域名随便找个品牌拼音就成了。其实，域名的挑选还有不少名堂，织梦教程网高端网站建设中，常常会带着seo思维去选域名。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(1)优先考虑品牌</div><div style=\"box-sizing:border-box;\">	好的域名并不会把行业词放在里面，就拿百度来说，字面上看与“搜索引擎”毫无关联，可就是国内搜索领域的龙头老大。可见，品牌名称与行业名称来得更重要，有些大公司就是根据品牌词来确定域名的。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(2)域名的续费周期</div><div style=\"box-sizing:border-box;\">	其实，域名的续费周期对网站排名有一定的影响。客观来说，域名续费的周期越长，则说明站长花费在站点上的时间就越长，可见并不是一个垃圾站，可能是一个高质量网站。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(3)域名的后缀</div><div style=\"box-sizing:border-box;\">	部分域名天生就能给网站带来高权重，比如大家熟悉的.gov/.edu。当然了，只有符合条件的才可以注册这种域名。我们可以选择国际通用的，比如.net/.com/.cn等等。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(4)域名的出生时间</div><div style=\"box-sizing:border-box;\">	一个老域名比较值钱，域名注册的越早，对网站排名越有利。这就是为什么有些站长喜欢购买老域名来建站的原因。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(5)首次收录时间</div><div style=\"box-sizing:border-box;\">	有过seo优化经验的朋友们应该清楚，域名第一次被搜索引擎收录非常重要。有些老域名没有解析，搜索引擎就不会收录其中的内容。虽然无法知道搜索引擎收录域名的确切时间，但可以使用互联网档案馆来查询网站的历史内容，比较有参考价值。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	(6)域名中包含关键词</div><div style=\"box-sizing:border-box;\">	对于英文站来说，通常会根据关键词来选购域名，会对谷歌排名有一定的影响。因为关键词形式的域名本身就有提升排名的效果，当有人转载文章时，无形之中就做了该关键词的锚文本。</div>(en)','2017-10-24 20:53:52','admin','100','112','images/nopic.png','0','	对于网站来说，域名的选择尤为重要，有些人就不太在意这些，认为网站内容才是关键，这域名随便找个品牌拼音就成了。其实，域名的挑选还有不少名堂，织梦教程网高端网站建设中，常常会带着seo思维去选域名。	&nbsp;	(1)优先考虑品牌	好的域名并不会把行业词放在里面，就拿百度来说，字面上看与“搜索引擎”毫无关联，可就是国内搜索领域的龙头老大。可见，品牌名称与行业名称来得更重要，有些大公司就是根据品牌词/l/	对于网站来说，域名的选择尤为重要，有些人就不太在意这些，认为网站内容才是关键，这域名随便找个品牌拼音就成了。其实，域名的挑选还有不少名堂，织梦教程网高端网站建设中，常常会带着seo思维去选域名。	&nbsp;	(1)优先考虑品牌	好的域名并不会把行业词放在里面，就拿百度来说，字面上看与“搜索引擎”毫无关联，可就是国内搜索领域的龙头老大。可见，品牌名称与行业名称来得更重要，有些大公司就是根据品牌词(en)','0','0','0','一半,成功,建站,域名,思维/l/一半,成功,建站,域名,思维(en)','	对于网站来说，域名的选择尤为重要，有些人就不太在意这些，认为网站内容才是关键，这域名随便找个品牌拼音就成了。其实，域名的挑选还有不少名堂，织梦教程网高端网站建设中，常常会带着seo思维去选域名。	&nbsp;	(1)优先考虑品牌	好的域名并不会把行业词放在里面，就拿百度来说，字面上看与“搜索引擎”毫无关联，可就是国内搜索领域的龙头老大。可见，品牌名称与行业名称来得更重要，有些大公司就是根据品牌词/l/	对于网站来说，域名的选择尤为重要，有些人就不太在意这些，认为网站内容才是关键，这域名随便找个品牌拼音就成了。其实，域名的挑选还有不少名堂，织梦教程网高端网站建设中，常常会带着seo思维去选域名。	&nbsp;	(1)优先考虑品牌	好的域名并不会把行业词放在里面，就拿百度来说，字面上看与“搜索引擎”毫无关联，可就是国内搜索领域的龙头老大。可见，品牌名称与行业名称来得更重要，有些大公司就是根据品牌词(en)','','/l/(en)',',,','','0','4','|||||','||||||||','','0','div','','','','','0','0','0');
insert into `sl_news`(`N_id`,`N_title`,`N_content`,`N_date`,`N_author`,`N_view`,`N_sort`,`N_pic`,`N_order`,`N_short`,`N_top`,`N_sh`,`N_lv`,`N_keywords`,`N_description`,`N_link`,`N_pagetitle`,`N_tag`,`N_color`,`N_strong`,`N_type`,`N_file`,`N_job`,`N_hide`,`N_hideon`,`N_hidetype`,`N_hideintro`,`N_price`,`N_video`,`N_team`,`N_teamid`,`N_teaminfo`,`N_like`) values('36','内容优化之有“心”创作/l/内容优化之有“心”创作(en)','<div style=\"box-sizing:border-box;\">	什么是真正的原创文?小编认为，真正的原创文是作者自己内心的真切感悟或体会，能够体现作者独特风格，且来源于日常生活或工作中，能给大众带来价值的文章。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	在网站优化中，内容优化一直是重中之重。小编看过不少关于写原创文的范例，网上也有不少相关课程，那么到底如何才能创作出一篇有质量的原创文?</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	第一，以实际的工作经验为题材。</div><div style=\"box-sizing:border-box;\">	既然我们从事这一方面的工作，最了解这一行的就是我们自己了，肯定有很多话想表达。我们何不把实际工作经验作为写作素材呢?seo编辑认为，完全可以写写平时编辑文章的感想。这种方法不仅可以加深日常工作中的经验，还能提高自己的写作能力。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	第二，通过交流、沟通整理成文章。</div><div style=\"box-sizing:border-box;\">	seo行业内经常会进行交流、沟通，或是您在访问某位seo高手时，都可以把内容整理出来，写成一篇访谈。而且，对于别人发表的看法，正好可以填补我们在这一块的缺失，这样，一篇高质量的原创文就出来了。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	第三，对当前的热门话题进行创作。</div><div style=\"box-sizing:border-box;\">	如今，比特币、黄金暴跌、4G网络等热词，都具有一定的写作价值。要知道，因为这些时效性的文章都是网络比较稀缺，正好是搜索引擎喜欢的。discuz模板网认为，对于用户来说，热门、有趣的文章比较有意思，对于千篇一律的东西不会投以多少关注。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	以上三点内容是小编写文时候的心得体会，比较具有可行性。其实，写作来源于生活，有价值的原创文当然离不开编辑的积累与学习。</div>/l/<div style=\"box-sizing:border-box;\">	什么是真正的原创文?小编认为，真正的原创文是作者自己内心的真切感悟或体会，能够体现作者独特风格，且来源于日常生活或工作中，能给大众带来价值的文章。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	在网站优化中，内容优化一直是重中之重。小编看过不少关于写原创文的范例，网上也有不少相关课程，那么到底如何才能创作出一篇有质量的原创文?</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	第一，以实际的工作经验为题材。</div><div style=\"box-sizing:border-box;\">	既然我们从事这一方面的工作，最了解这一行的就是我们自己了，肯定有很多话想表达。我们何不把实际工作经验作为写作素材呢?seo编辑认为，完全可以写写平时编辑文章的感想。这种方法不仅可以加深日常工作中的经验，还能提高自己的写作能力。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	第二，通过交流、沟通整理成文章。</div><div style=\"box-sizing:border-box;\">	seo行业内经常会进行交流、沟通，或是您在访问某位seo高手时，都可以把内容整理出来，写成一篇访谈。而且，对于别人发表的看法，正好可以填补我们在这一块的缺失，这样，一篇高质量的原创文就出来了。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	第三，对当前的热门话题进行创作。</div><div style=\"box-sizing:border-box;\">	如今，比特币、黄金暴跌、4G网络等热词，都具有一定的写作价值。要知道，因为这些时效性的文章都是网络比较稀缺，正好是搜索引擎喜欢的。discuz模板网认为，对于用户来说，热门、有趣的文章比较有意思，对于千篇一律的东西不会投以多少关注。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	以上三点内容是小编写文时候的心得体会，比较具有可行性。其实，写作来源于生活，有价值的原创文当然离不开编辑的积累与学习。</div>(en)','2017-10-24 20:54:28','admin','100','113','images/nopic.png','0','	什么是真正的原创文?小编认为，真正的原创文是作者自己内心的真切感悟或体会，能够体现作者独特风格，且来源于日常生活或工作中，能给大众带来价值的文章。	&nbsp;	在网站优化中，内容优化一直是重中之重。小编看过不少关于写原创文的范例，网上也有不少相关课程，那么到底如何才能创作出一篇有质量的原创文?	&nbsp;	第一，以实际的工作经验为题材。	既然我们从事这一方面的工作，最了解这一行的就是我们自己/l/	什么是真正的原创文?小编认为，真正的原创文是作者自己内心的真切感悟或体会，能够体现作者独特风格，且来源于日常生活或工作中，能给大众带来价值的文章。	&nbsp;	在网站优化中，内容优化一直是重中之重。小编看过不少关于写原创文的范例，网上也有不少相关课程，那么到底如何才能创作出一篇有质量的原创文?	&nbsp;	第一，以实际的工作经验为题材。	既然我们从事这一方面的工作，最了解这一行的就是我们自己(en)','0','0','0','创作/l/创作(en)','	什么是真正的原创文?小编认为，真正的原创文是作者自己内心的真切感悟或体会，能够体现作者独特风格，且来源于日常生活或工作中，能给大众带来价值的文章。	&nbsp;	在网站优化中，内容优化一直是重中之重。小编看过不少关于写原创文的范例，网上也有不少相关课程，那么到底如何才能创作出一篇有质量的原创文?	&nbsp;	第一，以实际的工作经验为题材。	既然我们从事这一方面的工作，最了解这一行的就是我们自己/l/	什么是真正的原创文?小编认为，真正的原创文是作者自己内心的真切感悟或体会，能够体现作者独特风格，且来源于日常生活或工作中，能给大众带来价值的文章。	&nbsp;	在网站优化中，内容优化一直是重中之重。小编看过不少关于写原创文的范例，网上也有不少相关课程，那么到底如何才能创作出一篇有质量的原创文?	&nbsp;	第一，以实际的工作经验为题材。	既然我们从事这一方面的工作，最了解这一行的就是我们自己(en)','','/l/(en)',',,','','0','0','|||||','||||||||','','0','div','','','','','0','0','0');
DROP TABLE IF EXISTS `sl_nsort`;
CREATE TABLE IF NOT EXISTS `sl_nsort` (
  `S_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `S_title` text,
  `S_entitle` text,
  `S_description` text,
  `S_keywords` text,
  `S_type` int(11) DEFAULT '0',
  `S_order` int(11) DEFAULT '0',
  `S_sub` int(11) DEFAULT '0',
  `S_pagetitle` text,
  `S_pic` text,
  `S_show` int(11) DEFAULT '0',
  PRIMARY KEY (`S_id`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('1','德育活动/l/company','company/l/company','1/l/1(en)','2/l/2(en)','0','0','99','/l/(en)','media/20171024203040267.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('7','教研动态/l/资料下载(en)','download/l/download(en)','资料下载/l/资料下载(en)','下载/l/下载(en)','0','0','100','/l/(en)','media/20171024203124165.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('99','德育视窗/l/新闻(en)','news/l/news(en)','新闻分类描述/l/新闻分类描述(en)','新闻分类关键词/l/新闻分类关键词(en)','0','0','0','/l/(en)','media/20171024203040267.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('100','教研教学/l/下载(en)','download/l/download(en)','下载分类描述/l/下载分类描述(en)','下载分类关键词/l/下载分类关键词(en)','0','0','0','/l/(en)','media/20171024203124165.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('104','心理健康/l/人才招聘(en)','job/l/job(en)','人才招聘/l/人才招聘(en)','招聘/l/招聘(en)','0','1','99','人才招聘/l/人才招聘(en)','media/20171024203100028.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('105','艺术天地/l/视频播放(en)','video/l/video(en)','视频播放/l/视频播放(en)','播放/l/播放(en)','0','2','99','视频播放/l/视频播放(en)','media/20171024203114342.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('106','教学成果/l/教学成果(en)','Teaching achievement/l/Teaching achievement(en)','教学成果/l/教学成果(en)','成果/l/成果(en)','0','2','100','教学成果/l/教学成果(en)','media/20171024202229795.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('107','外语特色/l/外语特色(en)','Foreign language characteristics/l/Foreign language characteristics(en)','外语特色/l/外语特色(en)','特色/l/特色(en)','0','3','0','外语特色/l/外语特色(en)','media/20171024202313382.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('108','外语教研/l/外语教研(en)','Foreign language teaching and research/l/Foreign language teaching and research(en)','外语教研/l/外语教研(en)','教研/l/教研(en)','0','1','107','外语教研/l/外语教研(en)','media/20171024202313382.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('109','外语活动/l/外语活动(en)','Foreign language activities/l/Foreign language activities(en)','外语活动/l/外语活动(en)','活动/l/活动(en)','0','2','107','外语活动/l/外语活动(en)','media/20171024203157842.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('110','英文佳作/l/英文佳作(en)','English excellent works/l/English excellent works(en)','英文佳作/l/英文佳作(en)','佳作/l/佳作(en)','0','3','107','英文佳作/l/英文佳作(en)','media/20171024203209462.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('111','学校资讯/l/学习资讯(en)','Learning information/l/Learning information(en)','学习资讯/l/学习资讯(en)','资讯/l/资讯(en)','0','4','0','学习资讯/l/学习资讯(en)','media/20171024203235053.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('112','学校公告/l/学校公告(en)','School bulletin/l/School bulletin(en)','学校公告/l/学校公告(en)','公告/l/公告(en)','0','2','111','学校公告/l/学校公告(en)','media/20171024203248315.jpg','1');
insert into `sl_nsort`(`S_id`,`S_title`,`S_entitle`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_sub`,`S_pagetitle`,`S_pic`,`S_show`) values('113','新闻动态/l/新闻动态(en)','News information/l/News information(en)','新闻动态/l/新闻动态(en)','动态/l/动态(en)','0','2','111','新闻动态/l/新闻动态(en)','media/20171024202229795.jpg','1');
DROP TABLE IF EXISTS `sl_orders`;
CREATE TABLE IF NOT EXISTS `sl_orders` (
  `O_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `O_member` int(11) DEFAULT '0',
  `O_price` double DEFAULT '0',
  `O_num` int(11) DEFAULT '0',
  `O_shuxing` text,
  `O_state` int(11) DEFAULT '0',
  `O_pid` int(11) DEFAULT '0',
  `O_wl` text,
  `O_wlid` text,
  `O_tradeno` text,
  `O_time` datetime DEFAULT NULL,
  `O_remark` varchar(200) DEFAULT '',
  `O_postage` double DEFAULT '0',
  `O_no` varchar(100) DEFAULT '',
  PRIMARY KEY (`O_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
insert into `sl_orders`(`O_id`,`O_member`,`O_price`,`O_num`,`O_shuxing`,`O_state`,`O_pid`,`O_wl`,`O_wlid`,`O_tradeno`,`O_time`,`O_remark`,`O_postage`,`O_no`) values('10','7','0.01','1','标配','3','78','中通','1234567890','1002510991201510241319384097（微信付款）','2015-10-24 19:35:52','','0','');
insert into `sl_orders`(`O_id`,`O_member`,`O_price`,`O_num`,`O_shuxing`,`O_state`,`O_pid`,`O_wl`,`O_wlid`,`O_tradeno`,`O_time`,`O_remark`,`O_postage`,`O_no`) values('11','7','0.01','2','标配','3','78','圆通','1234567890','2015102421001004110044403666（支付宝付款）','2015-10-24 19:39:21','','0','');
insert into `sl_orders`(`O_id`,`O_member`,`O_price`,`O_num`,`O_shuxing`,`O_state`,`O_pid`,`O_wl`,`O_wlid`,`O_tradeno`,`O_time`,`O_remark`,`O_postage`,`O_no`) values('12','7','0.01','3','标配','3','78','申通','1234567890','2015102421001004390025952107（网银付款）','2015-10-24 19:40:18','','0','');
DROP TABLE IF EXISTS `sl_product`;
CREATE TABLE IF NOT EXISTS `sl_product` (
  `P_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `P_path` text,
  `P_thumb` text,
  `P_title` text,
  `P_content` text,
  `P_sort` int(11) DEFAULT '0',
  `P_order` int(11) DEFAULT '0',
  `P_price` double DEFAULT '0',
  `P_buy` int(11) DEFAULT '0',
  `P_short` text,
  `P_shuxing` text,
  `P_top` int(11) DEFAULT '0',
  `P_keywords` text,
  `P_description` text,
  `P_time` text,
  `P_unlogin` int(11) DEFAULT '0',
  `P_name` int(11) DEFAULT '0',
  `P_email` int(11) DEFAULT '0',
  `P_mobile` int(11) DEFAULT '0',
  `P_address` int(11) DEFAULT '0',
  `P_postcode` int(11) DEFAULT '0',
  `P_qq` int(11) DEFAULT '0',
  `P_remark` int(11) DEFAULT '0',
  `P_sence` int(11) DEFAULT '0',
  `P_sell` text,
  `P_link` text,
  `P_pagetitle` text,
  `P_rest` int(11) DEFAULT '0',
  `P_shuxingt` int(11) DEFAULT '0',
  `P_like` int(11) DEFAULT '0',
  PRIMARY KEY (`P_id`)
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8;
insert into `sl_product`(`P_id`,`P_path`,`P_thumb`,`P_title`,`P_content`,`P_sort`,`P_order`,`P_price`,`P_buy`,`P_short`,`P_shuxing`,`P_top`,`P_keywords`,`P_description`,`P_time`,`P_unlogin`,`P_name`,`P_email`,`P_mobile`,`P_address`,`P_postcode`,`P_qq`,`P_remark`,`P_sence`,`P_sell`,`P_link`,`P_pagetitle`,`P_rest`,`P_shuxingt`,`P_like`) values('96','media/20171024235215887.jpg__','','英国斯坦福德中学/l/英国斯坦福德中学(en)','<div style=\"box-sizing:border-box;\">	斯坦福德校成立于1877年，属于斯坦福德捐赠学校中的其中一所，另外2所学校分别是斯坦福女子学校和斯坦福德初级中学。每个学校都各有其领导人，但是校长却只有一个。三所学校相互合作，互通有无，共同举办多种文化、社会和教育活动，其中A-Level采取混合教学的方式。三所学校的日常活动与当地紧密相连。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	斯坦福德学校位于城镇中心。设备齐全，住宿舒适。学校并没有特别的宗教信仰，但是提供宗教教育，全体学生每天都会有一次集合。学校的学业目标旨在避免过早的专业，鼓励学生采用最佳的传统与现代相结合的学习方式。该校学术成绩优秀。积极鼓励发展音乐和戏剧（设有专门的艺术表演大厅）。许多男孩都会至少一种乐器。戏剧是课程的一部分，每年都会进行多场演出。各种运动和游戏也应有尽有。学校还设有多种社团和俱乐部，积极鼓励学生参加各种社区和社会服务[1] &nbsp;。学校在爱丁堡伯爵奖章计划中成绩显著，深受广大学生的喜爱，同时也与CCF紧密合作。</div>/l/<div style=\"box-sizing:border-box;\">	斯坦福德校成立于1877年，属于斯坦福德捐赠学校中的其中一所，另外2所学校分别是斯坦福女子学校和斯坦福德初级中学。每个学校都各有其领导人，但是校长却只有一个。三所学校相互合作，互通有无，共同举办多种文化、社会和教育活动，其中A-Level采取混合教学的方式。三所学校的日常活动与当地紧密相连。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	斯坦福德学校位于城镇中心。设备齐全，住宿舒适。学校并没有特别的宗教信仰，但是提供宗教教育，全体学生每天都会有一次集合。学校的学业目标旨在避免过早的专业，鼓励学生采用最佳的传统与现代相结合的学习方式。该校学术成绩优秀。积极鼓励发展音乐和戏剧（设有专门的艺术表演大厅）。许多男孩都会至少一种乐器。戏剧是课程的一部分，每年都会进行多场演出。各种运动和游戏也应有尽有。学校还设有多种社团和俱乐部，积极鼓励学生参加各种社区和社会服务[1] &nbsp;。学校在爱丁堡伯爵奖章计划中成绩显著，深受广大学生的喜爱，同时也与CCF紧密合作。</div>(en)','7','0','0','0',' 斯坦福德校成立于1877年，属于斯坦福德捐赠学校中的其中一所，另外2所学校分别是斯坦福女子学校和斯坦福德初级中学。每个学校都各有其领导人，但是校长却只有一个。三所学校相互合作，互通有无，共同举办多种文化、社会和教育活动，其中A-Level采取混合教学的方式。三所学校的日常活动与当地紧密相连。 &nbsp; 斯坦福德学校位于城镇中心。设备齐全，住宿舒适。学校并没有特别的宗教信仰，但是提供宗教教育，/l/	斯坦福德校成立于1877年，属于斯坦福德捐赠学校中的其中一所，另外2所学校分别是斯坦福女子学校和斯坦福德初级中学。每个学校都各有其领导人，但是校长却只有一个。三所学校相互合作，互通有无，共同举办多种文化、社会和教育活动，其中A-Level采取混合教学的方式。三所学校的日常活动与当地紧密相连。	&nbsp;	斯坦福德学校位于城镇中心。设备齐全，住宿舒适。学校并没有特别的宗教信仰，但是提供宗教教育，(en)','','0','中学/l/中学(en)',' 斯坦福德校成立于1877年，属于斯坦福德捐赠学校中的其中一所，另外2所学校分别是斯坦福女子学校和斯坦福德初级中学。每个学校都各有其领导人，但是校长却只有一个。三所学校相互合作，互通有无，共同举办多种文化、社会和教育活动，其中A-Level采取混合教学的方式。三所学校的日常活动与当地紧密相连。 &nbsp; 斯坦福德学校位于城镇中心。设备齐全，住宿舒适。学校并没有特别的宗教信仰，但是提供宗教教育，/l/	斯坦福德校成立于1877年，属于斯坦福德捐赠学校中的其中一所，另外2所学校分别是斯坦福女子学校和斯坦福德初级中学。每个学校都各有其领导人，但是校长却只有一个。三所学校相互合作，互通有无，共同举办多种文化、社会和教育活动，其中A-Level采取混合教学的方式。三所学校的日常活动与当地紧密相连。	&nbsp;	斯坦福德学校位于城镇中心。设备齐全，住宿舒适。学校并没有特别的宗教信仰，但是提供宗教教育，(en)','2017/10/24 23:51:40','0','0','0','0','0','0','0','0','0','','','/l/(en)','100','0','0');
insert into `sl_product`(`P_id`,`P_path`,`P_thumb`,`P_title`,`P_content`,`P_sort`,`P_order`,`P_price`,`P_buy`,`P_short`,`P_shuxing`,`P_top`,`P_keywords`,`P_description`,`P_time`,`P_unlogin`,`P_name`,`P_email`,`P_mobile`,`P_address`,`P_postcode`,`P_qq`,`P_remark`,`P_sence`,`P_sell`,`P_link`,`P_pagetitle`,`P_rest`,`P_shuxingt`,`P_like`) values('97','media/20171024235315255.jpg__','','张三丰/l/张三丰(en)','张三，中国人最耳熟能详的名字。张三可能真有其人，但更多时候与李四、王五一起指代不特定的某个人，揶揄或者概括常用。例如古代说书人常说：那张三的李四的都来了。也常被用在文学影视作品中。因此名平常普通，近来也被用来指代一个普通人群体，即“张三族”。<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" /><div style=\"box-sizing:border-box;\">	如果你是背着生活压力的男人，你就已经成为了“张三族”的候选人。你可能是个生活平稳的中年男人，工作还算稳定，家庭还算和睦，孩子还算听话，每月数额不菲的房贷对生活还构不成太大压力，父母的身体也还算健康。中国人讲究知足常乐，知足常乐没错，可以让人常常保持放松的心态，但它同样也有害处，最大的害处就是容易让人懈怠，容易让人不思进取。平稳总是相对的，你没有意识到领导对你工作的不满是因为你的懈怠，反过来你却说认为领导实在变态；你没有注意到父母的身体一天天变差；你没有注意到温和的妻子已与你渐渐远行……小心了，如果任何一个危机爆发，你都会迅速沦为“张三族”徐峥解读“张三族”<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	反映都市小人物奋斗故事的《老爸快跑》在央视掀起热浪。一个三十多岁的都市小男人，原本过着懒散、邋遢的小市民生活，一连串突如其来的打击令他方寸大乱，老婆离婚、小店被骗、老父亲生病、争夺孩子抚养权……他的名字叫“张三”，这部戏的热播还引发了一个新名词——张三族，意指生活现状令人堪忧的中年男性。关于张三族的话题油然而生，而扮演张三的徐峥对这个不起眼的群体有着特殊的理解。在接受当年的“张三生活”。</div>/l/张三，中国人最耳熟能详的名字。张三可能真有其人，但更多时候与李四、王五一起指代不特定的某个人，揶揄或者概括常用。例如古代说书人常说：那张三的李四的都来了。也常被用在文学影视作品中。因此名平常普通，近来也被用来指代一个普通人群体，即“张三族”。<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" /><div style=\"box-sizing:border-box;\">	如果你是背着生活压力的男人，你就已经成为了“张三族”的候选人。你可能是个生活平稳的中年男人，工作还算稳定，家庭还算和睦，孩子还算听话，每月数额不菲的房贷对生活还构不成太大压力，父母的身体也还算健康。中国人讲究知足常乐，知足常乐没错，可以让人常常保持放松的心态，但它同样也有害处，最大的害处就是容易让人懈怠，容易让人不思进取。平稳总是相对的，你没有意识到领导对你工作的不满是因为你的懈怠，反过来你却说认为领导实在变态；你没有注意到父母的身体一天天变差；你没有注意到温和的妻子已与你渐渐远行……小心了，如果任何一个危机爆发，你都会迅速沦为“张三族”徐峥解读“张三族”<br style=\"box-sizing:border-box;\" />&nbsp;</div><div style=\"box-sizing:border-box;\">	反映都市小人物奋斗故事的《老爸快跑》在央视掀起热浪。一个三十多岁的都市小男人，原本过着懒散、邋遢的小市民生活，一连串突如其来的打击令他方寸大乱，老婆离婚、小店被骗、老父亲生病、争夺孩子抚养权……他的名字叫“张三”，这部戏的热播还引发了一个新名词——张三族，意指生活现状令人堪忧的中年男性。关于张三族的话题油然而生，而扮演张三的徐峥对这个不起眼的群体有着特殊的理解。在接受当年的“张三生活”。</div>(en)','2','0','0','0','张三，中国人最耳熟能详的名字。张三可能真有其人，但更多时候与李四、王五一起指代不特定的某个人，揶揄或者概括常用。例如古代说书人常说：那张三的李四的都来了。也常被用在文学影视作品中。因此名平常普通，近来也被用来指代一个普通人群体，即“张三族”。	如果你是背着生活压力的男人，你就已经成为了“张三族”的候选人。你可能是个生活平稳的中年男人，工作还算稳定，家庭还算和睦，孩子还算听话，每月数额不菲的房贷对生/l/张三，中国人最耳熟能详的名字。张三可能真有其人，但更多时候与李四、王五一起指代不特定的某个人，揶揄或者概括常用。例如古代说书人常说：那张三的李四的都来了。也常被用在文学影视作品中。因此名平常普通，近来也被用来指代一个普通人群体，即“张三族”。	如果你是背着生活压力的男人，你就已经成为了“张三族”的候选人。你可能是个生活平稳的中年男人，工作还算稳定，家庭还算和睦，孩子还算听话，每月数额不菲的房贷对生(en)','','0','张三/l/张三(en)','张三，中国人最耳熟能详的名字。张三可能真有其人，但更多时候与李四、王五一起指代不特定的某个人，揶揄或者概括常用。例如古代说书人常说：那张三的李四的都来了。也常被用在文学影视作品中。因此名平常普通，近来也被用来指代一个普通人群体，即“张三族”。	如果你是背着生活压力的男人，你就已经成为了“张三族”的候选人。你可能是个生活平稳的中年男人，工作还算稳定，家庭还算和睦，孩子还算听话，每月数额不菲的房贷对生/l/张三，中国人最耳熟能详的名字。张三可能真有其人，但更多时候与李四、王五一起指代不特定的某个人，揶揄或者概括常用。例如古代说书人常说：那张三的李四的都来了。也常被用在文学影视作品中。因此名平常普通，近来也被用来指代一个普通人群体，即“张三族”。	如果你是背着生活压力的男人，你就已经成为了“张三族”的候选人。你可能是个生活平稳的中年男人，工作还算稳定，家庭还算和睦，孩子还算听话，每月数额不菲的房贷对生(en)','2017/10/24 23:52:58','0','0','0','0','0','0','0','0','0','','','/l/(en)','100','0','0');
DROP TABLE IF EXISTS `sl_psort`;
CREATE TABLE IF NOT EXISTS `sl_psort` (
  `S_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `S_title` text,
  `S_entitle` text,
  `S_module` text,
  `S_sub` int(11) DEFAULT '0',
  `S_pic` text,
  `S_description` text,
  `S_keywords` text,
  `S_type` int(11) DEFAULT '0',
  `S_order` int(11) DEFAULT '0',
  `S_pagetitle` text,
  `S_show` int(11) DEFAULT '0',
  PRIMARY KEY (`S_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
insert into `sl_psort`(`S_id`,`S_title`,`S_entitle`,`S_module`,`S_sub`,`S_pic`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_pagetitle`,`S_show`) values('1','学子风采/l/Product','PRODUCT/l/Product','product','0','media/20171024210017647.jpg','产品展示/l/产品展示(en)','展示/l/展示(en)','0','0','产品展示/l/产品展示(en)','1');
insert into `sl_psort`(`S_id`,`S_title`,`S_entitle`,`S_module`,`S_sub`,`S_pic`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_pagetitle`,`S_show`) values('2','状元金榜/l/Canon','canon/l/Canon','p001','1','media/20151019110147886.jpg','佳能（Canon），是日本的一家全球领先的生产影像与信息产品的综合集团，从1937年成立以来，经过多年不懈的努力，佳能已将自己的业务全球化并扩展到各个领域。','佳能','0','0','','1');
insert into `sl_psort`(`S_id`,`S_title`,`S_entitle`,`S_module`,`S_sub`,`S_pic`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_pagetitle`,`S_show`) values('3','校园之星/l/Nikon','nikon/l/Nikon','p001','1','media/20151019110204439.jpg','尼康（Nikon），是日本的一家著名相机制造商，成立于1917年，当时名为日本光学工业株式会社。1988年该公司依托其照相机品牌，更名为尼康株式会社。','尼康','0','0','','1');
insert into `sl_psort`(`S_id`,`S_title`,`S_entitle`,`S_module`,`S_sub`,`S_pic`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_pagetitle`,`S_show`) values('4','杰出校友/l/Leica','leica/l/Leica','p001','1','media/20151019110223300.jpg','LEICA T 银色相机 德国徕卡相机发表T-System全新系列，将工艺美学及手工制作的触感设计，结合于产品创新概念。从最初灵感、开发过程到最终定案，始终不变的核心聚焦皆是 – 尽善尽美','莱卡','0','0','','1');
insert into `sl_psort`(`S_id`,`S_title`,`S_entitle`,`S_module`,`S_sub`,`S_pic`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_pagetitle`,`S_show`) values('6','国际交流/l/Case','case/l/Case','','0','media/20171024205955552.jpg','1/l/1(en)','案例中心/l/案例中心(en)','0','0','/l/(en)','1');
insert into `sl_psort`(`S_id`,`S_title`,`S_entitle`,`S_module`,`S_sub`,`S_pic`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_pagetitle`,`S_show`) values('7','友好学校/l/Success case','success/l/Success case','','6','media/20171019002925971.jpg','成功案例/l/成功案例(en)','案例/l/案例(en)','0','0','成功案例/l/成功案例(en)','1');
insert into `sl_psort`(`S_id`,`S_title`,`S_entitle`,`S_module`,`S_sub`,`S_pic`,`S_description`,`S_keywords`,`S_type`,`S_order`,`S_pagetitle`,`S_show`) values('8','来访外访/l/来访外访(en)','Visiting abroad/l/Visiting abroad(en)','','6','images/nopic.png','来访外访/l/来访外访(en)','来访/l/来访(en)','0','2','/l/(en)','1');
DROP TABLE IF EXISTS `sl_qsort`;
CREATE TABLE IF NOT EXISTS `sl_qsort` (
  `S_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `S_title` text,
  `S_content` text,
  PRIMARY KEY (`S_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
insert into `sl_qsort`(`S_id`,`S_title`,`S_content`) values('1','防伪码查询','如果未查到编号或者非首次查询，请注意您可能购买到假冒商品！');
DROP TABLE IF EXISTS `sl_query`;
CREATE TABLE IF NOT EXISTS `sl_query` (
  `Q_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Q_code` text,
  `Q_content` text,
  `Q_times` int(11) DEFAULT '0',
  `Q_sort` int(11) DEFAULT '0',
  `Q_first` text,
  PRIMARY KEY (`Q_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
insert into `sl_query`(`Q_id`,`Q_code`,`Q_content`,`Q_times`,`Q_sort`,`Q_first`) values('1','123123','您购买的为正品！','1','1','');
insert into `sl_query`(`Q_id`,`Q_code`,`Q_content`,`Q_times`,`Q_sort`,`Q_first`) values('2','456456','您购买的为正品！','0','1','');
insert into `sl_query`(`Q_id`,`Q_code`,`Q_content`,`Q_times`,`Q_sort`,`Q_first`) values('3','789789','您购买的为正品！','0','1','');
DROP TABLE IF EXISTS `sl_reply`;
CREATE TABLE IF NOT EXISTS `sl_reply` (
  `R_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `R_key` text,
  `R_reply` int(11) DEFAULT '0',
  PRIMARY KEY (`R_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
insert into `sl_reply`(`R_id`,`R_key`,`R_reply`) values('1','你好','1');
insert into `sl_reply`(`R_id`,`R_key`,`R_reply`) values('2','测试','4');
insert into `sl_reply`(`R_id`,`R_key`,`R_reply`) values('3','新用户关注','6');
insert into `sl_reply`(`R_id`,`R_key`,`R_reply`) values('4','推送','6');
DROP TABLE IF EXISTS `sl_response`;
CREATE TABLE IF NOT EXISTS `sl_response` (
  `R_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `R_cid` int(11) DEFAULT '0',
  `R_content` text,
  `R_time` datetime DEFAULT NULL,
  `R_rid` text,
  `R_member` int(11) DEFAULT '0',
  `R_read` int(11) DEFAULT '0',
  PRIMARY KEY (`R_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
DROP TABLE IF EXISTS `sl_safe`;
CREATE TABLE IF NOT EXISTS `sl_safe` (
  `S_filetype` text,
  `S_filesize` int(11) DEFAULT '0',
  `S_ip` text,
  `S_word` text,
  `S_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`S_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
insert into `sl_safe`(`S_filetype`,`S_filesize`,`S_ip`,`S_word`,`S_id`) values('jpg|png|gif|flv|mp3|doc|rar|ppt|pdf|ico|mp4|swf','10','123.45.67.89','\'|;|exec|update|count|*|%|chr|mid|master|truncate|char|declare','1');
DROP TABLE IF EXISTS `sl_slide`;
CREATE TABLE IF NOT EXISTS `sl_slide` (
  `S_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `S_pic` text,
  `S_thumb` text,
  `S_title` text,
  `S_content` text,
  `S_link` text,
  `S_order` int(11) DEFAULT '0',
  PRIMARY KEY (`S_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
insert into `sl_slide`(`S_id`,`S_pic`,`S_thumb`,`S_title`,`S_content`,`S_link`,`S_order`) values('4','media/20171024200440613.jpg','','Louis Vuitton视觉盛宴/l/visual feast','路易·威登法国历史上最杰出的皮件设计大师之一/l/visual feast','#','0');
insert into `sl_slide`(`S_id`,`S_pic`,`S_thumb`,`S_title`,`S_content`,`S_link`,`S_order`) values('5','media/20171024200444991.jpg','','Diesel时尚广告/l/Fashion advertising','Diesel的风格年轻而富有创意/l/Fashion advertising','#','0');
DROP TABLE IF EXISTS `sl_text`;
CREATE TABLE IF NOT EXISTS `sl_text` (
  `T_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `T_title` text,
  `T_entitle` text,
  `T_content` text,
  `T_pic` text,
  `T_description` text,
  `T_keywords` text,
  `T_link` text,
  `T_pagetitle` text,
  `T_order` int(11) DEFAULT '0',
  `T_like` int(11) DEFAULT '0',
  PRIMARY KEY (`T_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
insert into `sl_text`(`T_id`,`T_title`,`T_entitle`,`T_content`,`T_pic`,`T_description`,`T_keywords`,`T_link`,`T_pagetitle`,`T_order`,`T_like`) values('1','校长寄语/l/Itroduction','President&apos;s message/l/Itroduction','<div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	沈阳理工大学前身是东北军区军工部工业专门学校，创建于1948年。1960年组建成立沈阳工业学院，2004年经教育部批准更名为沈阳理工大学。2010年辽宁省人民政府与中国兵器装备集团、中国兵器工业集团签署了共建沈阳理工大学协议。2016年获批“国家国防科技工业局与辽宁省人民政府共建高校”，成为省局共建的国防特色院校。</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	学校位于辽宁省沈阳市浑南区，占地面积114万平方米，校舍建筑面积44.4万平方米。校园建筑气势恢宏，庄重典雅，环境清新宜人。校园内建有局域网，图书馆面积3.9万平方米，纸质藏书133.3万册。学生文化体育设施齐全，建有标准运动场和大学生文体中心，为大学生全面发展提供了良好基础。学校建有东北地区唯一的兵器博物馆，是国家、省级科普教育基地、辽宁省国防教育基地及沈阳市爱国主义教育基地。</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	经过六十多年的建设和发展，沈阳理工大学已由一所学科单一的军工院校发展成为以工为主，理、管、文、经、法、艺相结合，服务辽宁、面向全国，具有鲜明国防特色的多科性大学。承担着为沈阳军区培养国防生的重任。是教育部批准的招收高水平足球运动队的高等院校之一。</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	学校设有20个学院（教学部）。现有教职工1663人，其中双聘院士1人，博士、硕士研究生导师397人，教授、副教授552人。国家百千万人才工程百人层次、国家级教学名师、享受国务院政府特殊津贴、教育部“新世纪优秀人才”及全国专业教学指导委员会委员29人。省领军人才、省优秀专家、省特聘教授、省教学名师、省高校优秀科技人才支持计划、省高校杰出青年学者成长计划、省“百千万人才工程”百人层次61人，辽宁省创新团队4个。</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	学校现有各类全日制在校生17926人，其中本科生16395人，博士、硕士研究生1234人。有博士人才培养项目1个，博士后科研流动站1个，博士后科研工作站1个；有12个硕士学位授权一级学科，涵盖47个二级学科点（学科方向），涵盖工、理、经、管、文、法、艺术等7个学位门类。有7个工程硕士授权领域和4个专业学位授权点。拥有国家级沈阳中俄科技合作基地、国家863高技术发展计划重点实验室和1个省级重大科技平台。有5个省级重点学科，4个省级优势特色学科和培育学科，23个省、部级重点实验室（工程技术研究中心）。</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	&nbsp;</div><div style=\"box-sizing:border-box;color:#666666;font-family:&quot;font-size:14px;white-space:normal;background-color:#FFFFFF;\">	学校设有53个本科专业。2007年被教育部确定为高等学校本科教学工作水平评估优秀学校。有国家级特色专业建设点2个，国家级专业综合改革试点专业1个，省级特色（示范）专业、改革试点专业及重点支持专业16个。有6个省级教学团队；教育部精品视频公开课1门，省级精品课程13门，省级视频公开课和精品资源共享课14门。2011年我校被教育部确定为国家卓越工程师教育培养计划实施高校。现有国家级大学生校外实践教育基地建设项目1个，省级大学生实践教育基地、实验教学示范中心、工程实践教育中心11个。</div><br />/l/XXX Co., Ltd. was established in 1966 in order to enhance the industrial technology through the evaluation of technical support for the test and evaluation agencies,<br />Is a representative body of the Republic of Korea, which exchanges and cooperation with the test and certification bodies of the advanced (developed) countries.<br />In order to protect the domestic industry&apos;s various certification system is perfect, for the protection of consumer safety and environmental protection of the importance of the various systems is increasing,<br />KTL to adapt to the development of the situation, from product development to obtain certification throughout the stage to provide support to help enterprises to improve technical capabilities and have a stronger competitive.<br />In order to the business between the two countries and certification bodies and customers of the organic business contact and meet the needs of customers,<br />XXXX Co., Ltd. established in Guangzhou and Shanghai, China office,<br />To provide customers with quality services, in order to increase the development of Chinese enterprises to South Korea and the development of enterprises to contribute.<br />In order to solve the domestic and foreign customers to obtain certification as well as the country&apos;s non tariff barriers, and 35 countries have signed an agreement (MOU) 67 test certification bodies,<br />In order to obtain overseas certification, to provide a variety of safety and quality certification, factory review, information, technical education and other support.<br />Now in the operation of the international certification system IECEE (System for Conformity Testing IEC and Certification of Electrical Equipment) CB certification system (CBScheme),<br />Is one of the 9 areas of the 43 specifications of the issue of Certificate CB and Report IECEE Test recognized.<br />','media/20171024200243940.jpg','	沈阳理工大学前身是东北军区军工部工业专门学校，创建于1948年。1960年组建成立沈阳工业学院，2004年经教育部批准更名为沈阳理工大学。2010年辽宁省人民政府与中国兵器装备集团、中国兵器工业集团/l/Itroduction','寄语/l/Itroduction','','/l/(en)','1','0');
insert into `sl_text`(`T_id`,`T_title`,`T_entitle`,`T_content`,`T_pic`,`T_description`,`T_keywords`,`T_link`,`T_pagetitle`,`T_order`,`T_like`) values('2','学校简介/l/Corporate culture','School profiles/l/Corporate culture','高质量<div style=\"box-sizing:border-box;\">	AB模版网工作室认真对待每一个客户，我们不用口头语言来吹捧我们的优秀，成百上千的案例，见证着我们成长。</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	高效率</div><div style=\"box-sizing:border-box;\">	直接与设计师、程序师沟通！我们崇尚速度，喜欢感受风驰电掣的狂飙，所以在3-5个工作日内我们为您提供最完美的方案，我们拒绝拖沓!</div><div style=\"box-sizing:border-box;\">	&nbsp;</div><div style=\"box-sizing:border-box;\">	高诚信</div><div style=\"box-sizing:border-box;\">	客户是什么，他们在想什么，需要我们做什么，这些问题一直困扰着我们。但是经过几年的实践，发现做好客户关系其实很容易，那就是真诚！<br style=\"box-sizing:border-box;\" /><br style=\"box-sizing:border-box;\" />	<div style=\"box-sizing:border-box;\">		AB模版网自成立以来，一直专注于互联网品牌建设，我们团队的成员曾务于国内优秀广告公司及互联网公司业务类型涉及WEB视觉、交互设计、移动终端用户体验等质量和信誉是我们存在的基石。我们注重客户提出的每个要求，充分考虑每一个细节，积极的做好服务，努力开拓更好的视野。我们永远不会因为我们曾经的成绩而满足。在所有新老客户面前，我们都很乐意虚心、朴实的跟您接触，更深入的了解您的企业，以便为您提供更优质的服务！	</div>	<div style=\"box-sizing:border-box;\">		&nbsp;	</div>	<div style=\"box-sizing:border-box;\">		我们的服务宗旨:持续为客户创造最优质的服务	</div>	<div style=\"box-sizing:border-box;\">		&nbsp;	</div>	<div style=\"box-sizing:border-box;\">		感谢您选择AB模版网，每一次倾心的合作都是一个全新的体会和挑战，让我们从沟通开始这次愉快的合作吧！	</div></div><br />/l/1, dare to innovate<br />Innovation is the primary characteristic of XX enterprise, is daring to dare to try, dare to do.<br />XX is the first of the urban transformation of the old district of enterprises; XX is the first cross regional development of the real estate business, XX is the national real estate enterprises in the first transformation of commercial real estate enterprises, XX is the first large-scale investment in cultural industries enterprise, XX enterprise industry group was established has become the country&apos;s largest.<br />2, adhere to the good faith<br />Adhere to the integrity of the core features of XX enterprises.<br />In 1990, XX group and the development of Dalian civil residential street into northeast China first straight-A project quality residential quarters; in 1996, XX in the national real estate companies pioneered to protect the interests of consumers of \"three commitments\"; 2002, XX in Shenyang Taiyuan street XX square development, because of the bad part of the sale of shops operating efficiency, XX from the protection of the interests of consumers of, decided to repurchase Shenyang, Taiyuan street, XX square all sold in shops, in addition to the return of property and also compensates for the corresponding interest. XX Shenyang back shop in the country caused great repercussions, becoming the national integrity of the cultural construction of the landmark event.<br />3, take the lead in environmental protection<br />XX group is one of the earliest enterprises to implement energy-saving building.<br />XX group all XX square and five-star hotels have reached national star energy efficiency standards, since the State Department of housing and urban rural development in 2009 issued green building design logo and run ID, the obtained the certification of commercial projects most is XX square and five-star hotel, far ahead of other enterprises.<br />4, care staff<br />XX employees as the core capital of the enterprise, the development of the results of the first benefit employees, so that employees in the XX long ability, rising wages, long happiness index. XX annual investment of 100 million yuan for staff training, and invested 700 million yuan in Langfang to establish a domestic first-class XX college. All of the basic requirements of XX company running the staff canteen, staff to provide free meals. XX implementation of outstanding employees to take vacation system, each year named the outstanding group of employees, giving round-trip ticket reimbursement two people stay free around the XX hotel resort.<br />5, pay attention to charity<br />XX was established so far, charitable donations of cash more than 3 billion 700 million yuan, is one of China&apos;s largest charitable donations. Is the only seven won the \"China Charity Award\" of the enterprise.<br />XX group also advocated the concept of public welfare, all employees have become volunteers, at least once a year to do a volunteer.<br />6, do the best<br />XX has a broad vision of the work of the standard requirements, the pursuit of all the work to become a boutique\". XX as long as the industry into the industry, at least to do the first in the Chinese industry, the pursuit of the world&apos;s first industry. XX is the world&apos;s largest cinema line operators, the world&apos;s second largest real estate companies, the world&apos;s largest five star hotel owners.<br />7, strong execution<br />Executive power is a prominent feature of the XX enterprise culture. When it comes to. Two is to get to get. XX do the project after the first calculation, the first to do the planning and design, and then determine whether the cost of investment and investment. Project development process to implement the planning module control, to ensure that the entire project cost, cash flow within the scope of the project management and control. Three is fine. XX System Award, the prize award, the penalty is the punishment.<br />8, carry forward the traditional<br />In 2005 the group recommended the \"Analects of Confucius\", the whole group to carry out a year of study, discussion and speech. XX repeatedly invited famous etiquette experts to corporate culture, improve staff comprehensive quality. XX Group Chairman Wang Jianlin began very early Chinese calligraphy collection, exhibition held every year, support outstanding painter development.<br />','media/20151019103237394.jpg','高质量	AB模版网工作室认真对待每一个客户，我们不用口头语言来吹捧我们的优秀，成百上千的案例，见证着我们成长。	&nbsp;	高效率	直接与设计师、程序师沟通！我们崇尚速度，喜欢感受风驰电掣的狂飙，所/l/Corporate culture','简介/l/Corporate culture','','/l/(en)','2','0');
insert into `sl_text`(`T_id`,`T_title`,`T_entitle`,`T_content`,`T_pic`,`T_description`,`T_keywords`,`T_link`,`T_pagetitle`,`T_order`,`T_like`) values('13','办学理念/l/办学理念(en)','School running idea/l/School running idea(en)','<p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	民主：建立民主的教风，是当今教育改革的迫切要求，民主的教风要求教师在传授知识中博采众议，善于听取学生的各种意见，去粗取精、去伪存真，不断改进教学方法，我们要营造民主的教风，变主宰学生一时的老师为交给学生终生学习方法的老师。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	博学：意为学识渊博，知道的多，了解的广，学问丰富，为人师者必须博学，只有自己博学，才能使学生博学，因此，我们的教师团队当广知博学、精通业务、一专多能、苦练内功、热心科研、善于<a class=\"channel_keylink\" href=\"http://www.5ykj.com/Article/\" target=\"_blank\" style=\"margin:0px;padding:0px;text-decoration-line:none;\">总结</a>、积极进修、继续教育。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	爱生：即关爱学生，这是良好教风的内在灵魂。热爱学生是教师的天职，是教师高尚情操、道德的体现。教师要深情、无私地爱学生，不知疲倦地帮助、教育、引导学生，把爱施予每一位学生，我们要努力做到师生平等、民主和谐、关爱学生、善待后进、家校互访、经常沟通、尊重学生、杜绝体罚。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	学风：厚积&nbsp; 有恒&nbsp; 善思&nbsp; 乐学</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	厚积:意为大量地、充分地积蓄。作为学生，要在各个方面积蓄能力、提高技能，平时要注意基础知识的学习、积累。做到积少成多，达到基础扎实，从而进一步做到薄发。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	有恒：意为有恒心、坚持不懈，人贵有志、学贵有恒，学习上持之以恒，是读好书的关键，只有持之以恒，才能最终达到自己的理想和目标。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	善思：意为善于思考，孔子云：“学而不思则罔，思而不学则殆”，善思者即为善学者，只有善思，才能善学，我们拒绝读死书、死读书，要做到活学善思。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	乐学：“乐”，意为乐意、快乐，“乐学”即为乐意学习，在快乐的环境中学习，把学习当作是一种快乐，变过去的“要我学”为“我要学”，变“苦学”为“乐学”，提高学习的自觉性，使学习成为学生的一种自觉行为。</p>/l/<p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	民主：建立民主的教风，是当今教育改革的迫切要求，民主的教风要求教师在传授知识中博采众议，善于听取学生的各种意见，去粗取精、去伪存真，不断改进教学方法，我们要营造民主的教风，变主宰学生一时的老师为交给学生终生学习方法的老师。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	博学：意为学识渊博，知道的多，了解的广，学问丰富，为人师者必须博学，只有自己博学，才能使学生博学，因此，我们的教师团队当广知博学、精通业务、一专多能、苦练内功、热心科研、善于<a class=\"channel_keylink\" href=\"http://www.5ykj.com/Article/\" target=\"_blank\" style=\"margin:0px;padding:0px;text-decoration-line:none;\">总结</a>、积极进修、继续教育。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	爱生：即关爱学生，这是良好教风的内在灵魂。热爱学生是教师的天职，是教师高尚情操、道德的体现。教师要深情、无私地爱学生，不知疲倦地帮助、教育、引导学生，把爱施予每一位学生，我们要努力做到师生平等、民主和谐、关爱学生、善待后进、家校互访、经常沟通、尊重学生、杜绝体罚。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	学风：厚积&nbsp; 有恒&nbsp; 善思&nbsp; 乐学</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	厚积:意为大量地、充分地积蓄。作为学生，要在各个方面积蓄能力、提高技能，平时要注意基础知识的学习、积累。做到积少成多，达到基础扎实，从而进一步做到薄发。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	有恒：意为有恒心、坚持不懈，人贵有志、学贵有恒，学习上持之以恒，是读好书的关键，只有持之以恒，才能最终达到自己的理想和目标。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	善思：意为善于思考，孔子云：“学而不思则罔，思而不学则殆”，善思者即为善学者，只有善思，才能善学，我们拒绝读死书、死读书，要做到活学善思。</p><p style=\"margin-top:0px;margin-bottom:0px;padding:0px;white-space:normal;\">	乐学：“乐”，意为乐意、快乐，“乐学”即为乐意学习，在快乐的环境中学习，把学习当作是一种快乐，变过去的“要我学”为“我要学”，变“苦学”为“乐学”，提高学习的自觉性，使学习成为学生的一种自觉行为。</p>(en)','images/nopic.png',' 民主：建立民主的教风，是当今教育改革的迫切要求，民主的教风要求教师在传授知识中博采众议，善于听取学生的各种意见，去粗取精、去伪存真，不断改进教学方法，我们要营造民主的教风，变主宰学生一时的老师为交给/l/	民主：建立民主的教风，是当今教育改革的迫切要求，民主的教风要求教师在传授知识中博采众议，善于听取学生的各种意见，去粗取精、去伪存真，不断改进教学方法，我们要营造民主的教风，变主宰学生一时的老师为交给(en)','理念/l/理念(en)','','/l/(en)','3','0');
insert into `sl_text`(`T_id`,`T_title`,`T_entitle`,`T_content`,`T_pic`,`T_description`,`T_keywords`,`T_link`,`T_pagetitle`,`T_order`,`T_like`) values('14','组织机构/l/组织机构(en)','Organization/l/Organization(en)','<img src=\"{@SL_安装目录}kindeditor/attached/image/20171024/20171024201818161816.jpg\" alt=\"\" />/l/<img src=\"{@SL_安装目录}kindeditor/attached/image/20171024/20171024201818161816.jpg\" alt=\"\" />(en)','images/nopic.png','/l/(en)','机构/l/机构(en)','','/l/(en)','4','0');
DROP TABLE IF EXISTS `sl_wap`;
CREATE TABLE IF NOT EXISTS `sl_wap` (
  `W_show` int(11) DEFAULT '0',
  `W_phone` text,
  `W_email` text,
  `W_msg` int(11) DEFAULT '0',
  `W_logo` text,
  `W_template` text,
  `W_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`W_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
insert into `sl_wap`(`W_show`,`W_phone`,`W_email`,`W_msg`,`W_logo`,`W_template`,`W_id`) values('2','010-10086','your-maill@qq.com','1','media/20171024200359748.png','','1');
DROP TABLE IF EXISTS `sl_wapslide`;
CREATE TABLE IF NOT EXISTS `sl_wapslide` (
  `S_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `S_pic` text,
  `S_title` text,
  `S_content` text,
  `S_order` int(11) DEFAULT '0',
  `S_link` text,
  PRIMARY KEY (`S_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
insert into `sl_wapslide`(`S_id`,`S_pic`,`S_title`,`S_content`,`S_order`,`S_link`) values('1','media/20151019111808765.jpg','ERATAT时尚盛典/l/ERATAT Fashion Festival','ERATAT为消费者提供简洁优雅的英伦时尚着装体验/l/ERATAT Fashion Festival','0','#');
insert into `sl_wapslide`(`S_id`,`S_pic`,`S_title`,`S_content`,`S_order`,`S_link`) values('2','media/20151019111800144.jpg','Louis Vuitton视觉盛宴/l/Louis Vuitton visual feast','路易·威登法国历史上最杰出的皮件设计大师之一/l/Louis Vuitton visual feast','0','#');
insert into `sl_wapslide`(`S_id`,`S_pic`,`S_title`,`S_content`,`S_order`,`S_link`) values('3','media/20151019111751489.jpg','Diesel时尚广告/l/Diesel fashion advertising','Diesel的风格年轻而富有创意/l/Diesel fashion advertising','0','#');
DROP TABLE IF EXISTS `sl_wmenu`;
CREATE TABLE IF NOT EXISTS `sl_wmenu` (
  `W_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `W_title` text,
  `W_type` text,
  `W_content` text,
  `W_sub` int(11) DEFAULT '0',
  `W_order` int(11) DEFAULT '0',
  PRIMARY KEY (`W_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
insert into `sl_wmenu`(`W_id`,`W_title`,`W_type`,`W_content`,`W_sub`,`W_order`) values('1','关于我们','click','2','0','1');
insert into `sl_wmenu`(`W_id`,`W_title`,`W_type`,`W_content`,`W_sub`,`W_order`) values('2','产品/案例','click','1','0','2');
insert into `sl_wmenu`(`W_id`,`W_title`,`W_type`,`W_content`,`W_sub`,`W_order`) values('3','联系我们','view','http://www.baidu.com','0','3');
insert into `sl_wmenu`(`W_id`,`W_title`,`W_type`,`W_content`,`W_sub`,`W_order`) values('4','联系方式','click','4','3','1');
insert into `sl_wmenu`(`W_id`,`W_title`,`W_type`,`W_content`,`W_sub`,`W_order`) values('5','人才招聘','click','2','1','2');
insert into `sl_wmenu`(`W_id`,`W_title`,`W_type`,`W_content`,`W_sub`,`W_order`) values('6','最新产品','click','3','2','1');
insert into `sl_wmenu`(`W_id`,`W_title`,`W_type`,`W_content`,`W_sub`,`W_order`) values('7','网站目录','click','6','1','0');
insert into `sl_wmenu`(`W_id`,`W_title`,`W_type`,`W_content`,`W_sub`,`W_order`) values('8','官方商城','view','http://www.jd.com','3','0');
