<?php
/**
 *
 *****************************************************************************************************
 *    如果您通过浏览器访问网站时看到了这个提示，那么我们很遗憾地通知您，您的空间不支持 PHP 。
 *    也就是说，您的空间可能是静态空间，或没有安装PHP，或没有为 Web 服务器打开 PHP 支持。
 *    Sorry, PHP is not installed on your web hosting if you see this prompt.
 *    Please check out the PHP configuration.
 *
 *    如您使用虚拟主机：
 *
 *        > 联系空间商，更换空间为支持 PHP 的空间。
 *        > Contact your service provider, and let them provice a new service which supports PHP.
 *
 *
 *    如您自行搭建服务器，推荐您：
 *    Configuring manually? Recommend:
 *
 *        > 访问 PHP 官方网站获取安装帮助。
 *        > Visit PHP Official Website to get the documentation of installion and configuration.
 *        > 如果您需要ASP版本，请前往 https://www.s-cms.cn/download.html?code=asp 进行下载
 *
 ******************************************************************************************************
 */

error_reporting(E_ALL ^ E_NOTICE); 
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");

$dirx=dirname($_SERVER["SCRIPT_FILENAME"])."/";

if(file_get_contents($dirx."data/first.txt")=="0"){
	Header("Location: index.php"); 
    die();
}

$C_dir=splitx($_SERVER["PHP_SELF"],"install.php",0);
$update=file_get_contents("http://cdn.shanling.top/php/update.txt");
$update=str_replace(PHP_EOL,"",$update);
$update=trim($update,"\xEF\xBB\xBF");

$version=trim(file_get_contents($dirx."admin/version.txt"),"\xEF\xBB\xBF");
$version2=splitx($update,"|",0);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>网站初始化设置</title>
<script src="member/js/jquery.min.js"> </script>
<link rel="stylesheet" href="member/css/bootstrap.css" type="text/css" />
<style>

