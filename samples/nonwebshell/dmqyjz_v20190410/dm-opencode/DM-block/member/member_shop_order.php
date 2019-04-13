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
 require(BLOCKROOT.'member/meminc_sidebar.php');
  ?>
 </div>
 <div class="membercnt col_2f3"> 
 
 <div class="bodyheader"><h3> 我的订单</h3></div> 
 <div class="memberdetail">	

 <?php 
 echo $memact.'aaaa';
if($memact=='list')  require(BLOCKROOT.'member/meminc_order_list.php');
 
if($memact=='del'){
			 //$ss = "delete   from ".TABLE_ADDRESS."  where pid='$mempidname' and id='$memtid' limit 1";
	  			 // echo $ss;exit;
			//iquery($ss);
		   // jump('member-address-list.html');
	} 
 ?>

 </div> 
</div> 
<div class="c"> </div> 