<?php 
require('config.php'); 
define('ROOT_PATH', str_replace("\\", '/', substr(__FILE__, 0, strrpos(dirname(__FILE__), DIRECTORY_SEPARATOR))).'/');

require('function.php');

//判断是否已经安装过
if (file_exists(ROOT_PATH.'data/install.lock')) {
	failure('你已经安装过本系统！<br />如果还继续安装，请先删除data/install.lock，再继续');
	exit;
}
$flag = true;
$items = [
            'os'      => ['操作系统', '不限制', 'Windows/类Unix', PHP_OS, 'yes'],
            'php'     => ['PHP版本', '5.5', '5.5及以上', PHP_VERSION, 'yes'],
            'gd'      => ['GD库', '2.0', '2.0及以上', '未知', 'yes'],
        ];

  if ($items['php'][3] < $items['php'][1]) {
            $items['php'][4] = 'no';
             $flag = false;;
        }
        $tmp = function_exists('gd_info') ? gd_info() : [];
        if (empty($tmp['GD Version'])) {
            $items['gd'][3] = '未安装';
            $items['gd'][4] = 'no';
            $flag = false;;
        } else {
            $items['gd'][3] = $tmp['GD Version'];
        }

$file = [
  './config.php',
  './data',
  './uploads',
];

//检测模块

$module = [
['name'=>'pdo','type'=>'类'],
['name'=>'pdo_mysql','type'=>'模块'],
['name'=>'openssl','type'=>'模块'],
['name'=>'gd','type'=>'模块'],
['name'=>'zip','type'=>'模块'],
['name'=>'curl','type'=>'模块'],
['name'=>'file_get_contents','type'=>'函数']
];

foreach($module as $k=>$v){
	if($v['type'] == '模块'){
		  if(!extension_loaded($v['name'])){
		  	$module[$k]['status'] =false;
		    $flag = false;
		  }else{
		  	$module[$k]['status'] = true;
		  }
	}elseif($v['type'] == '函数'){
	  if(!function_exists($v['name'])){
		  	$module[$k]['status'] =false;
		    $flag = false;
		  }else{
		  	$module[$k]['status'] = true;
		  }

	}elseif($v['type'] == '类'){
  if(!class_exists($v['name'])){
		  	$module[$k]['status'] =false;
		    $flag = false;
		  }else{
		  	$module[$k]['status'] = true;
		  }
	}

}
// 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>优客365网址导航系统 安装向导</title>
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
					<h1 class="install">1</h1>
					<div class="left_title">  
						<h2 class="install">环境检测</h2>
						<p class="install">欢迎使用优客365网址导航系统！</p>
					</div>
				</li>
				<li>
					<h1>2</h1>
					<div class="left_title">  
						<h2>授权协议</h2>
						<p>请认真阅读软件使用协议，以免您的利益受到损害！</p>
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
			<div class="right_title">环境检测</div>
			<div style="font-size: 14px; line-height: 25px;text-align: left;">


			<div   align="center">

			            <div >
<table class="layui-table" lay-size="sm">
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>环境名称</th>
      <th>所需配置</th>
      <th>当前配置</th>
    </tr> 
  </thead>
  <tbody>
  <?php foreach($items as $k=>$v){?>
    <tr>
      <td><?php echo $v['0']?></td>
      <td><?php echo $v['2']?></td>
      <td><?php if($v['4'] == 'yes'){ echo '<i class="layui-icon layui-icon-ok" style="color:green"> </i>'; }else{ echo '<i class="layui-icon layui-icon-close" style="color:red">';}?>
      <?php echo $v['3']?></td>
    </tr>
  <?php }?>

  </tbody>
</table>

						<table class="layui-table" lay-size="sm">
						  <colgroup>
						    <col width="150">
						    <col width="200">
						    <col>
						  </colgroup>
						  <thead>
						    <tr>
						      <th>名称</th>
						      <th>目录/文件</th>
						      <th>必须权限</th>
						      <th>当前权限</th>
						    </tr> 
						  </thead>
						  <tbody>
						  <?php foreach($file as $k2=> $v2){ ?>
						    <tr>
						      <td><?php echo $v2;?></td>
						      <td>
						      <?php if(is_file($v2)){
						           echo '文件 ';
						 }else if(is_dir(ROOT_PATH.$v2)){
						          echo '目录';
						 } ?>
                   </td>
					<td>
<i class="layui-icon layui-icon-ok" style="color:green"> </i> 读写 
 </td>


  <td>
<?php if(is_readable(ROOT_PATH.$v2) && is_writeable(ROOT_PATH.$v2)){
 echo '<i class="layui-icon layui-icon-ok" style="color:green"> </i> 读写';
 }else{
 echo '<i class="layui-icon layui-icon-close" style="color:red"> </i> 读写';
 }
 ?>
  </td>
						    </tr>
 <?php } ?>
						  </tbody>
						</table>
<table class="layui-table" lay-size="sm">
  <colgroup>
    <col width="150">
    <col width="200">
    <col>
  </colgroup>
  <thead>
    <tr>
      <th>函数/扩展</th>
      <th>类型</th>
      <th>结果</th>
    </tr> 
  </thead>
  <tbody>
  <?php foreach($module as $k=>$v){?>
    <tr>
      <td><?php echo $v['name'];?></td>
      <td><?php echo $v['type'];?></td>
      <td><?php if($v['status']){ echo '<i class="layui-icon layui-icon-ok" style="color:green"></i>支持';}else{ echo '<i class="layui-icon layui-icon-close" style="color:red"> </i> 支持';}?></td>
    </tr>
<?php }?>
  </tbody>
</table>

                  </div>     
             </div>

				<form action="agreement.php" style="text-align:center">
         		<input hidefocus="true" type="submit" value="马上进入下一步！" 	"  
         		<?php if(!$flag){  
         			echo 'class="layui-btn layui-btn-disabled" disabled'; 
         			}else{ 
         			echo 'class="layui-btn layui-btn-normal"';}?>/>
            	</form>





            </div>
		</div>
 	</div>
</div>
<?php require('footer.php'); ?>
</body>
</html>