<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
echo 'member test ....'; exit;
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
layoutcur('','page');  

pre($_SESSION);

 $memact = @htmlentitdm($_GET['memact']);
$memtid = @htmlentitdm($_GET['memtid']);
$seo1[0]  = '会员';
$bsfootermob = '';
$banner='';$bannertitle=$bannertext='会员 ';

$bannercssname = $bannercssname2;
$banner = $banner2;
$bannertextstyle=$bannertextstyle2;
 $bannerbg=$bannerbg2;
 $bannereffect = 'banner_bg.php';
//------------------------

$loginerror ='n';
$memarr1 =array("login","register");

 $memarrsession =array('info','logout','shop_cart','shop_checkout','shop_pay','shop_order','address');
  $memarr = array_merge($memarr1,$memarrsession);

if (in_array($alias, $memarrsession)) {
	if (isset($_SESSION['mempidname'])){
		$mempidname = $_SESSION['mempidname'];

	$sql = " SELECT *  FROM  ".TABLE_AUTH."  where  pidname='$mempidname' and lang='".LANG."'  order by id desc";
	   // echo $sql;
	   $num = getnum($sql );
			if($num>0){
				$memberrow = getrow($sql);
				$nickname = $memberrow['nickname'];
				$email = $memberrow['email'];
				$telephone = $memberrow['telephone'];
			}
			else   $loginerror = 'y';
	}
	else{
		$loginerror = 'y';
	}
}

 $file = TPLCURROOT.'tpl/page/page_member.php';
 if(!is_file($file)) $file = BLOCKROOT.'tpl/page/page_member.php';
 if(checkfile($file)) require $file;
?>
