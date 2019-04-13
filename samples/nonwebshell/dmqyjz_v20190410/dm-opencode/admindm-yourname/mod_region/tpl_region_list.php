<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

//

?> 
 
 
 <form method=post action="<?php echo $jumpv;?>&act=pos">
 <table class="formtab formtabhovertr">    
<tr style="background:#B3C0E0">
<td  align="center">排序号</td>
<td>标题</td> 

<td align="center">操作</td>  
<td align="center">状态</td> 

</tr>
<?php
 $sql = "SELECT * from ".TABLE_REGION." where pid='$pid'   $andlangbh order by pos desc,id";
 //echo $sql; 
 $rowlist = getall($sql);
if($rowlist=='no') echo '暂无内容';
else{
foreach($rowlist as $v){
$pidname2=$v['pidname'];
$name=$v['name']; 
$tid=$v['id'];
$blockid=$v['blockid']; 

$sta_visi_v=$v['sta_visible']; 

menu_changesta($sta_visi_v,$jumpv,$tid,'sta');
 
 $reganchor = '';

$arr_cfg=$v['arr_cfg'];   //echo $arr_cfg;
$bscntarr = explode('==#==',$arr_cfg);
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }



 $jsname = jsdelname($v['name']);

$editlink='<a class=but1   href='.$jumpv.'&file=editcan&tid='.$tid.'><i class="fa fa-pencil-square-o"></i> 修改</a> ';
//$editlink.='<a class=but1   href='.$jumpv.'&file=editcfg&act=edit&tid='.$tid.'>样式</a> ';
 
$del_text= " <a href=javascript:del('del','$pidname2','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";

 // $movelink=' <a class=but3    href='.$jumpv.'&file=move&act=edit&tid='.$tid.'><i class="fa fa-files-o"></i> 复制</a>';
//no move function.
 
 
$numsubnode = num_subnode(TABLE_COLUMN,'pid',$pidname2);
if($numsubnode>0)   $del_text =''; 

  
if($blockid=='')  $namev =  '<strong><a   href="../mod_column/mod_column.php?lang='.LANG.'&pid='.$pidname2.'&type=region">'.$name.'</a></strong><span class="cred">('.$numsubnode.')</span>'; 
else $namev = '<strong>'.$name.'</strong>'; 


?>
<tr  <?php echo $tr_hide;?>>
 <td align="center">
 <input type="text" name="<?php echo $tid;?>"  value="<?php echo $v['pos'];?>" size="3" />
 </td> 

 <td>

 <?php 
 if($blockid=='') {
 echo '<strong><a   href="../mod_column/mod_column.php?lang='.LANG.'&pid='.$pidname2.'&type=region">'.$name.'</a></strong><span class="cred">('.$numsubnode.')</span>'; 
  }
  else{
     echo '<strong>'.$name.'</strong>'; 
  }
 
 ?>
 <br /> 锚点：
 <?php 
 if($reganchor=='') echo  'region'.$tid;
 else echo $reganchor;
 ?>
 <br />
 <span class="cgray"><?php echo $pidname2?></span>
 <?php
 if($blockid<>'') echo '<div style="border-top:0px solid #ccc">'.check_blockid($blockid).'</div>';

  ?>

  </td> 
  
  <td align="center">
  <?php 
  echo $editlink.$del_text;
  ?>    
  </td> 
   <td align="center"><?php echo $sta_visible;?></td> 

 </tr> 
 <?php 
}
}
?>
	
	</table>
<div style="padding-bottom:22px;text-align:left">
<input class="mysubmit" type="submit" name="Submit" value="排序" />
<p><?php echo $sortid_asc?>
</p>
</div>
</form>