body{ background:url(admin/images/login_bgx.gif); font-family:"微软雅黑"; font-size:12px;}
.div{position:absolute;left: 50%;top:100px;margin: 0 0px 100px -300px;padding:0 20px 20px 20px;overflow:hidden;width:600px; text-align:center;box-shadow:0px 0px 20px #999999; background:url(images/install_top.png) no-repeat;background-color:#FFFFFF;border-radius: 10px; }
.input1 {border-top:1px solid #ABADB3;border-left:1px solid #ABADB3;border-right:1px solid #ddd;border-bottom:1px solid #ddd;height:24px;width:300px;padding:0 5px;}
.input2 {border:1px solid #FFB334;outline:2px solid #ffdc97;*border:2px solid #FFB334;*padding:2px 5px;height:24px;width:300px;padding:0 5px;}
.submit{ width:131px;height:34px; border:hidden; font-family:"微软雅黑";color:#FFFFFF;background-image:url(images/btn.png);cursor:hand;font-size:15px; margin-top:10px;}
.submit2{ width:131px;height:34px; border:hidden; font-family:"微软雅黑";color:#FFFFFF;background-image:url(images/btn2.png);cursor:hand;font-size:15px;margin-top:10px;}
input[type="radio"]{display:none;}
label{border:#AAAAAA solid 2px;border-radius:3px;color:#AAAAAA;padding: 3px;margin: 0 5px;}
.checked{border:#0099ff solid 2px;border-radius:3px;color:#0099ff;padding: 3px;margin: 0 5px;}
</style>
</head>
<body>
<div id="ie"></div>
<script>
var ie = !+'\v1';
if(ie){
document.getElementById("ie").innerHTML="<div style='background:#FF9900; height:25px;padding:4px 10px 0 10px; color:#FFFFFF;text-align:center;'>您当前浏览器版本过低，请先升级！（请使用IE9或以上、谷歌浏览器、其他浏览器的急速模式）</div>";
}
</script>
<?php

if(is_dir($dirx.'template')==false || is_dir($dirx.'wap')==false || is_dir($dirx.'admin')==false){
	die("缺少配置文件，请检查template（电脑端模板）、wap（手机端模板）、admin（后台）文件夹是否存在！");
}

$handler = opendir($dirx.'template');
while( ($filename = readdir($handler)) !== false ) 
{
 if(is_dir($dirx."template/".$filename) && $filename != "." && $filename != "..")
 {  
   $t=$t.$filename."|";
  }
}

$handler = opendir($dirx.'wap');
while( ($filename = readdir($handler)) !== false ) 
{
 if(is_dir($dirx."wap/".$filename) && $filename != "." && $filename != "..")
 {  
   $w=$w.$filename."|";
  }
}

$C_installdir=splitx($_SERVER["PHP_SELF"],"install.php",0);
$action=URLEncode($_GET["action"]);
if ($action=="save" ){

$sitename2=$_POST["sitename2"];
$A_login2=$_POST["A_login2"];
$A_pwd2=md5($_POST["A_pwd2"]);
$admin_dir2=$_POST["admin_dir2"];
$web_dir2=$_POST["web_dir2"];
$_SESSION["set_login"]=$_POST["A_login2"];
$_SESSION["set_pwd"]=$_POST["A_pwd2"];
$dbserver=$_POST["dbserver"];
$dbname=$_POST["dbname"];
$dbusername=$_POST["dbusername"];
$dbpassword=$_POST["dbpassword"];
$authcode=$_POST["authcode"];

if($dbname==""){
	if($dbusername=="root"){
		$dbname="scms";
	}else{
		box("数据库名称未填写！","back","error");
	}
}

if ($_POST["A_login2"]==""){
	box("管理员账户未设置！","back","error");
}
if ($_POST["A_pwd2"]==""){
	box("管理员密码未设置！","back","error");
}

$connx = @mysqli_connect($dbserver,$dbusername,$dbpassword);

if (!$connx) {
    die("<p>抱歉，连接数据库失败！</p><p>您提供的数据库用户名和密码可能不正确，或者无法连接到您的数据库服务器，这意味着您的主机数据库服务器已停止工作。</p><p><ul><li>您确认您提供的用户名和密码正确么？</li><li>您确认您提供的主机名正确么？</li><li>您确认数据库服务器运行正常么？</li><li>您确认您购买的数据库是MYSQL而不是MSSQL么？</li></ul></p><p>请您联系您的空间商寻求帮助！</p><p>".mysqli_connect_error()."</p><div id='bottom'><input type=\"button\" name=\"next\" onClick=\"history.go(-1)\" id=\"netx\" value=\"返回\" /></div>");
}else{
	$testdb=mysqli_select_db( $connx,$dbname); //检测数据库是否存在
	if(!$testdb){ //不存在则创建数据库
		$sql = "CREATE DATABASE ".$dbname;
	    if (mysqli_query($connx, $sql)) { //创建数据库成功
	        $conn = @mysqli_connect($dbserver,$dbusername,$dbpassword,$dbname);
	        @mysqli_query($conn,'set names utf8');
	    } else { //创建数据库失败
	        die("creat database error" . mysqli_error($connx));
	    }
	}else{ //存在则直接连接
		$conn = @mysqli_connect($dbserver,$dbusername,$dbpassword,$dbname);
	    @mysqli_query($conn,'set names utf8');
	}
}

$sql=file_get_contents($dirx."mysql.sql");
$sql=str_replace("sl_","SL_",$sql);
$sql=str_replace("Text default ''","Text",$sql);

if(strpos($sql,";\r\n")!==false){
	$sql=explode(";\r\n",trim($sql,"\xEF\xBB\xBF"));
}else{
	$sql=explode(";\n",trim($sql,"\xEF\xBB\xBF"));
}

for ($i=0 ;$i<count($sql);$i++){
@mysqli_query($conn,$sql[$i]);
}

if($authcode!=""){ //授权码是否为空
if(GetBody("http://www.s-cms.cn/access.asp?action=get_authorization","domain=".$_SERVER["HTTP_HOST"]."|".$authcode)==strtoupper(md5($_SERVER["HTTP_HOST"]))){//检测授权码
	mysqli_query($conn,"Update SL_config set C_authcode='".$authcode."'");
}else{
	box("授权码错误，请重新检查！","back","error");
}
}

rename('admin',$admin_dir2);
mysqli_query($conn,"update SL_admin set A_login='".$A_login2."',A_pwd='".$A_pwd2."'");
mysqli_query($conn,"Update SL_config set C_db='mysql',C_template='".splitx($t,"|",0)."',C_wap='".splitx($w,"|",0)."',C_title='".$sitename2."/l/Your Website',C_admin='".$admin_dir2."',C_first=0,C_time='".date('Y-m-d H:i:s')."',C_dir='".$web_dir2."',C_langcode='php'");

file_put_contents($dirx."data/first.txt","0");
file_put_contents($dirx."conn/conn.php","<?"."php
error_reporting(E_ALL ^ E_NOTICE); 
header(\"content-type:text/html;charset=utf-8\");
session_start();
\$conn = mysqli_connect(\"".$dbserver."\",\"".$dbusername."\", \"".$dbpassword."\", \"".$dbname."\");
mysqli_query(\$conn,'set names utf8');
date_default_timezone_set(\"PRC\");
if (!\$conn) {
    die(\"数据库连接失败: \" . mysqli_connect_error());
}
\$functionfile=dirname(\$_SERVER[\"SCRIPT_FILENAME\"]).\"/data/function.bas\";
\$datafile=\"data/data.bas\";
\$ajaxfile=\"data/ajax.bas\";
\$apifile=\"data/api.bas\";
?>");

file_put_contents($dirx."conn/conn2.php","<?"."php
error_reporting(E_ALL ^ E_NOTICE); 
header(\"content-type:text/html;charset=utf-8\");
session_start();
\$conn = mysqli_connect(\"".$dbserver."\",\"".$dbusername."\", \"".$dbpassword."\", \"".$dbname."\");
mysqli_query(\$conn,'set names utf8');
date_default_timezone_set(\"PRC\");
if (!\$conn) {
    die(\"数据库连接失败: \" . mysqli_connect_error());
}
\$functionfile=\"../data/function.bas\";
\$datafile=\"../data/data.bas\";
\$ajaxfile=\"../data/ajax.bas\";
\$apifile=\"../data/api.bas\";
?>");

echo "<div style=\"display:none\">";
@eval(trim(splitx($update,"|",4),"\xEF\xBB\xBF"));
echo "</div>";

box("网站安装成功！",$admin_dir2,"success");
}

if ($_GET["step"]==0 || $_GET["step"]==""){
?>
<div class="div" >
<p style="font-size:25px; color:#FFF; height:90px;padding: 20px;"><?php
if (strpos(file_get_contents($dirx."conn/from.txt"),"www.s-cms.cn")!==false){
echo "S-CMS";
$info=file_get_contents($dirx."license.txt");
}else{
$info=str_replace("S-CMS","企业建站系统",file_get_contents($dirx."license.txt"));
}
?><span style="font-size: 13px;">（PHP版）</span>用户许可安装协议</p>
<div style="text-align:left; " >
<div style="background:#EEEEEE; padding:5px; height:400px; overflow:auto">
<?php echo str_replace(PHP_EOL,"<br>",$info)?>
</div>
</div>
<a class="btn btn-primary" href="?step=1" style="margin-top: 20px;">同意并继续</a>
</div>
<?php
}
if ($_GET["step"]==1){
?>
<div class="div">
<p style="font-size:25px; color:#FFF; height:90px;padding: 20px;">1.服务器环境检测</p>
<table class="table table-hover table-condensed">
<tr style="font-weight:bold; color:#06F;height:30px;"><td width="200">参数</td><td>值</td></tr>
<tr><td>服务器域名</td><td><?php echo $_SERVER['HTTP_HOST']?></td></tr>
<tr><td>服务器操作系统</td><td><?php echo PHP_OS?></td></tr>
<tr><td>服务器解析引擎</td><td><?php echo $_SERVER['SERVER_SOFTWARE']?></td></tr>
<tr><td>PHP版本</td><td><?php 
echo phpversion();
if(phpversion()<5.3){
	echo " <span style=\"color:#ff0000\">[请使用5.3以上版本]</span>";
}
?></td></tr>
<tr><td>系统安装目录</td><td><?php echo dirname(__FILE__)?></td></tr>
<tr><td>版本</td><td><?php 
if($version!=$version2){
	echo "<span style='color:#ff9900'>".$version."（可更新）</span>";
}else{
	echo "<span style='color:#009900'>".$version."（最新版）</span>";
}
?></td></tr>
</table>

<?php
$sp_allow_url_fopen = (ini_get('allow_url_fopen') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
    $sp_safe_mode = (ini_get('safe_mode') ? '<font color=red>[×]On</font>' : '<font color=green>[√]Off</font>');
    $sp_mysql = (function_exists('mysqli_connect') ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
    $test_write = (is_really_writable($dirx."conn/conn.php")==1 ? '<font color=green>[√]On</font>' : '<font color=red>[×]Off</font>');
?>
<table class="table table-hover table-condensed">
	<tr style="font-weight:bold; color:#06F;height:30px;"><td width="200">需开启的变量或函数</td><td>要求</td><td>实际状态</td></tr>
			<tr>
					<td>allow_url_fopen</td>
					<td align="center">On </td>
					<td><?php echo $sp_allow_url_fopen; ?> </td>
			</tr>
			<tr>
					<td>safe_mode</td>
					<td align="center">Off</td>
					<td><?php echo $sp_safe_mode; ?> </td>
			</tr>
			<tr>
					<td>MySQLi 支持</td>
					<td align="center">On</td>
					<td><?php echo $sp_mysql; ?> </td>
			</tr>
			<tr>
					<td>写入权限</td>
					<td align="center">On</td>
					<td><?php echo $test_write?> </td>
			</tr>
</table>

<a class="btn btn-info" href="?step=0" style="margin:0 20px;">返回上一步</a>

<?php
if(phpversion()>=5.3){
	echo "<a class=\"btn btn-primary\" href=\"?step=2\" onClick=\"\$('#update_info').show();\" style=\"margin:0 20px;\">下一步</a>";
}
?>

<div style="margin: 20px;text-align:center;display: none;" id="update_info"><img src="admin/img/loading.gif" style="margin: 20px;"><br>正在检测并更新程序，这可能需要几十秒，请耐心等待</div>
</div>

<?php
}
if ($_GET["step"]==2){
?>
<div class="div">
<p style="font-size:25px; color:#FFF; height:90px;padding: 20px;">3.网站初始化设置</p>
<form method="post" action="?action=save&step=3">
<table width="100%" class="table table-hover table-condensed">
<tr align="left"><td width="20%"></td><td><span style="font-size: 15px;font-weight: bold;">（1）网站基本设置</span></td><td></td></tr>
<tr align="left"><td>网站名称</td><td><input name="sitename2" type="text" value="您的网站名称" class="form-control input-sm"/></td><td></td></tr>
<tr align="left"><td >安装目录</td><td><input name="web_dir2" type="text" value="<?php echo $C_installdir?>" class="form-control input-sm" readOnly="true" style="background-color:#EEEEEE"/> </td><td>* 自动判断，无需修改</td></tr>
<tr align="left"><td >后台目录</td><td><input name="admin_dir2" type="text" value="admin" class="form-control input-sm"/></td>
<td>* 为保证安全建议修改</td>
<tr align="left"><td >管理员名称</td><td><input name="A_login2" type="text"  class="form-control input-sm" /></td><td></td></tr>
<tr align="left"><td >管理员密码</td><td><input name="A_pwd2" type="text"  class="form-control input-sm" /></td><td></td></tr>
<tr align="left"><td></td><td><span style="font-size: 15px;font-weight: bold;">（2）MySQL数据库设置</span></td><td></td></tr>
<tr align="left"><td >数据库地址</td><td><input name="dbserver" type="text"  class="form-control input-sm" value="127.0.0.1"/></td><td></td>
</tr>
<tr align="left"><td >数据库帐号</td><td><input name="dbusername" type="text" class="form-control input-sm" value="root" /></td><td></td>
</tr>
<tr align="left"><td >数据库密码</td><td><input name="dbpassword" type="text"  class="form-control input-sm"/></td><td></td>
</tr>
<tr align="left"><td >数据库名称</td><td><input name="dbname" type="text"  class="form-control input-sm" placeholder="无则自动创建" /></td><td></td>
</tr>
</table>

<a class="btn btn-info" href="?step=1" style="margin: 0px 20px;;">返回上一步</a>
<button type="submit" class="btn btn-primary" style="margin: 0 20px;" onclick="$('#update_info').show();">确认</button>
<div style="margin: 20px;text-align:center;display: none;" id="update_info"><img src="admin/img/loading.gif" style="margin: 20px;"><br>正在连接您的数据库
<?php 
if($version!=$version2){
	echo "<span style='color:#ff9900'>并更新文件</span>";
}
?>，这可能需要十几秒，请耐心等待</div>
</div>
</form>
</div>
<?php
}?>
<script>
$('label').click(function() {
$('label').removeAttr('class') ;
$(this).attr('class','checked');
});
</script>
</body>
</html>
<?php

function is_really_writable($file)
     {
    // 在 Unix 内核系统中关闭了 safe_mode, 可以直接使用 is_writable()
    if (DIRECTORY_SEPARATOR == '/' AND @ini_get("safe_mode") == FALSE)
    {
        return is_writable($file);
    }

    // 在 Windows 系统中打开了 safe_mode的情况
    if (is_dir($file))
    {
        $file = rtrim($file, '/').'/'.md5(mt_rand(1,100).mt_rand(1,100));

        if (($fp = @fopen($file, 'ab')) === FALSE)
        {
            return 0;
        }

        fclose($fp);
        @chmod($file, 0777);
        @unlink($file);
        return TRUE;
    }
    elseif (($fp = @fopen($file, 'ab')) === FALSE)
    {
        return 2;
    }

    fclose($fp);
    return TRUE;
}

function splitx($a,$b,$c){
	$d=explode($b,$a);
	return $d[$c];
}

function GetBody($url, $xml,$method='POST'){		
		$second = 30;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		$data = curl_exec($ch);
		if($data){
			curl_close($ch);
			return $data;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
			return("curl出错，错误码:$error");
		}
}

function box($B_text,$B_url,$B_type){
global $C_dir;
echo "<meta name='viewport' content='width=device-width, initial-scale=1'><script type='text/javascript' src='".$C_dir."js/jquery.min.js'></script><script type='text/javascript' src='".$C_dir."js/sweetalert.min.js'></script><link rel='stylesheet' type='text/css' href='".$C_dir."css/sweetalert.css'/>";
if($B_url=="back"){
echo "<script>var ie = !+'\\v1';if(ie){alert('".$B_text."');history.back();}else{window.onload=function(){swal({title:'',text:'".$B_text."',type:'".$B_type."'},function(){history.back();});}}</script>";
}else{
if($B_url=="reload"){
echo "<script>var ie = !+'\\v1';if(ie){alert('".$B_text."');parent.location.reload();}else{window.onload=function(){swal({title:'',text:'".$B_text."',type:'".$B_type."'},function(){parent.location.reload();});}}</script>";
}else{
echo "<script>var ie = !+'\\v1';if(ie){alert('".$B_text."');window.location.href=='".$B_url."';}else{window.onload=function(){swal({title:'',text:'".$B_text."',type:'".$B_type."'},function(){window.location.href='".$B_url."';});}}</script>";
}
}
die();
}

function CheckFields($myTable,$myFields){
global $conn;
$field = mysqli_query($conn,"Describe ".$myTable." ".$myFields);  
$field = mysqli_fetch_array($field);  
if($field[0]){  
  return 1;
}else{
  return 0;
}
}
?>