<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

 if($act=='update'){  
	 		     $subcate = get_fieldarr(TABLE_CATE,$pidname,'pidname');
				   if($subcate=='no'){echo '分类不对。';exit;}
				    else{
				    	$thename = $subcate['name'];
				    	$thelast = $subcate['last'];
				    }

				    if($thelast=='n')
				    	{ echo '<p>对不起，它有子分类，请先转移它的子分类。</p>';
				  		  exit;
						}

  //echo $abc1;
		  $sql = "select id,ppid,pid,pidname,title from  ".TABLE_NODE." where ppid='$catid' and pid='$pidname' $andlangbh order by pos desc,id";
		  if(getnum($sql)>0){
		  	  $res = getall($sql);
		  	  foreach ($res as $key => $v) { 
		  	  	    $pidnamecur = $v['pidname'];
		  	  	 	$ss = "update ".TABLE_NODE." set ppid='$abc1'   where pidname='$pidnamecur' $andlangbh limit 1";
					 iquery($ss); 

				  	 // $title = $v['title'];
				  	  //echo $ss.'<br>';
				  	  	# code...
		  	  } //end foreach

		  	  $ss = "update ".TABLE_CATE." set pid='$abc1'   where pidname='$pidname' $andlangbh limit 1";
					 iquery($ss); 

					  echo '<p><i class="fa fa-thumbs-o-up"></i> 转移成功！</p>';

		  } //if num>0
		  else {echo '<p><i class="fa fa-exclamation-circle cyel"></i> 要转移的分类还没有内容！</p>';exit;}
          
         


}

  if($act=='edit')	{  
   
  $moveactionupdate = $jumpvfp.'&act=update';;
	 
 
  echo '<p>本功能，可以把没有子分类的分类转移到其他主分类。  如果有子分类，请先转移它的子分类。<br /><span class="cred">同时，此分类下的内容也会转移过去。但内容还是位于此分类下。</span></p>';
  
   $subcate = get_fieldarr(TABLE_CATE,$pidname,'pidname');
   if($subcate=='no'){echo '分类不对。';exit;}
    else{
    	$thename = $subcate['name'];
    	$thelast = $subcate['last'];
    }
    if($thelast=='n'){ echo '<p>对不起，它有子分类，请先转移它的子分类。</p>';
    exit;

}
 
  ?>
<form  onsubmit="javascript:return checkhere(this)"  action="<?php  echo $moveactionupdate;?>" method="post" enctype="multipart/form-data">
<table class="formtab">

 
<tr>
    <td width="12%" class="tr">选择分类的父级：</td>
    <td width="88%">
	<?php	
 $sql_sel = "select pidname,name from  ".TABLE_CATE." where modtype='node' and pid='0' and pidname<>'$catid' $andlangbh order by pos desc,id desc";
    $rowlist_sel = getall($sql_sel);
	//echo $sql_sel;exit;	
	?>
 <select name='selecate' class="form-control">
 <option  value=''>请选择主分类：</option>
<?php 
   foreach ($rowlist_sel as $vcla){  //by pidname is father.
			$opt_pidname=$vcla['pidname'];	
			$optname=$vcla['name'];

	  echo '<option value='.$opt_pidname.'>'.$optname.'</option>';
					 
			}
 
		?>
 </select> 
 

 </td>
  </tr> 
  <tr>
    <td></td>
    <td> <input class="mysubmit" type="submit" name="Submit" value="转移"></td>
  </tr>
 </table>
</form>

<?php
} 
?>

 
 <script>
function checkhere(thisForm) {
   if (thisForm.selecate.value=="")
  {
    alert("请选择主分类。");
    thisForm.selecate.focus();
    return (false);
  }
   

   // return;

}
 

</script>

