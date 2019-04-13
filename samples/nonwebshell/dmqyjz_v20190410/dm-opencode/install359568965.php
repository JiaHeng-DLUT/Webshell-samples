
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>安装</title>
<meta name="author" content="" />
<meta name="keywords" content="" />
<meta name="description" content="" />
<meta name="robots" content="all" />
 
 <style>
 *{padding:0;margin:0}
 h2{text-align:center;height:60px;font-size:16px;background:#5780f2;padding:10px 0;color:#fff}
 h2 p{font-size:12px;}
 h2 a{color:#fff}
 h3{font-size:16px;margin:20px 0;background:#d4e5f7;padding:20px 0;text-align:center;}
  h3 p{font-size:12px;}
 .wrap{width:600px;margin:0 auto;padding:5px; line-height:22px;font-size:14px;padding:5px;color:#000}
 p{padding:10px 0  30px 0 ;color:#999}
 
 input{padding:5px;width:300px}
  .red{color:red} .blue{color:blue}
  .notice{padding:20px 0;font-size:14px}
 .content{font-size:14px;line-height:25px}
 .submit input{border:0;margin:10px;cursor:pointer;padding:10px 0;background:#12A7ED;color:#fff}
 
 </style>

</head>
<body>
<?php 
$dirnamefile = dirname(__FILE__);

$file=str_replace('\\','/',$dirnamefile).'/component/dm-config/database.php';

$filesql=str_replace('\\','/',$dirnamefile).'/component/dm-config/mysql.php';
$filesqlold=str_replace('\\','/',$dirnamefile).'/component/dm-config/mysqli5_below.php';
$filesqlnew=str_replace('\\','/',$dirnamefile).'/component/dm-config/mysqli5.5.php'; 
	
$jump = $_SERVER['PHP_SELF'];
	
$act = @$_GET['act'];
$local=$data=$user=$ps='';

?>
<h2>
DM企业建站系统安装 <br />
  <a target="_blank" href="http://www.demososo.com"> www.demososo.com</a>  

<?php
if($act<>''){
	echo '<br /><a href="'.$jump.'"><<<<<返回重新配置</a>';
 
}
?>
</h2>

<?php 

 
if($act==''){
?>
<h3>第一步：创建和导入数据库</h3>
<div class="wrap">
    用phpmyadmin等工具 创建数据库，格式选 utf8_general_ci<br />
	如果是网上空间，一般不用创建，已经分配好一个数据库<br />
	然后选中这个数据库，点击导入。把sql文件导入。<br />
	具体<a href="http://study.163.com/course/introduction.htm?courseId=1003791004#/courseDetail?tab=1" target="_blank">请看视频教程。</a><br />
	
 </div>
 
 
 <h3>第二步：数据库配置</h3>
 <div class="wrap">
<div class="notice red">
这里的配置会影响component\dm-config\database.php文件的内容。<br />
其实通过编辑database.php文件，也可以达到配置数据库的作用。
</div>
<div style="background:#d4e5f7;margin-bottom:10px ;padding:10px;">
<strong>配置信息：</strong></div>


<form  onsubmit="javascript:return checkhere(this)"  name="form1" method="post" action="<?php echo $jump.'?act=doit' ?>">
<div class="content">
数据库的服务器地址：<input type="text" name="local" value="localhost" />
<p>一般是localhost，有的空间商不是localhost，具体要问空间商。
<br />
比如阿里云的空间，localhost要换成阿里云后台的提示。叫<strong>数据库连接地址</strong>。
</p>

数据库名称： <input type="text" name="data" value="" />
<p>这是在第一步创建或网上空间分配好的数据库名称
</p>
数据库用户名： <input type="text" name="user" value="root" />
<br /><br />
数据库密码：<input type="text" name="ps" value="" />
<br /><br />
是否使用mysqli：
<select name="mysql55">
<option value="n">不是</option>
<option value="y">是</option>
</select>

<br /><br /> 
</div>
<div class="submit"> <input  type="submit"  name="Submit" value="开始配置"> </div>
		
 </form>
 
 <script>
function  checkhere(thisForm){
	 
 if (thisForm.data.value==""){
		 alert("请输入数据库名称");
	 	thisForm.data.focus();
	 	return (false);
      } 
		 
	
		
}

</script>


 </div>
 <?php
}

?>


<?php 
 
function htmlentitdm($v){
	$v = str_replace("..'", "===-", $v); //filter something  
	$v = str_replace(':','===-', $v);
	$v = str_replace('\\','===-', $v);
   return htmlentities(trim($v),ENT_QUOTES,"utf-8");
}//end func


 
if($act=='doit'){
	echo ' <div class="wrap"> ';
	
	$local = htmlentitdm($_POST['local']);
	$data = htmlentitdm($_POST['data']);
	$user = htmlentitdm($_POST['user']);
	$ps = htmlentitdm($_POST['ps']);
	$mysql55 = htmlentitdm($_POST['mysql55']);

	if($mysql55=='y') $mysqlcont =  file_get_contents($filesqlnew);
	else  $mysqlcont =  file_get_contents($filesqlold);

	//echo $mysqlcont;

		file_put_contents($filesql,$mysqlcont);

	
	$content = '<?php  $mysql_server_name="'.$local.'"; $mysql_database="'.$data.'"; $mysql_username="'.$user.'";  $mysql_password="'.$ps.'"; ?>';  
	

	file_put_contents($file,$content);



if($mysql55=='y') {

			if(function_exists('mysqli_connect')){
				$con=mysqli_connect($local,$user,$ps,$data); 
			 
				if (!$con) 
				{ 
					echo '<br /><br /><a href="'.$jump.'"><<<<<返回重新配置</a><br /><br />';
					echo '出错，提示：<span style="color:red">' . mysqli_connect_error().'</span>'; 
					echo '<br />请仔细检查。数据库是否存在? sql是否导入。数据库用户名或密码是否正确?';
					exit;					 
				} 
			}
			else {
				 echo '出错，请选择 不使用 mysqli ';
				 exit;
			}
		 
}
else{
	
			if(function_exists('mysql_connect')){
				
				$con = mysql_connect($local, $user,$ps,'utf-8');
				if (!$con)
				  {
				  //	echo '<a href="'.$jump.'"><<<<<返回重新配置</a>';
					echo '<br /><br />出错,提示：<span style="color:red">' . mysql_error().'</span>';				  
					echo '<br />请仔细检查。 数据库用户名或密码是否正确?';
					exit;
					
				  }
				  

				 $db_selected = mysql_select_db($data, $con);

				 if (!$db_selected)
				  {
				 	//echo '<a href="'.$jump.'"><<<<<返回重新配置</a>';
					echo  '出错，,提示：<span style="color:red">"' . mysql_error().'</span>';	
					echo '<br />请仔细检查。数据库是否存在? sql是否导入?';
					exit;				  
				 }

				mysql_close($con);

			}
			else {
				echo '出错，请选择使用 mysqli ';
				exit;
			}
	
 
				

}
 
	
	?>
	<div style="">
<?php 
/*
	//配置信息为：<br />
	//服务器：<span class="blue"><-?php echo $local;?></span><br />
	//数据库名称：<span class="blue"><-?php echo $data;?></span><br />
	//数据库用户名：<span class="blue"><-?php echo $user;?></span><br />
	//数据库密码：<span class="blue"><-?php echo $ps;?></span><br />
	*/
	?>
 <br /><br />安装成功。<br /><br />为了安全，请记得删除安装文件。<br /><br />
 <a href="index.php">访问前台></a>
 
 
 
</div>

 </div>
 
<?php
}
 ?>
 
 <h2 style="margin-top:30px;padding:20px;height:20px;font-size:12px;">

power by DM建站系统

</h2>

</body>
</html>