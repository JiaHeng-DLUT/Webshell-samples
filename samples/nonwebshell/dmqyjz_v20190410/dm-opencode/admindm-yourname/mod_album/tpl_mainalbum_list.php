
<?php
//$wherev = " and type='$type' and pid='$pid'   " ;
 //if($act2=='all') $wherev = "and type<>'subimg'   " ;

 $wherev = "and pid='$pid' " ;

  $sql = "SELECT * from ".TABLE_ALBUM." where   $noandlangbh  $wherev  order by pos desc,id desc"; //pos desc,id desc
    // echo $sql;
  $num_rows = getnum($sql);
     if($num_rows>0){
       $maxline = 300;
        $offset=5;
        $page_total=ceil($num_rows/$maxline); //maxline is in mod_node.php

        if (!isset($page)||($page<=0)) $page=1;
        if($page>$page_total) $page=$page_total;
        $start=($page-1)*$maxline;
        $sqltextlist2="$sql  limit $start,$maxline";
        $rowlisttext = getall($sqltextlist2);
?>
<form method=post action="<?php echo $jumpv;?>&act=pos">
  <table class="formtab formtabhovertr">
  <tr style="font-weight:bold;background:#eeefff">
  <td   align="center">排序号</td>
    <td   align="center">标题</td>
    <td  align="center">图片管理</td>
    <td  align="center">操作</td>
    <td   align="center">状态</td>
  </tr>
  <?php
        foreach($rowlisttext as $v){

     $tid = $v['id']; $title = $v['title'];
      $pidname = $v['pidname']; $pid = $v['pid'];
       $effect = $v['effect'];


  $jsname = jsdelname($v['title']);


//----------------------

 menu_changesta($v['sta_visible'],$jumpv,$tid,'sta_block');
 $num = num_subnode(TABLE_ALBUM,'pid',$pidname);
$edit_text= "<a class='but1'  href='$jumpvnopid&pidname=$pidname&act=edit'><i class='fa fa-pencil-square-o'></i> 修改</a>";


$del_text= " <a href=javascript:del('del_block','$pidname','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";

if($num>0) $del_text='';

$gl= "<a class='but1'  href='$jumpvsubgl&pid=$pidname'><i class='fa fa-folder'></i> 管理($num)</a> ";


    ?>
  <tr <?php echo $tr_hide?>>
  <td align="center">
  <?php
if($act2<>'headless'){
?>
<input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" />
<?php
}
?>
</td>

<td align="left">

 <?php
 echo '<strong>'.$title.'</strong> ';
  echo  adm_previewlink($pidname);
?>    <br />
  <span class="mobhide">标识：</span>

  <span class="cgray"><?php echo admblockid($pidname);?> </span>

 <div class="">
 <?php
 if($effect<>'') {
    $file =  BLOCKROOT.'album/'.$effect; 
    echo '效果文件：'.$effect;
    checkfile($file);
}

if($effect=='album.php') echo '<br /><span class="cred">效果文件不要选择 album.php</span>';
?>


 <?php
 /* 
if($act2=='all'){
  $fourstring = substr($pid,0,4);
  if($fourstring=='bloc')  echo  '<br />'.spanred($pid);
  if($fourstring=='page') {
    echo  '<br />'.spanred($pid);
    $tid = get_field(TABLE_PAGE,'id',$pid,'pidname');
    $title = get_field(TABLE_PAGE,'name',$pid,'pidname');
    echo ' <a target="_blank" href="../mod_page/mod_page_edit.php?lang='.LANG.'&file=edit_desp&act=edit&tid='.$tid.'"> '.$title.'</a>';
  }
  if($fourstring=='node') {
    echo  '<br />'.spanred($pid);
    $tid = get_field(TABLE_NODE,'id',$pid,'pidname');
    $title = get_field(TABLE_NODE,'title',$pid,'pidname');
    echo ' <a target="_blank" href="../mod_node/mod_node_edit.php?lang='.LANG.'&act=editdesp&tid='.$tid.'&file=editdesp">'.$title.'</a>';
  }


}*/ 
?>

  </div>

 </td>

 <td align="center">

  <?php echo $gl;?>
  </td>


  <td align="center">

  <?php echo $edit_text.$del_text;?>
  </td>

    <td> <?php
    if($act2<>'headless')    echo $sta_visible;
    ?></td>

  </tr>
<?php

    } ?>
</table>

<?php
if($act2<>'headless'){
 ?>
<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="修改排序" />

<br />
<?php
echo $sortid_desc;
//echo $text_commonblock;

?>
<p class="cred"><?php echo $text_adminhide2;?></p>

<?php
}
?>

</div>



</form>

<?php

//require_once HERE_ROOT.'plugin/page_2010.php';

?>

<?php
      $file='';
      require_once HERE_ROOT.'plugin/page_2010.php';

      ?>

<?php
}
else {
    echo '还没有内容，请添加。';
}


?>
