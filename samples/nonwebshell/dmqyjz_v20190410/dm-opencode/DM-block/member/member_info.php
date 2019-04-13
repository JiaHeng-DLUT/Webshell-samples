<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
} 
?>

 <div class="membersidebar col_1f3"> 
 <?php 
 $file = BLOCKROOT.'member/meminc_sidebar.php';
 if(checkfile($file)) require $file;  
  ?>
 </div>
 <div class="membercnt col_2f3"> 
 <h3 class="membertitle">个人信息：</h3>
 <div class="memberdetail">
		  <?php 

		  echo '昵称：'.$nickname;
			echo '<br />Email：'.$email;
			echo '<br />手机：'.$telephone;

			?> 
 </div> 
 </div> 

<div class="c"> </div> 

 