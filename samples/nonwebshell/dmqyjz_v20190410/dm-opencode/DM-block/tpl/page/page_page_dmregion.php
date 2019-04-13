<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
 layoutcur('','page'); 
require_once BLOCKROOT.'tpl/meta.php';
?>
 <div class="pagewrap">
<?php
require_once BLOCKROOT.'tpl/header.php';
 
?>
<?php

  //areacontent use danye page,need paddint-top:...
    echo '<div class="pageregionwrap">';
    //editpage_goadm($page_id,$page_pidname);
   // echo $alias;
   // $regpidname = get_field(TABLE_REGION,'pidname',$alias,'dmregdir');
   // echo $regpidname;
   //if($regpidname=='noid') echo '<p style="background:red;color:#fff">没有这个区域</p>';
   //  else   block($regpidname);
    block($alias);
	 echo '</div>';
	// if($alias<>'index') require_once DISPLAYROOT.'b_area.php';
 
?>
<!-- end contentwrap -->



<?php
  $reqfile = BLOCKROOT.'tpl/footer.php';
 require_once $reqfile;

?>

</div><!--end pagewrap-->

<?php
$reqfile = BLOCKROOT.'tpl/footer_last.php';
require_once $reqfile;

?>
