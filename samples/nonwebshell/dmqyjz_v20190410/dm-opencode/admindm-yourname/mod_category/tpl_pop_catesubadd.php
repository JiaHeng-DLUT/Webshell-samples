<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>

<?php


 




	if($act=='insert'){ 
			 
			$pidname='csub'.$bshou;
			$ss = "insert into ".TABLE_CATE." (ppid,pid,pidname,pbh,name,list_can,last,level,lang,alias_jump,arr_can) values ('$catpid','$catid','$pidname','$user2510','$abc1','$arr_listcanV','y',1,'".LANG."','','$arr_maincateV')";
			 // echo $ss;exit;
			iquery($ss);
			//tongbu_pidname($table);//change id to pidname
			// alert("添加成功");
			echo '<p style="padding:100px;text-align:center">添加成功！';

			 $jumpv_back = $jumpv.'&act=add&catpid='.$catpid.'&catid='.$catid;
       
			echo '<br /><a href="'.$jumpv_back.'" style="font-size:18px">继续添加</a></p>';
			  
	}

		if($act=='update'){ 
			 
		  $ss = "update " . TABLE_CATE . " set name='$abc1'  where pidname='$pidname'   $andlangbh limit 1"; 
        //echo $ss;exit;
            iquery($ss); 			
			$jumpv_back = 'mod_pop_catesubadd.php?lang='.LANG.'&act=edit&catpid='.$catpid.'&catid='.$catid.'&pidname='.$pidname;
			jump($jumpv_back);
			  
	}
	 

	 
 



  if($act=='add' || $act=='edit')	{

 
     $ppidnamev = get_field(TABLE_CATE,'name',$catpid,'pidname');
  	 $pidnamev = get_field(TABLE_CATE,'name',$catid,'pidname');


  if($act=='add')  {
  	$namev = '';
  	 $jumpv_insert = $jumpv.'&act=insert&catpid='.$catpid.'&catid='.$catid;

  }

  if($act=='edit')  {
  	 
  	 $namev = get_field(TABLE_CATE,'name',$pidname,'pidname');

  	 $jumpv_insert = $jumpv.'&act=update&catpid='.$catpid.'&catid='.$catid.'&pidname='.$pidname;
  	
   }

 
 


  ?>
<form  onsubmit="javascript:return checkhere(this)" action="<?php  echo $jumpv_insert;?>" method="post" enctype="multipart/form-data">
<table class="formtab">

<tr>
    <td width="12%" class="tr">主类：</td>
    <td width="88%"> 
            <?php echo $ppidnamev; ?>

     </td>
  </tr>

 

<tr>
    <td width="12%" class="tr">父级：</td>
    <td width="88%"> 
            <?php echo $pidnamev; ?>

     </td>
  </tr>

 

  <tr>
    <td width="12%" class="tr">分类名称：</td>
    <td width="88%"><input name="name" type="text"  value="<?php echo $namev;?>" class="form-control" />
     </td>
  </tr>


 
  
 
  <tr>
    <td></td>
    <td> 
  <br /><br />
    <input class="mysubmit" type="submit" name="Submit" value="添加"></td>
  </tr>
 </table>
</form>

<script>
function  checkhere(thisForm){
		if (thisForm.name.value==""){
		alert("请输入名称");
		thisForm.name.focus();
		return (false); 
		
}
}
 </script>
 


<?php 
}
?>

 
