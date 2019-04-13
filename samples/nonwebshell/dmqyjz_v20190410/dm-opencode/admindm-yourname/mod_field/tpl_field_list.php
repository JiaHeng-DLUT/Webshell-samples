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
 $sqlsub = "SELECT * from ".TABLE_FIELD." where  pid='$pid' $andlangbh order by pos desc,id";
 $rowlistsub = getall($sqlsub);
 if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有字段，请添加...</p>';
  }
  else{
  ?>


 <form method=post action="<?php echo $jumpv;?>&act=pos">
  <table class="formtab" style="width:100%">
  <tr style="font-weight:bold;background:#eeefff;">
  <td align="center">排序号</td>
    <td align=left>字段名称</td>
    <td align="center"></td>
    <td align="center">状态</td> 
	 
 
  </tr>
  
    <?php

   foreach($rowlistsub as $vsub){

           $tid=$vsub['id'];$type_fie=$vsub['typeinput']; 
            $jsname = jsdelname($vsub['name']);
		   $pidname=$vsub['pidname'];  $cusfields=$vsub['cusfields'];  
		  // $catid=$vsub['pid'];//catid use edit when select degree cate.
		  

  $del_text ='';
  
		//$url = ht_url($alias,$mainalias,'subcate',$tid); //ht_url($alias,$mainalias,$type,$id)
	  if($type_fie=='checkbox' or $type_fie=='radio' or $type_fie=='select') 
	  {
	   $sqlfieopt = "SELECT id from ".TABLE_FIELDOPTION." where  pid='$pidname' $andlangbh order by pos desc,id";
     //echo $sqlfieopt;
	   $fieoptnum=getnum($sqlfieopt);
 
	  
	  $fieldoption = '<a class="but4" target="_blank" href="mod_fieldoption.php?pid='.$pidname.'&type='.$type_fie.'&lang='.LANG.'">设置字段选项(<span class="cred">'.$fieoptnum.'</span>)</a>';



    if($fieoptnum==0){
      $del_text= " <a href=javascript:del('del','$pidname','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
  }
	  
	  }
	  else
    { $fieldoption ='';
   $del_text= " <a href=javascript:del('del','$pidname','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
}


   menu_changesta($vsub['sta_visible'],$jumpv,$tid,'sta');
    $edit_desp='<a class=but1 href='.$jumpv.'&file=addedit&act=edit&tid='.$vsub['id'].'><i class="fa fa-pencil-square-o"></i> 修改</a>';
   
 
?>
  <tr <?php echo $tr_hide?>>
  <td align="center"><input type="text" name="<?php echo $tid;?>"  value="<?php echo $vsub['pos'];?>" size="5" /></td>
    <td align="left">
    <strong><?php echo $vsub['name'];?></strong>
     <br />
     <?php   echo $pidname;?>
 <br />
       <?php echo select_return_string($arr_field,0,'',$type_fie);?>
      
      <br />
      <?php 
      if($cusfields<>'') echo $fieldoption;
      ?>


     </td>
    <td align="center"><?php echo $edit_desp.$del_text;?></td>
    <td align="center"><?php   echo $sta_visible;?></td>
	  
   
    
  </tr>
  
  <?php 
  }
  ?>

</table>

<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" /><?php echo $sort_ads?></div>
</form>

  


<?php
          
  
  }
  ?>