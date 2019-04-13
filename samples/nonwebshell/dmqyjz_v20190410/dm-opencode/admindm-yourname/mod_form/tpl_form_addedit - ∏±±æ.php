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
		 $tit_v='修改';		 
		 $sta_field=$row['typeinput']; 		 
		 $name = $row['name'];$namefront = $row['namefront'];
		  $cssname = $row['cssname']; $effect = $row['effect'];$cusfields = $row['cusfields'];
		 
		$jump_insertupdatefie = $jumpv_file.'&act=update&tid='.$tid;
	}
	
	if($act=='add'){
		$jump_insertupdatefie = $jumpv_file.'&act=insert';
		$tit_v='添加';
		$name = $namefront = $cssname = $effect = $cusfields= '';
		$sta_field=''; 
	}
	
	if($act=='insert'){ 
	     $jumpv_back = $jumpv_file.'&act=add';
			if($abc1=="" or strlen($abc1)<2) {alert('请输入字段名称或字太少！');  jump($jumpv_back); }
			
			$pidname='form'.$bshou;
			$ss = "insert into ".TABLE_FIELD." (pid,pidname,pbh,name,namefront,cssname,cusfields,type,effect,lang) values ('$pid','$pidname','$user2510','$abc1','$abc2','$abc3','$abc4','$type','$abc5','".LANG."')";
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
		 
			$ss = "update ".TABLE_FIELD." set name='$abc1',namefront='$abc2',cssname='$abc3',cusfields='$abc4',effect='$abc5' where id='$tid' $andlangbh limit 1";
			iquery($ss); 
 			
		jump($jumpv_back);
	
	}
if($act=='add' or $act=='edit'){  	
?>

 
 <form  onsubmit="javascript:return checkhere(this)" action="<?php  echo $jump_insertupdatefie;?>" method="post" enctype="multipart/form-data">
<table class="formtab">

  <tr>
    <td width="12%" class="tr">标题：</td>
    <td width="88%"><input name="name" type="text"   value="<?php echo $name;?>" class="form-control" />
    <?php echo $xz_must;?>
     </td>
  </tr>
  <tr>
    <td width="12%" class="tr">前台标题：</td>
    <td width="88%"><input name="namefront" type="text"   value="<?php echo $namefront;?>" class="form-control" />
    <?php echo $xz_maybe;?>
     </td>
  </tr>

    <tr>
    <td width="12%" class="tr">css名称：</td>
    <td width="88%"><input name="cssname" type="text"  value="<?php echo $cssname;?>" class="form-control" />
    <?php echo $xz_maybe;?>
     </td>
  </tr>
 

  <tr style="background:#dce8f4">
        <td class="tr fb">表单字段的来源：</td>
        <td class="select--TOinput--">  
   
   	
	自定义表单字段：<input name="cusfields" type="text"  value="<?php echo $cusfields;?>" class="form-control" />
	<?php echo $xz_maybe;

	if($cusfields<>'') {
		if(substr($cusfields,0,4)=='dmre'){
			$file = REGIONROOT.$cusfields;
			checkfile($file);
		}else  echo check_blockid($cusfields);

	}
	?>
	<p style="padding-bottom:15px">可以是prog或myprog文件 </p>

	<p class="cred">如果上面选项有值，则下面选项不起使用。</p>
  
        <?php
$type = 'form';
$filedir = BLOCKROOT.$type.'/';
$filearr = getFile($filedir);

$filedirself = TPLCURROOT.'selfblock/'.$type.'/';
//echo $filedirself;
if(is_dir($filedirself)) {
$filearr2 = getFile($filedirself);
$filearr = array_merge($filearr,$filearr2);
 }
 
echo  '<select name="effect">';
select_from_arr2($filearr,$effect,'');
 
echo '</select>';

 
?>

 

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
 