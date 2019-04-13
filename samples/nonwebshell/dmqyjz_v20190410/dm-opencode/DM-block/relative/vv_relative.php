  <?php 

//---获取数据-------------
 
  $maxline = (int)$relamaxline;
  $wherev = $relapid=='y'?" and ppid = '$mainpidname'  ":" and pid = '$curcatepidname' ";
 //ppid = '$mainpidname'  pid='curcatepidname' 


 
$sqlnode="select * from ".TABLE_NODE." where  sta_visible='y' and id<>$detailid $andlangbh  $wherev  order by pos desc,id desc limit $maxline";
$fenum = getnum($sqlnode);
 
if($fenum==0) {  //echo '没有记录。--'.$pidcate;
$result = array();
}
else 
{

  $result = getall($sqlnode);

$dhtrigger = 'bxbanneracc'.rand(1000,9999); 


 $relativetitle = $relativetitle==''?'相关文章：':$relativetitle;
 
  if(substr($relativefg,0,5)=='self_')  $file = TPLCURROOT.'selfblock/relative/'.$relativefg;
   else  $file = BLOCKROOT.'relative/'.$relativefg; 
if(checkfile($file)) require $file;

  }
  ?>
 