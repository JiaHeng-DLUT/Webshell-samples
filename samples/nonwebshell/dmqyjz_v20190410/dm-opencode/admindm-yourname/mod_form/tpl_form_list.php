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
 $sqlsub = "SELECT * from ".TABLE_FIELD." where  pid='block' $andlangbh and type='block' order by pos desc,id desc";
 $rowlistsub = getall($sqlsub);
 if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有记录，请添加...</p>';
  }
  else{
  ?>


 <form method=post action="<?php echo $jumpv;?>&act=pos">
  <table class="formtab" style="width:100%">
  <tr style="font-weight:bold;background:#eeefff;">
  <td align="center">排序号</td>
    <td align=left>标题</td>
     <td align=center>管理</td>
    <td align="center"></td>
    <td align="center">状态</td> 
	 
 
  </tr>
  
    <?php

   foreach($rowlistsub as $vsub){

           $tid=$vsub['id'];$type_fie=$vsub['typeinput']; 
            $jsname = jsdelname($vsub['name']);
		   $pidname=$vsub['pidname'];      $effect=$vsub['effect'];   
		  // $catid=$vsub['pid'];//catid use edit when select degree cate.
		  


  
      $sqlfieopt = "SELECT id from ".TABLE_FIELD." where  pid='$pidname' $andlangbh order by id";
     //echo $sqlfieopt;
     $num=getnum($sqlfieopt);

 
  $del_text ='';

    if($num==0){
      $del_text= " <a href=javascript:del('del','$pidname','$jumpv','$jsname')  class=but2><i class='fa fa-trash-o'></i> 删除</a>";
  }
    


   menu_changesta($vsub['sta_visible'],$jumpv,$tid,'sta');

    $edit_desp='<a class=but1 href='.$jumpv.'&file=addedit&act=edit&pidname='.$vsub['pidname'].'><i class="fa fa-pencil-square-o"></i> 修改</a>';
   
   $gl = '<a  class=but1 href="mod_field.php?lang='.LANG.'&pid='.$pidname.'">管理字段</a>';
 $result = ' - <a target="_blank" href="../mod_comment/mod_comment.php?lang='.LANG.'&catid=formblock&catpid='.$pidname.'">结果</a>';
?>
  <tr <?php echo $tr_hide?>>
  <td align="center"><input type="text" name="<?php echo $tid;?>"  value="<?php echo $vsub['pos'];?>" size="5" /></td>
    <td align="left">
    <strong><?php echo $vsub['name'].$result;?></strong>
     <br />
     <?php   echo admblockid($pidname);?>

<div class="">
 <?php
 
    if(substr($effect,0,5)=='self_')   $file =  TPLCURROOT.'/selfblock/form/'.$effect;
    else  $file =  BLOCKROOT.'form/'.$effect;
    echo  '效果文件：'.$effect;
    checkfile($file);
 
 ?>

  </div> 

     </td>
      <td align="center">
      <?php 
      $effect2 = substr($effect,0,5);
      if($effect2 =='self_') {
        echo '自定义表单文件：'.$effect;
      }
      else{
        echo $gl;
        echo '<span class="cred">('.$num.')</span>';
      }

    

    ?>
      </td>
    <td align="center"><?php echo $edit_desp.$del_text;?></td>
    <td align="center"><?php   echo $sta_visible;?></td>
	  
   
    
  </tr>
  
  <?php 
  }
  ?>

</table>

<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
<?php echo $sortid_asc?></div>
</form>

  


<?php
          
  
  }
  ?>