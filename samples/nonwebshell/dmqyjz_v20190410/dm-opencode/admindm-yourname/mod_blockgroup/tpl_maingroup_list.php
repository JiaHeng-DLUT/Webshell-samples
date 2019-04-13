<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

//echo strlen('lunh1/20100514_1637283869.jpg');--29
?>



<form method=post action="<?php echo $jumpvpf;?>&act=posmain">
<table class="formtab formtabhovertr">
<tr style="background:#B3C0E0">
<td  align="center">排序</td> 
<td  >标题</td> 
<td  align="center">操作</td>
</tr>


<?php
 
$sql = "SELECT * from ".TABLE_BLOCKGROUP." where pid='0'   $andlangbh  order by  pos desc,id desc";
//and (pidstylebh='$curstyle' or pidstylebh='y') 
  // echo $sql;
if(getnum($sql)>0){
$rowlist = getall($sql);
    foreach($rowlist as $vcat){
       $tidmain=$vcat['id']; //tidmain ,not use tid,for conflict in subedit.php
       $name=$vcat['name'];   $jsname = jsdelname($name);
       $pidnamecur=$vcat['pidname'];  $cssname=$vcat['cssname'];  
       $pidstylebh=$vcat['pidstylebh'];  
       $sta_width_cnt=$vcat['sta_width_cnt']; 

    if($pidname==$pidnamecur) $curclass=' style="color:#fff;background:red;padding:3px;" ';
    else $curclass=' ';

 
 

 $edit =  '<a class="but1"  href="'.$jumpv.'&file=addedit&tid='.$tidmain.'&act=edit"><span  class="bg22"><i class="fa fa-pencil-square-o"></i> 修改</span></a>';

 
  $del ="   <a class='but2'  href=javascript:del('delregion','$pidnamecur','$jumpv','$jsname')><span  class='bg22' ><i class='fa fa-trash-o'></i> 删除</span></a>";
 

$numsubnode = num_subnode(TABLE_COLUMN,'pid',$pidnamecur);
if($numsubnode>0)   $del =''; 

$gl =  '<a class="titletolist2" style="color:blue;font-size:14px;font-weight:bold"  href="../mod_column/mod_column.php?lang='.LANG.'&pid='.$pidnamecur.'&type=group">'.$name.'</a></strong><span class="cred">('.$numsubnode.')</span>'; 

 

     ?>
    <tr>
    <td align="center"><input type="text" name="<?php echo $tidmain;?>"  value="<?php echo $vcat['pos'];?>" size="5" /></td>
   <td align="left">

   <strong><?php echo $gl?></strong>
    <?php 
 echo  adm_previewlink($pidnamecur);
 ?>
   <br />
   <span class="cgray">标识: <?php echo $pidnamecur?> </span>
<br />
    <?php 
    echo '<span class="cgray">是否全宽: '.$sta_width_cnt.'</span>';
       if($cssname<>'') echo '<br /><span class="cgray">css名称: '.$cssname.'</span>';
?> 
<br />

 

   </td>
 
  <td align="center">
          <?php echo $edit.$del?>
     </td>


    </tr>
    <?php 
    } 
    ?>
  

    <?php }
    else echo '<tr><td colspan="3"> 暂无内容，请添加。<td><tr>';



//----------------
//}
//---------------



?>
</table>
  <div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
  <br />
  <?php 
  echo $sortid_desc;
 
  ?>
  </div>
  </form>

 