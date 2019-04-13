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
 layoutcur('','page'); 

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

 /*blocklist*/ 
.blocklist .h3here{background:red;color:#fff;padding:30px;font-size:14px;font-weight:bold; text-align: center;margin-bottom:20px; }
.blocklist .h3here a{ color:#fff;font-weight:normal;font-size:12px; }

</style>

<?php


require_once BLOCKROOT.'tpl/header.php'; 

$banner='';$bannertitle='预览 ';
$bannereffect = 'banner_bg.php';
$bannertext = '';
$bannercssname =$bannertextstyle =$bannerbg='';
$bannereffect = 'banner_bg.php';
require_once BLOCKROOT.'tpl/banner.php'; 
 
 
$ppid=$alias;

$ppid4 = substr($ppid,0,4);
 // echo $ppid4;
  if($ppid4=='regi'){
       block($ppid);
  }

// elseif($ppid4=='dmre'){
  //    $file22 = REGIONROOT.$ppid.'/'.$ppid.'.php';
       
     // if(checkfile($file22)) require $file22;
  //}
  elseif($ppid=='common' || $ppid4=='styl') {
    
 
      echo '<div class="blocklist">';

         $arr_block=array('bkcustom'=>'自定义区块', 
                    'bknode'=>'内容区块',
              'bkblockdh'=>'效果区块',
                    );

      foreach($arr_block as $k=>$v){
        $type=$k;
          $add = ' ';
        echo '<h3 class="h3here">'.$v.$add.'</h3>';
         echo '<div class="container">';
//----------------
        $sql = "SELECT * from ".TABLE_BLOCK." where   $noandlangbh  and pidstylebh='$ppid' and pid='$type' and typecolumn<>'column'  order by  pos desc,id desc"; //pos desc,id desc
  //echo $sql;
  $num_rows = getnum($sql);
  if($num_rows>0){

    $res = getall($sql);
     
  
      foreach($res as $v){


        $pidname = $v['pidname'];
        $template = $v['template'];
        $type = $v['pid'];

if($ppid=='common')  $filename =  'DM-block/'.$type.'/'.$template;
  if($ppid4=='styl')  $filename =  'DM-template/'.HTMLDIR.'/selfblock/'.$type.'/'.$template;
  if($ppid4=='dmre')  $filename = 'DM-region/'.$ppid.'/'.$type.'/'.$template;


   echo '<div class="headershowblock">'.$v['name'].'<br /><span>  [DMblockid]'.$pidname.'[/DMblockid]<br /> 文件：'.$filename.'</span></div>';
    block($v['pidname']);
    echo '<div class="c"></div>';




      }//end foreach res
     

}
else {echo '<p style="padding:20px;text-align:center">没有内容。</p>';}

 echo ' </div>';
//----------------------------
      }//end foreach arr_block

      echo ' </div>';
} //end  ($ppid4=='dmre')
else{
  echo '<p style="padding:55px;text-align:center">type is error...</p>';
}
?>
 



<?php
   

require_once BLOCKROOT.'tpl/footer.php';


?>

</div><!--end pagewrap-->

<?php
 
require_once BLOCKROOT.'tpl/footer_last.php';
 

?>



</body>
</html>
