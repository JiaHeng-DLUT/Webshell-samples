<div style="min-height:50px">
 
<p>
 
<?php 
$curv1 = $ppid=='common'?' style="background:red;color:#fff"':'';
echo '<a '.$curv1.' href="'.$jumpv.'&ppid=common">公共区块</a> &nbsp;| &nbsp;';

$curv2 = substr($ppid,0,4)=='styl'?' style="background:red;color:#fff"':'';
echo '<a '.$curv2.' href="'.$jumpv.'&ppid='.$curstyle.'">当前模板区块</a> ';

if(substr($ppid,0,4)=='dmre'){
   echo ' &nbsp;| &nbsp;<a  style="background:red;color:#fff"  href="'.$jumpv.'&ppid='.$ppid.'">
   '.$ppid.'</a> ';
}

echo ' &nbsp;| &nbsp;<a    href="'.$jumpv.'&ppid=coolmb">酷模板</a> ';

//$dmregarr = getDir(REGIONROOT);
//pre($dmregarr);

//foreach($dmregarr as $v){
 // $curv = $ppid==$v?' style="background:red;color:#fff"':'';

  ////echo '<a '.$curv.' href="'.$jumpv.'&ppid='.$v.'">'.$v.'</a> &nbsp;| &nbsp;';

//}
?>
</p>
<?php  
    $linkview = fronturl('dmlink-blockview-'.$ppid.'-1.html');
    echo '<p><a  target="_blank" href="'.$linkview.'">预览</a></p>';
 ?>

</div>
<div class="blocklist">
<form method=post action="<?php echo $jumpvppid;?>&act=pos">
<table class="formtab formtabhovertr">

<?php


foreach($arr_block as $k=>$v){
  $type=$k;
  echo '<tr><td colspan="6">';
    $add = ' &nbsp;&nbsp;&nbsp; <i class="fa fa-plus-circle"></i><a href="'.$jumpvppid.'&act=add&type='.$type.'">添加</a>';
  echo '<h3>'.$v.$add.'</h3>';
 echo '</td></tr>';
 ?>
 
<tr  >
<td  align="center">排序</td> 
<td  >标题</td> 
<td   align="center" >效果文件</td> 
<td  align="center">操作</td>
<td   align="center">转换/td>
<td   align="center">状态</td>
</tr>
<?php
///and (pidstylebh='$curstyle' or pidstylebh='common') 
//if($ppid=='common') $wherev= " and (pidstylebh='$curstyle' or pidstylebh='common')  ";
//else $wherev ='';
  $sql = "SELECT * from ".TABLE_BLOCK." where   $noandlangbh  and pidstylebh='$ppid' and pid='$type' and typecolumn<>'column'  order by  pos desc,id desc"; //pos desc,id desc
  //echo $sql;
  $num_rows = getnum($sql);
  if($num_rows>0){

    $res = getall($sql);
     
  
      foreach($res as $v){


    $tid = $v['id']; $name = $v['name'];
    $pidname = $v['pidname']; $pid = $v['pid'];
    $pidcate = $v['pidcate']; 
  
     $template = $v['template'];
  
    menu_changesta($v['sta_visible'],$jumpvppid,$tid,'sta_block');
 
$jsname = jsdelname($v['name']);


$arr_can = $v['blockcan'];
$bscntarr = explode('==#==',$arr_can); 
if(count($bscntarr)>1){
  foreach ($bscntarr as   $bsvalue) {
   if(strpos($bsvalue, ':##')){
     $bsvaluearr = explode(':##',$bsvalue);
     $bsccc = $bsvaluearr[0];
     $$bsccc=$bsvaluearr[1];
   }
 }
}

//---------
$tempself = substr($template,0,5);
 
if($template<>'') { 

  if($ppid=='common')  $file =  BLOCKROOT.$type.'/'.$template;
  if($ppid4=='styl')  $file =  TPLCURROOT.'/selfblock/'.$type.'/'.$template;
 if($ppid4=='dmre')  $file = REGIONROOT.$ppid.'/'.$type.'/'.$template;
  
 
  
$vnoexist =  is_file($file)?'':' <span class="cred">(不存在)</span>';


}

$templatev = ' <span class="cgray">'.$template.'</span>';

//----------------------

 //---------------
//$edit_text= "<a class='but1'  href='$jumpvt&pidname=$pidname&act=edit'><i class='fa fa-pencil-square-o'></i> 修改</a>";

$edit_text2= " <a class=but1  href='$jumpv&pidname=$pidname&act=edit'>修改</a>";


$del_text= " <a href=javascript:delid('del_block','$tid','$jumpvppid','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";

 
?><tr <?php echo $tr_hide?>> 
<td  align="center">
<input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="5" /></td> 
<td  ><?php echo $name.' ';
  echo  adm_previewlink($pidname);

 
if($type=='bkblockdh'){
  $num= num_subnode(TABLE_NODE,'pid',$pidname);
if($num==0) {
  $num = '<span class="cred">'.$num.'</span>';
 
}
else  $del_text='';
  // echo ' <a target="_blank" href="../mod_node/mod_blockdh.php?lang='.LANG.'&pid='.$pidcate.'">[管理]</a>';
  echo '  <a class="but1" target="_blank" href="mod_effectnode.php?lang='.LANG.'&pid='.$pidname.'">效果区块内容管理('.$num.')</a> ';

}
?>
<br /><?php 
echo  admblockid($pidname) ; 

?>
</td> 
<td  align="center"><?php echo $templatev.$vnoexist;

?></td>
<td  align="center"><?php echo $edit_text2.$del_text?></td>
<td  align="center"><?php echo $sta_visible;?></td>
<td  align="center"><?php 
if($ppid=='common') $movepid = '<a href="'.$jumpv.'&act=move&pidname='.$pidname.'">转为当前模板区块</a>';
else $movepid = '<a href="'.$jumpv.'&act=movecommon&pidname='.$pidname.'">转为公共区块</a>';

echo '<p>'.$movepid.'</p>';
?></td>

</tr>
<?php
 }//edn foreach
  }//enf if num>0
  ?>

<?php
}//end foreach $arr_block

?> 
</table> 
<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="修改排序" />
</form>
<?php
echo $sortid_desc;
?>
<p class="cred"><?php echo $text_adminhide2;?></p>
</div>

 
 
<?php
      $file='';
      require_once HERE_ROOT.'plugin/page_2010.php';

      ?>

 <script>
   function checksearch(thisForm) {


       if (thisForm.searchword.value == "" || thisForm.searchword.value == "请输入标题或模板" )
       {
           alert("请输入标题或模板。");
           thisForm.searchword.focus();
           return (false);
       }



       // return;

   }


function selectjump(url){
 if(url!='') window.location.href=url;
}


</script>
