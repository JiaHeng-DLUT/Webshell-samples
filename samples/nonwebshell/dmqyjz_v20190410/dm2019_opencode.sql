-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2019-04-10 04:43:48
-- 服务器版本： 10.1.29-MariaDB
-- PHP Version: 7.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dm2019_opencode`
--

-- --------------------------------------------------------

--
-- 表的结构 `zzz_album`
--

CREATE TABLE `zzz_album` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `pidname` varchar(100) NOT NULL,
  `pbh` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `cssname` varchar(100) DEFAULT NULL,
  `kvsm` varchar(50) DEFAULT NULL,
  `pos` int(3) DEFAULT '50',
  `cus_columns` int(3) NOT NULL DEFAULT '3',
  `sta_visible` char(1) NOT NULL DEFAULT 'y',
  `size` int(5) DEFAULT NULL,
  `effect` varchar(100) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'block',
  `dateedit` datetime DEFAULT NULL,
  `desp` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_album`
--

INSERT INTO `zzz_album` (`id`, `pid`, `pidname`, `pbh`, `lang`, `title`, `cssname`, `kvsm`, `pos`, `cus_columns`, `sta_visible`, `size`, `effect`, `type`, `dateedit`, `desp`) VALUES
(177, 'common', 'album20180525_1153443284', 'bh2010079002demososo', 'cn', '相册测试', '', NULL, 50, 3, 'y', NULL, 'album_jssor.php', 'block', NULL, NULL),
(186, 'album20180525_1153443284', '', 'bh2010079002demososo', 'cn', NULL, NULL, '20180525_120401_2974.png', 50, 3, 'y', 202192, NULL, 'block', NULL, NULL),
(184, 'album20180525_1153443284', '', 'bh2010079002demososo', 'cn', NULL, NULL, '20180525_120342_2824.jpg', 50, 3, 'y', 43940, NULL, 'block', NULL, NULL),
(185, 'album20180525_1153443284', '', 'bh2010079002demososo', 'cn', NULL, NULL, '20180525_120342_9455.jpg', 50, 3, 'y', 42355, NULL, 'block', NULL, NULL),
(288, 'node20150806_0929404264', 'album20190404_1856021617', 'bh2010079002demososo', 'cn', '2', '', NULL, 50, 3, 'y', NULL, 'album_fancybox.php', 'block', NULL, NULL),
(289, 'album20190404_1856021617', 'salbum20190404_1856201637', 'bh2010079002demososo', 'cn', NULL, NULL, '20190404_185620_5110.jpg', 50, 3, 'y', 17689, NULL, '', NULL, NULL),
(290, 'album20190404_1856021617', 'salbum20190404_1856201637', 'bh2010079002demososo', 'cn', NULL, NULL, '20190404_185620_1595.jpg', 50, 3, 'y', 55243, NULL, '', NULL, NULL),
(287, 'album20190404_1850348626', 'salbum20190404_1850515474', 'bh2010079002demososo', 'cn', NULL, NULL, '20190404_185051_3526.jpg', 50, 3, 'y', 109349, NULL, '', NULL, NULL),
(286, 'album20190404_1850348626', 'salbum20190404_1850515474', 'bh2010079002demososo', 'cn', NULL, NULL, '20190404_185051_3545.jpg', 50, 3, 'y', 18739, NULL, '', NULL, NULL),
(285, 'node20150806_0929404264', 'album20190404_1850348626', 'bh2010079002demososo', 'cn', '1', '', NULL, 500, 3, 'y', NULL, 'album_fancybox.php', 'block', NULL, NULL),
(266, 'node20160820_0656309862', 'salbum20190305_1831121754', 'bh2010079002demososo', 'cn', NULL, NULL, '20190305_183112_5207.jpg', 50, 3, 'y', 43251, NULL, 'node', NULL, NULL),
(267, 'node20160820_0656309862', 'salbum20190305_1831121754', 'bh2010079002demososo', 'cn', NULL, NULL, '20190305_183112_9661.jpg', 50, 3, 'y', 43251, NULL, 'node', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_alias`
--

CREATE TABLE `zzz_alias` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL DEFAULT '0',
  `pbh` varchar(50) NOT NULL DEFAULT 'n',
  `lang` varchar(50) NOT NULL,
  `pos` int(3) NOT NULL DEFAULT '50' COMMENT 'must need',
  `name` varchar(225) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_alias`
--

INSERT INTO `zzz_alias` (`id`, `pid`, `pbh`, `lang`, `pos`, `name`) VALUES
(2, 'cate20150805_1125344029', 'bh2010079002demososo', 'cn', 50, 'products'),
(3, 'cate20150805_1133251007', 'bh2010079002demososo', 'cn', 50, 'news'),
(5, 'page20150805_1138522811', 'bh2010079002demososo', 'cn', 50, 'about'),
(6, 'page20150805_1143268522', 'bh2010079002demososo', 'cn', 50, 'team'),
(7, 'page20150806_0435579851', 'bh2010079002demososo', 'cn', 50, 'jobs'),
(10, 'page20150806_0436437668', 'bh2010079002demososo', 'cn', 50, 'contact'),
(23, 'page20151015_0855506815', 'bh2010079002demososo', 'cn', 50, 'friendlinks'),
(32, 'page20160307_1115284044', 'bh2010079002demososo', 'cn', 50, 'index'),
(37, 'cate20160410_0658287350', 'bh2010079002demososo', 'cn', 50, 'sp'),
(95, 'csub20150805_1127356368', 'bh2010079002demososo', 'cn', 50, 'huawei'),
(234, 'cate20181217_1559263417', 'bh2010079002demososo', 'cn', 50, 'cate20181217_1559263417'),
(243, 'node20150806_0916371045', 'bh2010079002demososo', 'cn', 50, 'GSM-hua2'),
(244, 'csub20150805_1127279495', 'bh2010079002demososo', 'cn', 50, 'asfdf'),
(247, 'page20190102_1814157870', 'bh2010079002demososo', 'cn', 50, 'search'),
(248, 'tag20170712_1850111749', 'bh2010079002demososo', 'cn', 50, 'like-soccer'),
(250, 'tag20170717_1519198553', 'bh2010079002demososo', 'cn', 50, 'buy-a-huawei'),
(252, 'tag20170714_1125102062', 'bh2010079002demososo', 'cn', 50, 'do-you-like-movie'),
(259, 'page20190311_1431198444', 'bh2010079002demososo', 'cn', 50, 'dmregion_101'),
(257, 'page20190227_1749231026', 'bh2010079002demososo', 'cn', 50, 'dmregion_100');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_auth`
--

CREATE TABLE `zzz_auth` (
  `id` int(9) NOT NULL,
  `pbh` varchar(100) NOT NULL,
  `lang` varchar(50) NOT NULL DEFAULT 'cn',
  `pidname` varchar(100) DEFAULT NULL,
  `nickname` varchar(100) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL COMMENT '手机',
  `ps` varchar(100) NOT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `dateday` date DEFAULT NULL,
  `dateedit` datetime DEFAULT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'normal',
  `sta_noaccess` char(1) NOT NULL DEFAULT 'n',
  `tokenhour` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_auth`
--

INSERT INTO `zzz_auth` (`id`, `pbh`, `lang`, `pidname`, `nickname`, `email`, `telephone`, `ps`, `ip`, `dateday`, `dateedit`, `type`, `sta_noaccess`, `tokenhour`) VALUES
(108, 'bh2010079002demososo', 'cn', NULL, '1111111111111', '', '', '00as1wm0AZG56', NULL, NULL, '2018-09-29 12:44:15', 'normal', 'n', NULL),
(109, 'bh2010079002demososo', 'cn', 'mem20180929_1245206770', '', '', '', '', '127.0.0.1', '2018-09-29', '2018-09-29 12:45:20', 'normal', 'n', 'inq_20180929_12'),
(110, 'bh2010079002demososo', 'cn', 'mem20180929_1247566009', '222222222222', '', '', '', '127.0.0.1', '2018-09-29', '2018-09-29 12:47:56', 'normal', 'n', 'inq_20180929_12'),
(111, 'bh2010079002demososo', 'cn', 'mem20180929_1247591930', '33333333333', '', '', '', '127.0.0.1', '2018-09-29', '2018-09-29 12:47:59', 'normal', 'n', 'inq_20180929_12'),
(112, 'bh2010079002demososo', 'cn', 'mem20180929_1250127637', '555555555', '', '', '00as1wm0AZG56', NULL, NULL, '2018-09-29 12:50:12', 'normal', 'y', NULL),
(113, 'bh2010079002demososo', 'cn', 'mem20180929_1256261298', '大厦大厦在', '', '', '', '127.0.0.1', '2018-09-29', '2018-09-29 12:56:26', 'normal', 'n', 'inq_20180929_12'),
(114, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'aa', 'aa@aa.com', '1355555', '00gzXhNTZmkME', '127.0.0.1', '2018-09-29', '2018-09-29 20:51:48', 'normal', 'n', 'inq_20180929_20'),
(115, 'bh2010079002demososo', 'cn', 'mem20180929_2131163982', '', '', '', '', '127.0.0.1', '2018-09-29', '2018-09-29 21:31:16', 'normal', 'n', 'inq_20180929_21'),
(124, 'bh2010079002demososo', 'cn', 'mem20181224_1544011165t65359', 'asd', 'aaa@aaa.com', '13566666666', '00gzXhNTZmkME', '127.0.0.1', '2018-12-24', '2018-12-24 15:44:01', 'normal', 'n', 'inq_20181224_15'),
(122, 'bh2010079002demososo', 'cn', 'mem20180929_2142493577', 'dd', 'dd@dd.com', '13444444444', '00gzXhNTZmkME', '127.0.0.1', '2018-09-29', '2018-09-29 21:42:49', 'normal', 'n', 'inq_20180929_21'),
(123, 'bh2010079002demososo', 'cn', 'mem20180930_1325386296t76372', 'dddssssd2', 'aa@asddsa.com', '13566666662', '007Uvh4TLtdPU', '127.0.0.1', '2018-09-30', '2018-09-30 13:25:38', 'normal', 'n', 'inq_20180930_13');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_authaddress`
--

CREATE TABLE `zzz_authaddress` (
  `id` int(9) NOT NULL,
  `pbh` varchar(100) NOT NULL,
  `lang` varchar(50) NOT NULL DEFAULT 'cn',
  `pid` varchar(100) DEFAULT NULL COMMENT 'userid',
  `name` varchar(100) NOT NULL,
  `telephone` varchar(50) DEFAULT NULL COMMENT '手机',
  `address` varchar(250) DEFAULT NULL,
  `sta_default` char(1) NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_authaddress`
--

INSERT INTO `zzz_authaddress` (`id`, `pbh`, `lang`, `pid`, `name`, `telephone`, `address`, `sta_default`) VALUES
(128, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', '2223', '13555555555', 'efa', 'y'),
(132, 'bh2010079002demososo', 'cn', 'mem20181224_1544011165t65359', 'asdfasfg2222', '13555555555', 'asdfa', 'y'),
(134, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'aaaffffffeer', '13555555555', 'fffaf', 'n'),
(137, 'bh2010079002demososo', 'cn', 'mem20180929_2142493577', 'bbbb', '13555555555', 'asdfdff', 'n'),
(138, 'bh2010079002demososo', 'cn', 'mem20180929_2142493577', 'asdf', '13555555555', 'asfd', 'n');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_authcart`
--

CREATE TABLE `zzz_authcart` (
  `id` int(9) NOT NULL,
  `pbh` varchar(100) NOT NULL,
  `lang` varchar(50) NOT NULL DEFAULT 'cn',
  `pid` varchar(100) DEFAULT NULL COMMENT 'userid',
  `pidpro` varchar(100) NOT NULL,
  `pronum` int(3) DEFAULT '0',
  `proprice` int(3) DEFAULT NULL,
  `prosku` varchar(100) NOT NULL,
  `dateedit` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_authcart`
--

INSERT INTO `zzz_authcart` (`id`, `pbh`, `lang`, `pid`, `pidpro`, `pronum`, `proprice`, `prosku`, `dateedit`) VALUES
(152, 'bh2010079002demososo', 'cn', 'mem20180929_2142493577', 'node20160820_0656309862', 1, NULL, '', '2019-01-09 18:51:53');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_authcheckout`
--

CREATE TABLE `zzz_authcheckout` (
  `id` int(9) NOT NULL,
  `pbh` varchar(100) NOT NULL,
  `lang` varchar(50) NOT NULL DEFAULT 'cn',
  `pid` varchar(100) DEFAULT NULL COMMENT 'userid',
  `pidpro` varchar(100) NOT NULL COMMENT 'nodepidname',
  `pidorder` varchar(100) DEFAULT NULL,
  `protitle` varchar(200) NOT NULL,
  `pronum` int(3) DEFAULT '0',
  `proprice` float DEFAULT NULL,
  `propricetotal` float NOT NULL,
  `prosku` varchar(100) NOT NULL,
  `proimg` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_authcheckout`
--

INSERT INTO `zzz_authcheckout` (`id`, `pbh`, `lang`, `pid`, `pidpro`, `pidorder`, `protitle`, `pronum`, `proprice`, `propricetotal`, `prosku`, `proimg`) VALUES
(147, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'node20160820_0656309862', 'order20181228_1244141405', '黑色 移动联通电信4G手机 双卡双待', 1, 33.33, 33.33, '', NULL),
(148, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'node20150806_0926593475', 'order20181228_1244141405', 'LE50D59 50英寸 超窄边内置WIFI安卓智能液晶电视', 2, 55.22, 110.44, '', NULL),
(151, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'node20160820_0656309862', 'order20181228_1247182998', '黑色 移动联通电信4G手机 双卡双待', 1, 33.33, 33.33, '', NULL),
(152, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'node20150806_0926593475', 'order20181228_1247182998', 'LE50D59 50英寸 超窄边内置WIFI安卓智能液晶电视', 2, 55.22, 110.44, '', NULL),
(153, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'node20160820_0656309862', 'order20181228_1247577821', '黑色 移动联通电信4G手机 双卡双待', 1, 33.33, 33.33, '', NULL),
(154, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'node20150806_0926593475', 'order20181228_1247577821', 'LE50D59 50英寸 超窄边内置WIFI安卓智能液晶电视', 2, 55.22, 110.44, '', NULL),
(155, 'bh2010079002demososo', 'cn', 'mem20180929_2142493577', 'node20150806_0929404264', 'order20190109_1840562131', '17.3英寸游戏本17.3英寸游戏本', 1, 800, 800, '', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_authorder`
--

CREATE TABLE `zzz_authorder` (
  `id` int(9) NOT NULL,
  `pbh` varchar(100) NOT NULL,
  `lang` varchar(50) NOT NULL DEFAULT 'cn',
  `pid` varchar(100) DEFAULT NULL COMMENT 'userid',
  `pidname` varchar(100) DEFAULT NULL,
  `address` varchar(200) NOT NULL,
  `sta_del` char(1) NOT NULL DEFAULT 'n' COMMENT '是否回收站',
  `dateedit` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_authorder`
--

INSERT INTO `zzz_authorder` (`id`, `pbh`, `lang`, `pid`, `pidname`, `address`, `sta_del`, `dateedit`) VALUES
(155, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'order20181228_1247144186', 'address.........', 'n', '2018-12-28 12:47:14'),
(156, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'order20181228_1247144186', 'address.........', 'n', '2018-12-28 12:47:14'),
(157, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'order20181228_1247182998', 'address.........', 'n', '2018-12-28 12:47:18'),
(158, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'order20181228_1247182998', 'address.........', 'n', '2018-12-28 12:47:18'),
(159, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'order20181228_1247577821', 'address.........', 'n', '2018-12-28 12:47:57'),
(160, 'bh2010079002demososo', 'cn', 'mem20180929_2051487140', 'order20181228_1247577821', 'address.........', 'n', '2018-12-28 12:47:57'),
(161, 'bh2010079002demososo', 'cn', 'mem20180929_2142493577', 'order20190109_1840562131', 'address.........', 'n', '2019-01-09 18:40:56');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_block`
--

CREATE TABLE `zzz_block` (
  `id` int(11) NOT NULL,
  `pbh` varchar(100) CHARACTER SET utf8 NOT NULL,
  `pid` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT 'is type',
  `pidstylebh` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `pidname` varchar(100) CHARACTER SET utf8 NOT NULL,
  `pidcate` text CHARACTER SET utf8,
  `pidcolumn` varchar(80) CHARACTER SET utf8 DEFAULT 'none' COMMENT 'column pidname',
  `typecolumn` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT 'block' COMMENT 'column or block ',
  `lang` varchar(50) CHARACTER SET utf8 NOT NULL,
  `name` varchar(150) CHARACTER SET utf8 DEFAULT NULL,
  `pos` int(3) DEFAULT '50',
  `sta_visible` char(1) CHARACTER SET utf8 DEFAULT 'y',
  `blockimg` varchar(100) CHARACTER SET utf8 DEFAULT NULL,
  `blockcan` text CHARACTER SET utf8,
  `despjj` text CHARACTER SET utf8,
  `desp` text CHARACTER SET utf8,
  `desptext` text CHARACTER SET utf8,
  `template` varchar(100) CHARACTER SET utf8 DEFAULT 'default',
  `dateday` char(10) CHARACTER SET utf8 DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gb2312;

--
-- 转存表中的数据 `zzz_block`
--

INSERT INTO `zzz_block` (`id`, `pbh`, `pid`, `pidstylebh`, `pidname`, `pidcate`, `pidcolumn`, `typecolumn`, `lang`, `name`, `pos`, `sta_visible`, `blockimg`, `blockcan`, `despjj`, `desp`, `desptext`, `template`, `dateday`) VALUES
(833, 'bh2010079002demososo', 'video', 'common', 'vblock20170920_1203376300', NULL, 'none', 'block', 'cn', 'QQ视频 - default', 50, 'y', NULL, NULL, NULL, '', NULL, 'default', '2017-09-21'),
(85, 'bh2010079002demososo', 'bkcustom', 'common', 'vblock20151217_0448227671', 'style20160720_0539115716', 'none', 'block', 'cn', '公告：DM企业建站系统促销活动 - notice', 50, 'y', NULL, 'cssname:##==#==ifcurmb:##n==#==namefront:##公告：DM企业建站系统促销活动==#==bgcolor:##==#==blockimg:##==#==linktitle:##==#==linkurl:##', '', '&lt;p&gt;&lt;span style=&quot;font-size:16px&quot;&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;strong&gt;这是一段弹出来的网站公告内容。当网站第一次打开时，&lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:16px&quot;&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;strong&gt;也会弹出这个内容。可以在后台修改内容。&lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:16px&quot;&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;strong&gt;如果不需要自动弹出功能，也可以在后台取消。&lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20180315_123721_1520.jpg&quot; style=&quot;height:421px; width:561px&quot; /&gt;&lt;/p&gt;', '', 'notice.tpl.php', '2017-10-12'),
(229, 'bh2010079002demososo', 'bkcustom', 'common', 'vblock20160510_1000376089', 'style20160720_0539115716', NULL, 'block', 'cn', '404页面，当页面不存在时。', 50, 'y', NULL, 'cssname:##==#==ifcurmb:##n==#==namefront:##==#==bgcolor:##==#==blockimg:##==#==linktitle:##==#==linkurl:##', '', '&lt;p style=&quot;text-align:center&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20160510_100152_4288.jpg&quot; style=&quot;height:267px; width:504px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:16px&quot;&gt;&lt;strong&gt;对不起，您访问的页面不存在。&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:16px&quot;&gt;&lt;strong&gt;&lt;a href=&quot;/&quot;&gt;请返回首页 》&lt;/a&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p style=&quot;text-align:center&quot;&gt;&lt;span style=&quot;font-size:16px&quot;&gt;&lt;strong&gt;DM企业建站系统 &lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;www.demososo.com&lt;/a&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', 'default.tpl.php', '2017-09-20'),
(431, 'bh2010079002demososo', 'bkcustom', 'common', 'vblock20160921_1144538411', NULL, NULL, 'block', 'cn', '网站头部 右上角 的一段文字 - default', 50, 'y', NULL, 'cssname:##boxcolnopad==#==namefront:##==#==bgcolor:##==#==linktitle:##==#==linkurl:##', '', '&lt;p&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;span style=&quot;font-size:28px&quot;&gt;&lt;strong&gt;021 6666 6666&lt;/strong&gt;&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;', '', 'default.tpl.php', '2017-09-20'),
(717, 'bh2010079002demososo', 'video', 'common', 'vblock20170414_1636075709', NULL, NULL, 'none', 'cn', '本地视频 - default', 50, 'y', NULL, NULL, NULL, '', NULL, 'default', '2017-09-20'),
(724, 'bh2010079002demososo', 'bknode', 'common', 'vblock20170419_1529251096', 'cate20160410_0658287350', NULL, 'none', 'cn', '视频分类 - 图文列表 grid_node  - 带播放按钮', 35, 'y', NULL, 'cssname:##bgvideo diimg  moresm==#==testimgfolder:##==#==ifcurmb:##n==#==maxline:##8==#==cus_columns:##4==#==cus_substrnum:##0==#==namefront:##==#==bgcolor:##==#==blockimg:##==#==linktitle:##==#==linkurl:##', '', NULL, NULL, 'grid_node.tpl.php', '2017-09-21'),
(727, 'bh2010079002demososo', 'bknode', 'common', 'vblock20170419_1557044653', 'cate20150805_1133251007', NULL, 'none', 'cn', '列表 list simple', 50, 'y', '', 'cssname:##list_simple_nodesp==#==cssstyle:##==#==maxline:##10==#==cus_columns:##1==#==cus_substrnum:##0==#==namefront:##==#==nodebtnmore:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'list_simple.tpl.php', NULL),
(728, 'bh2010079002demososo', 'bknode', 'common', 'vblock20170419_1557131900', 'cate20150805_1133251007', NULL, 'none', 'cn', '新闻 - 向上垂直滚动列表 -- 如果 css名称加 listcircle ，则会是圆形日期。默认为方形', 30, 'y', NULL, 'cssname:##listcircle==#==cssstyle:##==#==maxline:##20==#==cus_columns:##4==#==cus_substrnum:##80==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'news_vertical.php', '2017-09-19'),
(729, 'bh2010079002demososo', 'bkblockdh', 'common', 'vblock20170419_1630345041', 'csub20160707_0905038793', NULL, 'none', 'cn', '幻灯片 - 默认效果,  -- css名称加 showtitle，可以显示文字', 5, 'y', NULL, 'cssname:##==#==testimgfolder:##==#==ifcurmb:##n==#==maxline:##20==#==cus_columns:##1==#==namefront:##==#==bgcolor:##==#==blockimg:##==#==linktitle:##==#==linkurl:##', '', NULL, NULL, 'banner_normal.tpl.php', '2017-09-19'),
(730, 'bh2010079002demososo', 'bkblockdh', 'common', 'vblock20170419_1639427863', 'csub20160707_0914597182', NULL, 'none', 'cn', '幻灯片 - 移动端', 5, 'y', NULL, 'cssname:##==#==testimgfolder:##==#==ifcurmb:##n==#==maxline:##20==#==cus_columns:##1==#==namefront:##==#==bgcolor:##==#==blockimg:##==#==linktitle:##==#==linkurl:##', '', NULL, NULL, 'banner_mobile.tpl.php', '2017-09-19'),
(733, 'bh2010079002demososo', 'bkblockdh', 'common', 'vblock20170419_1837016257', 'csub20160708_0511229047', NULL, 'none', 'cn', '为什么选择我们', 2, 'y', NULL, 'cssname:##==#==testimgfolder:##==#==ifcurmb:##n==#==maxline:##20==#==cus_columns:##1==#==namefront:##==#==bgcolor:##==#==blockimg:##==#==linktitle:##==#==linkurl:##', '', NULL, NULL, 'slider_whychoose.tpl.php', '2017-09-19'),
(734, 'bh2010079002demososo', 'bkblockdh', 'common', 'vblock20170419_1841265872', 'csub20160708_0508436425', NULL, 'none', 'cn', '客户评价-滚动效果', 2, 'y', NULL, 'cssname:##==#==testimgfolder:##==#==ifcurmb:##n==#==maxline:##8==#==cus_columns:##2==#==namefront:##==#==bgcolor:##==#==blockimg:##==#==linktitle:##==#==linkurl:##', '', NULL, NULL, 'testimonials.tpl.php', '2017-09-19'),
(736, 'bh2010079002demososo', 'bkblockdh', 'common', 'vblock20170419_1845397696', 'csub20160707_1140595619', NULL, 'none', 'cn', '我们的服务 - tab切换', 2, 'y', NULL, 'cssname:##==#==cssstyle:##==#==maxline:##5==#==cus_columns:##1==#==cus_substrnum:##500==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'tab_service.tpl.php', '2017-09-19'),
(738, 'bh2010079002demososo', 'bkblockdh', 'common', 'vblock20170420_1158241500', '', NULL, 'none', 'cn', '我们的服务-两列', 2, 'y', NULL, 'cssname:##==#==cssstyle:##==#==maxline:##20==#==cus_columns:##2==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'grid_img_left.php', '2017-09-19'),
(851, 'bh2010079002demososo', 'column', 'common', 'vblock20170921_1139507156', NULL, 'colu20170921_1138528459', 'column', 'cn', ' - default', 50, 'y', NULL, 'namefront:##公司新闻==#==blockid:##vblock20170419_1557044653==#==cssname:##==#==linktitle:##==#==linkurl:##', '', '', '', 'default_column', '2017-10-12'),
(850, 'bh2010079002demososo', 'column', 'common', 'vblock20170921_1139335749', NULL, 'colu20170921_1138459407', 'column', 'cn', ' - default', 50, 'y', NULL, 'namefront:##标签==#==blockid:##prog_tag==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', '', '', '', 'default_column', '2017-10-12'),
(848, 'bh2010079002demososo', 'column', 'common', 'vblock20170921_1139013583', NULL, 'colu20170921_1138225871', 'column', 'cn', ' - default', 50, 'y', NULL, 'namefront:##联系方式==#==blockid:##==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', '', '&lt;p&gt;联系：DM企业建站系统&lt;br /&gt;\r\n地址：上海市浦东新区&lt;br /&gt;\r\n电话： 136 6666 6666&lt;br /&gt;\r\n邮箱：66666666@QQ.com&lt;br /&gt;\r\n网址： &lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;www.demososo.com&lt;/a&gt;&lt;/p&gt;', '', 'default_column', '2017-09-21'),
(849, 'bh2010079002demososo', 'column', 'common', 'vblock20170921_1139192157', NULL, 'colu20170921_1138331265', 'column', 'cn', '- default', 50, 'y', NULL, 'namefront:##==#==blockid:##==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com/sp.html&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20170421_144032_2721.jpg&quot; style=&quot;height:124px; width:242px&quot; /&gt;&lt;/a&gt;&lt;/p&gt;', '', 'default_column', '2017-10-04'),
(834, 'bh2010079002demososo', 'column', 'common', 'vblock20170920_1611575542', NULL, 'colu20170914_1755204518', 'column', 'cn', ' - defaultnopadmag', 50, 'y', NULL, 'namefront:##==#==blockid:##==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', '', '&lt;p&gt;&lt;strong&gt;欢迎光临DM建站系统 总部：上海&lt;/strong&gt;&lt;/p&gt;', '', 'default_column', '2017-09-20'),
(835, 'bh2010079002demososo', 'column', 'common', 'vblock20170920_1717501290', NULL, 'colu20170920_1717466496', 'column', 'cn', ' - default', 50, 'y', NULL, 'namefront:##==#==blockid:##prog_backtotop==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##&lt;br /&gt;&lt;font size=&#039;1&#039;&gt;&lt;table class=&#039;xdebug-error xe-notice&#039; dir=&#039;ltr&#039; border=&#039;1&#039; cellspacing=&#039;0&#039; cellpadding=&#039;1&#039;&gt;&lt;tr&gt;&lt;th align=&#039;left&#039; bgcolor=&#039;#f57900&#039; colspan=', '', '', '', 'default_column', '2017-09-20'),
(836, 'bh2010079002demososo', 'column', 'common', 'vblock20170920_1718376273', NULL, 'colu20170920_1718203997', 'column', 'cn', ' - default', 50, 'y', NULL, 'namefront:##==#==blockid:##==#==cssname:##pcshow==#==linktitle:##==#==linkurl:##', '', '', '&lt;div class=&quot;sitecolorchange&quot;&gt;\r\n &lt;div class=&quot;cp onlineclosecolor&quot;  style=&quot;display: block;&quot;&gt; &lt;/div&gt;\r\n &lt;a href=&quot;http://www.demososo.com/mb.html&quot; target=&quot;_blank&quot;&gt;更多官方模板&amp;gt;&lt;/a&gt;\r\n\r\n  \r\n&lt;/div&gt;', 'default_column', '2017-11-29'),
(820, 'bh2010079002demososo', 'column', 'common', 'vblock20170914_1756148792', NULL, 'colu20170914_1755237816', 'column', 'cn', 'tr - defaultnopadmag', 50, 'y', NULL, 'namefront:##==#==blockid:##==#==cssname:##tr==#==linktitle:##==#==linkurl:##', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com/install.html&quot; target=&quot;_blank&quot;&gt;如何安装&lt;/a&gt; | &lt;a href=&quot;http://www.demososo.com/sq.html&quot; target=&quot;_blank&quot;&gt;关于授权&lt;/a&gt; | &lt;a href=&quot;http://www.demososo.com/sp.html&quot; target=&quot;_blank&quot;&gt;视频教程&lt;/a&gt;&lt;/p&gt;', '', 'default_column', '2017-09-20'),
(828, 'bh2010079002demososo', 'bknode', 'common', 'vblock20170919_1202408332', 'cate20150805_1125344029', 'none', 'block', 'cn', '普通的产品中心  grid_node', 35, 'y', NULL, 'cssname:##imghg180 imgdesp80 gridboxshadow zoomimgwrap  morexs more3==#==cssstyle:##==#==maxline:##8==#==cus_columns:##4==#==cus_substrnum:##0==#==namefront:##==#==nodebtnmore:##==#==linktitle:##查看详情==#==linkurl:##dsdad==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'grid_node.tpl.php', '2017-09-19'),
(829, 'bh2010079002demososo', 'bkblockdh', 'common', 'vblock20170919_1446491004', 'csub20160708_0509074359', 'none', 'block', 'cn', '我们的客户 - 滚动效果', 3, 'y', NULL, 'cssname:##slickbtn slickarrow2 slickarrow2xs==#==cssstyle:##==#==maxline:##10==#==cus_columns:##6==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'clients_slider_.php', '2017-09-19'),
(897, 'bh2010079002demososo', 'bkblockdh', 'common', 'vblock20171201_1536338532', 'csub20170426_1859253747', 'none', 'block', 'cn', '全屏幻灯片 fullscreen default03', 5, 'y', NULL, 'cssname:##==#==testimgfolder:##==#==ifcurmb:##n==#==maxline:##20==#==cus_columns:##1==#==namefront:##==#==bgcolor:##==#==blockimg:##==#==linktitle:##==#==linkurl:##', '', NULL, NULL, 'banner_fullscreen.tpl.php', NULL),
(867, 'bh2010079002demososo', 'column', 'common', 'vblock20171012_0857055868', NULL, 'colu20171012_0857027802', 'column', 'cn', ' - &lt;div class=&quot;onlineqq&quot;&gt;\r\n\r\n&lt;div class=&quot;onlineopen cp&quot;&gt; &lt;/div&gt;\r\n&lt;div class=&quot;onlineclose cp&quot;&gt; &l', 50, 'y', NULL, 'namefront:##==#==blockid:##==#==cssname:##==#==linktitle:##==#==linkurl:##', '', '', '&lt;div class=&quot;onlineqq&quot;&gt;\r\n\r\n&lt;div class=&quot;onlineopen cp&quot;&gt; &lt;/div&gt;\r\n&lt;div class=&quot;onlineclose cp&quot;&gt; &lt;/div&gt;\r\n\r\n\r\n&lt;div class=&quot;onlinecontent dn&quot;&gt; \r\n        &lt;ul class=&quot;qqnumber&quot;&gt;\r\n        &lt;li&gt;&lt;a  href=&quot;http://wpa.qq.com/msgrd?v=3&amp;uin=939805498&amp;site=qq&amp;menu=yes&quot; target=&quot;_blank&quot;&gt;售前咨询&lt;/a&gt;&lt;/li&gt;\r\n         &lt;li&gt;&lt;a  href=&quot;http://wpa.qq.com/msgrd?v=3&amp;uin=939805498&amp;site=qq&amp;menu=yes&quot;   target=&quot;_blank&quot;&gt;售后咨询&lt;/a&gt;&lt;/li&gt;\r\n        &lt;/ul&gt;\r\n&lt;div class=&quot;onlinetel&quot;&gt;\r\n            售前咨询热线 \r\n          &lt;span&gt; 400-123-45678 &lt;/span&gt;\r\n\r\n            售后咨询热线  \r\n           &lt;span&gt; 021-12345678 &lt;/span&gt;\r\n\r\n            热线--添加或修改  \r\n           &lt;span&gt; 021-12345678 &lt;/span&gt;\r\n        &lt;/div&gt;\r\n\r\n  &lt;p class=&quot;tc&quot;&gt;\r\n        &lt;a target=&quot;_blank&quot; href=&quot;http://www.demososo.com&quot;&gt;&lt;img border=&quot;0&quot; src=&quot;imgpath_3qys0o_comimage/cn/20160410_100653_6176.gif&quot; width=&quot;120&quot;&gt;&lt;/a&gt;\r\n &lt;/p&gt;\r\n\r\n &lt;div class=&quot;tc&quot;&gt;\r\n                &lt;p&gt;微信搜索：&lt;span&gt;demososo&lt;/span&gt;&lt;/p&gt;\r\n                &lt;p&gt;&lt;img src=&quot;imgpath_3qys0o_comimage/cn/20160410_100648_6599.jpg&quot; border=&quot;0&quot; width=&quot;120px&quot;&gt;&lt;/p&gt;\r\n                &lt;p&gt;扫一扫官方微信&lt;/p&gt;\r\n    &lt;/div&gt;\r\n\r\n&lt;/div&gt;&lt;!--end online content--&gt;\r\n\r\n&lt;/div&gt;&lt;!--end onlineqq--&gt;', 'default_column', '2017-11-29'),
(1510, 'bh2010079002demososo', 'bknode', 'common', 'vblock20190117_1056524182', 'cate20150805_1133251007', 'none', 'block', 'cn', '单列滚动的内容效果 - 推荐新闻', 50, 'y', NULL, 'cssname:##ordernodetj==#==cssstyle:##==#==maxline:##3==#==cus_columns:##1==#==cus_substrnum:##0==#==namefront:##==#==nodebtnmore:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'slider_onenode.php', NULL),
(908, 'bh2010079002demososo', 'bkblockdh', 'common', 'vblock20171220_1120341606', 'csub20171212_1153095561', 'none', 'block', 'cn', 'water01模板的幻灯片', 5, 'y', NULL, 'cssname:##==#==testimgfolder:##==#==ifcurmb:##n==#==maxline:##20==#==cus_columns:##1==#==namefront:##==#==bgcolor:##==#==blockimg:##==#==linktitle:##==#==linkurl:##', '', NULL, NULL, 'banner_water01.tpl.php', NULL),
(923, 'bh2010079002demososo', 'video', 'common', 'vblock20180123_1850456893', NULL, 'none', 'block', 'cn', 'asdfasd', 50, 'y', NULL, NULL, 'asdfasdf', 'v.qq.comccc', NULL, 'default', NULL),
(928, 'bh2010079002demososo', 'video', 'common', 'vblock20180124_1238309815', NULL, 'none', 'block', 'cn', 'asfdasf', 50, 'y', NULL, NULL, '', '', NULL, 'default', NULL),
(929, 'bh2010079002demososo', 'video', 'common', 'vblock20180124_1238421513', NULL, 'none', 'block', 'cn', '11111111', 50, 'y', NULL, NULL, '44444cc', 'asdf.mp4', NULL, 'default', NULL),
(930, 'bh2010079002demososo', 'video', 'common', 'vblock20180124_1507176931', NULL, 'none', 'block', 'cn', 'rrrrrrrrrrrrasffasdfa', 50, 'y', NULL, NULL, NULL, NULL, NULL, 'default', NULL),
(931, 'bh2010079002demososo', 'video', 'common', 'vblock20180124_1512434171', NULL, 'none', 'block', 'cn', 'mp4的视频', 50, 'y', NULL, NULL, NULL, NULL, NULL, 'video_default', NULL),
(932, 'bh2010079002demososo', 'video', 'common', 'vblock20180124_1613284594', NULL, 'none', 'block', 'cn', 'TFboys和小虎队跨时空合作', 50, 'y', NULL, NULL, NULL, NULL, NULL, 'video_default', NULL),
(936, 'bh2010079002demososo', 'column', 'common', 'vblock20180224_1442019220', NULL, 'colu20180224_1441239930', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##关于我们==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', NULL, '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot;&gt;&lt;strong&gt;DM企业建站系统&lt;/strong&gt;&lt;/a&gt;，专注中小企业网站建设，&lt;/p&gt;\r\n\r\n&lt;p&gt;系统开源免费，无需授权。&lt;/p&gt;\r\n\r\n&lt;p&gt;模板都支持响应式设计。支持移动端访问。&lt;br /&gt;\r\nDM企业建站系统，专注中小企业网站建设，系统开源免费，无需授权。&lt;/p&gt;', '', 'default_column', '2018-02-24'),
(937, 'bh2010079002demososo', 'column', 'common', 'vblock20180224_1442155974', NULL, 'colu20180224_1441348425', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##公司==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', NULL, '&lt;p&gt;&lt;a href=&quot;about.html&quot;&gt;公司介绍&lt;/a&gt;&amp;nbsp;&lt;br /&gt;\r\n&lt;a href=&quot;about.html&quot;&gt;团队实力&lt;/a&gt;&amp;nbsp;&lt;br /&gt;\r\n&lt;a href=&quot;about.html&quot;&gt;企业文化&lt;/a&gt;&amp;nbsp;&lt;br /&gt;\r\n&lt;a href=&quot;contact.html&quot;&gt;联系我们&lt;/a&gt;&lt;/p&gt;', '', 'default_column', '2018-02-24'),
(938, 'bh2010079002demososo', 'column', 'common', 'vblock20180224_1442479840', NULL, 'colu20180224_1441431609', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##联系方式==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', NULL, '&lt;p&gt;公司地址：********&lt;br /&gt;\r\n联系人：****&lt;br /&gt;\r\n联系方式：*****&lt;/p&gt;', '', 'default_column', '2018-02-24'),
(939, 'bh2010079002demososo', 'column', 'common', 'vblock20180224_1442529390', NULL, 'colu20180224_1441527142', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##扫描二维码==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', NULL, '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20160410_100648_6599.jpg&quot; /&gt;&lt;/p&gt;', '', 'default_column', '2018-02-24'),
(940, 'bh2010079002demososo', 'column', 'common', 'vblock20180224_1446181736', NULL, 'colu20180224_1445595161', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##统计代码==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', NULL, '', '', 'default_column', '2018-02-24'),
(941, 'bh2010079002demososo', 'column', 'common', 'vblock20180224_1446303457', NULL, 'colu20180224_1445492913', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##==#==blockid:##==#==cssname:##==#==linktitle:##==#==linkurl:##', NULL, '&lt;p&gt;版权所有2019 DM企业建站系统&lt;/p&gt;', '', 'default_column', '2018-02-24'),
(942, 'bh2010079002demososo', 'column', 'common', 'vblock20180224_1446446892', NULL, 'colu20180224_1446114928', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##==#==blockid:##==#==cssname:##==#==linktitle:##==#==linkurl:##', NULL, '&lt;p&gt;&lt;a href=&quot;about.html&quot;&gt;关于我们 &lt;/a&gt; | &lt;a href=&quot;contact.html&quot;&gt;联系我们&lt;/a&gt; | &lt;a href=&quot;friendlinks.html&quot;&gt;友情链接&lt;/a&gt;&lt;/p&gt;', '', 'default_column', '2018-02-24'),
(969, 'bh2010079002demososo', 'column', 'common', 'vblock20180305_1058502928', NULL, 'colu20180305_1058499246', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##==#==blockid:##form20180218_1250127063==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', NULL, '', '', 'default_column', '2018-03-05'),
(970, 'bh2010079002demososo', 'column', 'common', 'vblock20180305_1059193986', NULL, 'colu20180305_1058373875', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##==#==blockid:##==#==cssname:##==#==linktitle:##==#==linkurl:##==#==blockimg:##', NULL, '&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;联系：&lt;/span&gt;&lt;a href=&quot;http://www.demososo.com/&quot; style=&quot;padding: 0px; margin: 0px; color: rgb(102, 102, 102); text-decoration: none;&quot; target=&quot;_blank&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;&lt;strong&gt;DM企业建站企业建站系统&lt;/strong&gt;&lt;/span&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:18px&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;网址：&lt;/span&gt;&lt;a href=&quot;http://www.demososo.com/&quot; style=&quot;padding: 0px; margin: 0px; color: rgb(102, 102, 102); text-decoration: none;&quot; target=&quot;_blank&quot;&gt;&lt;span style=&quot;color:#000000&quot;&gt;&lt;strong&gt;www.demososo.com&lt;/strong&gt;&lt;/span&gt;&lt;/a&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\n&lt;span style=&quot;color:#000000&quot;&gt;&lt;span style=&quot;font-size:18px&quot;&gt;手机：133 8888 8888&lt;br /&gt;\r\n电话：021-8888 8888 传真：021-8888 8888&lt;br /&gt;\r\n邮箱：***@163.com&lt;br /&gt;\r\n地址：上海市长宁区天山路**号&lt;br /&gt;\r\n电话：021-8888 8888&lt;br /&gt;\r\n传真：021-8888 8888&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;', '', 'default_column', '2018-03-05'),
(1492, 'bh2010079002demososo', 'bkcustom', 'style20171123_1856515884', 'vblock20181209_1109414403', NULL, 'none', 'block', 'cn', 'test', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '', '无文件', NULL),
(1499, 'bh2010079002demososo', 'bkblockdh', 'dmregionjc01', 'vblock20181209_1349005133', '', 'none', 'block', 'cn', 'ssd', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==maxline:##8==#==cus_columns:##3==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'rgbk_partner.php', NULL),
(1503, 'bh2010079002demososo', 'bkcustom', 'common', 'vblock20181221_1033067548', NULL, 'none', 'block', 'cn', '移动端底部', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;div class=&quot;footermobline&quot;&gt;&lt;/div&gt;\r\n&lt;div class=&quot;footermob&quot;&gt;\r\n&lt;ul&gt;\r\n		&lt;li&gt;&lt;a href=&quot;index.php&quot;&gt;&lt;i class=&quot;fa  fa-home&quot;&gt;&lt;/i&gt; &lt;p&gt;首页&lt;/p&gt;&lt;/a&gt;&lt;/li&gt;		\r\n		&lt;li&gt;&lt;a href=&quot;about.html&quot;&gt;&lt;i class=&quot;fa fa-address-book&quot;&gt;&lt;/i&gt;&lt;p&gt;关于&lt;/p&gt;&lt;/a&gt;&lt;/li&gt;\r\n		&lt;li&gt;&lt;a href=&quot;products.html&quot;&gt;&lt;i class=&quot;fa  fa-file&quot;&gt;&lt;/i&gt;&lt;p&gt;产品&lt;/p&gt;&lt;/a&gt;&lt;/li&gt;\r\n		&lt;li&gt;&lt;a href=&quot;contact.html&quot;&gt;&lt;i class=&quot;fa  fa-map-marker&quot;&gt;&lt;/i&gt;&lt;p&gt;联系&lt;/p&gt;&lt;/a&gt;&lt;/li&gt;\r\n       &lt;li&gt;&lt;a href=&quot;tel:13866666666&quot;&gt;&lt;i class=&quot;fa  fa-phone-square&quot;&gt;&lt;/i&gt;&lt;p&gt;电话&lt;/p&gt;&lt;/a&gt;&lt;/li&gt;\r\n&lt;/ul&gt;\r\n &lt;/div&gt;', 'default.tpl.php', NULL),
(1504, 'bh2010079002demososo', 'bknode', 'common', 'vblock20190102_1737179880', 'cate20150805_1133251007', 'none', 'block', 'cn', '多列新闻显示', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==maxline:##8==#==cus_columns:##4==#==cus_substrnum:##300==#==namefront:##==#==nodebtnmore:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'grid_z_cate_list.php', NULL),
(1506, 'bh2010079002demososo', 'bknode', 'common', 'vblock20190107_1052337558', 'cate20150805_1125344029', 'none', 'block', 'cn', '单列滚动的内容效果 - 产品', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==maxline:##8==#==cus_columns:##1==#==cus_substrnum:##300==#==namefront:##==#==nodebtnmore:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'slider_onenode.php', NULL),
(1507, 'bh2010079002demososo', 'column', NULL, 'vblock20190107_1053049409', NULL, 'colu20190107_1053021484', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##==#==blockid:##vblock20190107_1052337558==#==cssname:##==#==linktitle:##==#==linkurl:##', NULL, '', '', 'default_column', '2019-01-07'),
(1508, 'bh2010079002demososo', 'bknode', 'common', 'vblock20190107_1056503744', 'cate20150805_1125344029', 'none', 'block', 'cn', '侧边栏的推荐和最新', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==maxline:##4==#==cus_columns:##1==#==cus_substrnum:##30==#==namefront:##==#==nodebtnmore:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'sidebar_imgleft_tab.php', NULL),
(1509, 'bh2010079002demososo', 'column', NULL, 'vblock20190107_1115367865', NULL, 'colu20190107_1115348246', 'column', 'cn', 'namecolumn', 50, 'y', NULL, 'namefront:##==#==blockid:##vblock20190107_1056503744==#==cssname:##==#==linktitle:##==#==linkurl:##', NULL, '', '', 'default_column', '2019-01-07'),
(1513, 'bh2010079002demososo', 'bknode', 'common', 'vblock20190117_1103544735', 'cate20150805_1125344029', 'none', 'block', 'cn', '滚动的产品效果', 50, 'y', NULL, 'cssname:##sliderenable==#==cssstyle:##==#==maxline:##20==#==cus_columns:##4==#==cus_substrnum:##0==#==namefront:##==#==nodebtnmore:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', NULL, NULL, 'grid_ceng_jia.tpl.php', NULL),
(1515, 'bh2010079002demososo', 'bkcustom', 'dmregion_100', 'vblock20190311_1309287785', NULL, 'none', 'block', 'cn', '1slider', 500, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;div class=&quot;hero-slider&quot;&gt;\r\n            &lt;div class=&quot;single-slide&quot; style=&quot;background-image: url(imgpath_3qys0o_comcoolmbimg/100/slide1.jpg)&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;container&quot;&gt;\r\n                        &lt;div class=&quot;row&quot;&gt;\r\n                            &lt;div class=&quot;col-lg-6&quot;&gt;\r\n                                &lt;div class=&quot;slide-content&quot;&gt;\r\n                                    &lt;h2&gt;这是页面区域演示1111111111.&lt;/h2&gt;\r\n                                    &lt;p&gt;Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/p&gt;\r\n                                    &lt;div class=&quot;slide-btn&quot;&gt;\r\n                                        &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;Learn More&lt;/a&gt;\r\n                                        &lt;a href=&quot;#&quot; class=&quot;button-2&quot;&gt;Live Preview&lt;/a&gt;\r\n                                    &lt;/div&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n          \r\n		  \r\n		   &lt;div class=&quot;single-slide&quot; style=&quot;background-image: url(imgpath_3qys0o_comcoolmbimg/100/slide2.jpg)&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;container&quot;&gt;\r\n                        &lt;div class=&quot;row&quot;&gt;\r\n                            &lt;div class=&quot;col-lg-6&quot;&gt;\r\n                                &lt;div class=&quot;slide-content&quot;&gt;\r\n                                    &lt;h2&gt;这是页面区域演示22222222222.&lt;/h2&gt;\r\n                                    &lt;p&gt;Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/p&gt;\r\n                                    &lt;div class=&quot;slide-btn&quot;&gt;\r\n                                        &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;Learn More&lt;/a&gt;\r\n                                        &lt;a href=&quot;#&quot; class=&quot;button-2&quot;&gt;Live Preview&lt;/a&gt;\r\n                                    &lt;/div&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n			\r\n			 &lt;div class=&quot;single-slide&quot; style=&quot;background-image: url(imgpath_3qys0o_comcoolmbimg/100/slide3.jpg)&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;container&quot;&gt;\r\n                        &lt;div class=&quot;row&quot;&gt;\r\n                            &lt;div class=&quot;col-lg-6&quot;&gt;\r\n                                &lt;div class=&quot;slide-content&quot;&gt;\r\n                                    &lt;h2&gt;这是页面区域演示.3333333333&lt;/h2&gt;\r\n                                    &lt;p&gt;Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/p&gt;\r\n                                    &lt;div class=&quot;slide-btn&quot;&gt;\r\n                                        &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;Learn More&lt;/a&gt;\r\n                                        &lt;a href=&quot;#&quot; class=&quot;button-2&quot;&gt;Live Preview&lt;/a&gt;\r\n                                    &lt;/div&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;', 'default.tpl.php', NULL),
(1517, 'bh2010079002demososo', 'bkcustom', 'dmregion_100', 'vblock20190311_1309359510', NULL, 'none', 'block', 'cn', 'faq', 0, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;div class=&quot;faq-area ptb100 bg2&quot;&gt;\r\n    &lt;div class=&quot;container&quot;&gt;\r\n        &lt;div class=&quot;section-title&quot;&gt;\r\n            &lt;h2&gt;常见问题&lt;/h2&gt;\r\n            &lt;p&gt;这是副标题介绍。。。。如果没有，可以直接删除。。。。。。。。。。&lt;/p&gt;\r\n        &lt;/div&gt;\r\n        &lt;div class=&quot;row&quot;&gt;\r\n            &lt;div class=&quot;col-md-6&quot;&gt;\r\n                &lt;div class=&quot;faq&quot;&gt;\r\n                    &lt;div class=&quot;single-item&quot;&gt;\r\n                        &lt;h4&gt; 为什么使用DM企业建站系统？&lt;/h4&gt;\r\n                        &lt;div class=&quot;content&quot;&gt;\r\n                            为什么使用DM企业建站系统？。。。。。。为什么使用DM企业建站系统？。。。。。。为什么使用DM企业建站系统？。。。。。。\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;single-item&quot;&gt;\r\n                        &lt;h4&gt;php是什么语言？&lt;/h4&gt;\r\n                        &lt;div class=&quot;content&quot;&gt;\r\n                          php是什么语言？。。。。。。php是什么语言？。。。。。。php是什么语言？。。。。。。php是什么语言？。。。。。。\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;single-item&quot;&gt;\r\n                        &lt;h4&gt;react是什么框架？&lt;/h4&gt;\r\n                        &lt;div class=&quot;content&quot;&gt;\r\n                         react是什么框架？。。。。。。react是什么框架？。。。。。。react是什么框架？。。。。。。react是什么框架？。。。。。。\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;single-item&quot;&gt;\r\n                        &lt;h4&gt;你喜欢什么样的电影？&lt;/h4&gt;\r\n                        &lt;div class=&quot;content&quot;&gt;\r\n                             你喜欢什么样的电影？。。。。。。 你喜欢什么样的电影？。。。。。。 你喜欢什么样的电影？。。。。。。 你喜欢什么样的电影？。。。。。。\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;col-md-6&quot;&gt;\r\n                &lt;div class=&quot;faq-img text-center&quot;&gt;\r\n                    &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/faq.png&quot; alt=&quot;faq&quot;&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;', 'default.tpl.php', NULL),
(1518, 'bh2010079002demososo', 'bkcustom', 'dmregion_101', 'vblock20190311_1435253865', NULL, 'none', 'block', 'cn', '关于我们', 500, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;section class=&quot;flat-about style3 c mt80 mb100&quot;&gt;\r\n                 &lt;div class=&quot;container&quot;&gt;\r\n                    &lt;div class=&quot;row&quot;&gt;\r\n                        &lt;div class=&quot;col_2f3 fl&quot;&gt;\r\n                           &lt;div class=&quot;image-single&quot;&gt;\r\n                               &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/abt1.png&quot; alt=&quot;image&quot;&gt;\r\n                           &lt;/div&gt;\r\n                        &lt;/div&gt; &lt;!-- /col-lg-7 --&gt;\r\n                        &lt;div class=&quot;col_1f3 fl&quot;&gt;\r\n                            &lt;div class=&quot;flat-divider margin-top60px&quot;&gt;&lt;/div&gt;\r\n                            &lt;div class=&quot;flat-textbox&quot;&gt;\r\n                               \r\n                                &lt;h2 class=&quot;titleblock&quot;&gt;关于我们&lt;/h2&gt;\r\n                                 &lt;p&gt;葡萄酒品牌前十名-莅临人头马品牌网站,人头马酒庄誉满全球,三百年传统,只为酿造卓越干邑.人头马选取法国大,小香槟区的上乘葡萄酿造,凝聚了每一代酿酒大师卓越的专注和创新。。。葡萄酒品牌前十名-莅临人头马品牌网站,人头马酒庄誉满全球,三百年传统,只为酿造卓越干邑.人头马选取法国大,小香槟区的上乘葡萄酿造,凝聚了每一代酿酒大师卓越的专注和创新&lt;/p&gt;\r\n                            &lt;/div&gt; &lt;!-- /flat-textbox --&gt;\r\n                            &lt;div class=&quot;elm-btn&quot;&gt;\r\n                                   &lt;a href=&quot;#&quot; class=&quot;btnwine btnwineeff&quot;&gt;更多&lt;/a&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;&lt;!-- /col-lg-5 --&gt;\r\n                    &lt;/div&gt; &lt;!-- /row--&gt;\r\n                 &lt;/div&gt; &lt;!-- /container --&gt;  \r\n          &lt;/section&gt; &lt;!-- /flat-about --&gt;', 'default.tpl.php', NULL),
(1544, 'bh2010079002demososo', 'bkcustom', 'dmregion_101', 'vblock20190315_1721143463', NULL, 'none', 'block', 'cn', '新闻', 1, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;section class=&quot;flat-new-latest style2 c mb100&quot;&gt;\r\n        &lt;div class=&quot;container&quot;&gt;\r\n            &lt;div class=&quot;row&quot;&gt;\r\n                 \r\n                     &lt;div class=&quot;title-section&quot;&gt;\r\n                       \r\n                        &lt;h2 class=&quot;titleblock&quot;&gt; 新闻   &lt;/h2&gt;\r\n                        &lt;div class=&quot;our-product-image&quot;&gt;\r\n                             &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/cup.png&quot; alt=&quot;image&quot;&gt;\r\n                        &lt;/div&gt;\r\n                     &lt;/div&gt; &lt;!-- /title-section --&gt;\r\n               \r\n                 &lt;div class=&quot;line colhalf fl&quot;&gt;\r\n                    &lt;article class=&quot;post post-latest&quot;&gt;\r\n                        &lt;div class=&quot;featured-post&quot;&gt;\r\n                            &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/1.png&quot; alt=&quot;image&quot;&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;div class=&quot;content-post&quot;&gt;\r\n                            \r\n                            &lt;div class=&quot;post-title&quot;&gt;\r\n                                 &lt;h2&gt;&lt;a href=&quot;#&quot;&gt; 红酒什么牌子好国产红酒哪个牌子好喝? &lt;/a&gt;&lt;/h2&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;post-meta&quot;&gt;\r\n                                 &lt;span&gt;&lt;a href=&quot;#&quot;&gt;2018-06-05&lt;/a&gt;&lt;/span&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;post-content&quot;&gt;\r\n                                 &lt;span&gt;&lt;a href=&quot;#&quot;&gt; 红酒什么牌子好国产红酒哪个牌子好喝?红酒什么牌子好国产红酒哪个牌子好喝?...&lt;/a&gt;&lt;/span&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;post-submit&quot;&gt;\r\n                               &lt;a href=&quot;#&quot;&gt; READ MORE &lt;i class=&quot;fa fa-long-arrow-right&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/a&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/article&gt;\r\n                &lt;/div&gt; \r\n                &lt;div class=&quot;line colhalf fl&quot;&gt;\r\n                    &lt;article class=&quot;post post-latest&quot;&gt;\r\n                        &lt;div class=&quot;featured-post&quot;&gt;\r\n                            &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/2.png&quot; alt=&quot;image&quot;&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;div class=&quot;content-post&quot;&gt;\r\n                            \r\n                            &lt;div class=&quot;post-title&quot;&gt;\r\n                                 &lt;h2&gt;&lt;a href=&quot;#&quot;&gt; 红酒什么牌子好国产红酒哪个牌子好喝? &lt;/a&gt;&lt;/h2&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;post-meta&quot;&gt;\r\n                                &lt;span&gt;&lt;a href=&quot;#&quot;&gt;2018-06-05&lt;/a&gt;&lt;/span&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;post-content&quot;&gt;\r\n                                 &lt;span&gt;&lt;a href=&quot;#&quot;&gt;红酒什么牌子好国产红酒哪个牌子好喝?红酒什么牌子好国产红酒哪个牌子好喝?...&lt;/a&gt;&lt;/span&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;post-submit&quot;&gt;\r\n                                &lt;a href=&quot;#&quot;&gt; READ MORE &lt;i class=&quot;fa fa-long-arrow-right&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/a&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/article&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n    &lt;/section&gt;', 'default.tpl.php', NULL),
(1545, 'bh2010079002demososo', 'bkcustom', 'dmregion_101', 'vblock20190315_1721166380', NULL, 'none', 'block', 'cn', '红酒知识', 2, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;section class=&quot;flat-new-latest style3 c&quot;&gt;\r\n              &lt;div class=&quot;container&quot;&gt;\r\n                   &lt;div class=&quot;row&quot;&gt;\r\n                        \r\n                            &lt;div class=&quot;title-section&quot;&gt;                                \r\n                                &lt;h2 class=&quot;titleblock&quot;&gt;红酒知识&lt;/h2&gt;\r\n                                &lt;div class=&quot;our-product-image&quot;&gt;\r\n                                     &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/cup.png&quot; alt=&quot;image&quot;&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt; &lt;!-- /title-section --&gt;\r\n                        \r\n                       &lt;div class=&quot;col_1f3 &quot;&gt;\r\n                           \r\n                           &lt;div class=&quot;content-post&quot;&gt;\r\n                                \r\n                                &lt;div class=&quot;post-title&quot;&gt;\r\n                                     &lt;h2&gt;&lt;a href=&quot;#&quot;&gt; 红酒什么牌子好国产红酒哪个牌子好喝?&lt;/a&gt;&lt;/h2&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;post-meta&quot;&gt;\r\n                                      &lt;span&gt;&lt;a href=&quot;#&quot;&gt;2018-02-02 &lt;/a&gt;&lt;/span&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;post-submit&quot;&gt;\r\n                                   &lt;a href=&quot;#&quot;&gt; READ MORE &lt;i class=&quot;fa fa-long-arrow-right&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                       &lt;/div&gt;\r\n                        &lt;div class=&quot;col_1f3 &quot;&gt;\r\n                           &lt;div class=&quot;content-post&quot;&gt;\r\n                                 \r\n                                &lt;div class=&quot;post-title&quot;&gt;\r\n                                     &lt;h2&gt;&lt;a href=&quot;#&quot;&gt; 红酒什么牌子好国产红酒哪个牌子好喝? &lt;/a&gt;&lt;/h2&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;post-meta&quot;&gt;\r\n                                     &lt;span&gt;&lt;a href=&quot;#&quot;&gt;2018-02-02 &lt;/a&gt;&lt;/span&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;post-submit&quot;&gt;\r\n                                   &lt;a href=&quot;#&quot;&gt; READ MORE &lt;i class=&quot;fa fa-long-arrow-right&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                       &lt;/div&gt;\r\n                         &lt;div class=&quot;col_1f3 &quot;&gt;\r\n                           &lt;div class=&quot;content-post&quot;&gt;\r\n                               \r\n                                &lt;div class=&quot;post-title&quot;&gt;\r\n                                     &lt;h2&gt;&lt;a href=&quot;#&quot;&gt; 红酒什么牌子好国产红酒哪个牌子好喝? &lt;/a&gt;&lt;/h2&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;post-meta&quot;&gt;\r\n                                     &lt;span&gt;&lt;a href=&quot;#&quot;&gt;2018-02-02 &lt;/a&gt;&lt;/span&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;post-submit&quot;&gt;\r\n                                   &lt;a href=&quot;#&quot;&gt; READ MORE &lt;i class=&quot;fa fa-long-arrow-right&quot; aria-hidden=&quot;true&quot;&gt;&lt;/i&gt;&lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                       &lt;/div&gt;\r\n                   &lt;/div&gt;\r\n              &lt;/div&gt;\r\n          &lt;/section&gt;', 'default.tpl.php', NULL);
INSERT INTO `zzz_block` (`id`, `pbh`, `pid`, `pidstylebh`, `pidname`, `pidcate`, `pidcolumn`, `typecolumn`, `lang`, `name`, `pos`, `sta_visible`, `blockimg`, `blockcan`, `despjj`, `desp`, `desptext`, `template`, `dateday`) VALUES
(1519, 'bh2010079002demososo', 'bkcustom', 'dmregion_101', 'vblock20190311_1440565786', NULL, 'none', 'block', 'cn', '产品中心', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;section class=&quot;flat-products style3 c mb100&quot;&gt;\r\n        &lt;div class=&quot;container&quot;&gt;\r\n            &lt;div class=&quot;row&quot;&gt;\r\n                &lt;div class=&quot;col-lg-12&quot;&gt;\r\n                     &lt;div class=&quot;title-section&quot;&gt;\r\n                        \r\n                        &lt;h2 class=&quot;titleblock&quot;&gt;产品中心 &lt;/h2&gt;\r\n                        &lt;div class=&quot;our-product-image&quot;&gt;\r\n                             &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/cup.png&quot; alt=&quot;image&quot;&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt; &lt;!-- /title-section --&gt;\r\n                        \r\n						   &lt;div class=&quot;slider-style4&quot;&gt;\r\n       &lt;div class=&quot;container&quot;&gt;\r\n           &lt;div class=&quot;row&quot;&gt;\r\n               \r\n                   &lt;div class=&quot;flat-carousel-box data-effect clearfix&quot; data-gap=&quot;30&quot; data-column=&quot;4&quot; data-column2=&quot;2&quot; data-column3=&quot;1&quot; data-dots=&quot;false&quot; data-nav=&quot;true&quot;  data-auto=&quot;false&quot;&gt;\r\n                        &lt;div class=&quot;wineproslider slickarrow3&quot;&gt;                              \r\n                            &lt;div class=&quot;product-item style4&quot;&gt;\r\n                                &lt;div class=&quot;product-thumb clearfix&quot;&gt;\r\n                                    &lt;a href=&quot;#&quot; class=&quot;product-thumb&quot;&gt;\r\n                                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/p1.png&quot; alt=&quot;image&quot;&gt;\r\n                                    &lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;product-info text-center clearfix&quot;&gt;\r\n                                    &lt;span class=&quot;product-title&quot;&gt;葡萄酒名&lt;/span&gt;                                           \r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;\r\n                            &lt;div class=&quot;product-item style4&quot;&gt;\r\n                                &lt;div class=&quot;product-thumb clearfix&quot;&gt;\r\n                                    &lt;a href=&quot;#&quot; class=&quot;product-thumb&quot;&gt;\r\n                                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/p2.png&quot; alt=&quot;image&quot;&gt;\r\n                                    &lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;product-info text-center clearfix&quot;&gt;\r\n                                    &lt;span class=&quot;product-title&quot;&gt;葡萄酒名&lt;/span&gt;                                           \r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;     \r\n                            &lt;div class=&quot;product-item style4&quot;&gt;\r\n                                &lt;div class=&quot;product-thumb clearfix&quot;&gt;\r\n                                    &lt;a href=&quot;#&quot; class=&quot;product-thumb&quot;&gt;\r\n                                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/p3.png&quot; alt=&quot;image&quot;&gt;\r\n                                    &lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;product-info text-center clearfix&quot;&gt;\r\n                                    &lt;span class=&quot;product-title&quot;&gt;葡萄酒名&lt;/span&gt;                                           \r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;     \r\n                            &lt;div class=&quot;product-item style4&quot;&gt;\r\n                                &lt;div class=&quot;product-thumb clearfix&quot;&gt;\r\n                                    &lt;a href=&quot;#&quot; class=&quot;product-thumb&quot;&gt;\r\n                                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/p1.png&quot; alt=&quot;image&quot;&gt;\r\n                                    &lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;product-info text-center clearfix&quot;&gt;\r\n                                    &lt;span class=&quot;product-title&quot;&gt;葡萄酒名&lt;/span&gt;                                          \r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;     \r\n                            &lt;div class=&quot;product-item style4&quot;&gt;\r\n                                &lt;div class=&quot;product-thumb clearfix&quot;&gt;\r\n                                    &lt;a href=&quot;#&quot; class=&quot;product-thumb&quot;&gt;\r\n                                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/p2.png&quot; alt=&quot;image&quot;&gt;\r\n                                    &lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;product-info text-center clearfix&quot;&gt;\r\n                                    &lt;span class=&quot;product-title&quot;&gt;葡萄酒名&lt;/span&gt;\r\n                                                                               \r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;     \r\n                            &lt;div class=&quot;product-item style4&quot;&gt;\r\n                                &lt;div class=&quot;product-thumb clearfix&quot;&gt;\r\n                                    &lt;a href=&quot;#&quot; class=&quot;product-thumb&quot;&gt;\r\n                                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/p3.png&quot; alt=&quot;image&quot;&gt;\r\n                                    &lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;product-info text-center clearfix&quot;&gt;\r\n                                    &lt;span class=&quot;product-title&quot;&gt;葡萄酒名&lt;/span&gt;\r\n                                                                                \r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;     \r\n                            &lt;div class=&quot;product-item style4&quot;&gt;\r\n                                &lt;div class=&quot;product-thumb clearfix&quot;&gt;\r\n                                    &lt;a href=&quot;#&quot; class=&quot;product-thumb&quot;&gt;\r\n                                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/p1.png&quot; alt=&quot;image&quot;&gt;\r\n                                    &lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;product-info text-center clearfix&quot;&gt;\r\n                                    &lt;span class=&quot;product-title&quot;&gt;葡萄酒名&lt;/span&gt;\r\n                                                                                \r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;     \r\n                            &lt;div class=&quot;product-item style4&quot;&gt;\r\n                                &lt;div class=&quot;product-thumb clearfix&quot;&gt;\r\n                                    &lt;a href=&quot;#&quot; class=&quot;product-thumb&quot;&gt;\r\n                                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/p2.png&quot; alt=&quot;image&quot;&gt;\r\n                                    &lt;/a&gt;\r\n                                &lt;/div&gt;\r\n                                &lt;div class=&quot;product-info text-center clearfix&quot;&gt;\r\n                                    &lt;span class=&quot;product-title&quot;&gt;葡萄酒名&lt;/span&gt;\r\n                                                                              \r\n                                &lt;/div&gt;\r\n                            &lt;/div&gt;                             \r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                \r\n               &lt;div class=&quot;col-lg-1&quot;&gt;&lt;/div&gt;\r\n           &lt;/div&gt; &lt;!-- /row --&gt;\r\n       &lt;/div&gt; &lt;!-- /container --&gt;\r\n    &lt;/div&gt; &lt;!-- /slider-style4 --&gt; \r\n	\r\n   \r\n                        &lt;div class=&quot;elm-btn&quot;&gt;\r\n                           &lt;a href=&quot;#&quot; class=&quot;btnwine btnwineeff&quot;&gt;更多产品&lt;/a&gt;\r\n                        &lt;/div&gt;\r\n                &lt;/div&gt; &lt;!-- /col-lg-12 --&gt; \r\n            &lt;/div&gt; &lt;!-- /row --&gt; \r\n        &lt;/div&gt; &lt;!-- /container --&gt; \r\n    &lt;/section&gt; &lt;!-- /flat-products--&gt;', 'pro.php', NULL),
(1520, 'bh2010079002demososo', 'bkcustom', 'dmregion_101', 'vblock20190311_1441005310', NULL, 'none', 'block', 'cn', '迎来到我们的葡萄酒网站', 3, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;section class=&quot;flat-banner c mb100&quot;&gt;\r\n        &lt;div class=&quot;container&quot;&gt;\r\n            &lt;div class=&quot;row&quot;&gt;\r\n                &lt;div class=&quot;col-lg-12&quot;&gt;\r\n                    &lt;div class=&quot;title-section&quot;&gt;\r\n                        &lt;h2 class=&quot;titleblock titleblockbg1&quot;&gt;欢迎来到我们的葡萄酒网站&lt;/h2&gt;\r\n                        &lt;div class=&quot;our-product-image-background&quot;&gt;\r\n                             &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/101/cup2.png&quot; alt=&quot;image&quot;&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt; &lt;!-- /title-section --&gt;\r\n                    &lt;p class=&quot;banner-content&quot;&gt;&lt;a href=&quot;&quot;&gt;欢迎来到我们的葡萄酒网站欢迎来到我们的葡萄酒网站欢迎来到我们的葡萄酒网站&lt;/a&gt;&lt;/p&gt;\r\n                    &lt;div class=&quot;elm-btn&quot;&gt;\r\n                        &lt;a href=&quot;#&quot; class=&quot;btnwine btnwineeff&quot;&gt;查看更多&lt;/a&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt; &lt;!-- /row --&gt; \r\n        &lt;/div&gt; &lt;!-- /container --&gt;\r\n    &lt;/section&gt; &lt;!-- /flat-banner --&gt;', 'default.tpl.php', NULL),
(1540, 'bh2010079002demososo', 'bkcustom', 'dmregion_100', 'vblock20190315_1659395148', NULL, 'none', 'block', 'cn', '客户评价', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;!--客户评价--&gt;\r\n\r\n&lt;div class=&quot;testimonial-area ptb100 bg1&quot;&gt;\r\n    &lt;div class=&quot;container&quot;&gt;\r\n        &lt;div class=&quot;section-title white&quot;&gt;\r\n            &lt;h2&gt;客户评价&lt;/h2&gt;\r\n            &lt;p&gt;这是副标题介绍。。。。如果没有，可以直接删除。。。。。。。。。。&lt;/p&gt;\r\n        &lt;/div&gt;\r\n        &lt;div class=&quot;testimonial-slider&quot;&gt;\r\n            &lt;div class=&quot;single-slide&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;p&gt;在不远的将来，太阳急速衰老膨胀，地球面临被太阳吞没的灭顶之灾。为拯救地球，人类在地球表面建造了一万一千座行星发动机，以逃离太阳系寻找新的家园&lt;/p&gt;\r\n                    &lt;div class=&quot;client-info&quot;&gt;\r\n                        &lt;div class=&quot;client-img&quot;&gt;\r\n                            &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/client.jpg&quot; alt=&quot;client&quot;&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;div class=&quot;client-data&quot;&gt;\r\n                            &lt;h4&gt;导演&lt;/h4&gt;\r\n                            &lt;span&gt;郭帆&lt;/span&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;single-slide&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;p&gt;地球和人类就此踏上预计长达2500年的宇宙流浪之旅。在完成这一宏伟计划的进程中，无数人挺身而出上演了可歌可泣的传奇故事，九死一生的冒险和对人性的终极拷问也同时上演&lt;/p&gt;\r\n                    &lt;div class=&quot;client-info&quot;&gt;\r\n                        &lt;div class=&quot;client-img&quot;&gt;\r\n                            &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/client.jpg&quot; alt=&quot;client&quot;&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;div class=&quot;client-data&quot;&gt;\r\n                            &lt;h4&gt;主演&lt;/h4&gt;\r\n                            &lt;span&gt;吴京&lt;/span&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n\r\n            &lt;div class=&quot;single-slide&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;p&gt;在不远的将来，太阳急速衰老膨胀，地球面临被太阳吞没的灭顶之灾。为拯救地球，人类在地球表面建造了一万一千座行星发动机，以逃离太阳系寻找新的家园&lt;/p&gt;\r\n                    &lt;div class=&quot;client-info&quot;&gt;\r\n                        &lt;div class=&quot;client-img&quot;&gt;\r\n                            &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/client.jpg&quot; alt=&quot;client&quot;&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;div class=&quot;client-data&quot;&gt;\r\n                            &lt;h4&gt;导演&lt;/h4&gt;\r\n                            &lt;span&gt;郭帆&lt;/span&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;single-slide&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;p&gt;在不远的将来，太阳急速衰老膨胀，地球面临被太阳吞没的灭顶之灾。为拯救地球，人类在地球表面建造了一万一千座行星发动机，以逃离太阳系寻找新的家园&lt;/p&gt;\r\n                    &lt;div class=&quot;client-info&quot;&gt;\r\n                        &lt;div class=&quot;client-img&quot;&gt;\r\n                            &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/client.jpg&quot; alt=&quot;client&quot;&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;div class=&quot;client-data&quot;&gt;\r\n                            &lt;h4&gt;主演&lt;/h4&gt;\r\n                            &lt;span&gt;吴京&lt;/span&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;', 'default.tpl.php', NULL),
(1541, 'bh2010079002demososo', 'bkcustom', 'dmregion_100', 'vblock20190315_1700029881', NULL, 'none', 'block', 'cn', '最新案例', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '&lt;!--可用于最新案例 或 产品--&gt;\r\n&lt;div class=&quot;portfolio-area ptb100&quot;&gt;\r\n&lt;div class=&quot;container&quot;&gt;\r\n&lt;div class=&quot;section-title&quot;&gt;\r\n&lt;h2&gt;&amp;nbsp;&lt;/h2&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;\r\n&lt;/div&gt;', '&lt;!--可用于最新案例 或 产品--&gt;\r\n&lt;div class=&quot;portfolio-area ptb100&quot;&gt;\r\n    &lt;div class=&quot;container&quot;&gt;\r\n        &lt;div class=&quot;section-title&quot;&gt;\r\n            &lt;h2&gt;最新案例&lt;/h2&gt;\r\n            &lt;p&gt;这是副标题介绍。。。。如果没有，可以直接删除。。。。。。。。。。&lt;/p&gt;\r\n        &lt;/div&gt;\r\n        &lt;div class=&quot;row&quot;&gt;\r\n            &lt;div class=&quot;single-portfolio col-md-4&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;portfolio-img&quot;&gt;\r\n                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/portfolio1.jpg&quot; alt=&quot;portfolio-image&quot;&gt;\r\n                        &lt;div class=&quot;hover-content&quot;&gt;\r\n                            &lt;div&gt;\r\n                                &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;查看详情&gt;&lt;/a&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;portfolio-content&quot;&gt;\r\n                        &lt;a href=&quot;#&quot;&gt;&lt;h3&gt;这是标题。。。&lt;/h3&gt;&lt;/a&gt;\r\n                        \r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;single-portfolio col-md-4&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;portfolio-img&quot;&gt;\r\n                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/portfolio2.jpg&quot; alt=&quot;portfolio-image&quot;&gt;\r\n                        &lt;div class=&quot;hover-content&quot;&gt;\r\n                            &lt;div&gt;\r\n                                &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;查看详情&gt;&lt;/a&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;portfolio-content&quot;&gt;\r\n                        &lt;a href=&quot;#&quot;&gt;&lt;h3&gt;这是标题。。。&lt;/h3&gt;&lt;/a&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;single-portfolio col-md-4&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;portfolio-img&quot;&gt;\r\n                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/portfolio3.jpg&quot; alt=&quot;portfolio-image&quot;&gt;\r\n                        &lt;div class=&quot;hover-content&quot;&gt;\r\n                            &lt;div&gt;\r\n                                &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;查看详情&gt;&lt;/a&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;portfolio-content&quot;&gt;\r\n                       &lt;a href=&quot;#&quot;&gt;&lt;h3&gt;这是标题。。。&lt;/h3&gt;&lt;/a&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;single-portfolio col-md-4&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;portfolio-img&quot;&gt;\r\n                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/portfolio4.jpg&quot; alt=&quot;portfolio-image&quot;&gt;\r\n                        &lt;div class=&quot;hover-content&quot;&gt;\r\n                            &lt;div&gt;\r\n                                &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;查看详情&gt;&lt;/a&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;portfolio-content&quot;&gt;\r\n                       &lt;a href=&quot;#&quot;&gt;&lt;h3&gt;这是标题。。。&lt;/h3&gt;&lt;/a&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;single-portfolio col-md-4&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;portfolio-img&quot;&gt;\r\n                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/portfolio5.jpg&quot; alt=&quot;portfolio-image&quot;&gt;\r\n                        &lt;div class=&quot;hover-content&quot;&gt;\r\n                            &lt;div&gt;\r\n                                &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;查看详情&gt;&lt;/a&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;portfolio-content&quot;&gt;\r\n                       &lt;a href=&quot;#&quot;&gt;&lt;h3&gt;这是标题。。。&lt;/h3&gt;&lt;/a&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;single-portfolio col-md-4&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;portfolio-img&quot;&gt;\r\n                        &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/portfolio6.jpg&quot; alt=&quot;portfolio-image&quot;&gt;\r\n                        &lt;div class=&quot;hover-content&quot;&gt;\r\n                            &lt;div&gt;\r\n                                &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;查看详情&gt;&lt;/a&gt;\r\n                            &lt;/div&gt;\r\n                        &lt;/div&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;portfolio-content&quot;&gt;\r\n                       &lt;a href=&quot;#&quot;&gt;&lt;h3&gt;这是标题。。。&lt;/h3&gt;&lt;/a&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n        &lt;div class=&quot;row&quot;&gt;\r\n            &lt;div class=&quot;col-12 text-center&quot; data-margin=&quot;40px 0 0&quot;&gt;\r\n                &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;更多案例&lt;/a&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;', 'default.tpl.php', NULL),
(1542, 'bh2010079002demososo', 'bkcustom', 'dmregion_100', 'vblock20190315_1700241372', NULL, 'none', 'block', 'cn', '我们的服务', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;!--service--&gt;	\r\n		\r\n&lt;div class=&quot;service-area bg2 ptb100&quot;&gt;\r\n    &lt;div class=&quot;container&quot;&gt;\r\n        &lt;div class=&quot;section-title&quot;&gt;\r\n            &lt;h2&gt;我们的服务&lt;/h2&gt;\r\n            &lt;p&gt;这是副标题介绍。。。。如果没有，可以直接删除。。。。。。。。。。&lt;/p&gt;\r\n        &lt;/div&gt;\r\n        &lt;div class=&quot;row&quot;&gt;\r\n            &lt;div class=&quot;col-lg-4 col-md-6 single-service&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;title&quot;&gt;\r\n                        &lt;div class=&quot;icon&quot;&gt;\r\n                            &lt;i class=&quot;fa fa-film&quot;&gt;&lt;/i&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;h4&gt;这是标题&lt;/h4&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;content&quot;&gt;\r\n                        &lt;p&gt;写点什么内容。。。写点什么内容。。。写点什么内容。。。写点什么内容。。。&lt;/p&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;col-lg-4 col-md-6 single-service&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;title&quot;&gt;\r\n                        &lt;div class=&quot;icon&quot;&gt;\r\n                            &lt;i class=&quot;fa fa-camera&quot;&gt;&lt;/i&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;h4&gt;这是标题&lt;/h4&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;content&quot;&gt;\r\n                        &lt;p&gt;写点什么内容。。。写点什么内容。。。写点什么内容。。。写点什么内容。。。&lt;/p&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;col-lg-4 col-md-6 single-service&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;title&quot;&gt;\r\n                        &lt;div class=&quot;icon&quot;&gt;\r\n                            &lt;i class=&quot;fa fa-music&quot;&gt;&lt;/i&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;h4&gt;这是标题&lt;/h4&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;content&quot;&gt;\r\n                        &lt;p&gt;写点什么内容。。。写点什么内容。。。写点什么内容。。。写点什么内容。。。&lt;/p&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;col-lg-4 col-md-6 single-service&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;title&quot;&gt;\r\n                        &lt;div class=&quot;icon&quot;&gt;\r\n                            &lt;i class=&quot;fa fa-bullhorn&quot;&gt;&lt;/i&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;h4&gt;这是标题&lt;/h4&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;content&quot;&gt;\r\n                        &lt;p&gt;写点什么内容。。。写点什么内容。。。写点什么内容。。。写点什么内容。。。&lt;/p&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;col-lg-4 col-md-6 single-service&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;title&quot;&gt;\r\n                        &lt;div class=&quot;icon&quot;&gt;\r\n                            &lt;i class=&quot;fa fa-magic&quot;&gt;&lt;/i&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;h4&gt;这是标题&lt;/h4&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;content&quot;&gt;\r\n                        &lt;p&gt;写点什么内容。。。写点什么内容。。。写点什么内容。。。写点什么内容。。。&lt;/p&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;col-lg-4 col-md-6 single-service&quot;&gt;\r\n                &lt;div class=&quot;inner&quot;&gt;\r\n                    &lt;div class=&quot;title&quot;&gt;\r\n                        &lt;div class=&quot;icon&quot;&gt;\r\n                            &lt;i class=&quot;fa fa-bar-chart&quot;&gt;&lt;/i&gt;\r\n                        &lt;/div&gt;\r\n                        &lt;h4&gt;这是标题&lt;/h4&gt;\r\n                    &lt;/div&gt;\r\n                    &lt;div class=&quot;content&quot;&gt;\r\n                        &lt;p&gt;写点什么内容。。。写点什么内容。。。写点什么内容。。。写点什么内容。。。&lt;/p&gt;\r\n                    &lt;/div&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;', 'default.tpl.php', NULL),
(1543, 'bh2010079002demososo', 'bkcustom', 'dmregion_100', 'vblock20190315_1700334376', NULL, 'none', 'block', 'cn', '关于我们', 50, 'y', NULL, 'cssname:##==#==cssstyle:##==#==namefront:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', '&lt;div class=&quot;about-area pt100&quot;&gt;\r\n    &lt;div class=&quot;container&quot;&gt;\r\n        &lt;div class=&quot;row&quot;&gt;\r\n            &lt;div class=&quot;col-md-6&quot;&gt;\r\n                &lt;div class=&quot;about-content&quot;&gt;\r\n                    &lt;h3&gt;关于我们&lt;/h3&gt;\r\n                    &lt;p&gt;DM企业建站系统 www.demososo.com ...........DM企业建站系统 www.demososo.com ...........DM企业建站系统 www.demososo.com ...........DM企业建站系统 www.demososo.com ...........&lt;/p&gt;\r\n					&lt;p&gt;DM企业建站系统 www.demososo.com ...........DM企业建站系统 www.demososo.com ...........DM企业建站系统 www.demososo.com ...........DM企业建站系统 www.demososo.com ...........&lt;/p&gt;\r\n                    &lt;a href=&quot;#&quot; class=&quot;button&quot;&gt;查看更多&lt;/a&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n            &lt;div class=&quot;col-md-6&quot;&gt;\r\n                &lt;div class=&quot;about-img&quot;&gt;\r\n                    &lt;img src=&quot;imgpath_3qys0o_comcoolmbimg/100/about.png&quot; alt=&quot;&quot;&gt;\r\n                &lt;/div&gt;\r\n            &lt;/div&gt;\r\n        &lt;/div&gt;\r\n    &lt;/div&gt;\r\n&lt;/div&gt;', 'default.tpl.php', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_blockgroup`
--

CREATE TABLE `zzz_blockgroup` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `pbh` varchar(50) NOT NULL,
  `pidname` varchar(100) NOT NULL,
  `pidstylebh` varchar(80) NOT NULL DEFAULT 'n',
  `lang` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `namebz` varchar(100) DEFAULT NULL,
  `cssname` varchar(200) DEFAULT NULL,
  `sta_name` char(1) NOT NULL DEFAULT 'n',
  `pos` int(3) DEFAULT '50',
  `blockid` varchar(100) DEFAULT NULL,
  `dateedit` datetime DEFAULT NULL,
  `sta_visible` char(1) DEFAULT 'n',
  `sta_width_cnt` char(1) NOT NULL DEFAULT 'n' COMMENT 'for regcommon',
  `arr_cfg` text,
  `despjj` varchar(200) DEFAULT NULL,
  `desp` text,
  `desptext` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_blockgroup`
--

INSERT INTO `zzz_blockgroup` (`id`, `pid`, `pbh`, `pidname`, `pidstylebh`, `lang`, `name`, `namebz`, `cssname`, `sta_name`, `pos`, `blockid`, `dateedit`, `sta_visible`, `sta_width_cnt`, `arr_cfg`, `despjj`, `desp`, `desptext`) VALUES
(154, '0', 'bh2010079002demososo', 'group20160509_1200413359', 'style20160721_0855323118', 'cn', '网站最顶部一排的内容的文字内容', NULL, 'headertop pcshow', 'n', 520, NULL, '2016-05-09 12:00:41', 'n', 'n', NULL, NULL, NULL, NULL),
(444, 'group20160822_1126481127', 'bh2010079002demososo', 'sgroup20161019_1112358815', 'n', 'cn', '在线客服', NULL, '', 'n', 50, 'vblock20151202_1007031562', '2016-10-19 11:12:35', 'y', 'n', NULL, NULL, '', ''),
(561, '0', 'bh2010079002demososo', 'group20170921_1137442079', 'style20160721_0855323118', 'cn', '侧边栏', NULL, '', 'n', 50, NULL, '2017-09-21 11:37:44', 'n', 'y', NULL, NULL, NULL, NULL),
(557, '0', 'bh2010079002demososo', 'group20170920_1717255504', 'style20160721_0855323118', 'cn', '网站浮动部分---在线客服等悬浮代码 (它的列，要用绝对定位，这样不会占位置)', NULL, '', 'n', 50, NULL, '2017-09-20 17:17:25', 'n', 'y', NULL, NULL, NULL, NULL),
(569, '0', 'bh2010079002demososo', 'group20180303_1220043665', 'n', 'cn', '联系我们的组合区块', NULL, '', 'n', 50, NULL, '2018-03-03 12:20:04', 'n', 'n', NULL, NULL, NULL, NULL),
(620, '0', 'bh2010079002demososo', 'group20190107_1049375343', 'n', 'cn', '标签的侧边栏', NULL, '', 'n', 50, NULL, '2019-01-07 10:49:37', 'n', 'y', NULL, NULL, NULL, NULL),
(621, '0', 'bh2010079002demososo', 'group20190404_1205003166', 'n', 'cn', '网站底部内容', NULL, 'pt30', 'n', 50, NULL, '2019-04-04 12:05:00', 'n', 'n', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_cate`
--

CREATE TABLE `zzz_cate` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `ppid` varchar(100) NOT NULL DEFAULT '0',
  `pbh` varchar(50) NOT NULL,
  `pidname` varchar(50) NOT NULL,
  `pidstylebh` varchar(80) NOT NULL DEFAULT 'n',
  `lang` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `namebz` varchar(50) DEFAULT NULL,
  `sta_visible` varchar(1) NOT NULL DEFAULT 'y',
  `sta_noaccess` char(1) NOT NULL DEFAULT 'n',
  `sta_listcan_inherit` char(1) NOT NULL DEFAULT 'y',
  `pos` int(3) NOT NULL DEFAULT '50',
  `level` tinyint(2) DEFAULT NULL,
  `last` varchar(1) DEFAULT 'n',
  `alias` varchar(200) DEFAULT NULL,
  `alias_jump` varchar(100) DEFAULT NULL,
  `modtype` varchar(50) DEFAULT 'node',
  `arr_can` text,
  `list_can` text,
  `seo1` text,
  `seo2` text,
  `seo3` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_cate`
--

INSERT INTO `zzz_cate` (`id`, `pid`, `ppid`, `pbh`, `pidname`, `pidstylebh`, `lang`, `name`, `namebz`, `sta_visible`, `sta_noaccess`, `sta_listcan_inherit`, `pos`, `level`, `last`, `alias`, `alias_jump`, `modtype`, `arr_can`, `list_can`, `seo1`, `seo2`, `seo3`) VALUES
(1, '0', '', 'bh2010079002demososo', 'cate20150805_1125344029', 'n', 'cn', '产品中心', NULL, 'y', 'n', 'y', 69, 1, 'y', '添加主类', '', 'node', 'shop_price:##y==#==formblockid:##form20180223_1705033909==#==authorcate:##hide==#==authorcompanycate:##hide==#==authordatecate:##hide==#==authorhitcate:##hide==#==news_title:##==#==can_title:##规格(这文字可以后台改)==#==download_title:##==#==news_moretitle:##==#==sta_fontsize:##y==#==sta_sharebtn:##y==#==sta_tag:##y==#==nextprev:##nextprev.php==#==relativetitle:##相关产品==#==relativefg:##relative_text_nodate.php==#==relamaxline:##20==#==relapid:##y==#==cateofpagemenu:##smenu20181214_1231422774', 'sm_w:##300==#==sm_h:##300==#==template:##grid_ceng_kuo.tpl.php==#==cssname:##==#==maxline:##20==#==cus_columns:##3==#==cus_substrnum:##100==#==nodebtnmore:##==#==detailfg:##detail_leftright.php==#==albumfg:##album_shop_mobile.php==#==cus_columns_album:##2==#==musicfg:##music.php', 'asd', 'kk', 'ddd'),
(2, 'cate20150805_1125344029', 'cate20150805_1125344029', 'bh2010079002demososo', 'csub20150805_1127279495', 'n', 'cn', '平板电视', NULL, 'y', 'n', 'y', 55, 1, 'y', '', '', 'node', NULL, 'sta_listcan_inherit:##y==#==template:##grid_ceng_arrow.tpl.php==#==cssname:##==#==maxline:##20==#==cus_columns:##3==#==cus_substrnum:##30==#==nodebtnmore:##==#==detailfg:##detail_normal.php==#==albumfg:##album_fancybox.php==#==musicfg:##music.php', '平板电视平板电视ccdd', 'kkk平板电视平板电视dfdd', 'dddd平板电视平板电视平板电视aa'),
(3, 'cate20150805_1125344029', 'cate20150805_1125344029', 'bh2010079002demososo', 'csub20150805_1127356368', 'n', 'cn', '手机', NULL, 'y', 'n', 'y', 50, 1, 'n', '', '', 'node', NULL, 'sta_listcan_inherit:##y==#==template:##grid_ceng_arrow.tpl.php==#==cssname:##==#==maxline:##20==#==cus_columns:##3==#==cus_substrnum:##30==#==detailfg:##detail_normal.php', '', '', ''),
(4, 'cate20150805_1125344029', 'cate20150805_1125344029', 'bh2010079002demososo', 'csub20150805_1127429915', 'n', 'cn', '笔记本', NULL, 'y', 'n', 'y', 50, 1, 'y', '', '', 'node', NULL, NULL, '笔记本笔记本笔记本', '笔记本笔记本笔记本笔记本', '笔记本笔记本笔记本笔记本笔记本笔记本笔记本笔记本笔记本'),
(5, 'csub20150805_1127356368', 'cate20150805_1125344029', 'bh2010079002demososo', 'csub20150805_1128542682', 'n', 'cn', '华为', NULL, 'y', 'n', 'y', 0, 2, 'y', '', '', 'node', NULL, 'sta_listcan_inherit:##y==#==template:##grid_ceng_arrow.tpl.php==#==cssname:##==#==maxline:##20==#==cus_columns:##3==#==cus_substrnum:##30==#==nodebtnmore:##==#==detailfg:##detail_normal.php==#==albumfg:##album_fancybox.php==#==musicfg:##music.php', '华为华为dd', 'kkkk华为华为华为ads', 'dddd华为华为华为22aas'),
(6, 'csub20150805_1127356368', 'cate20150805_1125344029', 'bh2010079002demososo', 'csub20150805_1129022677', 'n', 'cn', '联想', NULL, 'y', 'n', 'y', 0, 2, 'y', '', '', 'node', NULL, NULL, '联想', '联想联想', '联想联想联想'),
(7, 'csub20150805_1127356368', 'cate20150805_1125344029', 'bh2010079002demososo', 'csub20150805_1129113039', 'n', 'cn', '其他', NULL, 'y', 'n', 'y', 0, 2, 'y', '', '', 'node', NULL, NULL, '其他其他', '其他其他', '其他其他其他'),
(8, '0', '', 'bh2010079002demososo', 'cate20150805_1133251007', 'n', 'cn', '新闻中心', NULL, 'y', 'n', 'y', 66, 1, 'y', '添加主类', '', 'node', 'shop_priceold:##hide==#==shop_price:##hide==#==shop_currency:##==#==shop_currencycn:##==#==shop_linktitle:##==#==formblockid:##form20180223_2133551842==#==authorcate:##hide==#==authorcompanycate:##hide==#==authordatecate:##hide==#==authorhitcate:##hide==#==news_title:##==#==can_title:##==#==download_title:##==#==news_moretitle:##==#==sta_fontsize:##y==#==sta_sharebtn:##y==#==sta_tag:##y==#==nextprev:##nextprev.php==#==relativetitle:##相关新闻==#==relativefg:##relative_text.php==#==relamaxline:##20==#==relapid:##y==#==cateofpagemenu:##', 'sm_w:##300==#==sm_h:##300==#==template:##list_textimg.php==#==cssname:##==#==maxline:##9==#==cus_columns:##3==#==cus_substrnum:##30==#==nodebtnmore:##==#==detailfg:##detail_normal.php', NULL, NULL, NULL),
(9, 'cate20150805_1133251007', 'cate20150805_1133251007', 'bh2010079002demososo', 'csub20150805_1133441588', 'n', 'cn', '公司新闻1', NULL, 'y', 'n', 'y', 50, 1, 'y', '', '', 'node', NULL, NULL, '', '', ''),
(10, 'cate20150805_1133251007', 'cate20150805_1133251007', 'bh2010079002demososo', 'csub20150805_1133512388', 'n', 'cn', '公司新闻2', NULL, 'y', 'n', 'y', 50, 1, 'y', '', '', 'node', NULL, NULL, '', '', ''),
(11, 'cate20150805_1133251007', 'cate20150805_1133251007', 'bh2010079002demososo', 'csub20150805_1133597884', 'n', 'cn', '公司新闻3', NULL, 'y', 'n', 'y', 50, 1, 'y', '', '', 'node', NULL, NULL, '', '', ''),
(37, '0', '', 'bh2010079002demososo', 'cate20160410_0658287350', 'n', 'cn', '视频中心', NULL, 'y', 'n', 'y', 50, 1, 'y', '添加主类', '', 'node', 'shop_priceold:##hide==#==shop_price:##hide==#==shop_currency:##==#==shop_currencycn:##==#==shop_linktitle:##==#==formblockid:##==#==authorcate:##hide==#==authorcompanycate:##hide==#==authordatecate:##hide==#==authorhitcate:##hide==#==news_title:##==#==news_moretitle:##==#==sta_fontsize:##y==#==sta_sharebtn:##y==#==sta_tag:##n==#==nextprev:##nextprev.php==#==relativetitle:##相关视频==#==relativefg:##relative_grid.php', 'sm_w:##300==#==sm_h:##300==#==template:##grid_node.tpl.php==#==cssname:##bgvideo==#==maxline:##9==#==cus_columns:##3==#==cus_substrnum:##==#==nodebtnmore:##==#==detailfg:##detail_normal.php', NULL, NULL, NULL),
(38, 'cate20160410_0658287350', 'cate20160410_0658287350', 'bh2010079002demososo', 'csub20160410_0658592970', 'n', 'cn', '视频分类1', NULL, 'y', 'n', 'y', 50, 1, 'y', '', '', 'node', NULL, NULL, '', '', ''),
(39, 'cate20160410_0658287350', 'cate20160410_0658287350', 'bh2010079002demososo', 'csub20160410_0659073489', 'n', 'cn', '视频分类2', NULL, 'y', 'n', 'y', 50, 1, 'y', '', '', 'node', NULL, NULL, '', '', ''),
(40, 'cate20150805_1133251007', 'cate20150805_1133251007', 'bh2010079002demososo', 'csub20160603_1044113807', 'n', 'cn', '公司新闻4', NULL, 'y', 'n', 'y', 50, 1, 'y', '', '', 'node', NULL, NULL, 'asdf', 'asdfasd', 'asdf'),
(54, '0', '', 'bh2010079002demososo', 'cate20160707_0437114782', 'n', 'cn', '效果区块管理', NULL, 'y', 'y', 'y', 50, 1, 'y', '添加主类', '', 'blockdh', NULL, NULL, NULL, NULL, NULL),
(58, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20160707_0905038793', 'style20180224_1720347037', 'cn', '蓝色企业幻灯片', NULL, 'y', 'n', 'y', 555, 2, 'y', NULL, '', 'blockdh', NULL, NULL, NULL, NULL, NULL),
(65, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20160707_0914597182', 'y', 'cn', '800px的幻灯片，可用于移动端', NULL, 'y', 'n', 'y', 555, 2, 'y', NULL, NULL, 'blockdh', NULL, NULL, NULL, NULL, NULL),
(67, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20160707_1140595619', 'y', 'cn', 'tab切换内容-我们的服务 - 2', NULL, 'y', 'n', 'y', 150, 2, 'y', NULL, '', 'blockdh', NULL, NULL, NULL, NULL, NULL),
(68, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20160708_0508436425', 'y', 'cn', '客户评价', NULL, 'y', 'n', 'y', 135, 1, 'y', NULL, NULL, 'blockdh', NULL, NULL, NULL, NULL, NULL),
(69, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20160708_0508536755', 'y', 'cn', '我们的服务-2列（小图标）', NULL, 'y', 'n', 'y', 149, 1, 'y', NULL, '', 'blockdh', NULL, NULL, NULL, NULL, NULL),
(70, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20160708_0509074359', 'y', 'cn', '我们的客户', NULL, 'y', 'n', 'y', 50, 1, 'y', NULL, NULL, 'blockdh', NULL, NULL, NULL, NULL, NULL),
(72, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20160708_0511229047', 'y', 'cn', '为什么选择我们', NULL, 'y', 'n', 'y', 50, 1, 'y', NULL, NULL, 'blockdh', NULL, NULL, NULL, NULL, NULL),
(116, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20170214_1756444189', 'y', 'cn', '关于我们', NULL, 'y', 'n', 'y', 155, 1, 'y', NULL, NULL, 'blockdh', NULL, NULL, NULL, NULL, NULL),
(140, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20170426_1859253747', 'style20180224_1720347037', 'cn', '全屏幻灯片 fullscreen default03', NULL, 'y', 'n', 'y', 500, 1, 'y', NULL, NULL, 'blockdh', NULL, NULL, NULL, NULL, NULL),
(183, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20171212_1153095561', 'y', 'cn', 'water01模板的幻灯片', NULL, 'y', 'n', 'y', 555, 1, 'y', NULL, NULL, 'blockdh', NULL, NULL, NULL, NULL, NULL),
(177, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20171207_1040119631', 'style20180224_1720347037', 'cn', '关于我们的内容--strip', NULL, 'y', 'n', 'y', 50, 1, 'y', NULL, NULL, 'blockdh', NULL, NULL, NULL, NULL, NULL),
(178, 'cate20160707_0437114782', '', 'bh2010079002demososo', 'csub20171207_1040184257', 'style20180224_1720347037', 'cn', '我们的服务--多列', NULL, 'y', 'n', 'y', 50, 1, 'y', NULL, NULL, 'blockdh', NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_column`
--

CREATE TABLE `zzz_column` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL DEFAULT '0',
  `pidname` varchar(100) NOT NULL,
  `pbh` varchar(50) NOT NULL DEFAULT 'n',
  `type` varchar(50) DEFAULT NULL COMMENT 'region or page or group',
  `lang` varchar(50) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `cssname` varchar(50) DEFAULT NULL,
  `sta_visible` varchar(1) NOT NULL DEFAULT 'y',
  `pos` int(3) DEFAULT '50',
  `kv` varchar(100) DEFAULT NULL,
  `kvtitle` varchar(200) DEFAULT NULL,
  `desp` text,
  `desptext` text,
  `arr_can` text,
  `width` varchar(20) DEFAULT NULL,
  `floattype` varchar(20) DEFAULT NULL,
  `onlyposi` char(1) DEFAULT 'n' COMMENT 'no content ,only position'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_column`
--

INSERT INTO `zzz_column` (`id`, `pid`, `pidname`, `pbh`, `type`, `lang`, `name`, `cssname`, `sta_visible`, `pos`, `kv`, `kvtitle`, `desp`, `desptext`, `arr_can`, `width`, `floattype`, `onlyposi`) VALUES
(38, 'group20160509_1200413359', 'colu20170914_1755237816', 'bh2010079002demososo', 'group', 'cn', '标题', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'col_3f5', 'fl', 'n'),
(37, 'group20160509_1200413359', 'colu20170914_1755204518', 'bh2010079002demososo', 'group', 'cn', '标题', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'col_2f5', 'fl', 'n'),
(44, 'group20170920_1717255504', 'colu20170920_1717466496', 'bh2010079002demososo', 'group', 'cn', '返回顶部', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'poa', 'n'),
(45, 'group20170920_1717255504', 'colu20170920_1718203997', 'bh2010079002demososo', 'group', 'cn', '网站模板演示', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'poa', 'n'),
(57, 'group20170921_1137442079', 'colu20170921_1138225871', 'bh2010079002demososo', 'group', 'cn', '联系我们', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'fl', 'n'),
(58, 'group20170921_1137442079', 'colu20170921_1138331265', 'bh2010079002demososo', 'group', 'cn', 'DM视频教程', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'fl', 'n'),
(59, 'group20170921_1137442079', 'colu20170921_1138459407', 'bh2010079002demososo', 'group', 'cn', '标签', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'fl', 'n'),
(60, 'group20170921_1137442079', 'colu20170921_1138528459', 'bh2010079002demososo', 'group', 'cn', '侧边栏的新闻', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'fl', 'n'),
(75, 'group20170920_1717255504', 'colu20171012_0857027802', 'bh2010079002demososo', 'group', 'cn', '在线咨询', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'poa', 'n'),
(84, 'group20190404_1205003166 ', 'colu20180224_1441239930', 'bh2010079002demososo', 'group', 'cn', '关于我们', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'col_1f4', 'fl', 'n'),
(85, 'group20190404_1205003166 ', 'colu20180224_1441348425', 'bh2010079002demososo', 'group', 'cn', '公司', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'col_1f4', 'fl', 'n'),
(86, 'group20190404_1205003166 ', 'colu20180224_1441431609', 'bh2010079002demososo', 'group', 'cn', '联系方式', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'col_1f4', 'fl', 'n'),
(87, 'group20190404_1205003166 ', 'colu20180224_1441527142', 'bh2010079002demososo', 'group', 'cn', '扫描二维码', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'col_1f4', 'fl', 'n'),
(88, 'group20190404_1205003166 ', 'colu20180224_1445492913', 'bh2010079002demososo', 'group', 'cn', '版权信息', NULL, 'y', 33, NULL, NULL, NULL, NULL, NULL, 'col_2f5', 'fl', 'n'),
(89, 'group20190404_1205003166 ', 'colu20180224_1445595161', 'bh2010079002demososo', 'group', 'cn', '统计代码', NULL, 'n', 33, NULL, NULL, NULL, NULL, NULL, 'col_1f5', 'fl', 'n'),
(90, 'group20190404_1205003166 ', 'colu20180224_1446114928', 'bh2010079002demososo', 'group', 'cn', '一些链接', NULL, 'y', 33, NULL, NULL, NULL, NULL, NULL, 'col_2f5', 'fl', 'n'),
(91, 'group20180303_1220043665', 'colu20180305_1058373875', 'bh2010079002demososo', 'group', 'cn', '文字', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'col_2f5', 'fl', 'n'),
(92, 'group20180303_1220043665', 'colu20180305_1058499246', 'bh2010079002demososo', 'group', 'cn', '表单', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'col_3f5', 'fl', 'n'),
(344, 'group20190107_1049375343', 'colu20190107_1053021484', 'bh2010079002demososo', 'group', 'cn', '单列滚动', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'fl', 'n'),
(345, 'group20190107_1049375343', 'colu20190107_1115348246', 'bh2010079002demososo', 'group', 'cn', '推荐和最新', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'fl', 'n'),
(351, 'group20190404_1205003166', 'colu20190404_1206479940', 'bh2010079002demososo', 'group', 'cn', 'clear', NULL, 'y', 50, NULL, NULL, NULL, NULL, NULL, 'colfull', 'clear', 'y');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_comment`
--

CREATE TABLE `zzz_comment` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL DEFAULT '0',
  `pidname` varchar(100) NOT NULL,
  `nodepidname` varchar(99) DEFAULT NULL,
  `pbh` varchar(50) NOT NULL DEFAULT 'n',
  `lang` varchar(50) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `sta_visible` varchar(1) NOT NULL DEFAULT 'y',
  `type` varchar(50) NOT NULL DEFAULT 'page' COMMENT 'page or contact or product or ordernow',
  `sta_noaccess` char(1) NOT NULL DEFAULT 'n',
  `pos` int(3) DEFAULT '50',
  `tokenhour` varchar(50) DEFAULT NULL,
  `desp` text,
  `ip` varchar(50) DEFAULT NULL,
  `dateday` date DEFAULT NULL,
  `dateedit` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_comment`
--

INSERT INTO `zzz_comment` (`id`, `pid`, `pidname`, `nodepidname`, `pbh`, `lang`, `name`, `sta_visible`, `type`, `sta_noaccess`, `pos`, `tokenhour`, `desp`, `ip`, `dateday`, `dateedit`) VALUES
(256, 'form20180223_2133551842', 'comm20181219_1746233035', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181219_17', '表单标题：新闻留言&lt;br /&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/detail-72.html&lt;br /&gt;*昵称：asdfasfd&lt;br /&gt;*内容：asdf&lt;br /&gt;', '127.0.0.1', '2018-12-19', '2018-12-19 17:46:23'),
(257, 'form20180223_2133551842', 'comm20181219_1746285399', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181219_17', '表单标题：新闻留言&lt;br /&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/detail-72.html&lt;br /&gt;*昵称：asdfas&lt;br /&gt;内容：fasfdas&lt;br /&gt;', '127.0.0.1', '2018-12-19', '2018-12-19 17:46:28'),
(258, 'form20180223_2133551842', 'comm20181219_1747242692', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181219_17', '表单标题：新闻留言&lt;br /&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/detail-72.html&lt;br /&gt;*昵称：2222&lt;br /&gt;内容：&lt;br /&gt;', '127.0.0.1', '2018-12-19', '2018-12-19 17:47:24'),
(259, 'form20180223_2133551842', 'comm20181219_1751115598', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181219_17', '表单标题：新闻留言&lt;br /&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/detail-72.html&lt;br /&gt;*昵称：dqweqweq&lt;br /&gt;内容：&lt;br /&gt;', '127.0.0.1', '2018-12-19', '2018-12-19 17:51:11'),
(260, 'form20180218_1250127063', 'comm20181219_1826139764', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181219_18', '表单标题：联系我们的表单&lt;br /&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/detail-72.html&lt;br /&gt;*昵称：asfdasdf&lt;br /&gt;内容：sdf&lt;br /&gt;', '127.0.0.1', '2018-12-19', '2018-12-19 18:26:13'),
(261, 'form20180218_1250127063', 'comm20181219_1826331278', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181219_18', '表单标题：联系我们的表单&lt;br /&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/detail-72.html&lt;br /&gt;*昵称：asdf&lt;br /&gt;内容：asdfasdf&lt;br /&gt;', '127.0.0.1', '2018-12-19', '2018-12-19 18:26:33'),
(262, 'form20180223_2133551842', 'comm20181220_1024359527', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181220_10', '表单标题：新闻留言&lt;br /&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/detail-72.html&lt;br /&gt;*昵称：asdfasd&lt;br /&gt;*内容：adfasdf&lt;br /&gt;', '127.0.0.1', '2018-12-20', '2018-12-20 10:24:35'),
(263, '', 'comm20181220_1031343837', '', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, '', '', '127.0.0.1', '2018-12-20', '2018-12-20 10:31:34'),
(264, 'form20180218_1250127063', 'comm20181220_1036146329', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181220_10', '表单标题：联系我们的表单&lt;br /&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/detail-72.html&lt;br /&gt;名称：张三&lt;br&gt;内容: 请问如何定制DM表单？。。。。。等等其他内容。。。。。', '127.0.0.1', '2018-12-20', '2018-12-20 10:36:14'),
(265, 'form20180218_1250127063', 'comm20181220_1040403102', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181220_10', '表单标题：联系我们的表单&lt;br /&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/detail-72.html&lt;br /&gt;名称：张三&lt;br&gt;内容: 请问如何定制DM表单？。。。。。等等其他内容。。。。。', '127.0.0.1', '2018-12-20', '2018-12-20 10:40:40'),
(266, 'form20180218_1250127063', 'comm20181220_1041045867', 'page20150806_0436437668', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181220_10', '表单标题：联系我们的表单&lt;br /&gt;来自：联系我们 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/contact.html&lt;br /&gt;名称：张三&lt;br&gt;内容: 请问如何定制DM表单？。。。。。等等其他内容。。。。。', '127.0.0.1', '2018-12-20', '2018-12-20 10:41:04'),
(267, 'form20180218_1250127063', 'comm20181220_1451154996', 'page20150806_0436437668', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181220_14', '表单标题：联系我们的表单&lt;br /&gt;来自：联系我们 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/contact.html&lt;br /&gt;名称：张三&lt;br&gt;内容: 请问如何定制DM表单？。。。。。等等其他内容。。。。。', '127.0.0.1', '2018-12-20', '2018-12-20 14:51:15'),
(268, 'form20180223_2133551842', 'comm20181221_1055433408', 'node20160406_0930259685', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20181221_10', '表单标题：新闻留言&lt;br ===-&gt;来自：男篮热身计划：5月VS澳洲6月战马其顿7月赴美 - http===-===-===-127.0.0.22===-8080===-dev2018===-dm-opencodestatic===-detail-72.html&lt;br ===-&gt;*昵称：asdfasd&lt;br ===-&gt;*内容：asf&lt;br ===-&gt;', '127.0.0.1', '2018-12-21', '2018-12-21 10:55:43'),
(269, 'form20180218_1250127063', 'comm20190107_1043099956', 'page20150806_0436437668', 'bh2010079002demososo', 'cn', NULL, 'y', 'formblock', 'n', 50, 'inq_20190107_10', '表单标题：联系我们的表单&lt;br /&gt;来自：联系我们 - http://127.0.0.22:8080/dev2018/dm-opencodestatic/contact.html&lt;br /&gt;*昵称：地asdf&lt;br /&gt;*电子邮箱：asdfasf@asdfj.com&lt;br /&gt;*手机：13566666666&lt;br /&gt;内容：asdfas&lt;br /&gt;', '127.0.0.1', '2019-01-07', '2019-01-07 10:43:09');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_field`
--

CREATE TABLE `zzz_field` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `pbh` varchar(50) DEFAULT NULL,
  `pidname` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `namefront` varchar(66) DEFAULT NULL,
  `sta_visible` char(1) NOT NULL DEFAULT 'y',
  `sta_must` char(1) NOT NULL DEFAULT 'n',
  `pos` int(3) NOT NULL DEFAULT '50',
  `typeinput` varchar(20) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'cate' COMMENT 'cate or other',
  `effect` varchar(100) DEFAULT NULL,
  `cssname` varchar(50) DEFAULT NULL,
  `error` varchar(20) NOT NULL DEFAULT 'error1',
  `cusfields` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_field`
--

INSERT INTO `zzz_field` (`id`, `pid`, `pbh`, `pidname`, `lang`, `name`, `namefront`, `sta_visible`, `sta_must`, `pos`, `typeinput`, `type`, `effect`, `cssname`, `error`, `cusfields`) VALUES
(43, 'block', 'bh2010079002demososo', 'form20180218_1250088582', 'cn', '表单测试', '表单测试', 'y', 'n', 50, NULL, 'block', 'form.php', '', 'error1', NULL),
(44, 'block', 'bh2010079002demososo', 'form20180218_1250127063', 'cn', '联系我们的表单', '', 'y', 'n', 50, NULL, 'block', 'form.php', '', 'error1', ''),
(48, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180218_1355397966', 'cn', 'radio', NULL, 'y', 'n', 50, 'radio', '', NULL, '', 'error1', NULL),
(46, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180218_1321499097', 'cn', 'select', NULL, 'y', 'n', 50, 'select', '', NULL, '', 'error1', NULL),
(47, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180218_1321599780', 'cn', '姓名', NULL, 'y', 'n', 502, 'text', '', NULL, '', 'error1', NULL),
(49, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180218_1355485286', 'cn', 'checkbox', NULL, 'y', 'n', 50, 'checkbox', '', NULL, '', 'error1', NULL),
(52, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180222_1457247151', 'cn', 'email', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error3', NULL),
(53, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180222_1457411819', 'cn', '手机', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error2', NULL),
(54, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180222_1457521078', 'cn', '年龄', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error4', NULL),
(55, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180222_1636575014', 'cn', '爱好', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error0', NULL),
(56, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180223_1208582851', 'cn', '不能为空', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error1', NULL),
(57, 'form20180218_1250088582', 'bh2010079002demososo', 'field20180223_1434207038', 'cn', '内容', NULL, 'y', 'n', 50, 'textarea', '', NULL, '', 'error0', NULL),
(58, 'form20180218_1250127063', 'bh2010079002demososo', 'field20180223_1654098888', 'cn', '昵称', NULL, 'y', 'n', 50, 'text', '', NULL, 'c', 'error1', NULL),
(59, 'form20180218_1250127063', 'bh2010079002demososo', 'field20180223_1656069986', 'cn', '电子邮箱', NULL, 'y', 'n', 50, 'text', '', NULL, 'c', 'error3', NULL),
(60, 'form20180218_1250127063', 'bh2010079002demososo', 'field20180223_1656189548', 'cn', '手机', NULL, 'y', 'n', 50, 'text', '', NULL, 'c', 'error2', NULL),
(61, 'form20180218_1250127063', 'bh2010079002demososo', 'field20180223_1656299551', 'cn', '内容', NULL, 'y', 'n', 50, 'textarea', '', NULL, '', 'error0', NULL),
(62, 'block', 'bh2010079002demososo', 'form20180223_1705033909', 'cn', '产品的表单', '立即下单', 'y', 'n', 50, NULL, 'block', 'form.php', 'productform', 'error1', NULL),
(63, 'form20180223_1705033909', 'bh2010079002demososo', 'field20180223_1713059257', 'cn', '订单数量', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error4', NULL),
(64, 'form20180223_1705033909', 'bh2010079002demososo', 'field20180223_1713181470', 'cn', '客户姓名', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error1', NULL),
(65, 'form20180223_1705033909', 'bh2010079002demososo', 'field20180223_1713351093', 'cn', '电子邮箱', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error3', NULL),
(66, 'form20180223_1705033909', 'bh2010079002demososo', 'field20180223_1713449328', 'cn', '手机', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error2', NULL),
(67, 'form20180223_1705033909', 'bh2010079002demososo', 'field20180223_1714153195', 'cn', '详细地址', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error1', NULL),
(68, 'form20180223_1705033909', 'bh2010079002demososo', 'field20180223_1714279503', 'cn', '客户留言', NULL, 'y', 'n', 50, 'textarea', '', NULL, '', 'error1', NULL),
(69, 'block', 'bh2010079002demososo', 'form20180223_2133551842', 'cn', '新闻留言', '新闻留言', 'y', 'n', 50, NULL, 'block', 'form.php', '', 'error1', 'self_form_1.php'),
(70, 'form20180223_2133551842', 'bh2010079002demososo', 'field20180223_2134082500', 'cn', '昵称', NULL, 'y', 'n', 50, 'text', '', NULL, '', 'error1', NULL),
(71, 'form20180223_2133551842', 'bh2010079002demososo', 'field20180223_2134208108', 'cn', '内容', NULL, 'y', 'n', 50, 'textarea', '', NULL, '', 'error1', NULL),
(162, 'block', 'bh2010079002demososo', 'form20180820_1536319421', 'cn', '自定义表单', '前台标题', 'y', 'n', 50, NULL, 'block', 'form.php', '', 'error1', 'dmregionjc02/form/formjc02.php'),
(180, 'block', 'bh2010079002demososo', 'form20181219_1242524532', 'cn', 'sdfasf', 'asdf', 'y', 'n', 50, NULL, 'block', 'form.php', 'asdf', 'error1', NULL),
(181, 'block', 'bh2010079002demososo', 'form20181219_1421366828', 'cn', 'afWQD', 'asdf', 'y', 'n', 50, NULL, 'block', 'form.php', 'asdf', 'error1', NULL),
(182, 'form20181219_1421366828', 'bh2010079002demososo', 'field20190227_1754457370', 'cn', '基本原则顶戴', NULL, 'y', 'n', 50, 'text', '', NULL, 'asfasdf', 'error0', NULL),
(183, 'form20181219_1421366828', 'bh2010079002demososo', 'field20190227_1754539869', 'cn', 'asdf', NULL, 'y', 'n', 50, 'select', '', NULL, 'asd', 'error0', NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_fieldoption`
--

CREATE TABLE `zzz_fieldoption` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `pbh` varchar(50) DEFAULT NULL,
  `pidname` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `sta_visible` char(1) NOT NULL DEFAULT 'y',
  `pos` int(3) NOT NULL DEFAULT '50'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_fieldoption`
--

INSERT INTO `zzz_fieldoption` (`id`, `pid`, `pbh`, `pidname`, `lang`, `name`, `sta_visible`, `pos`) VALUES
(90, 'field20180218_1355485286', 'bh2010079002demososo', 'fieopt20180820_1551336315', 'cn', 'small', 'y', 50),
(89, 'field20180218_1355485286', 'bh2010079002demososo', 'fieopt20180820_1551282454', 'cn', 'large', 'y', 50),
(88, 'field20180218_1355397966', 'bh2010079002demososo', 'fieopt20180820_1551194815', 'cn', 'male', 'y', 50),
(87, 'field20180218_1355397966', 'bh2010079002demososo', 'fieopt20180820_1551163651', 'cn', 'female', 'y', 50),
(86, 'field20180218_1321499097', 'bh2010079002demososo', 'fieopt20180820_1551012666', 'cn', 'blue', 'y', 50),
(85, 'field20180218_1321499097', 'bh2010079002demososo', 'fieopt20180820_1550587145', 'cn', 'red', 'y', 50),
(84, 'field20180218_1321499097', 'bh2010079002demososo', 'fieopt20180820_1550564262', 'cn', 'black', 'y', 50),
(91, 'field20190227_1754539869', 'bh2010079002demososo', 'fieopt20190227_1755365103', 'cn', 'aaa', 'n', 50),
(92, 'field20190227_1754539869', 'bh2010079002demososo', 'fieopt20190227_1755435374', 'cn', 'bbb', 'n', 50),
(93, 'field20190227_1754539869', 'bh2010079002demososo', 'fieopt20190227_1757195940', 'cn', 'ccc', 'y', 50);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_fieldvalue`
--

CREATE TABLE `zzz_fieldvalue` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL COMMENT 'pid-field',
  `pidnode` varchar(50) NOT NULL,
  `pbh` varchar(50) DEFAULT NULL,
  `lang` varchar(50) NOT NULL,
  `value` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `zzz_imgfj`
--

CREATE TABLE `zzz_imgfj` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `pidname` varchar(100) DEFAULT NULL,
  `pbh` varchar(50) NOT NULL,
  `pidstylebh` varchar(90) NOT NULL DEFAULT 'y',
  `lang` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `kv` varchar(50) DEFAULT NULL,
  `kvlink` varchar(250) DEFAULT NULL,
  `size` int(12) DEFAULT NULL,
  `pos` int(3) NOT NULL DEFAULT '50' COMMENT 'need,for some func to order by pos desc',
  `dateedit` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_imgfj`
--

INSERT INTO `zzz_imgfj` (`id`, `pid`, `pidname`, `pbh`, `pidstylebh`, `lang`, `title`, `kv`, `kvlink`, `size`, `pos`, `dateedit`) VALUES
(1, 'page20150805_1138522811', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20150805_113942_1804.jpg', NULL, 15028, 50, '2015-08-05 11:39:42'),
(3, 'page20150805_1143268522', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20150805_114410_5513.jpg', NULL, 22391, 50, '2015-08-05 11:44:10'),
(60, 'common', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160410_101019_8098.png', NULL, 950, 50, '2016-04-10 10:10:19'),
(65, 'common', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160510_100152_4288.jpg', NULL, 7577, 50, '2016-05-10 10:01:52'),
(9, 'block20150803_0638326914', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20150806_102334_9252.jpg', NULL, 9085, 50, '2015-08-06 10:23:34'),
(189, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20150806_103634_1001.jpg', NULL, 37363, 50, '2018-03-16 10:23:52'),
(40, 'group_i20151202_1006575766', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20151215_113456_4458.jpg', NULL, 21304, 50, '2015-12-15 11:34:56'),
(188, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20180315_183804_8641.jpg', NULL, 30641, 50, '2018-03-15 18:38:04'),
(39, 'group_i20151202_1006575766', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20151215_113453_1897.gif', NULL, 5354, 50, '2015-12-15 11:34:53'),
(34, 'page20151015_0855506815', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20151015_085813_2221.gif', NULL, 4575, 50, '2015-10-15 08:58:13'),
(38, 'page20151015_0911225612', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20151015_091438_6322.jpg', NULL, 41358, 50, '2015-10-15 09:14:38'),
(41, 'group_i20151217_0447557625', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20151217_045219_9054.jpg', NULL, 106304, 50, '2015-12-17 04:52:19'),
(43, 'group_i20160101_0932453193', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160101_105616_3651.jpg', NULL, 12999, 50, '2016-01-01 10:56:16'),
(44, 'dhsub20151217_0448227671', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160101_110307_2784.jpg', NULL, 22850, 50, '2016-01-01 11:03:43'),
(45, 'dhsub20151202_1007034444', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160101_110608_9073.gif', NULL, 5354, 50, '2016-01-01 11:06:08'),
(46, 'dhsub20151202_1007034444', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160101_110612_8395.jpg', NULL, 21304, 50, '2016-01-01 11:06:12'),
(47, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160102_100829_4932.jpg', NULL, 1434, 50, '2016-01-02 10:08:29'),
(48, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160102_101454_7183.jpg', NULL, 1644, 50, '2016-01-02 10:14:54'),
(49, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160215_113655_8906.png', NULL, 28475, 50, '2016-02-15 11:36:55'),
(50, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160223_102445_6381.jpg', NULL, 17292, 50, '2016-02-23 10:24:45'),
(230, 'music', 'muadr20180528_130737', 'bh2010079002demososo', 'y', 'cn', 'asdf', '', 'asfdas', 0, 50, '2018-05-28 13:07:37'),
(57, 'common', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160330_104430_2431.jpg', NULL, 17763, 50, '2016-03-30 10:44:30'),
(54, 'common', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160330_103830_9414.jpg', NULL, 4161, 50, '2016-03-30 10:38:30'),
(58, 'common', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160410_100648_6599.jpg', NULL, 15178, 50, '2017-05-03 18:46:39'),
(59, 'common', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160410_100653_6176.gif', NULL, 5186, 50, '2016-04-10 10:06:53'),
(61, 'common', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160410_101137_6214.png', NULL, 1255, 50, '2016-04-10 10:11:37'),
(62, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160415_050507_6454.jpg', NULL, 194586, 50, '2016-04-15 05:05:07'),
(63, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160419_125516_6089.ico', NULL, 1150, 50, '2016-04-19 12:55:16'),
(93, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160713_121206_4187.jpg', NULL, 137385, 50, '2016-07-13 12:12:06'),
(92, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20160713_120705_3380.jpg', NULL, 117750, 50, '2016-07-13 12:07:05'),
(98, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', 'sgdsg', '20160812_042415_1315.png', NULL, 1255, 50, '2017-04-10 17:02:25'),
(388, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20190103_123027_7211.png', NULL, 4648, 50, '2019-01-03 15:57:16'),
(121, 'common', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20170421_144032_2721.jpg', NULL, 12928, 50, '2017-04-21 14:40:32'),
(122, 'page20161207_1036569778', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20170423_181014_5749.jpg', NULL, 11168, 50, '2017-04-23 18:10:14'),
(186, 'common', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20180315_123721_1520.jpg', NULL, 43940, 50, '2018-03-15 12:37:21'),
(174, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20180306_180946_2038.jpg', NULL, 96107, 50, '2018-03-06 18:09:46'),
(173, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20180306_180803_5244.jpg', NULL, 57527, 50, '2018-03-06 18:08:03'),
(219, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20180323_163049_2338.jpg', NULL, 58756, 50, '2018-03-23 16:30:49'),
(240, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20180611_180825_2967.jpg', NULL, 36317, 50, '2018-06-11 18:08:25'),
(223, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20180420_185935_7246.jpg', NULL, 16280, 50, '2018-04-20 18:59:35'),
(228, 'music', 'muadr20180528_130715', 'bh2010079002demososo', 'y', 'cn', 'asdfas', '', 'sadfas', 0, 50, '2018-05-28 13:07:15'),
(229, 'music', 'muadr20180528_130719', 'bh2010079002demososo', 'y', 'cn', 'asdf', '', 'asdf', 0, 50, '2018-05-28 13:07:19'),
(227, 'music', 'muadr20180524_125009', 'bh2010079002demososo', 'y', 'cn', '测试音乐', '', 'test.mp3', 209120, 50, '2018-05-24 12:50:09'),
(231, 'music', 'muadr20180528_135723', 'bh2010079002demososo', 'y', 'cn', 'asdf', '', 'http://m2.music.126.net/JpSMJHt4W14RkMWuA4TZBQ==/1210562302189233.mp3', 0, 50, '2018-05-28 13:57:23'),
(232, 'music', 'muadr20180529_104206', 'bh2010079002demososo', 'y', 'cn', 'aa', '', 'aa', 0, 50, '2018-05-29 10:42:06'),
(233, 'music', 'muadr20180529_104210', 'bh2010079002demososo', 'y', 'cn', 'asdf', '', 'asdf', 0, 50, '2018-05-29 10:42:10'),
(234, 'music', 'muadr20180529_104214', 'bh2010079002demososo', 'y', 'cn', 'asdf', '', 'asdf', 0, 50, '2018-05-29 10:42:14'),
(235, 'music', 'muadr20180529_104218', 'bh2010079002demososo', 'y', 'cn', 'asdf', '', 'asdf', 0, 50, '2018-05-29 10:42:18'),
(236, 'music', 'muadr20180529_104222', 'bh2010079002demososo', 'y', 'cn', 'asfd', '', 'asdf', 0, 50, '2018-05-29 10:42:22'),
(237, 'music', 'muadr20180529_104226', 'bh2010079002demososo', 'y', 'cn', 'asdf', '', 'asdf', 0, 50, '2018-05-29 10:42:26'),
(238, 'music', 'muadr20180529_104229', 'bh2010079002demososo', 'y', 'cn', 'asdf', '', 'asfd', 0, 50, '2018-05-29 10:42:29'),
(245, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20180706_173917_7245.jpg', NULL, 21654, 50, '2018-07-06 17:39:17'),
(376, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20181220_150212_4949.jpg', NULL, 3680, 50, '2018-12-20 15:02:12'),
(410, 'node20150806_0929404264', NULL, 'bh2010079002demososo', 'y', 'cn', '', '20190305_182611_9228.png', NULL, 13475, 50, '2019-03-05 18:27:05'),
(412, 'name', NULL, 'bh2010079002demososo', 'y', 'cn', '甘fffsasfasfasdas', '20190329_111349_8928.png', NULL, 2092, 50, '2019-03-29 10:59:39');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_imgtext`
--

CREATE TABLE `zzz_imgtext` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `pidname` varchar(100) NOT NULL,
  `pbh` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `cssname` varchar(100) DEFAULT NULL,
  `kv` varchar(100) DEFAULT NULL,
  `pos` int(3) DEFAULT '50',
  `sta_visible` char(1) NOT NULL DEFAULT 'y',
  `fullwidth` char(1) NOT NULL DEFAULT 'n',
  `haswow` char(1) NOT NULL DEFAULT 'n',
  `effect` varchar(100) DEFAULT NULL,
  `arr_can` text,
  `desp` text,
  `desptext` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_imgtext`
--

INSERT INTO `zzz_imgtext` (`id`, `pid`, `pidname`, `pbh`, `lang`, `title`, `cssname`, `kv`, `pos`, `sta_visible`, `fullwidth`, `haswow`, `effect`, `arr_can`, `desp`, `desptext`) VALUES
(277, 'imgtext20190401_1332183787', 'simgtext20190401_1337361472', 'bh2010079002demososo', 'cn', '《小飞象》', '', '20190401_160742_5890.jpg', 500, 'y', 'n', 'n', NULL, 'titlefg:##titlecenter==#==format:##onlyedit==#==linkdhtitle:##查看更多==#==linkdhurl:##https://movie.douban.com/subject/1652592==#==blockid:##', '&lt;p&gt;迪士尼全新真人版《小飞象》改编自1941年推出的迪士尼同名经典动画，讲述了生来因一双大耳朵而遭人嘲笑的小飞象，在众人的帮助下逐渐拥抱自己的与众不同，成就一段逆风翱翔的暖心传奇。&amp;nbsp;&lt;br /&gt;\r\n　　一位前马戏团明星，刚从战争前线归来，霍特&amp;middot;法瑞尔(科林&amp;middot;法瑞尔饰)在一家艰难经营的马戏团谋得一份工作，负责照顾刚出生的小象，带着两个善良的孩子，女儿米莉&amp;middot;法瑞尔(尼科&amp;middot;帕克饰)和儿子乔&amp;middot;法瑞尔(芬利&amp;middot;霍宾斯饰)，两个孩子和另外一个女孩玛茜特(蔡慧泉饰)与小飞象成为朋友， 帮助小飞象找到妈妈。&amp;nbsp;&lt;br /&gt;\r\n　　当人们发现小象会飞后，马戏团重复生机，更吸引到一个充满心机的生意人文德维尔（迈克尔&amp;middot;基顿饰）的注意，他把小飞象雇佣到他的大型游乐场Dreamland，与杂技演员柯莱特&amp;middot;马钱特(伊娃&amp;middot;格林饰)做搭档，人气达到新高度，然而霍特&amp;middot;法瑞尔发现，游乐场光鲜亮丽的背后，充满种种见不得人的秘密。&amp;nbsp;&lt;/p&gt;', ''),
(273, 'common', 'imgtext20190401_1331404648', 'bh2010079002demososo', 'cn', 'scroll fix效果', 'mt30', NULL, 50, 'y', 'y', 'n', 'scrollfix.php', NULL, NULL, NULL),
(274, 'common', 'imgtext20190401_1332124432', 'bh2010079002demososo', 'cn', 'tab效果', 'mt30', NULL, 50, 'y', 'n', 'n', 'tab.php', NULL, NULL, NULL),
(275, 'common', 'imgtext20190401_1332183787', 'bh2010079002demososo', 'cn', '默认效果', 'moresm more4', NULL, 50, 'y', 'y', 'n', 'default.php', NULL, NULL, NULL),
(276, 'imgtext20190401_1332183787', 'simgtext20190401_1337331173', 'bh2010079002demososo', 'cn', '惊奇队长 Captain Marvel', '', '20190401_160737_6936.jpg', 50, 'y', 'n', 'n', NULL, 'titlefg:##titleleft==#==format:##imgright==#==linkdhtitle:##查看更多==#==linkdhurl:##https://movie.douban.com/subject/1652592==#==blockid:##', '&lt;p&gt;漫画中的初代&amp;ldquo;惊奇女士&amp;rdquo;原名Carol Danvers，她曾经是一名美国空军情报局探员，暗恋惊奇先生。此后她得到了超能力，成为&amp;ldquo;惊奇女士&amp;rdquo;，在漫画中是非常典型的女性英雄人物。&amp;nbsp;&lt;br /&gt;\r\n　　她可以吸收并控制任意形态的能量，拥有众多超能力。《惊奇队长》将是漫威首部以女性超级英雄为主角的电影。&lt;/p&gt;', ''),
(278, 'imgtext20190401_1332183787', 'simgtext20190401_1340538258', 'bh2010079002demososo', 'cn', '流浪地球', '', '20190401_160643_3584.jpg', 50, 'y', 'n', 'n', NULL, 'titlefg:##titleleft==#==format:##imgleft==#==linkdhtitle:##查看更多==#==linkdhurl:##https://movie.douban.com/subject/1652592==#==blockid:##', '&lt;p&gt;近未来，科学家们发现太阳急速衰老膨胀，短时间内包括地球在内的整个太阳系都将被太阳所吞没。为了自救，人类提出一个名为&amp;ldquo;流浪地球&amp;rdquo;的大胆计划，即倾全球之力在地球表面建造上万座发动机和转向发动机，推动地球离开太阳系，用2500年的时间奔往另外一个栖息之地。中国航天员刘培强（吴京 饰）在儿子刘启四岁那年前往国际空间站，和国际同侪肩负起领航者的重任。转眼刘启（屈楚萧 饰）长大，他带着妹妹朵朵（赵今麦 饰）偷偷跑到地表，偷开外公韩子昂（吴孟达 饰）的运输车，结果不仅遭到逮捕，还遭遇了全球发动机停摆的事件。为了修好发动机，阻止地球坠入木星，全球开始展开饱和式营救，连刘启他们的车也被强征加入。在与时间赛跑的过程中，无数的人前仆后继，奋不顾身，只为延续百代子孙生存的希望&amp;hellip;&amp;hellip;&amp;nbsp;&lt;/p&gt;', ''),
(279, 'imgtext20190401_1332183787', 'simgtext20190401_1341484135', 'bh2010079002demososo', 'cn', '阿丽塔：战斗天使 Alita', NULL, '20190401_160636_4544.jpg', 50, 'y', 'n', 'n', NULL, 'format:##imgright==#==linkdhtitle:##查看更多==#==linkdhurl:##https://movie.douban.com/subject/1652592==#==blockid:##', '&lt;p&gt;　故事发生在遥远的26世纪，外科医生依德（克里斯托弗&amp;middot;瓦尔兹 Christoph Waltz 饰）在垃圾场里捡到了只剩下头部的机械少女将她带回家中，给她装上了本来为自己已故的女儿所准备的义体，并取名阿丽塔（罗莎&amp;middot;萨拉扎尔 Rosa Salazar 饰）。苏醒后的阿丽塔对这个五彩斑斓但却暴力而又残酷的世界产生了浓厚的兴趣，在结识了青年雨果（基恩&amp;middot;约翰逊 Keean Johnson 饰）后，阿丽塔开始接触名为机动球的运动，并在比赛中展现出了惊人的格斗天赋。&amp;nbsp;&lt;br /&gt;\r\n　　在废铁城居民们的头顶，漂浮着巨大的浮空城市撒冷，废铁城居民们的一切劳作和付出，都是为了给撒冷提供继续运作的燃料。在大财阀维克特（马赫沙拉&amp;middot;阿里 Mahershala Ali 饰）所设立的机动球比赛中，最终获得冠军的人能够获得前往撒冷生活的资格，阿丽塔决定利用自己的格斗天赋参加比赛，却被卷入了一个巨大的阴...&lt;/p&gt;', ''),
(280, 'imgtext20190401_1332124432', 'simgtext20190401_1749209677', 'bh2010079002demososo', 'cn', '《小飞象》', '', '20190401_180051_4317.jpg', 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##notitle==#==format:##imgright==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##', '&lt;p&gt;迪士尼全新真人版《小飞象》改编自1941年推出的迪士尼同名经典动画，讲述了生来因一双大耳朵而遭人嘲笑的小飞象，在众人的帮助下逐渐拥抱自己的与众不同，成就一段逆风翱翔的暖心传奇。&amp;nbsp;&lt;br /&gt;\r\n　　一位前马戏团明星，刚从战争前线归来，霍特&amp;middot;法瑞尔(科林&amp;middot;法瑞尔饰)在一家艰难经营的马戏团谋得一份工作，负责照顾刚出生的小象，带着两个善良的孩子，女儿米莉&amp;middot;法瑞尔(尼科&amp;middot;帕克饰)和儿子乔&amp;middot;法瑞尔(芬利&amp;middot;霍宾斯饰)，两个孩子和另外一个女孩玛茜特(蔡慧泉饰)与小飞象成为朋友， 帮助小飞象找到妈妈。&amp;nbsp;&lt;br /&gt;\r\n　　当人们发现小象会飞后，马戏团重复生机，更吸引到一个充满心机的生意人文德维尔（迈克尔&amp;middot;基顿饰）的注意，他把小飞象雇佣到他的大型游乐场Dreamland，与杂技演员柯莱特&amp;middot;马钱特(伊娃&amp;middot;格林饰)做搭档，人气达到新高度，然而霍特&amp;middot;法瑞尔发现，游乐场光鲜亮丽的背后，充满种种见不得人的秘密。&amp;nbsp;&lt;/p&gt;', ''),
(281, 'imgtext20190401_1332124432', 'simgtext20190401_1750532565', 'bh2010079002demososo', 'cn', '惊奇队长 Captain Marvel', '', '', 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##notitle==#==format:##bsleft==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##vblock20170419_1639427863', '&lt;p&gt;漫画中的初代&amp;ldquo;惊奇女士&amp;rdquo;原名Carol Danvers，她曾经是一名美国空军情报局探员，暗恋惊奇先生。此后她得到了超能力，成为&amp;ldquo;惊奇女士&amp;rdquo;，在漫画中是非常典型的女性英雄人物。&amp;nbsp;&lt;br /&gt;\r\n　　她可以吸收并控制任意形态的能量，拥有众多超能力。《惊奇队长》将是漫威首部以女性超级英雄为主角的电影。&lt;/p&gt;', ''),
(282, 'imgtext20190401_1332124432', 'simgtext20190401_1750557506', 'bh2010079002demososo', 'cn', '流浪地球', '', '20190401_180042_5055.jpg', 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##notitle==#==format:##imgright==#==linkdhtitle:##查看更多==#==linkdhurl:##https://movie.douban.com/subject/1652592==#==blockid:##', '&lt;p&gt;近未来，科学家们发现太阳急速衰老膨胀，短时间内包括地球在内的整个太阳系都将被太阳所吞没。为了自救，人类提出一个名为&amp;ldquo;流浪地球&amp;rdquo;的大胆计划，即倾全球之力在地球表面建造上万座发动机和转向发动机，推动地球离开太阳系，用2500年的时间奔往另外一个栖息之地。中国航天员刘培强（吴京 饰）在儿子刘启四岁那年前往国际空间站，和国际同侪肩负起领航者的重任。转眼刘启（屈楚萧 饰）长大，他带着妹妹朵朵（赵今麦 饰）偷偷跑到地表，偷开外公韩子昂（吴孟达 饰）的运输车，结果不仅遭到逮捕，还遭遇了全球发动机停摆的事件。为了修好发动机，阻止地球坠入木星，全球开始展开饱和式营救，连刘启他们的车也被强征加入。在与时间赛跑的过程中，无数的人前仆后继，奋不顾身，只为延续百代子孙生存的希望&amp;hellip;&amp;hellip;&amp;nbsp;&lt;/p&gt;', ''),
(283, 'imgtext20190401_1332124432', 'simgtext20190401_1750574426', 'bh2010079002demososo', 'cn', '阿丽塔：战斗天使 Alita', '', '20190401_180024_6256.jpg', 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##notitle==#==format:##imgleft==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##', '&lt;p&gt;　故事发生在遥远的26世纪，外科医生依德（克里斯托弗&amp;middot;瓦尔兹 Christoph Waltz 饰）在垃圾场里捡到了只剩下头部的机械少女将她带回家中，给她装上了本来为自己已故的女儿所准备的义体，并取名阿丽塔（罗莎&amp;middot;萨拉扎尔 Rosa Salazar 饰）。苏醒后的阿丽塔对这个五彩斑斓但却暴力而又残酷的世界产生了浓厚的兴趣，在结识了青年雨果（基恩&amp;middot;约翰逊 Keean Johnson 饰）后，阿丽塔开始接触名为机动球的运动，并在比赛中展现出了惊人的格斗天赋。&amp;nbsp;&lt;br /&gt;\r\n　　在废铁城居民们的头顶，漂浮着巨大的浮空城市撒冷，废铁城居民们的一切劳作和付出，都是为了给撒冷提供继续运作的燃料。在大财阀维克特（马赫沙拉&amp;middot;阿里 Mahershala Ali 饰）所设立的机动球比赛中，最终获得冠军的人能够获得前往撒冷生活的资格，阿丽塔决定利用自己的格斗天赋参加比赛，却被卷入了一个巨大的阴...&lt;/p&gt;', ''),
(284, 'imgtext20190401_1331404648', 'simgtext20190401_1808361234', 'bh2010079002demososo', 'cn', '阿丽塔：战斗天使 Alita', '', NULL, 50, 'y', 'n', 'n', NULL, 'titlefg:##titlecenter==#==format:##bsleft==#==linkdhtitle:##查看更多==#==linkdhurl:##https://movie.douban.com/subject/1652592==#==blockid:##vblock20170419_1557044653', '&lt;p&gt;　故事发生在遥远的26世纪，外科医生依德（克里斯托弗&amp;middot;瓦尔兹 Christoph Waltz 饰）在垃圾场里捡到了只剩下头部的机械少女将她带回家中，给她装上了本来为自己已故的女儿所准备的义体，并取名阿丽塔（罗莎&amp;middot;萨拉扎尔 Rosa Salazar 饰）。苏醒后的阿丽塔对这个五彩斑斓但却暴力而又残酷的世界产生了浓厚的兴趣，在结识了青年雨果（基恩&amp;middot;约翰逊 Keean Johnson 饰）后，阿丽塔开始接触名为机动球的运动，并在比赛中展现出了惊人的格斗天赋。&amp;nbsp;&lt;br /&gt;\r\n　　在废铁城居民们的头顶，漂浮着巨大的浮空城市撒冷，废铁城居民们的一切劳作和付出，都是为了给撒冷提供继续运作的燃料。在大财阀维克特（马赫沙拉&amp;middot;阿里 Mahershala Ali 饰）所设立的机动球比赛中，最终获得冠军的人能够获得前往撒冷生活的资格，阿丽塔决定利用自己的格斗天赋参加比赛，却被卷入了一个巨大的阴...&lt;/p&gt;', ''),
(285, 'imgtext20190401_1331404648', 'simgtext20190401_1808388802', 'bh2010079002demososo', 'cn', '流浪地球', NULL, '20190401_181001_6951.jpg', 50, 'y', 'n', 'n', NULL, 'format:##imgright==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##', '&lt;p&gt;近未来，科学家们发现太阳急速衰老膨胀，短时间内包括地球在内的整个太阳系都将被太阳所吞没。为了自救，人类提出一个名为&amp;ldquo;流浪地球&amp;rdquo;的大胆计划，即倾全球之力在地球表面建造上万座发动机和转向发动机，推动地球离开太阳系，用2500年的时间奔往另外一个栖息之地。中国航天员刘培强（吴京 饰）在儿子刘启四岁那年前往国际空间站，和国际同侪肩负起领航者的重任。转眼刘启（屈楚萧 饰）长大，他带着妹妹朵朵（赵今麦 饰）偷偷跑到地表，偷开外公韩子昂（吴孟达 饰）的运输车，结果不仅遭到逮捕，还遭遇了全球发动机停摆的事件。为了修好发动机，阻止地球坠入木星，全球开始展开饱和式营救，连刘启他们的车也被强征加入。在与时间赛跑的过程中，无数的人前仆后继，奋不顾身，只为延续百代子孙生存的希望&amp;hellip;&amp;hellip;&amp;nbsp;&lt;/p&gt;', ''),
(286, 'imgtext20190401_1331404648', 'simgtext20190401_1808405304', 'bh2010079002demososo', 'cn', '惊奇队长 Captain Marvel', '', '20190401_180955_7314.jpg', 50, 'y', 'n', 'n', NULL, 'titlefg:##titlecenter==#==format:##onlyedit==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##', '&lt;p&gt;漫画中的初代&amp;ldquo;惊奇女士&amp;rdquo;原名Carol Danvers，她曾经是一名美国空军情报局探员，暗恋惊奇先生。此后她得到了超能力，成为&amp;ldquo;惊奇女士&amp;rdquo;，在漫画中是非常典型的女性英雄人物。&amp;nbsp;&lt;br /&gt;\r\n　　她可以吸收并控制任意形态的能量，拥有众多超能力。《惊奇队长》将是漫威首部以女性超级英雄为主角的电影。&lt;/p&gt;', ''),
(287, 'imgtext20190401_1331404648', 'simgtext20190401_1808426889', 'bh2010079002demososo', 'cn', '《小飞象》', NULL, '20190401_180947_5399.jpg', 50, 'y', 'n', 'n', NULL, 'format:##imgright==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##', '&lt;p&gt;迪士尼全新真人版《小飞象》改编自1941年推出的迪士尼同名经典动画，讲述了生来因一双大耳朵而遭人嘲笑的小飞象，在众人的帮助下逐渐拥抱自己的与众不同，成就一段逆风翱翔的暖心传奇。&amp;nbsp;&lt;br /&gt;\r\n　　一位前马戏团明星，刚从战争前线归来，霍特&amp;middot;法瑞尔(科林&amp;middot;法瑞尔饰)在一家艰难经营的马戏团谋得一份工作，负责照顾刚出生的小象，带着两个善良的孩子，女儿米莉&amp;middot;法瑞尔(尼科&amp;middot;帕克饰)和儿子乔&amp;middot;法瑞尔(芬利&amp;middot;霍宾斯饰)，两个孩子和另外一个女孩玛茜特(蔡慧泉饰)与小飞象成为朋友， 帮助小飞象找到妈妈。&amp;nbsp;&lt;br /&gt;\r\n　　当人们发现小象会飞后，马戏团重复生机，更吸引到一个充满心机的生意人文德维尔（迈克尔&amp;middot;基顿饰）的注意，他把小飞象雇佣到他的大型游乐场Dreamland，与杂技演员柯莱特&amp;middot;马钱特(伊娃&amp;middot;格林饰)做搭档，人气达到新高度，然而霍特&amp;middot;法瑞尔发现，游乐场光鲜亮丽的背后，充满种种见不得人的秘密。&amp;nbsp;&lt;/p&gt;', ''),
(288, 'imgtext20190401_1331404648', 'simgtext20190401_1813104030', 'bh2010079002demososo', 'cn', '产品介绍', '', NULL, 50, 'y', 'n', 'n', NULL, 'titlefg:##titleleft==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##vblock20190117_1103544735', '', ''),
(295, 'common', 'imgtext20190403_1453115152', 'bh2010079002demososo', 'cn', '首页', '', NULL, 50, 'y', 'y', 'n', 'default.php', NULL, NULL, NULL),
(296, 'imgtext20190403_1453115152', 'simgtext20190403_1455391692', 'bh2010079002demososo', 'cn', '关于我们', '', '20190403_145606_4334.jpg', 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##imgleft==#==linkdhtitle:##查看更多==#==linkdhurl:##https://www.demososo.com==#==blockid:##', '&lt;p&gt;&lt;strong&gt;欢迎使用DM企业建站系统&lt;/strong&gt;&lt;strong&gt;&lt;a href=&quot;http://www.demososo.com/&quot; target=&quot;_blank&quot;&gt;www.demososo.com&lt;/a&gt;&lt;/strong&gt;&lt;strong&gt;，本系统&lt;/strong&gt;&lt;strong&gt;开源免费，无需授权&lt;/strong&gt;&lt;strong&gt;即可使用，模板响应式，支持手机等移动端设备访问。&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;欢迎使用DM企业建站系统www.demososo.com，本系统开源免费，无需授权即可使用，模板响应式，支持手机等移动端设备访问。&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;​&lt;strong&gt;欢迎使用DM企业建站系统www.demososo.com，本系统开源免费，无需授权即可使用，模板响应式，支持手机等移动端设备访问。&lt;/strong&gt;&lt;/p&gt;', ''),
(297, 'imgtext20190403_1453115152', 'simgtext20190403_1709275107', 'bh2010079002demososo', 'cn', '我们的服务', '', NULL, 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##vblock20170420_1158241500', '', ''),
(298, 'imgtext20190403_1453115152', 'simgtext20190403_1716371922', 'bh2010079002demososo', 'cn', '我们的服务tab切换', '', NULL, 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##vblock20170419_1845397696', '', ''),
(299, 'imgtext20190403_1453115152', 'simgtext20190403_1717039015', 'bh2010079002demososo', 'cn', '为什么 选择DM建站系统', '', NULL, 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##vblock20170419_1837016257', '', ''),
(300, 'imgtext20190403_1453115152', 'simgtext20190403_1717402449', 'bh2010079002demososo', 'cn', '产品中心', '', NULL, 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##vblock20170919_1202408332', '', ''),
(301, 'imgtext20190403_1453115152', 'simgtext20190403_1717517759', 'bh2010079002demososo', 'cn', '新闻', '', NULL, 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##vblock20170419_1557131900', '', ''),
(302, 'imgtext20190403_1453115152', 'simgtext20190403_1718017281', 'bh2010079002demososo', 'cn', '客户评价', '', NULL, 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##vblock20170419_1841265872', '', ''),
(303, 'imgtext20190403_1453115152', 'simgtext20190403_1718077235', 'bh2010079002demososo', 'cn', '我们的客户', '', NULL, 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##vblock20170919_1446491004', '', ''),
(304, 'imgtext20190403_1453115152', 'simgtext20190403_1718144355', 'bh2010079002demososo', 'cn', '联系我们', '', NULL, 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##group20180303_1220043665', '', ''),
(305, 'page20150806_0436437668', 'imgtext20190403_1838395607', 'bh2010079002demososo', 'cn', '联系我们', '', NULL, 50, 'y', 'y', 'y', 'default.php', NULL, NULL, NULL),
(306, 'imgtext20190403_1838395607', 'simgtext20190403_1838528554', 'bh2010079002demososo', 'cn', '百度地图', '', NULL, 50, 'y', 'y', 'n', NULL, 'cssstyle:##==#==titlefg:##notitle==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##prog_baidumap', '', ''),
(307, 'imgtext20190403_1838395607', 'simgtext20190403_1838547150', 'bh2010079002demososo', 'cn', '文字和图片', '', '20190403_184035_5148.jpg', 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##notitle==#==format:##imgright==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##', '&lt;p&gt;联系：&lt;a href=&quot;http://www.demososo.com/&quot; target=&quot;_blank&quot;&gt;&lt;strong&gt;DM企业建站企业建站系统&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;网址：&lt;a href=&quot;http://www.demososo.com/&quot; target=&quot;_blank&quot;&gt;&lt;strong&gt;www.demososo.com&lt;/strong&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\n手机：133 8888 8888&lt;br /&gt;\r\n电话：021-8888 8888 传真：021-8888 8888&lt;br /&gt;\r\n邮箱：***@163.com&lt;br /&gt;\r\n地址：上海市长宁区天山路**号&lt;br /&gt;\r\n电话：021-8888 8888&lt;br /&gt;\r\n传真：021-8888 8888&lt;/p&gt;', ''),
(308, 'imgtext20190403_1838395607', 'simgtext20190403_1838587498', 'bh2010079002demososo', 'cn', '联系表单', '', NULL, 50, 'y', 'n', 'n', NULL, 'cssstyle:##==#==titlefg:##titlecenter==#==format:##bsonly==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##form20180218_1250127063', '', ''),
(309, 'page20150806_0436437668', 'imgtext20190403_1843301739', 'bh2010079002demososo', 'cn', '基本原则顶戴223355333', '5566633', NULL, 50, 'y', 'y', 'n', 'default.php', NULL, NULL, NULL),
(310, 'imgtext20190403_1843301739', 'simgtext20190403_1846579826', 'bh2010079002demososo', 'cn', '以', NULL, NULL, 50, 'y', 'n', 'n', NULL, 'cssname:##==#==cssstyle:##==#==fullwidth:##n==#==titlefg:##notitle==#==format:##imgtop==#==linkdhtitle:##==#==linkdhurl:##==#==blockid:##', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_lang`
--

CREATE TABLE `zzz_lang` (
  `id` int(11) NOT NULL,
  `pbh` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL DEFAULT 'cn' COMMENT 'lang is pidname,no change',
  `langfile` varchar(50) DEFAULT 'lang_cn.php',
  `name` varchar(30) DEFAULT NULL,
  `langpath` varchar(50) DEFAULT NULL,
  `domain` varchar(50) DEFAULT NULL,
  `pos` int(3) NOT NULL DEFAULT '0',
  `sta_visible` char(1) NOT NULL DEFAULT 'n',
  `sta_big5` char(1) NOT NULL DEFAULT 'y',
  `sta_main` char(1) NOT NULL DEFAULT 'n',
  `sitename` varchar(200) DEFAULT NULL,
  `water` varchar(50) DEFAULT NULL,
  `imgfolder` varchar(20) NOT NULL DEFAULT '1',
  `arr_assets` text,
  `arr_map` text,
  `curstyle` varchar(60) DEFAULT NULL,
  `arr_basicset` text,
  `arr_smtp` text,
  `seo1` text,
  `seo2` text,
  `seo3` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_lang`
--

INSERT INTO `zzz_lang` (`id`, `pbh`, `lang`, `langfile`, `name`, `langpath`, `domain`, `pos`, `sta_visible`, `sta_big5`, `sta_main`, `sitename`, `water`, `imgfolder`, `arr_assets`, `arr_map`, `curstyle`, `arr_basicset`, `arr_smtp`, `seo1`, `seo2`, `seo3`) VALUES
(1, 'bh2010079002demososo', 'cn', 'lang_cn.php', '中文', 'cn', '127.0.0.55:8080', 200, 'y', 'n', 'y', '默认中文网站 power by DM系统', '20190103_123027_7211.png', '1', 'jquery:##==#==compresscss:##n', 'map_title:##DM企业建站系统==#==map_desp:##企业建站，就选DM企业建站系统 www.demososo.com==#==map_w:##100%==#==map_h:##400px==#==map_x_wei:##121.481033==#==map_y_jing:##31.238802', 'style20160721_0855323118', 'waterposi:##y==#==waterpercent:##30==#==editor:##ck==#==cdnurl:##==#==ico:##20160419_125516_6089.ico==#==sta_frontedit:##y==#==cssversion:##23282==#==tag_title:##标签==#==tag_fg:##tag_grid.php==#==sta_tag_shownum:##y==#==tagmaxline:##20==#==sta_colseresponsive:##n==#==linkofmobile:##==#==searcherror:##请输入关键字==#==searchtext:##手机', 'smtp_active:##n==#==smtp_server:##smtp.163.com==#==smtp_port:##25==#==smtp_email:##......@163.com==#==smtp_ps:##', 'DM企业建站系统1', 'DM企业建站系统2', 'DM企业建站系统 SEO描述3');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_layout`
--

CREATE TABLE `zzz_layout` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL DEFAULT '0',
  `pidname` varchar(80) DEFAULT NULL,
  `pid_inherit` varchar(100) DEFAULT NULL,
  `lang` varchar(50) NOT NULL,
  `pbh` varchar(50) NOT NULL DEFAULT 'n',
  `pidstylebh` varchar(80) NOT NULL,
  `pos` int(3) NOT NULL DEFAULT '50' COMMENT 'must',
  `type` varchar(20) DEFAULT NULL COMMENT 'index or read or cate',
  `layoutcan` text,
  `dateedit` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_layout`
--

INSERT INTO `zzz_layout` (`id`, `pid`, `pidname`, `pid_inherit`, `lang`, `pbh`, `pidstylebh`, `pos`, `type`, `layoutcan`, `dateedit`) VALUES
(1253, 'common', 'layout20180719_1540544512', NULL, 'cn', 'bh2010079002demososo', 'style20160506_1242421660', 50, 'common', 'header_pc:##header_menu_right.php==#==skincss:##skin_orange.css==#==pidmenu:##menu20161129_1804453928==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20170921_1137442079==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-07-19 15:40:54'),
(1254, 'common', 'layout20180719_1610565696', NULL, 'cn', 'bh2010079002demososo', 'style20160721_0855323118', 50, 'common', 'header_pc:##header_menu_bottom.php==#==skincss:##skin_blue.css==#==pidmenu:##menu20161129_1804453928==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20170921_1137442079==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-07-19 16:10:56'),
(1328, 'page20150805_1138522811', 'layout20181117_0840219233', NULL, 'cn', 'bh2010079002demososo', 'style20160721_0855323118', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##hide==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-11-17 08:40:21'),
(1256, 'page20150805_1143268522', 'layout20180719_1611097835', NULL, 'cn', 'bh2010079002demososo', 'style20160721_0855323118', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##20160713_121206_4187.jpg==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##t==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-07-19 16:11:09'),
(1257, 'page20151015_0911225612', 'layout20180719_1611105582', NULL, 'cn', 'bh2010079002demososo', 'style20160721_0855323118', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##20160713_120705_3380.jpg==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##t==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-07-19 16:11:10'),
(1258, 'page20161207_1036569778', 'layout20180719_1611121842', NULL, 'cn', 'bh2010079002demososo', 'style20160721_0855323118', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##20160713_120705_3380.jpg==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##t==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-07-19 16:11:12'),
(1259, 'page20150806_0435579851', 'layout20180719_1611139179', NULL, 'cn', 'bh2010079002demososo', 'style20160721_0855323118', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##20180315_183804_8641.jpg==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##hide==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##n==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-07-19 16:11:13'),
(1260, 'common', 'layout20180719_1616583760', NULL, 'cn', 'bh2010079002demososo', 'style20180420_1235164259', 50, 'common', 'bannercssname:##==#==banner:##20180706_173917_7245.jpg==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20170921_1137442079==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==template:##', '2018-07-19 16:16:58'),
(1261, 'common', 'layout20180719_1617512583', NULL, 'cn', 'bh2010079002demososo', 'style20180420_1201347506', 50, 'common', 'bannercssname:##==#==banner:##20160223_102445_6381.jpg==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20170921_1137442079==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==template:##', '2018-07-19 16:17:51'),
(1262, 'common', 'layout20180719_1621456162', NULL, 'cn', 'bh2010079002demososo', 'style20180710_1618471645', 50, 'common', 'bannercssname:##bannerhgtall==#==banner:##20180710_184957_5228.png==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20170921_1137442079==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==template:##', '2018-07-19 16:21:45'),
(1263, 'common', 'layout20180719_1626046776', NULL, 'cn', 'bh2010079002demososo', 'style20171123_1856515884', 50, 'common', 'header_pc:##self_header.php==#==skincss:##skin_black.css==#==pidmenu:##menu20161129_1804453928==#==bannercssname:##==#==banner:##20180611_180825_2967.jpg==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20170921_1137442079==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-07-19 16:26:04'),
(1264, 'common', 'layout20180719_1627567570', NULL, 'cn', 'bh2010079002demososo', 'style20170426_1846378581', 50, 'common', 'header_pc:##header_menu_floatbanner.php==#==skincss:##skin_blue.css==#==pidmenu:##menu20161129_1804453928==#==bannercssname:##==#==banner:##20180420_185935_7246.jpg==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20170921_1137442079==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-07-19 16:27:56'),
(1265, 'common', 'layout20180719_1628414565', NULL, 'cn', 'bh2010079002demososo', 'style20171022_1025054134', 50, 'common', 'header_pc:##header_menu_right.php==#==skincss:##skin_blue.css==#==pidmenu:##menu20171022_1200255763==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_hide.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20170921_1137442079==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-07-19 16:28:41'),
(1320, 'cate20150805_1125344029', 'layout20180824_1654105602', NULL, 'cn', 'bh2010079002demososo', 'style20170426_1846378581', 50, 'cate', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##t==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-08-24 16:54:10'),
(1329, 'common', 'layout20181117_1149111513', NULL, 'cn', 'bh2010079002demososo', 'style20181117_1146577982', 50, 'common', 'bannercssname:##==#==banner:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==template:##', '2018-11-17 11:49:11'),
(1330, 'common', 'layout20181214_1151122607', NULL, 'cn', 'bh2010079002demososo', 'style20181214_1150088751', 50, 'common', 'bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20170921_1137442079==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2018-12-14 11:51:12'),
(1336, 'page20190102_1814157870', 'layout20190102_1815135754', NULL, 'cn', 'bh2010079002demososo', 'style20160506_1242421660', 50, 'page', 'bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##r==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##prog_search==#==contentbot:##==#==pagetop:##==#==pagebot:##', '2019-01-02 18:15:13'),
(1339, 'tag', 'layout20190104_1016406756', NULL, 'cn', 'bh2010079002demososo', 'style20160506_1242421660', 50, 'tag', 'bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20190107_1049375343==#==contentheader:##==#==contenttop:##http://www.demososo.com|这可是后台可以修改的哟|20150806_103634_1001.jpg==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##', '2019-01-04 10:16:40'),
(1340, 'tag', 'layout20190109_1752179246', NULL, 'cn', 'bh2010079002demososo', 'style20160721_0855323118', 50, 'tag', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##group20190107_1049375343==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2019-01-09 17:52:17'),
(1342, 'page20150805_1143268522', 'layout20190115_1045259765', NULL, 'cn', 'bh2010079002demososo', 'style20181214_1150088751', 50, 'page', 'bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##vblock20190107_1056503744==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2019-01-15 10:45:25'),
(1343, 'cate20150805_1125344029', 'layout20190115_1445544515', NULL, 'cn', 'bh2010079002demososo', 'style20181214_1150088751', 50, 'cate', 'bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##r==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2019-01-15 14:45:54'),
(1344, 'common', 'layout20190215_1503038140', NULL, 'cn', 'bh2010079002demososo', 'style20190215_1501501686', 50, 'common', 'bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==template:##', '2019-02-15 15:03:03'),
(1347, 'page20190102_1814157870', 'layout20190301_1311069265', NULL, 'cn', 'bh2010079002demososo', 'style20160721_0855323118', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##prog_searchinput==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##prog_searchinput==#==content:##prog_search==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2019-03-01 13:11:06'),
(1354, 'page20150806_0436437668', 'layout20190403_1825455130', NULL, 'cn', 'bh2010079002demososo', 'style20160721_0855323118', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##sdf==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2019-04-03 18:25:45'),
(1351, 'page20190102_1814157870', 'layout20190314_1459093429', NULL, 'cn', 'bh2010079002demososo', 'style20171123_1856515884', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##prog_search==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2019-03-14 14:59:09'),
(1352, 'page20190102_1814157870', 'layout20190314_1459558128', NULL, 'cn', 'bh2010079002demososo', 'style20171022_1025054134', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##prog_search==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2019-03-14 14:59:55'),
(1353, 'page20190102_1814157870', 'layout20190314_1500432223', NULL, 'cn', 'bh2010079002demososo', 'style20170426_1846378581', 50, 'page', 'header_pc:##jcgg==#==skincss:##jcgg==#==pidmenu:##jcgg==#==bannercssname:##==#==banner:##==#==bannermobi:##==#==bannereffect:##banner_bg.php==#==bannertext:##==#==bannertextstyle:##==#==bannerbg:##==#==breadposi:##r==#==breadtext:##==#==sidebarposi:##l==#==sidebartop:##==#==sidebar:##==#==sidebarbot:##==#==contentheader:##==#==contenttop:##==#==content:##prog_search==#==contentbot:##==#==pagetop:##==#==pagebot:##==#==pagetemplate:##', '2019-03-14 15:00:43');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_menu`
--

CREATE TABLE `zzz_menu` (
  `id` int(11) NOT NULL,
  `ppid` varchar(80) NOT NULL DEFAULT '0' COMMENT 'main is 0.other is main pidname',
  `pid` varchar(50) NOT NULL DEFAULT '0',
  `pidname` varchar(100) NOT NULL,
  `pbh` varchar(50) NOT NULL DEFAULT 'n',
  `lang` varchar(50) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `cssname` varchar(50) DEFAULT NULL,
  `alias_jump` varchar(100) DEFAULT NULL,
  `sta_visible` varchar(1) NOT NULL DEFAULT 'y',
  `type` varchar(50) NOT NULL DEFAULT 'page' COMMENT 'page or cate or catesub',
  `linkurl` varchar(200) DEFAULT NULL,
  `kv` varchar(100) DEFAULT NULL,
  `sta_noaccess` char(1) NOT NULL DEFAULT 'n',
  `pos` int(3) DEFAULT '50',
  `sta_cusmenu` char(1) NOT NULL DEFAULT 'n',
  `cusmenudesp` text,
  `menu_xiala` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_menu`
--

INSERT INTO `zzz_menu` (`id`, `ppid`, `pid`, `pidname`, `pbh`, `lang`, `name`, `cssname`, `alias_jump`, `sta_visible`, `type`, `linkurl`, `kv`, `sta_noaccess`, `pos`, `sta_cusmenu`, `cusmenudesp`, `menu_xiala`) VALUES
(157, 'menu20161129_1804453928', '0', 'smenu20150806_0435579851', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20150806_0435579851', NULL, NULL, 'n', 50, 'n', NULL, NULL),
(155, 'menu20161129_1804453928', '0', 'smenu20150805_1133251007', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'cate20150805_1133251007', NULL, NULL, 'n', 66, 'n', NULL, NULL),
(154, 'menu20161129_1804453928', '0', 'smenu20150805_1125344029', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'cate20150805_1125344029', NULL, NULL, 'n', 65, 'n', NULL, NULL),
(153, 'menu20161129_1804453928', 'smenu20170510_1715538289', 'smenu20150805_1138522811', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20150805_1138522811', NULL, NULL, 'n', 100, 'n', NULL, NULL),
(152, 'menu20161129_1804453928', 'smenu20170510_1715538289', 'smenu20151015_0911225612', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20151015_0911225612', NULL, NULL, 'n', 50, 'n', NULL, NULL),
(151, 'menu20161129_1804453928', 'smenu20170510_1715538289', 'smenu20150805_1143268522', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20150805_1143268522', NULL, NULL, 'n', 50, 'n', NULL, NULL),
(173, 'menu20161129_1804453928', 'smenu20170510_1715538289', 'smenu20161207_1036569778', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20161207_1036569778', NULL, NULL, 'n', 60, 'n', NULL, NULL),
(148, '0', 'main', 'menu20161129_1804453928', 'bh2010079002demososo', 'cn', '默认菜单组', NULL, NULL, 'y', 'page', NULL, NULL, 'n', 500, 'n', '', NULL),
(178, 'menu20161129_1804453928', '0', 'smenu20170510_1715538289', 'bh2010079002demososo', 'cn', '关于我们', NULL, NULL, 'y', 'cusm20170510_1715538289', 'about.html', NULL, 'n', 100, 'n', NULL, ''),
(247, 'menu20170704_1705401885', '0', 'smenu20180605_1610283446', 'bh2010079002demososo', 'cn', 'ccc', NULL, NULL, 'y', 'cusm20180605_1610283446', 'ccc', NULL, 'n', 50, 'n', NULL, ''),
(215, '0', 'main', 'menu20171022_1200255763', 'bh2010079002demososo', 'cn', '单页面菜单', NULL, NULL, 'y', 'page', NULL, NULL, 'n', 50, 'y', '&lt;ul class=&quot;m menudanye&quot;&gt;\r\n&lt;li class=&quot;m&quot;&gt;&lt;a class=&quot;m&quot; href=&quot;#anchor0&quot;&gt;关于我们&lt;/a&gt;&lt;/li&gt;\r\n&lt;li class=&quot;m&quot;&gt;&lt;a class=&quot;m&quot; href=&quot;#anchor1&quot;&gt;我们的服务&lt;/a&gt;&lt;/li&gt;\r\n \r\n&lt;li class=&quot;m&quot;&gt;&lt;a class=&quot;m&quot; href=&quot;#anchor4&quot;&gt;产品&lt;/a&gt;&lt;/li&gt;\r\n\r\n&lt;li class=&quot;m&quot;&gt;&lt;a class=&quot;m&quot; href=&quot;#anchor5&quot;&gt;公司新闻&lt;/a&gt;&lt;/li&gt;\r\n&lt;li class=&quot;m&quot;&gt;&lt;a class=&quot;m&quot; href=&quot;#anchor7&quot;&gt;客户介绍&lt;/a&gt;&lt;/li&gt;\r\n&lt;li class=&quot;m&quot;&gt;&lt;a class=&quot;m&quot; href=&quot;#anchor8&quot;&gt;联系我们&lt;/a&gt;&lt;/li&gt;\r\n&lt;/ul&gt;', NULL),
(283, 'menu20161129_1804453928', '0', 'smenu20180801_1832569361', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'cate20160410_0658287350', NULL, NULL, 'n', 50, 'n', NULL, NULL),
(242, 'menu20161129_1804453928', '0', 'smenu20180508_1455556398', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20160307_1115284044', NULL, '', 'n', 500, 'n', NULL, NULL),
(245, 'menu20161129_1804453928', '0', 'smenu20180525_2101414003', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20150806_0436437668', NULL, NULL, 'n', 0, 'n', NULL, NULL),
(365, 'menu20161129_1804453928', 'smenu20170510_1715538289', 'smenu20181214_1231422774', 'bh2010079002demososo', 'cn', '产品中心页面', NULL, NULL, 'y', 'cusm20181214_1231422774', 'products.html', NULL, 'n', 50, 'n', NULL, ''),
(375, 'menu20161129_1804453928', 'smenu20190410_1040131770', 'smenu20190410_1040433782', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20190311_1431198444', NULL, NULL, 'n', 22, 'n', NULL, NULL),
(368, 'menu20161129_1804453928', 'smenu20150806_0435579851', 'smenu20190215_1132499642', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20181217_1728381650', NULL, NULL, 'n', 50, 'n', NULL, NULL),
(370, 'menu20161129_1804453928', '0', 'smenu20190410_1040131770', 'bh2010079002demososo', 'cn', '特色页面', NULL, NULL, 'y', 'cusm20190410_1040131770', 'page-179.html', NULL, 'n', 99, 'n', NULL, ''),
(371, 'menu20161129_1804453928', 'smenu20190410_1040131770', 'smenu20190410_1040224080', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20190401_1835494002', NULL, NULL, 'n', 50, 'n', NULL, NULL),
(372, 'menu20161129_1804453928', 'smenu20190410_1040131770', 'smenu20190410_1040277885', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20190401_1835598959', NULL, NULL, 'n', 33, 'n', NULL, NULL),
(373, 'menu20161129_1804453928', 'smenu20190410_1040131770', 'smenu20190410_1040328442', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20190401_1836112105', NULL, NULL, 'n', 50, 'n', NULL, NULL),
(374, 'menu20161129_1804453928', 'smenu20190410_1040131770', 'smenu20190410_1040392617', 'bh2010079002demososo', 'cn', NULL, NULL, NULL, 'y', 'page20190227_1749231026', NULL, NULL, 'n', 22, 'n', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_music`
--

CREATE TABLE `zzz_music` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `pidname` varchar(100) NOT NULL,
  `pbh` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `title` varchar(100) DEFAULT NULL,
  `cssname` varchar(100) DEFAULT NULL,
  `kvsm` varchar(50) DEFAULT NULL,
  `kv` varchar(100) NOT NULL COMMENT 'music upload',
  `kvlink` varchar(250) NOT NULL COMMENT 'music link',
  `pos` int(3) DEFAULT '50',
  `cus_columns` int(3) NOT NULL DEFAULT '3',
  `sta_visible` char(1) NOT NULL DEFAULT 'y',
  `size` int(5) DEFAULT NULL,
  `effect` varchar(100) DEFAULT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'block',
  `dateedit` datetime DEFAULT NULL,
  `desp` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_music`
--

INSERT INTO `zzz_music` (`id`, `pid`, `pidname`, `pbh`, `lang`, `title`, `cssname`, `kvsm`, `kv`, `kvlink`, `pos`, `cus_columns`, `sta_visible`, `size`, `effect`, `type`, `dateedit`, `desp`) VALUES
(40, 'music20190404_1604241057', 'smusic20190404_172234', 'bh2010079002demososo', 'cn', 'asdfasdf', NULL, NULL, '', 'asdfasdf', 50, 3, 'y', 0, NULL, '', NULL, NULL),
(33, 'music20190404_1604241057', 'smusic20190404_161715', 'bh2010079002demososo', 'cn', '333322333', NULL, NULL, '', 'http://dream.demososo.com/music.mp3', 50, 3, 'y', 0, NULL, '', NULL, NULL),
(30, 'common', 'music20190404_1604241057', 'bh2010079002demososo', 'cn', '55rr', 'd', NULL, '', '', 50, 3, 'y', NULL, 'music.php', 'block', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_node`
--

CREATE TABLE `zzz_node` (
  `id` int(11) NOT NULL,
  `pid` text,
  `ppid` varchar(50) NOT NULL,
  `pidmulti` text NOT NULL,
  `pidname` varchar(50) NOT NULL,
  `pbh` varchar(50) NOT NULL,
  `pbrand` varchar(50) DEFAULT NULL,
  `lang` varchar(50) NOT NULL DEFAULT 'cn',
  `pos` int(3) DEFAULT '50',
  `modtype` varchar(50) NOT NULL DEFAULT 'node' COMMENT 'node or blockdh',
  `hit` int(5) NOT NULL DEFAULT '10',
  `sta_search` char(1) NOT NULL DEFAULT 'y' COMMENT 'for search in frontend',
  `sta_visible` char(1) DEFAULT 'y',
  `sta_noaccess` char(1) NOT NULL DEFAULT 'n',
  `sta_tj` char(1) NOT NULL DEFAULT 'n',
  `sta_new` char(1) NOT NULL DEFAULT 'n',
  `sta_orignimg` char(1) NOT NULL DEFAULT 'n',
  `title` varchar(150) DEFAULT NULL,
  `titlestyle` varchar(100) DEFAULT NULL,
  `kv` varchar(220) DEFAULT NULL,
  `kvsm` varchar(220) DEFAULT NULL,
  `kvsm2` varchar(220) DEFAULT NULL,
  `alias_jump` varchar(100) DEFAULT NULL,
  `despjj` text,
  `desp` text,
  `desptext` text,
  `arr_can` text,
  `detpriceold` float NOT NULL DEFAULT '0',
  `detprice` float NOT NULL DEFAULT '0',
  `stock` int(3) NOT NULL DEFAULT '10000',
  `sku` varchar(100) NOT NULL,
  `dateedit` datetime DEFAULT NULL,
  `seo1` text,
  `seo2` text,
  `seo3` text,
  `videoid` text,
  `albumid` text,
  `musicid` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_node`
--

INSERT INTO `zzz_node` (`id`, `pid`, `ppid`, `pidmulti`, `pidname`, `pbh`, `pbrand`, `lang`, `pos`, `modtype`, `hit`, `sta_search`, `sta_visible`, `sta_noaccess`, `sta_tj`, `sta_new`, `sta_orignimg`, `title`, `titlestyle`, `kv`, `kvsm`, `kvsm2`, `alias_jump`, `despjj`, `desp`, `desptext`, `arr_can`, `detpriceold`, `detprice`, `stock`, `sku`, `dateedit`, `seo1`, `seo2`, `seo3`, `videoid`, `albumid`, `musicid`) VALUES
(1, 'csub20150805_1127279495', 'cate20150805_1125344029', '', 'node20150806_0900535131', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 15, 'y', 'y', 'n', 'n', 'n', 'n', 'LED50EC310JD 50英寸 全网Vision 智能LED电视', NULL, '20150806_090145_7218.jpg', '20160820_063033_9478.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(2, 'csub20150805_1129113039', 'cate20150805_1125344029', '', 'node20150806_0911442628', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 50, 'y', 'y', 'n', 'n', 'y', 'n', '幻影白 移动联通4G手机 双卡双待', NULL, '20160820_065418_4988.jpg', '20160820_065425_3224.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(3, 'csub20150805_1128542682', 'cate20150805_1125344029', '', 'node20150806_0913071844', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 51, 'y', 'y', 'n', 'y', 'n', 'n', '移动联通电信4G手机 双卡双待', NULL, '20160820_065158_9420.jpg', '20160820_065151_8351.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(4, 'csub20150805_1129022677', 'cate20150805_1125344029', '', 'node20150806_0914588863', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 17, 'y', 'y', 'n', 'y', 'n', 'n', '移动联通电信4G手机 双卡双待 香槟金', NULL, '20160820_064911_2203.jpg', '20160820_064917_6826.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(252, 'csub20150805_1129113039', 'cate20150805_1125344029', '', 'node20160820_0656309862', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 129, 'y', 'y', 'n', 'n', 'y', 'n', '黑色 移动联通电信4G手机 双卡双待', NULL, '', '20160820_065655_3605.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'author:##==#==authorcompany:##==#==detlinktitle:##苏宁天猫==#==detlinkurl:##https://detail.tmall.com/item.htm?id=579794586729==#==downloadurl:##==#==linkmore:##==#==nodekvshow:##y==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 55, 33.33, 10000, '', '2016-08-20 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(5, 'csub20150805_1128542682', 'cate20150805_1125344029', '', 'node20150806_0916371045', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 62, 'y', 'y', 'n', 'n', 'n', 'n', '手机（白色）WCDMA/GSM hua2', '', '20150806_091718_2691.jpg', '20160820_064151_2910.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-16 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(6, 'csub20150805_1129022677', 'cate20150805_1125344029', '', 'node20150806_0918325701', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 52, 'y', 'y', 'n', 'y', 'n', 'n', '手机（炫酷银）WCDMA/GSM', NULL, '20150806_091923_3218.jpg', '20160820_064047_5245.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'author:##==#==authorcompany:##asfas==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==linkmore:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(7, 'csub20150805_1129113039', 'cate20150805_1125344029', '', 'node20150806_0920002293', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 36, 'y', 'y', 'n', 'n', 'y', 'n', '16G版 3G手机（金色）WCDMA/GSM', NULL, '20150806_092048_7826.jpg', '20160820_064001_4739.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(8, 'csub20150805_1129113039', 'cate20150805_1125344029', '', 'node20150806_0921189784', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 59, 'y', 'y', 'n', 'n', 'n', 'n', '手机（白色） CDMA2000/WCDMA/GSM 32G版', NULL, '20150806_092204_7023.jpg', '20160820_063852_9745.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(9, 'csub20150805_1127279495', 'cate20150805_1125344029', '', 'node20150806_0924473423', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 38, 'y', 'y', 'n', 'n', 'n', 'n', '50E6CRD 50英寸 窄边超薄 超级网络解码3DLED电视', NULL, '20150806_092545_1198.jpg', '20160820_063746_5055.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'author:##==#==authorcompany:##==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==linkmore:##==#==nodekvshow:##y==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 0, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(10, 'csub20150805_1127279495', 'cate20150805_1125344029', '', 'node20150806_0925599652', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 36, 'y', 'y', 'n', 'n', 'n', 'n', '39EU3000 39英寸 窄边框流媒体全高清LED电视', NULL, '20150806_092643_9470.jpg', '20160820_063313_9504.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(11, 'csub20150805_1127279495', 'cate20150805_1125344029', '', 'node20150806_0926593475', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 99, 'y', 'y', 'n', 'n', 'n', 'n', 'LE50D59 50英寸 超窄边内置WIFI安卓智能液晶电视', NULL, '20150806_092746_9245.jpg', '20160820_063146_7484.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;br /&gt;\r\n&amp;nbsp;&lt;/p&gt;', '', 'author:##==#==authorcompany:##==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==linkmore:##==#==nodekvshow:##y==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 66.33, 55.22, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(12, 'csub20150805_1127429915', 'cate20150805_1125344029', '', 'node20150806_0928223823', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 66, 'y', 'y', 'n', 'n', 'y', 'n', '14.0英寸笔记本电脑14.0英寸笔记本电脑', NULL, '20150806_092914_1276.jpg', '20160820_062914_8463.jpg', NULL, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;', '', 'author:##==#==authorcompany:##==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==linkmore:##==#==nodekvshow:##y==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 25.33, 15.26, 0, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(13, 'csub20150805_1127429915', 'cate20150805_1125344029', '', 'node20150806_0929404264', 'bh2010079002demososo', NULL, 'cn', 60, 'node', 981, 'y', 'y', 'n', 'y', 'n', 'n', '17.3英寸游戏本17.3英寸游戏本', 'color:red', '20150806_093046_2423.jpg', '20160820_065945_9561.jpg', '', '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt;是由php+mysql开发的一套专门用于中小企业网站建设的开源cms。&lt;br /&gt;\r\n可以用来快速建设一个响应式的企业网站( PC，手机，微信都可以访问)。后台操作简单，维护方便。&lt;br /&gt;\r\n系统主要特点：&lt;br /&gt;\r\n1、模板管理功能，下载后，会有多个模板可选择。&lt;br /&gt;\r\n2、可以给每个页面设置SEO关键字，有利于搜索引擎收录。可以给每个页面设置别名，从而是让网页的访问网址更加简洁。&lt;br /&gt;\r\n3、后台有布局功能。让页面呈现更加方便。&lt;br /&gt;\r\n4、丰富的区块效果&lt;br /&gt;\r\n5、通过前台编辑，直接链接到后台。&lt;/p&gt;\r\n\r\n&lt;p&gt;安装步骤：&lt;br /&gt;\r\n第一步，先用phpmyadmin导入sql文件。&lt;br /&gt;\r\n创建一个库，名字随便。格式选 tf8_general_ci。&lt;br /&gt;\r\n第二步：把文件放到你的本地服务器，或上传到空间。&lt;br /&gt;\r\n网站只有一个入口文件 ，即index.php&lt;br /&gt;\r\n然后修改在component/demososo_cfg 下的mysql.php&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20180315_123721_1520.jpg&quot; style=&quot;height:421px; width:561px&quot; /&gt;&lt;/p&gt;', '', 'author:##==#==authorcompany:##==#==detlinktitle:##京东==#==detlinkurl:##https://item.jd.com/7435156.html==#==downloadurl:##==#==linkmore:##==#==nodekvshow:##y==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 1000, 800, 0, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(14, 'csub20160603_1044113807', 'cate20150805_1133251007', '', 'node20150806_0933549151', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 22, 'y', 'y', 'n', 'n', 'n', 'n', '26+25悍将休赛期苦练 誓言夺最佳防守球员奖', NULL, NULL, '20160603_104520_1688.jpg', NULL, NULL, '', '&lt;p&gt;26+25悍将休赛期苦练 誓言夺最佳防守球员奖&lt;/p&gt;\r\n\r\n&lt;p&gt;26+25悍将休赛期苦练 誓言夺最佳防守球员奖&lt;/p&gt;\r\n\r\n&lt;p&gt;26+25悍将休赛期苦练 誓言夺最佳防守球员奖26+25悍将休赛期苦练 誓言夺最佳防守球员奖&lt;/p&gt;\r\n\r\n&lt;p&gt;26+25悍将休赛期苦练 誓言夺最佳防守球员奖&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;26+25悍将休赛期苦练 誓言夺最佳防守球员奖&lt;/p&gt;\r\n\r\n&lt;p&gt;26+25悍将休赛期苦练 誓言夺最佳防守球员奖26+25悍将休赛期苦练 誓言夺最佳防守球员奖&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(16, 'csub20150805_1133441588', 'cate20150805_1133251007', '', 'node20150806_0934538110', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 11, 'y', 'y', 'n', 'n', 'n', 'n', '奥迪杯-贝尔反戈J罗破门 皇马2-0热刺晋级决赛', NULL, NULL, NULL, NULL, NULL, '', '&lt;p&gt;奥迪杯-贝尔反戈J罗破门 皇马2-0热刺晋级决赛&lt;/p&gt;\r\n\r\n&lt;p&gt;奥迪杯-贝尔反戈J罗破门 皇马2-0热刺晋级决赛&lt;/p&gt;\r\n\r\n&lt;p&gt;奥迪杯-贝尔反戈J罗破门 皇马2-0热刺晋级决赛&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;奥迪杯-贝尔反戈J罗破门 皇马2-0热刺晋级决赛奥迪杯-贝尔反戈J罗破门 皇马2-0热刺晋级决赛&lt;/p&gt;\r\n\r\n&lt;p&gt;奥迪杯-贝尔反戈J罗破门 皇马2-0热刺晋级决赛&lt;/p&gt;\r\n\r\n&lt;p&gt;奥迪杯-贝尔反戈J罗破门 皇马2-0热刺晋级决赛&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(17, 'csub20150805_1133512388', 'cate20150805_1133251007', '', 'node20150806_0935224419', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 18, 'y', 'y', 'n', 'n', 'n', 'n', 'FIBA竞赛部主任：中国举办世界杯成功率达90%', NULL, NULL, NULL, NULL, NULL, '', '&lt;p&gt;FIBA竞赛部主任：中国举办世界杯成功率达90%&lt;/p&gt;\r\n\r\n&lt;p&gt;FIBA竞赛部主任：中国举办世界杯成功率达90%FIBA竞赛部主任：中国举办世界杯成功率达90%&lt;/p&gt;\r\n\r\n&lt;p&gt;FIBA竞赛部主任：中国举办世界杯成功率达90%&lt;/p&gt;\r\n\r\n&lt;p&gt;FIBA竞赛部主任：中国举办世界杯成功率达90%&lt;/p&gt;\r\n\r\n&lt;p&gt;FIBA竞赛部主任：中国举办世界杯成功率达90%&lt;/p&gt;\r\n\r\n&lt;p&gt;FIBA竞赛部主任：中国举办世界杯成功率达90%FIBA竞赛部主任：中国举办世界杯成功率达90%&lt;/p&gt;\r\n\r\n&lt;p&gt;FIBA竞赛部主任：中国举办世界杯成功率达90%&lt;/p&gt;\r\n\r\n&lt;p&gt;FIBA竞赛部主任：中国举办世界杯成功率达90%&lt;/p&gt;\r\n\r\n&lt;p&gt;FIBA竞赛部主任：中国举办世界杯成功率达90%&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(18, 'csub20160603_1044113807', 'cate20150805_1133251007', '', 'node20150806_0935506630', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 10, 'y', 'y', 'n', 'n', 'n', 'n', 'NBA球星隆多畅谈“控卫经” 称日后或将来华征战', NULL, NULL, NULL, NULL, NULL, '', '&lt;p&gt;NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA球星隆多畅谈&amp;ldquo;控卫经&amp;rdquo; 称日后或将来华征战&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-08-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(19, 'csub20150805_1133597884', 'cate20150805_1133251007', '', 'node20150806_0936553528', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 10, 'y', 'y', 'n', 'n', 'n', 'n', '揭秘北京申冬奥宣传片 拍摄姚明成最大挑战', NULL, NULL, NULL, NULL, NULL, '', '&lt;p&gt;揭秘北京申冬奥宣传片 拍摄姚明成最大挑战&lt;/p&gt;\r\n\r\n&lt;p&gt;揭秘北京申冬奥宣传片 拍摄姚明成最大挑战揭秘北京申冬奥宣传片 拍摄姚明成最大挑战&lt;/p&gt;\r\n\r\n&lt;p&gt;揭秘北京申冬奥宣传片 拍摄姚明成最大挑战&lt;/p&gt;\r\n\r\n&lt;p&gt;揭秘北京申冬奥宣传片 拍摄姚明成最大挑战&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;揭秘北京申冬奥宣传片 拍摄姚明成最大挑战揭秘北京申冬奥宣传片 拍摄姚明成最大挑战&lt;/p&gt;\r\n\r\n&lt;p&gt;揭秘北京申冬奥宣传片 拍摄姚明成最大挑战&lt;/p&gt;\r\n\r\n&lt;p&gt;揭秘北京申冬奥宣传片 拍摄姚明成最大挑战揭秘北京申冬奥宣传片 拍摄姚明成最大挑战&lt;/p&gt;\r\n\r\n&lt;p&gt;揭秘北京申冬奥宣传片 拍摄姚明成最大挑战&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-10-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(20, 'csub20150805_1133597884', 'cate20150805_1133251007', '', 'node20150806_0952354404', 'bh2010079002demososo', NULL, 'cn', 0, 'node', 15, 'y', 'y', 'n', 'n', 'n', 'n', 'NBA选秀改革双方向，老三届成绝响', NULL, '20150806_095329_7264.jpg', '20160406_094240_1253.jpg', NULL, NULL, '当然，你也可以这里输入一些简短的文字描述。。。当然，你也可以这里输入一些简短的文字描述。。。<br />\n333<br />\n4444', '&lt;p&gt;NBA选秀改革双方向，老三届成绝响NBA选秀改革双方向，老三届成绝响&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA选秀改革双方向，老三届成绝响NBA选秀改革双方向，老三届成绝响&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA选秀改革双方向，老三届成绝响NBA选秀改革双方向，老三届成绝响&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA选秀改革双方向，老三届成绝响&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA选秀改革双方向，老三届成绝响NBA选秀改革双方向，老三届成绝响&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA选秀改革双方向，老三届成绝响NBA选秀改革双方向，老三届成绝响&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA选秀改革双方向，老三届成绝响&lt;/p&gt;\r\n\r\n&lt;p&gt;NBA选秀改革双方向，老三届成绝响NBA选秀改革双方向，老三届成绝响NBA选秀改革双方向，老三届成绝响&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2015-12-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(61, 'csub20150805_1133441588', 'cate20150805_1133251007', '', 'node20160406_0915262737', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 14, 'y', 'y', 'n', 'n', 'n', 'n', '曝穆帅受够了！逼曼联签约 他不想被范加尔耍', NULL, NULL, NULL, NULL, NULL, '', '&lt;p&gt;范加尔和穆里尼奥这对昔日师徒，如今正在同时竞争曼联的帅位。早前曼联战绩不佳时，穆里尼奥入主的呼声甚高。而近来红魔战绩好转，弗格森更是公开表态支持范加尔，这让穆里尼奥有些坐不住了。据《太阳报》报道，穆帅希望能与曼联签订一份书面协议，确保自己在今夏成为曼联主帅，而不是这样没有尽头的等待下去。&lt;/p&gt;\r\n\r\n&lt;p&gt;穆里尼奥的心急完全是在情理之中的。曼联近来取得连胜，联赛积分榜上已经只差第4名的曼城1分，红魔很有希望拿到下赛季的欧冠资格，而这也是曼联给范加尔定下的最低要求，一旦他能够完成任务，就大有希望保住帅位。另一方面，曼联功勋主帅弗格森在最近接受采访时也公开表示：&amp;ldquo;曼联需要对范加尔保持耐心，他在提拔青训球员上做的非常好，我认为曼联的未来充满希望。&amp;rdquo;弗格森的发言也被看作是曼联高层仍然信任范加尔的一个标志。&lt;/p&gt;\r\n\r\n&lt;p&gt;而来自荷兰《电讯报》的最新消息称，曼联高层已经向范加尔做出了保证，俱乐部会在今夏留任他，完成最后一年的合同。这对于一直想要拿下曼联帅位的穆里尼奥来说，无疑不是一个好消息。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(62, 'csub20150805_1133441588', 'cate20150805_1133251007', '', 'node20160406_0916127154', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 65, 'y', 'y', 'n', 'y', 'n', 'n', '他们回来了！昔日欧洲劲旅4年后重返顶级联赛', NULL, '20160406_091658_4796.jpg', '20160406_094131_6337.jpg', NULL, NULL, '', '&lt;p&gt;在苏格兰冠军联赛第32轮的一场比赛中，流浪者FC主场1-0击败邓巴顿，提前锁定联赛冠军，下赛季他们将征战苏格兰超级联赛，而他们曾经有个响亮无比的名字&amp;mdash;&amp;mdash;格拉斯哥流浪者，在经过4年的努力后，他们在遭受处罚被降入苏格兰乙级联赛后重新回到了顶级联赛。&lt;/p&gt;\r\n\r\n&lt;p&gt;本场比赛流浪者FC坐镇主场迎战倒数第三的邓巴顿，只要获胜就可以提前4轮锁定冠军，而想要直接升入苏超必须夺得冠军，否则还可能通过附加赛才能冲超，上赛季流浪者FC就是在升级附加赛决赛中输给了马瑟韦尔，重返顶级联赛的步伐晚了一年。&lt;/p&gt;\r\n\r\n&lt;p&gt;第50分钟，塔弗尼尔打进了制胜球，流浪者FC全取三分，积分达到79分，而第二名的福尔柯克和第三名的希伯尼安即使全胜也分别只能得到74分和77分，流浪者FC已经将联赛冠军揽入怀中，在时隔4年后即将重新踏上苏超的赛场。&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\n昔日的格拉斯哥流浪者是苏格兰最顶级的强队，也是欧洲顶级的强队，他们拥有54个苏格兰顶级联赛冠军、33个苏格兰杯冠军、27个苏格兰联赛杯冠军，1971-72赛季他们还夺得了欧洲优胜者杯冠军，但他们在2012年由于破产被降入了第四级别联赛，并以流浪者FC的名字进行重组。2012-13赛季和2013-14赛季，流浪者FC分别夺得了苏乙和苏甲的冠军，在上赛季升级失败后，流浪者FC重振旗鼓，再又一个赛季的努力后，他们终于圆梦。&lt;/p&gt;\r\n\r\n&lt;p&gt;格拉斯哥流浪者和凯尔特人瓜分了苏格兰顶级联赛的大部分冠军，而在格拉斯哥流浪者不在苏超的这几个赛季，凯尔特人已经是完成了苏超三连冠，领先优势分别是16分、29分、17分，本赛季在还剩4轮的情况下凯尔特人领先第二名阿伯丁也还有5分。格拉斯哥流浪者和凯尔特人的比赛是世界足坛著名的&amp;ldquo;老字号德比&amp;rdquo;，比赛激烈程度超乎想象，随着流浪者FC重返顶级联赛，&amp;ldquo;老字号德比&amp;rdquo;也将开启新的篇章。&lt;/p&gt;', '', 'author:##==#==authorcompany:##==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==linkmore:##==#==nodekvshow:##y==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(64, 'csub20150805_1133512388', 'cate20150805_1133251007', '', 'node20160406_0919389503', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 60, 'y', 'y', 'n', 'n', 'n', 'n', '国米动手!和中超抢曼城天王 年薪500万PK2500万', NULL, NULL, NULL, NULL, NULL, '', '&lt;p&gt;亚亚-图雷的经纪人已经亲口承认，球员在赛季结束后将会铁定离开曼城，而国米也准备出手把这位中场大将收入阵中，但是蓝黑军团要面对与中超球队的竞争。&lt;/p&gt;\r\n\r\n&lt;p&gt;昨天，亚亚-图雷的经纪人在接受采访时称：&amp;ldquo;图雷肯定会离开曼城，我们收到了各个球队的offer，现在需要进行一下选择。钱会是最重要的因素吗？绝对不是！再多的钱，也不能与俱乐部所展现出来的雄心和未来计划相比，对我们来说最好的就是最能说服我们的。国米？所有人都知道图雷与曼奇尼的关系，国米的未来计划也非常诱人，但我们还没有做出决定。&amp;rdquo;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\n为了得到科特迪瓦大将，国米加紧了行动。根据《罗马体育报》的报道，国米为图雷已经准备好了一份合同，算上肖像权、奖金等，图雷的年薪将会达到500万欧元，合同期为两年，若达到一定出场数字，会触发延长一年的条款。500万的年薪比起图雷目前在曼城拿到的1000万来说显然是低了不少，但是这在意甲已经是较高的薪资水平了，尤文的法国天王博格巴目前只拿了450万的年薪，而意甲顶薪德罗西不过拿着650万欧元，在国米队内500万也绝对是第一高薪了。&lt;/p&gt;\r\n\r\n&lt;p&gt;但是这样的待遇能否打动图雷还不好说，因为国米要面对与中超球队的竞争。上个月就有英国媒体称上海上港曾经重金邀请图雷加盟，而他的经纪人也透露，江苏苏宁给他开出了2000万英镑（约合2500万欧元）的天价年薪：&amp;ldquo;我们拒绝了一家中超俱乐部，就是买下拉米雷斯的那支球队，他们开出的报价比给拉米雷斯的还高，但我们现在不想去那里。&amp;rdquo;按照图雷经纪人的说法，球员现在不会考虑金钱，而是要力求在高水平的联赛中效力。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(65, 'csub20150805_1133512388', 'cate20150805_1133251007', '', 'node20160406_0920373622', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 19, 'y', 'y', 'n', 'n', 'n', 'n', '国米未来还有大咖！马竞铁帅亲承早晚回来执教', NULL, NULL, NULL, NULL, NULL, '', '&lt;p&gt;马竞主教练西蒙尼也是近几年世界足坛崛起的少帅，不少豪门球队都想邀请这位极具个性的天才执教。西蒙尼在近期接受采访的时候还坦言称自己希望未来能够回到国际米兰执教。&lt;/p&gt;\r\n\r\n&lt;p&gt;带领马竞在西甲打破皇马巴萨的垄断让西蒙尼声名鹊起，他的铁血属性、执教能力和带队能力让众多豪门眼红。在切尔西确定孔蒂为新任主帅之前，就有传言称蓝军想请西蒙尼出任球队主帅。还有媒体称阿森纳希望西蒙尼能接班温格带领枪手重夺冠军。&lt;/p&gt;\r\n\r\n&lt;p&gt;但是以西蒙尼本人的意愿，目前还没有离开马德里竞技的打算，但他透露，自己希望未来能够执教国际米兰：&amp;ldquo;在我的职业生涯中，有许多地点是我非常渴望要去的，所以我希望未来能够回到米兰。当然不是马上，因为我目前在马竞状况很好。这只是我对未来的一种构想，就像当初我计划回到马德里一样。&amp;rdquo;&lt;/p&gt;\r\n\r\n&lt;p&gt;球员时代，西蒙尼在意甲踢过6年，加盟拉齐奥之前他于1997-1999年之间的两个赛季在国米效力，共为球队打进11球，还帮助蓝黑军团在1998年拿到了欧洲联盟杯的冠军。随后在拉齐奥他又随队获得了意甲冠军、意大利杯冠军和意大利超级杯的冠军。&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(66, 'csub20150805_1133512388', 'cate20150805_1133251007', '', 'node20160406_0925136757', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 25, 'y', 'y', 'n', 'y', 'n', 'n', '马刺险胜爵士义助火箭 威少三双雷霆轻取掘金', NULL, '20160406_092545_4473.jpg', '20160406_094221_3130.jpg', NULL, NULL, '', '&lt;p&gt;马刺（65-12）惊险过关，取得四连胜。考瓦伊-莱昂纳德在终场前4.9秒投中制胜一球，全场贡献18分8个篮板，拉马库斯-阿尔德里奇[微博]14分7个篮板，托尼-帕克11分4次助攻，蒂姆-邓肯3分。替补出场的凯尔-安德森11分，马努-吉诺比利14分。&lt;/p&gt;\r\n\r\n&lt;p&gt;爵士（39-39）二连胜结束，仍居西部第八，但优势不大。罗德尼-胡德23分7个篮板，谢尔文-马克13分，戈登-海沃德12分，鲁迪-戈伯特4分10个篮板。替补出场的乔-因格尔斯13分。&lt;/p&gt;\r\n\r\n&lt;p&gt;前三节马刺以67-53领先，但在最后一节遭到爵士的顽强反击，几乎被翻盘。&lt;/p&gt;\r\n\r\n&lt;p&gt;比赛还有1分59秒时，安德森命中三分，马刺以83-80再度领先。胡德连续两次中投命中，爵士以84-83反超。&lt;/p&gt;\r\n\r\n&lt;p&gt;帕克命中一记三分后，在比赛还有27.7秒时，海沃德禁区内转身投篮命中，双方战成86-86。&lt;/p&gt;\r\n\r\n&lt;p&gt;帕克此后的投篮遭到盖帽，但马刺拥有球权，比赛还有4.9秒时莱昂纳德接安德森传球，中投命中，马刺以88-86领先。爵士还有机会，但胡德最后时刻三分不中。&lt;/p&gt;\r\n\r\n&lt;p&gt;此役过后，爵士仍居西部第八，但只领先火箭0.5场。火箭有平局优势，他们只要剩下的比赛全部胜出，就能取得季后赛门票，已经可以掌控自己的命运。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(67, 'csub20150805_1133512388', 'cate20150805_1133251007', '', 'node20160406_0926069724', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 17, 'y', 'y', 'n', 'n', 'n', 'n', '观点:鲁能阵中找不到“尖刀”那就必须“换刀”', NULL, NULL, NULL, NULL, NULL, '', '&lt;p&gt;主队大举压上，本来应该是客队难得的反击良机。尤其是在场上比分持平的情况下，只需要一次成功的快速反击，就能够终结比赛的悬念，甚至上演一场逆袭的好戏。&lt;/p&gt;\r\n\r\n&lt;p&gt;这样的好戏，在2016赛季的中超联赛中就已经上演过不止一次。中超首轮比赛中，重庆力帆队的&amp;ldquo;小摩托&amp;rdquo;费尔南多快速反击弄得广州恒大队一众大牌无功而返。在上周的联赛中，&amp;ldquo;小摩托&amp;rdquo;在比赛最后阶段的一次犀利反击，又让同样拥有一众大牌的上海上港队到手的三分变一分。&lt;/p&gt;\r\n\r\n&lt;p&gt;看了好戏过眼瘾之余，不禁的想、不由得问，鲁能泰山队的&amp;ldquo;好戏&amp;rdquo;，究竟何时能够上演？&lt;/p&gt;\r\n\r\n&lt;p&gt;实际上讲，这是一个相当尴尬的话题。当2015赛季失去瓦格纳。洛维之后，鲁能泰山队的阵容中，无论是蒙蒂略、阿洛伊西奥还是当做&amp;ldquo;洛维替代者&amp;rdquo;加盟的塔尔德利，都无法担当起上演类似&amp;ldquo;好戏&amp;rdquo;的重任。&lt;/p&gt;\r\n\r\n&lt;p&gt;在本场比赛中，首发阵容里的吴兴涵，可以看做是曼诺准备好在合适时候捅FC首尔的一把&amp;ldquo;小刀&amp;rdquo;，而塔尔德利则是光明正大摆在外面充当&amp;ldquo;尖刀&amp;rdquo;的角色。毕竟，顶着&amp;ldquo;巴西9号&amp;rdquo;名头的塔尔德利且不论战斗力如何，摆出来还总是能吓唬吓唬对手的。&lt;/p&gt;\r\n\r\n&lt;p&gt;FC首尔队并没有对塔尔德利有丝毫的轻视，在全场比赛中，拿球时能够享受三人逼抢的鲁能泰山队员只有蒙蒂略和塔尔德利。可以说，FC首尔在本场比赛中对蒙蒂略和塔尔德利的限制是成功的。蒙蒂略的进攻，大多在拿球之后尚未传球之时就被FC首尔队的贴身逼抢破坏。而塔尔德利拿球之后试图发动的进攻，几乎全被终结在萌芽状态。甚至说，不知这两名外援，鲁能泰山队的另一名中场核心蒿俊闵在本场比赛中也因为被FC首尔的防守球员重点照顾而几乎隐形。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(68, 'csub20150805_1133512388', 'cate20150805_1133251007', '', 'node20160406_0927195094', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 40, 'y', 'y', 'n', 'y', 'n', 'n', '14中5却无碍这4.9秒的绝杀 邓肯眼看着他长大', '', '20160406_092740_2483.jpg', '20160406_094157_4368.jpg', NULL, '', '北京时间4月6日，圣安东尼奥马刺在客场以88-86战胜犹他爵士。马刺核心考瓦伊-莱昂纳德出场38分钟，14投5中得到18分。第四节最后4.9秒时，莱昂纳德命中了一个制胜的中距离跳投。&lt;br /&gt;\r\n当初选秀大会上用乔治-希尔[微博]换来莱昂纳德时，可能连马刺队自己都没有想到莱昂纳德会有那么好的发展。', '&lt;p&gt;北京时间4月6日，圣安东尼奥马刺在客场以88-86战胜犹他爵士。马刺核心考瓦伊-莱昂纳德出场38分钟，14投5中得到18分。第四节最后4.9秒时，莱昂纳德命中了一个制胜的中距离跳投。&lt;/p&gt;\r\n\r\n&lt;p&gt;当初选秀大会上用乔治-希尔[微博]换来莱昂纳德时，可能连马刺队自己都没有想到莱昂纳德会有那么好的发展。&lt;/p&gt;\r\n\r\n&lt;p&gt;起初，莱昂纳德只是被视为一名防守型球员，但是过去两年里，他先后成为总决赛MVP和最佳防守球员，并成为当今NBA攻守最全面的球员之一。本赛季，莱昂纳德已经是马刺当之无愧的核心球员，他场均得到21.1分、6.8个篮板和2.6次助攻，外加1.8次抢断，投篮命中率和三分球命中率分别达到51%和45.7%。如今的莱昂纳德在进攻端打得非常高效，防守端则是更加沉稳老练。&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\n根据BR网的统计结果显示：考瓦伊成为本赛季常规赛MVP的概率排进了联盟前四，甚至超过了詹姆斯。&lt;/p&gt;\r\n\r\n&lt;p&gt;今天面对防守强悍的爵士，马刺的进攻打得并不顺利，考瓦伊的投篮手感也不是很好。全场比赛，他14投仅5中。不过在第二节，莱昂纳德得到了马刺全队17分里面的8分，他在那一节6投2中，5罚4中，使得马刺在上半场结束时依然领先对手。&lt;/p&gt;\r\n\r\n&lt;p&gt;下半场，两队各打了一节好球，而马刺在第四节被爵士打了一波33-21。最后还剩27秒时，海沃德的转身跳投将双方比分打成86平。此后马刺的一次进攻，帕克的上篮被戈伯特帽掉。关键时刻，考瓦伊展现出了杀手本色，他在最后4.9秒时命中一个中距离跳投，并帮助马刺在客场涉险过关。&lt;/p&gt;\r\n\r\n&lt;p&gt;凭借着考瓦伊的准绝杀，蒂姆-邓肯迎来了个人职业生涯的第1000场胜利。可以说，邓肯是亲眼看着莱昂纳德在很短的时间内成为联盟的顶级球星，现在，他已经可以非常放心地把马刺队交到考瓦伊的手里。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(69, 'csub20150805_1133597884', 'cate20150805_1133251007', '', 'node20160406_0928025393', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 23, 'y', 'y', 'n', 'n', 'n', 'n', '洛城新王的尴尬!25+4+8他赢了比赛赢不了人心', NULL, NULL, NULL, NULL, NULL, '快船与湖人同处一座球场，但正所谓“一山不容二虎”，两支球队虽然近况不同，实力存在差距，仍然会刺刀见红，擦出火花。而保罗与湖人队也颇有渊源。2011年，保罗险些被黄蜂交易到湖人，这笔交易最终被NBA总裁斯特恩否决。今天的比赛中，面对“同城死敌”，快船队没有心慈手软，他们仅用三节就打垮了湖人队。', '&lt;p&gt;快船与湖人同处一座球场，但正所谓&amp;ldquo;一山不容二虎&amp;rdquo;，两支球队虽然近况不同，实力存在差距，仍然会刺刀见红，擦出火花。而保罗与湖人队也颇有渊源。2011年，保罗险些被黄蜂交易到湖人，这笔交易最终被NBA总裁斯特恩否决。今天的比赛中，面对&amp;ldquo;同城死敌&amp;rdquo;，快船队没有心慈手软，他们仅用三节就打垮了湖人队。&lt;/p&gt;\r\n\r\n&lt;p&gt;快船队当家控卫克里斯保罗显现出全明星后卫的气质。首节保罗里突外投，屡屡命中高难度投篮；此外，保罗犀利的传球如手术刀一般撕破了湖人队的防线，首节保罗多次连线小乔丹，助攻后者完成空接暴扣。在保罗的带领下，快船队打出了20比2的梦幻开局。随后湖人队发起反攻，但是快船队在保罗稳健地掌控之下，一直占据领先。&lt;/p&gt;\r\n\r\n&lt;p&gt;第三节保罗再次带领全队打出流畅进攻，快船队在第三节再次拉开了比分，随着保罗一记空位3分，快船队得以领先21分，这记三分球也终结了比赛的悬念，保罗也&amp;ldquo;打卡下班&amp;rdquo;。最终快船迎来了大胜，保罗则得到25分4篮板8次助攻，绝对是球队灵魂般的人物。&lt;/p&gt;\r\n\r\n&lt;p&gt;值得一提的是，尽管保罗本场表现出色，且带队在主场赢得了一场大胜，但自己主场的球迷们还是将更多地掌声和欢呼送给了对面的科比。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(70, 'csub20160603_1044113807', 'cate20150805_1133251007', '', 'node20160406_0928324317', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 35, 'y', 'y', 'n', 'n', 'n', 'n', '火牛爵最后5场解析:小牛关键2战 休城能5连胜?', NULL, '20160406_092854_8161.jpg', '20160406_094140_5257.jpg', NULL, NULL, '北京时间4月6日，据《Fansided》报道，常规赛还剩下最后一周多的时间，西部季后赛的最后两个席位也将在爵士、小牛和火箭当中产生，剩余的赛程里对谁最有利？今天，《Fansided》就专门分析了三队各自剩下的赛程。', '&lt;p&gt;北京时间4月6日，据《Fansided》报道，常规赛还剩下最后一周多的时间，西部季后赛的最后两个席位也将在爵士、小牛和火箭当中产生，剩余的赛程里对谁最有利？今天，《Fansided》就专门分析了三队各自剩下的赛程。&lt;/p&gt;\r\n\r\n&lt;p&gt;目前，小牛跟爵士都是39胜38负的战绩，分别排在西部第七和第八的位置，而火箭则以38胜39负落后他们1场位列第九。最近，小牛拿到了一波重要的四连胜，而火箭则拿下了跟雷霆的比赛，挽救了他们的季后赛机会。而爵士最近表现同样亮眼，他们最近5场比赛只输了1场，还是加时败给勇士。三队各自都剩下最后5场比赛，那么赛程到底对谁最有利呢？&lt;/p&gt;\r\n\r\n&lt;p&gt;火箭：&lt;/p&gt;\r\n\r\n&lt;p&gt;剩余赛程：客场对小牛、主场对太阳、主场对湖人、客场对森林狼、主场对国王。&lt;/p&gt;\r\n\r\n&lt;p&gt;火箭的赛程是三队当中最轻松的，明天对阵小牛的比赛将可能是他们本赛季最重要的一场比赛，而一旦他们跨过了小牛，就极有可能以5连胜结束常规赛。最后一场对阵国王的比赛是剩下4场比赛里他们输球可能性最大的，因为那三个对手都在想办法给自己的乐透签概率增加一些筹码呢。&lt;/p&gt;\r\n\r\n&lt;p&gt;爵士：&lt;/p&gt;\r\n\r\n&lt;p&gt;剩余赛程：主场对马刺、主场对快船、客场对掘金、主场对小牛、客场对湖人&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\n爵士剩余赛程比较有趣，他们将在今天对阵马刺，虽然马刺上一场也上了全部主力，但是天才知道他们这场到底会不会轮休，而快船的情况也类似，虽然他们锁定了西部第四的位置，但是由于刚刚迎回布雷克-格里芬，他们很可能会选择不放水而磨合阵容。而湖人的比赛则可能会更有趣，因为那将是科比的最后一战，湖人全队肯定会希望用一场胜利送别科比。而对于小牛这场，可能就会直接决定最后的西部第七第八的位置。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(71, 'csub20150805_1133597884', 'cate20150805_1133251007', '', 'node20160406_0929508322', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 27, 'y', 'y', 'n', 'n', 'n', 'n', '内线小将强悍防守获比帅点赞：一战可见他未来', NULL, NULL, NULL, NULL, '', '', '&lt;p&gt;北京时间4月6日，据《休斯顿纪事报》的乔纳森-费根报道，上一场击败俄城雷霆，克林特-卡佩拉在末节的防守，获得了代理主帅J.B。-比克斯塔夫的称赞。而获得本季单场最多出场时间的K.J。-麦克丹尼尔斯则表示，出场时间越多，他就越能找到节奏。&lt;/p&gt;\r\n\r\n&lt;p&gt;在1月底雷霆对火箭的比赛中，在德怀特-霍华德因2次技犯被逐后，恩尼斯-坎特开始大杀四方。他全场得到22分10个篮板，其中20分是在魔兽被逐后所得。&lt;/p&gt;\r\n\r\n&lt;p&gt;上一场，坎特出场18分钟仍拿下16分，但在末节8分半钟由卡佩拉防守时，坎特仅得2分。全场，卡佩拉出战24分钟得到9分6个篮板4次盖帽，他的出色表现，也使火箭对于未来能更放心地安排他防守对方大个中锋。&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;ldquo;他的防守令人难以置信，&amp;rdquo;比克斯塔夫说，&amp;ldquo;他非常有活力。以往，他对位大个子，和对方拼身体的时候总会陷入麻烦。（但上一场）他表现不错，打出了侵略性。&amp;rdquo;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;br /&gt;\r\n比克斯塔夫接着说：&amp;ldquo;我认为，他已意识到他的运动能力、速度和聪明的头脑，如何能让他和那些块头更大，更为强壮的对手对位。你推不动他，撞不开他，也无法将他推离令他舒服的区域。防守端他的确做得很出色。他驻扎在篮下，送出了许多精彩的盖帽，干扰了对手多次出手，迫使对手改变投篮弧度。他打得很棒，从中我们也可瞥见未来的他会是怎样的。&amp;rdquo;&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(72, 'csub20150805_1133597884', 'cate20150805_1133251007', '', 'node20160406_0930259685', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 305, 'y', 'y', 'n', 'y', 'n', 'n', '男篮热身计划：5月VS澳洲6月战马其顿7月赴美', '', '20160804_120816_2164.png', '20160603_101652_5575.png', NULL, '', '北京时间4月6日消息，“高通骁龙”杯中澳男篮热身对抗赛发布会今天上午在北京举办。中国男篮领队柴文生在接受采访时介绍了中国男篮今夏备战里约奥运的计划。', '&lt;p&gt;北京时间4月6日消息，&amp;ldquo;高通骁龙&amp;rdquo;杯中澳男篮热身对抗赛发布会今天上午在北京举办。中国男篮领队柴文生在接受采访时介绍了中国男篮今夏备战里约奥运的计划。&lt;/p&gt;\r\n\r\n&lt;p&gt;据领队柴文胜介绍，男篮最早将于13日奔赴海埂基地，进行高原集训。由于目前还没有跟沟通完毕，因此男篮这段时间的训练将由李楠牵头进行。&lt;/p&gt;\r\n\r\n&lt;p&gt;中国男篮具体热身赛计划：&lt;/p&gt;\r\n\r\n&lt;p&gt;5月6日 中国VS澳大利亚 南宁&lt;/p&gt;\r\n\r\n&lt;p&gt;5月8日 中国VS澳大利亚 广州&lt;/p&gt;\r\n\r\n&lt;p&gt;5月10日 中国VS澳大利亚 北京&lt;/p&gt;\r\n\r\n&lt;p&gt;6月6日 中国VS马其顿 长春&lt;/p&gt;\r\n\r\n&lt;p&gt;6月8日 中国VS马其顿 焦作&lt;/p&gt;\r\n\r\n&lt;p&gt;6月10日 中国VS马其顿 洛阳&lt;/p&gt;\r\n\r\n&lt;p&gt;6月中旬 中国男篮赴意大利参加两站热身赛&lt;/p&gt;\r\n\r\n&lt;p&gt;7月上旬 斯坦科维奇杯&lt;/p&gt;\r\n\r\n&lt;p&gt;7月 中欧对抗赛&lt;/p&gt;\r\n\r\n&lt;p&gt;7月20日 中国男篮赴美热身&lt;/p&gt;\r\n\r\n&lt;p&gt;7月30日 中国男篮赴里约进行一场热身赛&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##33==#==detprice:##444==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-05-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(73, 'csub20160410_0658592970', 'cate20160410_0658287350', '', 'node20160410_0701251989', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 13, 'y', 'y', 'n', 'n', 'n', 'n', '神探夏洛克', NULL, NULL, '20160410_071354_6503.jpg', NULL, '', '', '&lt;p&gt;《飓风营救3》是由奥利维尔&amp;middot;米加顿执导，连姆&amp;middot;尼森、福里斯特&amp;middot;惠特克、多格雷&amp;middot;斯科特和玛姬&amp;middot;格蕾斯等联袂出演的动作影片。影片讲述特工布莱恩的前妻诺尔在家里被谋杀，被误认为杀人凶手，为了保护自己的女儿，再次展开一段逃亡营救之旅。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(74, 'csub20160410_0658592970', 'cate20160410_0658287350', '', 'node20160410_0707082846', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 14, 'y', 'y', 'n', 'n', 'n', 'n', '陪安东尼度过漫长岁月', NULL, NULL, '20160410_071341_8687.jpg', NULL, '', '', '&lt;p&gt;《飓风营救3》是由奥利维尔&amp;middot;米加顿执导，连姆&amp;middot;尼森、福里斯特&amp;middot;惠特克、多格雷&amp;middot;斯科特和玛姬&amp;middot;格蕾斯等联袂出演的动作影片。影片讲述特工布莱恩的前妻诺尔在家里被谋杀，被误认为杀人凶手，为了保护自己的女儿，再次展开一段逃亡营救之旅。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(75, 'csub20160410_0658592970', 'cate20160410_0658287350', '', 'node20160410_0709314927', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 14, 'y', 'y', 'n', 'n', 'n', 'n', '十月初五的月光', NULL, NULL, '20160410_071347_1842.jpg', NULL, '', '', '&lt;p&gt;《飓风营救3》是由奥利维尔&amp;middot;米加顿执导，连姆&amp;middot;尼森、福里斯特&amp;middot;惠特克、多格雷&amp;middot;斯科特和玛姬&amp;middot;格蕾斯等联袂出演的动作影片。影片讲述特工布莱恩的前妻诺尔在家里被谋杀，被误认为杀人凶手，为了保护自己的女儿，再次展开一段逃亡营救之旅。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(76, 'csub20160410_0658592970', 'cate20160410_0658287350', '', 'node20160410_0710091322', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 13, 'y', 'y', 'n', 'n', 'n', 'n', '风口青春', NULL, NULL, '20160410_071320_1468.jpg', NULL, '', '', '&lt;p&gt;《飓风营救3》是由奥利维尔&amp;middot;米加顿执导，连姆&amp;middot;尼森、福里斯特&amp;middot;惠特克、多格雷&amp;middot;斯科特和玛姬&amp;middot;格蕾斯等联袂出演的动作影片。影片讲述特工布莱恩的前妻诺尔在家里被谋杀，被误认为杀人凶手，为了保护自己的女儿，再次展开一段逃亡营救之旅。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(77, 'csub20160410_0658592970', 'cate20160410_0658287350', '', 'node20160410_0710424788', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 15, 'y', 'y', 'n', 'n', 'n', 'n', '猛龙特囧', NULL, NULL, '20160410_071312_4780.jpg', NULL, '', '', '&lt;p&gt;《你丫闭嘴》是弗朗西斯&amp;middot;维贝执导的喜剧片，由让&amp;middot;雷诺、杰拉尔&amp;middot;德帕迪约、蕾诺&amp;middot;瓦莱拉联袂主演。该片讲述的是让&amp;middot;雷诺扮演的杀手Ruby为了被仇人杀害的情人，而走上了复仇之路。期间他遇见了有着善良的热心肠并且还有点愚蠢的Quentin，二人发生了让人啼笑皆非的一段段法式喜剧。...&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(78, 'csub20160410_0659073489', 'cate20160410_0658287350', '', 'node20160410_0719516967', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 17, 'y', 'y', 'n', 'n', 'n', 'n', '捉妖记', NULL, NULL, '20160410_072101_5445.jpg', NULL, '', '', '&lt;p&gt;《你丫闭嘴》是弗朗西斯&amp;middot;维贝执导的喜剧片，由让&amp;middot;雷诺、杰拉尔&amp;middot;德帕迪约、蕾诺&amp;middot;瓦莱拉联袂主演。该片讲述的是让&amp;middot;雷诺扮演的杀手Ruby为了被仇人杀害的情人，而走上了复仇之路。期间他遇见了有着善良的热心肠并且还有点愚蠢的Quentin，二人发生了让人啼笑皆非的一段段法式喜剧。...&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(79, 'csub20160410_0659073489', 'cate20160410_0658287350', '', 'node20160410_0719594433', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 12, 'y', 'y', 'n', 'n', 'n', 'n', '窃听风云', NULL, NULL, '20160410_072055_6922.jpg', NULL, '', '', '&lt;p&gt;《你丫闭嘴》是弗朗西斯&amp;middot;维贝执导的喜剧片，由让&amp;middot;雷诺、杰拉尔&amp;middot;德帕迪约、蕾诺&amp;middot;瓦莱拉联袂主演。该片讲述的是让&amp;middot;雷诺扮演的杀手Ruby为了被仇人杀害的情人，而走上了复仇之路。期间他遇见了有着善良的热心肠并且还有点愚蠢的Quentin，二人发生了让人啼笑皆非的一段段法式喜剧。...&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(80, 'csub20160410_0659073489', 'cate20160410_0658287350', '', 'node20160410_0720092861', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 12, 'y', 'y', 'n', 'n', 'n', 'n', '飓风营救3', NULL, NULL, '20160410_072048_8084.jpg', NULL, NULL, '', '&lt;p&gt;《飓风营救3》是由奥利维尔&amp;middot;米加顿执导，连姆&amp;middot;尼森、福里斯特&amp;middot;惠特克、多格雷&amp;middot;斯科特和玛姬&amp;middot;格蕾斯等联袂出演的动作影片。影片讲述特工布莱恩的前妻诺尔在家里被谋杀，被误认为杀人凶手，为了保护自己的女儿，再次展开一段逃亡营救之旅。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(81, 'csub20160410_0659073489', 'cate20160410_0658287350', '', 'node20160410_0720179909', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 16, 'y', 'y', 'n', 'n', 'n', 'n', '丑女也有春天', NULL, NULL, '20160410_072041_4779.jpg', NULL, '', '', '&lt;p&gt;《你丫闭嘴》是弗朗西斯&amp;middot;维贝执导的喜剧片，由让&amp;middot;雷诺、杰拉尔&amp;middot;德帕迪约、蕾诺&amp;middot;瓦莱拉联袂主演。该片讲述的是让&amp;middot;雷诺扮演的杀手Ruby为了被仇人杀害的情人，而走上了复仇之路。期间他遇见了有着善良的热心肠并且还有点愚蠢的Quentin，二人发生了让人啼笑皆非的一段段法式喜剧。...&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(82, 'csub20160410_0659073489', 'cate20160410_0658287350', '', 'node20160410_0720253479', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 18, 'y', 'y', 'n', 'n', 'n', 'n', '巨人捕手杰克', NULL, NULL, '20160410_072034_1962.jpg', NULL, '', '', '&lt;p&gt;《你丫闭嘴》是弗朗西斯&amp;middot;维贝执导的喜剧片，由让&amp;middot;雷诺、杰拉尔&amp;middot;德帕迪约、蕾诺&amp;middot;瓦莱拉联袂主演。该片讲述的是让&amp;middot;雷诺扮演的杀手Ruby为了被仇人杀害的情人，而走上了复仇之路。期间他遇见了有着善良的热心肠并且还有点愚蠢的Quentin，二人发生了让人啼笑皆非的一段段法式喜剧。...&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL);
INSERT INTO `zzz_node` (`id`, `pid`, `ppid`, `pidmulti`, `pidname`, `pbh`, `pbrand`, `lang`, `pos`, `modtype`, `hit`, `sta_search`, `sta_visible`, `sta_noaccess`, `sta_tj`, `sta_new`, `sta_orignimg`, `title`, `titlestyle`, `kv`, `kvsm`, `kvsm2`, `alias_jump`, `despjj`, `desp`, `desptext`, `arr_can`, `detpriceold`, `detprice`, `stock`, `sku`, `dateedit`, `seo1`, `seo2`, `seo3`, `videoid`, `albumid`, `musicid`) VALUES
(83, 'csub20160410_0658592970', 'cate20160410_0658287350', '', 'node20160410_0723141828', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 26, 'y', 'y', 'n', 'n', 'n', 'n', '请你闭嘴', '', NULL, '20160410_072624_8716.jpg', NULL, '', '', '&lt;p&gt;《你丫闭嘴》是弗朗西斯&amp;middot;维贝执导的喜剧片，由让&amp;middot;雷诺、杰拉尔&amp;middot;德帕迪约、蕾诺&amp;middot;瓦莱拉联袂主演。该片 讲述的是让&amp;middot;雷诺扮演的杀手Ruby为了被仇人杀害的情人，而走上了复仇之路。期间他遇见了有着善良的热心肠并且还有点愚蠢的Quentin，二人发生了让人啼笑皆非的一段段法式喜剧。&lt;/p&gt;\r\n\r\n&lt;p&gt;《你丫闭嘴》是弗朗西斯&amp;middot;维贝执导的喜剧片，由让&amp;middot;雷诺、杰拉尔&amp;middot;德帕迪约、蕾诺&amp;middot;瓦莱拉联袂主演。该片 讲述的是让&amp;middot;雷诺扮演的杀手Ruby为了被仇人杀害的情人，而走上了复仇之路。期间他遇见了有着善良的热心肠并且还有点愚蠢的Quentin，二人发生了让人啼笑皆非的一段段法式喜剧。&lt;/p&gt;', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(84, 'csub20160410_0659073489', 'cate20160410_0658287350', '', 'node20160410_0723301708', 'bh2010079002demososo', NULL, 'cn', 50, 'node', 22, 'y', 'y', 'n', 'n', 'n', 'n', '私奔B计划', NULL, '', '20160410_072340_7170.jpg', NULL, NULL, '', '&lt;p&gt;电影《私奔B计划》是由帕斯卡尔&amp;middot;舒梅执导的爱情喜剧片，黛安&amp;middot;克鲁格，丹尼&amp;middot;伯恩，伊什尼&amp;middot;齐科特，劳尔&amp;middot;卡拉米领衔主演。影片于2013年10月25日在中国大陆上映。影片讲述了女主人公伊萨贝拉为绕过她家所有人第一次婚姻都会破裂的厄运，想出了能嫁给她爱的人的策略：找个好骗的，诱惑他、嫁给他然后再离婚。&lt;/p&gt;', '', 'author:##==#==authorcompany:##==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==linkmore:##==#==detail_albumid:##==#==detail_videoid:##video20180524_1839345521==#==detail_musicid:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-04-10 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(136, '', 'blockdh', '', 'dhnode20160707_0453176331', 'bh2010079002demososo', NULL, 'cn', 500, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '请输入标题', NULL, NULL, NULL, NULL, NULL, '', '', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(138, '', 'blockdh', '', 'dhnode20160707_0453262249', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '请输入标题', NULL, NULL, NULL, NULL, NULL, '', '', '', 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(149, 'vblock20170419_1630345041', 'blockdh', '', 'dhnode20160707_0949595818', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '图片1', NULL, '20160924_125009_5777.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(150, 'vblock20170419_1630345041', 'blockdh', '', 'dhnode20160707_0950025452', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '图片2', NULL, '20160924_124827_5740.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(151, 'vblock20170419_1630345041', 'blockdh', '', 'dhnode20160707_0951208542', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '图片3', NULL, '20160924_124644_1529.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(154, 'vblock20170419_1639427863', 'blockdh', '', 'dhnode20160707_1124101118', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '1', NULL, '20160707_112429_7823.jpg', NULL, NULL, NULL, '', NULL, NULL, 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(155, 'vblock20170419_1639427863', 'blockdh', '', 'dhnode20160707_1124132779', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '3', NULL, '20160707_112424_8656.jpg', NULL, NULL, NULL, '', NULL, NULL, 'titlecss:##==#==author:##==#==authorcompany:##==#==sta_noaccess:##n==#==sta_tj:##y==#==sta_new:##y==#==stock:##10000==#==detpriceold:##0==#==detprice:##0==#==detlinktitle:##==#==detlinkurl:##==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==linkmore:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(156, 'vblock20170419_1639427863', 'blockdh', '', 'dhnode20160707_1124152176', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '2', NULL, '20160707_112420_9896.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(168, 'vblock20170419_1845397696', 'blockdh', '', 'dhnode20160707_1154283772', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '泊秦淮', NULL, '20180530_123928_1658.jpg', NULL, NULL, NULL, '', '&lt;p&gt;&lt;strong&gt;DM建站系统，免费开源，无需授权。。。&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;烟笼寒水月笼沙，夜泊秦淮近酒家。&lt;br /&gt;\r\n商女不知亡国恨，隔江犹唱《后庭花》。烟笼寒水月笼沙，夜泊秦淮近酒家。&lt;br /&gt;\r\n商女不知亡国恨，隔江犹唱《后庭花》。&lt;br /&gt;\r\n&amp;nbsp;&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(169, 'vblock20170419_1845397696', 'blockdh', '', 'dhnode20160707_1154326670', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '瑶池', NULL, '20180530_123922_6089.jpg', NULL, NULL, NULL, '', '&lt;p&gt;&lt;strong&gt;DM建站系统，免费开源，无需授权。。。&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;瑶池阿母绮窗开，黄竹歌声动地哀。&amp;nbsp;&lt;br /&gt;\r\n八骏日行三万里，穆王何事不重来瑶池阿母绮窗开，黄竹歌声动地哀。&amp;nbsp;&lt;br /&gt;\r\n八骏日行三万里，穆王何事不重来瑶池阿母绮窗开，黄竹歌声动地哀。&amp;nbsp;&lt;br /&gt;\r\n八骏日行三万里，穆王何事不重来&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(170, 'vblock20170419_1845397696', 'blockdh', '', 'dhnode20160707_1154347224', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '黄鹤楼', NULL, '20180530_123916_6251.jpg', NULL, NULL, NULL, '', '&lt;p&gt;&lt;strong&gt;DM建站系统，免费开源，无需授权。。。&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;故人西辞黄鹤楼，烟花三月下扬州。孤帆远影碧空尽，唯见长江天际流。故人西辞黄鹤楼，烟花三月下扬州。孤帆远影碧空尽，唯见长江天际流。&lt;/p&gt;\r\n\r\n&lt;p&gt;故人西辞黄鹤楼，烟花三月下扬州。孤帆远影碧空尽，唯见长江天际流。故人西辞黄鹤楼，烟花三月下扬州。孤帆远影碧空尽，唯见长江天际流。&lt;/p&gt;\r\n\r\n&lt;p&gt;故人西辞黄鹤楼，烟花三月下扬州。孤帆远影碧空尽，唯见长江天际流。&lt;/p&gt;\r\n\r\n&lt;p&gt;故人西辞黄鹤楼，烟花三月下扬州。孤帆远影碧空尽，唯见长江天际流。&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-07 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(171, 'vblock20170419_1837016257', 'blockdh', '', 'dhnode20160708_0511415697', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '1标题', NULL, '20160708_051409_5884.png', NULL, NULL, NULL, '', '&lt;p&gt;这个和上面的内容一样，只是效果不一样，在后台改变他们很容易的哟。。。。。。。。。合用户编辑所见即所得，但会过滤一些html，所以如果自己写html源代码的话，请使用纯这个和上面的内容一样，只是效果不一样，在后台改变他们很容易的哟。。。。。。。。。合用户编辑所见即所得，但会过滤一些html，所以如果自己写html源代码的话，请使用纯&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(172, 'vblock20170419_1837016257', 'blockdh', '', 'dhnode20160708_0511438328', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '2标题', NULL, '20160708_051405_9841.png', NULL, NULL, NULL, '', '&lt;p&gt;这个和上面的内容一样，只是效果不一样，在后台改变他们很容易的哟。。。。。。。。。合用户编辑所见即所得，但会过滤一些html，所以如果自己写html源代码的话，请使用纯这个和上面的内容一样，只是效果不一样，在后台改变他们很容易的哟。。。。。。。。。合用户编辑所见即所得，但会过滤一些html，所以如果自己写html源代码的话，请使用纯&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(173, 'vblock20170419_1837016257', 'blockdh', '', 'dhnode20160708_0511478936', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '3标题', NULL, '20160708_051400_5821.png', NULL, NULL, NULL, '', '&lt;p&gt;这个和上面的内容一样，只是效果不一样，在后台改变他们很容易的哟。。。。。。。。。合用户编辑所见即所得，但会过滤一些html，所以如果自己写html源代码的话，请使用纯这个和上面的内容一样，只是效果不一样，在后台改变他们很容易的哟。。。。。。。。。合用户编辑所见即所得，但会过滤一些html，所以如果自己写html源代码的话，请使用纯&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(177, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0517599105', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '1', NULL, '20160708_051831_1555.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(178, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0518036419', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '2', NULL, '20160708_051837_3866.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(179, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0518057581', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '3', NULL, '20160708_051843_3631.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(180, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0518084448', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '4', NULL, '20160708_051848_7868.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(181, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0518103626', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '5', NULL, '20160708_051853_3681.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(182, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0518128116', 'bh2010079002demososo', NULL, 'cn', 45, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '6', NULL, '20160708_051858_5293.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(183, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0518177683', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '7', NULL, '20160708_051905_7435.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(184, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0518198316', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '8', NULL, '20160708_051910_3697.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(185, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0518219661', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '9', NULL, '20160708_051924_7490.jpg', NULL, NULL, NULL, '', '', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(186, 'vblock20170919_1446491004', 'blockdh', '', 'dhnode20160708_0518245788', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '10', NULL, '20160708_051916_7969.jpg', NULL, NULL, NULL, '', '', '', 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(188, 'vblock20170420_1158241500', 'blockdh', '', 'dhnode20160708_0519565256', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '响应服务', NULL, '20160708_052109_4752.jpg', NULL, NULL, NULL, '', '&lt;p&gt;我们通过QQ 939805498、只是测试一下哟只是测试一下哟只是测试一下哟只是测试一下哟&amp;nbsp;电话和售后工单的方式&amp;nbsp;&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(189, 'vblock20170420_1158241500', 'blockdh', '', 'dhnode20160708_0519582176', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '节假日无休制度', NULL, '20160708_052103_5765.jpg', NULL, NULL, NULL, '', '&lt;p&gt;为保证客户系统的安全与稳定DM建站系统，我们在周末和节假日都会轮休为客户提供售后支持&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(190, 'vblock20170420_1158241500', 'blockdh', '', 'dhnode20160708_0520011899', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户反馈', NULL, '20160708_052042_4614.jpg', NULL, NULL, NULL, '', '&lt;p&gt;我们收到过很多客户DM建站系统给我们售后团队寄来的锦旗和礼品，我们的售后得到广大客户的极大认可&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(191, 'vblock20170420_1158241500', 'blockdh', '', 'dhnode20160708_0520036020', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '服务评价机制服务评价机制', NULL, '20160708_052036_3356.jpg', NULL, NULL, NULL, '', '&lt;p&gt;DM建站系统自建服务评价体系DM建站系统，对于不满意售后的客户，我们有专人负责跟踪回访&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(192, 'vblock20170420_1158241500', 'blockdh', '', 'dhnode20160708_0520033998', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '售后投诉监督机制', NULL, '20160708_052031_5410.jpg', NULL, NULL, NULL, '', '&lt;p&gt;公司通过设立微信DM建站系统投诉和电话投诉，由专人来监督售后服务质量&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(193, 'vblock20170420_1158241500', 'blockdh', '', 'dhnode20160708_0520079152', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '强大的售后团队', NULL, '20160708_052024_7556.jpg', NULL, NULL, NULL, '', '&lt;p&gt;我们售后技术包括开发工程师DM建站系统、安全工程师、运维工程师，全方位为客户的稳定安全服务&lt;/p&gt;', '', 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(194, 'vblock20170419_1841265872', 'blockdh', '', 'dhnode20160708_0528214835', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户评价1', NULL, '20160708_053224_8385.jpg', NULL, NULL, NULL, '', '&lt;p&gt;客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##CFO==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(195, 'vblock20170419_1841265872', 'blockdh', '', 'dhnode20160708_0528245891', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户评价2', NULL, '20160708_053219_9347.jpg', NULL, NULL, NULL, '', '&lt;p&gt;客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##CTO==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(196, 'vblock20170419_1841265872', 'blockdh', '', 'dhnode20160708_0528262594', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户评价3', NULL, '20160708_053215_7122.jpg', NULL, NULL, NULL, '', '&lt;p&gt;客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##CFO==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(197, 'vblock20170419_1841265872', 'blockdh', '', 'dhnode20160708_0528295219', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户评价4', NULL, '20160708_053210_2374.jpg', NULL, NULL, NULL, '', '&lt;p&gt;客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##CEO==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(198, 'vblock20170419_1841265872', 'blockdh', '', 'dhnode20160708_0528326665', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户评价5', NULL, '20160708_053206_1162.jpg', NULL, NULL, NULL, '', '&lt;p&gt;客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##CFO==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(199, 'vblock20170419_1841265872', 'blockdh', '', 'dhnode20160708_0528356660', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户评价6', NULL, '20160708_053202_1372.jpg', NULL, NULL, NULL, '', '&lt;p&gt;客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。客户评价内容。。。&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##CTO==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2016-07-08 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(281, 'csub20170214_1756444189', 'blockdh', '', 'dhnode20170214_1757156752', 'bh2010079002demososo', NULL, 'cn', 500, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '安全服务器', NULL, '20170214_180324_6851.png', '', '', NULL, '', '&lt;p&gt;&lt;span style=&quot;color:#e74c3c&quot;&gt;&lt;strong&gt;DM企业建站系统&lt;/strong&gt;www.demososo.com&lt;/span&gt; ， 开源免费，无需授权。DM企业建站系统www.demososo.com ， 开源免费，无需授权。&lt;span style=&quot;color:#e74c3c&quot;&gt;内容的高度由内容决定。。。&lt;/span&gt;&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2017-02-14 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(282, 'csub20170214_1756444189', 'blockdh', '', 'dhnode20170214_1801039449', 'bh2010079002demososo', NULL, 'cn', 360, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '备份和存储', NULL, '20180313_152128_4187.jpg', '', '', NULL, '', '&lt;p&gt;东风仿佛吹开了盛开鲜花的千棵树，又如将空中的繁星吹落，像阵阵星雨。华丽的香车宝马在路上来来往往，各式各样的醉人香气弥漫着大街。悦耳的音乐之声四处回荡&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2017-02-14 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(283, 'csub20170214_1756444189', 'blockdh', '', 'dhnode20170214_1801124071', 'bh2010079002demososo', NULL, 'cn', 250, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '24/7 每天备份', NULL, '20180313_152142_4542.jpg', '', '', NULL, '', '&lt;p&gt;东风仿佛吹开了盛开鲜花的千棵树，又如将空中的繁星吹落，像阵阵星雨。华丽的香车宝马在路上来来往往，各式各样的醉人香气弥漫着大街。悦耳的音乐之声四处回荡&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2017-02-14 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(284, 'csub20170214_1756444189', 'blockdh', '', 'dhnode20170214_1801216295', 'bh2010079002demososo', NULL, 'cn', 200, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '控制面板', NULL, '20180313_152147_6756.jpg', '', '', NULL, '', '&lt;p&gt;东风仿佛吹开了盛开鲜花的千棵树，又如将空中的繁星吹落，像阵阵星雨。华丽的香车宝马在路上来来往往，各式各样的醉人香气弥漫着大街。悦耳的音乐之声四处回荡&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2017-02-14 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(285, 'csub20170214_1756444189', 'blockdh', '', 'dhnode20170214_1801508504', 'bh2010079002demososo', NULL, 'cn', 490, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '容易操作', NULL, '20180313_152120_8289.jpg', '', '', NULL, '', '&lt;p&gt;东风仿佛吹开了盛开鲜花的千棵树，又如将空中的繁星吹落，像阵阵星雨。华丽的香车宝马在路上来来往往，各式各样的醉人香气弥漫着大街。悦耳的音乐之声四处回荡&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2017-02-14 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(286, 'csub20170214_1756444189', 'blockdh', '', 'dhnode20170214_1802044753', 'bh2010079002demososo', NULL, 'cn', 350, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '虚拟服务', NULL, '20180313_152135_9625.jpg', '', '', NULL, '', '&lt;p&gt;东风仿佛吹开了盛开鲜花的千棵树，又如将空中的繁星吹落，像阵阵星雨。华丽的香车宝马在路上来来往往，各式各样的醉人香气弥漫着大街。悦耳的音乐之声四处回荡&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2017-02-14 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(320, 'vblock20171201_1536338532', 'blockdh', '', 'dhnode20170426_1859383219', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '标题3标题3标题3标题3标题3， 如果区块的css名称里有hideslidetext ，则会不显示文字', NULL, '20170426_190020_3054.jpg', '', '', NULL, '', '&lt;p&gt;秋高气爽33333. 指秋天的天空.天气晴朗,天少云而高.云轻薄而淡...南飞的大雁已望到了天边. 不登临长城关口绝不是英雄长空高阔白云清朗,&amp;nbsp;&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2017-04-26 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(321, 'vblock20171201_1536338532', 'blockdh', '', 'dhnode20170426_1859419254', 'bh2010079002demososo', NULL, 'cn', 55, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '标题1标题1标题1标题1标题1标题1， 如果区块的css名称里有hideslidetext ，则会不显示文字', NULL, '20170426_190014_9970.jpg', '', '', NULL, '', '&lt;p&gt;秋高气爽22222. 指秋天的天空.天气晴朗,天少云而高.云轻薄而淡...南飞的大雁已望到了天边.&amp;nbsp;&lt;/p&gt;', '', 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2017-04-26 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(322, 'vblock20171201_1536338532', 'blockdh', '', 'dhnode20170426_1859432657', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '标题2标题2标题2标题2标题2，如果区块的css名称里有hideslidetext ，则会不显示文字', NULL, '20170426_190002_2823.jpg', '', '', NULL, '', '&lt;p&gt;秋高气爽111. 指秋天的天空.天气晴朗,天少云而高.云轻薄而淡...南飞的大雁已望到了天边.&amp;nbsp;&lt;/p&gt;', '', 'linktitle:##==#==linkurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2017-04-26 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(426, 'csub20171207_1040119631', 'blockdh', '', 'dhnode20180306_1806169984', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '这是标题3这是标题1', NULL, '20180306_180624_6788.png', '', '', NULL, '', '&lt;p&gt;白日依山尽，黄河入海流。欲穷千里目，更上一层楼。&amp;nbsp;夕阳依傍着西山慢慢地沉没， 滔滔黄河朝着东海汹涌奔流。若想把千里的风光景物看够， 那就要登上更高的一层城楼。&lt;/p&gt;', '', 'linkdhtitle:##查看详情==#==linkdhurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-03-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(424, 'csub20171207_1040119631', 'blockdh', '', 'dhnode20180306_1806063878', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '这是标题3这是标题3', NULL, '20180306_180632_3335.png', '', '', NULL, '', '&lt;p&gt;离离原上草，一岁一枯荣。野火烧不尽，春风吹又生。远芳侵古道，晴翠接荒城。又送王孙去，萋萋满别情。离离原上草，一岁一枯荣。野火烧不尽，春风吹又生。远芳侵古道，晴翠接荒城。又送王孙去，萋萋满别情。&lt;/p&gt;', '', 'linkdhtitle:##查看详情==#==linkdhurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-03-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(425, 'csub20171207_1040119631', 'blockdh', '', 'dhnode20180306_1806087297', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '这是标题3这是标题2', NULL, '20180306_180628_5816.png', '', '', NULL, '', '&lt;p&gt;离离原上草，一岁一枯荣。野火烧不尽，春风吹又生。远芳侵古道，晴翠接荒城。又送王孙去，萋萋满别情。离离原上草，一岁一枯荣。野火烧不尽，春风吹又生。远芳侵古道，晴翠接荒城。又送王孙去，萋萋满别情。&lt;/p&gt;', '', 'linkdhtitle:##查看详情==#==linkdhurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-03-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(423, 'csub20171207_1040184257', 'blockdh', '', 'dhnode20180306_1804026824', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '我们的服务1', NULL, '20180306_180417_5908.jpg', '', '', NULL, '', '&lt;p&gt;白日依山尽，黄河入海流。欲穷千里目，更上一层楼。 夕阳依傍着西山慢慢地沉没， 滔滔黄河朝着东海汹涌奔流。若想把千里的风光景物看够， 那就要登上更高的一层城楼。&lt;/p&gt;', '', 'linkdhtitle:##查看详情==#==linkdhurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-03-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(420, 'csub20171207_1040184257', 'blockdh', '', 'dhnode20180306_1803478979', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '我们的服务4', NULL, '20180306_180433_1482.jpg', '', '', NULL, '', '&lt;p&gt;白日依山尽，黄河入海流。欲穷千里目，更上一层楼。 夕阳依傍着西山慢慢地沉没， 滔滔黄河朝着东海汹涌奔流。若想把千里的风光景物看够， 那就要登上更高的一层城楼。&lt;/p&gt;', '', 'linkdhtitle:##查看详情==#==linkdhurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-03-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(421, 'csub20171207_1040184257', 'blockdh', '', 'dhnode20180306_1803558731', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '我们的服务3', NULL, '20180306_180428_6984.jpg', '', '', NULL, '', '&lt;p&gt;白日依山尽，黄河入海流。欲穷千里目，更上一层楼。 夕阳依傍着西山慢慢地沉没， 滔滔黄河朝着东海汹涌奔流。若想把千里的风光景物看够， 那就要登上更高的一层城楼。&lt;/p&gt;', '', 'linkdhtitle:##查看详情==#==linkdhurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-03-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(422, 'csub20171207_1040184257', 'blockdh', '', 'dhnode20180306_1803586772', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '我们的服务42', NULL, '20180306_180423_8965.jpg', '', '', NULL, '', '&lt;p&gt;白日依山尽，黄河入海流。欲穷千里目，更上一层楼。 夕阳依傍着西山慢慢地沉没， 滔滔黄河朝着东海汹涌奔流。若想把千里的风光景物看够， 那就要登上更高的一层城楼。&lt;/p&gt;', '', 'linkdhtitle:##查看详情==#==linkdhurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-03-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(419, 'vblock20171220_1120341606', 'blockdh', '', 'dhnode20180306_1759599242', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '企业建站系统，百变多模板', NULL, '20180306_180039_5231.jpg', '', '', NULL, '', '&lt;p&gt;免费建站，免费授权，区块管理，建站灵活。多模板选择。&lt;/p&gt;', '', 'linkdhtitle:##DM系统建站==#==linkdhurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-03-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(418, 'vblock20171220_1120341606', 'blockdh', '', 'dhnode20180306_1759287556', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '用拼积木的方法来建设网站', NULL, '20180306_180044_3682.jpg', '', '', NULL, '', '&lt;p&gt;响应式快速建站系统 , 辑器格式适合用户编辑所见即所得&amp;nbsp;&lt;/p&gt;', '', 'linkdhtitle:##DM系统建站==#==linkdhurl:##http://www.demososo.com==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-03-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(406, 'vblock20170516_1805542410', 'blockdh', '', 'dhnode20180206_1225531845', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户评价2', NULL, '20180206_123335_5443.jpg', '', '', NULL, '', '&lt;p&gt;唐诗泛指创作于唐朝的诗。唐诗是中华民族最珍贵的文化遗产之一，是中华文化宝库中的一颗明珠，同时也对世界上许多民族和国家的文化发展产生了很大影响&lt;/p&gt;', '', NULL, 0, 0, 10000, '', '2018-02-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(405, 'vblock20170516_1805542410', 'blockdh', '', 'dhnode20180206_1225488966', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户评价1', NULL, '20180206_123339_5946.jpg', '', '', NULL, '', '&lt;p&gt;唐诗泛指创作于唐朝的诗。唐诗是中华民族最珍贵的文化遗产之一，是中华文化宝库中的一颗明珠，同时也对世界上许多民族和国家的文化发展产生了很大影响&lt;/p&gt;', '', NULL, 0, 0, 10000, '', '2018-02-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(407, 'vblock20170516_1805542410', 'blockdh', '', 'dhnode20180206_1225576864', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '客户评价3', NULL, '20180206_123331_9871.jpg', '', '', NULL, '', '唐诗泛指创作于唐朝的诗。唐诗是中华民族最珍贵的文化遗产之一，是中华文化宝库中的一颗明珠，同时也对世界上许多民族和国家的文化发展产生了很大影响', '', NULL, 0, 0, 10000, '', '2018-02-06 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(984, 'vblock20181202_1243218844', 'blockdh', '', 'dhnode20181202_1250132442', 'bh2010079002demososo', NULL, 'cn', 503, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', 'dasdf', NULL, '', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(985, 'vblock20181202_1243218844', 'blockdh', '', 'dhnode20181202_1253064309', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'n', 'n', 'n', 'n', 'n', 'Bbbb', NULL, '', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(986, 'vblock20181202_1243218844', 'blockdh', '', 'dhnode20181202_1254014904', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', 'cccccc', NULL, '', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(987, 'vblock20181202_1243218844', 'blockdh', '', 'dhnode20181202_1255469561', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', 'adada', NULL, '', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(988, 'vblock20181202_1256035928', 'blockdh', '', 'dhnode20181202_1256146835', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', 'sss', NULL, '', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(992, 'vblock20181202_1256035928', 'blockdh', '', 'dhnode20181202_1354306482', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'n', 'n', 'n', 'n', 'n', 'ssdsdsafasdasdf', NULL, '20181202_140053_3312.png', '', '', NULL, 'asd', '&lt;p&gt;sasfdasf&lt;/p&gt;', '', 'linkdhtitle:##cc==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(993, 'vblock20181202_1256035928', 'blockdh', '', 'dhnode20181202_1357329514', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'n', 'n', 'n', 'n', 'n', 'cccc', NULL, '', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(994, 'vblock20181202_1418198029', 'blockdh', '', 'dhnode20181202_1658043578', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', 'ssssssss', NULL, '', '', '', NULL, '', '&lt;p&gt;sssssssssssss&lt;/p&gt;\r\n\r\n&lt;p&gt;ddddddddddddd&lt;/p&gt;', '', 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(995, 'vblock20181202_1418198029', 'blockdh', '', 'dhnode20181202_1658095193', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', 'dddddddddddd', NULL, '', '', '', NULL, '', '&lt;p&gt;sdss&lt;/p&gt;\r\n\r\n&lt;p&gt;asfas&lt;/p&gt;\r\n\r\n&lt;p&gt;fdasf&lt;/p&gt;', '', 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(996, 'vblock20181202_1418198029', 'blockdh', '', 'dhnode20181202_1700549047', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', 'afd', NULL, '', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-02 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(1003, 'vblock20181209_1119122979', 'blockdh', '', 'dhnode20181209_1152535834', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '评价1', NULL, '20181209_115447_3369.jpg', '', '', NULL, '', '&lt;p&gt;评价内容。。。评价内容。。。评价内容。。。评价内容。。。&lt;/p&gt;\r\n\r\n&lt;p&gt;评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。&lt;/p&gt;', '', 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##李四==#==titlebz2:##CTO==#==titlebz3:##', 0, 0, 10000, '', '2018-12-09 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(1004, 'vblock20181209_1119122979', 'blockdh', '', 'dhnode20181209_1152596069', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '评价2', NULL, '20181209_115435_6029.jpg', '', '', NULL, '', '&lt;p&gt;评价内容222。。。评价内容222。。。评价内容222。。。评价内容222。。。&lt;/p&gt;\r\n\r\n&lt;p&gt;评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。评价内容。。。&lt;/p&gt;', '', 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##张三==#==titlebz2:##CFO==#==titlebz3:##', 0, 0, 10000, '', '2018-12-09 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(1005, 'vblock20181209_1118582514', 'blockdh', '', 'dhnode20181209_1334101429', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '1', NULL, '20181209_133541_5008.png', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-09 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(1006, 'vblock20181209_1118582514', 'blockdh', '', 'dhnode20181209_1334168042', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '2', NULL, '20181209_133553_3103.png', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-09 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(1007, 'vblock20181209_1118582514', 'blockdh', '', 'dhnode20181209_1334217265', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '3', NULL, '20181209_133609_9724.png', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-09 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(1008, 'vblock20181209_1118582514', 'blockdh', '', 'dhnode20181209_1334274757', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '4', NULL, '20181209_133616_3001.png', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-09 00:00:00', NULL, NULL, NULL, '', NULL, NULL),
(1009, 'vblock20181209_1118582514', 'blockdh', '', 'dhnode20181209_1334325279', 'bh2010079002demososo', NULL, 'cn', 50, 'blockdh', 10, 'n', 'y', 'n', 'n', 'n', 'n', '5', NULL, '20181209_133623_2051.png', '', '', NULL, '', NULL, NULL, 'linkdhtitle:##==#==linkdhurl:##==#==titlebz1:##==#==titlebz2:##==#==titlebz3:##==#==', 0, 0, 10000, '', '2018-12-09 00:00:00', NULL, NULL, NULL, '', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_nodetext`
--

CREATE TABLE `zzz_nodetext` (
  `id` int(11) NOT NULL,
  `pbh` varchar(100) NOT NULL,
  `pidname` varchar(100) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `pid` text,
  `type` varchar(50) NOT NULL DEFAULT 'node',
  `type2` varchar(50) NOT NULL DEFAULT 'nodeprocan',
  `desp` text,
  `desptext` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_nodetext`
--

INSERT INTO `zzz_nodetext` (`id`, `pbh`, `pidname`, `lang`, `pid`, `type`, `type2`, `desp`, `desptext`) VALUES
(1020, 'bh2010079002demososo', 'ndtext20181122_1037319600', 'cn', 'node20150806_0929404264', 'node', 'nodeprocan', '&lt;p&gt;应用范围 ：MSK-115A-S真空预封机可应用于软包装锂电池真空预封口工艺。本机设计紧凑，可放置到手套箱内使用，并可实现抽真空和加热封口功能。该设备工作腔室真空度保持度好，封口效果优质，电池成品平整度好。&lt;br /&gt;\r\n产品型号 ：MSK-115A-S&lt;br /&gt;\r\n上架时间 ：2018-11-20&lt;br /&gt;\r\n产品尺寸 ：410mm&amp;times;365mm&amp;times;520mm&lt;br /&gt;\r\n重量 ：约45KG&lt;br /&gt;\r\n价格 ：￥ 38000.00&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20190305_182611_9228.png&quot; style=&quot;height:172px; width:602px&quot; /&gt;&lt;/p&gt;', ''),
(1019, 'bh2010079002demososo', 'ndtext20181122_1036556561', 'cn', 'node20150806_0929404264', 'node', 'nodeotherinfo', '&lt;p&gt;22222222222&lt;/p&gt;\r\n\r\n&lt;p&gt;asdfasdfasdf&lt;img alt=&quot;显示图片&quot; src=&quot;imgpath_3qys0o_comimage/cn/20180315_123721_1520.jpg?v=3865&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', ''),
(1022, 'bh2010079002demososo', 'ndtext20190107_1210135830', 'cn', 'node20150806_0916371045', 'node', 'nodeprocan', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_page`
--

CREATE TABLE `zzz_page` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL DEFAULT '0',
  `pidname` varchar(100) NOT NULL,
  `pbh` varchar(50) NOT NULL DEFAULT 'n',
  `regionid` varchar(50) DEFAULT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(225) DEFAULT NULL,
  `cssname` varchar(50) DEFAULT NULL,
  `sta_noaccess` char(1) NOT NULL DEFAULT 'n',
  `sta_visible` varchar(1) NOT NULL DEFAULT 'y',
  `pos` int(3) DEFAULT '50',
  `kv` varchar(100) DEFAULT NULL,
  `kvtitle` varchar(200) DEFAULT NULL,
  `desp` text,
  `desptext` text,
  `arr_can` text,
  `seo1` text,
  `seo2` text,
  `seo3` text,
  `alias_jump` varchar(100) NOT NULL COMMENT 'just for get_link.'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_page`
--

INSERT INTO `zzz_page` (`id`, `pid`, `pidname`, `pbh`, `regionid`, `lang`, `name`, `cssname`, `sta_noaccess`, `sta_visible`, `pos`, `kv`, `kvtitle`, `desp`, `desptext`, `arr_can`, `seo1`, `seo2`, `seo3`, `alias_jump`) VALUES
(6, '0', 'page20150805_1138522811', 'bh2010079002demososo', '', 'cn', '集团介绍', '', 'n', 'y', 500, '', '', '&lt;p&gt;&lt;img alt=&quot;集团介绍 &quot; src=&quot;imgpath_3qys0o_comimage/cn/20150805_113942_1804.jpg&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:26px&quot;&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;strong&gt;DM企业建站企业建站系统&lt;/strong&gt;(www.demososo.com)&lt;/span&gt;&lt;/a&gt;&lt;span style=&quot;color:#ff0000&quot;&gt; 是自主开发的一套面向中小企业建站的系统。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;span style=&quot;font-size:26px&quot;&gt;操作简单，维护方便。前台绝大多数的内容都可以在后台维护管理。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;[DMblockid]album20180525_1153443284[/DMblockid]&lt;/p&gt;\r\n\r\n&lt;p&gt;[DMblockid]video20180524_1839345521[/DMblockid]&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:26px&quot;&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;strong&gt;DM企业建站企业建站系统&lt;/strong&gt;(www.demososo.com)&lt;/span&gt;&lt;/a&gt;&lt;span style=&quot;color:#ff0000&quot;&gt; 是自主开发的一套面向中小企业建站的系统。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;span style=&quot;font-size:26px&quot;&gt;操作简单，维护方便。前台绝大多数的内容都可以在后台维护管理。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;font-size:26px&quot;&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;strong&gt;DM企业建站企业建站系统&lt;/strong&gt;(www.demososo.com)&lt;/span&gt;&lt;/a&gt;&lt;span style=&quot;color:#ff0000&quot;&gt; 是自主开发的一套面向中小企业建站的系统。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;span style=&quot;color:#ff0000&quot;&gt;&lt;span style=&quot;font-size:26px&quot;&gt;操作简单，维护方便。前台绝大多数的内容都可以在后台维护管理。&lt;/span&gt;&lt;/span&gt;&lt;/p&gt;', '', 'downloadtitle:##==#==downloadurl:##==#==linkmoretitle:##==#==linkmore:##asdf', '', '', '', ''),
(160, '0', 'page20181217_1728381650', 'bh2010079002demososo', '', 'cn', 'test', NULL, 'n', 'y', 50, NULL, NULL, '&lt;p&gt;test ，作为子单页面&amp;nbsp;测试。&lt;/p&gt;', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', NULL, NULL, NULL, ''),
(8, '0', 'page20150805_1143268522', 'bh2010079002demososo', '', 'cn', '团队建设', '', 'n', 'y', 500, '', '', '&lt;p&gt;&lt;span style=&quot;color:red; font-size:18px&quot;&gt;&lt;strong&gt;&lt;a href=&quot;http://www.demososo.com/detail-100.html&quot; target=&quot;_blank&quot;&gt;如何设置页面的侧边栏的位置?是在左边还是在右边，或是在上面？&lt;/a&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设&lt;/p&gt;\r\n\r\n&lt;p&gt;团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设&lt;/p&gt;\r\n\r\n&lt;p&gt;团队建设团队建设团队建设团队建设团队建设团队建设&lt;/p&gt;\r\n\r\n&lt;p&gt;团队建设团队建设团队建设团队建设团队建设团队建设&lt;/p&gt;\r\n\r\n&lt;p&gt;团队建设团队建设团队建设团队建设团队建设团队建设&lt;/p&gt;\r\n\r\n&lt;p&gt;团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设团队建设&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20150805_114410_5513.jpg&quot; style=&quot;height:209px; width:355px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', '团队建设团队建设团队建设', 'kkk团队建设', 'ddd团队建设团队建设团队建设团队建设团队建设团队建设', ''),
(10, '0', 'page20150806_0435579851', 'bh2010079002demososo', '', 'cn', '人才招聘', '', 'n', 'y', 110, '', '', '&lt;p&gt;&lt;strong&gt;品牌经理职位&lt;/strong&gt;&lt;br /&gt;\r\n岗位职责：&lt;br /&gt;\r\n1、根据品牌发展策略负责发展品牌推广创意策略以及媒介策略；实施并监督管理。协调其他传播推广工具如PR与品牌调性关系；&lt;br /&gt;\r\n2、品牌研究负责通过产业广告投放情况以及媒介投放监测进行定性与定量的研究。分析其SWOT。以对品牌长期策略的发展起参考作用。为品牌资产的建立以及品牌管理提供直接资料与数据。&lt;br /&gt;\r\n3、完善企业视觉识别体系：如渠道、合作伙伴、供应商、管理企业品牌树（品牌架构）；&lt;br /&gt;\r\n4、内部品牌传播以及品牌管理规范如品牌手册的发展；&lt;br /&gt;\r\n5、分解企业竞争战略； 6、协助制定产品开发计划并与研发以及产品部门共同组织实施；&lt;br /&gt;\r\n7、协助确定产品的经营和竞争战略；&lt;br /&gt;\r\n8、编制年度营销计划和进行营销预测；&lt;br /&gt;\r\n9、管理产品品牌资产并不断优化以获得品牌竞争优势。（视乎产业竞争状况）；&lt;br /&gt;\r\n任职资格：&lt;br /&gt;\r\n5年以上相关工作经验，组织和沟通能力强、工作经验要求，在互联网/电商企业工作者优先。&lt;br /&gt;\r\n&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;strong&gt;媒介经理职位&lt;/strong&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;岗位职责：&lt;br /&gt;\r\n拟定媒体投放计划及方案、编制公司年度广告预算。开拓整合媒体资源并进行有效管理及合作谈判、合同签订及维护管理、管理媒体投放效果的跟踪监测等、制定媒介资源数去库的更新和维护标准及监督实施、维护媒体关系，与媒体建立长期稳定的合作关系负责联络、拓展及维护媒体关系，进行媒体资源整合和维护；&lt;br /&gt;\r\n任职资格：&lt;br /&gt;\r\n本科及以上学历，3年以上相关工作经验，沟通能力强，协调组织能力强，逻辑思路清晰，熟练运用各种办公软件。&lt;/p&gt;', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', NULL, NULL, NULL, ''),
(11, '0', 'page20150806_0436437668', 'bh2010079002demososo', 'imgtext20190403_1838395607', 'cn', '联系我们', '', 'n', 'y', 100, '', '', '', '', 'sta_noaccess:##n==#==pagelayout:##allwidth==#==downloadurl:##==#==seocus1:##eee==#==seocus2:##==#==seocus3:##', '', '', '', ''),
(21, '0', 'page20151015_0855506815', 'bh2010079002demososo', NULL, 'cn', '友情链接', '', 'n', 'y', 1, '', '', '&lt;p&gt;&lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt; | &lt;a href=&quot;http://www.baidu.com&quot; target=&quot;_blank&quot;&gt;百度&lt;/a&gt; | &lt;a href=&quot;http://www.Opencart.com&quot; target=&quot;_blank&quot;&gt;opencart购物系统&lt;/a&gt; | &lt;a href=&quot;http://www.demososo.com&quot; target=&quot;_blank&quot;&gt;DM企业建站系统&lt;/a&gt; | &lt;a href=&quot;http://www.baidu.com&quot; target=&quot;_blank&quot;&gt;百度&lt;/a&gt; | &lt;a href=&quot;http://www.Opencart.com&quot; target=&quot;_blank&quot;&gt;opencart购物系统&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&amp;nbsp;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&amp;nbsp;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&amp;nbsp;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&amp;nbsp;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;span style=&quot;line-height: 20.7999992370605px;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;span style=&quot;line-height: 20.7999992370605px;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;span style=&quot;line-height: 20.7999992370605px;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;span style=&quot;line-height: 20.7999992370605px;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;span style=&quot;line-height: 20.7999992370605px;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;span style=&quot;line-height: 20.7999992370605px;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;span style=&quot;line-height: 20.7999992370605px;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;span style=&quot;line-height: 20.7999992370605px;&quot;&gt;&amp;nbsp;&lt;/span&gt;&lt;a href=&quot;http://www.dlut.edu.cn/&quot; style=&quot;line-height: 20.7999992370605px;&quot; target=&quot;_blank&quot;&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_085813_2221.gif&quot; style=&quot;opacity: 0.9; width: 140px; height: 50px;&quot; /&gt;&lt;/a&gt;&lt;/p&gt;', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==videourl:##==#==videotitle:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', '11', '1111', '111', ''),
(22, '0', 'page20151015_0911225612', 'bh2010079002demososo', NULL, 'cn', '企业资质', '', 'n', 'y', 500, '', '', '&lt;p&gt;&lt;span style=&quot;color:red; font-size:18px&quot;&gt;&lt;strong&gt;&lt;a href=&quot;http://www.demososo.com/detail-100.html&quot; target=&quot;_blank&quot;&gt;如何设置页面的侧边栏的位置?是在左边还是在右边，或是在上面？&lt;/a&gt;&lt;/strong&gt;&lt;/span&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20151015_091438_6322.jpg&quot; style=&quot;height:460px; width:615px&quot; /&gt;&lt;/p&gt;', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', NULL, NULL, NULL, ''),
(33, '0', 'page20160307_1115284044', 'bh2010079002demososo', '', 'cn', '网站首页', '', 'n', 'y', 1000, '', '', '', '', 'downloadtitle:##==#==downloadurl:##==#==linkmoretitle:##==#==linkmore:##==#==detail_albumid:##==#==detail_videoid:##==#==detail_musicid:##', 'index - 修改单页面-首页的seo', 'asas', 'asfas', ''),
(59, '0', 'page20160930_1202132274', 'bh2010079002demososo', NULL, 'cn', '视频和下载', NULL, 'n', 'y', 50, NULL, NULL, '', '', 'downloadtitle:##==#==downloadurl:##==#==linkmoretitle:##==#==linkmore:##==#==detail_albumid:##==#==detail_videoid:##==#==detail_musicid:##', NULL, NULL, NULL, ''),
(65, '0', 'page20161207_1036569778', 'bh2010079002demososo', '', 'cn', '集团文化', NULL, 'n', 'y', 500, NULL, NULL, '&lt;p&gt;&lt;img alt=&quot;&quot; src=&quot;imgpath_3qys0o_comimage/cn/20170423_181014_5749.jpg&quot; style=&quot;height:181px; width:502px&quot; /&gt;&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;\r\n\r\n&lt;p&gt;集团文化集团文化集团文化集团文化集团文化集团文化集团文化集团文化集团文化&lt;/p&gt;\r\n\r\n&lt;p&gt;集团文化集团文化集团文化集团文化集团文化集团文化集团文化&lt;/p&gt;\r\n\r\n&lt;p&gt;集团文化集团文化集团文化集团文化集团文化集团文化集团文化集团文化集团文化集团文化&lt;/p&gt;\r\n\r\n&lt;p&gt;集团文化集团文化集团文化&lt;/p&gt;\r\n\r\n&lt;p&gt;集团文化集团文化集团文化集团文化集团文化集团文化集团文化&lt;/p&gt;\r\n\r\n&lt;p&gt;集团文化集团文化集团文化集团文化集团文化集团文化集团文化集团文化集团文化集团文化&lt;/p&gt;\r\n\r\n&lt;p&gt;&amp;nbsp;&lt;/p&gt;', '', 'downloadtitle:##==#==downloadurl:##==#==linkmoretitle:##==#==linkmore:##==#==detail_albumid:##==#==detail_videoid:##==#==detail_musicid:##', NULL, NULL, NULL, ''),
(161, '0', 'page20190102_1814157870', 'bh2010079002demososo', '', 'cn', '搜索页面', NULL, 'n', 'y', 50, NULL, NULL, '', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', NULL, NULL, NULL, ''),
(173, '0', 'page20190311_1431198444', 'bh2010079002demososo', 'dmregion_101', 'cn', '酷模板 - 红酒', NULL, 'n', 'y', 0, NULL, NULL, '', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', NULL, NULL, NULL, ''),
(171, '0', 'page20190227_1749231026', 'bh2010079002demososo', 'dmregion_100', 'cn', '酷模板 - bootstap简约', NULL, 'n', 'y', 0, NULL, NULL, '', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', NULL, NULL, NULL, ''),
(177, '0', 'page20190401_1835494002', 'bh2010079002demososo', 'imgtext20190401_1331404648', 'cn', '图文生成器-scroll fix', NULL, 'n', 'y', 50, NULL, NULL, '', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', NULL, NULL, NULL, ''),
(178, '0', 'page20190401_1835598959', 'bh2010079002demososo', 'imgtext20190401_1332183787', 'cn', '图文生成器-default', NULL, 'n', 'y', 50, NULL, NULL, '', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', NULL, NULL, NULL, ''),
(179, '0', 'page20190401_1836112105', 'bh2010079002demososo', 'imgtext20190401_1332124432', 'cn', '图文生成器-tab', NULL, 'n', 'y', 50, NULL, NULL, '', '', 'sta_noaccess:##n==#==pagelayout:##noallwidth==#==downloadurl:##==#==seocus1:##==#==seocus2:##==#==seocus3:##', NULL, NULL, NULL, '');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_region`
--

CREATE TABLE `zzz_region` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL,
  `pbh` varchar(50) NOT NULL,
  `pidstylebh` varchar(100) NOT NULL DEFAULT 'common',
  `pidname` varchar(100) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `template` varchar(100) DEFAULT 'region.php',
  `pos` int(3) DEFAULT '50',
  `sta_visible` char(1) NOT NULL DEFAULT 'y',
  `blockid` varchar(100) DEFAULT NULL,
  `dateedit` datetime DEFAULT NULL,
  `arr_cfg` text,
  `addcss` text NOT NULL,
  `addjs` text NOT NULL,
  `dmregdir` varchar(100) DEFAULT NULL,
  `despjj` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_region`
--

INSERT INTO `zzz_region` (`id`, `pid`, `pbh`, `pidstylebh`, `pidname`, `lang`, `name`, `template`, `pos`, `sta_visible`, `blockid`, `dateedit`, `arr_cfg`, `addcss`, `addjs`, `dmregdir`, `despjj`) VALUES
(924, '0', 'bh2010079002demososo', 'dmregion01', 'region20181208_1123378424', 'cn', 'wwwwwwwwwwww', 'region.php', 50, 'y', NULL, '2018-12-08 11:23:37', NULL, 'assets/vendor/bxslider/jquery.bxslider.css|\nassets/vendor/owl-carousel/owl.carousel.css|\nassets/vendor/owl-carousel/owl.theme.css|\nbootstrap.css|\ncolors.css', 'assets/vendor/owl-carousel/owl.carousel.min.js|\nassets/vendor/bxslider/jquery.bxslider.min.js', NULL, NULL),
(925, '0', 'bh2010079002demososo', 'dmregion01', 'region20181208_1123437624', 'cn', 'fffffff', 'region.php', 50, 'y', NULL, '2018-12-08 11:23:43', NULL, 'dddaf|\nasdffds', 'asfdasf|\nasdfdsf', NULL, NULL),
(926, 'region20181208_1123378424', 'bh2010079002demososo', 'common', 'sreg20181208_1228313485', 'cn', '11', 'region.php', 50, 'y', 'dmregionjc01', '2018-12-08 12:28:31', 'reganchor:##==#==cssname:##==#==cssstyle:##==#==sta_title:##n==#==sta_width_title:##y==#==sta_width_cnt:##n==#==titleimg:##==#==titlestyle:##==#==titlestylesub:##==#==titlelinelong:##==#==titlelineshort:##==#==linktitle:##==#==linkurl:##==#==bgcolor:##==#==bgimg:##==#==bgposi:##center center==#==bgattach:##fixed==#==bgrepeat:##no-repeat==#==bgsize:##cover', '', '', NULL, ''),
(959, '0', 'bh2010079002demososo', 'style20160506_1242421660', 'region20190311_1254537603', 'cn', '1', 'region.php', 50, 'y', NULL, '2019-03-11 12:54:53', NULL, '', '', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `zzz_style`
--

CREATE TABLE `zzz_style` (
  `id` int(11) NOT NULL,
  `pid` varchar(50) NOT NULL DEFAULT '0',
  `pidname` varchar(60) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `pbh` varchar(50) NOT NULL DEFAULT 'n',
  `title` varchar(20) NOT NULL DEFAULT 'pls input title',
  `pidmenu` varchar(100) DEFAULT NULL,
  `pidregion` varchar(60) DEFAULT NULL,
  `pidregionmobile` varchar(100) DEFAULT NULL,
  `pos` int(3) NOT NULL DEFAULT '50',
  `htmldir` varchar(100) DEFAULT NULL,
  `header_pc` varchar(100) NOT NULL DEFAULT 'pc_header_menu_bottom',
  `header_mobile` varchar(100) NOT NULL DEFAULT 'header_mobile.php',
  `skincss` varchar(100) NOT NULL DEFAULT 'skin_blue.css',
  `kv` varchar(100) DEFAULT NULL,
  `sta_visible` char(1) NOT NULL DEFAULT 'y',
  `sta_sqlcss` char(1) NOT NULL DEFAULT 'y',
  `sta_bootstrap` char(1) NOT NULL DEFAULT 'n',
  `style_normal` text,
  `style_hf` text,
  `style_menu` text,
  `style_banner` text,
  `style_boxtitle` text,
  `style_blockid` text,
  `desp` text,
  `despsql` text,
  `type` varchar(20) DEFAULT 'pc' COMMENT 'pc or mobile',
  `addcss` text,
  `addjs` text,
  `addDMcssjs` char(1) NOT NULL DEFAULT 'y',
  `dateedit` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_style`
--

INSERT INTO `zzz_style` (`id`, `pid`, `pidname`, `lang`, `pbh`, `title`, `pidmenu`, `pidregion`, `pidregionmobile`, `pos`, `htmldir`, `header_pc`, `header_mobile`, `skincss`, `kv`, `sta_visible`, `sta_sqlcss`, `sta_bootstrap`, `style_normal`, `style_hf`, `style_menu`, `style_banner`, `style_boxtitle`, `style_blockid`, `desp`, `despsql`, `type`, `addcss`, `addjs`, `addDMcssjs`, `dateedit`) VALUES
(3, '0', 'style20160506_1242421660', 'cn', 'bh2010079002demososo', '橙色 - 简约 sky01', 'menu20161129_1804453928', 'imgtext20190403_1453115152', '', 155, 'sky01', 'header_menu_floatsimple.php', '', 'skin_orange.css', '20180530_181634_3293.jpg', 'y', 'y', 'n', 'pagewidth:##1200px==#==body_bgcolor:##==#==body_bgimg:##==#==body_bgimgset:##norepeat==#==color_body:###000==#==color_a:###666==#==color_ahover:###FF6634', 'bodynarrow:##n==#==bodybg:##none==#==contentwrapbg:###fff==#==bodycolor:###000==#==color_a:###333==#==color_ahover:###3DA8E0==#==headertop_bgcolor:###b5d1ee==#==headertop_color:###000==#==headertop_color_a:###000==#==headertop_color_ahover:###333==#==header_bgcolor:##none==#==footer_bgcolor:###FFB16A==#==footer_color:###DEF0FA==#==footer_color_a:###DEF0FA==#==footer_color_ahover:###2c455e==#==menu_height:##50px==#==menu_border:##none==#==menu_bgcolor:##none==#==menu_color:###333==#==menu_bgcolor_h:##none==#==menu_color_h:###FF7A00==#==msub_height:##30px==#==msub_border:##1px solid #F7CE64==#==msub_bgcolor:###FE972E==#==msub_color:###fff==#==msub_bgcolor_h:###FEAC5A==#==msub_color_h:###fff==#==boxtitle_bgcolor:###3DA8E0==#==boxtitle_color:###fff', 'menu_height:##50px==#==menu_border:##0==#==menu_bgcolor:##==#==menu_bgimg:##==#==menu_color:###000==#==menu_bgcolor_h:##==#==menu_bgimg_h:##==#==menu_color_h:###FF7A00==#==msub_height:##30px==#==msub_border:##1px solid  #F7CE64==#==msub_bgcolor:###FE972E==#==msub_color:###e2e2e2==#==msub_bgcolor_h:###FEAC5A==#==msub_color_h:###e2e2e2', 'banner_enable:##n==#==banner_textfirst:##y==#==banner_style:##padding-top:150px;padding-bottom:130px==#==banner_bgcolor:##red==#==banner_bgimg:##==#==banner_color:###333', 'boxtitle_height:##40px==#==boxtitle_bgcolor:###FF8719==#==boxtitle_bgimg:##==#==boxtitle_color:###fff', 'bsbanner:##vblock20170419_1630345041==#==bsbannermob:##vblock20170419_1639427863==#==bsheadertop:##==#==bsheaderlogo:##20160812_042415_1315.png==#==bsheaderlogomobi:##20181220_150212_4949.jpg==#==bsheadertext:##==#==bsheadersearch:##prog_searchinput==#==bsfooter:##group20190404_1205003166==#==bsfootermob:##vblock20181221_1033067548==#==bsfooterlast:##group20170920_1717255504==#==bsblock404:##vblock20160510_1000376089', '', '', 'pc', 'assets/vendor/singlecss/animate.css|\nassets/vendor/singlecss/font-awesome.css', '', 'y', '2016-05-06 12:42:42'),
(18, '0', 'style20160721_0855323118', 'cn', 'bh2010079002demososo', '蓝色企业网站 skyblue [免费]', 'menu20161129_1804453928', 'imgtext20190403_1453115152', '', 150, 'skyblue', 'header_menu_bottom.php', '', 'skin_blue.css', '20160923_090432_3316.jpg', 'y', 'y', 'y', 'sta_widthscreen:##y==#==pagewidth:##1200px==#==body_bgcolor:##==#==body_bgimg:##==#==body_bgimgset:##norepeat==#==color_body:###000==#==color_a:###333==#==color_ahover:###3DA8E0', 'bodynarrow:##n==#==bodybg:##none==#==contentwrapbg:###fff==#==bodycolor:###000==#==color_a:###1688D3==#==color_ahover:###3DA8E0==#==headertop_bgcolor:###b5d1ee==#==headertop_color:###000==#==headertop_color_a:###000==#==headertop_color_ahover:###333==#==header_bgcolor:##none==#==footer_bgcolor:###3DA8E0==#==footer_color:###DEF0FA==#==footer_color_a:###DEF0FA==#==footer_color_ahover:###2c455e==#==menu_height:##60px==#==menu_border:##none==#==menu_bgcolor:###12A7ED==#==menu_color:###fff==#==menu_bgcolor_h:###43BDF8==#==menu_color_h:###fff==#==msub_height:##30px==#==msub_border:##1px solid #7ECFF5==#==msub_bgcolor:###43BDF8==#==msub_color:###fff==#==msub_bgcolor_h:###20B3F6==#==msub_color_h:###fff==#==boxtitle_bgcolor:###3DA8E0==#==boxtitle_color:###fff', 'menu_height:##60px==#==menu_border:##0==#==menu_bgcolor:###12A7ED==#==menu_bgimg:##==#==menu_color:###fff==#==menu_bgcolor_h:###43BDF8==#==menu_bgimg_h:##==#==menu_color_h:###fff==#==msub_height:##30px==#==msub_border:##1px solid #7ECFF5==#==msub_bgcolor:###43BDF8==#==msub_color:###fff==#==msub_bgcolor_h:###20B3F6==#==msub_color_h:###fff', 'banner_enable:##n==#==banner_textfirst:##n==#==banner_style:##padding-top:150px;padding-bottom:130px==#==banner_bgcolor:##red==#==banner_bgimg:##==#==banner_color:###333', 'boxtitle_height:##40px==#==boxtitle_bgcolor:###3DA8E0==#==boxtitle_bgimg:##==#==boxtitle_color:###fff', 'bsbanner:##vblock20170419_1630345041==#==bsbannermob:##vblock20170419_1639427863==#==bsheadertop:##group20160509_1200413359==#==bsheaderlogo:##20160812_042415_1315.png==#==bsheaderlogomobi:##20181220_150212_4949.jpg==#==bsheadertext:##vblock20160921_1144538411==#==bsheadersearch:##prog_searchinput==#==bsfooter:##group20190404_1205003166==#==bsfootermob:##==#==bsfooterlast:##group20170920_1717255504==#==bsblock404:##vblock20160510_1000376089', '', '', 'pc', 'assets/vendor/singlecss/animate.css|\nassets/vendor/singlecss/font-awesome.css', '', 'y', '2016-07-21 08:55:32'),
(66, '0', 'style20170426_1846378581', 'cn', 'bh2010079002demososo', '幻灯片全屏sky_full', 'menu20161129_1804453928', 'imgtext20190403_1453115152', '', 50, 'sky_full', 'header_menu_floatbanner.php', '', 'skin_blue.css', '20170426_184816_8533.jpg', 'y', 'y', 'y', 'pagewidth:##1200px==#==body_bgcolor:##none==#==body_bgimg:##==#==body_bgimgset:##norepeat==#==color_body:###000==#==color_a:###666==#==color_ahover:###FF6634', 'bodynarrow:##n==#==bodybg:##none==#==contentwrapbg:###fff==#==bodycolor:###000==#==color_a:###333==#==color_ahover:###3DA8E0==#==headertop_bgcolor:###b5d1ee==#==headertop_color:###000==#==headertop_color_a:###000==#==headertop_color_ahover:###333==#==header_bgcolor:##none==#==footer_bgcolor:###383D61==#==footer_color:###fff==#==footer_color_a:###97C1E7==#==footer_color_ahover:###ebe6b7==#==menu_height:##50px==#==menu_border:##none==#==menu_bgcolor:##none==#==menu_color:###eeeeee==#==menu_bgcolor_h:##none==#==menu_color_h:###e2e2e2==#==msub_height:##30px==#==msub_border:##1px solid #9db5cd==#==msub_bgcolor:###367bba==#==msub_color:###fff==#==msub_bgcolor_h:###97C1E7==#==msub_color_h:###fff==#==boxtitle_bgcolor:###383D61==#==boxtitle_color:###fff', 'menu_height:##50px==#==menu_border:##0==#==menu_bgcolor:##none==#==menu_bgimg:##==#==menu_color:###ccc==#==menu_bgcolor_h:##none==#==menu_bgimg_h:##==#==menu_color_h:###fff==#==msub_height:##35px==#==msub_border:##1px solid #ffac22==#==msub_bgcolor:###FF5722==#==msub_color:###fff==#==msub_bgcolor_h:###ff9122==#==msub_color_h:###fff', 'banner_enable:##y==#==banner_textfirst:##y==#==banner_style:##padding-top:120px;padding-bottom:100px==#==banner_bgcolor:###383d61==#==banner_bgimg:##==#==banner_color:###fff', 'boxtitle_height:##40px==#==boxtitle_bgcolor:###FF5722==#==boxtitle_bgimg:##==#==boxtitle_color:###fff', 'bsbanner:##vblock20171201_1536338532==#==bsbannermob:##==#==bsheadertop:##==#==bsheaderlogo:##20160812_042415_1315.png==#==bsheaderlogomobi:##20181220_150212_4949.jpg==#==bsheadertext:##==#==bsheadersearch:##prog_searchinput==#==bsfooter:##group20190404_1205003166==#==bsfootermob:##==#==bsfooterlast:##group20170920_1717255504==#==bsblock404:##vblock20160510_1000376089', NULL, NULL, 'pc', 'assets/vendor/singlecss/font-awesome.css|\nassets/vendor/singlecss/animate.css', '', 'y', '2017-04-26 18:46:37'),
(96, '0', 'style20171022_1025054134', 'cn', 'bh2010079002demososo', '单页面模板 sky_danye', 'menu20171022_1200255763', 'imgtext20190403_1453115152', '', 50, 'sky_danye', 'header_menu_right.php', '', '', '20180209_113703_8877.jpg', 'y', 'y', 'n', 'pagewidth:##1200px==#==body_bgcolor:##==#==body_bgimg:##==#==body_bgimgset:##norepeat==#==color_body:###000==#==color_a:###666==#==color_ahover:###FF6634', 'bodynarrow:##n==#==bodybg:##none==#==contentwrapbg:###fff==#==bodycolor:###000==#==color_a:###333==#==color_ahover:###3DA8E0==#==headertop_bgcolor:###b5d1ee==#==headertop_color:###000==#==headertop_color_a:###000==#==headertop_color_ahover:###333==#==header_bgcolor:##none==#==footer_bgcolor:###FFB16A==#==footer_color:###DEF0FA==#==footer_color_a:###DEF0FA==#==footer_color_ahover:###2c455e==#==menu_height:##50px==#==menu_border:##none==#==menu_bgcolor:##none==#==menu_color:###333==#==menu_bgcolor_h:##none==#==menu_color_h:###FF7A00==#==msub_height:##30px==#==msub_border:##1px solid #F7CE64==#==msub_bgcolor:###FE972E==#==msub_color:###fff==#==msub_bgcolor_h:###FEAC5A==#==msub_color_h:###fff==#==boxtitle_bgcolor:###3DA8E0==#==boxtitle_color:###fff', 'menu_height:##50px==#==menu_border:##0==#==menu_bgcolor:##==#==menu_bgimg:##==#==menu_color:###000==#==menu_bgcolor_h:##==#==menu_bgimg_h:##==#==menu_color_h:###FF7A00==#==msub_height:##30px==#==msub_border:##1px solid  #F7CE64==#==msub_bgcolor:###FE972E==#==msub_color:###e2e2e2==#==msub_bgcolor_h:###FEAC5A==#==msub_color_h:###e2e2e2', 'banner_enable:##n==#==banner_textfirst:##y==#==banner_style:##padding-top:150px;padding-bottom:130px==#==banner_bgcolor:##red==#==banner_bgimg:##==#==banner_color:###333', 'boxtitle_height:##40px==#==boxtitle_bgcolor:###FF8719==#==boxtitle_bgimg:##==#==boxtitle_color:###fff', 'bsbanner:##vblock20170419_1630345041==#==bsbannermob:##vblock20170419_1639427863==#==bsheadertop:##==#==bsheaderlogo:##20160812_042415_1315.png==#==bsheaderlogomobi:##20181220_150212_4949.jpg==#==bsheadertext:##==#==bsheadersearch:##prog_searchinput==#==bsfooter:##group20190404_1205003166==#==bsfootermob:##==#==bsfooterlast:##group20170920_1717255504==#==bsblock404:##vblock20160510_1000376089', NULL, NULL, 'pc', 'assets/vendor/singlecss/animate.css|\nassets/vendor/singlecss/font-awesome.css', '', 'y', '2017-10-22 10:25:05'),
(97, '0', 'style20171123_1856515884', 'cn', 'bh2010079002demososo', 'sky02menu', 'menu20161129_1804453928', 'imgtext20190403_1453115152', '', 50, 'sky02menu', 'usercurmb', '', '', '20171207_152259_7074.jpg', 'y', 'y', 'n', 'pagewidth:##1200px==#==body_bgcolor:##==#==body_bgimg:##==#==body_bgimgset:##norepeat==#==color_body:###000==#==color_a:###666==#==color_ahover:###FF6634', 'bodynarrow:##y==#==bodybg:##==#==contentwrapbg:##==#==bodycolor:##==#==color_a:##==#==color_ahover:##==#==headertop_bgcolor:##==#==headertop_color:##==#==headertop_color_a:##==#==headertop_color_ahover:##==#==header_bgcolor:###fff==#==footer_bgcolor:###FFB16A==#==footer_color:###DEF0FA==#==footer_color_a:###DEF0FA==#==footer_color_ahover:###fff==#==menu_height:##==#==menu_border:##==#==menu_bgcolor:##==#==menu_color:##==#==menu_bgcolor_h:##==#==menu_color_h:##==#==msub_height:##==#==msub_border:##==#==msub_bgcolor:##==#==msub_color:##==#==msub_bgcolor_h:##==#==msub_color_h:##==#==boxtitle_bgcolor:##==#==boxtitle_color:##', 'menu_height:##50px==#==menu_border:##0==#==menu_bgcolor:##==#==menu_bgimg:##==#==menu_color:###000==#==menu_bgcolor_h:##==#==menu_bgimg_h:##==#==menu_color_h:###FF7A00==#==msub_height:##30px==#==msub_border:##1px solid  #F7CE64==#==msub_bgcolor:###FE972E==#==msub_color:###e2e2e2==#==msub_bgcolor_h:###FEAC5A==#==msub_color_h:###e2e2e2', 'banner_enable:##n==#==banner_textfirst:##y==#==banner_style:##padding-top:150px;padding-bottom:130px==#==banner_bgcolor:##red==#==banner_bgimg:##==#==banner_color:###333', 'boxtitle_height:##40px==#==boxtitle_bgcolor:###FF8719==#==boxtitle_bgimg:##==#==boxtitle_color:###fff', 'bsbanner:##vblock20171220_1120341606==#==bsbannermob:##==#==bsheadertop:##==#==bsheaderlogo:##20160812_042415_1315.png==#==bsheaderlogomobi:##==#==bsheadertext:##==#==bsheadersearch:##prog_searchinput==#==bsfooter:##group20190404_1205003166==#==bsfootermob:##==#==bsfooterlast:##group20170920_1717255504==#==bsblock404:##vblock20160510_1000376089', NULL, NULL, 'pc', 'assets/vendor/singlecss/font-awesome.css|\nassets/vendor/singlecss/animate.css', '', 'y', '2017-11-23 18:56:51');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_tag`
--

CREATE TABLE `zzz_tag` (
  `id` int(11) NOT NULL,
  `sta_visible` char(1) NOT NULL DEFAULT 'n',
  `pid` varchar(50) NOT NULL DEFAULT '0',
  `pidname` varchar(50) NOT NULL,
  `pbh` varchar(50) NOT NULL DEFAULT 'n',
  `lang` varchar(50) NOT NULL,
  `pos` int(3) NOT NULL DEFAULT '50' COMMENT 'must need',
  `name` varchar(225) DEFAULT NULL,
  `weight` char(1) DEFAULT '1',
  `alias_jump` varchar(100) DEFAULT NULL COMMENT 'no use,just for link.',
  `seo1` text NOT NULL,
  `seo2` text NOT NULL,
  `seo3` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_tag`
--

INSERT INTO `zzz_tag` (`id`, `sta_visible`, `pid`, `pidname`, `pbh`, `lang`, `pos`, `name`, `weight`, `alias_jump`, `seo1`, `seo2`, `seo3`) VALUES
(118, 'y', '0', 'tag20170712_1850111749', 'bh2010079002demososo', 'cn', 50, '足球', '1', NULL, '', '', ''),
(119, 'y', '0', 'tag20170712_1850131707', 'bh2010079002demososo', 'cn', 50, '英语', '1', NULL, 'asdfaasdfasdfa111', 'asdf3333', 'asdfasdf222'),
(128, 'y', '0', 'tag20170714_1125102062', 'bh2010079002demososo', 'cn', 50, '电影', '5', NULL, '电影seo1', '电影关键字1  电影关键字2', '电影描述1 ...电影描述2 ..电影描述3 ... 电影描述1 ...电影描述2 ..电影描述3 ...'),
(121, 'y', '0', 'tag20170713_1214442173', 'bh2010079002demososo', 'cn', 50, '网站', '1', NULL, '', '', ''),
(123, 'y', '0', 'tag20170713_1302125810', 'bh2010079002demososo', 'cn', 50, '学习', '2', NULL, '', '', ''),
(129, 'y', '0', 'tag20170714_1125217248', 'bh2010079002demososo', 'cn', 50, '生活', '1', NULL, '', '', ''),
(135, 'y', '0', 'tag20170717_1519198553', 'bh2010079002demososo', 'cn', 500, '华为', '5', NULL, '', '', ''),
(122, 'y', '0', 'tag20170713_1214489409', 'bh2010079002demososo', 'cn', 50, '科技', '3', NULL, '', '', ''),
(134, 'y', '0', 'tag20170717_1519139951', 'bh2010079002demososo', 'cn', 50, '篮球', '3', NULL, '', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_tagnode`
--

CREATE TABLE `zzz_tagnode` (
  `id` int(11) NOT NULL,
  `sta_visible` char(1) NOT NULL DEFAULT 'n',
  `pbh` varchar(50) NOT NULL DEFAULT 'n',
  `lang` varchar(50) NOT NULL,
  `pos` int(3) NOT NULL DEFAULT '50' COMMENT 'must need',
  `tag` varchar(50) NOT NULL,
  `node` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_tagnode`
--

INSERT INTO `zzz_tagnode` (`id`, `sta_visible`, `pbh`, `lang`, `pos`, `tag`, `node`) VALUES
(90, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170717_1519198553', 'node20150806_0916371045'),
(89, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170714_1125102062', 'node20150806_0916371045'),
(88, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170713_1214489409', 'node20150806_0916371045'),
(87, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170713_1214442173', 'node20150806_0916371045'),
(86, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170712_1850111749', 'node20160406_0930259685'),
(85, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170714_1125102062', 'node20160406_0930259685'),
(84, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170713_1302125810', 'node20160406_0930259685'),
(83, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170713_1214489409', 'node20160406_0930259685'),
(82, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170713_1214442173', 'node20160406_0930259685'),
(81, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170714_1125102062', 'node20160820_0656309862'),
(80, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170713_1214442173', 'node20160820_0656309862'),
(95, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170714_1125102062', 'node20150806_0925599652'),
(96, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170714_1125102062', 'node20150806_0921189784'),
(97, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170713_1214442173', 'node20150806_0929404264'),
(98, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170713_1214489409', 'node20150806_0929404264'),
(99, 'n', 'bh2010079002demososo', 'cn', 50, 'tag20170713_1302125810', 'node20150806_0929404264');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_user`
--

CREATE TABLE `zzz_user` (
  `id` int(9) NOT NULL,
  `userdir` varchar(50) NOT NULL,
  `bh` varchar(50) NOT NULL,
  `lang` varchar(50) NOT NULL DEFAULT 'cn',
  `email` varchar(100) DEFAULT NULL,
  `ps` varchar(100) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `ip` varchar(100) DEFAULT NULL,
  `pos` smallint(3) DEFAULT '50',
  `dateedit` datetime DEFAULT NULL,
  `sqcode` int(3) NOT NULL DEFAULT '0',
  `type` varchar(10) NOT NULL DEFAULT 'normal',
  `previ` varchar(200) DEFAULT NULL,
  `user_stanoaccess` char(1) NOT NULL DEFAULT 'n'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_user`
--

INSERT INTO `zzz_user` (`id`, `userdir`, `bh`, `lang`, `email`, `ps`, `name`, `ip`, `pos`, `dateedit`, `sqcode`, `type`, `previ`, `user_stanoaccess`) VALUES
(77, 'user_20130601_2148331669', 'bh2010079002demososo', '', 'admin', '00Ko3aqrA3ETk', 'name company', '127.0.0.27', 0, '2012-02-26 17:33:33', 0, 'admin', NULL, 'n'),
(99, 'userdir', 'bh2010079002demososo', 'cn', 'test', '00hzYw5m.HyAY', NULL, NULL, 50, '2018-03-16 15:40:01', 0, 'normal', 'cate20150805_1125344029|', 'n');

-- --------------------------------------------------------

--
-- 表的结构 `zzz_video`
--

CREATE TABLE `zzz_video` (
  `id` int(11) NOT NULL,
  `pid` varchar(100) NOT NULL,
  `pidname` varchar(100) NOT NULL,
  `pbh` varchar(100) NOT NULL,
  `lang` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL DEFAULT 'block' COMMENT 'node or page or block',
  `title` varchar(100) DEFAULT NULL,
  `cssname` varchar(100) DEFAULT NULL,
  `pos` int(3) NOT NULL DEFAULT '50',
  `sta_visible` varchar(1) NOT NULL DEFAULT 'y',
  `kv` varchar(100) DEFAULT NULL COMMENT 'fengmian',
  `effect` varchar(50) NOT NULL DEFAULT 'video_default',
  `video` tinytext COMMENT 'mp4',
  `despjj` text,
  `desp` text
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `zzz_video`
--

INSERT INTO `zzz_video` (`id`, `pid`, `pidname`, `pbh`, `lang`, `type`, `title`, `cssname`, `pos`, `sta_visible`, `kv`, `effect`, `video`, `despjj`, `desp`) VALUES
(160, 'common', 'video20180126_1845151600', 'bh2010079002demososo', 'cn', 'block', '小虎队', '', 50, 'y', '', 'video.php', '', '视频说明视频说明视频说明', '&lt;iframe frameborder=&quot;0&quot; width=&quot;640&quot; height=&quot;498&quot; src=&quot;https://v.qq.com/iframe/player.html?vid=b0537w8vdfu&amp;tiny=0&amp;auto=1&quot; allowfullscreen&gt;&lt;/iframe&gt;'),
(175, 'common', 'video20180524_1839345521', 'bh2010079002demososo', 'cn', 'block', 'mp4视频效果', '', 50, 'y', '', 'video.php', 'videotest2.mp4', '测试视频用，文件太大，只播放一小段。', ''),
(192, 'common', 'video20190404_1653337885', 'bh2010079002demososo', 'cn', '', 'aaaaaaaaaaaaaaaaasd', '', 50, 'y', '20190404_171423_2562.jpg', 'video.php', 'aaaaaaaaaaaaaaa', '', ''),
(188, 'common', 'video20181203_1209236319', 'bh2010079002demososo', 'cn', 'block', 'asdfasdf', '', 50, 'y', '', 'video.php', '', '', '&lt;iframe frameborder=&quot;0&quot; width=&quot;640&quot; height=&quot;498&quot; src=&quot;https://v.qq.com/iframe/player.html?vid=b0537w8vdfu&amp;tiny=0&amp;auto=1&quot; allowfullscreen&gt;&lt;/iframe&gt;');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `zzz_album`
--
ALTER TABLE `zzz_album`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_alias`
--
ALTER TABLE `zzz_alias`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_auth`
--
ALTER TABLE `zzz_auth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_authaddress`
--
ALTER TABLE `zzz_authaddress`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_authcart`
--
ALTER TABLE `zzz_authcart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_authcheckout`
--
ALTER TABLE `zzz_authcheckout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_authorder`
--
ALTER TABLE `zzz_authorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_block`
--
ALTER TABLE `zzz_block`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_blockgroup`
--
ALTER TABLE `zzz_blockgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_cate`
--
ALTER TABLE `zzz_cate`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_column`
--
ALTER TABLE `zzz_column`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_comment`
--
ALTER TABLE `zzz_comment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_field`
--
ALTER TABLE `zzz_field`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_fieldoption`
--
ALTER TABLE `zzz_fieldoption`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_fieldvalue`
--
ALTER TABLE `zzz_fieldvalue`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_imgfj`
--
ALTER TABLE `zzz_imgfj`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_imgtext`
--
ALTER TABLE `zzz_imgtext`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_lang`
--
ALTER TABLE `zzz_lang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_layout`
--
ALTER TABLE `zzz_layout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_menu`
--
ALTER TABLE `zzz_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_music`
--
ALTER TABLE `zzz_music`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_node`
--
ALTER TABLE `zzz_node`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_nodetext`
--
ALTER TABLE `zzz_nodetext`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_page`
--
ALTER TABLE `zzz_page`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_region`
--
ALTER TABLE `zzz_region`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_style`
--
ALTER TABLE `zzz_style`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_tag`
--
ALTER TABLE `zzz_tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_tagnode`
--
ALTER TABLE `zzz_tagnode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_user`
--
ALTER TABLE `zzz_user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `zzz_video`
--
ALTER TABLE `zzz_video`
  ADD PRIMARY KEY (`id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `zzz_album`
--
ALTER TABLE `zzz_album`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=291;
--
-- 使用表AUTO_INCREMENT `zzz_alias`
--
ALTER TABLE `zzz_alias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=263;
--
-- 使用表AUTO_INCREMENT `zzz_auth`
--
ALTER TABLE `zzz_auth`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
--
-- 使用表AUTO_INCREMENT `zzz_authaddress`
--
ALTER TABLE `zzz_authaddress`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;
--
-- 使用表AUTO_INCREMENT `zzz_authcart`
--
ALTER TABLE `zzz_authcart`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
--
-- 使用表AUTO_INCREMENT `zzz_authcheckout`
--
ALTER TABLE `zzz_authcheckout`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;
--
-- 使用表AUTO_INCREMENT `zzz_authorder`
--
ALTER TABLE `zzz_authorder`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=162;
--
-- 使用表AUTO_INCREMENT `zzz_block`
--
ALTER TABLE `zzz_block`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1554;
--
-- 使用表AUTO_INCREMENT `zzz_blockgroup`
--
ALTER TABLE `zzz_blockgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=622;
--
-- 使用表AUTO_INCREMENT `zzz_cate`
--
ALTER TABLE `zzz_cate`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;
--
-- 使用表AUTO_INCREMENT `zzz_column`
--
ALTER TABLE `zzz_column`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=352;
--
-- 使用表AUTO_INCREMENT `zzz_comment`
--
ALTER TABLE `zzz_comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=270;
--
-- 使用表AUTO_INCREMENT `zzz_field`
--
ALTER TABLE `zzz_field`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=184;
--
-- 使用表AUTO_INCREMENT `zzz_fieldoption`
--
ALTER TABLE `zzz_fieldoption`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;
--
-- 使用表AUTO_INCREMENT `zzz_fieldvalue`
--
ALTER TABLE `zzz_fieldvalue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- 使用表AUTO_INCREMENT `zzz_imgfj`
--
ALTER TABLE `zzz_imgfj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=413;
--
-- 使用表AUTO_INCREMENT `zzz_imgtext`
--
ALTER TABLE `zzz_imgtext`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=320;
--
-- 使用表AUTO_INCREMENT `zzz_lang`
--
ALTER TABLE `zzz_lang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- 使用表AUTO_INCREMENT `zzz_layout`
--
ALTER TABLE `zzz_layout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1355;
--
-- 使用表AUTO_INCREMENT `zzz_menu`
--
ALTER TABLE `zzz_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=376;
--
-- 使用表AUTO_INCREMENT `zzz_music`
--
ALTER TABLE `zzz_music`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- 使用表AUTO_INCREMENT `zzz_node`
--
ALTER TABLE `zzz_node`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1023;
--
-- 使用表AUTO_INCREMENT `zzz_nodetext`
--
ALTER TABLE `zzz_nodetext`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1024;
--
-- 使用表AUTO_INCREMENT `zzz_page`
--
ALTER TABLE `zzz_page`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=181;
--
-- 使用表AUTO_INCREMENT `zzz_region`
--
ALTER TABLE `zzz_region`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=980;
--
-- 使用表AUTO_INCREMENT `zzz_style`
--
ALTER TABLE `zzz_style`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;
--
-- 使用表AUTO_INCREMENT `zzz_tag`
--
ALTER TABLE `zzz_tag`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;
--
-- 使用表AUTO_INCREMENT `zzz_tagnode`
--
ALTER TABLE `zzz_tagnode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;
--
-- 使用表AUTO_INCREMENT `zzz_user`
--
ALTER TABLE `zzz_user`
  MODIFY `id` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100;
--
-- 使用表AUTO_INCREMENT `zzz_video`
--
ALTER TABLE `zzz_video`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=198;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
