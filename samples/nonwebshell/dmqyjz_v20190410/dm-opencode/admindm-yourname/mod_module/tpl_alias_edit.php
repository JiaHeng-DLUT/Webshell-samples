<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

exit;
//-------------
 if($act=="edit"){
 

	if($abc1==''){
		   alert('别名不能为空。如果要删除别名，请到别名管理里操作。');
   }
   else{
   			 $sqlalias = "SELECT * from ".TABLE_ALIAS."  where  name='$abc1' $andlangbh and pid<>'$pid' order by id limit 1";	
			//echo $sqllayout;exit; 

				  if(getnum($sqlalias)>0){ 
					 echo '<p class="hintbox">提示：<br>别名已存在。</p>'.$backlist;exit;
				  }else{	
                        $sqlalias = "SELECT id from ".TABLE_ALIAS."  where  pid='$pid' $andlangbh   order by id limit 1";
                        if(getnum($sqlalias)>0) 
                        	$ss = "update ".TABLE_ALIAS." set name='$abc1' where pid='$pid' $andlangbh limit 1";
                        else 	
                        	$ss = "insert into ".TABLE_ALIAS." (pid,pbh,lang,type,name) values ('$pid','$user2510','".LANG."','$type','$abc1')"; 
				  		// echo $ss;exit;
						iquery($ss);  
					} 
	}	 

  $jumpv = $jumpv.'&type2='.$type2.'&file=edit';
 jump($jumpv);	 	
		
 }
 
if($act=="list"){
 
 $jumpv_update_here = $jumpv.'&act=edit&file=edit&tid='.$tid.'.&type2='.$type2;
 
    ?>
 
<form onsubmit="return formvalidate()"   action="<?php  echo $jumpv_update_here;?>"   method="post" enctype="multipart/form-data">
<table class="formtab">



  <tr>
    <td width="12%" class="tr">别名：</td>
    <td width="88%"><br /><input name="alias" type="text"  value="<?php echo $name;?>" class="form-control" />
	
	<p class="hintbox">提示：<br>
	  (只能用英文和数字，不能有空格和一杠，多个字符，请用下划线连接) 
<br />(<strong>主分类必须要有别名</strong>，其他子分类或菜单等没有的话可以不填。)
 
	</p>
	

	</td>
  </tr>

  <tr>
    <td></td>
    <td> <input class="mysubmit" type="submit" name="Submit" value="提交">

<br /><br /><br /><br /><br />
<?php 
if($type2=='fromlist') echo '<a href="'.$jumpv_list.'">返回别名管理>></a>';
else  echo '<a href="'.$jumpv_list.'" target="_blank"><span style="color:red;font-size:16px">别名管理>></span>（搜索，修改，删除别名等）</a>';

?>

    </td>
  </tr>
 </table>
</form>
	 

	 
 
<?php } 
 
?>
 

 <script>
function formvalidate(){
    var valias = $.trim($('.formtab input[name=alias]').val());
     if(valias=='') {alert('别名不能为空。如果要删除别名，请到别名管理里操作。'); 
     	$('.formtab input[name=alias]').focus();
   		  return false;}

    var v = '=='+valias;
    var indexv = v.indexOf('-');
    if(indexv!=-1)  {alert('别名不能有杠，可以有下划线。'); return false;}

     var indexv = v.indexOf(' ');
    if(indexv!=-1)  {alert('别名不能空格，可以有下划线。'); return false;}



}

 </script>