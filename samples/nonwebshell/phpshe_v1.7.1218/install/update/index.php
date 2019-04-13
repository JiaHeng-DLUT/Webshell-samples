<?php
include('../../common.php');
print<<<html
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PHPSHE商城系统升级程序</title>
<link type="text/css" rel="stylesheet" href="{$pe['host_root']}template/default/index/css/style.css" />
<script type="text/javascript" src="{$pe['host_root']}include/js/jquery.js"></script>
<script type="text/javascript" src="{$pe['host_root']}include/js/global.js"></script>
<style type="text/css">
body{background:#f4f4f4; font-family:"宋体"}
h1{height:50px;line-height:50px; margin-top:10px; font-family:'微软雅黑'; color:#555;}
.main{margin:10px auto; width:980px;font-size:14px;line-height:24px;}
.list{background:#fff; margin-bottom:20px; padding:10px 20px; border:1px solid #eee; color:#666;}
.list .tt{border-bottom:1px solid #f1f1f1; margin-bottom:10px; padding-bottom:8px}
fieldset{padding:8px 18px; border:1px solid #eee; border-radius:0 0 8px 8px}
</style>
</head>
<body>
<h1 class="center font20">PHPSHE商城系统升级程序</h1>
<div class="main font14">
	<div class="list">
	<div class="tt strong">【1.6 升级至 1.7】教程说明</div>
	<p>1> 请务必先备份整站程序和数据库到本地，防止升级失败造成数据丢失；(数据库备份可参考：<a class="cblue" href="http://jingyan.baidu.com/article/27fa7326da2bbc46f9271f6e.html" target="_blank">phpmyadmin备份mysql数据库</a>)</p>
	<p class="mat5">2> 删除网站根目录中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">3> 上传PHPSHE1.7程序中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">3> 上传PHPSHE1.7程序 <span class="cred">data文件夹中的lock文件夹</span> 和 <span class="cred">data/attachment文件夹中的prokey_import文件夹和prokey_import.xls文件</span>；</p>
	<p class="mat5">4> <a href="{$pe['host_root']}install/update/update1.6_1.7.php" target="_blank" class="cblue" onclick="return pe_cfone(this, '升级数据库')">[点击升级数据库1.6->1.7]</a>，数据库升级完成后删除 <span class="cred">install</span> 文件夹。</p>
</div>	
<div class="main font14">
	<div class="list">
	<div class="tt strong">【1.5 升级至 1.6】教程说明</div>
	<p>1> 请务必先备份整站程序和数据库到本地，防止升级失败造成数据丢失；(数据库备份可参考：<a class="cblue" href="http://jingyan.baidu.com/article/27fa7326da2bbc46f9271f6e.html" target="_blank">phpmyadmin备份mysql数据库</a>)</p>
	<p class="mat5">2> 删除网站根目录中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">3> 上传PHPSHE1.6程序中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">4> <a href="{$pe['host_root']}install/update/update1.5_1.6.php" target="_blank" class="cblue" onclick="return pe_cfone(this, '升级数据库')">[点击升级数据库1.5->1.6]</a>，数据库升级完成后删除 <span class="cred">install</span> 文件夹。</p>
</div>
<div class="list">
	<div class="tt strong">【1.4 升级至 1.5】教程说明</div>
	<p>1> 请务必先备份整站程序和数据库到本地，防止升级失败造成数据丢失；(数据库备份可参考：<a class="cblue" href="http://jingyan.baidu.com/article/27fa7326da2bbc46f9271f6e.html" target="_blank">phpmyadmin备份mysql数据库</a>)</p>
	<p class="mat5">2> 删除网站根目录中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">3> 上传PHPSHE1.5程序中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">4> <a href="{$pe['host_root']}install/update/update1.4_1.5.php" target="_blank" class="cblue" onclick="return pe_cfone(this, '升级数据库')">[点击升级数据库1.4->1.5]</a>，数据库升级完成后删除 <span class="cred">install</span> 文件夹。</p>
</div>
<div class="list">
	<div class="tt strong">【1.3 升级至 1.4】教程说明</div>
	<p>1> 请务必先备份整站程序和数据库到本地，防止升级失败造成数据丢失；(数据库备份可参考：<a class="cblue" href="http://jingyan.baidu.com/article/27fa7326da2bbc46f9271f6e.html" target="_blank">phpmyadmin备份mysql数据库</a>)</p>
	<p class="mat5">2> 删除网站根目录中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">3> 上传PHPSHE1.4程序中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">4> <a href="{$pe['host_root']}install/update/update1.3_1.4.php" target="_blank" class="cblue" onclick="return pe_cfone(this, '升级数据库')">[点击升级数据库1.3->1.4]</a>，数据库升级完成后删除 <span class="cred">install</span> 文件夹。</p>
</div>
<div class="list">
	<div class="tt strong">【1.2 升级至 1.3】教程说明</div>
	<p>1> 请务必先备份整站程序和数据库到本地，防止升级失败造成数据丢失；(数据库备份可参考：<a class="cblue" href="http://jingyan.baidu.com/article/27fa7326da2bbc46f9271f6e.html" target="_blank">phpmyadmin备份mysql数据库</a>)</p>
	<p class="mat5">2> 删除网站根目录中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">3> 上传PHPSHE1.3程序中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">4> <a href="{$pe['host_root']}install/update/update1.2_1.3.php" target="_blank" class="cblue" onclick="return pe_cfone(this, '升级数据库')">[点击升级数据库1.2->1.3]</a>，数据库升级完成后删除 <span class="cred">install</span> 文件夹。</p>
</div>
<div class="list">
	<div class="tt strong">【1.1 升级至 1.2】教程说明</div>
	<p>1> 请务必先备份整站程序和数据库到本地，防止升级失败造成数据丢失；(数据库备份可参考：<a class="cblue" href="http://jingyan.baidu.com/article/27fa7326da2bbc46f9271f6e.html" target="_blank">phpmyadmin备份mysql数据库</a>)</p>
	<p class="mat5">2> 删除网站根目录中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">3> 上传PHPSHE1.2程序中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">4> <a href="{$pe['host_root']}install/update/update1.1_1.2.php" target="_blank" class="cblue" onclick="return pe_cfone(this, '升级数据库')">[点击升级数据库1.1->1.2]</a>，数据库升级完成后删除 <span class="cred">install</span> 文件夹。</p>
</div>
<div class="list">
	<div class="tt strong">【1.0 升级至 1.1】教程说明</div>
	<p>1> 请务必先备份整站程序和数据库到本地，防止升级失败造成数据丢失；(数据库备份可参考：<a class="cblue" href="http://jingyan.baidu.com/article/27fa7326da2bbc46f9271f6e.html" target="_blank">phpmyadmin备份mysql数据库</a>)</p>
	<p class="mat5">2> 删除网站根目录中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">3> 上传PHPSHE1.1程序中除 <span class="cred">data文件夹</span> 和 <span class="cred">config.php文件</span> 之外的其他文件和文件夹；</p>
	<p class="mat5">4> <a href="{$pe['host_root']}install/update/update1.0_1.1.php" target="_blank" class="cblue" onclick="return pe_cfone(this, '升级数据库')">[点击升级数据库1.0->1.1]</a>，数据库升级完成后删除 <span class="cred">install</span> 文件夹。</p>
	<p class="mat5">由于PHPSHE1.1版本相比1.0有较多优化与完善，请在第4步完成后继续执行以下操作；</p>
	<p class="font12">(1)如果您之前新增加了文章分类，请检查这些分类是否已经归到商品分类中，如有请自行更正；</p>
	<p class="font12">(2)网站logo需要在后台【基本信息】中重新上传；</p>
	<p class="font12">(3)请到后台【支付方式】重新填写支付信息；</p>
	<p class="font12">(4)最后执行【更新缓存】操作；</p>
</div>
<div class="font12" style="text-align:center">Copyright <span class="num">©</span> 2008-2018 <a href="http://www.phpshe.com" target="_blank" title="灵宝简好网络科技有限公司">灵宝简好网络科技有限公司</a> 版权所有</div>
</div>
</body>
</html>
html;
pe_result();
?>