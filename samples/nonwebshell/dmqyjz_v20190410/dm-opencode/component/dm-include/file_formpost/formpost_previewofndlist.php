<?php 
if(!dmlogin()){
	echo '提示：没有登录后台，或者后台取消了前台编辑功能';
    //fnoid();
	exit;
}

$seo1 = array('预览');
 
require_once  BLOCKROOT.'tpl/meta.php'; 

?>


<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}

$pidname = @htmlentitdm($_GET['pidname']);

 
//$pidname = 'ndlist20160712_1014264451';
$container1 = $container2 ='';
$pidname4 = substr($pidname, 0,4);
 //echo $pidname4;
if($pidname4=='regi' || $pidname4=='imgt') { }
	else {
		$container1 = '<div class="container">';
		$container2 = '</div>';
	}


echo $container1;
 $page = 1;
block($pidname);

echo $container2;
 

?>


<div class="container c">
<p style="height:100px;padding:50px;text-align:center">
提示：个别预览可能不会有结果或不正常。这时以前台正式显示为准。
<br />
如果目录区块没有正常显示，则可能是 当前模板 没有 使用这个目录区块。
</p>
</div>
<script>
$(function(){
	$('.blockregion').show();
});

</script>


 