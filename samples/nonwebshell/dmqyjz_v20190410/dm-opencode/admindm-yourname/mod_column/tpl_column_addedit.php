<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
 
if($act=='insert')
 {
  
 //if($abc1=="") $abc1 = 'pls input title'; 

  $pidname='colu'.$bshou;
 

			$ss = "insert into ".TABLE_COLUMN." (pid,pidname,pbh,type,name,width,floattype,onlyposi,lang) values ('$pid','$pidname','$user2510','$type','$abc1','$abc2','$abc3','$abc4','".LANG."')";
			 //echo $ss;exit;
			iquery($ss);
			//alert('添加成功！');			 
			jump($jumpv);
			
 
 }
 if($act=='update')
 {
   if(@$_POST['inputmust']=='') {echo $inputmusterror.$backlist;exit;}

  // if($abc1=="") $abc1 = 'pls input title'; 

 $ss = "update ".TABLE_COLUMN." set name='$abc1',width='$abc2',floattype='$abc3',onlyposi='$abc4' where pid='$pid' and id='$tid' $andlangbh limit 1";

 //echo $ss;exit;
			iquery($ss); 	
		 
			 jump($jumpvf.'&act=edit&tid='.$tid);
	 	
 }
 
 
 if($act=='add')
 { $titleh2= '添加列';
 
  $jumpvinsert = $jumpvf.'&act=insert'; 
   $name= '标题';
$width=$floattype='';
 $onlyposi='n';
 
 
 }
 
 if($act=='edit')
 {
 $titleh2= '修改列';
  
 $jumpvinsert = $jumpvf.'&act=update'.'&tid='.$tid; 
 
$sql = "SELECT * from ".TABLE_COLUMN."  where id='$tid'   $andlangbh order by id limit 1";
$row222 = getrow($sql);
if($row222=='no'){echo 'no record...';exit;}
//$desp=zbdesp_imgpath($row['desp']);
$name= $row222['name']; 
 $width= $row222['width']; 
 $floattype= $row222['floattype']; 
 $onlyposi= $row222['onlyposi']; 
 
}

 if($act=='add' or $act=='edit')
 {

  
?>
 
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpvinsert?>" method="post">
  <table class="formtab">
    <tr>
      <td width="22%" class="tr">列的标题：</td>
      <td width="77%"> <input name="name" type="text" value="<?php echo $name?>" class="form-control" />

      <br />
      <span class="cgray">这个标题不会在前台显示 </span>
       </td>
    </tr>
    <tr>
      <td width="22%" class="tr">列的宽度：</td>
      <td width="77%">
       <select name="width">
            <?php select_from_arr($arr_columnwidth,$width,'');?>
     </select> 
       </td>
    </tr>
<tr>
      <td width="22%" class="tr">浮动类型：</td>
      <td width="77%">
       <select name="floattype">
            <?php select_from_arr($arr_columnfloat,$floattype,'');?>
     </select> 
       </td>
    </tr>

 
  <tr>
      <td width="22%" class="tr">无内容，只占位置：</td>
      <td width="77%">
      <select name="block">
            <?php select_from_arr($arr_yn,$onlyposi,'');?>
     </select>
      
      <br />
      (不能更改)
       </td>
    </tr>



 
 
<tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="<?php echo $titleh2;?>"></td>
    </tr>
  </table>
  <?php echo $inputmust;?>
</form>

 

<?php
}
?>

<script>
function checkhere(thisForm) {
   if (thisForm.name.value=="")
	{
		alert("请输入标题。");
		thisForm.name.focus();
		return (false);
	}
  
  

   // return;

}
 

</script>
