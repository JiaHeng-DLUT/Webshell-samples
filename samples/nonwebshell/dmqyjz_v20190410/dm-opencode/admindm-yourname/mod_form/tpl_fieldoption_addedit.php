<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
//-------------

	if($act=='edit'){
		
		$ss = "select * from ".TABLE_FIELDOPTION." where id= '$tid' $andlangbh limit 1";
		$row = getrow($ss);
		if($row=='no'){alert($text_edit_nothisid);exit;}		
		 $tit_v='修改选项';		 
		 $name =  $row['name']; 		
		$jump_insertupdatefie = $jumpv_file.'&act=update&tid='.$tid;
	}
	
	if($act=='add'){
		$jump_insertupdatefie = $jumpv_file.'&act=insert';
		$tit_v='添加选项';
		 $name = '';
	}
	
	if($act=='insert'){ 
			$jumpv_back = $jumpv_file.'&act=add';
			if($abc1=="" or strlen($abc1)<2) {alert('请输入选项名称或字太少！');  jump($jumpv_back); }
			ifhaspidname(TABLE_FIELD,$pid);
			$pidname='fieopt'.$bshou;
			$ss = "insert into ".TABLE_FIELDOPTION." (pid,pidname,pbh,name,lang) values ('$pid','$pidname','$user2510','$abc1','".LANG."')";
			 //echo $ss;exit;
			iquery($ss);
			//tongbu_pidname($table);//change id to pidname
			jump($jumpv);
	}
	 
	if($act=='update'){  
			$jumpv_back = $jumpv_file.'&act=edit';
		 if($abc1=="" or strlen($abc1)<2) {alert('请输入选项名称或字太少！');  jump($jumpv_back); }
		//if($abc3=="" or strlen($abc3)<3) {alert('请输入别名或字太少！');  jump($jumpv_editsub); }
		//if(!in_array($catid,$art_cat_id)){alert('先选择父级分类。');jump($PHP_SELF);}
		ifhaspidname(TABLE_FIELD,$pid);
			$ss = "update ".TABLE_FIELDOPTION." set name='$abc1' where id='$tid' $andlangbh limit 1";
			iquery($ss); 	
		jump($jumpv);
	
	}
if($act=='add' or $act=='edit'){	
?>

 
 <form  onsubmit="javascript:return checkhere(this)" action="<?php  echo $jump_insertupdatefie;?>" method="post" enctype="multipart/form-data">
<table class="formtab">

  <tr>
    <td   class="tr">选项名称：</td>
    <td  ><input name="name" type="text" id="name" value="<?php echo $name;?>" class="form-control" />
     </td>
  </tr>

  
 
  <tr>
    <td></td>
    <td> <input class="mysubmit" type="submit" name="Submit" value="<?php echo $tit_v;?>"></td>
  </tr>
 </table>
</form>
<?php
}
?>
 <script>
function  checkhere(thisForm){
		if (thisForm.name.value==""){
		alert("请输入名称");
		thisForm.name.focus();
		return (false);
        }
 
}
</script>