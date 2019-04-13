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

 

		echo '<div class="contentwrap container">';

		$filehere = BLOCKROOT.'member/member_'.$alias.'.php';
		if(checkfile($filehere)) require_once $filehere; 

		 echo '</div>';
 
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
