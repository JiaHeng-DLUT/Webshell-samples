<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

if($act=='insert')
 {
  if($abc1=="") { echo 'pls input title'; exit;}

  $pidname='group'.$bshou;
  
			$ss = "insert into ".TABLE_BLOCKGROUP." (pid,pidname,pbh,name,cssname,sta_width_cnt,lang,dateedit) values ('0','$pidname','$user2510','$abc1','$abc2','$abc3','".LANG."','$dateall')";
			 //echo $ss;exit;
			iquery($ss);
			//alert('添加成功！');
			//jump($jumpvf.'&act=edit&pidname='.$pidname);
			jump($jumpv);
			
 
 }
 if($act=='update')
 {
    if($abc1=="") {$abc1='pls input title'; exit;}
 
			 $ss = "update ".TABLE_BLOCKGROUP." set name='$abc1',cssname='$abc2',sta_width_cnt='$abc3' where id='$tid' $andlangbh limit 1";
			iquery($ss); 	
		 
			 jump($jumpvf.'&act=edit&tid='.$tid);
	 	
 }
 
 
 if($act=='add')
 { $titleh2= '添加';
 
 $jumpv_insert = $jumpvf.'&act=insert';
 $name=$cssname='';
 $sta_width_cnt = $pidstylebh = 'n';
 
 }
 
 if($act=='edit')
 {
 $titleh2= '修改';
  $jumpv_insert =  $jumpvf.'&tid='.$tid.'&act=update';
   $sta_sub = 'y';

$sql = "SELECT * from ".TABLE_BLOCKGROUP."  where id='$tid'   $andlangbh order by id limit 1";
$row222 = getrow($sql);
if($row222=='no'){echo 'no record...';exit;}

$name= $row222['name']; $cssname= $row222['cssname']; 
$pidstylebh= $row222['pidstylebh']; 
  
   if($pidstylebh<>'y')  $pidstylebh='n';

$sta_width_cnt= $row222['sta_width_cnt'];
 
}

 if($act=='add' or $act=='edit')
 {
?>
 
<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jumpv_insert?>" method="post">
  <table class="formtab">
    <tr>
      <td width="22%" class="tr">组合区块名称：</td>
      <td width="77%"> <input name="name" type="text" value="<?php echo $name?>" class="form-control" />
       <?php echo $xz_must;?>
       </td>
    </tr>

 
 <tr>
      <td width="22%" class="tr"> <?php echo $text_cssname; ?></td>
      <td width="77%">
           <input name="cssname" type="text" value="<?php echo $cssname?>" class="inputcss form-control" />
            <?php echo $xz_maybe;?>
       </td>
    </tr>
 

     <tr>
      <td width="22%" class="tr">是否全宽：</td>
      <td width="77%">
          
               
               <select name="sta_width_cnt">

         <?php select_from_arr($arr_yn,$sta_width_cnt,'plsno');?>
     </select>
     <br />

     <span class="cgray">比如侧边栏等不用container，则选 "是" </span>
       </td>
    </tr>
 

 
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
		alert("请输入组合区块名称。");
		thisForm.name.focus();
		return (false);
	}
   

   // return;

}
 

</script>
