<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$page=$_GET["page"];
switch($page){

case "0.1":
$url="1.1下载程序.html";
break;
case "0.2":
$url="1.2上传空间-服务器.html";
break;
case "0.3":
$url="1.3安装完成.html";
break;
case "1.1.1":
$url="2.1.1支付宝.html";
break;
case "1.1.2":
$url="2.1.2微信支付.html";
break;
case "1.1.3":
$url="2.1.37支付.html";
break;
case "1.2.1":
$url="2.2.1QQ快捷登录.html";
break;
case "1.2.2":
$url="2.2.2微信快捷登录.html";
break;
case "1.3.1":
$url="2.3.1统计代码.html";
break;
case "1.3.2":
$url="2.3.2分享代码.html";
break;
case "1.3.3":
$url="2.3.3公众号接入.html";
break;
case "1.3.4":
$url="1.3.4评论接口.html";
break;
case "1.3.5":
$url="1.3.5邮件接口.html";
break;
case "1.3.6":
$url="1.3.6云储存接口.html";
break;
case "1.3.7":
$url="1.3.7客服云接口.html";
break;
case "2.1":
$url="3.1基本设置.html";
break;
case "2.2":
$url="3.2自定义设置.html";
break;
case "2.3":
$url="3.3焦点图管理.html";
break;
case "2.4":
$url="3.4友情链接.html";
break;
case "3.1":
$url="4.1简介管理.html";
break;
case "3.2":
$url="4.2新闻管理.html";
break;
case "3.2.1":
$url="4.2.1文章采集.html";
break;
case "3.2.2":
$url="4.2.2视频无法播放.html";
break;
case "3.3":
$url="4.3产品-案例管理.html";
break;
case "3.3.1":
$url="4.3.1订单管理.html";
break;
case "3.4":
$url="4.4表单管理.html";
break;
case "3.4.1":
$url="4.4.1表单统计.html";
break;
case "3.4.2":
$url="4.4.2防伪查询.html";
break;
case "3.5":
$url="4.5论坛管理.html";
break;
case "4.1":
$url="5.1切换模板.html";
break;
case "4.2":
$url="5.2编辑模板.html";
break;
case "4.3":
$url="5.3生成静态.html";
break;
case "4.4":
$url="5.4生成小程序.html";
break;
case "4.5":
$url="5.5生成APP.html";
break;
case "5.1":
$url="6.1联系方式.html";
break;
case "5.2":
$url="6.2留言管理.html";
break;
case "6.1":
$url="7.1基本设置.html";
break;
case "6.2":
$url="7.2自定义设置.html";
break;
case "6.3":
$url="7.3焦点图设置.html";
break;
case "7.1":
$url="8.1菜单管理.html";
break;
case "8.1":
$url="9.1管理员.html";
break;
case "8.2":
$url="9.2会员.html";
break;
case "9.1":
$url="10.1安全设置.html";
break;
case "9.2":
$url="10.2文件管理.html";
break;
case "9.3":
$url="10.3素材管理.html";
break;
case "9.4":
$url="10.4数据迁移.html";
break;
case "9.5":
$url="10.5sitemap.html";
break;
case "9.6":
$url="9.6找回密码.html";
break;
default:
$url="";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1" />
<link rel="shortcut icon" href="<?php echo $C_dir.$C_ico?>" type="image/x-icon" />
<link rel="Bookmark" href="<?php echo $C_dir.$C_ico?>" />
<title>用户使用手册</title>
<link href="css/jquery-accordion-menu.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<style type="text/css">
body{margin:0px; overflow:hidden }
</style>
<script language="JavaScript">
function show()
{
document.getElementById("iframeid").style.height=(document.documentElement.clientHeight)+"px";
}
window.onresize = function(){
document.getElementById("iframeid").style.height=(document.documentElement.clientHeight)+"px";
}
</script>
</head>
<body>
<iframe src="http://help.s-cms.cn/<?php echo $url?>" width="100%" frameBorder="0" id="iframeid" onLoad="show()"></iframe>
</body>
</html>