<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
  
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

if(!dmlogin()){
	echo '提示：没有登录后台，或者后台取消了前台编辑功能';
    //fnoid();
	exit;
}
$seo1[0]  = '预览区块';
$bsfootermob = '';

require_once BLOCKROOT.'tpl/meta.php';
?>
<div class="pagewrap">
 <style>
.headershowblock{
 margin:50px 0 20px  0;line-height:30px;
 text-align:center;background:#37cde6;font-size:20px
}
.headershowblock span{font-size:14px;color:#666;}

.viewblocktab {height:30px;margin:10px 0;text-align: center}
.viewblocktab a{display: inline-block;margin-right: 16px;padding:5px;background: #e2e2e2}
.viewblocktab a.active{background: #12A7ED;color:#fff;}
</style>

<?php
 
$banner='';$bannertitle='预览区块 ';
$bannertext = '';

require_once BLOCKROOT.'tpl/header.php'; 
$bannereffect = 'banner_bg.php';
 inc_brannereffect($bannereffect); 

$active1 = $active2 = $active3 = '';
if($alias=='bkcustom') $active1 = ' class="active" ';
if($alias=='bknode')  $active2 = ' class="active" ';
if($alias=='bkblockdh') $active3 = ' class="active" ';

//dmlink-blockview-bdgrid-1.html
//$cur_href = 'tag-'.$routeid.'.html';	
$cur_href = 'dmlink-blockview-'.$alias.'.html';	//for pager at bottom...


?>

<div class="viewblocktab">
公共区块演示：
<a <?php echo $active1;?> href="dmlink-blockview-bkcustom-1.html">自定义区块 </a>
<a <?php echo $active2;?> href="dmlink-blockview-bknode-1.html">文章区块 </a> 
<a <?php echo $active3;?> href="dmlink-blockview-bkblockdh-1.html">效果区块 </a> 
</div>

<?php

 // $progv = 'prog_viewblock_'.$page;
 // block($progv);
?>


 


<div class="container">
<?php
global $andlangbh;
//echo $curstyle;
 //and (pidstylebh='$curstyle' or pidstylebh='')  
  $sqlnode = "SELECT *  from ".TABLE_BLOCK." where   pid='$alias' and typecolumn<>'column'    and sta_visible='y' and (pidstylebh='$curstyle' or pidstylebh='common') $andlangbh order by pos desc,id desc";  //pos desc,id desc

   //echo $sqlnode;exit;
  Global $page; 
  $pagehere = $page; //bec confict with some block.
 
  
  
	$v= array();$page_total = 0;
	$maxline= 5;
	
	$fenum = getnum($sqlnode);
  if($fenum>0) {
	
	$page_total=ceil($fenum/$maxline);
	 
		if($pagehere>$page_total) $pagehere=$page_total;
        $start=($pagehere-1)*$maxline;
        $sqllist33="$sqlnode  limit $start,$maxline";
	  // echo  $sqllist33; 	exit;	 
        $result = getall($sqllist33);
		
   
   if($result =='no') echo '<p style="padding:100px;font-size:20px">提示：此站点（或语言）没有这类区块记录。请在后台添加。</p>';
 else{

   foreach($result as $v){
   //$inputcopyjs= "this.select();document.execCommand('Copy')";
  //  $inputcopy = '<input style="border:0;background:#C2E8FF" onclick="'.$inputcopyjs.'" type="text" value=" [DMblockid]'.$v['pidname'].' [/DMblockid]" class="form-control">';
       $pidname = $v['pidname'];
       $template = $v['template'];
       $type = $v['pid'];


  
$showrecord='y';
  $filename =  'base/block/'.$type.'/'.$template;   
 


if($showrecord=='y'){



    echo '<div class="headershowblock">'.$v['name'].'<br /><span>  [DMblockid]'.$pidname.'[/DMblockid]<br /> '.$filename.'</span></div>';
    block($v['pidname']);
    echo '<div class="c"></div>';

  }

   }
 }

}
else  {  echo 'no record...';}
?>
</div>






 








<?php

//echo '<br >==='.$page_total;
 // echo '<br >==='.$page;

    $page  = $pagehere; //here back to page. bec confict with some block.
 
  
  
require_once BLOCKROOT.'tpl/plugin_pager.php';


require_once BLOCKROOT.'tpl/footer.php';


?>

</div><!--end pagewrap-->

<?php
 
require_once BLOCKROOT.'tpl/footer_last.php';
 

?>



</body>
</html>
