/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50553
Source Host           : 127.0.0.1:3306
Source Database       : qile_news_md5

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2019-04-02 12:06:53
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for ql_ad
-- ----------------------------
DROP TABLE IF EXISTS `ql_ad`;
CREATE TABLE `ql_ad` (
  `ad_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` mediumint(7) NOT NULL DEFAULT '0' COMMENT '广告位置',
  `username` int(11) DEFAULT NULL,
  `title` varchar(64) DEFAULT NULL COMMENT '广告标题',
  `url` varchar(128) DEFAULT NULL COMMENT '链接URL',
  `ad_img` varchar(128) DEFAULT NULL COMMENT '图片',
  `code` text COMMENT '广告代码',
  `start_time` int(10) DEFAULT NULL,
  `end_time` int(10) DEFAULT NULL,
  `ad_type` tinyint(1) NOT NULL COMMENT '0 图片广告  1代码广告',
  `sort` tinyint(3) DEFAULT '100',
  `integral` int(11) DEFAULT NULL COMMENT '总积分',
  `hits` int(111) NOT NULL DEFAULT '0' COMMENT '点击量',
  `create_time` int(10) DEFAULT NULL COMMENT '创建时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '1：开启广告  0：未开启广告',
  `editor` varchar(32) DEFAULT NULL COMMENT '编辑者',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_ad
-- ----------------------------
INSERT INTO `ql_ad` VALUES ('49', '1', null, '广告1', '#', '', null, '1554172500', '0', '0', '100', null, '0', '1554172549', '1', null);

-- ----------------------------
-- Table structure for ql_ad_position
-- ----------------------------
DROP TABLE IF EXISTS `ql_ad_position`;
CREATE TABLE `ql_ad_position` (
  `position_id` int(3) unsigned NOT NULL AUTO_INCREMENT COMMENT '表id',
  `position_cate_id` int(3) DEFAULT NULL,
  `position_name` varchar(60) NOT NULL DEFAULT '' COMMENT '广告位置名称',
  `position_type` tinyint(4) DEFAULT NULL COMMENT '广告位类型',
  `position_width` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '广告位宽度',
  `position_height` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '广告位高度',
  `position_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '广告描述',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 关闭 1 开启',
  PRIMARY KEY (`position_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_ad_position
-- ----------------------------
INSERT INTO `ql_ad_position` VALUES ('1', null, '首页图片广告', '0', '1000', '60', '', '1');

-- ----------------------------
-- Table structure for ql_admin
-- ----------------------------
DROP TABLE IF EXISTS `ql_admin`;
CREATE TABLE `ql_admin` (
  `uid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `passsalt` varchar(8) NOT NULL COMMENT '登录密钥',
  `email` varchar(50) NOT NULL DEFAULT '',
  `city_id` smallint(6) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `create_ip` varchar(15) DEFAULT NULL,
  `last_time` int(11) DEFAULT NULL,
  `last_ip` varchar(20) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_admin
-- ----------------------------

-- ----------------------------
-- Table structure for ql_admin_nav
-- ----------------------------
DROP TABLE IF EXISTS `ql_admin_nav`;
CREATE TABLE `ql_admin_nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类',
  `module` varchar(20) DEFAULT NULL,
  `title` varchar(10) DEFAULT NULL COMMENT '规则唯一标识',
  `condition` varchar(255) DEFAULT NULL COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `name` varchar(200) DEFAULT NULL,
  `icon` varchar(40) DEFAULT NULL COMMENT '字体小图标',
  `target` tinyint(1) DEFAULT NULL COMMENT '打开方式',
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `sort` tinyint(6) NOT NULL DEFAULT '0',
  `display` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态：1 显示 0 不显示',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 正常 0 禁用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=171 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_admin_nav
-- ----------------------------
INSERT INTO `ql_admin_nav` VALUES ('1', '0', null, '全局', null, '', 'fa fa-cogs', null, '1', '0', '1', '1514981902', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('2', '0', null, '内容', null, '', 'fa fa-th-large', null, '1', '0', '1', '1514981911', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('3', '0', null, '用户', null, '', 'fa fa-user', null, '1', '0', '1', '1514981921', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('32', '12', '', '短信模板', '', 'sms/index', '', '0', '1', '0', '1', '1514983007', '0', '1');
INSERT INTO `ql_admin_nav` VALUES ('5', '0', null, '运营', null, '', 'fa fa-pie-chart', null, '1', '0', '1', '1514981929', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('9', '1', null, '后台首页', null, 'index/main', '', null, '1', '0', '1', '1514982251', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('10', '1', null, '网站功能', null, '', '', null, '1', '0', '1', '1514982269', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('11', '1', null, '导航管理', null, '', '', null, '1', '0', '1', '1514982276', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('12', '1', null, '模板管理', null, '', '', null, '1', '0', '1', '1514982288', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('14', '2', null, '新闻管理', null, '', '', null, '1', '0', '1', '1514982330', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('19', '10', null, '系统设置', null, 'settings/site', '', null, '1', '0', '1', '1514982402', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('30', '11', null, '前台导航', null, 'nav/index', '', null, '1', '0', '1', '1514982983', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('31', '11', null, '后台导航', null, 'adminNav/index', '', null, '1', '0', '1', '1514982991', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('34', '12', null, '网站模板', null, 'template/index', '', null, '1', '0', '1', '1514983020', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('35', '12', null, '手机模板', null, 'templateMobile/index', '', null, '1', '0', '1', '1514983033', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('40', '14', null, '新闻列表', null, 'article/index', '', null, '1', '0', '1', '1514983206', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('41', '14', null, '新闻分类', null, 'article/category', '', null, '1', '0', '1', '1514983213', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('42', '14', null, '新闻评论', null, 'article/comment', '', null, '1', '0', '1', '1514983225', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('43', '14', null, '新闻设置', null, 'article/set', '', null, '1', '0', '1', '1514983233', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('65', '3', null, '用户管理', null, '', '', null, '1', '0', '1', '1514984021', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('66', '3', null, '管理员管理', null, '', '', null, '1', '0', '1', '1514984027', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('109', '89', null, '广告列表', null, 'ad/index', '', null, '1', '0', '0', '1517737778', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('68', '65', null, '用户列表', null, 'user/index', '', null, '1', '0', '1', '1514984089', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('70', '66', null, '管理员列表', null, 'admin/index', '', null, '1', '0', '1', '1514984111', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('71', '66', null, '角色列表', null, 'adminRole/index', '', null, '1', '0', '1', '1514984116', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('110', '92', null, '站内文章', null, 'info/index', '', null, '1', '0', '1', '1517737914', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('89', '5', null, '广告管理', null, '', '', null, '1', '0', '1', '1514984424', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('90', '5', null, '友情链接', null, '', '', null, '1', '0', '1', '1514984438', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('24', '10', '', '短信设置', '', 'settings/sms', '', '0', '1', '0', '1', '1514982586', '0', '1');
INSERT INTO `ql_admin_nav` VALUES ('92', '5', null, '站内文章管理', null, '', '', null, '1', '0', '1', '1514984465', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('25', '10', '', '邮件设置', '', 'settings/email', '', '0', '1', '0', '1', '1514982597', '0', '1');
INSERT INTO `ql_admin_nav` VALUES ('106', '14', null, '新闻增加', null, 'article/add', '', null, '1', '0', '0', '1515057579', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('107', '14', null, '新闻修改', null, 'article/edit', '', null, '1', '0', '0', '1515057592', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('108', '14', null, '新闻删除', null, 'article/del', '', null, '1', '0', '0', '1515057601', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('111', '92', null, '站内文章分类', null, 'info/category', '', null, '1', '0', '1', '1517739257', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('112', '89', null, '广告位置', null, 'adPosition/index', '', null, '1', '0', '1', '1518061702', null, '1');
INSERT INTO `ql_admin_nav` VALUES ('113', '90', null, '友链列表', null, 'friendlink/index', '', null, '1', '0', '1', '1518586774', null, '1');

-- ----------------------------
-- Table structure for ql_admin_role
-- ----------------------------
DROP TABLE IF EXISTS `ql_admin_role`;
CREATE TABLE `ql_admin_role` (
  `role_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` char(100) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `sort` tinyint(6) NOT NULL,
  `rules` text NOT NULL,
  `remarks` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`role_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='用户组表';

-- ----------------------------
-- Records of ql_admin_role
-- ----------------------------
INSERT INTO `ql_admin_role` VALUES ('1', '超级管理员', '1', '0', 'all', '超级管理员拥有所有权限');

-- ----------------------------
-- Table structure for ql_admin_role_access
-- ----------------------------
DROP TABLE IF EXISTS `ql_admin_role_access`;
CREATE TABLE `ql_admin_role_access` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色 id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='管理组明细表';

-- ----------------------------
-- Records of ql_admin_role_access
-- ----------------------------
INSERT INTO `ql_admin_role_access` VALUES ('1', '1', '1');

-- ----------------------------
-- Table structure for ql_article
-- ----------------------------
DROP TABLE IF EXISTS `ql_article`;
CREATE TABLE `ql_article` (
  `aid` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `cid` tinyint(8) NOT NULL DEFAULT '0' COMMENT '文章分类ID',
  `uid` int(10) NOT NULL DEFAULT '0',
  `username` varchar(20) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `lang` varchar(10) DEFAULT NULL COMMENT '语言，支持多国语言',
  `content` text NOT NULL COMMENT '文章内容',
  `source` varchar(100) DEFAULT NULL COMMENT '来源',
  `source_url` varchar(255) DEFAULT NULL,
  `attr_value` varchar(255) DEFAULT NULL COMMENT '文章属性',
  `video_thumb` varchar(255) DEFAULT NULL COMMENT '视频缩略图',
  `video_url` varchar(255) DEFAULT NULL,
  `introduction` varchar(255) DEFAULT NULL COMMENT '简介',
  `email` varchar(30) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL COMMENT '关键字',
  `file_url` varchar(255) DEFAULT NULL COMMENT '文章附件',
  `hits` int(11) NOT NULL DEFAULT '0' COMMENT '文章点击量',
  `thumb` varchar(255) DEFAULT NULL COMMENT '文章缩略图1',
  `thumb1` varchar(255) DEFAULT NULL COMMENT '文章缩略图2',
  `thumb2` varchar(255) DEFAULT NULL COMMENT '文章缩略图3',
  `comment` int(10) NOT NULL DEFAULT '0',
  `tag` varchar(30) DEFAULT NULL,
  `provid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `cityid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '城市',
  `distid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '乡镇',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of ql_article
-- ----------------------------

-- ----------------------------
-- Table structure for ql_article_attr
-- ----------------------------
DROP TABLE IF EXISTS `ql_article_attr`;
CREATE TABLE `ql_article_attr` (
  `attr_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `attr_value` char(2) NOT NULL COMMENT '值',
  `attr_name` char(10) NOT NULL COMMENT '名称',
  `attr_order` int(11) NOT NULL COMMENT '排序',
  PRIMARY KEY (`attr_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='文章属性';

-- ----------------------------
-- Records of ql_article_attr
-- ----------------------------
INSERT INTO `ql_article_attr` VALUES ('1', 't', '顶置', '10');
INSERT INTO `ql_article_attr` VALUES ('3', 's', '幻灯', '30');

-- ----------------------------
-- Table structure for ql_article_category
-- ----------------------------
DROP TABLE IF EXISTS `ql_article_category`;
CREATE TABLE `ql_article_category` (
  `cid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL,
  `pid` smallint(6) NOT NULL COMMENT '父类ID',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL COMMENT '描述',
  `seo_keywords` varchar(30) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL COMMENT '分类外链链接',
  `type` tinyint(2) NOT NULL DEFAULT '0' COMMENT '文章/产品/图片/单页/链接',
  `content` text COMMENT '单页分类内容',
  `path` varchar(30) DEFAULT NULL COMMENT '分类三级路径',
  `level` tinyint(1) DEFAULT NULL COMMENT '分类等级',
  `alias` varchar(20) DEFAULT NULL COMMENT '别名',
  `sort` tinyint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  `list_template` varchar(200) NOT NULL,
  `detail_template` varchar(200) DEFAULT NULL COMMENT '详情模板',
  PRIMARY KEY (`cid`),
  UNIQUE KEY `cname` (`cname`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Records of ql_article_category
-- ----------------------------
INSERT INTO `ql_article_category` VALUES ('1', '科技', '0', '', null, '', null, '0', null, '1', '1', 'keji', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('2', '娱乐', '0', '', '', '', null, '2', null, '2', '1', 'yule', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('3', '体育', '0', '', '', '', null, '3', null, '3', '1', 'tiyu', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('4', '军事', '0', '', '', '', null, '1', null, '4', '1', 'junshi', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('5', '生活', '0', '', '', '', null, '0', null, '5', '1', 'shenghuo', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('6', '财经', '0', '', '', '', null, '3', null, '6', '1', 'ceshi', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('9', '搞笑', '0', '', '', '', null, '0', null, '9', '1', 'gaoxiao', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('8', '游戏', '0', '', '', '', null, '0', null, '8', '1', 'youxi', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('10', '美食', '0', '', '', '', null, '0', null, '10', '1', 'meishi', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('11', '汽车', '0', '', '', '', null, '0', null, '11', '1', 'qiche', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('12', '国际', '0', '', '', '', null, '0', null, '12', '1', 'guoji', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('13', '时尚', '0', '', '', '', null, '0', null, '13', '1', 'shishang', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('14', '旅游', '0', '', '', '', null, '0', null, '14', '1', 'lvyou', '0', '0', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('15', '历史', '0', '', '', '', null, '0', null, '15', '1', 'lishi', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('16', '探索', '0', '', '', '', null, '0', null, '16', '1', 'tansuo', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('17', '育儿', '0', '', '', '', null, '0', null, '17', '1', 'yuer', '0', '1', 'article/list/index.html', 'article/detail/index.html');
INSERT INTO `ql_article_category` VALUES ('18', '养生', '0', '', '', '', null, '0', null, '18', '1', 'yangsheng', '0', '1', 'article/list/index.html', 'article/detail/index.html');

-- ----------------------------
-- Table structure for ql_article_comment
-- ----------------------------
DROP TABLE IF EXISTS `ql_article_comment`;
CREATE TABLE `ql_article_comment` (
  `comment_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键id',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '上级评论id,若是一级评论则为0',
  `username` varchar(100) DEFAULT NULL COMMENT '评论人',
  `uid` int(11) DEFAULT NULL COMMENT '评论人UID',
  `article_id` int(11) DEFAULT NULL COMMENT '文章编号',
  `content` text COMMENT '评论内容',
  `zan` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '点赞',
  `create_time` int(11) DEFAULT NULL COMMENT '评论或回复发表时间',
  `ip` varchar(20) NOT NULL COMMENT 'IP地址',
  `status` tinyint(1) DEFAULT '0' COMMENT '审核状态',
  PRIMARY KEY (`comment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='文章评论';

-- ----------------------------
-- Records of ql_article_comment
-- ----------------------------

-- ----------------------------
-- Table structure for ql_collect
-- ----------------------------
DROP TABLE IF EXISTS `ql_collect`;
CREATE TABLE `ql_collect` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `article_id` int(11) DEFAULT NULL COMMENT '文章收藏id',
  `uid` int(11) NOT NULL DEFAULT '0' COMMENT '用户uid',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_collect
-- ----------------------------

-- ----------------------------
-- Table structure for ql_follow
-- ----------------------------
DROP TABLE IF EXISTS `ql_follow`;
CREATE TABLE `ql_follow` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `follow_who` int(11) NOT NULL DEFAULT '0' COMMENT '关注谁',
  `who_follow` int(11) NOT NULL DEFAULT '0' COMMENT '谁关注',
  `create_time` int(11) NOT NULL DEFAULT '0',
  `group_id` int(11) NOT NULL DEFAULT '0' COMMENT '分组ID',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='关注表';

-- ----------------------------
-- Records of ql_follow
-- ----------------------------

-- ----------------------------
-- Table structure for ql_friendlink
-- ----------------------------
DROP TABLE IF EXISTS `ql_friendlink`;
CREATE TABLE `ql_friendlink` (
  `fid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL COMMENT '友情链接名称',
  `url` varchar(200) DEFAULT NULL COMMENT '网站url',
  `logo` varchar(200) DEFAULT NULL COMMENT '网站logo',
  `sort` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0：隐藏 1:显示 ',
  PRIMARY KEY (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='友情链接表';

-- ----------------------------
-- Records of ql_friendlink
-- ----------------------------

-- ----------------------------
-- Table structure for ql_info
-- ----------------------------
DROP TABLE IF EXISTS `ql_info`;
CREATE TABLE `ql_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(6) NOT NULL DEFAULT '0',
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `sort` tinyint(4) NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='站内文章';

-- ----------------------------
-- Records of ql_info
-- ----------------------------
INSERT INTO `ql_info` VALUES ('1', '1', '关于我们', '&lt;p&gt;奇乐自媒体管理系统是一款基于 奇乐CMS 开发一款自媒体新闻管理系统，官网地址 ：&lt;a href=&quot;http://www.qilecms.com/&quot;&gt;http://www.qilecms.com/&lt;/a&gt;&amp;nbsp; 官方交流反馈群：970930073&lt;/p&gt;&lt;h5 style=&quot;font-weight: 100; margin: 20px 0px 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-size: 9pt; color: rgb(255, 255, 255); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;970930073&lt;/h5&gt;&lt;h5 style=&quot;font-weight: 100; margin: 20px 0px 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-size: 9pt; color: rgb(255, 255, 255); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;970930073&lt;/h5&gt;&lt;h5 style=&quot;font-weight: 100; margin: 20px 0px 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-size: 9pt; color: rgb(255, 255, 255); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;970930073&lt;br/&gt;&lt;/h5&gt;&lt;h5 style=&quot;font-weight: 100; margin: 20px 0px 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-size: 9pt; color: rgb(255, 255, 255); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;970930073&lt;/h5&gt;&lt;h5 style=&quot;font-weight: 100; margin: 20px 0px 0px; padding: 0px; -webkit-tap-highlight-color: rgba(0, 0, 0, 0); font-size: 9pt; color: rgb(255, 255, 255); font-family: &amp;quot;Helvetica Neue&amp;quot;, Helvetica, &amp;quot;PingFang SC&amp;quot;, 微软雅黑, Tahoma, Arial, sans-serif; text-align: center; white-space: normal; background-color: rgb(255, 255, 255);&quot;&gt;970930073&lt;/h5&gt;&lt;p&gt;&lt;br/&gt;&lt;/p&gt;', '1551791526', '1', '26');
INSERT INTO `ql_info` VALUES ('2', '1', '广告服务', '&lt;p&gt;暂无内容&lt;/p&gt;', '1550370816', '2', '27');
INSERT INTO `ql_info` VALUES ('3', '1', '联系我们', '&lt;p&gt;这是联系我们内容&lt;/p&gt;', '1551791556', '5', '39');

-- ----------------------------
-- Table structure for ql_info_category
-- ----------------------------
DROP TABLE IF EXISTS `ql_info_category`;
CREATE TABLE `ql_info_category` (
  `cid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL DEFAULT '',
  `pid` smallint(6) NOT NULL DEFAULT '0' COMMENT '父类ID',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL COMMENT '描述',
  `seo_keywords` varchar(30) DEFAULT NULL,
  `list_template` varchar(200) NOT NULL,
  `detail_template` varchar(200) DEFAULT NULL COMMENT '详情模板',
  `path` varchar(30) DEFAULT NULL COMMENT '分类三级路径',
  `level` tinyint(1) DEFAULT NULL COMMENT '分类等级',
  `alias` varchar(20) DEFAULT NULL COMMENT '英文缩写',
  `sort` tinyint(6) NOT NULL DEFAULT '0' COMMENT '排序',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '状态',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Records of ql_info_category
-- ----------------------------
INSERT INTO `ql_info_category` VALUES ('1', '帮助', '0', '', '', '', 'info/list/index.html', 'info/detail/index.html', '1', '1', 'help', '0', '1');



-- ----------------------------
-- Table structure for ql_nav
-- ----------------------------
DROP TABLE IF EXISTS `ql_nav`;
CREATE TABLE `ql_nav` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类',
  `module` varchar(20) DEFAULT '',
  `name` varchar(10) DEFAULT '',
  `url` varchar(200) DEFAULT '',
  `icon` varchar(40) DEFAULT '' COMMENT '字体小图标',
  `target` tinyint(1) NOT NULL DEFAULT '0' COMMENT '打开方式',
  `is_wap` tinyint(1) NOT NULL DEFAULT '0' COMMENT '手机是否显示',
  `sort` tinyint(6) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_nav
-- ----------------------------
INSERT INTO `ql_nav` VALUES ('1', '0', null, '首页', '/', '', '0', '0', '0', '1', '1525421131', '0');
INSERT INTO `ql_nav` VALUES ('2', '0', null, '国际', '/guoji.html', '', '0', '0', '0', '1', '1525421166', '0');
INSERT INTO `ql_nav` VALUES ('3', '0', null, '汽车', '/qiche.html', '', '0', '0', '0', '1', '1525421178', '0');
INSERT INTO `ql_nav` VALUES ('4', '0', null, '美食', '/meishi.html', '', '0', '0', '0', '1', '1525421190', '0');
INSERT INTO `ql_nav` VALUES ('5', '0', null, '搞笑', '/gaoxiao.html', '', '0', '0', '0', '1', '1525421264', '0');
INSERT INTO `ql_nav` VALUES ('6', '0', null, '军事', '/junshi.html', '', '0', '0', '0', '1', '1525421290', '0');
INSERT INTO `ql_nav` VALUES ('10', '0', null, '体育', '/tiyu.html', '', '0', '0', '0', '1', '1548753353', '0');
INSERT INTO `ql_nav` VALUES ('9', '0', null, '娱乐', '/yule.html', '', '0', '0', '0', '1', '1548753345', '0');
INSERT INTO `ql_nav` VALUES ('11', '0', null, '科技', '/keji.html', '', '0', '0', '0', '1', '1548753362', '0');
INSERT INTO `ql_nav` VALUES ('17', '0', null, '生活', '/shenghuo.html', '', '0', '0', '0', '1', '1550219329', '0');
INSERT INTO `ql_nav` VALUES ('16', '0', null, '养生', '/yangsheng.html', '', '0', '0', '0', '1', '1550219109', '0');

-- ----------------------------
-- Table structure for ql_settings
-- ----------------------------
DROP TABLE IF EXISTS `ql_settings`;
CREATE TABLE `ql_settings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '配置ID',
  `groupname` varchar(30) NOT NULL DEFAULT '' COMMENT '配置组名称',
  `value` text COMMENT '配置值',
  PRIMARY KEY (`id`),
  UNIQUE KEY `groupname` (`groupname`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_settings
-- ----------------------------
INSERT INTO `ql_settings` VALUES ('1', 'site', 'a:7:{s:8:\"sitename\";s:21:\"奇乐自媒体系统\";s:4:\"logo\";s:59:\"/upload/image/20190402/74ab11f4d9f1ca744ddd34f20a9c8545.png\";s:10:\"count_code\";s:0:\"\";s:3:\"icp\";s:22:\"皖ICP备13011761号-4\";s:9:\"seo_title\";s:27:\"奇乐自媒体新闻系统\";s:12:\"seo_keywords\";s:19:\"新闻系统,新闻\";s:15:\"seo_description\";s:27:\"奇乐自媒体新闻系统\";}');
INSERT INTO `ql_settings` VALUES ('2', 'sms', 'a:4:{s:13:\"aliyun_status\";s:1:\"0\";s:11:\"AccessKeyId\";s:0:\"\";s:15:\"AccessKeySecret\";s:0:\"\";s:8:\"SignName\";s:0:\"\";}');
INSERT INTO `ql_settings` VALUES ('3', 'email', 'a:5:{s:11:\"smtp_status\";s:1:\"1\";s:9:\"smtp_host\";s:0:\"\";s:9:\"smtp_port\";s:2:\"25\";s:9:\"smtp_user\";s:0:\"\";s:9:\"smtp_pass\";s:0:\"\";}');
INSERT INTO `ql_settings` VALUES ('4', 'article', 'a:2:{s:14:\"comment_status\";s:1:\"1\";s:20:\"comment_audit_status\";s:1:\"0\";}');

-- ----------------------------
-- Table structure for ql_sms
-- ----------------------------
DROP TABLE IF EXISTS `ql_sms`;
CREATE TABLE `ql_sms` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `tpl_name` varchar(255) DEFAULT NULL,
  `use_name` varchar(50) NOT NULL COMMENT '调用名称',
  `tpl_code` varchar(100) NOT NULL COMMENT '短信模板ID',
  `tpl_content` varchar(512) NOT NULL COMMENT '发送短信内容',
  `create_time` int(11) NOT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_sms
-- ----------------------------
INSERT INTO `ql_sms` VALUES ('1', '验证码', 'sms_yzm', 'SMS_25690748', '尊敬的用户，您的验证码为：${sendcode}。非本人操作,请忽略本信息。', '1483345812', '1');

-- ----------------------------
-- Table structure for ql_template
-- ----------------------------
DROP TABLE IF EXISTS `ql_template`;
CREATE TABLE `ql_template` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1 PC 端 2 移动端',
  `name` varchar(255) NOT NULL,
  `dirname` varchar(30) NOT NULL COMMENT '目录',
  `version` varchar(10) DEFAULT NULL COMMENT '版本',
  `thumb` varchar(255) DEFAULT NULL COMMENT '封面',
  `author` varchar(30) DEFAULT NULL COMMENT '0',
  `copyright` text,
  `create_time` int(10) DEFAULT NULL COMMENT '添加时间',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 未启用 1启用',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_template
-- ----------------------------
INSERT INTO `ql_template` VALUES ('35', '1', '奇乐自媒体新闻系统', 'default', 'v1.0.0', '/template/pc/default/cover.png', 'QileCMS', 'Copyright 2018 QileCms.com all rights reserved', '1554169211', '1');

-- ----------------------------
-- Table structure for ql_user
-- ----------------------------
DROP TABLE IF EXISTS `ql_user`;
CREATE TABLE `ql_user` (
  `uid` bigint(20) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户UID',
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `nickname` varchar(30) NOT NULL COMMENT '昵称',
  `password` varchar(32) NOT NULL COMMENT '登陆密码',
  `passsalt` varchar(8) NOT NULL COMMENT '登录密钥',
  `payword` varchar(32) NOT NULL COMMENT '支付密码',
  `paysalt` varchar(8) NOT NULL COMMENT '支付密钥',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `message` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '新信件数',
  `online` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '是否有头像',
  `avatar` varchar(255) NOT NULL COMMENT '头像',
  `gender` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '性别',
  `realname` varchar(20) NOT NULL COMMENT '真实姓名',
  `mobile` varchar(50) NOT NULL,
  `qq` varchar(20) DEFAULT '',
  `aid` int(10) unsigned NOT NULL DEFAULT '0',
  `level_id` smallint(4) unsigned NOT NULL DEFAULT '4' COMMENT '等级ID',
  `regid` smallint(4) unsigned NOT NULL DEFAULT '0',
  `provid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '省份',
  `cityid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '城市',
  `distid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '乡镇',
  `sms` int(10) NOT NULL DEFAULT '0',
  `credit` int(10) NOT NULL DEFAULT '0',
  `money` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '账户资金',
  `deposit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '保证金',
  `bank` varchar(30) NOT NULL DEFAULT '' COMMENT '收款银行',
  `bank_type` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '帐号类型',
  `branch` varchar(100) NOT NULL DEFAULT '' COMMENT '开户网点',
  `account` varchar(30) NOT NULL DEFAULT '' COMMENT '收款帐号',
  `reg_ip` varchar(50) NOT NULL DEFAULT '',
  `reg_time` int(10) unsigned NOT NULL DEFAULT '0',
  `login_ip` varchar(50) NOT NULL DEFAULT '',
  `login_time` int(10) unsigned DEFAULT NULL COMMENT '登录时间',
  `login_count` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '登录次数',
  `is_email` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_mobile` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_realname` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_bank` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `is_trade` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '支付宝帐号认证',
  `trade` varchar(50) NOT NULL DEFAULT '' COMMENT '支付宝帐号',
  `inviter` varchar(30) NOT NULL DEFAULT '' COMMENT '邀请人',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '-1 禁止访问  0 待审核  1 正常  ',
  PRIMARY KEY (`uid`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `nickname` (`nickname`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='会员';

-- ----------------------------
-- Records of ql_user
-- ----------------------------

-- ----------------------------
-- Table structure for ql_zan
-- ----------------------------
DROP TABLE IF EXISTS `ql_zan`;
CREATE TABLE `ql_zan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '点赞类型：0 文章点赞 1 评论点赞',
  `type_id` tinyint(1) NOT NULL DEFAULT '0' COMMENT '类型id：对应的文章或评论的id',
  `uid` tinyint(1) DEFAULT NULL COMMENT '用户id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '点赞时间',
  `status` tinyint(1) DEFAULT NULL COMMENT '点赞状态  0:取消赞   1:有效赞',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of ql_zan
-- ----------------------------
