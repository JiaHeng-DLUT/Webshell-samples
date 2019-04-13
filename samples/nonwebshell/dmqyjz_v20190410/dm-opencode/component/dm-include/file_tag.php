<?php
/*
	made by cmsmeng.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
} 
?>
<?php 	
$modtype='tag';	
//------------------
$sql="select * from ".TABLE_TAG." where id='$routeid'  $andlangbh limit 1"; 
	if(getnum($sql)>0){
		$row=getrow($sql); 
		$tagpidname=$row['pidname']; 
		$curpagetitle = $title = $tag_name=$row['name']; 
		
		 $seotitle = $tag_title.' '.$tag_name;//$tag_title in admin 
		 
		$seo1v=$row['seo1'];
		$seo2v=$row['seo2'];
		$seo3v=$row['seo3'];	
        $cururllink = $page_canshu= get_url($row);
		$breadarr[0] =  get_link($cururllink,$title,'');

		 if($seo1v<>''){ $seo1[0] =$seo1v;} else  $seo1[0] =strip_tags($title);
		if($seo2v<>''){ $seo2[0] =$seo2v;} else  $seo2[0] =strip_tags($title);
		if($seo3v<>''){ $seo3[0] =$seo3v;} else  $seo3[0] =strip_tags($title);

 			$bannertitle = $title;
 			$pagetemplate='';
         layoutcur('tag','tag');  //replace in layout.php

	}
	else{ fnoid();exit;
	}

 	 //for pagerlink
	 // $page_canshu = 'tag-'.$routeid.'.html';	
		
?>
<?php 
$bodycss = "taglinkwrap";	
  
//------------
 
		if($pagetemplate<>'') {
		  $reqfile =  TPLCURROOT.'/tpl/page/'.$pagetemplate; 
		}
		 else {
		 	$reqfile =  TPLCURROOT.'/tpl/page/page_tag.php'; 
		 	if(!is_file($reqfile))  $reqfile = BLOCKROOT.'/tpl/page/page_tag.php';  
		 	
		 }  
		
if(checkfile($reqfile))  require  $reqfile; 
 
?>