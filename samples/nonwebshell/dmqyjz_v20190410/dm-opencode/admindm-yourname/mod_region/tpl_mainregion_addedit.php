<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

if($act=='insert')
 {
  if($abc1=="") {
  	$abc1 = 'pls input title'; exit;
  }

  $pidname='region'.$bshou;
 

			$ss = "insert into ".TABLE_REGION." (pid,pidstylebh,pidname,pbh,name,lang,dateedit) values ('0','$ppid','$pidname','$user2510','$abc1','".LANG."','$dateall')";
			  //echo $ss;exit;
			iquery($ss);
			//alert('添加成功！');			 
			jump($jumpv);
			
 
 }
 if($act=='update')
 {
     if($abc1=="")  {
	  	$abc1 = 'pls input title'; exit;
	  }

	  $addcss =  htmlentitdm(@$_POST['addcss']);
	  $addcss=str_replace("\\","/",$addcss);
	  $addcss=str_replace(chr(13),"|",$addcss);
	  $addcss=str_replace(chr(32),"",$addcss);
   
	  $addjs =  htmlentitdm(@$_POST['addjs']);
	  $addjs=str_replace("\\","/",$addjs);
	  $addjs=str_replace(chr(13),"|",$addjs);
	  $addjs=str_replace(chr(32),"",$addjs);

 
			 $ss = "update ".TABLE_REGION." set name='$abc1',dmregdir='$abc2',addcss='$addcss',addjs='$addjs' where id='$tid'  $andlangbh limit 1";
			iquery($ss); 	
			$jumpv = $jumpvedit.'&tid='.$tid; 
			 jump($jumpv);
	 	
 }
 
 
 if($act=='add')
 { $titleh2= '添加区域'; 
 $name=$addcss=$addjs=''; 
 }
 
 if($act=='edit')
 {
 $titleh2= '修改区域';
  
 $jumpvinsert = $jumpvupdate.'&tid='.$tid; 
 
$sql = "SELECT * from ".TABLE_REGION."  where id='$tid'   $andlangbh order by id limit 1";
$row = getrow($sql);
if($row=='no'){echo 'no record...';exit;}
//$desp=zbdesp_imgpath($row['desp']);
$name= $row['name']; $dmregdir=$row['dmregdir'];

$addcss=$row['addcss'];
$addcss=str_replace("|",chr(13),$addcss);
$addjs=$row['addjs'];
$addjs=str_replace("|",chr(13),$addjs);

 }

 if($act=='add' or $act=='edit')
 {
?>
 
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpvinsert?>" method="post">
  <table class="formtab">
    <tr>
      <td width="22%" class="tr">页面区域标题：</td>
      <td width="77%"> <input name="name" type="text" value="<?php echo $name?>" class="form-control" />
       </td>
    </tr>


 <?php  
 if($ppid=='dmregion' && $act=='edit'){
  ?>
  <tr>
      <td width="22%" class="tr"> 位于DM-region的目录：</td>
      <td width="77%"> <input name="dmregdir" type="text" value="<?php echo $dmregdir?>"  size="35" />
      <?php 
      if($dmregdir<>''){
        $dir22 = REGIONROOT.$dmregdir;
        if(!is_dir($dir22)) echo '<span style="color:red">目录不存在</span>';
      }
      ?>
       </td>
    </tr>

  <?php
}
  ?>
  <?php


    if($act=='edit')    require_once HERE_ROOT.'mod_style/plugin_style_addcssjs.php';
 ?>

<tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="<?php echo $titleh2;?>"></td>
    </tr>
  </table>
</form>

 

<?php
}
?>

<script>
function checkhere(thisForm) {
   if (thisForm.name.value=="")
	{
		alert("请输入页面区域标题。");
		thisForm.name.focus();
		return (false);
	}
  
  

   // return;

}
 

</script>
