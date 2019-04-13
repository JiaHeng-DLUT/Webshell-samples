<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

/***here is common list part  ****
********
*********
***********
***********/


?>


<?php
 $sqlsub = "SELECT * from ".TABLE_FIELDOPTION." where  pid='$pid' $andlangbh order by pos desc,id";

 $rowlistsub = getall($sqlsub);
 if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有选项，请添加...</p>';
  }
  else{
  ?>


 <form method=post action="<?php echo $jumpv;?>&act=pos">
  <table class="formtab" style="width:100%">
  <tr style="font-weight:bold;background:#eeefff;">
  <td  align="center">排序号</td>
    <td align="left">选项名称</td>
    <td align="center"></td>
    <td  align="center">状态</td>
 
 
  </tr>
  
    <?php

   foreach($rowlistsub as $vsub){

           $tid=$vsub['id'];       $jsname = jsdelname($vsub['name']);   
          
		   $pidname=$vsub['pidname'];  
		  // $catid=$vsub['pid'];//catid use edit when select degree cate.
		  
            menu_changesta($vsub['sta_visible'],$jumpv,$tid,'sta');
        $edit_desp='<a class=but1 href='.$jumpv.'&file=addedit&act=edit&tid='.$vsub['id'].'><i class="fa fa-pencil-square-o"></i> 修改</a>';
	 
		 $del_text= " <a href=javascript:del('del','$pidname','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
		//$url = ht_url($alias,$mainalias,'subcate',$tid); //ht_url($alias,$mainalias,$type,$id)
	 
?>
  <tr <?php echo $tr_hide?>>
  <td align="center"><input type="text" name="<?php echo $tid;?>"  value="<?php echo $vsub['pos'];?>" size="5" /></td>
    <td align="left">
    <strong><?php echo $vsub['name'];?></strong>
  <br />
     <?php   echo $pidname;?>

     </td>
    <td align="center"><?php echo $edit_desp.$del_text;?></td>
    <td align="center"> <?php   echo $sta_visible;?></td>
	 
 
  </tr>
  
  <?php 
  }
  ?>

</table>

<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
<br />

<?php echo $sortid_asc?></div>
</form>

<?php     
  
  }
  ?>