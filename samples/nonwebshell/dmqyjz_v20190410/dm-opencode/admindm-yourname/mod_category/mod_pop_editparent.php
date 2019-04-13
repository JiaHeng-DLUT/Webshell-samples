<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
  
*/

require_once '../config_a/common.inc2010.php';
$menu_content = 'y';
ifhave_lang(LANG);//TEST if have lang,if no ,then jump



 

if($act <> "pos") zb_insert($_POST);
 
 
 ifhaspidname(TABLE_CATE,$pidname);

 

/************************/
 
$jumpv='mod_pop_editparent.php?lang='.LANG.'&pidname='.$pidname;
 

$title = '修改父级';

 //-----------------

 $pidarr = get_fieldarr(TABLE_CATE,$pidname,'pidname');
$catid= $pidarr['ppid'];
$pidhere= $pidarr['pid'];
$catname = get_field(TABLE_CATE,'name',$catid,'pidname');
$catnamesub = get_field(TABLE_CATE,'name',$pidhere,'pidname');
 $pidnamehere = $pidname;
//-------------------
if($act=='update'){

  echo 'adsadfsfsdadfs';
  $ss = "update ".TABLE_CATE." set pid='$abc1'  where pidname='$pidname' $andlangbh limit 1"; 
			iquery($ss); 	
		    jump($jumpv);
  
        
  
}



require_once HERE_ROOT.'mod_common/tpl_header_iframe.php';
?>
<!-- Content Header (Page header) -->
<section class="content-header">


</section>
 
 <section class="content">
 
     
 <form action="<?php  echo $jumpv;?>&act=update" method="post" enctype="multipart/form-data">   

<p  class="treearr_select_input_catename">父级名称：<span class="fb cblue"><?php echo $catnamesub;?></span>
    <input class="treearr_select_input" name="treearr_select_input" type="text"  value="<?php echo $pidhere?>" size="35"  />
    </p>
    <input class="mysubmit" type="submit" name="Submit" value="提交"></td>
 </form>

 <br> <br> 
  
 <span class="cp treearr_select_go fb cblue">选择分类的父级></span>

<?php 
 
function echoarrhtml($tree,$multicate='',$i=1)
{
 global $pidnamehere;   global $pidhere;
 //echo $pidhere.'---<br>';
$html = '';
 
foreach($tree as $vsub)
{
	
	$name =  $vsub['name']; 
	$tid=$vsub['id'];  $jsname = jsdelname($vsub['name']);
	$level=$vsub['level'];$last=$vsub['last']; 
  
	$pidname=$vsub['pidname']; 
	$pid=$vsub['pid'];  $sta_visiblevv=$vsub['sta_visible']; 
	
	$alias_jump=$vsub['alias_jump'];   		   
	$aliascc = alias($pidname,'cate');	
  //echo $pid.'===<br>';
 $classv = ($pidname == $pidhere )?' active':''; 
 $cureditv = ($pidname == $pidnamehere)?' class=" cureditparent"':''; 
 //cureditparent use for js,not select sub as parent
 $classhidev = $sta_visiblevv<>'y'?' hidediv':'';

 $namecur = ($pidname == $pidnamehere )?'<span class="cred">[当前]</span>':'';
 $namecur2 = ($pidname == $pidnamehere )?' activecur':''; //for js judge when nomulticate

  $name = $sta_visiblevv<>'y'?$name.' &nbsp; &nbsp;[隐藏]':$name;
  $name = $name.$namecur;
 $levelv= 'level_'.$i;///for nomulticate js judge
  if(@$vsub['son'] == '')
  {
   $html .= '<li'.$cureditv.'>├ <span  class="'.$levelv.$classv.$classhidev.$namecur2.'" id="'.$pidname.'">'.$name.'</span></li>';  //span for js,avoid li
  }
  else
  { 
   $html .= '<li'.$cureditv.'>├ <span  class="'.$levelv.$classv.$classhidev.$namecur2.'" id="'.$pidname.'">'.$name.'</span>';
    
   if(MULTICATE=='y' || $multicate=='')  $html .= echoarrhtml($vsub['son'],MULTICATE,2);
   $html = $html."</li>";
  }
}

 return $html ? '<ul class="tree">'.$html.'</ul>' : $html ;
 // return $html;
}


echo '<div class="treearr_select jstreearr_select" style="display:none2">';
echo '<strong>(主类) <span class="cp" id="'.$catid.'">'.$catname.'</span></strong>';
$sqlsub = "SELECT * from ".TABLE_CATE." where  ppid='$catid' $andlangbh order by pos desc,id";
 $rowlistsub = getall($sqlsub);
 if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有分类，请添加...</p>';
  }
  else{

  	
			$indexarr = indexingarr($rowlistsub);
			$getnewarr = getnewtreearr($indexarr);
		 	//pre($getnewarr);
 $nomulticate = MULTICATE=='y'?'hasmulticate':'nomulticate';
  echo '<div class="treearr '.$nomulticate.'"> ';
          
    		 echo   echoarrhtml($getnewarr);
    	 

  echo '</div>';
}
echo '</div>';


 ?>

 



 
       

 </section>


<?php 

require_once HERE_ROOT.'mod_common/tpl_footer_iframe.php';

?>
