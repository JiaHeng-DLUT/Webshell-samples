<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/
require_once '../config_a/common.inc2010.php';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump
 
if($pid<>''){
if($type=='common'  or $type=='page' or $type=='cate' or  $type=='read' or  $type=='tag'){
	// or  $type=='csubread'  -- no need csubread,bec useing read is enough
}
 else  {echo '出错的TYPE!';exit;}
}
$catename='';
if($type=='cate'  || $type=='read'){

	if($catid=='') {
		echo 'no catid...';exit;
	}
	else $catename = get_field(TABLE_CATE,'name',$catid,'pidname');
}
$alias= $title2 ='';
if($type=='page') {
	$alias= alias($pid,'page');
	//echo $alias;
}



$title ='页面布局管理';

  $pidstring = substr($pid,0,4);  
    if($pidstring=='comm') {$title2 ='公共布局';}
	else if($pidstring=='inde') {$title2 ='首页布局设置'; //no index.index by region
}
 else if($pidstring=='page') {
 	ifhaspidname(TABLE_PAGE,$pid);
 	$pagename = get_field(TABLE_PAGE,'name',$pid,'pidname');

 	$title2 ='<span style="color:blue">'.$pagename. '</span>的单页布局';

 }
  else if($pidstring=='cate') {
  			ifhaspidname(TABLE_CATE,$pid);
  			$pagename = get_field(TABLE_CATE,'name',$pid,'pidname');

  			if($type=='read') $title2 ='<span style="color:blue">'.$pagename.' </span>的<strong>详情页</strong>布局';
  			else   			$title2 ='<span style="color:blue">'.$pagename.' </span>的<strong>列表</strong>布局';
  		}
    
 else {
 	//echo 'pid出错!';exit;
 }

 $title2 .=' '.$pid; 


 if($type=='tag') $title2 = '标签';

 if($act <> "pos") zb_insert($_POST);
//

$jumpv='mod_layout.php?lang='.LANG;
//$jumpv='mod_layout.php?lang='.LANG.'&pid='.$pid.'&type='.$type;
$jumpv_file=$jumpv.'&file='.$file;



 
if($act=='del'){
	//ifsuredel_field(TABLE_,'pidname',$pidname,'equal',$jumpv_catid);
   
   //pre($_GET);  exit;
    
	$ss2 = "delete from ".TABLE_LAYOUT." where pid='$pid' and type='$type' and pidstylebh='$curstyle'   ".ANDLANGBH; 
	iquery($ss2);	
	$jumpv2 = $jumpv.'&pid='.$pid.'&catid='.$catid.'&type='.$type;
	jump($jumpv2);
		  
  }

  
if($act=='insert'){
	
	   $pidname='layout'.$bshou;
		 $ss = "insert into ".TABLE_LAYOUT." (pid,pidname,pidstylebh,pbh,lang,type,layoutcan,dateedit) values ('$pid','$pidname','$curstyle','$user2510','".LANG."','$type','$arr_layoutcan','$dateall')";
		 iquery($ss);
		 $jumpv2 = $jumpv.'&pid='.$pid.'&catid='.$catid.'&type='.$type;
		 jump($jumpv2);
	  }

 
	

require_once HERE_ROOT.'mod_common/tpl_header.php';

?>

<!-- Content Header (Page header) -->
<section class="content-header">
      <h1><?php echo $title?>      </h1>
     
</section>

 

 <section class="content">  


<?php 
require_once HERE_ROOT.'mod_layout/tpl_layout.php';
?>
 
</section>


 
<?php
require_once HERE_ROOT.'mod_common/tpl_footer.php';
?>
