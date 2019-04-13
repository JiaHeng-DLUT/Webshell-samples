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


		$sql = "SELECT id from ".TABLE_LANG." where lang='$abc1'  order by id desc";
		$num1 = getnum($sql);
 
		if($num1>0)
		{

			alert('出错，已存在这个站点-'.$abc1);
			jump($jumpv); 
		}
		else{


		$sql = "SELECT id from ".TABLE_STYLE." where lang='$abc1'  order by id desc";
		 
		if(getnum($sql)==0)
		{
			//insert mb,bec a lang need a mb

					  $stylepidname='style'.$bshou;
					  $title = $abc1.' mb';
   
			  $ss = "insert into ".TABLE_STYLE." (pidname,pbh,pid,pidmenu,pidregion,title,lang,dateedit,htmldir,style_hf,style_blockid) values ('$stylepidname','$user2510','0','pidmenu','pidregion','$title','$abc1','$dateall','htmldir','$arr_style_hf','$arr_styleblockidV')"; 
					 // echo $ss;exit;
					   iquery($ss);

		}

        $arr_assets = 'cdnurl:##==#==sta_cdn:##n==#==jquery:##==#==compressjs:##==#==compresscss:##==#==bootstrapjs:##==#==bootstrapcss:##';
        $arr_map ='map_title:##DM企业建站系统==#==map_desp:##企业建站，就选DM企业建站系统 www.demososo.com==#==map_x_wei:##121.481033==#==map_y_jing:##31.238802';
        $arr_basicset='editor:##ck==#==ico:##==#==sta_frontedit:##y==#==cssversion:##==#==tag_title:##标签tag==#==tag_fg:##tag_grid.php==#==sta_tag_shownum:##y==#==sta_colseresponsive:##n==#==linkofmobile:##==#==searchtext:##';
        $arr_smtp='smtp_active:##n==#==smtp_server:##smtp.163.com==#==smtp_port:##25==#==smtp_email:##......@163.com==#==smtp_ps:##';
			
			$ss = "insert into ".TABLE_LANG." (lang,sitename,pbh,curstyle,arr_assets,arr_map,arr_basicset,arr_smtp) values ('$abc1','$abc2','$user2510','$stylepidname','$arr_assets','$arr_map','$arr_basicset','$arr_smtp')";
		 //	echo $ss;exit;
		    iquery($ss);
		    alert("添加成功，请通过 修改功能  配置其他的参数。");
		    jump($jumpv);  

		}


    
                        
}

else {
	 

		$jump_insert=$jumpv_file.'&act=insert';
 	
?> 




<form  onsubmit="javascript:return checkhere(this)" action="<?php echo $jump_insert;?>" method="post">
  <table class="formtab">
 
	
    <tr>
      <td width="20%" class="tr">选择站点(语言)ID:</td>
      <td width="78%">


<select name="lang">
  <option value="">请选择</option>

  <?php 
   foreach ($arr_lang as $k=>$v) {

   	    $sql = "SELECT id from ".TABLE_LANG." where lang='$k'  order by id desc";
		 
		if(getnum($sql)>0) $ifexist = '(已存在)';
		else  $ifexist = '';
		 
   	    echo '<option value="'.$k.'">'.$k.'('.$v.')'.$ifexist.'</option>';
   }

 ?>

 </select>
 

 
<?php echo $xz_must;?>
        </td>
    </tr>
 
  
	<tr>
      <td class="tr">网站名称：</td>
      <td> 
      
       <input  type="text"  class="form-control"  name="sitename" value=""  ><?php echo $xz_must;?>
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
	 
		if (thisForm.lang.value==""){
		alert("请选择语言");
		thisForm.lang.focus();
		return (false);
        } 

        
		if (thisForm.sitename.value==""){
		alert("请输入网站名称");
		thisForm.sitename.focus();
		return (false);
        } 
	 
		
}

</script>


