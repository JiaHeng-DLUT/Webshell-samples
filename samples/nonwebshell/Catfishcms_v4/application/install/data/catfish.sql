SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- 表的结构 `catfish_users`
--

CREATE TABLE `catfish_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(50) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `avatar` varchar(255) DEFAULT NULL,
  `sex` smallint(1) DEFAULT '0',
  `birthday` date DEFAULT NULL,
  `signature` text,
  `last_login_ip` varchar(16) DEFAULT NULL,
  `last_login_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  `create_time` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '1',
  `score` int(11) NOT NULL DEFAULT '0',
  `user_type` smallint(1) DEFAULT '7',
  `coin` int(11) NOT NULL DEFAULT '0',
  `mobile` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_posts`
--

CREATE TABLE `catfish_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned DEFAULT '0',
  `post_keywords` varchar(150) NOT NULL,
  `post_source` varchar(150) DEFAULT NULL,
  `post_date` datetime DEFAULT '2000-01-01 00:00:00',
  `post_content` longtext,
  `post_title` text,
  `post_excerpt` text,
  `post_status` int(2) DEFAULT '1',
  `comment_status` int(2) DEFAULT '1',
  `post_modified` datetime DEFAULT '2000-01-01 00:00:00',
  `post_comment` datetime DEFAULT '2000-01-01 00:00:00',
  `parent_id` bigint(20) unsigned DEFAULT '0',
  `post_type` int(2) DEFAULT '0',
  `comment_count` bigint(20) DEFAULT '0',
  `thumbnail` text DEFAULT '',
  `template` text,
  `smeta` text,
  `post_hits` int(11) DEFAULT '0',
  `post_like` int(11) DEFAULT '0',
  `istop` tinyint(1) NOT NULL DEFAULT '0',
  `recommended` tinyint(1) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`),
  KEY `post_modified` (`post_modified`),
  KEY `post_author` (`post_author`),
  KEY `post_date` (`post_date`),
  KEY `post_hits` (`post_hits`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_terms`
--

