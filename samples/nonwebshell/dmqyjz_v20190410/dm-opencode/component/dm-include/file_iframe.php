<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}




$sql_detail = "SELECT * from ".TABLE_NODE."  where  id='$alias' $andlangbh  order by id limit 1";
	 $row_detail=getrow($sql_detail);	//$row_detail for system/syst_content_article_detail.php	
 if($row_detail=='no') {fnoid();exit;}	




  $alias_jump = $row_detail['alias_jump'];
   


  //echo $alias_jump;

 
?>

 
 
 <iframe   frameborder="0" vspace="0" hspace="0" style="width:100%;height: 100%" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" scrolling="auto" src="<?php echo $alias_jump;?>"></iframe>

 <style>
body{ margin:0; }
 </style> 
