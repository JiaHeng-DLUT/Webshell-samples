<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
require_once '../config_a/common.inc2010.php';
//
 if($act <> "pos") zb_insert($_POST);


ifhave_lang(LANG);//TEST if have lang,if no ,then jump

$title='css dao';


 
	 
  $typearr =  array("import", "export");   
  if(!in_array($type,$typearr))   {echo 'type is error.';exit;}
 


//-----------

require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';

?>
<style>
 table.formtab { margin-bottom:0 }

</style>

<div  class="showblockid cntwrap">

  <?php 
    $sql = "SELECT style_hf from ".TABLE_STYLE." where pidname='$pid'  limit 1";
   if(getnum($sql)>0){
	   
			  if($type=='export'){
				   
				  
				  $row = getrow($sql);
				  $style_hf = $row['style_hf'];
				 // echo $style_hf;
				 echo '<p>导出如下：</p>';
				  echo '<textarea cols="111" rows="11">'.$style_hf.'</textarea>';
			  
			  }
			  
			  
			  //-------import----------------------
			   if($type=='import'){
				
				
				if($act=='update'){
					
					if(strlen($abc1)<20){
						echo '出错，内容字符太少。';
					}
					else {
					$ss = "update ".TABLE_STYLE." set style_hf='$abc1' where pidname='$pid' $andlangbh limit 1";
					   //echo $ss;exit;    
					   iquery($ss);  
   
					echo '导入成功。';
					}
				}
				else{
					$jumpv_insert='mod_dao_css.php?lang='.LANG.'&type='.$type.'&pid='.$pid.'&act=update';
					echo '<p>请在下面输入内容：</p>';
					echo '<form   action="'.$jumpv_insert.'" method="post" enctype="multipart/form-data">
 ';
				  echo '<textarea name="css" cols="111" rows="11"></textarea>';
				  echo '<p><input  class="mysubmit" type="submit" name="Submit" value="提交" /></p></form>';
				}
				//-----
				  
			  }
			  
  //----------------
  
   
   }  
	  else echo 'style pidname is error.';

  ?>
  
  
  
  
 
</div> <!--end cntwrap--> 
<div  class="c"> </div>

 <?php
require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

?>
