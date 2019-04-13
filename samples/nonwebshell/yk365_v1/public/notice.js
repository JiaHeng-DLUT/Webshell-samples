$(function(){
	//版本更新提示
	$(".updata").html("<a href='http://bbs.youke365.com/forum.php?mod=forumdisplay&fid=2'  target='main' style='color:red'>Youke365-v1.2 </a>");
   // 官方公告
   // 
   var  text1= "1.官方发布最新版网站分类目录，请各位站长下载  <a href='www.baidu.com'>下载地址</a><br>";
   var  text2 ="2.官方最新补丁即将发布<br>";
   var  text3 ="3.使用官方主机，稳利于seo";

    $(".notice").html(text1+text2+text3).css({"width":"100%","height":"auto","border":"1px solid #62A1E2","padding":"10px","color":"red"});
});