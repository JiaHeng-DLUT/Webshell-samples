<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

?>
<?php

if($act=="insert"){    

		$sql = "SELECT id from ".TABLE_TAG." where name='$abc1'  order by id desc";
		$num2 = getnum($sql);
		 
		if($num2>0)
		{

			alert('出错，已存在这个标签。');
			jump($jumpv); 
		}
		else{

			$pidnamecur = 'tag' . $bshou; 
 
         	$ss = "insert into ".TABLE_TAG." (pidname,pbh,name,weight,lang) values ('$pidnamecur','$user2510','$abc1','$abc2','".LANG."')"; 
				//  echo $ss;exit;
			   iquery($ss);

	 
           jump($jumpv);  

		}


    
                        
}


if($act=="update"){  	 
 
		  $ss = "update " . TABLE_TAG . " set name='$abc1',weight='$abc2'  where  id='$tid'  $andlangbh limit 1";
    	 //echo $ss;exit;
    	    iquery($ss);  
	 
           jump($jumpv);  

    
                        
}
 if ($act=='edit') {
	 $sql = "SELECT * from " . TABLE_TAG . "  where  id='$tid'   $andlangbh order by id limit 1";
	    if(getnum($sql)>0){
	    	$row=getrow($sql);
	    	$name = $row['name'];
	    	$weight = $row['weight'];
	    	$jump_insert=$jumpv_file.'&act=update&tid='.$tid;
	    }
}
 if ($act=='add') {
	$name = '';
	$weight=1;
	$jump_insert=$jumpv_file.'&act=insert';
	}

 if ($act=='add' || $act=='edit') { 
	  
 	
?> 




<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jump_insert;?>" method="post">
  <table class="formtab">
 
	
    <tr>
      <td width="20%" class="tr">标题</td>
      <td width="78%">

 <input name="name" type="text" value="<?php echo $name;?>" class="form-control" >
 
<?php echo $xz_must;?>
        </td>
    </tr>

	<tr>
      <td class="tr">权重：</td>
      <td> 

        <select name="weight">
                    <?php select_from_arr($arr_tag,$weight,'');?>
                  </select>
 
 <br />
 <span class="cgray">权重只是影响前台标签显示 </span>
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
	 
		if (thisForm.name.value==""){
		alert("请输入标题");
		thisForm.name.focus();
		return (false);
        } 

        if (thisForm.weight.value==""){
		alert("请选择权重");
		thisForm.weight.focus();
		return (false);
        } 
	 
		
}

</script>


