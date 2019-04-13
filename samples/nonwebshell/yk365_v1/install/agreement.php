<?php
require('config.php'); 
define('ROOT_PATH', str_replace("\\", '/', substr(__FILE__, 0, strrpos(dirname(__FILE__), DIRECTORY_SEPARATOR))).'/');
require('function.php');

//判断是否已经安装过
if (file_exists(ROOT_PATH.'data/install.lock')) {
	failure('你已经安装过本系统！<br />如果还继续安装，请先删除data/install.lock，再继续');
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>优客365分类管理系统 安装向导</title>
<link href="images/skin.css" rel="stylesheet" type="text/css" />
<link href="/public/layui/css/layui.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="main">
	<?php require('header.php'); ?>
	<div class="central">
    	<div id="left">
    		<ul>
				<li>
					<h1>1</h1>
					<div class="left_title">  
						<h2>环境检测</h2>
						<p>欢迎您使用优客365网站分类管理系统！</p>
					</div>
				</li>
				<li>
					<h1 class="install">2</h1>
					<div class="left_title">  
						<h2 class="install">阅读协议</h2>
						<p class="install">请认真阅读软件使用协议，以免您的利益受到损害！</p>
					</div>
				</li>
				<li>
					<h1>3</h1>
					<div class="left_title">  
						<h2>基本设置</h2>
						<p>请设置网站的基本信息进行网站安装！</p>
					</div>
				</li>
				<li>
					<h1>4</h1>
					<div class="left_title">  
						<h2>开始安装</h2>
						<p>开始愉快的网站安装之旅吧！</p>
					</div>
				</li>
			</ul>
		</div>
		<div class="right">
			<div class="right_title">软件使用协议</div>
			<div style="font-size: 14px; line-height: 25px; padding: 20px 0; text-align: left;">

<p>1. 优客365免费开源软件！可以在保留版权的情况下二次开发，不允许对程序以新版本方式在第三方平台重新发布。</p>

<p>2. 无论用途如何、是否经过修改或美化、修改程度如何，只要使用本软件的整体或任何部分，软件首页顶部及页脚处的版权标识（Powered by Youke365）和本公司下属网站（http://www.youke365.site） 的链接都必须保留，不能清除或修改。</p>

<p><strong>限制条款：</strong></p>

<p>1. 禁止在 优客365的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</p>


<p><strong>免责条款：</strong></p>

<p>1. 优客365及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式出售的。

<p>2. 用户同意自己承担使用本产品的风险，在适用法律允许的最大范围内，优客365在任何情况下不就因使用或不能使用本产品所发生的特殊的、意外的、非直接或间接的损失承担赔偿责任。即使用户已事先被优客365告知该损害发生的可能性。</p>

<p>3. 用户利用本产品构建的网站的任何信息内容以及导致的任何版权纠纷和法律争议及后果与优客365无关，优客365对此不承担任何责任。</p>

<p><strong>其他条款：</strong></p>

<p>用户一旦开始安装使用优客365，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束</p>


            </div>
			<div class="agree"  align="center">
				<form action="database.php">
         		<input type="submit" class="layui-btn layui-btn-normal" value="同意下一步！" hidefocus="true" />
            	</form>
            </div>
		</div>
	</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>