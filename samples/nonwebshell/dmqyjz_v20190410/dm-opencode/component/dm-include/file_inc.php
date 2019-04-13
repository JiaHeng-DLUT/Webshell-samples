<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
}
 
if($file==''){
//$routeid= 33; 
 $alias='index';
 $filearr = filealias($alias);
$routeid= $filearr[0]; 
 $page = 1;
 require_once INCLUDE_ROOT.'file_page.php';//no use file_index.php	

} 

//else if($file=='404')  require_once INCLUDE_ROOT.'file_404.php';

else if($file=='404') { require_once BLOCKROOT.'tpl/page/page_404.php';}
else {
  //if ifalias =y,then judge file var by htaccess file...
  if($ifalias=='y'){ 
     if(substr($alias,0,9)=='---dmregion_'){
     	 // $seo1[0]= $alias;     	  
          /// require_once BLOCKROOT.'tpl/page/page_page_dmregion.php';
     }
     else {

		$filearr = filealias($alias);
		$routeid= $filearr[0]; 
		$detailid= $filearr[2]; 
	
		if(is_file($filearr[1])) require_once $filearr[1];
		else echo 'file not exist;';
	}
  
  }
  
  else {
  	     $filev = INCLUDE_ROOT.'file_'.$file.'.php';
  		 if(is_file($filev)) require_once $filev;
  		 else echo 'file not exist;';
	  }
} 
?>
<?php
function filealias($alias){  
global $andlangbh;global $noid;global $filearr; 
$sql = "SELECT pid from ".TABLE_ALIAS."  where  name='$alias' $andlangbh  order by id limit 1";	
		    //echo $sql;exit; 
		  if(getnum($sql)>0){ 
			$row=getrow($sql);
			//pre($row);
			$pidname=$row['pid'];
			$pidname4 = substr($pidname,0,4); $pidname3 = substr($pidname,0,3);
			 if($pidname3=='tag')  $pidname4 = 'tagg';

			if($pidname4=='page'){
				$sql2 = "SELECT id from ".TABLE_PAGE."  where  pidname='$pidname' $andlangbh  order by id limit 1";
				//echo $sql2;
				$row2=getrow($sql2);
				$routeid= $row2['id'];
				$reqfile =  INCLUDE_ROOT.'file_page.php';	
				$detailid='';				
				$filearr = array($routeid,$reqfile,$detailid);
				return $filearr;
				 
			}
			else if($pidname4=='tagg'){
				$sql2 = "SELECT id from ".TABLE_TAG."  where  pidname='$pidname' $andlangbh  order by id limit 1";
				//echo $sql2;
				$row2=getrow($sql2);
				$routeid= $row2['id'];
				$reqfile =  INCLUDE_ROOT.'file_tag.php';	
				$detailid='';				
				$filearr = array($routeid,$reqfile,$detailid);
				return $filearr;
				 
			}			
			else if($pidname4=='cate' || $pidname4=='csub'){ //no need use csub
				$sql2 = "SELECT id from ".TABLE_CATE."  where  pidname='$pidname' $andlangbh  order by id limit 1";
				$row2=getrow($sql2);
				$routeid= $row2['id'];	
				$detailid='';	
				$reqfile =  INCLUDE_ROOT.'file_category.php';				
				$filearr = array($routeid,$reqfile,$detailid);
				return $filearr;
				 
			}
			else if($pidname4=='node'){global $row_detail;
				$sql2 = "SELECT * from ".TABLE_NODE."  where  pidname='$pidname' $andlangbh  order by id limit 1";
				$row_detail=getrow($sql2);//$row_detail for system/syst_content_article_detail.php
				$detailid= $row_detail['id'];	
				$pid= $row_detail['pid'];
				$title_detail= $row_detail['title'];	
				$sta_noaccess= $row_detail['sta_noaccess'];
				if($sta_noaccess=='y') {echo $noaccess;exit;}
				//----------------
				$sql2 = "SELECT id from ".TABLE_CATE."  where  pidname='$pid' $andlangbh  order by id limit 1";
				$row2=getrow($sql2);
				$routeid= $row2['id'];	
				//echo '<br>'.$sql2.'<br>';
				
				//-----------------
				$reqfile =  INCLUDE_ROOT.'file_category.php';				
				$filearr = array($routeid,$reqfile,$detailid);
				return $filearr;
				 
			}
			 
			
		  }
		  else{fnoid();exit;}
  



}//end func
?>