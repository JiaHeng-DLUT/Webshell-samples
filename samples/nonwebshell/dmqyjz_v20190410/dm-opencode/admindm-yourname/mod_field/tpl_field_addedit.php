<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
  
//-------------

	if($act=='edit'){
		
		$ss = "select * from ".TABLE_FIELD." where id= '$tid' $andlangbh limit 1";
		$row = getrow($ss);
		if($row=='no'){alert($text_edit_nothisid);exit;}		
		 $tit_v='修改字段';		 
		 $sta_field=$row['typeinput']; 		 
		 $name = $row['name'];
		  $cssname = $row['cssname'];
		 
		$jump_insertupdatefie = $jumpv_file.'&act=update&tid='.$tid;
	}
	
	if($act=='add'){
		$jump_insertupdatefie = $jumpv_file.'&act=insert';
		$tit_v='添加字段';
		$name = '';$cssname = '';
		$sta_field=''; 
	}
	
	if($act=='insert'){ 
	     $jumpv_back = $jumpv_file.'&act=add';
			if($abc1=="" or strlen($abc1)<2) {alert('请输入字段名称或字太少！');  jump($jumpv_back); }
			ifhaspidname(TABLE_CATE,$pid);
			$pidname='field'.$bshou;
			$ss = "insert into ".TABLE_FIELD." (pid,pidname,pbh,name,typeinput,cssname,type,lang) values ('$pid','$pidname','$user2510','$abc1','$abc2','$abc3','$type','".LANG."')";
			 //echo $ss;exit;
			iquery($ss);
			//tongbu_pidname($table);//change id to pidname
			jump($jumpv);
	}
	
	if($act=='update'){  
		$jumpv_back =  $jumpv_file.'&act=edit&tid='.$tid;	
		 if($abc1=="" or strlen($abc1)<2) {alert('请输入字段名称或33字太少！');  jump($jumpv_back); }
		//if($abc3=="" or strlen($abc3)<3) {alert('请输入别名或字太少！');  jump($jumpv_editsub); }
		//if(!in_array($catid,$art_cat_id)){alert('先选择父级分类。');jump($PHP_SELF);}
		ifhaspidname(TABLE_CATE,$pid);
		
			$ss = "update ".TABLE_FIELD." set name='$abc1',typeinput='$abc2',cssname='$abc3',type='$type' where id='$tid' $andlangbh limit 1";
			iquery($ss); 
 			
		jump($jumpv_back);
	
	}
if($act=='add' or $act=='edit'){  	
?>

 
 <form  onsubmit="javascript:return checkhere(this)" action="<?php  echo $jump_insertupdatefie;?>" method="post" enctype="multipart/form-data">
<table class="formtab">

  <tr>
    <td width="12%" class="tr">字段名称：</td>
    <td width="88%"><input name="name" type="text" id="name" value="<?php echo $name;?>" class="form-control" />
    <?php echo $xz_must;?>
     </td>
  </tr>
   <tr>
    <td width="12%" class="tr">字段类型：</td>
    <td width="88%">
	<select name="sele">
	  <?php select_from_arr($arr_field,$sta_field,'pls');?>
     </select>
	 
     </td>
  </tr>
    <tr>
    <td width="12%" class="tr">css名称：</td>
    <td width="88%"><input name="cssname" type="text" id="cssname" value="<?php echo $cssname;?>" class="form-control" />
    <?php echo $xz_maybe;?>
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
 
 if (thisForm.sele.value==""){
		alert("请选择类型");
		thisForm.sele.focus();
		return (false);
        }

}
</script>
 