CREATE TABLE `catfish_terms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_name` varchar(200) DEFAULT NULL,
  `description` longtext,
  `parent_id` bigint(20) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_term_relationships`
--

CREATE TABLE `catfish_term_relationships` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tid`),
  KEY `term_taxonomy_id` (`term_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_nav`
--

CREATE TABLE `catfish_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `target` varchar(25) NOT NULL DEFAULT '_blank',
  `href` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `listorder` int(6) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`),
  KEY `href` (`href`),
  KEY `listorder` (`listorder`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_nav_cat`
--

CREATE TABLE `catfish_nav_cat` (
  `navcid` int(11) NOT NULL AUTO_INCREMENT,
  `nav_name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `remark` text,
  PRIMARY KEY (`navcid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_options`
--

CREATE TABLE `catfish_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL,
  `option_value` longtext NOT NULL,
  `autoload` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_comments`
--

CREATE TABLE `catfish_comments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` int(11) unsigned NOT NULL DEFAULT '0',
  `url` text DEFAULT NULL,
  `uid` int(11) NOT NULL DEFAULT '0',
  `to_uid` int(11) NOT NULL DEFAULT '0',
  `createtime` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  `content` text NOT NULL,
  `comment_type` smallint(1) NOT NULL DEFAULT '1',
  `parent_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `status` smallint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `comment_post_ID` (`post_id`),
  KEY `comment_uid` (`uid`),
  KEY `createtime` (`createtime`),
  KEY `comment_parent` (`parent_id`),
  KEY `comment_status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_slide`
--

CREATE TABLE `catfish_slide` (
  `slide_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slide_name` varchar(255) NOT NULL,
  `slide_pic` varchar(255) DEFAULT NULL,
  `slide_url` varchar(255) DEFAULT NULL,
  `slide_des` varchar(255) DEFAULT NULL,
  `slide_status` int(2) NOT NULL DEFAULT '1',
  `listorder` int(10) DEFAULT '0',
  PRIMARY KEY (`slide_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_links`
--

CREATE TABLE `catfish_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL,
  `link_name` varchar(255) NOT NULL,
  `link_image` varchar(255) DEFAULT NULL,
  `link_target` varchar(25) NOT NULL DEFAULT '_blank',
  `link_description` text NOT NULL,
  `link_location` int(2) NOT NULL DEFAULT '1',
  `link_status` int(2) NOT NULL DEFAULT '1',
  `listorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_user_favorites`
--

CREATE TABLE `catfish_user_favorites` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` bigint(20) DEFAULT NULL,
  `title` text,
  `url` text,
  `description` text,
  `object_id` int(11) DEFAULT NULL,
  `createtime` datetime NOT NULL DEFAULT '2000-01-01 00:00:00',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `createtime` (`createtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 表的结构 `catfish_guestbook`
--

CREATE TABLE `catfish_guestbook` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `msg` text NOT NULL,
  `createtime` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `createtime` (`createtime`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `catfish_nav` (`id`, `cid`, `parent_id`, `label`, `target`, `href`, `icon`, `status`, `listorder`) VALUES
(1, 1, 0, '首页', '_self', '/index', '', 1, 0);

INSERT INTO `catfish_nav_cat` (`navcid`, `nav_name`, `active`, `remark`) VALUES
(1, '导航菜单', 1, '');

INSERT INTO `catfish_posts` (`id`, `post_author`, `post_keywords`, `post_source`, `post_date`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `post_modified`, `post_comment`, `parent_id`, `post_type`, `comment_count`, `thumbnail`, `template`, `post_hits`, `post_like`, `istop`, `recommended`, `status`) VALUES
(1, 1, '', NULL, '2016-10-17 15:34:31', '<p>这是一个范例页面。它和文章不同，因为它的页面位置是固定的，主要用于不同于文章页的内容，比如：大多数人会新增一个“关于”页面向访客介绍自己。它可能类似下面这样：</p><blockquote><p>我是一个很有趣的人，我创建了网站和博客。并且，顺便提一下，我的妻子也很好。</p></blockquote><p>……或下面这样：</p><blockquote><p>XYZ网络公司成立于2000年，公司成立以来，我们一直向市民提供高品质的服务。我们位于××市，有超过2,000名员工，对××市有着相当大的贡献。</p></blockquote><p>作为一个新的Catfish用户，您可以前往“页面管理”删除这个页面，并建立属于您的全新内容。祝您使用愉快！</p><p><br/></p>', '我的第一个页面', '', 1, 1, '2016-10-17 15:34:31', '2000-01-01 00:00:00', 0, 1, 0, '', 'page.html', 0, 0, 0, 0, 1),
(2, 1, '', '', '2016-10-17 15:42:11', '<p>欢迎使用Catfish。这是您的第一篇文章。编辑或删除它，然后开始写作吧！</p>', '世界，您好！', '欢迎使用Catfish。这是您的第一篇文章。编辑或删除它，然后开始写作吧！', 1, 1, '2016-10-17 15:42:11', '2000-01-01 00:00:00', 0, 0, 0, '', NULL, 0, 0, 0, 0, 1);

INSERT INTO `catfish_slide` (`slide_id`, `slide_name`, `slide_pic`, `slide_url`, `slide_des`, `slide_status`, `listorder`) VALUES
(1, '', 'http://localhost/data/uploads/20161017/ac34332e0e4023fcaa73d1b69efff0a1.jpg', 'http://www.catfish-cms.com', '', 1, 0),
(2, '', 'http://localhost/data/uploads/20161017/af9cdd6168df9930ed1e75e9e6201224.jpg', 'http://www.catfish-cms.com', '', 1, 0),
(3, '', 'http://localhost/data/uploads/20161017/545f488ffce35eb6594249c2e911a147.jpg', 'http://www.catfish-cms.com', '', 1, 0);
