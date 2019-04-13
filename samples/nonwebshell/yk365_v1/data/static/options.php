<?php
//File name: options.php
//Creation time: 2019-02-28 14:43:02

if (!defined('IN_YOUKE365')) exit('Access Denied');

$static_data = array(
	'site_name' => '优客365 开源网址导航系统',
	'site_title' => '优客365开源版',
	'site_url' => 'http://www.youke365.site/',
	'site_root' => '/',
	'admin_email' => 'youke365@qq.com',
	'site_keywords' => '分类目录,网站收录,网站提交,网站目录,网站推广,网站登录',
	'site_description' => '全人工编辑的开放式网站分类目录，收录国内外、各行业优秀网站，旨在为用户提供网站分类目录检索、优秀网站参考、网站推广服务。',
	'site_copyright' => 'Copyright © 2017 <a href=\"http://www.youke365.site \">优客365官方</a>',
	'regname_small' => '2',
	'regname_large' => '15',
	'regname_forbid' => 'admin
管理员
admin888
',
	'home_instat' => '20',
	'home_outstat' => '20',
	'home_isbest' => '50',
	'home_new' => '13',
	'is_enabled_gzip' => 'yes',
	'is_enabled_submit' => 'yes',
	'submit_close_reason' => '站点提交已经关闭！',
	'data_update_cycle' => '1',
	'is_enabled_register' => 'yes',
	'register_email_verify' => 'no',
	'is_enabled_rewrite' => 'no',
	'rewrite_suffix' => '.html',
	'smtp_host' => 'mail.qijike.com.cn',
	'smtp_port' => '25',
	'smtp_auth' => 'yes',
	'smtp_user' => 'test@qijike.com.cn',
	'smtp_pass' => 'q123456',
	'filter_words' => 'sb
共产党
发票',
	'is_enabled_connect' => 'yes',
	'qq_appid' => '',
	'qq_appkey' => '',
	'link_struct' => '0',
	'search_words' => '百度，360',
	'upload_dir' => 'uploads',
	'ad_text' => '宅男边撩妹边赚外快|http://g.360.cn/game/sanqi
宅男边撩妹边赚外快|http://g.360.cn/game/sanqi
宅男边撩妹边赚外快|http://g.360.cn/game/sanqi
宅男边撩妹边赚外快|http://g.360.cn/game/sanqi
宅男边撩妹边赚外快|http://g.360.cn/game/sanqi
宅男边撩妹边赚外快|http://g.360.cn/game/sanqi
',
	'hot_words' => '嫌整容没效果裸体坐医院
西披露危害国家安全案
北京楼市调控再出重拳
西披露危害国家安全案
北京楼市调控再出重拳
西披露危害国家安全案
北京楼市调控再出重拳',
	'site_logo' => '/public/images/logo.png',
	'is_enabled_comment' => '1',
	'changyan_appid' => 'cyscE6A60',
	'changyan_conf' => '',
	'qcode_alipay' => '/uploads/images/w.png',
	'is_enabled_reward' => 'yes',
	'qcode_weixin' => '/uploads/images/bbs.png',
	'site_code' => '<script type=\"text/javascript\">var cnzz_protocol = ((\"https:\" == document.location.protocol) ? \" https://\" : \" http://\");document.write(unescape(\"%3Cspan id=\'cnzz_stat_icon_1257188920\'%3E%3C/span%3E%3Cscript src=\'\" + cnzz_protocol + \"s4.cnzz.com/stat.php%3Fid%3D1257188920%26show%3Dpic\' type=\'text/javascript\'%3E%3C/script%3E\"));</script>',
	'nav_code' => '<ul class=\"newsbox-list\">
<li><i class=\"fa fa-plane fa-lg fablue\" aria-hidden=\"true\"></i><a href=\"http://www.ctrip.com\" target=\"_blank\">机票</a> | <a href=\"http://www.12306.cn\" target=\"_blank\">火车票</a></li>

<li><i class=\"fa fa-film fablue\" aria-hidden=\"true\"></i> <a href=\"http://movie.youku.com/\" target=\"_blank\">电影</a> | <a href=\"http://movie.youku.com/\" target=\"_blank\">电视剧</a></li>

<li><i class=\"fa fa-gamepad fa-lg fablue\" aria-hidden=\"true\"></i><a href=\"http://www.37.com\"  target=\"_blank\">游戏</a> | <a href=\"http://www.4399.com/\"  target=\"_blank\">小游戏</a></li>          

<li><i class=\"fa fa-heart fablue\" aria-hidden=\"true\"></i><a href=\"http://www.acfun.cn/\" target=\"_blank\">动漫</a> | <a href=\"https://www.douyu.com/\" target=\"_blank\">直播</a></li>

<li><i class=\"fa fa-newspaper-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"http://www.toutiao.com/\" target=\"_blank\">新闻</a> | <a href=\"http://www.iqiyi.com/\" target=\"_blank\">视频</a></li>

<li> <i class=\"fa fa-shopping-cart fa-lg fa-fw fablue\" aria-hidden=\"true\"></i>
<a href=\"https://www.taobao.com/\" target=\"_blank\">购物</a> | <a href=\"http://www.zhe800.com\" target=\"_blank\">9块9</a></li>       

<li><i class=\"fa fa-money fa-lg fa-fw fablue\" aria-hidden=\"true\"></i> <a href=\"\" target=\"_blank\">理财</a> | <a href=\"http://www.500.com/\" target=\"_blank\">彩票</a></li>       

<li><i class=\"fa fa-jpy fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">活期</a> | <a href=\"\" target=\"_blank\">借条</a></li>       

<li><i class=\"fa fa-star-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i> <a href=\"\" target=\"_blank\">娱乐</a> | <a href=\"\" target=\"_blank\">商城</a></li>               

<li><i class=\"fa fa-smile-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">搞笑</a> | <a href=\"\" target=\"_blank\">解梦</a></li>       

<li><i class=\"fa fa-map-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">教育</a> | <a href=\"\" target=\"_blank\">度假</a></li>       

<li><i class=\"fa fa-search fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">查询</a> | <a href=\"\" target=\"_blank\">星座</a></li>        

<li><i class=\"fa fa-mobile fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">手机</a> | <a href=\"\" target=\"_blank\">小说</a></li>

<li><i class=\"fa fa-bookmark-o fa-lg fa-fw fablue\" aria-hidden=\"true\"></i><a href=\"\" target=\"_blank\">综艺</a> | <a href=\"\"  target=\"_blank\">旅游</a></li>

</ul>',
	'is_enabled_tj' => 'yes',
	'home_best' => '18',
	'is_enabled_submit_collect' => 'yes',
	'home_pay' => '18',
	'site_kefu' => '888888
',
	'qcode_name' => '优客365官方QQ群',
	'qcode_img' => '/public/images/youke.png',
	'nav_slide' => '<div class=\"app app-imageswitch\">
             <a href=\"http://ent.ifeng.com/\" target=\"_blank\" class=\"icon\">
                 <img src=\"/public/images/u=2133.png\" class=\"img-icon\" alt=\"\">娱乐
             </a>

          </div>

<div class=\"app app-imageswitch\">
             <a href=\"https://www.douyu.com/\" target=\"_blank\" class=\"icon\">
                  <img src=\"/public/images/u=2155.png\" class=\"img-icon\" alt=\"\">斗鱼
             </a>
          </div>
<div class=\"app app-imageswitch\">
         <a href=\"http://www.youku.com/\" target=\"_blank\" class=\"icon\">
             <img src=\"/public/images/u=2166.png\" class=\"img-icon\" alt=\"\">视频
         </a> 

     </div>
',
	'home_nav' => '<li><a href=\"/home/article.html\"><i class=\"fa fa-file\" aria-hidden=\"true\"></i> 新闻资讯</a></li>
<li><a href=\"/home/weblink.html\"><i class=\"fa fa-link\" aria-hidden=\"true\"></i> 换链大厅</a></li>
<li><a href=\"/home/webdir.html\"><i class=\"fa fa-sitemap\" aria-hidden=\"true\"></i> 分类目录</a></li>
<li><a href=\"/home/update.html\"><i class=\"fa fa-hourglass-start\" aria-hidden=\"true\"></i> 最新收录</a></li><li><a href=\"/home/top.html\"><i class=\"fa fa-trophy\" aria-hidden=\"true\"></i> 网站排行榜</a></li>',
	'home_pay_money' => '20',
	'default_skin' => 'default',
	'is_mobile_status' => 'yes',
	'default_theme' => 'default',
	'default_mobile_theme' => 'default',
	'is_article_status' => 'yes',
	'is_video_status' => 'yes',
	'is_game_status' => 'yes',
	'is_link_status' => 'yes',
);
?>