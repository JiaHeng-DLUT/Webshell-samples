<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

require_once BLOCKROOT.'tpl/meta.php';
?>
 <div class="pagewrap">
<?php
require_once BLOCKROOT.'tpl/header.php';
require_once BLOCKROOT.'tpl/banner.php';
?>
<?php

if($regionid<>'')  { //areacontent use danye page,need paddint-top:...
    echo '<div class="pageregionwrap">';
    editpage_goadm($page_id,$page_pidname);
	 block($regionid);
	 echo '</div>';
	// if($alias<>'index') require_once DISPLAYROOT.'b_area.php';
}
else {

		echo '<div class="contentwrap container">';
		editpage_goadm($page_id,$page_pidname);

		$areafile = BLOCKROOT.'tpl/area/area_page.php';
		if(checkfile($areafile))  require  $areafile; 

		 echo '</div>';
}
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
