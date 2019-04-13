<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php
if($act=="update"){   
$jump_back = $jumpv_file.'&act=edit&tid='.$tid;

$updatev = 'y';
$langpathv =$domanv ='';   
if($abc1<>''){
  $sql = "SELECT id from ".TABLE_LANG." where langpath='$abc1' and id<>'$tid' order by id desc";
  $num = getnum($sql);             
  if($num>0)   { 
    alert('出错，后缀重复。');
    $updatev = 'n';
  }
  else  $langpathv =" ,langpath='$abc1' ";  
} else  $langpathv =" ,langpath='' ";  

if($abc2<>''){
  $sql = "SELECT id from ".TABLE_LANG." where domain='$abc2' and id<>'$tid' order by id desc";
  $num = getnum($sql);             
  if($num>0)   {
    alert('出错，域名重复。');
    $updatev = 'n';
  }
  else  $domanv =" ,domain='$abc2' ";  
}
else  $domanv =" ,domain='' ";

  if($updatev =='y')    { 
     $ss = "update ".TABLE_LANG." set  langfile='$abc3' $langpathv $domanv  where  pbh='".USERBH."' and id='$tid' limit 1";
      //echo $ss;exit;
       iquery($ss);
           //alert("修改成功");
  }
 jump($jump_back);   

}

else{

 $sql = "SELECT * from ".TABLE_LANG."  where  id='$tid' and pbh='".USERBH."'    order by id limit 1"; 
 
$row = getrow($sql);

	  
    $langpath=$row['langpath']; 
    $domain=$row['domain']; 
    $lang=$row['lang']; 
    $langfile=$row['langfile']; 
	
 
		$jump_insert=$jumpv_file.'&act=update&tid='.$tid;	
 
 
?> 




<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jump_insert;?>" method="post">
  <table class="formtab">
 
	
    

	<tr>
      <td class="tr">多语言的后缀：</td>
      <td> <input name="langpath" type="text" value="<?php echo $langpath?>" class="form-control" />
<p class="cgray">
(  
  后缀可以修改， <br />
比如www.yoursite.com/<span class="cred">en</span> 还是 www.yoursite.com/<span class="cred">english</span>
)
</p>
        </td>
    </tr>
 
    <tr>
      <td class="tr">多站点的域名：</td>
      <td> <input name="domain" type="text" value="<?php echo $domain?>" class="form-control" />
 
        </td>
    </tr>

<tr>
      <td class="tr">语言标识：</td>
      <td>  <?php echo $lang?>  (标识不能修改)
        </td>
    </tr>
 
 
    <tr>
      <td class="tr">替换语言文件：</td>
      <td> 
      <?php 
     // component/lang/'.$langfileV.'.php';
//echo $langfile;
$filedir = WEB_ROOT.'component/lang/'; 
echo ' <select name="template">';
 select_from_filearr($filedir,$langfile); 
echo '</select>'; 
 
?>
<br />
位于： component/lang 
 
        </td>
    </tr>


<tr>
      <td></td>
      <td>
      <input  class="mysubmit" type="submit" name="Submit" value="提交"></td>
    </tr>
  </table>
</form>
 
	
<?php } ?>
 
<script>
function  checkhere(thisForm){
	 
	//	if (thisForm.path.value==""){
		//alert("请输入路径");
	//	thisForm.path.focus();
	//	return (false);
    //    } 
		 
	
		
}

</script>


