<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}




$sql_detail = "SELECT * from ".TABLE_NODE."  where  id='$page' $andlangbh  order by id limit 1";
	 $row_detail=getrow($sql_detail);	//$row_detail for system/syst_content_article_detail.php	
 if($row_detail=='no') {fnoid();exit;}	




  $alias_jump = $row_detail['alias_jump'];
  $title = $row_detail['title'];
   


  //echo $alias_jump;

 
?>
<html>
<head>
<title><?php echo $title;?></title>
	<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<script src="http://www.demososo.com/DM-static/app/jq/jquery.js" type="text/javascript"></script>
 	 <style>
body{  margin:0;padding:0 }
 </style> 
 <script>
 
 $(function(){
	 var height = $( window ).height(); 
	 if($( window ).width>800) height = height -2;
	    
	 $('iframe').height(height); 
	 
	 
 });
 
 </script>
 </head>
 <body>
 <iframe   frameborder="0" vspace="0" hspace="0" style="width:100%;height: 100%" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen="" scrolling="auto" src="<?php echo $alias_jump;?>"></iframe>

 <style>
body{ margin:0; }
 </style> 

</body>
</html>