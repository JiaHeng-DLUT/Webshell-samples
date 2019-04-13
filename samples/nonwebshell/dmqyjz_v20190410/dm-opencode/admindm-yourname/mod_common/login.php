<?php
$dirnamefile = dirname(__FILE__);
$dirnamefile=str_replace('\\','/',$dirnamefile);
$heredir_arr = explode('/',$dirnamefile);
$heredir_arr2 = array_slice($heredir_arr,-2,1);
$heredirlen = count($heredir_arr)-2;
$heredir_root = array_slice($heredir_arr,0,$heredirlen);
$heredir_root_string = implode('/', $heredir_root).'/';

define('WEB_ROOT', $heredir_root_string);

$adminstring = $heredir_arr2[0];
//echo $adminstring;

if(substr($adminstring,0,8)<>'admindm-'){
	echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />后台目录必须以admindm-开头，比如admindm-yournameyourname*** (admindm-后面不受限制)';
	exit;}




ini_set('display_errors', true);

define('IN_DEMOSOSO', TRUE);

//define('WEB_ROOT', substr(dirname(__FILE__), 0, -26));


define('SES_ROOT',WEB_ROOT.'cache/session');

// echo WEB_ROOT;




$userdir='';

 $baseurl_def = $_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
 //echo $baseurl_def;
 //echo '<br />';
$baseurlarr = explode("/", $baseurl_def);
$baseurl_dir_len=count($baseurlarr)-3;
$baseurl_root = array_slice($baseurlarr,0,$baseurl_dir_len);
//echo $baseurl_dir_len;
$baseurl_root_string = implode('/', $baseurl_root).'/';
$baseurl = 'http://'.$baseurl_root_string;//16 is admin_yourname1
define("BASEURL", $baseurl);
 
 //echo '<pre>'.print_r($baseurl,1).'</pre>';


require_once WEB_ROOT.'component/dm-config/inc_table.php';
require_once WEB_ROOT.'component/dm-config/config.php';
require_once WEB_ROOT.'component/dm-config/global.common.php';


ini_set('session.gc_maxlifetime', 7200);

$jumpv = 'login.php';

?>
<?php
$act= @htmlentitdm($_GET['act']);

if($act=='login'){

$user= @htmlentitdm(trim($_POST['user']));
$ps= @htmlentitdm(trim($_POST['password']));
$ifmbadmin= @htmlentitdm(trim($_POST['mbadmin']));


if(strlen($user)<2 or strlen($ps)<2){
	alert('字符不够 sorry,user need more long');    jump($jumpv);
}


require_once WEB_ROOT.'component/dm-config/database.php';
require_once WEB_ROOT.'component/dm-config/mysql.php';
     // $salt = '00';is in config.php
  $pscrypt= crypt($ps, $salt);
     //echo $pscrypt;
		 $user = htmlentitdm($user);
		 $pscrypt = htmlentitdm($pscrypt);
 $ss_P="select * from ".TABLE_USER."  where  email='$user' and ps='$pscrypt'  order by id desc limit 1";
    // echo $ss_P;exit;
		if(getnum($ss_P)>0){
					 $row=getrow($ss_P);
					 $userid=$row['id'];

//$cookiesecret='xylive029'; //only important
$cookiesecret='sec'.rand(11111,99999).time().rand(11111,99999);
//echo $cookiesecret;
session_start();
$_SESSION['sessionsec']=$cookiesecret;
//pre($_SESSION);
$usercookiev = $userid.'-'.md5($pscrypt.$cookiesecret);


				 setcookie("usercookie",$usercookiev,time()+36000,"/");
				 setcookie("isadmin",'y',time()+36000,"/");
				 setcookie("admindir",$adminstring,time()+36000,"/");//use frontend
				 setcookie("mbadmin",$ifmbadmin,time()+36000,"/");
				 setcookie("username",$user,time()+36000,"/");


     jump('mod_index.php?lang='.$mainlang);
					}
					else{
						// $_SESSION['isadmin']='n';
						 setcookie("isadmin",'n',time()+36000,"/");

					     alert('用户名或密码不对！sorry,user or password is incorrect');    jump($jumpv);
					}






}

else{


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
 <head>
  <title>用户登录</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

 <meta name="viewport" content="initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no, width=device-width">
<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />

<link rel="shortcut icon" href="../cssjs/ico/favicon2_cn.ico" />



<link rel="stylesheet" href="../cssjs/libs/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="../cssjs/libs/fontawesome/css/font-awesome.min.css">

<link href="../cssjs/a_common.css" rel=stylesheet type=text/css>
<link href="../cssjs/a_css.css" rel="stylesheet" type="text/css" />






<style>

/*
/* Created by Filipe Pina
 * Specific styles of signin, register, component
 */
/*
 * General styles http://bootsnipp.com/snippets/featured/register-page
 */


.main{margin-top:70px}
h1.title{font-size:50px;font-family:'Passion One',cursive;font-weight:400}
hr{width:10%;color:#fff}
.form-group{margin-bottom:15px}
label{margin-bottom:15px}
input,input::-webkit-input-placeholder{font-size:11px;padding-top:3px}
.main-login{border:1px solid #ccc;background-color:#fff;-moz-border-radius:2px;-webkit-border-radius:2px;border-radius:2px;-moz-box-shadow:0px 2px 2px rgba(0,0,0,0.3);-webkit-box-shadow:0px 2px 2px rgba(0,0,0,0.3);box-shadow:0px 2px 2px rgba(0,0,0,0.3)}
.main-center{margin-top:30px;margin:0 auto;max-width:330px;padding:40px 40px}
.login-button{margin-top:5px}
.login-register{font-size:11px;text-align:center}

</style>

 </head>
 <body>


<?php

$hidecheck = 'y'; //是否隐藏勾选 部分
$adminlte = 'n';  //设置adminlte为默认后台模板

?>


	<div class="container">
			<div class="row main">
				<div class="panel-heading">
	               <div class="panel-title text-center">
	               		<img src="../cssjs/img/adminlogo.png" alt="" />
	               	</div>
	            </div>
				<div class="main-login main-center">
					<form class="form-horizontal" method="post" action="<?php echo $jumpv.'?act=login' ?>">

						<div class="form-group">
							<label for="name" class="cols-sm-2 control-label">用户名</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
									<input type="text" class="form-control" name="user"    placeholder="请输入用户名"/>
								</div>
							</div>
						</div>




						<div class="form-group">
							<label for="password" class="cols-sm-2 control-label">密码</label>
							<div class="cols-sm-10">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
									<input type="password" class="form-control" name="password"    placeholder="请输入密码"/>
								</div>
							</div>
						</div>


 <div class="checkbox"  <?php if($hidecheck=='y') echo 'style="display:none"';?>>
                  <label>
                    <input type="checkbox"  <?php if($adminlte=='y') echo 'checked="checked"';?> name="mbadmin" value="y"> 使用adminLTE模板
                  </label>
                </div>

						<div class="form-group ">
							<button type="submit" class="btn btn-primary btn-lg btn-block login-button">用户登录</button>
						</div>

 <div class="tc" style="padding-top:15px">后台建议用chrome或firefox，不要用IE
 <br />

 Power by <a href="../../adminfrom.php?to=http://www.demososo.com" target="_blank">demososo.com</a>

 <br /> <br />
 <span style="color:red">为了安全，请记得修改后台目录。</span>

 </div>


					</form>
				</div>
			</div>
		</div>


 <?php

 }





 ?>
 </body>
</html>
