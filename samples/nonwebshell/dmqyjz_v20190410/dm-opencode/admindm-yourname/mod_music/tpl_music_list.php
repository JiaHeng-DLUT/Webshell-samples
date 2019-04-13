<?php
/*
  power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
?>


 <form method=post action="<?php echo $jumpvpid;?>&act=pos">
  <table class="formtab formtabhovertr">

 <?php
  
$sqlall = "SELECT * from ".TABLE_MUSIC." where pid='$pid' and type='$type'  $andlangbh order by pos desc,id desc";
$num_rows = getnum($sqlall);
if($num_rows>0){
   $maxline = 60;
   $offset=5;
   $page_total=ceil($num_rows/$maxline); //maxline is in mod_node.php

   if (!isset($page)||($page<=0)) $page=1;
   if($page>$page_total) $page=$page_total;
   $start=($page-1)*$maxline;
   $sqltextlist2="$sqlall  limit $start,$maxline";
   $rowall = getall($sqltextlist2);

//-----------
 
  
 ?>

   <tr style="font-weight:bold;background:#eeefff">
  <td   align="center">排序号</td>
  <td   align="center">标识</td>
    <td   align="center">标题</td>
    <td  align="center">mp3地址(优先)</td>
    <td  align="center">mp3上传</td>
    <td   align="center">操作</td>
    <td   align="center">状态</td>
  </tr>

  <?php
 foreach($rowall as $v){
$tid = $v['id'];
$title = $v['title'];
$pidname = $v['pidname'];
$kv = $v['kv'];
$kvlink = $v['kvlink'];

 menu_changesta($v['sta_visible'],$jumpvpid,$tid,'sta_vis');
  
 //$musicv = getmusic($kvlink,$kv);
  $musicaddr = STAPATH.'upload/music/';
  if(substr($kvlink,0,4)=='http') $kvlinkv = $kvlink;
  else $kvlinkv = $musicaddr.$kvlink;

$kvlinkv = '<a href="'.$kvlinkv.'" target="_blank">'.$kvlink.'</a>';
//-----

  $musicroot = STAROOT.'upload/music/'.$kv;

if($kv=='') $kv_v ='';
else {
    if(is_file($musicroot))  $kv_v = '<a href="'.$musicaddr.$kv.'" target="_blank">'.$kv.'</a>';
    else $kv_v = $kv.'不存在。';
}



 
$edit_text='<a class="but1" href="'.$jumpv.'&file=addedit&act=edit&tid='.$tid.'">修改</a>';
$del_text= "<a href=javascript:delimg('delimg','$tid','$pidname','$jumpv')  class='but2'>删除</a>";
      
$musicarootv = '';
if($kv<>''){
  $musicaroot = STAROOT.'upload/music/'.$kv;  
  if(!is_file($musicaroot)) $musicarootv='<span class="cred">不存在</span>'; 
  $linkv2 ='上传：';
}
?>
<tr <?php echo $tr_hide?>>
  <td   align="center"><input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" /></td>
  <td   align="center"><?php echo $pidname;?></td>
    <td   align="center"><?php echo $title;?></td>
    <td  align="center"><?php echo $kvlinkv;?></td>
    <td  align="center"><?php echo $kv_v;?></td>
    <td   align="center"><?php echo $edit_text.' | '.$del_text;?></td>
    <td   align="center"><?php  echo $sta_visible; ?></td>
  </tr>
 

<?php

    } //end foreach
  
  ?> 
 </table>

 <div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="修改排序" />

  </form>
<?php 
 
}
 else {  echo '没有mp3，请添加'; }
?>
<?php
      $file='';
      require_once HERE_ROOT.'plugin/page_2010.php';

      ?>