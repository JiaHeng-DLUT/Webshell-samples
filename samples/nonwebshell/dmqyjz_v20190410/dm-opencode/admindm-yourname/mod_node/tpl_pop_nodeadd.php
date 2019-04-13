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
			 
    $pidname = 'node'.$bshou; 
     $sta_noaccess='n';
     if($user_stanoaccess=='y' && $usertype=='normal')  $sta_noaccess='y';
    
    if($catid=='') $catid=$catpid;
	 //also must set pidmulti value when add node
      $ss = "insert into ".TABLE_NODE." (ppid,pid,pidmulti,pidname,pbh,title,lang,arr_can,sta_noaccess,dateedit,pos) values ('$catpid','$catid','$catid','$pidname','$user2510','$abc1','".LANG."','$arr_nodeV','$sta_noaccess','$dateall',5000)";
      //echo $ss;exit;
      iquery($ss);

    
			echo '<p style="padding:100px;text-align:center">添加成功！';

			 $jumpv_back = 'mod_pop_nodeadd.php?lang='.LANG.'&act=add&catpid='.$catpid.'&catid='.$catid;

			echo '<br /><a href="'.$jumpv_back.'" style="font-size:18px">继续添加</a></p>';
			  
	}

		if($act=='update'){ 
			 
		  $ss = "update " . TABLE_CATE . " set name='$abc1'  where pidname='$pidname'   $andlangbh limit 1"; 
        //echo $ss;exit;
            iquery($ss); 			
			$jumpv_back = 'mod_pop_cateadd.php?lang='.LANG.'&act=edit&catpid='.$catpid.'&catid='.$catid.'&pidname='.$pidname;
			jump($jumpv_back);
			  
	}
	 

	 
 



  if($act=='add' || $act=='edit---')	{

 
     $ppidnamev = get_field(TABLE_CATE,'name',$catpid,'pidname');

     if($catid=='') $pidnamev = '同主类';
  	 else $pidnamev = get_field(TABLE_CATE,'name',$catid,'pidname');


  if($act=='add')  {
  	$namev = '';
  	 $jumpv_insert = 'mod_pop_nodeadd.php?lang='.LANG.'&act=insert&catpid='.$catpid.'&catid='.$catid;

  }

  if($act=='edit')  {
  	 
  	 $namev = get_field(TABLE_CATE,'name',$pidname,'pidname');

  	 $jumpv_insert = 'mod_pop_nodeadd.php?lang='.LANG.'&act=update&catpid='.$catpid.'&catid='.$catid.'&pidname='.$pidname;
  	
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
    <td width="12%" class="tr">标题：</td>
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

 
