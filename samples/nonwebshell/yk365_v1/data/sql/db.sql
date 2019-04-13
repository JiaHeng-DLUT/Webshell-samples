SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yk365_advers
-- ----------------------------
DROP TABLE IF EXISTS `yk365_advers`;
CREATE TABLE `yk365_advers` (
  `adver_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `adver_name` varchar(50) DEFAULT NULL,
  `adver_url` varchar(255) DEFAULT NULL,
  `adver_code` text DEFAULT NULL ,
  `adver_etips` varchar(50) DEFAULT NULL,
  `adver_days` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `adver_date` int(10) unsigned NOT NULL DEFAULT '0',
  `adver_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 默认关闭 1显示',
  `adver_type` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`adver_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yk365_advers
-- ----------------------------
INSERT INTO `yk365_advers` VALUES ('1', '首页（左侧菜单下方广告位 250*90）', '', '<img src="/themes/default/home/skin/images/4.jpg">', '', '0', '1492331585', '0', '1');
INSERT INTO `yk365_advers` VALUES ('2', '首页左侧广告2（250*90）', '', '<img src="/themes/default/home/skin/images/4.jpg" >', '', '0', '1492331690', '0', '1');
INSERT INTO `yk365_advers` VALUES ('3', '首页看视频上方（1200_90）', '', '<img src="/public/images/ad/1200_90.png">', '', '0', '1492332384', '0', '1');
INSERT INTO `yk365_advers` VALUES ('4', '首页看玩游戏上方（1200_90）', '', '<img src="/public/images/ad/1200_90.png">', '', '0', '1492332443', '0', '1');
INSERT INTO `yk365_advers` VALUES ('5', '首最新点入上方（1200_90）', '', '<img src="/public/images/ad/1200_90.png">', '', '0', '1492332566', '0', '1');
INSERT INTO `yk365_advers` VALUES ('6', '全站底部', '', '<img src="/public/images/ad/1200_90.png">', '', '0', '1492332691', '0', '1');
INSERT INTO `yk365_advers` VALUES ('7', '新闻资讯左侧分类下方（930*90）', '', '<img src="/public/images/ad/930_90.png">', '', '0', '1492333079', '0', '1');
INSERT INTO `yk365_advers` VALUES ('8', '新闻列表右侧（250*200）', '', '<img src="/public/images/ad/250_200.png">', '', '0', '1492333234', '0', '1');
INSERT INTO `yk365_advers` VALUES ('9', '新闻列表热门下方（250*200）', '', '<img src="/public/images/ad/250_200.png">', '', '0', '1492333370', '0', '1');
INSERT INTO `yk365_advers` VALUES ('10', '新闻内容页右侧推荐资讯下方（250*200）', '', '<img src="/public/images/ad/250_200.png">', '', '0', '1492333702', '0', '1');
INSERT INTO `yk365_advers` VALUES ('11', '新闻内容页热门下方（250*200）', '', '<img src="/public/images/ad/250_200.png">', '', '0', '1492333695', '0', '1');
INSERT INTO `yk365_advers` VALUES ('12', '链接大厅列表右侧（250*60）', '', '<img src="/public/images/ad/250_60.png">', '', '0', '1492334439', '0', '1');
INSERT INTO `yk365_advers` VALUES ('13', '链接大厅列表右侧人气下方（250*200）', '', '<img src="/public/images/ad/250_200.png">', '', '0', '1492336051', '0', '1');
INSERT INTO `yk365_advers` VALUES ('14', '链接大厅详情右侧人气下方（250*200）', '', '<img src="/public/images/ad/250_200.png">', '', '0', '1492336218', '0', '1');
INSERT INTO `yk365_advers` VALUES ('15', '网站目录列表左侧下方（930*90）', '', '<img src="/public/images/ad/930_90.png">', '', '0', '1492337231', '0', '1');
INSERT INTO `yk365_advers` VALUES ('16', '网站目录列表右侧下方（250*200）', '', '<img src="/public/images/ad/250_200.png">', '', '0', '1492337953', '0', '1');
INSERT INTO `yk365_advers` VALUES ('17', '网站最新页面广告（250*200）', '', '<img src="/public/images/ad/250_200.png">', '', '0', '1492338804', '0', '1');
INSERT INTO `yk365_advers` VALUES ('18', '首页推荐网址下方（文字广告）', '', '<ul>\r\n   <li><a href="" target="_blank">娱乐八卦</a></li>\r\n    <li class="ad2colorblue"><a href=""  target="_blank">热门关注</a></li>\r\n    <li><a href=""  target="_blank">特价酒店</a></li>\r\n   <li class="ad2colorred"><a href=""  target="_blank">购物特卖</a></li>\r\n   <li><a href=""  target="_blank">教你理财</a></li>\r\n   <li><a href=""  target="_blank">在线教育</a></li>\r\n   <li><a href=""  target="_blank">特价机票</a></li>\r\n   <li class="ad2colororange"><a href=""  target="_blank">9.9元包邮</a></li>\r\n    <li><a href=""  target="_blank">特价旅游</a></li>\r\n   <li class="ad2colorred"><a href=""  target="_blank">经典传奇</a></li>\r\n   <li><a href=""  target="_blank">期中备考</a></li>\r\n   <li class="ad2colorgreen"><a href=""  target="_blank">女神范儿</a></li>\r\n </ul>', '', '0', '1492350324', '0', '1');
INSERT INTO `yk365_advers` VALUES ('19', '首页游戏图文广告', '', '<div class="youkeimg">\r\n<img src="https://p2.ssl.qhimg.com/t01f579aba5c444e58a.jpg"><span>一刀就满级 三秒成土豪</span></div>\r\n<div class="youkeimg">\r\n<img src="https://p3.ssl.qhimg.com/t01b7527dd7180e2c63.jpg">\r\n<span>怒斩千军新手送大礼</span>\r\n</div>\r\n<div class="youkeimg">\r\n<img src="https://p0.ssl.qhimg.com/t01e82ad266927e8d22.jpg">\r\n<span>散人天堂 装备靠打</span>\r\n</div>\r\n<div class="youkeimg">\r\n<img src="https://p2.ssl.qhimg.com/t01c5ba5f4c255983e1.jpg">\r\n<span>完美红颜</span>\r\n</div>\r\n<div class="youkeimg">\r\n<img src="https://p1.ssl.qhimg.com/t0151473c029f722e57.jpg">\r\n<span>最近热玩游戏</span>\r\n</div>\r\n<div class="youkeimg">\r\n<img src="https://p1.ssl.qhimg.com/t011d0cbe5b8368bd91.jpg">\r\n<span>传奇装备回收赚RMB</span>\r\n</div>', '', '0', '1492355323', '0', '1');
INSERT INTO `yk365_advers` VALUES ('20', '首页导航菜单下方（1200*90）', '', '<img src="/public/images/ad/1200_90.png">', '', '0', '1524622393', '0', '1');
INSERT INTO `yk365_advers` VALUES ('21', '手机-首页-顶部广告', '', '这是手机端广告代码', '', '0', '1524706053', '0', '1');
INSERT INTO `yk365_advers` VALUES ('22', '手机-底部-广告', '', '这是手机底部广告', '', '0', '1524706196', '0', '1');

-- ----------------------------
-- Table structure for yk365_articles
-- ----------------------------
DROP TABLE IF EXISTS `yk365_articles`;
CREATE TABLE `yk365_articles` (
  `art_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cate_id` int(5) unsigned NOT NULL DEFAULT '0',
  `art_title` varchar(100) DEFAULT NULL,
  `art_tags` varchar(50) DEFAULT NULL,
  `copy_from` varchar(50) DEFAULT NULL,
  `copy_url` varchar(200) DEFAULT NULL,
  `art_intro` varchar(200) DEFAULT NULL,
  `art_content` text DEFAULT NULL ,
  `art_views` int(10) unsigned NOT NULL DEFAULT '0',
  `art_ispay` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_istop` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_isbest` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `art_utime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`art_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yk365_articles
-- ----------------------------
INSERT INTO `yk365_articles` VALUES ('7', '1', '535', '外媒：中国建成世界最大高铁网 高铁像公交车一样', '高铁', '本站原创', 'http://www.youke365.com/', '英媒称，不到10年前，中国的城市之间还没有高速铁路相连。如今，中国已有超2万公里的高铁线路，超过世界其他地方高铁线路的总和。中国的规划者希望它们会像19世纪在英美涌现的铁路城镇一样。', '<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n 参考消息网1月22日报道 英媒称，不到10年前，中国的城市之间还没有高速铁路相连。如今，<strong>中国已有超2万公里的高铁线路，超过世界其他地方高铁线路的总和。</strong>中国的规划者希望它们会像19世纪在英美涌现的铁路城镇一样。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n 英国《经济学人》周刊网站1月14日报道称，中国计划在2025年建成3.8万公里的高铁线路。同样惊人的是伴随高铁线路的城市发展。几乎凡是有高铁站的地方，即便看似前不着村后不着店的地方，都有密密麻麻的新建办公楼和住宅区拔地而起。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  中国的规划者希望它们会像19世纪在英美涌现的铁路城镇一样。但问题是，收益是否大于损失。在最繁忙的高铁运营5年后（北京-上海高铁在2011年启用），可以得出初步结论了。<strong>在中国最密集的地区，高铁是利好：帮助建立紧密连接的经济。但往内陆去，过度投资的风险不断增加。</strong> \r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n 在中国三大人口中心北上广地区，生活和工作已经开始追随高铁资源。以前火车太少、太慢、太挤，不适用于每日通勤。如今，这三地都在发展通勤走廊。不足为奇，卫星城镇的房价往往要低得多。例如，昆山的房价比附近上海的房价大约低70%。但两地之间的高铁单程只需19分钟，票价25元。而昆山只是试图逃离上海高生活成本的人们可以选择的众多城镇中的一座。目前，大约有7500万人生活在距上海1小时高铁车程的范围内。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  调查结果显示，最繁忙线路上的旅客有一半以上是新增交通量，即以前不会乘坐高铁的旅客。这无疑有利于经济。这意味着高铁正在让中国生产率最高的城市周边的劳动力和消费者群体不断扩大，同时把投资和技术推向较穷的地方。徐向上（音）是卖房子的，他卖的公寓在安徽不那么富裕地区的高铁站旁边。从这些地方坐高铁不到半小时就能到达江苏省省会、人口800万的繁华城市南京。他说：<strong>“高铁正变得像公交车一样。”</strong> \r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  报道称，高铁不仅仅是一种交通工具。中国希望建立“高铁经济”。中国的想法是限制大城市的规模，但在高铁的帮助下实现聚集效应。中国认为，这样产生的大城市网，而非超大城市，将更容易管理。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n 然而，在大城市周边修建可靠和足够快的普通火车几乎和高铁一样好，而成本只是高铁的一小部分。经合组织认为，铺设时速350公里铁路线比铺设时速250公里铁路线的成本高90%以上。对于每年客流量达1亿人次、运行时间较长的线路——比如北京和上海之间，修建成本更高的类型或许是合理的。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  <br />\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  但对于在通勤城镇之间的旅程就不需要这样高成本的铁路线，因为在这样的旅程中火车只会短暂加速至最高速度。对于为少量人口服务的较长旅程来说，高铁成本太过高昂。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  报道称，总花销已经很巨大了。去年，设备制造商中国铁路物资总公司被迫对部分债务进行重组，压力显而易见。6条高铁线路已经开始盈利（不考虑修建成本），去年盈利66亿元人民币，而北京-上海之间的高铁成为世界上盈利最多的高铁。但在人口较少的地区，高铁亏损严重。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n 中国目前有四纵四横的高铁网格，即南北、东西各四条主干线路。它的新计划是在2035年前建成八纵八横的高铁网格。最终目标是拥有4.5万公里高铁线路。\r\n</p>\r\n<p>\r\n <br />\r\n</p>', '8', '0', '0', '0', '3', '1485095835', '0');
INSERT INTO `yk365_articles` VALUES ('5', '1', '535', '人民币贬值：川普第一个不答应', '人民币贬值', '本站原创', 'http://www.youke365.com/', '唐纳德·特朗普，在美国是个非常具有传奇色彩的人物，被冠以美国“地产大亨”、商人、作家、主持人、演员，而现在又多了一个政治家的身份。', '<p style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 唐纳德·特朗普，在美国是个非常具有传奇色彩的人物，被冠以美国“地产大亨”、商人、作家、主持人、演员，而现在又多了一个政治家的身份。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  现在，不仅是美国，特朗普也已经掀开了新的篇章，看来，全球市场还会发生了翻天覆地的变化，毕竟特朗普比较多变，让大多数人参谋不透，他下一步要怎么做。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 不管如何，特朗普既然商场上那么出色，为何不能用商业的原则来治国？“让这个人试试!”，成为许多美国底层白人的普遍呼声。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p2.qhimg.com/t01037fc2e85cecb567.jpg?size=599x336\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 很多美国人已经认定特朗普是一个脑袋好使的成功人士，他当选会给美国带来不同，是的，从他胜选的时候，全球市场发生了翻天覆地的变化，市场快速反弹，这是1960年肯尼迪时代以来从没发生过的。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  特朗普是个“大嘴巴”，过去的几周，世界人民都见识到了，让中国大妈都紧张了，早上吃面的时候，邻桌一位大妈对另一位大妈说，要不要兑换点美元，人民币跌得太厉害了。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 连面馆里的群众都有点坐不住了，人民币与美元，犹如跷跷板，一端上升，另一端就会下沉，金投网小编想对大妈说：大妈别慌，人民币硬着呢！\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 别把这个事情看得太严重，相对美元来说，人民币是贬值的，但是从一篮子货币来看，人民币贬得并不多。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  这里要特别提一下，人民币已经加入SDR货币篮子，从国内来看，人民币没有持续贬值的基础，实际上，汇率的贬值是一个双重的效果，不是单重的效果，比如汇率贬值对出口是有利的。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p0.qhimg.com/t017aaa6b10396fe23d.jpg?size=581x394\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 此外，大洋彼岸是特朗普及其团队很难左右的，而且特朗普是个个相当务实的商人，实行高利率、强美元的货币政策不利于其承诺的经济增长目标的实现。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 对大多数普通中国人来说，其实人民币贬值并没有太大的影响，毕竟面馆里大妈付钱还是用的人民币，不是吗？\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  要说美元强势，全球其他货币都会跌，全球央行看的下去吗？又谁会放任自己家的货币让美元虐呢？这不，全球央行一年内已经抛售4050亿美元。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 这次减持潮中要数中国抛售的力度最大，中国已经连续六个月减持美债，去年10月中国所持美债规模下降了413亿美元，成最大抛售者，而日本则成为“美国头号债主”。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p2.qhimg.com/t013825809e1ace388a.jpg?size=593x398\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 不管我们怎么做，就是川普一个商人也不会看着人民币一直贬值，这对他是没好处的，最近几日，川普对于人民币是神助攻，人民币大涨，特朗普不会对人民币采取强硬举措，也不会将我们列为“货币操纵国”的。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 放人民币贬值，特朗普能答应吗？相反小编觉得特朗普能拉人民币一把，在特朗普眼中，看到的只是中国能带给他的利益，这将从本质上，一定程度的改变中美外交关系，中国也会因此而少受排挤，更加快速的发展！\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  川普打算大干一场，首先就“唱衰”美元，让人民币黄金大涨，对于人民币的涨跌，央行应该有定力，保持淡定，不能因为人民币跌了一点，就进行干预，未来人民币汇率自由浮动是大趋势，要让市场对人民币进行定价。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  川普还在释放这一个信号，会成为黄金最铁的朋友，正在发起金价反弹之势的黄金多头在历史上这种时期的胜算更大。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p9.qhimg.com/t019a29d7551d121887.jpg?size=640x356\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 从近代美国总统职位交接在交易员中激起对黄金未来的乐观主义来看，自1970年代以来，在历届新总统的就职所在年份金价的平均涨幅将近15%。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  从1974年截至2016年，共有7位新任美国总统就职，在这7个年份中，金价录得上涨的年份为5年，相形之下，标普500股票指数有4年录得下跌，在此期间的平均跌幅为0.9%。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  黄金多头们认为，由于特朗普财政刺激计划缺乏细节，加之美国与包括中国在内等贸易伙伴之间的紧张关系，金价有望进一步扩大涨幅。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 2017年投资黄金需把握以下三大趋势：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p1.qhimg.com/t014050a6f7294e2747.jpg?size=640x454\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 政治和地缘政治风险：美国方面的风险最有可能引爆黄金的避险吸引力，尤其是美国新任总统特朗普的贸易协议谈判需要特别关注。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 货币贬值：近年来，美国和全球其他国家之间的货币政策逐渐出现分歧，实际上，多年来，作为交换工具的黄金早已超越大多数主要货币，黄金和疲软货币之间的分化也可能刺激黄金的投资需求。\r\n</p>', '28', '0', '0', '0', '3', '1485095411', '0');
INSERT INTO `yk365_articles` VALUES ('6', '1', '535', '周立波 你咋能这么怂呢?我就不信，警察敢开枪打你', '周立波', '本站原创', 'http://www.youke365.com/', '周立波日前在美国被抓，真是丢人丢大发丢到家了丢国外去了...真是搞不懂，你咋能这么怂呢?', '<p style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  周立波日前在美国被抓，真是丢人丢大发丢到家了丢国外去了...真是搞不懂，你咋能这么怂呢?\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 警察拦你，你就停车了?停就停了，你为啥不看人家警官证呢?不问问他们是否有执法证呢?不看警官证也就罢了，你为啥不打911叫巡警来看是不是真警察呢?\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p3.qhimg.com/t016fb997b9dc3fa2b0.jpg?size=450x315\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" />\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  警察说搜，你就让搜了?凭什么?!冲上去扇人耳光啊~把自己衣服撕开~再躺地上打滚，大喊:救命，警察打人了呀~\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  你为什么不朝对方吼:把你们局长叫来!\r\n</p>', '13', '0', '0', '0', '3', '1485095511', '0');
INSERT INTO `yk365_articles` VALUES ('8', '1', '535', '感觉赵薇被整个娱乐圈抛弃了！', '娱乐圈', '本站原创', 'http://www.youke365.site/', '要说现在“示爱”最简单的方式非他莫属了——手动“笔芯”', '<p class=\"text\" style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 要说现在“示爱”最简单的方式非他莫属了——手动“笔芯”\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p5.qhimg.com/t01fe208ae02b914765.jpg?size=642x268\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  男女老少要是不比个心都不好意思说自己是爱豆\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p5.qhimg.com/t01b4e900c0d19c36ca.jpg?size=544x367\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  要说“笔芯”鼻祖非他莫属了，\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  GD被发现四五岁时就开始做比心手势...\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p9.qhimg.com/t01599bd9bfb365c58b.jpg?size=622x326\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  当然啦，“韩国赵四” TOP的比发也是很吸引人的\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p6.qhimg.com/t01363ccf2309714475.gif?size=292x166\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  不知道从什么时候开始，国内艺人也开始玩手指心，男女老幼都爱得很。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  无论公开场合还是自拍，无论是表达感谢还是发放福利，一个手势就搞定！\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 舞台上：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p4.qhimg.com/t01d75b29bfcff9885c.jpg?size=402x357\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  自拍：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p6.qhimg.com/t01226229a99d02e136.jpg?size=483x515\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  发布会：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p4.qhimg.com/t01f3f8dd71f7c503f1.jpg?size=711x434\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  要说还有谁不懂这手势的意思？那小编还真不相信\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  可就在前几天某活动上，一群明星的非主流比心图真要把人笑裂了！！\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p7.qhimg.com/t01a8a1c6e573bd71f6.jpg?size=499x292\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  霸气刘烨型：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p5.qhimg.com/t0125df0e29f956c872.jpg?size=433x415\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  耿直刘国梁型：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p2.qhimg.com/t01835015fad23b48e1.jpg?size=434x419\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  罗志祥斜眼一看，OS：他们都在干什么？为啥出拳头？\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p6.qhimg.com/t01e9295dc57be0e386.jpg?size=426x426\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  最最搞笑的是赵薇——\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p2.qhimg.com/t01c7ab102d61b231f8.jpg?size=555x375\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  三脸懵逼，此时最崩溃的绝对是中间的范爷（OS:妈的智障，我左右两个人是在逗我玩吗？）\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p7.qhimg.com/t0152a0aeb54171e591.jpg?size=489x382\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  EXAM??\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p7.qhimg.com/t01d73bc034a62cd29b.jpg?size=442x345\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  舞台上还得现场教学如何比心，所有人都犹如智障一样看着我们小燕子\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p6.qhimg.com/t019ee8b9fd99a03460.gif?size=446x231\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  不是说赵薇控制了整个娱乐圈吗？小编咋觉得这活脱脱是被娱乐圈抛弃的节奏啊！\r\n</p>', '126', '1', '1', '1', '3', '1485096117', '0');
INSERT INTO `yk365_articles` VALUES ('9', '1', '535', '马云谈世界贸易战:“贸易结束日 战争开始时!”', '马云', '原创', 'http://www.youke365.com/', '“贸易结束日，战争开始时”，这是马云在阿里巴巴集团澳大利亚和新西兰总公司成立仪式上的警告。', '<p style=\"margin-top:0px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n “贸易结束日，战争开始时”，这是马云在阿里巴巴集团澳大利亚和新西兰总公司成立仪式上的警告。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  据英国《独立报》2月5日报道，上个月与美国总统特朗普会面的马云表示：“世界需要全球化，而全球化需要贸易。”\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  他说：“所有人都担心贸易战的发生。当贸易停止，贸易战争就开始了。你可以做的唯一一件事就是参与其中，然后积极证明一件事——贸易有利于人际沟通。我们应该进行公平、透明且包容的贸易活动。”\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  据报道，马云认为，世界正处在一个“很有趣”的时期，世界需要一个新的领导。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <div class=\"content-text\" id=\"content-text\" bk=\"content-text\" style=\"margin:0px;padding:0px;font-size:16px;line-height:2em;\">\r\n   <p style=\"margin-top:0px;margin-bottom:0px;padding:0px;text-indent:2em;\">\r\n     上台伊始，特朗普就签署行政命令，决定美国退出TPP。特朗普称，TPP对美国而言“是一个潜在的灾难”。他认为，只有“协商谈判出公平的双边贸易协定才能让工作和产业回归美国”，\r\n   </p>\r\n    <p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;\">\r\n      马云认为，“全球化才是未来。贸易就是信任和文化的交融。”\r\n    </p>\r\n  </div>\r\n  <div class=\"news-Edit\" style=\"margin:0px 0px 20px;padding:0px;float:right;\">\r\n  </div>\r\n  <div class=\"content-share\" bk=\"share\" style=\"margin:20px 0px 40px;padding:10px 0px 16px;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#F0F0F0;clear:both;color:#999999;height:27px;line-height:27px;zoom:1;\">\r\n   <div class=\"common-share fl\" style=\"margin:0px;padding:0px;float:left;position:relative;top:-4px;\">\r\n     <div class=\"share\" bk=\"share\" style=\"margin:0px;padding:0px;height:26px;line-height:26px;position:relative;z-index:10;\">\r\n        <span class=\"news-Edit\" style=\"display:block;float:left;margin-bottom:20px;font-size:14px;line-height:24px;margin-right:0px;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;white-space:normal;background-color:#FFFFFF;\"></span>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</p>', '10', '0', '0', '0', '3', '1486370584', '0');
INSERT INTO `yk365_articles` VALUES ('10', '2', '540', '正规军打不过“老百姓”！这帮民兵到底水有多深？', '老百姓', '本站原创', 'http://www.youke365.com/', '最近东乌克兰冲突再起，乌克兰政府军在坦克即火箭炮的支援下向东乌民兵发动了进攻，但从传出来的消息来看，乌克兰军队的进攻再次被挫败，大量的军人伤亡。', '<p class=\"text\" style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 最近东乌克兰冲突再起，乌克兰政府军在坦克即火箭炮的支援下向东乌民兵发动了进攻，但从传出来的消息来看，乌克兰军队的进攻再次被挫败，大量的军人伤亡。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  自2014年2月以来，面对仅占据2州的“乌合之众”，乌克兰政府军多个作战旅被分割歼灭，人员损失上万人，那么其面对的民兵武装究竟是何方神圣？为何战力如此强悍？本期熊熊讲武，熊熊为您解读。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  先简单介绍下，乌克兰的情况，该国最早可追溯至基辅罗斯时代，乌克兰人与俄罗斯人、白俄罗斯人共同组成东斯拉夫人。然而历史上俄罗斯却一直强大，乌克兰最终被沙俄吞并，但历史原因造成了乌克兰东部亲俄，西部亲西方。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p0.qhimg.com/t01a21874aaee5a896e.jpg?size=600x419\" style=\"vertical-align:middle;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 2013年底乌克兰动乱，次年2月克里米亚入俄，之后乌克兰东部亲俄地区也强烈要求并入俄罗斯，乌克兰遂派军大举进攻，然而东乌武装训练有素，短时间内竟将乌克兰政府军打得大败而逃。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  这些民兵之所以有强悍的战力大致有以下几个因素：\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 其一：乌克兰动乱中，新政府大批清洗军队，一些王牌部队被解散，这些人大都是俄罗斯族人。老兵们组成了东乌民兵武装的骨干，由于他们熟悉乌克兰政府军的作战风格，因此几乎招招令其难以招架。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p6.qhimg.com/t0114f71081d393b0c0.jpg?size=600x324\" style=\"vertical-align:middle;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 其二：东乌地区有大量苏联时期的军械库，在这些武器库中存储有巨量的武器装备，包括坦克、重炮与导弹等，足以支撑东乌民兵的持久作战。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 其三：东乌民兵战术高超，围点打援、分割包围战术用的炉火纯青，而且有当地民众的支持，属于“本土”作战，士气高昂。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 其四：这是最关键的一点，那就是背靠俄罗斯，直接得到了俄军的武器、人员与情报支持。俄军现役军人以志愿军的身份参战，很多乌克兰政府军实际遭遇的正规的俄军精锐部队，焉能有不败之理。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p5.qhimg.com/t012f7aecb7611c8647.jpg?size=600x399\" style=\"vertical-align:middle;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 而反观乌克兰政府军，其在大量清洗俄罗斯族官兵与政见不和人员后已大为削弱，新部队都是以新兵为主力，这些人在训练不足的情况下贸然前往交战区可想结果会是如何。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <br />\r\n</p>\r\n<p class=\"text\" style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 乌克兰政府在战前过高估计了西方对其的援助力度，导致正规军运作的武器装备很多都不到位，紧急开工的生产量又抵消不了前线的损失量，因此在武器对攻层面都占不了优势。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  而且乌克兰政府军士气低落，广大官兵本就对政府不满，因此到前线后也是出工不出力，最终丢盔弃甲也是理所当然的事情。\r\n</p>\r\n<p>\r\n  <br />\r\n</p>', '0', '0', '0', '0', '2', '1523960846', '0');
INSERT INTO `yk365_articles` VALUES ('13', '0', '540', '辽宁号航母编队“逆时针绕台”了！', '辽宁号航母,编队昨日', '原创', 'http://www.youke365.site/', '据日本防卫省统合幕僚监部网站4月20日消息，4月20日上午10点半左右，海上自卫队第13护卫队所属“泽雾”驱逐舰，第5护卫队所属的“秋月”号驱逐舰以及第5航空群的P-3C反潜巡逻机在与那国岛(冲绳县)南约350公里发现向东行进的中国海军辽宁号航空母舰以及护航的052D级导弹驱逐舰1艘,052C级驱逐舰3艘，054A护卫舰2艘。', '<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n  原标题：辽宁号航母编队昨日“逆时针绕台”\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n 【观察者网综合报道】辽宁号航母编队“逆时针绕台”了！\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n 据日本防卫省统合幕僚监部网站4月20日消息，4月20日上午10点半左右，海上自卫队第13护卫队所属“泽雾”驱逐舰，第5护卫队所属的“秋月”号驱逐舰以及第5航空群的P-3C反潜巡逻机在与那国岛(冲绳县)南约350公里发现向东行进的中国海军辽宁号航空母舰以及护航的052D级导弹驱逐舰1艘,052C级驱逐舰3艘，054A护卫舰2艘。\r\n</p>\r\n<div>\r\n <br />\r\n</div>', '5', '0', '0', '0', '3', '1524277535', '0');
INSERT INTO `yk365_articles` VALUES ('14', '0', '540', '解放军轰-6战机连续三天绕台 台媒紧张：又来了', '', '凤凰网', 'http://news.ifeng.com/a/20180420/57757784_0.shtml', '', '<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n  原标题：解放军轰-6战机连续三天绕台 台媒紧张：又来了\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n  海外网4月20日电 继18日、19日解放军军机连续两天绕台飞行后，台媒曝出，今日（20日）上午，解放军再有2架轰-6战机绕台训练。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n  据台湾《联合报》报道，台防务部门20日晚间18时20分称，2架解放军轰-6战机，今日上午穿越宫古水道进入西太平洋，经巴士海峡后飞返原驻地，进行远海长航训练活动。台军方面称，依据相关规定，对解放军活动全程予以“监控”，期间并无异常情形。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n  近日，解放军台海军演，让民进党当局的神经一直处于紧绷状态。早前有台媒认为，大陆的台海军演，似乎是对赖清德“台独”言论的警告。而继解放军在台湾海峡水域进行实弹演习之后，又一连两天派出多架战机“绕岛巡航”。不仅如此，台军方还预判，辽宁舰近日还将北上经过台湾周边，届时“恐怕还有新一波的震撼”。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n 中国空军新闻发言人申进科大校4月19日也发布消息称，空军近日连续组织多架轰炸机、侦察机成体系“绕岛巡航”，锤炼提升维护国家主权和领土完整的能力。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n 空军开展的海上方向实战化军事训练，出动了轰-6K、苏-30、歼-11和侦察机、预警机等多型多架战机。轰-6K等战机实施了“绕岛巡航”训练课题，提升了机动能力，检验了实战能力。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n  空军新闻发言人表示，按照“空天一体、攻防兼备”战略目标，空军深入开展海上方向实战化军事训练，备战打仗能力发生历史性变化。空军有坚定的意志、充分的信心和足够的能力，捍卫国家主权和领土完整。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;white-space:normal;background-color:#FFFFFF;\">\r\n  国台办新闻发言人马晓光在回应“绕岛巡航”一事时表示，“台独”分裂活动是台海和平稳定的最大现实威胁。两岸同胞都应对此保持高度警惕。我们坚决反对任何形式的“台独”分裂图谋和言行，任何企图把台湾从中国分裂出去的图谋都注定失败。任何人、任何势力不要低估我们捍卫国家主权和领土完整的坚定决心和坚强能力。（海外网 李萌）\r\n</p>', '7', '0', '0', '0', '3', '1524277658', '0');

-- ----------------------------
-- Table structure for yk365_categories
-- ----------------------------
DROP TABLE IF EXISTS `yk365_categories`;
CREATE TABLE `yk365_categories` (
  `cate_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `root_id` int(5) unsigned NOT NULL DEFAULT '0',
  `cate_name` varchar(50) DEFAULT NULL,
  `cate_dir` varchar(50) DEFAULT NULL,
  `cate_url` varchar(255) DEFAULT NULL,
  `cate_isbest` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cate_order` int(5) unsigned NOT NULL DEFAULT '0',
  `cate_keywords` varchar(100) DEFAULT NULL,
  `cate_description` varchar(255) DEFAULT NULL,
  `cate_arrparentid` varchar(255) DEFAULT NULL,
  `cate_arrchildid` text DEFAULT NULL ,
  `cate_childcount` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `cate_postcount` int(5) unsigned NOT NULL DEFAULT '0',
  `cate_mod` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`cate_id`),
  KEY `root_id` (`root_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yk365_categories
-- ----------------------------
INSERT INTO `yk365_categories` VALUES ('1', '0', '娱乐休闲', 'entertainment', '', '0', '0', '', '', '0', '1,6,141,142,143,144,145,146,147,7,148,149,150,151,152,8,153,154,155,156,157,158,159,160,161,162,9,163,164,165,10,166,167,168,169,11,170,171,172,173,174,12,175,176,13,177,178,179,180,181,14,182,183,184,15,185,186,187,188,189,16,190,191,192,193,194,195,17,196,197,18,198,199,19,200,201,202,203,204,205,206,20,207,208,209,210,211,529', '16', '53', 'webdir');
INSERT INTO `yk365_categories` VALUES ('2', '0', '电脑网络', 'computer-network', '', '0', '0', '', '', '0', '2,21,212,213,214,22,215,216,217,23,218,219,220,221,222,24,223,224,225,25,226,227,228,229,230,231,26,232,233,234,27,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250,28,251,252,253,254,255,256,257,258,259,260,261,29,262,263,264,30,265,266,267,268,31,269,270,32,271,272,33,273,274,34,275,276,35,277,278,279,280,281,282,283,36,284,285,37,286,38,287,288,289,290,39,291,292,293,294,40,295,296', '20', '20', 'webdir');
INSERT INTO `yk365_categories` VALUES ('3', '0', '生活服务', 'life-service', '', '0', '0', '', '', '0', '3,41,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314,42,315,316,317,43,318,44,319,320,321,322,323,45,325,324,326,327,328,46,329,330,331,332,333,334,335,336,337,47,338,339,340,341,342,343,48,344,345,49,346,347,348,50,349,350,351,352,353,354,355,356,51,357,358,359,360,361,52,362,363,364,365,366,367,368,369,53,370,371,372,373,374,375,54,376,377,378,379,380,381,382,383,384,385,55,386,387,388,56,389,390,391,392,393,394,395,396,57,397,398,399,58,400,401,402,59,403,404,405,60,406,407,408,409,410,61,411,412,413,62,414,415,416,417,418,419,420,421,63,422,423,424,425,426,427,64,428,429,430,65,431,432,433,434', '25', '43', 'webdir');
INSERT INTO `yk365_categories` VALUES ('4', '0', '文化教育', 'culture', '', '0', '0', '', '', '0', '4,66,435,436,437,438,439,440,441,442,67,443,444,68,445,446,447,69,448,449,450,451,452,453,454,455,70,456,457,71,458,459,72,460,461,73,462,74,463,75,464,465,466,467,468,76,469,470,471,472,473,77,474,475,476,477,478,479,480,78,481,482,483,79,484,485,486,487,80,488,489,490', '15', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('5', '0', '综合其他', 'other', '', '0', '0', '', '', '0', '5,81,491,492,493,494,495,82,496,497,498,499,500,501,502,503,504,505,506,507,508,509,510,511,512,513,514,83,515,516,84,517,518,519,520,521,522,523,524,525,526,85,527', '5', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('6', '1', '音乐', 'music', '', '1', '0', '免费音乐，音乐下载，流行歌曲，音乐排行榜', '内容包括最新流行歌曲(仰望、荷塘月色、真爱的味道、Girlfriend)，中文/欧美/日韩音乐排行榜等。', '0,1', '6,141,142,143,144,145,146,147', '7', '8', 'webdir');
INSERT INTO `yk365_categories` VALUES ('7', '1', '影视', 'video', '', '1', '0', '美剧，日剧，韩剧，美剧，高清电影，双语字幕', '提供最热门的美剧（变形金刚3，美国队长，哈利波特），日剧，韩剧，纪录片，高清电影，字幕下载等内容。', '0,1', '7,148,149,150,151,152', '5', '9', 'webdir');
INSERT INTO `yk365_categories` VALUES ('8', '1', '游戏', 'game', '', '1', '0', '最新网游，游戏攻略，游戏资料，游戏公测时间表', '包括最新新闻资讯、视频、攻略、图片、下载、最新游戏（穿越火线、地下城与勇士、魔兽世界）、游戏公测时间表等信息。', '0,1', '8,153,154,155,156,157,158,159,160,161,162', '10', '8', 'webdir');
INSERT INTO `yk365_categories` VALUES ('9', '1', '动漫', 'animation', '', '0', '0', '', '', '0,1', '9,163,164,165', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('10', '1', '图片', 'picture', '', '0', '0', '', '', '0,1', '10,166,167,168,169', '4', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('11', '1', '小说', 'fiction', '', '1', '0', '', '', '0,1', '11,170,171,172,173,174', '5', '6', 'webdir');
INSERT INTO `yk365_categories` VALUES ('12', '1', '笑话', 'joke', '', '0', '0', '', '', '0,1', '12,175,176', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('13', '1', '星相', 'astrology', '', '1', '0', '', '', '0,1', '13,177,178,179,180,181', '5', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('14', '1', '交友', 'make-friends', '', '0', '0', '', '', '0,1', '14,182,183,184', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('15', '1', '新闻', 'news', '', '1', '0', '', '', '0,1', '15,185,186,187,188,189', '5', '6', 'webdir');
INSERT INTO `yk365_categories` VALUES ('16', '1', '体育', 'sport', '', '1', '0', '', '', '0,1', '16,190,191,192,193,194,195', '6', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('17', '1', '军事', 'military', '', '1', '0', '', '', '0,1', '17,196,197', '2', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('18', '1', '摄影', 'photography', '', '0', '0', '', '', '0,1', '18,198,199', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('19', '1', '明星', 'star', '', '0', '0', '', '', '0,1', '19,200,201,202,203,204,205,206', '7', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('20', '1', '社区', 'community', '', '1', '0', '', '', '0,1', '20,207,208,209,210,211', '5', '6', 'webdir');
INSERT INTO `yk365_categories` VALUES ('21', '2', '互联网', 'internet', '', '0', '0', '', '', '0,2', '21,212,213,214', '3', '10', 'webdir');
INSERT INTO `yk365_categories` VALUES ('22', '2', 'IT', 'it', '', '0', '0', '', '', '0,2', '22,215,216,217', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('23', '2', '硬件', 'hardware', '', '0', '0', '', '', '0,2', '23,218,219,220,221,222', '5', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('24', '2', '数码', 'digital', '', '0', '0', '', '', '0,2', '24,223,224,225', '3', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('25', '2', '软件', 'software', '', '0', '0', '', '', '0,2', '25,226,227,228,229,230,231', '6', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('26', '2', '电脑', 'computer', '', '1', '0', '', '', '0,2', '26,232,233,234', '3', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('27', '2', '编程', 'programming', '', '0', '0', '', '', '0,2', '27,235,236,237,238,239,240,241,242,243,244,245,246,247,248,249,250', '16', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('28', '2', '设计', 'design', '', '0', '0', '', '', '0,2', '28,251,252,253,254,255,256,257,258,259,260,261', '11', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('29', '2', '建站', 'buildweb', '', '0', '0', '', '', '0,2', '29,262,263,264', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('30', '2', '站长', 'webmaster', '', '0', '0', '', '', '0,2', '30,265,266,267,268', '4', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('31', '2', '搜索', 'search', '', '1', '0', '', '', '0,2', '31,269,270', '2', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('32', '2', '网址', 'website', '', '0', '0', '', '', '0,2', '32,271,272', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('33', '2', '博客', 'blog', '', '0', '0', '', '', '0,2', '33,273,274', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('34', '2', '网摘', 'bookmark', '', '0', '0', '', '', '0,2', '34,275,276', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('35', '2', '资源', 'resource', '', '0', '0', '', '', '0,2', '35,277,278,279,280,281,282,283', '7', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('36', '2', '桌面', 'desktop', '', '0', '0', '', '', '0,2', '36,284,285', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('37', '2', '分享', 'share', '', '0', '0', '', '', '0,2', '37,286', '1', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('38', '2', '聊天', 'chat', '', '0', '0', '', '', '0,2', '38,287,288,289,290', '4', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('39', '2', '黑客', 'hacker', '', '0', '0', '', '', '0,2', '39,291,292,293,294', '4', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('40', '2', '杀毒', 'antivirus', '', '0', '0', '', '', '0,2', '40,295,296', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('41', '3', '购物', 'shopping', '', '1', '0', '', '', '0,3', '41,297,298,299,300,301,302,303,304,305,306,307,308,309,310,311,312,313,314', '18', '8', 'webdir');
INSERT INTO `yk365_categories` VALUES ('42', '3', '彩票', 'lottery', '', '1', '0', '', '', '0,3', '42,315,316,317', '3', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('43', '3', '天气', 'weather', '', '0', '0', '', '', '0,3', '43,318', '1', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('44', '3', '交通', 'traffic', '', '0', '0', '', '', '0,3', '44,319,320,321,322,323', '5', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('45', '3', '股票', 'stock', '', '1', '0', '', '', '0,3', '45,325,324,326,327,328', '5', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('46', '3', '基金', 'fund', '', '0', '0', '', '', '0,3', '46,329,330,331,332,333,334,335,336,337', '9', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('47', '3', '银行', 'bank', '', '1', '0', '', '', '0,3', '47,338,339,340,341,342,343', '6', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('48', '3', '保险', 'insurance', '', '0', '0', '', '', '0,3', '48,344,345', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('49', '3', '房产', 'house', '', '0', '0', '', '', '0,3', '49,346,347,348', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('50', '3', '汽车', 'car', '', '1', '0', '', '', '0,3', '50,349,350,351,352,353,354,355,356', '8', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('51', '3', '电视', 'television', '', '1', '0', '', '', '0,3', '51,357,358,359,360,361', '5', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('52', '3', '手机', 'mobile', '', '1', '0', '', '', '0,3', '52,362,363,364,365,366,367,368,369', '8', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('53', '3', '通信', 'communication', '', '0', '0', '', '', '0,3', '53,370,371,372,373,374,375', '6', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('54', '3', '健康', 'healthy', '', '1', '0', '', '', '0,3', '54,376,377,378,379,380,381,382,383,384,385', '10', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('55', '3', '美食', 'food', '', '0', '0', '', '', '0,3', '55,386,387,388', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('56', '3', '宠物', 'pet', '', '0', '0', '', '', '0,3', '56,389,390,391,392,393,394,395,396', '8', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('57', '3', '儿童', 'children', '', '0', '0', '', '', '0,3', '57,397,398,399', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('58', '3', '女性', 'female', '', '1', '0', '', '', '0,3', '58,400,401,402', '3', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('59', '3', '时尚', 'fashion', '', '1', '0', '', '', '0,3', '59,403,404,405', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('60', '3', '旅游', 'tourism', '', '0', '0', '', '', '0,3', '60,406,407,408,409,410', '5', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('61', '3', '生活', 'life', '', '0', '0', '', '', '0,3', '61,411,412,413', '3', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('62', '3', '品牌', 'brand', '', '0', '0', '', '', '0,3', '62,414,415,416,417,418,419,420,421', '8', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('63', '3', '查询', 'query', '', '0', '0', '', '', '0,3', '63,422,423,424,425,426,427', '6', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('64', '3', '招聘', 'recruitment', '', '0', '0', '', '', '0,3', '64,428,429,430', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('65', '3', '法律', 'law', '', '0', '0', '', '', '0,3', '65,431,432,433,434', '4', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('66', '4', '教育', 'education', '', '0', '0', '', '', '0,4', '66,435,436,437,438,439,440,441,442', '8', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('67', '4', '知识', 'knowledge', '', '0', '0', '', '', '0,4', '67,443,444', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('68', '4', '外语', 'foreign', '', '0', '0', '', '', '0,4', '68,445,446,447', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('69', '4', '考试', 'exam', '', '0', '0', '', '', '0,4', '69,448,449,450,451,452,453,454,455', '8', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('70', '4', '论文', 'paper', '', '0', '0', '', '', '0,4', '70,456,457', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('71', '4', '大学', 'university', '', '0', '0', '', '', '0,4', '71,458,459', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('72', '4', '校园', 'campus', '', '0', '0', '', '', '0,4', '72,460,461', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('73', '4', '图书馆', 'library', '', '0', '0', '', '', '0,4', '73,462', '1', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('74', '4', '留学', 'overseas', '', '0', '0', '', '', '0,4', '74,463', '1', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('75', '4', '曲艺', 'folkart', '', '0', '0', '', '', '0,4', '75,464,465,466,467,468', '5', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('76', '4', '爱好', 'hobby', '', '0', '0', '', '', '0,4', '76,469,470,471,472,473', '5', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('77', '4', '科技', 'science', '', '0', '0', '', '', '0,4', '77,474,475,476,477,478,479,480', '7', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('78', '4', '人文', 'humanities', '', '0', '0', '', '', '0,4', '78,481,482,483', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('79', '4', '宗教', 'religion', '', '0', '0', '', '', '0,4', '79,484,485,486,487', '4', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('80', '4', '公益', 'welfare', '', '0', '0', '', '', '0,4', '80,488,489,490', '3', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('81', '5', '政府', 'government', '', '0', '0', '', '', '0,5', '81,491,492,493,494,495', '5', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('82', '5', '行业', 'industry', '', '0', '0', '', '', '0,5', '82,496,497,498,499,500,501,502,503,504,505,506,507,508,509,510,511,512,513,514', '19', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('83', '5', '黄页', 'yellowpage', '', '0', '0', '', '', '0,5', '83,515,516', '2', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('84', '5', '酷站', 'coolsite', '', '0', '0', '', '', '0,5', '84,517,518,519,520,521,522,523,524,525,526', '10', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('85', '5', '其他', 'other', '', '0', '0', '', '', '0,5', '85,527', '1', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('141', '6', '在线音乐', '', '', '0', '0', '', '', '0,1,6', '141', '0', '7', 'webdir');
INSERT INTO `yk365_categories` VALUES ('142', '6', '轻音乐', '', '', '0', '0', '', '', '0,1,6', '142', '0', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('143', '6', 'DJ/舞曲', 'dj', '', '0', '0', '', '', '0,1,6', '143', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('144', '6', '原创/翻唱', '', '', '0', '0', '', '', '0,1,6', '144', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('145', '6', '音乐搜索', 'music-search', '', '0', '0', '', '', '0,1,6', '145', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('146', '6', '音乐周边', '', '', '0', '0', '', '', '0,1,6', '146', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('147', '6', '唱片公司', '', '', '0', '0', '', '', '0,1,6', '147', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('148', '7', '影视资讯', '', '', '0', '0', '', '', '0,1,7', '148', '0', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('149', '7', '在线影视', '', '', '0', '0', '', '', '0,1,7', '149', '0', '6', 'webdir');
INSERT INTO `yk365_categories` VALUES ('150', '7', '影视下载', '', '', '0', '0', '', '', '0,1,7', '150', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('151', '7', '视频播客', '', '', '0', '0', '', '', '0,1,7', '151', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('152', '7', '网络电视', '', '', '0', '0', '', '', '0,1,7', '152', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('153', '8', '游戏综合', '', '', '0', '0', '', '', '0,1,8', '153', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('154', '8', '网络游戏', '', '', '0', '0', '', '', '0,1,8', '154', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('155', '8', '网页游戏', 'webgame', '', '0', '0', '', '', '0,1,8', '155', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('156', '8', '单机游戏', '', '', '0', '0', '', '', '0,1,8', '156', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('157', '8', '小游戏', '', '', '0', '0', '', '', '0,1,8', '157', '0', '7', 'webdir');
INSERT INTO `yk365_categories` VALUES ('158', '8', '游戏论坛', '', '', '0', '0', '', '', '0,1,8', '158', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('159', '8', '游戏下载', '', '', '0', '0', '', '', '0,1,8', '159', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('160', '8', '单机电玩', '', '', '0', '0', '', '', '0,1,8', '160', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('161', '8', '游戏周边', '', '', '0', '0', '', '', '0,1,8', '161', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('162', '8', '游戏厂商', '', '', '0', '0', '', '', '0,1,8', '162', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('163', '9', '动漫综合', '', '', '0', '0', '', '', '0,1,9', '163', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('164', '9', '动漫下载', '', '', '0', '0', '', '', '0,1,9', '164', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('165', '9', '动漫原创', '', '', '0', '0', '', '', '0,1,9', '165', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('166', '10', '图片图库', '', '', '0', '0', '', '', '0,1,10', '166', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('167', '10', '美女写真', '', '', '0', '0', '', '', '0,1,10', '167', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('168', '10', '相册贴图', '', '', '0', '0', '', '', '0,1,10', '168', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('169', '10', '电子贺卡', '', '', '0', '0', '', '', '0,1,10', '169', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('170', '11', '小说阅读', '', '', '0', '0', '', '', '0,1,11', '170', '0', '6', 'webdir');
INSERT INTO `yk365_categories` VALUES ('171', '11', '小说搜索', '', '', '0', '0', '', '', '0,1,11', '171', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('172', '11', '电子书', '', '', '0', '0', '', '', '0,1,11', '172', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('173', '11', '文化文学', '', '', '0', '0', '', '', '0,1,11', '173', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('174', '11', '作家作品', '', '', '0', '0', '', '', '0,1,11', '174', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('175', '12', '幽默笑话', '', '', '0', '0', '', '', '0,1,12', '175', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('176', '12', '搞笑视频', '', '', '0', '0', '', '', '0,1,12', '176', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('177', '13', '12星座', '', '', '0', '0', '', '', '0,1,13', '177', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('178', '13', '算命占卜', '', '', '0', '0', '', '', '0,1,13', '178', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('179', '13', '生肖/解梦', '', '', '0', '0', '', '', '0,1,13', '179', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('180', '13', '风水玄学', '', '', '0', '0', '', '', '0,1,13', '180', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('181', '13', '心理测试', '', '', '0', '0', '', '', '0,1,13', '181', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('182', '14', '交友综合', '', '', '0', '0', '', '', '0,1,14', '182', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('183', '14', '情感爱情', '', '', '0', '0', '', '', '0,1,14', '183', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('184', '14', '婚嫁婚介', '', '', '0', '0', '', '', '0,1,14', '184', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('185', '15', '新闻综合', '', '', '0', '0', '', '', '0,1,15', '185', '0', '6', 'webdir');
INSERT INTO `yk365_categories` VALUES ('186', '15', '知名媒体', '', '', '0', '0', '', '', '0,1,15', '186', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('187', '15', '报刊杂志', '', '', '0', '0', '', '', '0,1,15', '187', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('188', '15', '时事论坛', '', '', '0', '0', '', '', '0,1,15', '188', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('189', '15', '各地媒体', '', '', '0', '0', '', '', '0,1,15', '189', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('190', '16', '体育综合', '', '', '0', '0', '', '', '0,1,16', '190', '0', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('191', '16', 'NBA专区', '', '', '0', '0', '', '', '0,1,16', '191', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('192', '16', '足球专区', '', '', '0', '0', '', '', '0,1,16', '192', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('193', '16', '其他体育项目', '', '', '0', '0', '', '', '0,1,16', '193', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('194', '16', '体育相关', '', '', '0', '0', '', '', '0,1,16', '194', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('195', '16', '体育协会', '', '', '0', '0', '', '', '0,1,16', '195', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('196', '17', '军事资讯', '', '', '0', '0', '', '', '0,1,17', '196', '0', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('197', '17', '军事论坛', '', '', '0', '0', '', '', '0,1,17', '197', '0', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('198', '18', '摄影综合', '', '', '0', '0', '', '', '0,1,18', '198', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('199', '18', '摄影论坛', '', '', '0', '0', '', '', '0,1,18', '199', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('200', '19', '娱乐资讯', '', '', '0', '0', '', '', '0,1,19', '200', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('201', '19', '大陆明星', '', '', '0', '0', '', '', '0,1,19', '201', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('202', '19', '港台明星', '', '', '0', '0', '', '', '0,1,19', '202', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('203', '19', '欧美明星', '', '', '0', '0', '', '', '0,1,19', '203', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('204', '19', '日韩明星', '', '', '0', '0', '', '', '0,1,19', '204', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('205', '19', '追星一族', '', '', '0', '0', '', '', '0,1,19', '205', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('206', '19', '解读明星', '', '', '0', '0', '', '', '0,1,19', '206', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('207', '20', '综合社区', '', '', '0', '0', '', '', '0,1,20', '207', '0', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('208', '20', 'SNS社区', '', '', '0', '0', '', '', '0,1,20', '208', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('209', '20', '特色论坛', '', '', '0', '0', '', '', '0,1,20', '209', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('210', '20', '校园BBS', '', '', '0', '0', '', '', '0,1,20', '210', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('211', '20', '地方论坛', '', '', '0', '0', '', '', '0,1,20', '211', '0', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('212', '21', '互联网资讯', '', '', '0', '0', '', '', '0,2,21', '212', '0', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('213', '21', '门户名站', '', '', '0', '0', '', '', '0,2,21', '213', '0', '8', 'webdir');
INSERT INTO `yk365_categories` VALUES ('214', '21', '组织协会', '', '', '0', '0', '', '', '0,2,21', '214', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('215', '22', 'IT资讯', '', '', '0', '0', '', '', '0,2,22', '215', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('216', '22', 'IT博客', '', '', '0', '0', '', '', '0,2,22', '216', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('217', '22', '网络编辑', '', '', '0', '0', '', '', '0,2,22', '217', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('218', '23', '硬件资讯', '', '', '0', '0', '', '', '0,2,23', '218', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('219', '23', '硬件评测', '', '', '0', '0', '', '', '0,2,23', '219', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('220', '23', '硬件论坛', '', '', '0', '0', '', '', '0,2,23', '220', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('221', '23', '驱动程序', '', '', '0', '0', '', '', '0,2,23', '221', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('222', '23', '硬件相关', '', '', '0', '0', '', '', '0,2,23', '222', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('223', '24', '数码资讯', '', '', '0', '0', '', '', '0,2,24', '223', '0', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('224', '24', '数码论坛', '', '', '0', '0', '', '', '0,2,24', '224', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('225', '24', '数码相关', '', '', '0', '0', '', '', '0,2,24', '225', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('226', '25', '软件资讯', '', '', '0', '0', '', '', '0,2,25', '226', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('227', '25', '软件下载', '', '', '0', '0', '', '', '0,2,25', '227', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('228', '25', '装机软件', '', '', '0', '0', '', '', '0,2,25', '228', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('229', '25', '软件论坛', '', '', '0', '0', '', '', '0,2,25', '229', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('230', '25', '软件评测', '', '', '0', '0', '', '', '0,2,25', '230', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('231', '25', '软件相关', '', '', '0', '0', '', '', '0,2,25', '231', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('232', '26', '电脑资讯', '', '', '0', '0', '', '', '0,2,26', '232', '0', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('233', '26', '电脑报刊', '', '', '0', '0', '', '', '0,2,26', '233', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('234', '26', '网管技术', '', '', '0', '0', '', '', '0,2,26', '234', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('235', '27', '程序编程', 'program', '', '0', '0', '', '', '0,2,27', '235', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('236', '27', 'ASP/ASP.NET', 'aspnet', '', '0', '0', '', '', '0,2,27', '236', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('237', '27', 'PHP', 'php', '', '0', '0', '', '', '0,2,27', '237', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('238', '27', 'JSP/JAVA', 'java', '', '0', '0', '', '', '0,2,27', '238', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('239', '27', 'CGI', 'cgi', '', '0', '0', '', '', '0,2,27', '239', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('240', '27', 'WAP', 'wap', '', '0', '0', '', '', '0,2,27', '240', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('241', '27', 'VB', 'vb', '', '0', '0', '', '', '0,2,27', '241', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('242', '27', 'C/C++/C#', 'c', '', '0', '0', '', '', '0,2,27', '242', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('243', '27', 'DELPHI', 'delphi', '', '0', '0', '', '', '0,2,27', '243', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('244', '27', 'Python', 'python', '', '0', '0', '', '', '0,2,27', '244', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('245', '27', 'LINUX/UNIX', 'linux', '', '0', '0', '', '', '0,2,27', '245', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('246', '27', 'JS/AJAX', 'ajax', '', '0', '0', '', '', '0,2,27', '246', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('247', '27', 'WEB开发', 'web', '', '0', '0', '', '', '0,2,27', '247', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('248', '27', '数据库开发', 'database', '', '0', '0', '', '', '0,2,27', '248', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('249', '27', '嵌入式开发', 'embed', '', '0', '0', '', '', '0,2,27', '249', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('250', '27', '源码下载', 'source', '', '0', '0', '', '', '0,2,27', '250', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('251', '28', '设计综合', '', '', '0', '0', '', '', '0,2,28', '251', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('252', '28', '设计素材', '', '', '0', '0', '', '', '0,2,28', '252', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('253', '28', '设计竞标', '', '', '0', '0', '', '', '0,2,28', '253', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('254', '28', '平面设计', '', '', '0', '0', '', '', '0,2,28', '254', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('255', '28', 'CG/FLASH', 'flash', '', '0', '0', '', '', '0,2,28', '255', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('256', '28', '交互设计', '', '', '0', '0', '', '', '0,2,28', '256', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('257', '28', '室内设计', '', '', '0', '0', '', '', '0,2,28', '257', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('258', '28', '建筑设计', '', '', '0', '0', '', '', '0,2,28', '258', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('259', '28', '工业设计', '', '', '0', '0', '', '', '0,2,28', '259', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('260', '28', '服装设计', '', '', '0', '0', '', '', '0,2,28', '260', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('261', '28', '字体下载', 'font', '', '0', '0', '', '', '0,2,28', '261', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('262', '29', '域名主机', 'domain', '', '0', '0', '', '', '0,2,29', '262', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('263', '29', '网页制作', 'homepage', '', '0', '0', '', '', '0,2,29', '263', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('264', '29', '论坛/CMS', 'cms', '', '0', '0', '', '', '0,2,29', '264', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('265', '30', '站长资讯', '', '', '0', '0', '', '', '0,2,30', '265', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('266', '30', '站长工具', 'tool', '', '0', '0', '', '', '0,2,30', '266', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('267', '30', '流量统计', '', '', '0', '0', '', '', '0,2,30', '267', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('268', '30', '网赚联盟', 'union', '', '0', '0', '', '', '0,2,30', '268', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('269', '31', '搜索引擎', '', '', '0', '0', '', '', '0,2,31', '269', '0', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('270', '31', '特色搜索', '', '', '0', '0', '', '', '0,2,31', '270', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('271', '32', '网址导航', '', '', '0', '0', '', '', '0,2,32', '271', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('272', '32', '分类目录', '', '', '0', '0', '', '', '0,2,32', '272', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('273', '33', '博客', '', '', '0', '0', '', '', '0,2,33', '273', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('274', '33', '微博', '', '', '0', '0', '', '', '0,2,33', '274', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('275', '34', 'RSS订阅', 'rssfeed', '', '0', '0', '', '', '0,2,34', '275', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('276', '34', '网摘/书签', '', '', '0', '0', '', '', '0,2,34', '276', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('277', '35', '免费信息', 'free', '', '0', '0', '', '', '0,2,35', '277', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('278', '35', '电子邮箱', 'email', '', '0', '0', '', '', '0,2,35', '278', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('279', '35', '网络硬盘', 'netdisk', '', '0', '0', '', '', '0,2,35', '279', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('280', '35', '网络相册', '', '', '0', '0', '', '', '0,2,35', '280', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('281', '35', '在线翻译', '', '', '0', '0', '', '', '0,2,35', '281', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('282', '35', '域名/DNS', 'dns', '', '0', '0', '', '', '0,2,35', '282', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('283', '35', '主页/网店/论坛', '', '', '0', '0', '', '', '0,2,35', '283', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('284', '36', '桌面壁纸', '', '', '0', '0', '', '', '0,2,36', '284', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('285', '36', '主题屏保', '', '', '0', '0', '', '', '0,2,36', '285', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('286', '37', '社会化分享', '', '', '0', '0', '', '', '0,2,37', '286', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('287', '38', '聊天工具', '', '', '0', '0', '', '', '0,2,38', '287', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('288', '38', '聊天室', '', '', '0', '0', '', '', '0,2,38', '288', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('289', '38', 'QQ空间代码', '', '', '0', '0', '', '', '0,2,38', '289', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('290', '38', 'QQ相关', '', '', '0', '0', '', '', '0,2,38', '290', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('291', '39', '黑客安全', '', '', '0', '0', '', '', '0,2,39', '291', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('292', '39', '黑客组织', '', '', '0', '0', '', '', '0,2,39', '292', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('293', '39', '黑客论坛', '', '', '0', '0', '', '', '0,2,39', '293', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('294', '39', '在线工具', '', '', '0', '0', '', '', '0,2,39', '294', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('295', '40', '病毒防治', '', '', '0', '0', '', '', '0,2,40', '295', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('296', '40', '安全防毒论坛', '', '', '0', '0', '', '', '0,2,40', '296', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('297', '41', '综合购物', '', '', '0', '0', '', '', '0,3,41', '297', '0', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('298', '41', '团购导航', '', '', '0', '0', '', '', '0,3,41', '298', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('299', '41', '导购打折', '', '', '0', '0', '', '', '0,3,41', '299', '0', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('300', '41', '数码家电', '', '', '0', '0', '', '', '0,3,41', '300', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('301', '41', '图书音像', '', '', '0', '0', '', '', '0,3,41', '301', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('302', '41', '衣服首饰', '', '', '0', '0', '', '', '0,3,41', '302', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('303', '41', '鞋子箱包', '', '', '0', '0', '', '', '0,3,41', '303', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('304', '41', '美容化妆', '', '', '0', '0', '', '', '0,3,41', '304', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('305', '41', '母婴儿童', '', '', '0', '0', '', '', '0,3,41', '305', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('306', '41', '两性情趣', '', '', '0', '0', '', '', '0,3,41', '306', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('307', '41', '医药保健', '', '', '0', '0', '', '', '0,3,41', '307', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('308', '41', '食品饮料', '', '', '0', '0', '', '', '0,3,41', '308', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('309', '41', '礼品鲜花', '', '', '0', '0', '', '', '0,3,41', '309', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('310', '41', '珠宝眼镜', '', '', '0', '0', '', '', '0,3,41', '310', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('311', '41', '文体办公', '', '', '0', '0', '', '', '0,3,41', '311', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('312', '41', '日用家居', '', '', '0', '0', '', '', '0,3,41', '312', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('313', '41', '数字点卡', '', '', '0', '0', '', '', '0,3,41', '313', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('314', '41', '电子支付', '', '', '0', '0', '', '', '0,3,41', '314', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('315', '42', '在线购彩', '', '', '0', '0', '', '', '0,3,42', '315', '0', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('316', '42', '福利彩票', '', '', '0', '0', '', '', '0,3,42', '316', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('317', '42', '体育彩票', '', '', '0', '0', '', '', '0,3,42', '317', '0', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('318', '43', '天气综合', '', '', '0', '0', '', '', '0,3,43', '318', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('319', '44', '电子地图', '', '', '0', '0', '', '', '0,3,44', '319', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('320', '44', '道路交通', '', '', '0', '0', '', '', '0,3,44', '320', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('321', '44', '公交公司', '', '', '0', '0', '', '', '0,3,44', '321', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('322', '44', '航空公司', '', '', '0', '0', '', '', '0,3,44', '322', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('325', '45', '股票综合', '', '', '0', '0', '', '', '0,3,45', '325', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('323', '44', '各地铁路', '', '', '0', '0', '', '', '0,3,44', '323', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('324', '45', '财经资讯', '', '', '0', '0', '', '', '0,3,45', '324', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('326', '45', '股票交流', '', '', '0', '0', '', '', '0,3,45', '326', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('327', '45', '财经报刊', '', '', '0', '0', '', '', '0,3,45', '327', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('328', '45', '证券公司', '', '', '0', '0', '', '', '0,3,45', '328', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('329', '46', '投资理财', '', '', '0', '0', '', '', '0,3,46', '329', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('330', '46', '金融综合', '', '', '0', '0', '', '', '0,3,46', '330', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('331', '46', '基金资讯', '', '', '0', '0', '', '', '0,3,46', '331', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('332', '46', '证券债券', '', '', '0', '0', '', '', '0,3,46', '332', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('333', '46', '外汇资讯', '', '', '0', '0', '', '', '0,3,46', '333', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('334', '46', '期货资讯', '', '', '0', '0', '', '', '0,3,46', '334', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('335', '46', '黄金资讯', '', '', '0', '0', '', '', '0,3,46', '335', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('336', '46', '风险投资', '', '', '0', '0', '', '', '0,3,46', '336', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('337', '46', '基金公司', '', '', '0', '0', '', '', '0,3,46', '337', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('338', '47', '银行网站', '', '', '0', '0', '', '', '0,3,47', '338', '0', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('339', '47', '各地银行', '', '', '0', '0', '', '', '0,3,47', '339', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('340', '47', '港澳台银行', '', '', '0', '0', '', '', '0,3,47', '340', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('341', '47', '外资银行', '', '', '0', '0', '', '', '0,3,47', '341', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('342', '47', '银行机构', '', '', '0', '0', '', '', '0,3,47', '342', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('343', '47', '信用卡资讯', '', '', '0', '0', '', '', '0,3,47', '343', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('344', '48', '保险资讯', '', '', '0', '0', '', '', '0,3,48', '344', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('345', '48', '保险公司', '', '', '0', '0', '', '', '0,3,48', '345', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('346', '49', '房产综合', '', '', '0', '0', '', '', '0,3,49', '346', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('347', '49', '家居装修', '', '', '0', '0', '', '', '0,3,49', '347', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('348', '49', '地方房产', '', '', '0', '0', '', '', '0,3,49', '348', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('349', '50', '汽车资讯', '', '', '0', '0', '', '', '0,3,50', '349', '0', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('350', '50', '报价交易', '', '', '0', '0', '', '', '0,3,50', '350', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('351', '50', '二手车', '', '', '0', '0', '', '', '0,3,50', '351', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('352', '50', '汽车配件', '', '', '0', '0', '', '', '0,3,50', '352', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('353', '50', '汽车论坛', '', '', '0', '0', '', '', '0,3,50', '353', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('354', '50', '用车学车', '', '', '0', '0', '', '', '0,3,50', '354', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('355', '50', '地方汽车', '', '', '0', '0', '', '', '0,3,50', '355', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('356', '50', '汽车厂商', '', '', '0', '0', '', '', '0,3,50', '356', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('357', '51', '电视资讯', '', '', '0', '0', '', '', '0,3,51', '357', '0', '5', 'webdir');
INSERT INTO `yk365_categories` VALUES ('358', '51', '在线电视', '', '', '0', '0', '', '', '0,3,51', '358', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('359', '51', '在线电台', '', '', '0', '0', '', '', '0,3,51', '359', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('360', '51', '电视台', '', '', '0', '0', '', '', '0,3,51', '360', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('361', '51', '广播电台', '', '', '0', '0', '', '', '0,3,51', '361', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('362', '52', '手机综合', '', '', '0', '0', '', '', '0,3,52', '362', '0', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('363', '52', '手机报价', '', '', '0', '0', '', '', '0,3,52', '363', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('364', '52', '手机论坛', '', '', '0', '0', '', '', '0,3,52', '364', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('365', '52', '手机电影', '', '', '0', '0', '', '', '0,3,52', '365', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('366', '52', '手机游戏', '', '', '0', '0', '', '', '0,3,52', '366', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('367', '52', '手机软件', '', '', '0', '0', '', '', '0,3,52', '367', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('368', '52', '手机主题', '', '', '0', '0', '', '', '0,3,52', '368', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('369', '52', '短信图铃', '', '', '0', '0', '', '', '0,3,52', '369', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('370', '53', '通信综合', '', '', '0', '0', '', '', '0,3,53', '370', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('371', '53', '通信运营商', '', '', '0', '0', '', '', '0,3,53', '371', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('372', '53', '各地电信', '', '', '0', '0', '', '', '0,3,53', '372', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('373', '53', '各地移动', '', '', '0', '0', '', '', '0,3,53', '373', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('376', '54', '医疗健康', '', '', '0', '0', '', '', '0,3,54', '376', '0', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('374', '53', '各地联通', '', '', '0', '0', '', '', '0,3,53', '374', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('375', '53', '各地铁通', '', '', '0', '0', '', '', '0,3,53', '375', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('377', '54', '寻医问药', '', '', '0', '0', '', '', '0,3,54', '377', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('378', '54', '健康养生', '', '', '0', '0', '', '', '0,3,54', '378', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('379', '54', '两性健康', '', '', '0', '0', '', '', '0,3,54', '379', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('380', '54', '心理健康', '', '', '0', '0', '', '', '0,3,54', '380', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('381', '54', '医院诊所', '', '', '0', '0', '', '', '0,3,54', '381', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('382', '54', '医学研究', '', '', '0', '0', '', '', '0,3,54', '382', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('383', '54', '药品器械', '', '', '0', '0', '', '', '0,3,54', '383', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('384', '54', '医院管理', '', '', '0', '0', '', '', '0,3,54', '384', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('385', '54', '疾病预防', '', '', '0', '0', '', '', '0,3,54', '385', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('386', '55', '饮食营养', '', '', '0', '0', '', '', '0,3,55', '386', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('387', '55', '菜谱食谱', '', '', '0', '0', '', '', '0,3,55', '387', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('388', '55', '电子优惠券', '', '', '0', '0', '', '', '0,3,55', '388', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('389', '56', '宠物综合', '', '', '0', '0', '', '', '0,3,56', '389', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('390', '56', '猫猫狗狗', '', '', '0', '0', '', '', '0,3,56', '390', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('391', '56', '水族爬虫', '', '', '0', '0', '', '', '0,3,56', '391', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('392', '56', '宠物鸟', '', '', '0', '0', '', '', '0,3,56', '392', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('393', '56', '花草花卉', '', '', '0', '0', '', '', '0,3,56', '393', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('394', '56', '宠物用品', '', '', '0', '0', '', '', '0,3,56', '394', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('395', '56', '宠物医院', '', '', '0', '0', '', '', '0,3,56', '395', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('396', '56', '动物保护', '', '', '0', '0', '', '', '0,3,56', '396', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('397', '57', '儿童乐园', '', '', '0', '0', '', '', '0,3,57', '397', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('398', '57', '母婴亲子', '', '', '0', '0', '', '', '0,3,57', '398', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('399', '57', '亲子论坛', '', '', '0', '0', '', '', '0,3,57', '399', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('400', '58', '女性综合', '', '', '0', '0', '', '', '0,3,58', '400', '0', '3', 'webdir');
INSERT INTO `yk365_categories` VALUES ('401', '58', '美容减肥', '', '', '0', '0', '', '', '0,3,58', '401', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('402', '58', '男人世界', '', '', '0', '0', '', '', '0,3,58', '402', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('403', '59', '时尚资讯', '', '', '0', '0', '', '', '0,3,59', '403', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('404', '59', '时尚杂志', '', '', '0', '0', '', '', '0,3,59', '404', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('405', '59', '奢侈品', '', '', '0', '0', '', '', '0,3,59', '405', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('406', '60', '旅游资讯', '', '', '0', '0', '', '', '0,3,60', '406', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('407', '60', '旅行社/酒店/机票', '', '', '0', '0', '', '', '0,3,60', '407', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('408', '60', '旅游景点', '', '', '0', '0', '旅游景点，旅游风景区，旅游景点大全', '为您提供中国著名旅游景点大全，旅游景点介绍，旅游景点推荐，旅游景点图片等信息。', '0,3,60', '408', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('409', '60', '自助户外游', '', '', '0', '0', '', '', '0,3,60', '409', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('410', '60', '地方旅游网', '', '', '0', '0', '', '', '0,3,60', '410', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('411', '61', '生活名站', '', '', '0', '0', '', '', '0,3,61', '411', '0', '2', 'webdir');
INSERT INTO `yk365_categories` VALUES ('412', '61', '网上记账', '', '', '0', '0', '', '', '0,3,61', '412', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('413', '61', '消费者协会', '', '', '0', '0', '', '', '0,3,61', '413', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('414', '62', '服装鞋帽', '', '', '0', '0', '', '', '0,3,62', '414', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('415', '62', '珠宝配饰', '', '', '0', '0', '', '', '0,3,62', '415', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('416', '62', '美容化妆', '', '', '0', '0', '', '', '0,3,62', '416', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('417', '62', '生活日用', '', '', '0', '0', '', '', '0,3,62', '417', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('418', '62', '餐饮食品', '', '', '0', '0', '', '', '0,3,62', '418', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('419', '62', '数码家电', '', '', '0', '0', '', '', '0,3,62', '419', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('420', '62', '文体办公', '', '', '0', '0', '', '', '0,3,62', '420', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('421', '62', '药品器械', '', '', '0', '0', '', '', '0,3,62', '421', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('422', '63', '日常生活', '', '', '0', '0', '', '', '0,3,63', '422', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('423', '63', '交通旅游', '', '', '0', '0', '', '', '0,3,63', '423', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('424', '63', '金融理财', '', '', '0', '0', '', '', '0,3,63', '424', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('425', '63', '学习教育', '', '', '0', '0', '', '', '0,3,63', '425', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('426', '63', '电脑网络', '', '', '0', '0', '', '', '0,3,63', '426', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('427', '63', '综合其他', '', '', '0', '0', '', '', '0,3,63', '427', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('428', '64', '人才招聘', '', '', '0', '0', '', '', '0,3,64', '428', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('429', '64', '行业人才', '', '', '0', '0', '', '', '0,3,64', '429', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('430', '64', '地方人才', '', '', '0', '0', '', '', '0,3,64', '430', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('431', '65', '法律综合', '', '', '0', '0', '', '', '0,3,65', '431', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('432', '65', '法律法规', '', '', '0', '0', '', '', '0,3,65', '432', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('433', '65', '知识产权', '', '', '0', '0', '', '', '0,3,65', '433', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('434', '65', '法律援助', '', '', '0', '0', '', '', '0,3,65', '434', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('435', '66', '教育综合', '', '', '0', '0', '', '', '0,4,66', '435', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('436', '66', '基础教育', '', '', '0', '0', '', '', '0,4,66', '436', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('437', '66', '高等教育', '', '', '0', '0', '', '', '0,4,66', '437', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('438', '66', '成人教育', '', '', '0', '0', '', '', '0,4,66', '438', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('439', '66', '职业教育', '', '', '0', '0', '', '', '0,4,66', '439', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('440', '66', '特殊教育', '', '', '0', '0', '', '', '0,4,66', '440', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('441', '66', '远程教育', '', '', '0', '0', '', '', '0,4,66', '441', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('442', '66', '教育科研', '', '', '0', '0', '', '', '0,4,66', '442', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('443', '67', '百科问答', '', '', '0', '0', '', '', '0,4,67', '443', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('444', '67', '文档网站', '', '', '0', '0', '', '', '0,4,67', '444', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('445', '68', '英语学习', '', '', '0', '0', '', '', '0,4,68', '445', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('446', '68', '其他语种', '', '', '0', '0', '', '', '0,4,68', '446', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('447', '68', '在线翻译', '', '', '0', '0', '', '', '0,4,68', '447', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('448', '69', '考试招生', '', '', '0', '0', '', '', '0,4,69', '448', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('449', '69', '高考/自考/成考', '', '', '0', '0', '', '', '0,4,69', '449', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('450', '69', '公务员考试', '', '', '0', '0', '', '', '0,4,69', '450', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('451', '69', '考研', '', '', '0', '0', '', '', '0,4,69', '451', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('452', '69', '英语类考试(托福/雅思/GRE/PETS)', '', '', '0', '0', '', '', '0,4,69', '452', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('453', '69', '计算机考试', '', '', '0', '0', '', '', '0,4,69', '453', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('454', '69', '专业类考试', '', '', '0', '0', '', '', '0,4,69', '454', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('455', '69', '各地考试信息', '', '', '0', '0', '', '', '0,4,69', '455', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('456', '70', '免费论文', '', '', '0', '0', '', '', '0,4,70', '456', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('457', '70', '课件资源', '', '', '0', '0', '', '', '0,4,70', '457', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('458', '71', '国内高校', '', '', '0', '0', '', '', '0,4,71', '458', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('459', '71', '国外高校', '', '', '0', '0', '', '', '0,4,71', '459', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('460', '72', '校园综合', '', '', '0', '0', '', '', '0,4,72', '460', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('461', '72', '同学录', '', '', '0', '0', '', '', '0,4,72', '461', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('462', '73', '图书馆院', '', '', '0', '0', '', '', '0,4,73', '462', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('463', '74', '出国留学', '', '', '0', '0', '', '', '0,4,74', '463', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('464', '75', '相声/小品/评书', '', '', '0', '0', '', '', '0,4,75', '464', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('465', '75', '舞蹈', '', '', '0', '0', '', '', '0,4,75', '465', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('466', '75', '乐器', '', '', '0', '0', '', '', '0,4,75', '466', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('467', '75', '魔术杂技', '', '', '0', '0', '', '', '0,4,75', '467', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('468', '75', '地方戏', '', '', '0', '0', '', '', '0,4,75', '468', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('469', '76', '艺术鉴赏', '', '', '0', '0', '', '', '0,4,76', '469', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('470', '76', '收藏艺术', '', '', '0', '0', '', '', '0,4,76', '470', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('471', '76', '美术绘画', '', '', '0', '0', '', '', '0,4,76', '471', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('472', '76', '书法艺术', '', '', '0', '0', '', '', '0,4,76', '472', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('473', '76', '纹身', '', '', '0', '0', '', '', '0,4,76', '473', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('474', '77', '科研机构', '', '', '0', '0', '', '', '0,4,77', '474', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('475', '77', '社会科学', '', '', '0', '0', '', '', '0,4,77', '475', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('476', '77', '自然科学', '', '', '0', '0', '', '', '0,4,77', '476', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('477', '77', '农业科学', '', '', '0', '0', '', '', '0,4,77', '477', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('478', '77', '工程科学', '', '', '0', '0', '', '', '0,4,77', '478', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('479', '77', '科普知识', '', '', '0', '0', '', '', '0,4,77', '479', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('480', '77', '发明专利', '', '', '0', '0', '', '', '0,4,77', '480', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('481', '78', '社会文化', '', '', '0', '0', '', '', '0,4,78', '481', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('482', '78', '历史人文', '', '', '0', '0', '', '', '0,4,78', '482', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('483', '78', '历史名人', '', '', '0', '0', '', '', '0,4,78', '483', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('484', '79', '佛教', '', '', '0', '0', '', '', '0,4,79', '484', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('485', '79', '道教', '', '', '0', '0', '', '', '0,4,79', '485', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('486', '79', '基督教', '', '', '0', '0', '', '', '0,4,79', '486', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('487', '79', '伊斯兰教', '', '', '0', '0', '', '', '0,4,79', '487', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('488', '80', '公益项目', '', '', '0', '0', '', '', '0,4,80', '488', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('489', '80', '公益基金', '', '', '0', '0', '', '', '0,4,80', '489', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('490', '80', '公益资讯', '', '', '0', '0', '', '', '0,4,80', '490', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('491', '81', '国家政府机构', '', '', '0', '0', '', '', '0,5,81', '491', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('492', '81', '地方政府机构', '', '', '0', '0', '', '', '0,5,81', '492', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('493', '81', '国际/区域组织', '', '', '0', '0', '', '', '0,5,81', '493', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('494', '81', '驻华使馆/领事馆', '', '', '0', '0', '', '', '0,5,81', '494', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('495', '81', '各国政府', '', '', '0', '0', '', '', '0,5,81', '495', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('496', '82', '商业贸易', 'business', '', '0', '0', '', '', '0,5,82', '496', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('497', '82', '农林牧渔', 'agriculture', '', '0', '0', '', '', '0,5,82', '497', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('498', '82', '物流快递', 'express', '', '0', '0', '', '', '0,5,82', '498', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('499', '82', '食品饮料', 'food', '', '0', '0', '', '', '0,5,82', '499', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('500', '82', '服装鞋帽', 'clothing', '', '0', '0', '', '', '0,5,82', '500', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('501', '82', '礼品玩具', 'toy', '', '0', '0', '', '', '0,5,82', '501', '0', '0', '');
INSERT INTO `yk365_categories` VALUES ('502', '82', '建筑建材', 'building', '', '0', '0', '', '', '0,5,82', '502', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('503', '82', '家电音响', 'electrical', '', '0', '0', '', '', '0,5,82', '503', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('504', '82', '电子安防', 'security', '', '0', '0', '', '', '0,5,82', '504', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('505', '82', '能源电力', 'energy', '', '0', '0', '', '', '0,5,82', '505', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('506', '82', '机械仪表', 'mechanical', '', '0', '0', '', '', '0,5,82', '506', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('507', '82', '化学工业', 'chemistry', '', '0', '0', '', '', '0,5,82', '507', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('508', '82', '纺织皮革', 'spinning', '', '0', '0', '', '', '0,5,82', '508', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('509', '82', '冶金矿产', 'metallurgy', '', '0', '0', '', '', '0,5,82', '509', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('510', '82', '五金模具', 'mold', '', '0', '0', '', '', '0,5,82', '510', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('511', '82', '广告营销', 'advertising', '', '0', '0', '', '', '0,5,82', '511', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('512', '82', '印刷包装', 'print', '', '0', '0', '', '', '0,5,82', '512', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('513', '82', '出版发行', 'publish', '', '0', '0', '', '', '0,5,82', '513', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('514', '82', '环保绿化', 'green', '', '0', '0', '', '', '0,5,82', '514', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('515', '83', '黄页大全', 'huangye', '', '0', '0', '', '', '0,5,83', '515', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('516', '83', '企业网站', 'enterprise', '', '0', '0', '', '', '0,5,83', '516', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('517', '84', '美图分享', 'meitufenxiang', '', '0', '0', '', '', '0,5,84', '517', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('518', '84', '晒搭配', 'saitaipei', '', '0', '0', '', '', '0,5,84', '518', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('519', '84', '吃货据点', 'chihuojudian', '', '0', '0', '', '', '0,5,84', '519', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('520', '84', '发现好音乐', 'faxianhaoyinyue', '', '0', '0', '', '', '0,5,84', '520', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('521', '84', '新鲜科技', 'xinxiankeji', '', '0', '0', '', '', '0,5,84', '521', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('522', '84', '创意设计', 'chuangyisheji', '', '0', '0', '', '', '0,5,84', '522', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('523', '84', '爱旅行', 'ailvxing', '', '0', '0', '', '', '0,5,84', '523', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('524', '84', '爱手工', 'aishougong', '', '0', '0', '', '', '0,5,84', '524', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('525', '84', '新潮社区', 'xinchaoshequ', '', '0', '0', '', '', '0,5,84', '525', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('526', '84', '趣味测试', 'quweiceshi', '', '0', '0', '', '', '0,5,84', '526', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('527', '85', '菜鸟', 'q', 'http://www.cnqqnz.com', '0', '0', '11', '111', '0,5,85', '527', '0', '1', 'webdir');
INSERT INTO `yk365_categories` VALUES ('529', '1', '直播', 'live', '', '1', '0', '', '', '0,1', '529', '0', '0', 'webdir');
INSERT INTO `yk365_categories` VALUES ('561', '0', '电视剧', '', '', '1', '0', '', '', '0', '561', '0', '0', 'video');
INSERT INTO `yk365_categories` VALUES ('535', '0', '娱乐', 'ent', '', '1', '0', '', '', '0', '535', '0', '7', 'article');
INSERT INTO `yk365_categories` VALUES ('536', '0', '财经', 'finance', '', '1', '0', '', '', '0', '536', '0', '1', 'article');
INSERT INTO `yk365_categories` VALUES ('537', '0', '科技', 'tech', '', '1', '0', '', '', '0', '537', '0', '0', 'article');
INSERT INTO `yk365_categories` VALUES ('538', '0', '汽车', 'auto', '', '1', '0', '', '', '0', '538', '0', '0', 'article');
INSERT INTO `yk365_categories` VALUES ('539', '0', '房产', 'house', '', '1', '0', '', '', '0', '539', '0', '0', 'article');
INSERT INTO `yk365_categories` VALUES ('540', '0', '军事', 'mil', '', '0', '0', '', '', '0', '540', '0', '3', 'article');
INSERT INTO `yk365_categories` VALUES ('541', '0', '体育', 'sports', '', '0', '0', '', '', '0', '541', '0', '0', 'article');
INSERT INTO `yk365_categories` VALUES ('542', '0', '生活', 'life', '', '0', '0', '', '', '0', '542', '0', '0', 'article');
INSERT INTO `yk365_categories` VALUES ('543', '0', '格斗', '', '', '0', '0', '', '', '0', '543', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('544', '0', '体育', '', '', '0', '0', '', '', '0', '544', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('545', '0', '益智', '', '', '0', '0', '', '', '0', '545', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('546', '0', '射击', '', '', '0', '0', '', '', '0', '546', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('547', '0', '搞笑', '', '', '0', '0', '', '', '0', '547', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('548', '0', '冒险', '', '', '0', '0', '', '', '0', '548', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('549', '0', '儿童', '', '', '0', '0', '', '', '0', '549', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('550', '0', '休闲', '', '', '0', '0', '', '', '0', '550', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('551', '0', '棋牌', '', '', '0', '0', '', '', '0', '551', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('552', '0', '敏捷', '', '', '0', '0', '', '', '0', '552', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('553', '0', '策略', '', '', '0', '0', '', '', '0', '553', '0', '0', 'game');
INSERT INTO `yk365_categories` VALUES ('555', '0', '电影', '', '', '1', '0', '', '', '0', '555', '0', '1', 'video');
INSERT INTO `yk365_categories` VALUES ('556', '0', '综艺', '', '', '1', '0', '', '', '0', '556', '0', '0', 'video');
INSERT INTO `yk365_categories` VALUES ('557', '0', '娱乐', '', '', '1', '0', '', '', '0', '557', '0', '0', 'video');
INSERT INTO `yk365_categories` VALUES ('558', '0', '科技', '', '', '1', '0', '', '', '0', '558', '0', '0', 'video');
INSERT INTO `yk365_categories` VALUES ('559', '0', '搞笑', '', '', '0', '0', '', '', '0', '559', '0', '0', 'video');
INSERT INTO `yk365_categories` VALUES ('560', '0', '动漫', '', '', '0', '0', '', '', '0', '560', '0', '0', 'video');
INSERT INTO `yk365_categories` VALUES ('562', '0', '卫视直播', 'weishi', '', '0', '0', '', '', '0', '562', '0', '13', 'live');
INSERT INTO `yk365_categories` VALUES ('563', '0', '央视频道', '', '', '0', '0', '', '', '0', '563', '0', '0', 'live');

-- ----------------------------
-- Table structure for yk365_feedback
-- ----------------------------
DROP TABLE IF EXISTS `yk365_feedback`;
CREATE TABLE `yk365_feedback` (
  `fb_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `fb_nick` varchar(50) DEFAULT NULL,
  `fb_email` varchar(50) DEFAULT NULL,
  `fb_content` text DEFAULT NULL ,
  `fb_date` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`fb_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yk365_feedback
-- ----------------------------

-- ----------------------------
-- Table structure for yk365_games
-- ----------------------------
DROP TABLE IF EXISTS `yk365_games`;
CREATE TABLE `yk365_games` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cate_id` int(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `cover` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `intro` varchar(200) DEFAULT NULL,
  `content` text DEFAULT NULL ,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `_ispay` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `istop` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isbest` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `utime` int(10) unsigned NOT NULL DEFAULT '0',
  `ishot` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yk365_games
-- ----------------------------
INSERT INTO `yk365_games` VALUES ('2', '1', '543', '老爹寿司店中文版', 'http://imga1.5054399.com/upload_pic/2017/4/7/4399_21090336095.jpg', 'http://www.4399.com/flash/187040.htm', '', '', '0', '0', '0', '0', '3', '1491792637', '0', '0');
INSERT INTO `yk365_games` VALUES ('3', '1', '543', '路飞大冒险', 'http://imga3.5054399.com/upload_pic/2017/4/1/4399_15353778616.jpg', 'http://www.4399.com/flash/186857.htm', '', '', '0', '0', '0', '0', '3', '1491792756', '0', '0');
INSERT INTO `yk365_games` VALUES ('4', '1', '543', '3D公共巴士停靠2', 'http://imga2.5054399.com/upload_pic/2017/4/6/4399_10071267044.jpg', 'http://www.4399.com/flash/186971.htm', '', '', '0', '0', '0', '1', '3', '1491792786', '0', '1');

-- ----------------------------
-- Table structure for yk365_links
-- ----------------------------
DROP TABLE IF EXISTS `yk365_links`;
CREATE TABLE `yk365_links` (
  `link_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `link_name` varchar(50) DEFAULT NULL,
  `link_url` varchar(255) DEFAULT NULL,
  `link_logo` varchar(255) DEFAULT NULL,
  `link_display` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_order` tinyint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yk365_links
-- ----------------------------
INSERT INTO `yk365_links` VALUES ('1', '优客365官方网站', 'http://www.youke365.site', '', '1', '0');
INSERT INTO `yk365_links` VALUES ('2', '优客365论坛', 'http://bbs.youke365.site', '', '1', '0');

-- ----------------------------
-- Table structure for yk365_options
-- ----------------------------
DROP TABLE IF EXISTS `yk365_options`;
CREATE TABLE `yk365_options` (
  `option_name` varchar(30) DEFAULT NULL,
  `option_value` text DEFAULT NULL 
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


-- ----------------------------
-- Records of yk365_options
-- ----------------------------
INSERT INTO `yk365_options` VALUES ('site_name', '优客365 开源网址导航系统');
INSERT INTO `yk365_options` VALUES ('site_title', '优客365开源版');
INSERT INTO `yk365_options` VALUES ('site_url', 'http://www.youke365.site/');
INSERT INTO `yk365_options` VALUES ('site_root', '/');
INSERT INTO `yk365_options` VALUES ('admin_email', 'youke365@qq.com');
INSERT INTO `yk365_options` VALUES ('site_keywords', '分类目录,网站收录,网站提交,网站目录,网站推广,网站登录');
INSERT INTO `yk365_options` VALUES ('site_description', '全人工编辑的开放式网站分类目录，收录国内外、各行业优秀网站，旨在为用户提供网站分类目录检索、优秀网站参考、网站推广服务。');
INSERT INTO `yk365_options` VALUES ('site_copyright', 'Copyright © 2017 <a href=\"http://www.youke365.site \">优客365官方</a>');
INSERT INTO `yk365_options` VALUES ('regname_small', '2');
INSERT INTO `yk365_options` VALUES ('regname_large', '15');
INSERT INTO `yk365_options` VALUES ('regname_forbid', 'admin\r\n管理员\r\nadmin888\r\n');
INSERT INTO `yk365_options` VALUES ('home_instat', '20');
INSERT INTO `yk365_options` VALUES ('home_outstat', '20');
INSERT INTO `yk365_options` VALUES ('home_isbest', '50');
INSERT INTO `yk365_options` VALUES ('home_new', '13');
INSERT INTO `yk365_options` VALUES ('is_enabled_gzip', 'yes');
INSERT INTO `yk365_options` VALUES ('is_enabled_submit', 'yes');
INSERT INTO `yk365_options` VALUES ('submit_close_reason', '站点提交已经关闭！');
INSERT INTO `yk365_options` VALUES ('data_update_cycle', '1');
INSERT INTO `yk365_options` VALUES ('is_enabled_register', 'yes');
INSERT INTO `yk365_options` VALUES ('register_email_verify', 'no');
INSERT INTO `yk365_options` VALUES ('is_enabled_rewrite', 'no');
INSERT INTO `yk365_options` VALUES ('rewrite_suffix', '.html');
INSERT INTO `yk365_options` VALUES ('smtp_host', 'mail.qijike.com.cn');
INSERT INTO `yk365_options` VALUES ('smtp_port', '25');
INSERT INTO `yk365_options` VALUES ('smtp_auth', 'yes');
INSERT INTO `yk365_options` VALUES ('smtp_user', 'test@qijike.com.cn');
INSERT INTO `yk365_options` VALUES ('smtp_pass', 'q123456');
INSERT INTO `yk365_options` VALUES ('filter_words', 'sb\r\n共产党\r\n发票');
INSERT INTO `yk365_options` VALUES ('is_enabled_connect', 'yes');
INSERT INTO `yk365_options` VALUES ('qq_appid', '');
INSERT INTO `yk365_options` VALUES ('qq_appkey', '');
INSERT INTO `yk365_options` VALUES ('link_struct', '0');
INSERT INTO `yk365_options` VALUES ('search_words', '百度，360');
INSERT INTO `yk365_options` VALUES ('upload_dir', 'uploads');
INSERT INTO `yk365_options` VALUES ('ad_text', '宅男边撩妹边赚外快|http://g.360.cn/game/sanqi\r\n宅男边撩妹边赚外快|http://g.360.cn/game/sanqi\r\n宅男边撩妹边赚外快|http://g.360.cn/game/sanqi\r\n宅男边撩妹边赚外快|http://g.360.cn/game/sanqi\r\n宅男边撩妹边赚外快|http://g.360.cn/game/sanqi\r\n宅男边撩妹边赚外快|http://g.360.cn/game/sanqi\r\n');
INSERT INTO `yk365_options` VALUES ('hot_words', '嫌整容没效果裸体坐医院\r\n西披露危害国家安全案\r\n北京楼市调控再出重拳\r\n西披露危害国家安全案\r\n北京楼市调控再出重拳\r\n西披露危害国家安全案\r\n北京楼市调控再出重拳');
INSERT INTO `yk365_options` VALUES ('site_logo', '/public/images/logo.png');
INSERT INTO `yk365_options` VALUES ('is_enabled_comment', '1');
INSERT INTO `yk365_options` VALUES ('changyan_appid', 'cyscE6A60');
INSERT INTO `yk365_options` VALUES ('changyan_conf', '');
INSERT INTO `yk365_options` VALUES ('qcode_alipay', '/uploads/images/w.png');
INSERT INTO `yk365_options` VALUES ('is_enabled_reward', 'yes');
INSERT INTO `yk365_options` VALUES ('qcode_weixin', '/uploads/images/bbs.png');
INSERT INTO `yk365_options` VALUES ('site_code', '<script type=\"text/javascript\">var cnzz_protocol = ((\"https:\" == document.location.protocol) ? \" https://\" : \" http://\");document.write(unescape(\"%3Cspan id=\'cnzz_stat_icon_1257188920\'%3E%3C/span%3E%3Cscript src=\'\" + cnzz_protocol + \"s4.cnzz.com/stat.php%3Fid%3D1257188920%26show%3Dpic\' type=\'text/javascript\'%3E%3C/script%3E\"));</script>');
INSERT INTO `yk365_options` VALUES ('nav_code', '<ul class=\"newsbox-list\">\r\n<li><i class=\"fa fa-plane fa-lg fablue\" aria-hidden=\"true\"></i><a href=\"http://www.ctrip.com\" target=\"_blank\">机票</a> | <a href=\"http://www.12306.cn\" target=\"_blank\">火车票</a></li>\r\n\r\n<li><i class=\"fa fa-film fablue\" aria-hidden=\"true\"></i> <a href=\"http://movie.youku.com/\" target=\"_blank\">电影</a> | <a href=\"http://movie.youku.com/\" target=\"_blank\">电视剧</a></li>\r\n\r\n<li><i class=\"fa fa-gamepad fa-lg fablue\" aria-hidden=\"true\"></i><a href=\"http://www.37.com\"  target=\"_blank\">游戏</a> | <a href=\"http://www.4399.com/\"  target=\"_blank\">小游戏</a></li>          \r\n\r\n<li><i class=\"fa fa-heart fablue\" aria-hidden=\"true\"></i><a href=\"http://www.acfun.cn/\" target=\"_blank\">动漫</a> | <a href=\"https://www.douyu.com/\" target=\"_blank\">直播</a></li>\r\n\r\n<li><i class=\"fa fa-newspaper-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"http://www.toutiao.com/\" target=\"_blank\">新闻</a> | <a href=\"http://www.iqiyi.com/\" target=\"_blank\">视频</a></li>\r\n\r\n<li> <i class=\"fa fa-shopping-cart fa-lg fa-fw fablue\" aria-hidden=\"true\"></i>\r\n<a href=\"https://www.taobao.com/\" target=\"_blank\">购物</a> | <a href=\"http://www.zhe800.com\" target=\"_blank\">9块9</a></li>       \r\n\r\n<li><i class=\"fa fa-money fa-lg fa-fw fablue\" aria-hidden=\"true\"></i> <a href=\"\" target=\"_blank\">理财</a> | <a href=\"http://www.500.com/\" target=\"_blank\">彩票</a></li>       \r\n\r\n<li><i class=\"fa fa-jpy fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">活期</a> | <a href=\"\" target=\"_blank\">借条</a></li>       \r\n\r\n<li><i class=\"fa fa-star-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i> <a href=\"\" target=\"_blank\">娱乐</a> | <a href=\"\" target=\"_blank\">商城</a></li>               \r\n\r\n<li><i class=\"fa fa-smile-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">搞笑</a> | <a href=\"\" target=\"_blank\">解梦</a></li>       \r\n\r\n<li><i class=\"fa fa-map-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">教育</a> | <a href=\"\" target=\"_blank\">度假</a></li>       \r\n\r\n<li><i class=\"fa fa-search fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">查询</a> | <a href=\"\" target=\"_blank\">星座</a></li>        \r\n\r\n<li><i class=\"fa fa-mobile fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">手机</a> | <a href=\"\" target=\"_blank\">小说</a></li>\r\n\r\n<li><i class=\"fa fa-bookmark-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">综艺</a> | <a href=\"\"  target=\"_blank\">旅游</a></li>\r\n\r\n</ul>');
INSERT INTO `yk365_options` VALUES ('is_enabled_tj', 'yes');
INSERT INTO `yk365_options` VALUES ('home_best', '18');
INSERT INTO `yk365_options` VALUES ('is_enabled_submit_collect', 'yes');
INSERT INTO `yk365_options` VALUES ('home_pay', '18');
INSERT INTO `yk365_options` VALUES ('site_kefu', '888888\r\n');
INSERT INTO `yk365_options` VALUES ('qcode_name', '优客365官方QQ群');
INSERT INTO `yk365_options` VALUES ('qcode_img', '/public/images/youke.png');
INSERT INTO `yk365_options` VALUES ('nav_slide', '<div class=\"app app-imageswitch\">\r\n             <a href=\"http://ent.ifeng.com/\" target=\"_blank\" class=\"icon\">\r\n                 <img src=\"/public/images/u=2133.png\" class=\"img-icon\" alt=\"\">娱乐\r\n             </a>\r\n\r\n          </div>\r\n\r\n<div class=\"app app-imageswitch\">\r\n             <a href=\"https://www.douyu.com/\" target=\"_blank\" class=\"icon\">\r\n                  <img src=\"/public/images/u=2155.png\" class=\"img-icon\" alt=\"\">斗鱼\r\n             </a>\r\n          </div>\r\n<div class=\"app app-imageswitch\">\r\n         <a href=\"http://www.youku.com/\" target=\"_blank\" class=\"icon\">\r\n             <img src=\"/public/images/u=2166.png\" class=\"img-icon\" alt=\"\">视频\r\n         </a> \r\n\r\n     </div>\r\n');
INSERT INTO `yk365_options` VALUES ('home_nav', '<li><a href=\"/home/article.html\"><i class=\"fa fa-file\" aria-hidden=\"true\"></i> 新闻资讯</a></li>\r\n<li><a href=\"/home/weblink.html\"><i class=\"fa fa-link\" aria-hidden=\"true\"></i> 换链大厅</a></li>\r\n<li><a href=\"/home/webdir.html\"><i class=\"fa fa-sitemap\" aria-hidden=\"true\"></i> 分类目录</a></li>\r\n<li><a href=\"/home/update.html\"><i class=\"fa fa-hourglass-start\" aria-hidden=\"true\"></i> 最新收录</a></li><li><a href=\"/home/top.html\"><i class=\"fa fa-trophy\" aria-hidden=\"true\"></i> 网站排行榜</a></li>');
INSERT INTO `yk365_options` VALUES ('home_pay_money', '20');
INSERT INTO `yk365_options` VALUES ('default_skin', 'default');
INSERT INTO `yk365_options` VALUES ('is_mobile_status', 'yes');
INSERT INTO `yk365_options` VALUES ('default_theme', 'default');
INSERT INTO `yk365_options` VALUES ('default_mobile_theme', 'default');
INSERT INTO `yk365_options` VALUES ('is_article_status', 'yes');
INSERT INTO `yk365_options` VALUES ('is_video_status', 'yes');
INSERT INTO `yk365_options` VALUES ('is_game_status', 'yes');
INSERT INTO `yk365_options` VALUES ('is_link_status', 'yes');

-- ----------------------------
-- Table structure for yk365_pages
-- ----------------------------
DROP TABLE IF EXISTS `yk365_pages`;
CREATE TABLE `yk365_pages` (
  `page_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `page_name` varchar(50) DEFAULT NULL,
  `page_intro` varchar(255) DEFAULT NULL,
  `page_content` text DEFAULT NULL ,
  PRIMARY KEY (`page_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yk365_pages
-- ----------------------------

-- ----------------------------
-- Table structure for yk365_picture
-- ----------------------------
DROP TABLE IF EXISTS `yk365_picture`;
CREATE TABLE `yk365_picture` (
  `art_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cate_id` int(5) unsigned NOT NULL DEFAULT '0',
  `art_title` varchar(100) DEFAULT NULL,
  `art_tags` varchar(50) DEFAULT NULL,
  `copy_from` varchar(50) DEFAULT NULL,
  `copy_url` varchar(200) DEFAULT NULL,
  `art_intro` varchar(200) DEFAULT NULL,
  `art_content` text DEFAULT NULL,
  `art_views` int(10) unsigned NOT NULL DEFAULT '0',
  `art_ispay` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_istop` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_isbest` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `art_ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `art_utime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`art_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
-- ----------------------------
-- Records of yk365_picture
-- ----------------------------
INSERT INTO `yk365_picture` VALUES ('7', '1', '534', '外媒：中国建成世界最大高铁网 高铁像公交车一样', '高铁', '本站原创', 'http://www.youke365.com/', '英媒称，不到10年前，中国的城市之间还没有高速铁路相连。如今，中国已有超2万公里的高铁线路，超过世界其他地方高铁线路的总和。中国的规划者希望它们会像19世纪在英美涌现的铁路城镇一样。', '<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  参考消息网1月22日报道 英媒称，不到10年前，中国的城市之间还没有高速铁路相连。如今，<strong>中国已有超2万公里的高铁线路，超过世界其他地方高铁线路的总和。</strong>中国的规划者希望它们会像19世纪在英美涌现的铁路城镇一样。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n 英国《经济学人》周刊网站1月14日报道称，中国计划在2025年建成3.8万公里的高铁线路。同样惊人的是伴随高铁线路的城市发展。几乎凡是有高铁站的地方，即便看似前不着村后不着店的地方，都有密密麻麻的新建办公楼和住宅区拔地而起。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  中国的规划者希望它们会像19世纪在英美涌现的铁路城镇一样。但问题是，收益是否大于损失。在最繁忙的高铁运营5年后（北京-上海高铁在2011年启用），可以得出初步结论了。<strong>在中国最密集的地区，高铁是利好：帮助建立紧密连接的经济。但往内陆去，过度投资的风险不断增加。</strong> \r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n 在中国三大人口中心北上广地区，生活和工作已经开始追随高铁资源。以前火车太少、太慢、太挤，不适用于每日通勤。如今，这三地都在发展通勤走廊。不足为奇，卫星城镇的房价往往要低得多。例如，昆山的房价比附近上海的房价大约低70%。但两地之间的高铁单程只需19分钟，票价25元。而昆山只是试图逃离上海高生活成本的人们可以选择的众多城镇中的一座。目前，大约有7500万人生活在距上海1小时高铁车程的范围内。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  调查结果显示，最繁忙线路上的旅客有一半以上是新增交通量，即以前不会乘坐高铁的旅客。这无疑有利于经济。这意味着高铁正在让中国生产率最高的城市周边的劳动力和消费者群体不断扩大，同时把投资和技术推向较穷的地方。徐向上（音）是卖房子的，他卖的公寓在安徽不那么富裕地区的高铁站旁边。从这些地方坐高铁不到半小时就能到达江苏省省会、人口800万的繁华城市南京。他说：<strong>“高铁正变得像公交车一样。”</strong> \r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  报道称，高铁不仅仅是一种交通工具。中国希望建立“高铁经济”。中国的想法是限制大城市的规模，但在高铁的帮助下实现聚集效应。中国认为，这样产生的大城市网，而非超大城市，将更容易管理。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n 然而，在大城市周边修建可靠和足够快的普通火车几乎和高铁一样好，而成本只是高铁的一小部分。经合组织认为，铺设时速350公里铁路线比铺设时速250公里铁路线的成本高90%以上。对于每年客流量达1亿人次、运行时间较长的线路——比如北京和上海之间，修建成本更高的类型或许是合理的。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  <br />\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  但对于在通勤城镇之间的旅程就不需要这样高成本的铁路线，因为在这样的旅程中火车只会短暂加速至最高速度。对于为少量人口服务的较长旅程来说，高铁成本太过高昂。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n  报道称，总花销已经很巨大了。去年，设备制造商中国铁路物资总公司被迫对部分债务进行重组，压力显而易见。6条高铁线路已经开始盈利（不考虑修建成本），去年盈利66亿元人民币，而北京-上海之间的高铁成为世界上盈利最多的高铁。但在人口较少的地区，高铁亏损严重。\r\n</p>\r\n<p style=\"margin-top:0px;margin-bottom:25px;padding:0px;text-indent:28px;font-size:14px;text-align:justify;word-break:normal;color:#2B2B2B;font-family:simsun, arial, helvetica, clean, sans-serif;line-height:24px;white-space:normal;background-color:#FFFFFF;\">\r\n 中国目前有四纵四横的高铁网格，即南北、东西各四条主干线路。它的新计划是在2035年前建成八纵八横的高铁网格。最终目标是拥有4.5万公里高铁线路。\r\n</p>\r\n<p>\r\n <br />\r\n</p>', '6', '0', '0', '0', '3', '1485095835', '0');
INSERT INTO `yk365_picture` VALUES ('5', '1', '534', '人民币贬值：川普第一个不答应', '人民币贬值', '本站原创', 'http://www.youke365.com/', '唐纳德·特朗普，在美国是个非常具有传奇色彩的人物，被冠以美国“地产大亨”、商人、作家、主持人、演员，而现在又多了一个政治家的身份。', '<p style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  唐纳德·特朗普，在美国是个非常具有传奇色彩的人物，被冠以美国“地产大亨”、商人、作家、主持人、演员，而现在又多了一个政治家的身份。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  现在，不仅是美国，特朗普也已经掀开了新的篇章，看来，全球市场还会发生了翻天覆地的变化，毕竟特朗普比较多变，让大多数人参谋不透，他下一步要怎么做。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 不管如何，特朗普既然商场上那么出色，为何不能用商业的原则来治国？“让这个人试试!”，成为许多美国底层白人的普遍呼声。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p2.qhimg.com/t01037fc2e85cecb567.jpg?size=599x336\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 很多美国人已经认定特朗普是一个脑袋好使的成功人士，他当选会给美国带来不同，是的，从他胜选的时候，全球市场发生了翻天覆地的变化，市场快速反弹，这是1960年肯尼迪时代以来从没发生过的。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  特朗普是个“大嘴巴”，过去的几周，世界人民都见识到了，让中国大妈都紧张了，早上吃面的时候，邻桌一位大妈对另一位大妈说，要不要兑换点美元，人民币跌得太厉害了。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 连面馆里的群众都有点坐不住了，人民币与美元，犹如跷跷板，一端上升，另一端就会下沉，金投网小编想对大妈说：大妈别慌，人民币硬着呢！\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 别把这个事情看得太严重，相对美元来说，人民币是贬值的，但是从一篮子货币来看，人民币贬得并不多。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  这里要特别提一下，人民币已经加入SDR货币篮子，从国内来看，人民币没有持续贬值的基础，实际上，汇率的贬值是一个双重的效果，不是单重的效果，比如汇率贬值对出口是有利的。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p0.qhimg.com/t017aaa6b10396fe23d.jpg?size=581x394\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 此外，大洋彼岸是特朗普及其团队很难左右的，而且特朗普是个个相当务实的商人，实行高利率、强美元的货币政策不利于其承诺的经济增长目标的实现。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 对大多数普通中国人来说，其实人民币贬值并没有太大的影响，毕竟面馆里大妈付钱还是用的人民币，不是吗？\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  要说美元强势，全球其他货币都会跌，全球央行看的下去吗？又谁会放任自己家的货币让美元虐呢？这不，全球央行一年内已经抛售4050亿美元。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 这次减持潮中要数中国抛售的力度最大，中国已经连续六个月减持美债，去年10月中国所持美债规模下降了413亿美元，成最大抛售者，而日本则成为“美国头号债主”。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p2.qhimg.com/t013825809e1ace388a.jpg?size=593x398\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 不管我们怎么做，就是川普一个商人也不会看着人民币一直贬值，这对他是没好处的，最近几日，川普对于人民币是神助攻，人民币大涨，特朗普不会对人民币采取强硬举措，也不会将我们列为“货币操纵国”的。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 放人民币贬值，特朗普能答应吗？相反小编觉得特朗普能拉人民币一把，在特朗普眼中，看到的只是中国能带给他的利益，这将从本质上，一定程度的改变中美外交关系，中国也会因此而少受排挤，更加快速的发展！\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  川普打算大干一场，首先就“唱衰”美元，让人民币黄金大涨，对于人民币的涨跌，央行应该有定力，保持淡定，不能因为人民币跌了一点，就进行干预，未来人民币汇率自由浮动是大趋势，要让市场对人民币进行定价。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  川普还在释放这一个信号，会成为黄金最铁的朋友，正在发起金价反弹之势的黄金多头在历史上这种时期的胜算更大。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p9.qhimg.com/t019a29d7551d121887.jpg?size=640x356\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 从近代美国总统职位交接在交易员中激起对黄金未来的乐观主义来看，自1970年代以来，在历届新总统的就职所在年份金价的平均涨幅将近15%。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  从1974年截至2016年，共有7位新任美国总统就职，在这7个年份中，金价录得上涨的年份为5年，相形之下，标普500股票指数有4年录得下跌，在此期间的平均跌幅为0.9%。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  黄金多头们认为，由于特朗普财政刺激计划缺乏细节，加之美国与包括中国在内等贸易伙伴之间的紧张关系，金价有望进一步扩大涨幅。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 2017年投资黄金需把握以下三大趋势：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p1.qhimg.com/t014050a6f7294e2747.jpg?size=640x454\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 政治和地缘政治风险：美国方面的风险最有可能引爆黄金的避险吸引力，尤其是美国新任总统特朗普的贸易协议谈判需要特别关注。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 货币贬值：近年来，美国和全球其他国家之间的货币政策逐渐出现分歧，实际上，多年来，作为交换工具的黄金早已超越大多数主要货币，黄金和疲软货币之间的分化也可能刺激黄金的投资需求。\r\n</p>', '14', '0', '0', '0', '3', '1485095411', '0');
INSERT INTO `yk365_picture` VALUES ('6', '1', '534', '周立波 你咋能这么怂呢?我就不信，警察敢开枪打你', '周立波', '本站原创', 'http://www.youke365.com/', '周立波日前在美国被抓，真是丢人丢大发丢到家了丢国外去了...真是搞不懂，你咋能这么怂呢?', '<p style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 周立波日前在美国被抓，真是丢人丢大发丢到家了丢国外去了...真是搞不懂，你咋能这么怂呢?\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 警察拦你，你就停车了?停就停了，你为啥不看人家警官证呢?不问问他们是否有执法证呢?不看警官证也就罢了，你为啥不打911叫巡警来看是不是真警察呢?\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p3.qhimg.com/t016fb997b9dc3fa2b0.jpg?size=450x315\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" />\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  警察说搜，你就让搜了?凭什么?!冲上去扇人耳光啊~把自己衣服撕开~再躺地上打滚，大喊:救命，警察打人了呀~\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  你为什么不朝对方吼:把你们局长叫来!\r\n</p>', '4', '0', '0', '0', '3', '1485095511', '0');
INSERT INTO `yk365_picture` VALUES ('8', '1', '535', '感觉赵薇被整个娱乐圈抛弃了！', '娱乐圈', '本站原创', 'http://www.youke365.com/', '要说现在“示爱”最简单的方式非他莫属了——手动“笔芯”', '<p class=\"text\" style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 要说现在“示爱”最简单的方式非他莫属了——手动“笔芯”\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p5.qhimg.com/t01fe208ae02b914765.jpg?size=642x268\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  男女老少要是不比个心都不好意思说自己是爱豆\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p5.qhimg.com/t01b4e900c0d19c36ca.jpg?size=544x367\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  要说“笔芯”鼻祖非他莫属了，\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  GD被发现四五岁时就开始做比心手势...\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p9.qhimg.com/t01599bd9bfb365c58b.jpg?size=622x326\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  当然啦，“韩国赵四” TOP的比发也是很吸引人的\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p6.qhimg.com/t01363ccf2309714475.gif?size=292x166\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  不知道从什么时候开始，国内艺人也开始玩手指心，男女老幼都爱得很。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  无论公开场合还是自拍，无论是表达感谢还是发放福利，一个手势就搞定！\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 舞台上：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p4.qhimg.com/t01d75b29bfcff9885c.jpg?size=402x357\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  自拍：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p6.qhimg.com/t01226229a99d02e136.jpg?size=483x515\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  发布会：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p4.qhimg.com/t01f3f8dd71f7c503f1.jpg?size=711x434\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  要说还有谁不懂这手势的意思？那小编还真不相信\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  可就在前几天某活动上，一群明星的非主流比心图真要把人笑裂了！！\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p7.qhimg.com/t01a8a1c6e573bd71f6.jpg?size=499x292\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  霸气刘烨型：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p5.qhimg.com/t0125df0e29f956c872.jpg?size=433x415\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  耿直刘国梁型：\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p2.qhimg.com/t01835015fad23b48e1.jpg?size=434x419\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  罗志祥斜眼一看，OS：他们都在干什么？为啥出拳头？\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p6.qhimg.com/t01e9295dc57be0e386.jpg?size=426x426\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  最最搞笑的是赵薇——\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p2.qhimg.com/t01c7ab102d61b231f8.jpg?size=555x375\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  三脸懵逼，此时最崩溃的绝对是中间的范爷（OS:妈的智障，我左右两个人是在逗我玩吗？）\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p7.qhimg.com/t0152a0aeb54171e591.jpg?size=489x382\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  EXAM??\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <img src=\"http://p7.qhimg.com/t01d73bc034a62cd29b.jpg?size=442x345\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  舞台上还得现场教学如何比心，所有人都犹如智障一样看着我们小燕子\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p6.qhimg.com/t019ee8b9fd99a03460.gif?size=446x231\" style=\"vertical-align:top;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" /> \r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  不是说赵薇控制了整个娱乐圈吗？小编咋觉得这活脱脱是被娱乐圈抛弃的节奏啊！\r\n</p>', '39', '1', '1', '1', '3', '1485096117', '0');
INSERT INTO `yk365_picture` VALUES ('9', '1', '534', '马云谈世界贸易战:“贸易结束日 战争开始时!”', '马云', '原创', 'http://www.youke365.com/', '“贸易结束日，战争开始时”，这是马云在阿里巴巴集团澳大利亚和新西兰总公司成立仪式上的警告。', '<p style=\"margin-top:0px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  “贸易结束日，战争开始时”，这是马云在阿里巴巴集团澳大利亚和新西兰总公司成立仪式上的警告。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  据英国《独立报》2月5日报道，上个月与美国总统特朗普会面的马云表示：“世界需要全球化，而全球化需要贸易。”\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  他说：“所有人都担心贸易战的发生。当贸易停止，贸易战争就开始了。你可以做的唯一一件事就是参与其中，然后积极证明一件事——贸易有利于人际沟通。我们应该进行公平、透明且包容的贸易活动。”\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  据报道，马云认为，世界正处在一个“很有趣”的时期，世界需要一个新的领导。\r\n</p>\r\n<p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n <div class=\"content-text\" id=\"content-text\" bk=\"content-text\" style=\"margin:0px;padding:0px;font-size:16px;line-height:2em;\">\r\n   <p style=\"margin-top:0px;margin-bottom:0px;padding:0px;text-indent:2em;\">\r\n     上台伊始，特朗普就签署行政命令，决定美国退出TPP。特朗普称，TPP对美国而言“是一个潜在的灾难”。他认为，只有“协商谈判出公平的双边贸易协定才能让工作和产业回归美国”，\r\n   </p>\r\n    <p style=\"margin-top:20px;margin-bottom:0px;padding:0px;text-indent:2em;\">\r\n      马云认为，“全球化才是未来。贸易就是信任和文化的交融。”\r\n    </p>\r\n  </div>\r\n  <div class=\"news-Edit\" style=\"margin:0px 0px 20px;padding:0px;float:right;\">\r\n  </div>\r\n  <div class=\"content-share\" bk=\"share\" style=\"margin:20px 0px 40px;padding:10px 0px 16px;border-bottom-width:1px;border-bottom-style:solid;border-bottom-color:#F0F0F0;clear:both;color:#999999;height:27px;line-height:27px;zoom:1;\">\r\n   <div class=\"common-share fl\" style=\"margin:0px;padding:0px;float:left;position:relative;top:-4px;\">\r\n     <div class=\"share\" bk=\"share\" style=\"margin:0px;padding:0px;height:26px;line-height:26px;position:relative;z-index:10;\">\r\n        <span class=\"news-Edit\" style=\"display:block;float:left;margin-bottom:20px;font-size:14px;line-height:24px;margin-right:0px;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;white-space:normal;background-color:#FFFFFF;\"></span>\r\n      </div>\r\n    </div>\r\n  </div>\r\n</p>', '1', '0', '0', '0', '3', '1486370584', '0');
INSERT INTO `yk365_picture` VALUES ('10', '2', '540', '正规军打不过“老百姓”！这帮民兵到底水有多深？', '老百姓', '本站原创', 'http://www.youke365.com/', '最近东乌克兰冲突再起，乌克兰政府军在坦克即火箭炮的支援下向东乌民兵发动了进攻，但从传出来的消息来看，乌克兰军队的进攻再次被挫败，大量的军人伤亡。', '<p class=\"text\" style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  最近东乌克兰冲突再起，乌克兰政府军在坦克即火箭炮的支援下向东乌民兵发动了进攻，但从传出来的消息来看，乌克兰军队的进攻再次被挫败，大量的军人伤亡。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  自2014年2月以来，面对仅占据2州的“乌合之众”，乌克兰政府军多个作战旅被分割歼灭，人员损失上万人，那么其面对的民兵武装究竟是何方神圣？为何战力如此强悍？本期熊熊讲武，熊熊为您解读。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  先简单介绍下，乌克兰的情况，该国最早可追溯至基辅罗斯时代，乌克兰人与俄罗斯人、白俄罗斯人共同组成东斯拉夫人。然而历史上俄罗斯却一直强大，乌克兰最终被沙俄吞并，但历史原因造成了乌克兰东部亲俄，西部亲西方。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p0.qhimg.com/t01a21874aaee5a896e.jpg?size=600x419\" style=\"vertical-align:middle;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" />\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  2013年底乌克兰动乱，次年2月克里米亚入俄，之后乌克兰东部亲俄地区也强烈要求并入俄罗斯，乌克兰遂派军大举进攻，然而东乌武装训练有素，短时间内竟将乌克兰政府军打得大败而逃。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  这些民兵之所以有强悍的战力大致有以下几个因素：\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 其一：乌克兰动乱中，新政府大批清洗军队，一些王牌部队被解散，这些人大都是俄罗斯族人。老兵们组成了东乌民兵武装的骨干，由于他们熟悉乌克兰政府军的作战风格，因此几乎招招令其难以招架。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p6.qhimg.com/t0114f71081d393b0c0.jpg?size=600x324\" style=\"vertical-align:middle;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" />\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  其二：东乌地区有大量苏联时期的军械库，在这些武器库中存储有巨量的武器装备，包括坦克、重炮与导弹等，足以支撑东乌民兵的持久作战。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 其三：东乌民兵战术高超，围点打援、分割包围战术用的炉火纯青，而且有当地民众的支持，属于“本土”作战，士气高昂。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n 其四：这是最关键的一点，那就是背靠俄罗斯，直接得到了俄军的武器、人员与情报支持。俄军现役军人以志愿军的身份参战，很多乌克兰政府军实际遭遇的正规的俄军精锐部队，焉能有不败之理。\r\n</p>\r\n<p class=\"content-img\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <img src=\"http://p5.qhimg.com/t012f7aecb7611c8647.jpg?size=600x399\" style=\"vertical-align:middle;display:block;margin:0px auto;max-width:100%;word-wrap:break-word !important;\" />\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  而反观乌克兰政府军，其在大量清洗俄罗斯族官兵与政见不和人员后已大为削弱，新部队都是以新兵为主力，这些人在训练不足的情况下贸然前往交战区可想结果会是如何。\r\n</p>\r\n<p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n  <p class=\"text\" style=\"margin-top:0px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n   乌克兰政府在战前过高估计了西方对其的援助力度，导致正规军运作的武器装备很多都不到位，紧急开工的生产量又抵消不了前线的损失量，因此在武器对攻层面都占不了优势。\r\n  </p>\r\n  <p class=\"text\" style=\"margin-top:20px;margin-bottom:0px;padding:0px;color:#333333;font-family:\'Microsoft YaHei\', \'Helvetica Neue\', Arial, sans-serif;font-size:16px;line-height:32px;white-space:normal;background-color:#FFFFFF;\">\r\n    而且乌克兰政府军士气低落，广大官兵本就对政府不满，因此到前线后也是出工不出力，最终丢盔弃甲也是理所当然的事情。\r\n </p>\r\n</p>', '0', '0', '0', '0', '2', '1486370781', '0');

-- ----------------------------
-- Table structure for yk365_users
-- ----------------------------
DROP TABLE IF EXISTS `yk365_users`;
CREATE TABLE `yk365_users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nick_name` varchar(20) DEFAULT NULL,
  `user_type` enum('admin','member','recruit','vip') NOT NULL DEFAULT 'member',
  `user_email` varchar(50) DEFAULT NULL,
  `user_pass` char(32) DEFAULT NULL,
  `open_id` char(32) DEFAULT NULL,
  `user_qq` varchar(20) DEFAULT NULL,
  `user_score` int(5) unsigned NOT NULL DEFAULT '0',
  `verify_code` varchar(32) DEFAULT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT '0',
  `join_time` int(10) unsigned NOT NULL DEFAULT '0',
  `login_time` int(10) unsigned NOT NULL DEFAULT '0',
  `login_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `login_count` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `nick_name` (`nick_name`) USING BTREE,
  UNIQUE KEY `user_email` (`user_email`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;


-- ----------------------------
-- Table structure for yk365_videos
-- ----------------------------
DROP TABLE IF EXISTS `yk365_videos`;
CREATE TABLE `yk365_videos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cate_id` int(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `cover` varchar(200) DEFAULT NULL,
  `url` varchar(200) DEFAULT NULL,
  `intro` varchar(200) DEFAULT NULL,
  `content` text DEFAULT NULL ,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `ispay` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `istop` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `isbest` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `utime` int(10) unsigned NOT NULL DEFAULT '0',
  `ishot` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='视频表';
-- ----------------------------
-- Records of yk365_videos
-- ----------------------------
INSERT INTO `yk365_videos` VALUES ('8', '1', '561', '黎明决战', '/uploads/video/20170415093502_581.jpg', 'http://www.360kan.com/tv/RLFpaH7kTz8oOX.html', '', '', '0', '0', '0', '1', '3', '1491877393', '0', '1');
INSERT INTO `yk365_videos` VALUES ('9', '1', '561', '剃刀边缘', '/uploads/video/20170415093551_132.jpg', 'http://www.360kan.com/tv/PrZtb07kTzDnN3.html', '', '', '0', '0', '0', '1', '3', '0', '0', '1');
INSERT INTO `yk365_videos` VALUES ('10', '1', '561', '射雕英雄传', '/uploads/video/20170415093635_105.jpg', 'http://www.360kan.com/tv/Q4lrcH7kSmbuOH.html', '', '', '0', '0', '0', '1', '3', '0', '0', '1');
INSERT INTO `yk365_videos` VALUES ('12', '1', '555', '王牌逗王牌', '/uploads/video/20170514144938_894.jpg', 'http://www.360kan.com/m/gqbnZhH2RHH2SB.html', '', '', '0', '0', '0', '0', '3', '0', '0', '1');
INSERT INTO `yk365_videos` VALUES ('13', '1', '561', '铁血军魂', '/uploads/video/20170514145121_645.jpg', 'http://www.360kan.com/tv/PLFoan7kTzDsNX.html', '', '', '0', '0', '0', '1', '3', '0', '0', '0');
INSERT INTO `yk365_videos` VALUES ('14', '1', '555', '外科风云', '/uploads/video/20170514145304_657.jpg', 'http://www.360kan.com/tv/PLZuan7kTzHoMX.html', '', '', '0', '0', '0', '1', '3', '0', '0', '0');


-- ----------------------------
-- Table structure for yk365_webdata
-- ----------------------------
DROP TABLE IF EXISTS `yk365_webdata`;
CREATE TABLE `yk365_webdata` (
  `web_id` int(10) unsigned NOT NULL DEFAULT '0',
  `web_ip` int(10) unsigned NOT NULL DEFAULT '0',
  `web_brank` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `web_r360` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `web_grank` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `web_srank` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `web_arank` int(10) unsigned NOT NULL DEFAULT '0',
  `web_instat` int(10) unsigned NOT NULL DEFAULT '0',
  `web_outstat` int(10) unsigned NOT NULL DEFAULT '0',
  `web_views` int(10) unsigned NOT NULL DEFAULT '0',
  `web_errors` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `web_itime` int(10) unsigned NOT NULL DEFAULT '0',
  `web_otime` int(10) unsigned NOT NULL DEFAULT '0',
  `web_utime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`web_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站数据表';

-- ----------------------------
-- Records of yk365_webdata
-- ----------------------------
INSERT INTO `yk365_webdata` VALUES ('4', '1896984346', '0', '0', '0', '0', '592', '0', '0', '780', '0', '0', '0', '1473524555');
INSERT INTO `yk365_webdata` VALUES ('3', '1995767128', '0', '0', '0', '0', '40', '0', '0', '642', '0', '0', '0', '1473523274');
INSERT INTO `yk365_webdata` VALUES ('5', '3738840528', '0', '0', '0', '0', '109', '1', '0', '563', '0', '0', '0', '1473523785');
INSERT INTO `yk365_webdata` VALUES ('11', '3029321767', '0', '0', '0', '0', '585', '1', '0', '398', '0', '0', '0', '1473524232');
INSERT INTO `yk365_webdata` VALUES ('7', '977267960', '0', '0', '0', '0', '13', '0', '0', '591', '0', '0', '0', '1473523753');
INSERT INTO `yk365_webdata` VALUES ('8', '1881000948', '7', '7', '0', '2', '1179', '0', '0', '577', '0', '0', '0', '1524554414');
INSERT INTO `yk365_webdata` VALUES ('9', '2095202317', '0', '0', '0', '0', '1315', '0', '0', '362', '0', '0', '0', '1473523903');
INSERT INTO `yk365_webdata` VALUES ('10', '2061822417', '0', '0', '0', '0', '1414', '0', '0', '549', '0', '0', '0', '1473524338');
INSERT INTO `yk365_webdata` VALUES ('12', '0', '0', '0', '0', '0', '0', '0', '0', '411', '0', '0', '0', '1524546324');
INSERT INTO `yk365_webdata` VALUES ('13', '2070362498', '0', '0', '0', '0', '226', '0', '0', '429', '0', '0', '0', '1473523114');
INSERT INTO `yk365_webdata` VALUES ('14', '1896975541', '0', '0', '0', '0', '22152', '1', '0', '340', '0', '0', '0', '1473524357');
INSERT INTO `yk365_webdata` VALUES ('15', '3029321767', '0', '0', '0', '0', '88', '0', '0', '497', '0', '0', '0', '1473524077');
INSERT INTO `yk365_webdata` VALUES ('16', '987506523', '0', '0', '0', '0', '0', '0', '0', '371', '0', '0', '0', '1473524127');
INSERT INTO `yk365_webdata` VALUES ('17', '987196695', '0', '0', '0', '0', '2581', '0', '0', '453', '0', '0', '0', '1473524052');
INSERT INTO `yk365_webdata` VALUES ('18', '2002401992', '0', '0', '0', '0', '1322', '0', '0', '406', '0', '0', '0', '1473524018');
INSERT INTO `yk365_webdata` VALUES ('19', '0', '8', '7', '0', '2', '0', '0', '0', '682', '0', '0', '0', '1524563904');
INSERT INTO `yk365_webdata` VALUES ('20', '709953839', '0', '0', '0', '0', '4359', '0', '0', '480', '0', '0', '0', '1473522834');
INSERT INTO `yk365_webdata` VALUES ('21', '709957264', '0', '0', '0', '0', '87193', '0', '0', '472', '0', '0', '0', '1473522801');
INSERT INTO `yk365_webdata` VALUES ('22', '1707567102', '6', '0', '5', '1', '52', '0', '0', '624', '0', '0', '0', '1453259003');
INSERT INTO `yk365_webdata` VALUES ('23', '3074218340', '7', '0', '7', '2', '20420', '0', '0', '457', '0', '0', '0', '1453259057');
INSERT INTO `yk365_webdata` VALUES ('24', '1949820519', '7', '0', '1', '1', '284682', '2', '0', '463', '0', '0', '0', '1453259135');
INSERT INTO `yk365_webdata` VALUES ('25', '2073441294', '6', '0', '6', '2', '87193', '1', '0', '337', '0', '0', '0', '1453259275');
INSERT INTO `yk365_webdata` VALUES ('26', '2071818967', '6', '0', '6', '2', '23', '0', '0', '507', '0', '0', '0', '1485446930');
INSERT INTO `yk365_webdata` VALUES ('27', '3663520633', '0', '0', '0', '0', '6753', '0', '0', '430', '0', '0', '0', '1473522889');
INSERT INTO `yk365_webdata` VALUES ('28', '2005336008', '0', '0', '0', '0', '4125', '0', '0', '465', '0', '0', '0', '1473524303');
INSERT INTO `yk365_webdata` VALUES ('29', '2073472948', '0', '0', '0', '0', '2510', '0', '0', '460', '0', '0', '0', '1473524720');
INSERT INTO `yk365_webdata` VALUES ('30', '248973651', '8', '0', '6', '2', '5137', '0', '0', '376', '0', '0', '0', '1453259797');
INSERT INTO `yk365_webdata` VALUES ('31', '2362301538', '0', '0', '0', '0', '1221', '0', '0', '435', '0', '0', '0', '1453259749');
INSERT INTO `yk365_webdata` VALUES ('32', '1709392542', '8', '0', '4', '2', '58432', '0', '0', '463', '0', '0', '0', '1453259718');
INSERT INTO `yk365_webdata` VALUES ('33', '1786294701', '0', '0', '0', '0', '369', '0', '0', '467', '0', '0', '0', '1473524186');
INSERT INTO `yk365_webdata` VALUES ('34', '1944558664', '0', '0', '0', '0', '5709', '0', '0', '222', '0', '0', '0', '1473524037');
INSERT INTO `yk365_webdata` VALUES ('35', '3702889826', '8', '0', '1', '1', '4298', '0', '0', '541', '0', '0', '0', '1453259978');
INSERT INTO `yk365_webdata` VALUES ('36', '737807402', '0', '0', '0', '0', '116', '0', '0', '625', '0', '0', '0', '1473523843');
INSERT INTO `yk365_webdata` VALUES ('37', '2006133147', '0', '0', '0', '0', '5312', '0', '0', '423', '0', '0', '0', '1473524705');
INSERT INTO `yk365_webdata` VALUES ('38', '236013582', '0', '0', '0', '0', '22414', '1', '0', '433', '0', '0', '0', '1473524096');
INSERT INTO `yk365_webdata` VALUES ('39', '3663515978', '0', '0', '0', '0', '5376', '0', '0', '448', '0', '0', '0', '1473524146');
INSERT INTO `yk365_webdata` VALUES ('40', '709952847', '0', '0', '0', '0', '1078', '0', '0', '270', '0', '0', '0', '1473524321');
INSERT INTO `yk365_webdata` VALUES ('41', '1780921136', '0', '0', '0', '0', '13682', '0', '0', '447', '0', '0', '0', '1473522782');
INSERT INTO `yk365_webdata` VALUES ('42', '709957264', '6', '0', '6', '2', '108139', '0', '0', '424', '0', '0', '0', '1453260662');
INSERT INTO `yk365_webdata` VALUES ('43', '3054648645', '6', '0', '6', '2', '8561', '1', '0', '490', '0', '1486195500', '0', '1453260809');
INSERT INTO `yk365_webdata` VALUES ('44', '2093652550', '6', '0', '6', '2', '360606', '0', '0', '474', '0', '0', '0', '1453261079');
INSERT INTO `yk365_webdata` VALUES ('45', '3395701651', '0', '0', '0', '0', '13', '0', '0', '443', '0', '0', '0', '1473522757');
INSERT INTO `yk365_webdata` VALUES ('46', '3702872591', '8', '0', '7', '2', '39', '0', '0', '418', '0', '0', '0', '1453261200');
INSERT INTO `yk365_webdata` VALUES ('47', '3702884893', '8', '0', '7', '2', '8', '0', '0', '462', '0', '0', '0', '1453261300');
INSERT INTO `yk365_webdata` VALUES ('48', '3026316100', '9', '0', '7', '2', '109', '0', '0', '533', '0', '0', '0', '1453261256');
INSERT INTO `yk365_webdata` VALUES ('49', '248973651', '8', '0', '7', '2', '0', '0', '0', '468', '0', '0', '0', '1453261347');
INSERT INTO `yk365_webdata` VALUES ('50', '3074213095', '0', '0', '0', '0', '281', '4', '0', '522', '0', '0', '0', '1486364280');
INSERT INTO `yk365_webdata` VALUES ('51', '3395701651', '0', '0', '0', '0', '13', '0', '0', '497', '0', '0', '0', '1473522608');
INSERT INTO `yk365_webdata` VALUES ('52', '248994059', '8', '0', '8', '2', '109', '0', '0', '562', '0', '0', '0', '1453348393');
INSERT INTO `yk365_webdata` VALUES ('53', '3729360439', '4', '0', '7', '2', '488', '0', '0', '407', '0', '0', '0', '1453348459');
INSERT INTO `yk365_webdata` VALUES ('54', '3078864979', '4', '0', '0', '1', '81950', '0', '0', '498', '0', '0', '0', '1453348548');
INSERT INTO `yk365_webdata` VALUES ('55', '2016919612', '0', '0', '0', '0', '2270', '0', '0', '427', '0', '0', '0', '1473524433');
INSERT INTO `yk365_webdata` VALUES ('56', '1902852393', '7', '0', '7', '2', '112', '0', '0', '443', '0', '0', '0', '1453348722');
INSERT INTO `yk365_webdata` VALUES ('57', '2874908258', '6', '0', '7', '2', '12857', '0', '0', '513', '0', '0', '0', '1453348789');
INSERT INTO `yk365_webdata` VALUES ('58', '1034196469', '0', '0', '0', '0', '2849', '0', '0', '589', '0', '0', '0', '1473522596');
INSERT INTO `yk365_webdata` VALUES ('59', '3729577294', '1', '0', '6', '2', '29527', '0', '0', '383', '0', '0', '0', '1453446008');
INSERT INTO `yk365_webdata` VALUES ('60', '248994057', '5', '0', '0', '1', '11302', '0', '0', '710', '0', '0', '0', '1453446131');
INSERT INTO `yk365_webdata` VALUES ('61', '1946860216', '0', '0', '0', '0', '8318', '0', '0', '399', '0', '0', '0', '1473524216');
INSERT INTO `yk365_webdata` VALUES ('62', '3702851611', '6', '0', '7', '2', '109', '0', '0', '347', '0', '0', '0', '1453446364');
INSERT INTO `yk365_webdata` VALUES ('63', '3026198010', '7', '0', '7', '2', '5745', '0', '0', '521', '0', '0', '0', '1453446402');
INSERT INTO `yk365_webdata` VALUES ('64', '2095175373', '9', '0', '6', '2', '64', '0', '0', '557', '0', '0', '0', '1453446458');
INSERT INTO `yk365_webdata` VALUES ('65', '3549627424', '9', '0', '7', '2', '199', '0', '0', '437', '0', '0', '0', '1453446506');
INSERT INTO `yk365_webdata` VALUES ('66', '1032941865', '6', '0', '7', '2', '572', '0', '0', '448', '0', '0', '0', '1453446597');
INSERT INTO `yk365_webdata` VALUES ('67', '2061512165', '8', '0', '9', '2', '47', '0', '0', '630', '0', '0', '0', '1453446640');
INSERT INTO `yk365_webdata` VALUES ('68', '987633822', '5', '0', '7', '2', '245', '1', '0', '437', '0', '0', '0', '1453446672');
INSERT INTO `yk365_webdata` VALUES ('69', '1033061206', '6', '0', '5', '2', '20059', '0', '0', '642', '0', '0', '0', '1453446817');
INSERT INTO `yk365_webdata` VALUES ('70', '3074323193', '9', '0', '7', '2', '17038', '0', '0', '159', '0', '0', '0', '1453446858');
INSERT INTO `yk365_webdata` VALUES ('71', '3729370770', '0', '0', '0', '0', '5036', '0', '0', '478', '0', '0', '0', '1473524623');
INSERT INTO `yk365_webdata` VALUES ('72', '0', '0', '0', '0', '0', '0', '0', '0', '485', '0', '0', '0', '1524563890');
INSERT INTO `yk365_webdata` VALUES ('73', '3411087746', '0', '0', '0', '0', '114', '1', '0', '449', '0', '0', '0', '1473524405');
INSERT INTO `yk365_webdata` VALUES ('74', '2006044474', '0', '0', '0', '0', '1813', '22', '0', '450', '0', '1524270226', '0', '1473523999');
INSERT INTO `yk365_webdata` VALUES ('75', '987633822', '8', '0', '7', '2', '5534', '0', '0', '488', '0', '0', '0', '1453448103');
INSERT INTO `yk365_webdata` VALUES ('76', '987633822', '6', '0', '6', '2', '37180', '0', '0', '395', '0', '0', '0', '1453448143');
INSERT INTO `yk365_webdata` VALUES ('77', '3757884295', '7', '0', '7', '2', '109', '0', '0', '369', '0', '0', '0', '1453448232');
INSERT INTO `yk365_webdata` VALUES ('78', '3736006571', '0', '0', '0', '0', '20993', '2', '1', '431', '0', '1524270637', '0', '1473524669');
INSERT INTO `yk365_webdata` VALUES ('79', '2937694993', '0', '0', '0', '0', '24567', '3', '0', '761', '0', '1492310744', '0', '1473524284');
INSERT INTO `yk365_webdata` VALUES ('80', '2030784035', '7', '0', '7', '2', '2284', '0', '0', '495', '0', '0', '0', '1453448865');
INSERT INTO `yk365_webdata` VALUES ('81', '3683539306', '7', '0', '7', '2', '1171', '0', '0', '476', '0', '0', '0', '1453448933');
INSERT INTO `yk365_webdata` VALUES ('82', '2085286914', '7', '0', '7', '2', '4349', '0', '0', '365', '0', '0', '0', '1453448991');
INSERT INTO `yk365_webdata` VALUES ('83', '2085288593', '8', '0', '8', '2', '2045', '0', '0', '508', '0', '0', '0', '1453449085');
INSERT INTO `yk365_webdata` VALUES ('84', '2085288944', '7', '0', '7', '2', '3037', '0', '0', '464', '0', '0', '0', '1453449141');
INSERT INTO `yk365_webdata` VALUES ('93', '977267960', '4', '0', '7', '2', '13', '0', '0', '463', '0', '0', '0', '1454642502');
INSERT INTO `yk365_webdata` VALUES ('86', '3026212544', '6', '0', '7', '2', '8', '0', '0', '405', '0', '0', '0', '1453537474');
INSERT INTO `yk365_webdata` VALUES ('87', '236795426', '7', '0', '6', '2', '12900', '0', '0', '424', '0', '0', '0', '1453537552');
INSERT INTO `yk365_webdata` VALUES ('88', '1984131143', '7', '0', '7', '2', '59262', '0', '0', '462', '0', '0', '0', '1453537672');
INSERT INTO `yk365_webdata` VALUES ('89', '3663519188', '7', '0', '7', '2', '3400', '0', '0', '352', '0', '0', '0', '1453537726');
INSERT INTO `yk365_webdata` VALUES ('90', '1882265365', '7', '8', '6', '2', '1537', '0', '0', '382', '0', '0', '0', '1524650758');
INSERT INTO `yk365_webdata` VALUES ('91', '3722757926', '7', '0', '6', '2', '6172', '0', '0', '0', '0', '0', '0', '1453774602');
INSERT INTO `yk365_webdata` VALUES ('92', '2875937821', '0', '0', '0', '0', '4465', '0', '0', '318', '0', '0', '0', '1454039179');
INSERT INTO `yk365_webdata` VALUES ('94', '2032822100', '0', '0', '0', '0', '0', '147', '0', '446', '0', '1523955163', '0', '1456472637');
INSERT INTO `yk365_webdata` VALUES ('95', '3074274520', '6', '0', '2', '1', '4137', '0', '0', '295', '0', '0', '0', '1456472795');
INSERT INTO `yk365_webdata` VALUES ('96', '3074231784', '5', '0', '6', '2', '16461', '0', '0', '365', '0', '0', '0', '1456472937');
INSERT INTO `yk365_webdata` VALUES ('97', '1780922414', '1', '0', '0', '1', '260379', '0', '0', '536', '0', '0', '0', '1456473368');
INSERT INTO `yk365_webdata` VALUES ('98', '3078818770', '6', '0', '0', '1', '7987', '0', '0', '359', '0', '0', '0', '1456748806');
INSERT INTO `yk365_webdata` VALUES ('99', '3524171049', '4', '0', '0', '1', '63117', '0', '0', '435', '0', '0', '0', '1456748939');
INSERT INTO `yk365_webdata` VALUES ('100', '1931223883', '5', '0', '0', '1', '17892', '1', '0', '381', '0', '1524450774', '0', '1456749360');
INSERT INTO `yk365_webdata` VALUES ('101', '3730095304', '4', '0', '0', '1', '115', '21', '0', '456', '0', '1524058095', '0', '1457485874');
INSERT INTO `yk365_webdata` VALUES ('102', '993533661', '6', '0', '6', '2', '248', '0', '0', '564', '0', '0', '0', '1457486163');
INSERT INTO `yk365_webdata` VALUES ('103', '3702872588', '7', '0', '7', '2', '39', '0', '0', '476', '0', '0', '0', '1457486520');
INSERT INTO `yk365_webdata` VALUES ('104', '3079199058', '6', '0', '6', '2', '5835', '0', '0', '424', '0', '0', '0', '1457486502');
INSERT INTO `yk365_webdata` VALUES ('105', '1968135284', '6', '0', '7', '2', '812', '0', '0', '315', '0', '0', '0', '1457486759');
INSERT INTO `yk365_webdata` VALUES ('106', '2340533970', '0', '0', '0', '0', '0', '0', '0', '383', '0', '0', '0', '1463641147');
INSERT INTO `yk365_webdata` VALUES ('107', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1460877081');
INSERT INTO `yk365_webdata` VALUES ('108', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '1460878138');
INSERT INTO `yk365_webdata` VALUES ('109', '3683186088', '7', '0', '0', '2', '19776', '1', '0', '370', '0', '1490162970', '0', '1460877191');
INSERT INTO `yk365_webdata` VALUES ('110', '3722762328', '0', '0', '0', '0', '9817', '0', '0', '509', '0', '0', '0', '1473524257');
INSERT INTO `yk365_webdata` VALUES ('111', '1731753046', '7', '0', '0', '2', '1064', '0', '0', '421', '0', '0', '0', '1460878822');
INSERT INTO `yk365_webdata` VALUES ('112', '0', '0', '0', '0', '0', '0', '0', '0', '834', '0', '0', '0', '1524563925');
INSERT INTO `yk365_webdata` VALUES ('127', '0', '0', '0', '0', '0', '0', '0', '0', '24', '0', '0', '0', '1524546333');
INSERT INTO `yk365_webdata` VALUES ('126', '0', '0', '0', '0', '0', '0', '0', '0', '22', '0', '0', '0', '1483592000');
INSERT INTO `yk365_webdata` VALUES ('125', '1743466023', '0', '0', '0', '0', '4', '32', '0', '25', '0', '1484012402', '0', '1483592037');
INSERT INTO `yk365_webdata` VALUES ('118', '0', '0', '0', '0', '0', '0', '3', '0', '120', '0', '0', '0', '1492400597');
INSERT INTO `yk365_webdata` VALUES ('119', '0', '0', '0', '0', '0', '0', '0', '0', '99', '0', '0', '0', '1473522745');
INSERT INTO `yk365_webdata` VALUES ('120', '0', '0', '0', '0', '0', '0', '0', '0', '172', '0', '0', '0', '1473523671');
INSERT INTO `yk365_webdata` VALUES ('124', '0', '0', '0', '0', '0', '0', '0', '0', '10', '0', '0', '0', '1524649235');
INSERT INTO `yk365_webdata` VALUES ('123', '0', '0', '0', '0', '0', '0', '0', '0', '22', '0', '0', '0', '1524563937');
INSERT INTO `yk365_webdata` VALUES ('132', '2043216828', '6', '5', '0', '1', '10450', '0', '0', '0', '0', '0', '0', '1524650465');
INSERT INTO `yk365_webdata` VALUES ('131', '0', '7', '8', '0', '9', '0', '0', '0', '0', '0', '0', '0', '1524649225');
INSERT INTO `yk365_webdata` VALUES ('136', '794767357', '8', '8', '0', '2', '54', '0', '0', '11', '0', '0', '0', '1524648719');
INSERT INTO `yk365_webdata` VALUES ('1', '1881000948', '7', '7', '0', '9', '1184', '0', '0', '0', '0', '0', '0', '1524619846');

-- ----------------------------
-- Table structure for yk365_weblinks
-- ----------------------------
DROP TABLE IF EXISTS `yk365_weblinks`;
CREATE TABLE `yk365_weblinks` (
  `link_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `web_id` int(10) unsigned NOT NULL DEFAULT '0',
  `deal_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_name` varchar(20) DEFAULT NULL,
  `link_type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_pos` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_price` int(3) unsigned NOT NULL DEFAULT '0',
  `link_if1` int(10) unsigned NOT NULL DEFAULT '0',
  `link_if2` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_if3` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `link_if4` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `link_intro` varchar(200) DEFAULT NULL,
  `link_days` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `link_views` int(10) unsigned NOT NULL DEFAULT '0',
  `link_istop` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_hide` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `link_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`link_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='链接交易表';

-- ----------------------------
-- Records of yk365_weblinks
-- ----------------------------

-- ----------------------------
-- Table structure for yk365_website
-- ----------------------------
DROP TABLE IF EXISTS `yk365_website`;
CREATE TABLE `yk365_website` (
  `web_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cate_id` int(5) unsigned NOT NULL DEFAULT '0',
  `web_name` varchar(100) DEFAULT NULL,
  `web_url` varchar(255) DEFAULT NULL,
  `web_tags` varchar(100) DEFAULT NULL,
  `web_pic` varchar(100) DEFAULT NULL,
  `web_qq` varchar(20) DEFAULT NULL,
  `web_intro` text DEFAULT NULL ,
  `web_istop` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `web_isbest` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `web_status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `web_ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `web_ispay` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `web_islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `web_ico` varchar(50) DEFAULT NULL,
  `web_utime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`web_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='网站信息表';
-- ----------------------------
-- Records of yk365_website
-- ----------------------------
INSERT INTO `yk365_website` VALUES ('4', '1', '213', '360', 'http://www.360.com', '360,360安全卫士,360杀毒,360手机卫士,360安全浏览器,360极速浏览器,360商城,360奇酷手机,360智能家居,360智能摄像机,360儿童卫士智能手表,360行车记录仪,360电', '', '', '360免费安全软件平台和智能硬件家居平台，免费安全软件平台为用户提供360安全卫士、360免费杀毒软件、360企业杀毒软件、360安全浏览器等安全软件。智能硬件家居平台包含奇酷手机、智能摄像机、儿童智能手表、行车记录仪、智能路由器、超级充电器等智能硬件。', '1', '1', '3', '1452614757', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('11', '1', '349', '汽车之家', 'http://www.autohome.com.cn', '汽车,汽车之家,汽车网,汽车报价,汽车图片,新闻,评测,社区,俱乐部', '', '', '汽车之家为您提供最新汽车报价，汽车图片，汽车价格大全，最精彩的汽车新闻、行情、评测、导购内容，是提供信息最快最全的中国汽车网站。', '1', '1', '3', '1452744050', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('3', '1', '213', '搜狐', 'http://www.sohu.com', '搜狐,门户网站,新媒体,网络媒体,新闻,财经,体育,娱乐,时尚,汽车,房产,科技,图片,论坛,微博,博客,视频,电影,电视剧', '', '', '搜狐网为用户提供24小时不间断的最新资讯，及搜索、邮件等网络服务。内容包括全球热点事件、突发新闻、时事评论、热播影视剧、体育赛事、行业动态、生活服务信息，以及论坛、博客、微博、我的搜狐等互动空间。', '1', '1', '3', '1452613903', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('5', '1', '213', '网易', 'http://www.163.com', '网易,邮箱,游戏,新闻,体育,娱乐,女性,亚运,论坛,短信,数码,汽车,手机,财经,科技,相册', '', '', '网易是中国领先的互联网技术公司，为用户提供免费邮箱、游戏、搜索引擎服务，开设新闻、娱乐、体育等30多个内容频道，及博客、视频、论坛等互动交流，网聚人的力量。', '1', '1', '3', '1452664547', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('12', '1', '297', '京东', 'http://www.jd.com', '网上购物,网上商城,手机,笔记本,电脑,mp3,cd,vcd,dv,相机,数码,配件,手表,存储卡,京东', '', '', '京东JD.COM-专业的综合网上购物商城,销售家电、数码通讯、电脑、家居百货、服装服饰、母婴、图书、食品等数万个品牌优质商品.便捷、诚信的服务，为您提供愉悦的网上购物体验!', '1', '0', '3', '1452746011', '0', '0', '', '0');
INSERT INTO `yk365_website` VALUES ('7', '1', '213', '新浪', 'http://www.sina.com.cn', '新浪,新浪网,sina,sina,sina.com.cn,新浪首页,门户,资讯', '', '', '新浪网为全球用户24小时提供全面及时的中文资讯，内容覆盖国内外突发新闻事件、体坛赛事、娱乐时尚、产业资讯、实用信息等，设有新闻、体育、娱乐、财经、科技、房产、汽车等30多个内容频道，同时开设博客、视频、论坛等自由互动交流空间。', '1', '1', '3', '1452743001', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('8', '1', '213', '凤凰网', 'http://www.ifeng.com', '凤凰,凤凰网,凤凰新媒体,凤凰卫视,凤凰卫视中文台,资讯台,电影台,欧洲台,美洲台,凤凰周刊,phoenix,phoenixtv', '', '', '凤凰网是中国领先的综合门户网站，提供含文图音视频的全方位综合新闻资讯、深度访谈、观点评论、财经产品、互动应用、分享社区等服务，同时与凤凰无线、凤凰宽频形成三屏联动，为全球主流华人提供互联网、无线通信、电视网三网融合无缝衔接的新媒体优质体验。', '1', '0', '3', '1452743091', '0', '0', 'http://www.ifeng.com/favicon.ico', '0');
INSERT INTO `yk365_website` VALUES ('9', '1', '406', '携程', 'http://www.ctrip.com', '酒店预订,特价酒店, 机票,机票预订,飞机票查询,航班查询,酒店团购,旅游度假,旅行,商旅管理', '', '', '携程旅行网是中国领先的在线旅行服务公司，向超过9000万会员提供酒店预订、酒店点评及特价酒店查询、机票预订、飞机票查询、时刻表、票价查询、航班查询、度假预订、商旅管理、为您的出行提供全方位旅行服务。', '1', '1', '3', '1452743286', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('10', '1', '157', '4399游戏', 'http://www.4399.com', '小游戏,4399小游戏大全,在线小游戏', '', '', '4399是中国最大的小游戏专业网站,免费为你提供小游戏大全,4399洛克王国小游戏,双人小游戏,连连看小游戏,赛尔号,奥拉星,奥奇传说小游戏,造梦西游3等最新小游戏。', '1', '1', '3', '1452743582', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('13', '1', '223', '中关村在线', 'http://www.zol.com.cn', '中关村在线,中关村,电脑报价,新闻,行情,导购,装机,攒机,评测,新品,软件,下载,产品,报价,经销商,二手,数码,手机,数码相机,数码摄像机,dc,dv,mp3,mp4,论坛,硬件论坛', '', '', '中国领先的IT信息与商务门户, 包括新闻, 商城, 硬件, 下载, 游戏, 手机, 评测等40个大型频道，每天发布大量各类产品促销信息及文章专题，是IT行业的厂商, 经销商, IT产品, 解决方案的提供场所', '0', '0', '3', '1452839664', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('14', '1', '407', '同程旅游', 'http://www.ly.com', '奔跑吧兄弟,旅游,旅游网,旅游线路,酒店预订,特价机票,景点门票,出境游,周边游,国内游,同程旅游', '', '', '同程旅游(LY.COM)是一家专业的一站式旅游预订平台，奔跑吧兄弟官方指定旅游网站，提供近万家景点门票、特价机票、出境游、周边游、邮轮旅行及酒店预订服务；专业服务、让您的旅行更安心！', '1', '1', '3', '1452839892', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('15', '1', '212', '央视网', 'http://www.cntv.cn', '央视网 中央电视台 央视 cctv  cctv.com  cctv.cn 新闻 体育 奥运 综艺 科教 cctv-1 cctv新闻 cctv体育 新闻联播 焦点访谈 领导人视频集 网络新闻联播 365', '', '', '央视网(www.cctv.com)是中国网络电视台旗下互联网站业务，也是中央重点新闻网站，以视频为特色，以互动和移动服务为基础，以特色产品和独家观点为核心，面向全球、多终端、立体化的新闻信息共享平台。', '1', '1', '3', '1452840082', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('16', '1', '299', '折800', 'http://www.zhe800.com', '折800,折800官网,折八百,9.9包邮,九块九包邮,折800天天特价,zhe800,折八百官网,9块9包邮', '/uploads/website/www.zhe800.com.jpg', '', '折800(折八百)-优质折扣商品推荐平台「谢娜代言」。每天精选千款超值折扣商品，特卖1折起，8块8包邮、9.9包邮的宝贝天天有，欢迎选购！【折800 真便宜】', '1', '1', '3', '1452841746', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('17', '1', '213', '人民网', 'http://www.people.com.cn', '人民网,人民日报,中国共产党新闻,新闻中心,时政,社会,地方,地方领导,经济,能源环保,跨国公司,新农村,教育,科技,文化,饮食,娱乐,旅游,游戏,短信,彩信,资料,人民电视图片,直播,访谈,观点,理', '', '', '人民网，是世界十大报纸之一《人民日报》建设的以新闻为主的大型网上信息发布平台，也是互联网上最大的中文和多语种新闻网站之一。作为国家重点新闻网站，人民网以新闻报道的权威性、及时性、多样性和评论性为特色，在网民中树立起了“权威媒体、大众网站”的形象。', '1', '1', '3', '1452841981', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('18', '1', '301', '当当网', 'http://www.dangdang.com', '当当网,当当,网上购物,网上商城,网上买书,购物中心,在线购物,图书,影视,音像,教育音像,cd, dvd,百货,母婴,家居,家纺,厨具,化妆品,美妆,个人护理用品,数码,电脑,笔记本,u盘,手机,m', '', '', '全球领先的综合性网上购物中心。超过100万种商品在线热销！图书、音像、母婴、美妆、家居、数码3C、服装、鞋包等几十大类，正品行货，低至2折，700多城市货到付款，（全场购物满29元免运费。当当网一贯秉承提升顾客体验的承诺，自助退换货便捷又放心）。', '1', '1', '3', '1452842075', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('19', '1', '213', '新华网', 'http://www.xinhuanet.com', '新闻中心,时政,人事任免,国际,地方,香港,台湾,澳门,华人,军事,图片,财经,政权,股票,房产,汽车,体育,奥运,法治,廉政,社会,科技,互联网,教育,文娱,电视剧,电影,视频,访谈,直播,专题', '', '', '中国主要重点新闻网站,依托新华社遍布全球的采编网络,记者遍布世界100多个国家和地区,地方频道分布全国31个省市自治区,每天24小时同时使用6种语言滚动发稿,权威、准确、及时播发国内外重要新闻和重大突发事件,受众覆盖200多个国家和地区,发展论坛是全球知名的中文论坛。', '1', '0', '3', '1453107436', '0', '0', 'http://www.xinhuanet.com/favicon.ico', '0');
INSERT INTO `yk365_website` VALUES ('20', '1', '157', '7k7k小游戏', 'http://www.7k7k.com', '小游戏,7k7k小游戏,双人小游戏,小游戏大全,双人小游戏大全', '', '', '7k7k小游戏大全包含洛克王国,赛尔号,7k7k洛克王国,连连看 ,连连看小游戏大全,美女小游戏,双人小游戏大全,在线小游戏,7k7k赛尔号,7k7k奥拉星,斗破苍穹 2,7k7k奥比岛,7k7k弹弹堂,7k7k单人小游戏,奥比岛小游戏,7k7k功夫派,7k7k小花仙,功夫派等最新小游戏。', '0', '0', '3', '1453258729', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('22', '1', '157', '360小游戏', 'http://xiaoyouxi.360.cn', '', '', '', '360游戏', '0', '0', '3', '1453259003', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('21', '1', '157', '2144小游戏', 'http://www.2144.cn', '小游戏,网页游戏,网页游戏大全,在线小游戏,小游戏下载,2144小游戏,手机游戏,手机游戏下载', '', '', '2144游戏是中国最专业的游戏平台,免费为你提供各种精品小游戏,最全的网页游戏,好玩的手机游戏,同时还提供精品游戏专题，游戏攻略，人气论坛等，玩小游戏,网页游戏,手机游戏就上2144游戏网2144.cn', '0', '0', '3', '1453258769', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('23', '1', '157', '3366小游戏', 'http://www.3366.com', '小游戏,3366小游戏,小游戏大全,在线小游戏', '', '', '3366小游戏是最有影响力的Flash小游戏网站，提供安全免费的在线小游戏。有双人小游戏大全，儿童小游戏，网页游戏，积分小游戏，中文小游戏，射击小游戏等17类最新小游戏。', '0', '0', '3', '1453259057', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('24', '1', '157', '543儿童游戏', 'http://www.543.cn', '动画片,小游戏,儿童故事,儿童儿歌,qq个性,爱星座,测试', '', '', '543儿童网站提供动画片、小游戏、儿童故事、儿童儿歌、qq个性、爱星座、神测试等与儿童相关的内容；致力于打造最全的儿童娱乐网站，让每一位小朋友都能在快乐中成长！', '0', '0', '3', '1453259135', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('25', '1', '155', '37游戏', 'http://www.37.com', '37游戏,三七玩,网页游戏平台,37.com,网页游戏', '', '', '37游戏平台是专业的游戏运营平台，为中外游戏用户提供精品游戏；37游戏致力于游戏精细化运营与优质的客户服务，成为深受玩家喜爱的国际化品牌游戏运营商。', '0', '0', '3', '1453259275', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('26', '1', '157', '小游戏', 'http://xyx.hao123.com', '小游戏,hao123小游戏,小游戏大全,在线小游戏', '', '', 'hao123小游戏汇聚互联网热门精品小游戏，免费提供数万款在线小游戏，包括植物大战僵尸，愤怒的小鸟，连连看小游戏大全，双人小游戏大全，斗地主，益智小游戏，儿童小游戏等。', '0', '0', '3', '1453259321', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('27', '1', '141', '一听音乐', 'http://www.1ting.com', '音乐,免费音乐,好听的歌,网络歌曲,高品质mp3,音乐下载,经典老歌,最新音乐,dj,佛教音乐,胎教音乐,广场舞,古典音乐,戏曲,qq音乐', '', '', '一听音乐网是中国最大的在线音乐网站，提供免费歌曲在线试听、下载。一听音乐网拥有正版、庞大、完整的曲库，歌曲更新迅速，试听流畅，口碑极佳。一听音乐网，每天听一听', '0', '0', '3', '1453259422', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('28', '1', '141', '酷狗音乐', 'http://www.kugou.com', '', '', '', '酷狗音乐旗下最新最全的在线正版音乐网站，本站为您免费提供最全的在线音乐试听下载，以及全球海量电台和MV播放服务、最新音乐播放器下载。酷狗音乐 和音乐在一起。', '1', '1', '3', '1453259475', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('29', '1', '141', '酷我音乐', 'http://www.kuwo.cn', '音乐,中国好声音,蒙面歌王,音悦台,酷我音乐,音乐播放器,音乐在线听,qq音乐,天地人音乐网,网络歌曲,最新歌曲,好听的歌,英文歌曲,流行歌曲,非主流音乐,经典老歌,劲舞团歌曲,搞笑歌曲,儿童歌曲,云', '', '', '酷我音乐是中国最新最全的在线正版音乐网站,酷我音乐网为您提供音乐,中国好声音,蒙面歌王,音悦台,酷我音乐,音乐播放器,音乐在线听,qq音乐,天地人音乐网,网络歌曲,最新歌曲,好听的歌,英文歌曲,流行歌曲,非主流音乐,经典老歌,劲舞团歌曲,搞笑歌曲,儿童歌曲,云音乐等多种音乐服务.酷我音乐拥有庞大,完整的曲库,歌曲更新迅速,听音乐用酷我。', '1', '1', '3', '1453259507', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('30', '1', '141', '九酷音乐', 'http://www.9ku.com', '音乐,音乐网站,mp3下载,好听的歌,qq音乐,非主流音乐,经典老歌,劲舞团歌曲,搞笑歌曲,儿童歌曲,网络歌曲,最新歌曲,好听的歌,英文歌曲,流行歌曲,音乐排行等专业音乐网站', '', '', '音乐-歌曲.九酷音乐网是专业的在线音乐试听mp3下载网站.收录了网上最新歌曲和流行音乐,网络歌曲,好听的歌,非主流音乐,QQ音乐,经典老歌,劲舞团歌曲,搞笑歌曲,儿童歌曲,英文歌曲等。是您寻找好听的歌首选网站。', '0', '0', '3', '1453259603', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('31', '1', '141', '虾米音乐', 'http://www.xiami.com', '', '', '', '高品质音乐 发现 分享', '0', '0', '3', '1453259631', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('32', '1', '141', '5nd音乐', 'http://www.5nd.com', '歌曲,音乐网站,最新歌曲,mp3歌曲免费下载,歌曲下载,好听的歌,流行歌曲,网络歌曲,伤感歌曲,儿童歌曲,非主流音乐,劲舞团歌曲,英文歌曲,在线音乐网站试听下载', '/uploads/website/www.5nd.com.jpg', '', '歌曲,音乐,提供MP3歌曲免费下载,歌曲下载,在线试听流行歌曲和好听的歌,劲舞团歌曲,伤感歌曲,非主流音乐,好听的英文歌曲,儿童歌曲,网络歌曲,最新歌曲下载,下歌曲听音乐,在线听歌曲尽在5nd音乐网。', '0', '0', '3', '1453259718', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('33', '1', '151', '爱奇艺', 'http://www.iqiyi.com', '高清视频,正版视频,热门电影,经典大片,热播电视剧,综艺,动漫,纪录片,音乐,mv,在线观看,免费观看,网络视频,视频搜索,在线视频,点播', '/uploads/website/www.iqiyi.com.jpg', '', '爱奇艺（iQIYI.COM）,网络视频播放平台；是国内首家专注于提供免费、高清网络视频服务的大型视频网站。爱奇艺影视内容丰富多元，涵盖电影、电视剧、综艺、纪录片、动画片等热门剧目；视频播放清晰流畅，操作界面简单友好，真正为用户带来“悦享品质”的观映体验。', '1', '1', '3', '1453259905', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('34', '1', '149', '乐视', 'http://www.letv.com', '乐视视频,乐视,乐视网,视频播放,视频搜索,视频发布', '', '', '乐视视频是以正版,高清影视剧为主的视频门户,乐视旗下专业影视剧视频网站。为用户提供正版高清电影,电视剧,动漫,综艺等视频在线观看,以及视频分享,视频搜索等服务。', '1', '1', '3', '1453259944', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('36', '1', '149', '优酷', 'http://www.youku.com', '视频,视频分享,视频搜索,视频播放,优酷视频', '', '', '视频服务平台,提供视频播放,视频发布,视频搜索,视频分享', '1', '1', '3', '1453260215', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('35', '1', '149', '360影视', 'http://www.360kan.com', '', '', '', '360影视', '0', '0', '3', '1453259978', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('37', '1', '149', '响巢看看', 'http://www.kankan.com', '看看出品,电影,电视剧,综艺,动漫,娱乐,快报,微电影,纪录片,公开课,游戏,音乐,预告,电视剧榜,创星空间,人气,颜值,电影榜,高清,720p,1080p,新片,点播,大片,tvb,韩剧,好看的电视', '', '', '响巣看看是中国领先的高清影视视频门户，免费提供电影、电视剧、综艺、音乐MV、动漫、新片、大片的高清在线点播和下载，是中国最大最全的正版影视发行平台', '1', '1', '3', '1453260302', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('38', '1', '149', '风行网', 'http://www.fun.tv', '免费电影,电影下载,在线视频,在线电影', '', '', '新一代视频风行网,提供免费电影、电视剧、综艺、动漫、体育等视频内容的在线观看和下载.累积7亿用户的全平台,为传媒机构和品牌客户开设了官方视频服务账号,通过大数据分析与个性推荐订阅技术,实现海量独家内容与用户个性需求即时匹配.', '1', '1', '3', '1453260335', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('39', '1', '149', '56网', 'http://www.56.com', '56.com,视频,电影,电视剧,综艺,搞笑,汽车,游戏,生活,音乐,mv,原创、高清,视频,在线观看,视频分享,视频播放', '/uploads/website/www.56.com.jpg', '', '56网是中国最大的原创视频网站,免费上传搞笑逗趣生活视频，观看优质丰富的特色节目，关注感兴趣的原创导演和美女解说，快速分享及评论互动。', '1', '1', '3', '1453260411', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('40', '1', '170', '起点中文', 'http://www.qidian.com', '', '', '', '起点中文网', '1', '1', '3', '1453260511', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('41', '1', '170', '纵横中文网', 'http://www.zongheng.com', '小说,小说网,免费小说,纵横中文网', '', '', '纵横中文网,最热门的免费小说网站,提供玄幻小说、网游小说、言情小说、穿越小说、都市小说等免费小说在线阅读与下载。大神作品齐聚纵横,最新章节每日更新。', '0', '0', '3', '1453260577', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('42', '1', '170', '小说阅读网', 'http://www.readnovel.com', '小说,言情小说,小说下载,校园小说,穿越小说,玄幻小说', '', '', '《小说阅读网》提供原创小说，包含穿越小说、言情小说、校园小说、玄幻小说、武侠小说、历史小 说、军事小说、网游小说、免费小说等在线阅读和小说下载。页面简洁，无眩杂广告。', '0', '0', '3', '1453260662', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('43', '1', '170', '逐浪小说网', 'http://www.zhulang.com', '小说,小说网,都市小说,玄幻小说,修真小说,穿越小说,历史小说,网络小说,逐浪小说,原创网络文学', '', '', '小说阅读,精彩小说尽在逐浪小说网。逐浪小说提供玄幻小说,武侠小说,网游小说,都市言情小说,历史军事小说,首发小说最新章节免费阅读！热门小说:绝世武神,我的美女总裁老婆,异世灵武天下,九阴九阳,天眼人生,天控者,官途。', '0', '0', '3', '1453260809', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('44', '1', '170', '看书网', 'http://www.kanshu.com', '小说,小说阅读网,小说网', '', '', '看书网,专业原创小说网站,提供最新言情,都市校园,穿越,网游,玄幻,武侠,科幻,历史等小说免费阅读和小说下载,是最好看的小说阅读网。看小说,就上看书网！', '0', '0', '3', '1453261079', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('45', '1', '185', '新浪新闻', 'http://news.sina.com.cn', '新闻,时事,时政,国际,国内,社会,法治,聚焦,评论,文化,教育,新视点,深度,网评,专题,环球,传播,论坛,图片,军事,焦点,排行,环保,校园,法治,奇闻,真情', '/uploads/website/news.sina.com.cn.jpg', '', '新浪网新闻中心是新浪网最重要的频道之一，24小时滚动报道国内、国际及社会新闻。每日编发新闻数以万计。', '0', '0', '3', '1453261156', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('46', '1', '185', '搜狐新闻', 'http://news.sohu.com', '', '/uploads/website/news.sohu.com.jpg', '', '搜狐新闻', '0', '0', '3', '1453261200', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('47', '1', '185', '腾讯新闻', 'http://news.qq.com', '新闻 新闻中心 事实派 新闻频道,时事报道', '/uploads/website/news.qq.com.jpg', '', '腾讯新闻，事实派。新闻中心,包含有时政新闻、国内新闻、国际新闻、社会新闻、时事评论、新闻图片、新闻专题、新闻论坛、军事、历史、的专业时事报道门户网站', '0', '0', '3', '1453261239', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('48', '1', '185', '网易新闻', 'http://news.163.com', '新闻,新闻中心,新闻频道,时事报道', '/uploads/website/news.163.com.jpg', '', '新闻,新闻中心,包含有时政新闻,国内新闻,国际新闻,社会新闻,时事评论,新闻图片,新闻专题,新闻论坛,军事,历史,的专业时事报道门户网站', '0', '0', '3', '1453261256', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('49', '1', '185', '凤凰资讯', 'http://news.ifeng.com', '新闻,时政,时事,评论,专题,大陆,国际,台湾,社会,香港,凤凰卫视,军事,深度,视频,图片,排行,调查', '/uploads/website/news.ifeng.com.jpg', '', '凤凰网资讯、凤凰网新闻24小时提供大陆、台湾、香港、国际重大新闻资讯，军事、社会好玩好看，20个图集看不停，大学问、自由谈、凤凰网评提供大智慧和犀利观点。', '0', '0', '3', '1453261347', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('50', '1', '185', '环球网', 'http://www.huanqiu.com', '环球网,环球时报,军事,国际新闻,兵器,国际军情,中国军力,网络调查,国际话题,视频新闻,最新消息,航母,全球化,舆情,网络评论,全球局势,全球动态,外交,中国外交,全球化,全球新闻,环球资讯,出国', '', '', '环球网是中国领先的国际资讯门户，拥有独立采编权的中央重点新闻网站。环球网秉承环球时报的国际视野，力求及时、客观、权威、独立地报道新闻，致力于应用前沿的互联网技术，为全球化时代的中国互联网用户提供与国际生活相关的资讯服务、互动社区。未来会致力于打造全球化在线生活平台，成为中国与国际之间沟通与交流的桥梁。', '1', '1', '3', '1453261462', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('51', '1', '190', '新浪体育', 'http://sports.sina.com.cn', '体育,体育新闻,新浪体育,新浪竞技风暴,世界杯,奥运会,nba直播', '/uploads/website/sports.sina.com.cn.jpg', '', '新浪体育提供最快速最全面最专业的体育新闻和赛事报道，主要有以下栏目：中国足球、国际足球、篮球、NBA、综合体育、奥运、F1、网球、高尔夫、棋牌、彩票、视频、图片、博客、体育微博、社区论坛', '0', '0', '3', '1453345845', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('52', '1', '190', '网易体育', 'http://sports.163.com', '体育,体育新闻,体育中心,体育图片', '', '', '体育,体育频道,包含体育新闻,NBA,CBA,英超,意甲,西甲,冠军杯,体育比分,足彩,福彩,体育秀色,网球,F1,棋牌,乒羽,体育论坛,中超,中国足球,综合体育等专业体育门户网站', '0', '0', '3', '1453348393', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('53', '1', '190', '虎扑体育', 'http://www.hupu.com', '体育,运动,虎扑体育,虎扑', '', '', '体育,虎扑体育是以篮球,足球,网球,F1,NFL,MMA格斗等运动项目为主的专业体育网站,原创的体育新闻与专栏,最全的体育直播和视频,千万铁杆体育迷尽在虎扑体育.', '0', '0', '3', '1453348459', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('54', '1', '190', '乐视体育', 'http://www.lesports.com', '', '', '', '乐视体育将为您带来：中国足球、国际足球、篮球、NBA、综合体育、奥运、F1、网球、高尔夫、跑步、彩票、等一系列精彩赛事的直播、转播、录像、视频，立志于打造中国最专业的体育赛事平台，关于体育赛事，关注乐视体育', '0', '0', '3', '1453348548', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('55', '1', '190', '直播吧', 'http://www.zhibo8.cc', '直播吧,nba直播,nba直播吧,足球直播,英超直播,cctv5在线直播,cba直播,nba在线直播,nba视频直播,cba直播吧', '', '', '直播吧提供NBA直播,NBA直播吧,足球直播,英超直播,CCTV5在线直播,CBA直播,NBA在线直播,NBA视频直播,等体育赛事直播,我们努力做最好的直播吧', '1', '1', '3', '1453348601', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('56', '1', '196', '中华网军事', 'http://military.china.com', '军事,武器,军事论坛,台海,歼20,四代机,战斗机,武直10,武直19,苏35,运20,辽宁舰,枪,图库,解放军,美军,战争,军事历史,军事新闻,朝鲜半岛,钓鱼岛,南海', '', '', '中华网军事频道是全国最大的军事网站，主要有以下栏目：军事要闻、台海形势、中国军情、国际军情、军事专题、论坛军帖精选、网友原创、军事视频、军事图库、军事论坛。', '0', '0', '3', '1453348722', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('57', '1', '197', '铁血军事', 'http://www.tiexue.net', '', '', '', '铁血军事网', '0', '0', '3', '1453348789', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('58', '1', '196', '环球新军事', 'http://www.xinjunshi.com', '军事,军事网,军事新闻,中国军事,中国军事网,中国新闻,中国军事新闻,最新军事新闻,军情,军事网站,新军事', '/uploads/website/www.xinjunshi.com.jpg', '', '环球新军事网(www.xinjunshi.com) 提供最新军事新闻、中国军事新闻、国际军事新闻、军事图片等军事资料，以中国军事军情为主，每日更新，打造中国优秀前卫军事网站。', '0', '0', '3', '1453445838', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('59', '1', '196', '复兴网', 'http://www.fxingw.com', '复兴网,军事网,复兴军事,军事热点,军事新闻,中国军事,中国军情,军事评论,军事报道,军情解码', '', '', '复兴军事网是专业的中国军事新闻网站，向广大军事网友提供最全的专业军事新闻知识，掌握最新的中国军事新闻，了解中国军情，看中国军事报道，参与中国军事评论，见证中华伟大复兴！', '0', '0', '3', '1453446008', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('60', '1', '197', '强国网', 'http://www.cnqiang.com', '军事,强国,强国军事,军事网站,chn,强国网站,军事新闻,军事装备,最新军情,最新军事消息,最新军事新闻,军事网站,强国网,chn强国网,强国军事,强国网军事,chn,中国海军,中国空军,中国陆军', '', '', '强国网是一个最专业最全面的军事网站，主要有以下栏目：军事新闻,战略时评,军事评论,中国军事,军情聚焦,军事视频,国际观察,强国军事,军事图片', '0', '0', '3', '1453446062', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('61', '1', '207', '猫扑网', 'http://dzh.mop.com', '猫扑大杂烩,网络流行文化,发源地,娱乐互动论坛,btyy', '', '', '猫扑大杂烩网络流行文化发源地,汇集大杂烩,娱乐八卦,原创区,鬼话,游戏烩,人肉搜索,军事烩,汽车烩,冷笑话,猫扑电台等内容为一体的富媒体娱乐互动平台。坚持BT和YY的娱乐精神,现在这里已成为公众舆论的策源地和扩散平台。', '1', '1', '3', '1453446225', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('62', '1', '209', '网易论坛', 'http://bbs.163.com', '论坛,bbs,社区,club,热点,讨论,交友,新闻,情感,游戏,动漫,旅游,摄影,星座,音乐,漫画,时尚,电影,手机,数码,汽车,房产,图片,美容,女人', '/uploads/website/bbs.163.com.jpg', '', '网易论坛,最贴近网友的综合性中文论坛,网络热点一网打尽!', '0', '0', '3', '1453446364', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('63', '1', '211', '西祠胡同', 'http://www.xici.net', '南京西祠胡同,xici,南京生活社区,南京论坛,花嫁,亲子,汽车,旅游,摄影,房产,家居,财富', '', '', '西祠胡同（www.xici.net），是国内首创的网友“自行开版、自行管理、自行发展”的开放式社区平台，致力于为各地用户提供便捷的生活交流空间与本地生活服务平台。', '0', '0', '3', '1453446402', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('64', '1', '207', '天涯论坛', 'http://bbs.tianya.cn', '天涯,天涯论坛,天涯社区,论坛,tianya,bbs', '/uploads/website/bbs.tianya.cn.jpg', '', '全民话题，天涯制造——天涯论坛，华人网上家园', '0', '0', '3', '1453446458', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('65', '1', '207', '豆瓣', 'http://www.douban.com', '', '', '', '提供图书、电影、音乐唱片的推荐、评论和价格比较，以及城市独特的文化生活。', '0', '0', '3', '1453446506', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('66', '1', '232', '太平洋电脑网', 'http://www.pconline.com.cn', '太平洋电脑网,太平洋,it门户,it资讯,电脑,手机,数码', '', '', '太平洋电脑网是专业IT门户网站,为用户和经销商提供IT资讯和行情报价,涉及电脑,手机,数码产品,软件等.', '0', '0', '3', '1453446597', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('67', '1', '232', '苹果官网', 'http://www.apple.com', '', '', '', 'Apple leads the world in innovation with iPhone, iPad, Mac, Apple Watch, iOS, OS X, watchOS and more. Visit the site to learn, buy, and get support.', '0', '0', '3', '1453446640', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('68', '1', '232', '天极网', 'http://www.yesky.com', '天极网,天极,信息,资讯,新闻,企业,行业,市场,产品,评测,价格,行情,经销商,渠道,导购,商城,杂志,数字家庭,电脑,笔记本,整机,服务器,硬件,配件,外设,软件,数码,相机,摄像机,手机,mp3', '', '', '天极网,全球最大的中文IT门户,专注IT产品采购及应用指南,每天为广大用户提供电脑硬件,软件,数码,商情,手机,笔记本,游戏,互联网,数字家庭,教育,下载等内容,解决网友工作学习中的技术疑难,指导数字科技消费,领引时尚生活潮流.', '0', '0', '3', '1453446672', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('69', '1', '232', '我要自学网', 'http://www.51zxw.net', '我要自学网-视频教程|免费教程|自学电脑|3d教程|平面教程|影视动画教程|办公教程|机械设计教程|网站设计教程,我要自学网,视频教程', '', '', '我要自学网-免费视频教程,提供全方位软件学习，有3D教程，平面教程，多媒体制作教程，办公信息化教程，机械设计教程，网站制作教程,电脑培训', '0', '0', '3', '1453446817', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('70', '1', '223', '泡泡网', 'http://www.pcpop.com', '', '', '', '泡泡网是中国领先的数码和消费电子网站,以最具亲和力的方式,面向最广泛的数码及消费电子用户和爱好者,提供专业的资讯、互动、购买在内的全面服务。', '0', '0', '3', '1453446858', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('71', '1', '232', '电脑之家', 'http://www.pchome.net', '电脑报价,新闻,行情,导购,装机,攒机,评测,新品,软件,下载,产品,报价,经销商,数码,手机,数码相机,数码摄像机,dc,dv,mp3,mp4,论坛,硬件论坛', '', '', 'PChome电脑之家是中国优秀的IT资讯服务提供商之一,一直积极倡导\\\\\\\\\\\\\\\'科技引领生活\\\\\\\\\\\\\\\'理念,实现IT资讯与产品走近用户生活为目标', '1', '1', '3', '1453446895', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('72', '1', '297', '苏宁易购', 'http://www.suning.com', '苏宁易购,苏宁易购网上商城,苏宁电器,苏宁云商,suning,手机,电脑,冰箱,洗衣机,相机,数码,家居用品,鞋帽,化妆品,母婴用品,图书,食品,保险,旅行,充值,团购,正品行货,全国联保,货到付款。', '', '', '苏宁易购(Suning.com)网上商城 - 苏宁云商综合网上购物商城，销售传统家电、通讯数码、电脑、家居百货、服装服饰、母婴、图书、食品、保险、旅行、充值等数万类商品和服务。正品行货,全国联保,本地配送,货到付款。省钱放心上苏宁网上商城(原苏宁电器）,尽享购物乐趣！', '1', '0', '3', '1453447115', '1', '0', 'http://www.suning.com/favicon.ico', '0');
INSERT INTO `yk365_website` VALUES ('73', '1', '297', '亚马逊', 'http://www.amazon.cn', '网购,网上购物,在线购物,网购网站,网购商城,购物网站,网购中心,购物中心,卓越,亚马逊,卓越亚马逊,亚马逊中国,joyo,amazon', '', '', '亚马逊中国（z.cn）坚持“以客户为中心”的理念，秉承“天天低价，正品行货”信念，销售图书、电脑、数码家电、母婴百货、服饰箱包等上千万种产品。亚马逊中国提供专业服务：正品行货天天低价，机打发票全国联保。货到付款，30天内可退换货。亚马逊为中国消费者提供便利、快捷的网购体验。', '1', '1', '3', '1453447314', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('74', '1', '299', '唯品会', 'http://www.vip.com', '唯品会,vip,打折,品牌折扣,限时抢购,特卖', '', '', '唯品会vip购物网以1-7折超低折扣对全球各大品牌进行限时特卖，商品囊括服装、化妆品、家居、奢侈品等上千品牌。100%正品、低价、货到付款、7天无理由退货。', '1', '1', '3', '1453447336', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('75', '1', '316', '中彩网', 'http://www.zhcw.com', '彩票,福彩,福利彩票,双色球,福彩3d,七乐彩,东方6+1,&#32;双色球开奖结果,3d开奖结果,七乐彩开奖结果,东方6+1开奖结果', '', '', '中彩网：中国福利彩票发行管理中心指定网络信息发布媒体。提供彩票开奖结果：双色球开奖结果，3D开奖结果，七乐彩开奖结果，东方6+1开奖结果。及彩票走势图：双色球走势图，3D走势图，七乐彩走势图，东方6+1走势图。', '0', '0', '3', '1453448103', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('76', '1', '317', '竞彩网', 'http://www.sporttery.cn', '中国,体育,彩票,竞猜,游戏,方信息,发布,平台,中国,体育', '', '', '[日乙] 周三003：磐田喜悦可复仇 周三004：北九州向日葵有力止跌 [欧冠] 欧冠提点:凯尔特人连胜晋级 周三019：邓多克主场有望强势 [巴西杯] 周三026：瓦斯科达不足信 周三027：庞特普雷塔主场翻盘 [金杯赛] 周三022：邓普西开挂助美国 周三029：墨西哥欲斩巴', '0', '0', '3', '1453448143', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('77', '1', '315', '网易彩票', 'http://caipiao.163.com', '彩票,彩票网,福彩,体彩,合买彩票,中国福利彩票网,中国福利彩票', '/uploads/website/caipiao.163.com.jpg', '', '网易彩票是最值得信赖的专业彩票网站,为彩民提供双色球,大乐透,3D,11选5,足彩,竞彩,北单等众多彩种的彩票代购、合买、开奖等服务，中奖福地，买彩票首选！', '0', '0', '3', '1453448211', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('78', '1', '317', '中国体彩', 'http://www.lottery.gov.cn', '唯一,官方,最快开奖,大奖,巨奖,竞彩,体育彩票,七星彩,排列三,排列五,足彩胜负,足彩进球,足彩半全场,篮球彩票,即开彩,即开型彩票,顶呱刮,省市体彩,无线体彩,体彩数据,22选5,31选7,媒体擂', '', '', '国家体育总局体育彩票管理中心唯一指定官方网站，为彩民提供超级大乐透、排列三、排列五、七星彩、足彩、22选5、31选7等彩种官方准确中奖公告及各种资讯服务。', '1', '1', '3', '1453448344', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('79', '1', '315', '500彩票网', 'http://www.500.com', '足彩,体彩,彩票,体育彩票,足球彩票,彩票合买,竞彩', '', '', '500彩票网彩票购买平台提供足彩、体彩、足球彩票、体育彩票、竞彩、福彩等国家合法彩票的购买合买服务。是一家服务于中国彩民的互联网彩票合买代购交易平台，是当前中国彩票互联网交易行业的领导者。', '1', '1', '3', '1453448371', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('80', '1', '338', '工商银行', 'http://www.icbc.com.cn', '', '', '', '中国工商银行（全称：中国工商银行股份有限公司，Industrial and Commercial Bank of China）简称ICBC ，成立于1984年1月1日。\r\n成立于1984年，是中国五大银行之首，世界五百强企业之一，拥有中国最大的客户群，是中国最大的商业银行。 中国工商银行是中国最大的国有独资商业银行，基本任务是依据国家的法律和法规，通过国内外开展融资活动筹集社会资金，加强信贷资金管理，支持企业生产和技术改造，为我国经济建设服务。', '0', '0', '3', '1453448865', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('81', '1', '338', '建设银行', 'http://www.ccb.com', '', '', '', '中国建设银行（简称建设银行或建行，最初行名为中国人民建设银行，1996年3月26日更名为中国建设银行）成立于1954年(甲午年)10月1日，是股份制商业银行， 是国有五大商业银行之一。中国建设银行主要经营领域包括公司银行业务、个人银行业务和资金业务，中国内地设有分支机构14,121 家（2012年），在香港，台湾，墨尔本等地设有分行，拥有建信基金、建信租赁、建信信托、建信人寿、中德住房储蓄银行、建行亚洲、建行伦敦、建行俄罗斯、建行迪拜、建银国际等多家子公司，为客户提供全面的金融服务。中国建设银行拥有广泛的客户基础，与多个大型企业集团及中国经济战略性行业的主导企业保持银行业务联系，营销网络覆盖全国的主要地区，于2013年6月末，市值为1,767 亿美元，居全球上市银行第五位。[1]  2014年5月8日，2014福布斯全球企业2000强榜单出炉，建行蝉联全球第二大企业', '0', '0', '3', '1453448933', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('82', '1', '338', '交通银行', 'http://www.bankcomm.com', '', '', '', '交通银行（全称：交通银行股份有限公司）始建于1908年，是中国近代以来延续历史最悠久、最古老的银行，也是近代中国的发钞行之一。现为中国五大国有银行之一。\r\n交通银行是中国境内主要综合金融服务提供商之一，并正在成为一家以商业银行为主体，跨市场、国际化的大型银行集团，业务范围涵盖商业银行、投资银行、证券、信托、金融租赁、基金管理、保险、离岸金融服务等诸多领域。\r\n1987年重新组建成全国第一家股份制商业银行，分别于2005年、2007年先后在香港、上海上市，是第一家在境外上市的国有控股大型商业银行。中华人民共和国财政部、香港上海汇丰银行有限公司、社保基金理事会是交通银行前三大股东，共持有交通银行59.44%的股份。交通银行旗下全资子公司包括交银国信、交银保险和交银金融租赁，控股子公司包括交银村镇银行。此外，交通银行还是江苏常熟农村商业银行的第一大股东，西藏银行的并列第一大股东。', '0', '0', '3', '1453448991', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('83', '1', '338', '中国银行', 'http://www.boc.cn', '', '', '', '中国银行官网', '0', '0', '3', '1453449085', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('84', '1', '338', '农业银行', 'http://www.abchina.com', '', '', '', '农业银行官网', '0', '0', '3', '1453449141', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('93', '1', '362', '新浪手机', 'http://mobile.sina.com.cn', '手机,iphone6,android,iphone5s,苹果手机,安卓手机,手机评测,手机导购,智能手机,三星手机,小米手机,华为手机', '', '', '新浪科技手机频道提供专业的手机评测,手机参数,手机行情,手机新品报道,手机图片,手机游戏,手机软件与应用,手机主题,手机论坛等内容,为您选购手机提供全方位的服务。', '0', '0', '3', '1454642459', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('86', '1', '350', '腾讯汽车', 'http://auto.qq.com', '腾讯汽车,汽车网,汽车图片,汽车,评测,资讯,社区,腾讯网', '', '', '腾讯汽车，为您提供最新最快的车市行情，最全面的购车指导及车型信息，旨在成为中国最具影响力、规模最大、内容最全的汽车专业网站，是网民获取汽车资讯的最佳选择。', '0', '0', '3', '1453537474', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('87', '1', '351', '二手车之家', 'http://www.che168.com', '二手车,二手车交易市场,二手车网上交易平台', '', '', '二手车之家是中国访问量最大,二手车源信息最真实,最值得信赖的网上二手车交易市场,提供二手车评估,二手车报价,二手车资讯等相关服务,买卖二手车就上二手车之家', '0', '0', '3', '1453537552', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('88', '1', '349', '爱卡汽车', 'http://www.xcar.com.cn', '汽车,爱卡汽车网,汽车网,汽车报价,汽车图片,汽车社区,车友会,汽车论坛,汽车俱乐部,xcar', '', '', '爱卡汽车网为您提供最新汽车报价、汽车图片、车型资料、汽车论坛、汽车资讯信息,XCAR-爱卡汽车网是全球最大的汽车主题社区,其中包括85个主流品牌车型俱乐部,国内32个省市和地区分会,36个特色讨论区', '0', '0', '3', '1453537672', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('89', '1', '349', '太平洋汽车网', 'http://www.pcauto.com.cn', '汽车,太平洋汽车网,汽车报价,汽车评测,汽车论坛', '', '', '太平洋汽车网下设汽车报价,汽车评测,以及新闻、导购、维修、保养、安全、汽车论坛、自驾游、汽车休闲、汽车文化等方面的内容,为中国汽车排名第一的综合汽车网站,提供最权威,最全面的车型数据、参数、配置、报价、相关新闻和图片等', '0', '0', '3', '1453537726', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('90', '1', '362', '中关村手机', 'http://mobile.zol.com.cn', '手机,手机报价,手机大全,手机品牌,手机评测,手机资讯,手机行情', '', '', '中关村在线手机频道是权威的手机资讯中心,提供专业及时的手机报价,手机评测,手机行情,为您选购手机提供全方位的服务.并提供手机游戏,手机主题,手机壁纸下载,是网友交流的理想平台', '0', '0', '2', '1524650758', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('92', '1', '212', '中国新闻网', 'http://www.chinanews.com', '新闻,时事,时政,国际,国内,社会,法治,聚焦,评论,文化,教育,新视点,深度,网评,专题,环球,传播,论坛,图片,军事,焦点,排行,环保,校园,法治,奇闻,真情', '', '', '中国新闻网是知名的中文新闻门户网站，也是全球互联网中文新闻资讯最重要的原创内容供应商之一。依托中新社遍布全球的采编网络,每天24小时面向广大网民和网络媒体，快速、准确地提供文字、图片、视频等多样化的资讯服务。在新闻报道方面，中新网动态新闻及时准确，解释性报道角度独特，稿件被国内外网络媒体大量转载。', '0', '0', '3', '1453774790', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('94', '1', '297', '聚欢喜商城', 'http://www.ju123456.com', '聚欢喜,聚欢喜官网,聚欢喜商城,9.9包邮,品牌特卖,天天特价,优品精选', '', '', '聚欢喜—每天9.9包邮,品牌特卖,天天特价,优品精选,天天更新,件件都超值', '0', '0', '3', '1455683533', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('95', '1', '357', '智能电视网', 'http://www.znds.com', 'znds,智能电视网,智能电视论坛,智能电视', '/uploads/website/www.znds.com.jpg', '', 'ZNDS智能电视网是中国最大的智能电视论坛,关注智能电视,智能电视盒,安卓电视,安卓TV,安卓机顶盒论坛,智能电视软件下载,Android智能电视机,智能电视游戏。安卓智能电视TV应用市场,TV OS Rom,刷机教程,安卓TV软件下载,Android电视软件商店,智能电视APP应用分享和交流。', '0', '0', '3', '1456472795', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('96', '1', '357', '奇珀网', 'http://www.7po.com', '智能电视,智能电视论坛,智能电视盒,智能机顶盒,网络机顶盒,高清机顶盒,安卓tv,小米盒子,盒子越狱,芒果tv,天猫魔盒,机顶盒应用', '', '', '奇珀网是国内创立最早目前最大的智能电视,网络机顶盒用户社区,广大智能电视,安卓智能机顶盒用户进行资源下载和交流的乐园,旗下奇珀市场是专业智能电视应用与游戏下载平台,小米盒子,乐视盒子,芒果TV,天猫魔盒,泰捷视频等官方合作伙伴.', '0', '0', '3', '1456472937', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('97', '1', '376', '360良医', 'http://www.liangyi.com', '360良医,良医', '', '', '360良医，安全、干净、专业的医疗健康搜索引擎。拒绝虚假广告，整合各大权威医疗网站资源，提供专业、安全的医疗信息。包含医院，挂号，专家，药品，疾病，育儿，保健，养生，心理等内容。', '0', '0', '3', '1456473368', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('98', '1', '357', '电视之家', 'http://www.tvhome.com', '电视之家,电视盒子,智能电视,网络机顶盒,优酷路由宝,天猫魔盒,小米电视2s,小米电视3,小米电视3s,小米电视,pptv电视评测,小米专区,电视游戏下载,电视助手', '', '', '“电视之家”提供智能电视、电视盒子最全面、最新的资讯服务，将目前市场上最具热点与话题性的智能电视、电视盒子等相关信息囊括其中，并汇聚新闻、评测、教学、攻略、专访、排行榜等资讯内容，来满足大家对行业动态和产品信息知识获取的需求。', '0', '0', '3', '1456748806', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('99', '1', '357', '欢视网', 'http://www.tvhuan.com', '欢视网,智能电视,云电视,智能电视网,智能云电视,智能电视评测,智能电视论坛,智能电视软件', '', '', '中国第一智能电视论坛,最大智能电视软件应用商店下载,最新最快的智能电视行业资讯和最全面深入的原创评测内容,尽在-欢视网,为智能电视/网络机顶盒用户、开发者及生产厂商提供实时的交流平台.', '0', '0', '3', '1456748939', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('100', '1', '357', '电视家', 'http://www.tvapk.net', '电视家,智能电视,网络机顶盒,智能电视软件,智能电视论坛', '', '', '电视家，是提供网络机顶盒和智能电视软件下载，发布行业新闻，电视、盒子评测的智能电视论坛，最丰富的电视直播软件应用，电视盒子评测，安卓电视软件和应用。电视直播软件哪个好，智能电视哪个牌子好，网络机顶盒怎么用……等各类问题，电视家帮你解决。', '0', '0', '3', '1456749360', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('101', '1', '376', '网易健康', 'http://jiankang.163.com', '健康,网易健康,养生,保健,男性,女性,两性,心理健康,健康减肥,亚健康,健康饮食,疾病,中医,水果,蔬菜,药膳,中医养生,减肥食谱,瘦身瑜伽, 瘦身操,减肥方法,减肥茶,减肥药,瘦身霜,减肥精油 ,', '', '', '网易健康，专注于为20-45岁白领提供服务。减肥、两性、健身、营养、保健、养生、美食、用药，白领健康的一切，就是我们关心的一切。', '0', '0', '3', '1457485874', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('102', '1', '377', '寻医问药', 'http://www.xywy.com', '', '', '', '寻医问药闻康网，是提供医生，患者，相互交流的平台，也是中国唯一为寻医患者搭建在线咨询的医疗网站，更是目前国内人气最旺、规模最大、最权威的寻医问药网站', '0', '0', '3', '1457486163', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('103', '1', '378', '健康频道', 'http://health.sohu.com', '搜狐健康', '', '', '搜狐健康', '0', '0', '3', '1457486220', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('104', '1', '376', '99健康网', 'http://www.99.com.cn', '99健康网,健康网,健康门户网站', '', '', '99健康网是一家专业提供健康资讯的综合性健康网，是最适合中国人的健康门户网站。99健康网站旗下设有医院库、药品库、男科、妇科、中医、老人、育儿、体检、图库、美容、整形、减肥、健身、心理、饮食、保健、疾病等频道。是医疗保健类网站杰出代表，欢迎广大网友加入我们的99健康论坛一起交流健康养生之道。', '0', '0', '3', '1457486472', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('105', '1', '362', '手机中国', 'http://www.cnmo.cohm', '手机中国,手机,手机报价,手机大全,手机行情,手机资讯', '', '', '手机中国是一个实现了专业、时尚、品位并重的新兴手机媒体。相对于传统手机媒体不同之处在于，手机中国不仅提供指导消费、倡导应用，同时还在引领着手机的时尚与品位。在专业端，手机中国提供售前指导，包括价格、选购、评测试用、新品消息等，同时还在时尚与品味端，提供全方位的服务。', '0', '0', '3', '1457486759', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('106', '1', '514', '山东智信环保有限公司', 'http://www.wscljx.com', '活性炭投加,高锰酸钾投加系统,石灰投加系统,pam制备装置,pac制备投加系统', '', '', '山东智信环保有限公司专业生产销售活性炭投加,高锰酸钾投加系统,石灰投加系统,pam制备装置,pac制备投加系统等计量加药投加系统，深得广大用户的信赖和支持，成为国内的知名企业。', '0', '0', '3', '1458096907', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('107', '1', '141', '爱云音乐网', 'http://mp3.aiyunpay.com', '爱云音乐网', '', '', '爱云音乐网', '0', '0', '1', '1459171776', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('108', '1', '297', '爱云商城', 'http://shop.aiyunpay.co/m', '', '', '', '爱云商城', '0', '0', '1', '1459171874', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('109', '1', '400', '太平洋时尚网', 'http://www.pclady.com.cn', '时尚,女性,女性网,太平洋女性网,太平洋时尚女性网,pclady', '', '', '风采.迷人.做自己-Be Pretty.Be Charming.Be myself-太平洋女性网，Pclady.com.cn是集实用性，互动性，鉴赏性为一体的专业女性资讯平台；着力打造时尚、智慧、自信、独立、健康的新时代女性。Pclady下设美容、服饰、健康、居家、情感、品味、搜店、打折优惠、品牌库及女性论坛等频道，使网友可以获取最新、最快、最全面的时尚潮流讯息和消费导向', '0', '0', '3', '1460877191', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('110', '1', '400', '蘑菇街', 'http://www.mogujie.com', '蘑菇街,蘑菇街首页,蘑菇街官网,女装,淘宝网蘑菇街,网购,买手,时尚,mogujie,购物', '', '', '蘑菇街，我的买手街！蘑菇街是最大的女性电商社交平台，一亿多爱美的妹纸在这里找到自己喜爱的商品，数千时尚买手达人在这里交流购物心得，分享自己的消费体验。', '1', '1', '3', '1460878343', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('111', '1', '400', '爱美女性网', 'http://www.lady8844.com', '女性时尚,美容护肤,瘦身减肥,化妆彩妆,发型美发,香水香薰,时尚品牌', '', '', '爱美女性网(www.lady8844.com)女性时尚美容资讯,提供专业美容美体,护肤修身资讯.爱美女性网设有时装,护肤,彩妆,美发,瘦身,香水栏目.提供美丽护肤,时尚彩妆,瘦身纤体,流行发型,经典香水等潮流爱美资讯,为各位爱美人士提供一个交流美容美体心得的爱美论坛,女性时尚,美容护肤,瘦身减肥,化妆彩妆,发型美发,香水香薰,时尚品牌。', '0', '0', '3', '1460878822', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('112', '1', '170', '言情小说吧', 'http://www.xs8.cn', '小说,小说阅读网,言情小说,免费小说,言情小说免费阅读,穿越小说,校园小说,言情小说吧,言情,言情小说网,都市小说,都市言情小说,校园言情小说,xs8', '', '', '最好看的免费言情小说阅读网，24小时首发穿越小说、校园言情小说、都市言情小说在线阅读，所有的言情小说都提供txt免费下载！－－看言情小说就上言情小说吧！', '0', '0', '3', '1461128021', '0', '0', '', '0');
INSERT INTO `yk365_website` VALUES ('125', '1', '269', '百度', 'http://www.baidu.com', '', '/uploads/website/www.baidu.com.jpg', '', '百度搜索', '1', '1', '3', '1483591952', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('126', '1', '269', '360搜索', 'http://www.so.com', '', '', '', '360搜索', '1', '1', '3', '1483592000', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('127', '1', '269', '谷歌', 'http://www.google.com', '', '', '', '谷歌', '1', '0', '3', '1483592106', '1', '0', '', '0');
INSERT INTO `yk365_website` VALUES ('118', '1', '411', '赶集', 'http://www.ganji.com', '', '', '', '赶集网是更专业的分类信息网!提供免费发布信息,查阅信息服务.寻找最新最全的房屋出租、二手房、二手车、二手物品交易、求职招聘等生活信息,请到赶集网ganji.com！', '1', '1', '3', '1473522067', '1', '0', '', '0');
INSERT INTO `yk365_website` VALUES ('119', '1', '411', '腾讯博客首页_腾讯网', 'http://blog.qq.com', '明星风采与精英思想的展示台,大众信息与新锐观点的集散地', '', '', '博客,BLOG,QQ,腾讯博客,QQ博客,QQ空间,Qzone,Bloger,博客频道,名人博客,精英博客,草根博客,网络日志,文化博客,思想博客,企业博客,商务博客,特色博客,图片博客,播客', '0', '0', '3', '1473522341', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('120', '1', '213', '腾讯', 'http://www.qq.com', '', '', '', '资讯,新闻,财经,房产,视频,NBA,科技,腾讯网,腾讯,QQ,Tencent\\\" \r\n是中国浏览量最大的中文门户网站，是腾讯公司推出的集新闻信息、互动社区、娱乐产品和基础服务为一体的大型综合门户网站。腾讯网服务于全球华人用户，致力成为最具传播力和互动性，权威、主流、时尚的互联网媒体平台。通过强大的实时新闻和全面深入的信息资讯服务，为中国数以亿计的互联网用户提供富有创意的网上新生活。', '1', '1', '3', '1473523671', '0', '0', null, '0');
INSERT INTO `yk365_website` VALUES ('123', '1', '527', '源码', 'http://www.kuaiphp.com', '网站源码,源码网,网站源码下载,源码下载,源码之家,站长下载,asp源码,php源码,net源码,js特效', '', '', '酷爱站长下载提供最新最全免费网站源码下载(asp源码,php源码,.net源码),源码动态,为站长推介有价值的源码,为开发者宣传源码作品。', '0', '0', '3', '1482715510', '0', '0', '', '0');
INSERT INTO `yk365_website` VALUES ('124', '1', '211', '심쿵박스', 'http://www.simkungbox.com', '朝鲜族论坛,朝鲜族美食,招聘信息,房地产信息,便民服务,二手物品,延边足球论坛,韩剧,韩国电视剧,韩国综艺,韩国电影,最新韩剧,好看的韩剧,经典韩剧,韩剧排行,simkungbox,simkung', '', '', 'simkungbox是朝鲜族论坛每天更新有趣的信息。招聘，求职,房地产,美食,便民服务,二手物品,微商信息,韩剧,韩国电视剧,韩国综艺,韩国电影,最新韩剧,好看的韩剧,经典韩剧,韩剧排行。并且有关延边足球的最新消息和现场图片！', '0', '0', '3', '1483502168', '0', '0', '', '0');
INSERT INTO `yk365_website` VALUES ('132', '1', '148', '西部数码', 'https://www.west.cn/', '云主机,云服务器,虚拟主机,西部数码,域名注册,主机租用,服务器租用,网站空间', '', '', '西部数码是基于云计算领先的互联网服务提供商,15年专业知名品牌。专业提供云服务器、虚拟主机、域名注册、VPS主机、云服务器等，50余万个虚拟主机网站及1000余万个域名用户的共同选择！', '0', '0', '3', '1524453758', '0', '0', '', '0');
INSERT INTO `yk365_website` VALUES ('131', '1', '148', '360官网', 'https://www.360.cn/', '', '', '', '2121', '0', '0', '3', '1522565470', '0', '0', '', '0');
INSERT INTO `yk365_website` VALUES ('136', '1', '142', 'CSDN博客', 'https://blog.csdn.net/mayuko2012/article/details/5474406822', '', '', '', '111', '0', '0', '3', '1524542880', '0', '0', '', '0');


-- ----------------------------
-- Table structure for yk365_lives
-- ----------------------------
DROP TABLE IF EXISTS `yk365_lives`;
CREATE TABLE `yk365_lives` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cate_id` int(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(100) DEFAULT NULL,
  `video_url` varchar(200) DEFAULT NULL,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `isbest` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `ctime` int(10) unsigned NOT NULL DEFAULT '0',
  `utime` int(10) unsigned NOT NULL DEFAULT '0',
  `ishot` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='电视直播表';

-- ----------------------------
-- Records of yk365_lives
-- ----------------------------
INSERT INTO `yk365_lives` VALUES ('1', '1', '562', '香港卫视', 'http://www.flashls.org/playlists/test_001/stream.m3u8', '0', '0', '0', '1537628031', '0', '0');
