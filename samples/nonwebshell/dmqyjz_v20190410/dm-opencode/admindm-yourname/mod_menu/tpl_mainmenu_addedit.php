<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
//'  category sub can set page content.';

 
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
//---------------------
if($act == "insert")
{
    
   if(strlen(trim($abc1))<2){
        alert(' 不能为空或字太少');
        jump($jumpv);
    }

$pidname='menu'.$bshou;

    $ss = "insert into ".TABLE_MENU." (ppid,pid,pidname,name,sta_cusmenu,cusmenudesp,pbh,lang) values ('0','main','$pidname','$abc1','$abc2','$abc3','$user2510','".LANG."')"; 
     // echo $ss;exit;  
    iquery($ss);     

    //alert('添加成功!');
    jump($jumpv);
  
} 

if($act == "update")
{
    
   if(strlen(trim($abc1))<2){
        alert(' 不能为空或字太少');
        jump($jumpv);
    }
$ss = "update ".TABLE_MENU." set  name='$abc1',sta_cusmenu='$abc2',cusmenudesp='$abc3'  where ppid='0' and id='$tid' $andlangbh limit 1";
 //echo $ss;exit;  
  iquery($ss);    
 
    jump($jumpv);
  
} 
 

 
if($act == "add")
{
  $sta_cusmenu = 'n';  
 $cusmenudesp = ''; 
} 
if($act == "edit")
{
     $ss = "select * from ".TABLE_MENU." where id='$tid' and ppid='0' $andlangbh limit 1"; 
  $row = getrow($ss);
  if($row=='no') {echo 'no record ...';exit;}
  $name= $row['name'];
  $sta_cusmenu= $row['sta_cusmenu'];
  $cusmenudesp= $row['cusmenudesp'];
  
  $jumpvinsert = $jumpvupdate.'&tid='.$tid;

} 
?>

 
<?php 
 
if($act=="add" || $act=="edit"){
?>
 
<form  onsubmit="javascript:return checkhere(this)" method="post"   action="<?php echo $jumpvinsert?>">
<table class="formtab">
  <tr>
    <td width="20%" class="tr">菜单组的名称：</td>
    <td >

    <input name="name" type="text"  value="<?php echo $name?>" class="form-control" /> <?php echo $xz_must;?>
      </td>
  </tr>


   <tr>
      <td class="tr">是否启动自定义：</td>
      <td> <select name="sta_cusmenu">
    <?php select_from_arr($arr_yn,$sta_cusmenu,'');?>
     </select>
  <br /> <span class="cgray"> (默认不启动)</span>
      </td>
      </tr>

   <tr>
    <td class="tr">菜单内容：</td>
    <td>
 
<textarea class="form-control" id="editor1" name="cusmenudesp" rows="30">
<?php echo $cusmenudesp;?>
</textarea>
      </td>
  </tr>
 


  <tr>
    <td></td>
    <td> <br />
  <br />
 
  <input class="mysubmit" type="submit" name="Submit" value="提交" />
</td>
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
    alert("请输入菜单组的名称");
    thisForm.name.focus();
    return (false);
  } 
   
}

</script>

 

