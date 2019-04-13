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
 
 <div class="bodyheader"><h3> 收货地址</h3></div> 
 <div class="memberdetail">	

 <?php 
if($memact=='list')  require(BLOCKROOT.'member/meminc_address_list.php');
if($memact=='add' ||  $memact=='edit')  require(BLOCKROOT.'member/meminc_address_addedit.php');
if($memact=='del'){
			 $ss = "delete   from ".TABLE_ADDRESS."  where pid='$mempidname' and id='$memtid' limit 1";
	  			 // echo $ss;exit;
			iquery($ss);
		    jump('member-address-list.html');
	}

if($memact=='insert' ||   $memact=='update'){
  // pre($_POST); 
  
	$name = htmlentitdm($_POST['name']);
	$telephone = htmlentitdm($_POST['telephone']);
	$address = htmlentitdm($_POST['address']);
   $sta_default = @htmlentitdm($_POST['sta_default']);

	if($memact=='insert'){
		if($sta_default=='on'){
		 	$ss = "update ".TABLE_ADDRESS." set  sta_default='n'  where pid='$mempidname' "; 
		 	iquery($ss);
		 	$sta_defaultv = "y";
		 }
		 else{
		 	$sta_defaultv = "n";
		 }

			$ss = "insert into ".TABLE_ADDRESS." (lang,pbh,pid,name,telephone,address,sta_default) values ('".LANG."','$user2510','$mempidname','$name','$telephone','$address','$sta_defaultv')";
		 	 // echo $ss;exit;
		    iquery($ss); 
		    jump('member-address-list.html');
	}
	if($memact=='update'){
		 if($sta_default=='on'){
		 	$ss = "update ".TABLE_ADDRESS." set  sta_default='n'  where pid='$mempidname' "; 
		 	iquery($ss);
		 	$sta_defaultv = "y";
		 }
		 else{
		 	$sta_defaultv = "n";
		 }

				$ss = "update ".TABLE_ADDRESS." set  name='$name',telephone='$telephone',address='$address',sta_default='$sta_defaultv' where pid='$mempidname' and id='$memtid' limit 1";
	  			  // echo $ss;exit;
		  
			iquery($ss);
		     jump('member-address-list.html');
	}
 }
 

	/*
if($memact=='default'){
	$ss = "update ".TABLE_ADDRESS." set  sta_default='n'  where pid='$mempidname' "; 
			iquery($ss);

		 $ss = "update ".TABLE_ADDRESS." set  sta_default='y'  where pid='$mempidname' and id='$memtid' limit 1";
	  			 // echo $ss;exit;
			iquery($ss);
		    jump('member-address-list.html');
	}*/
 
 ?>

 </div> 
</div> 
<div class="c"> </div> 