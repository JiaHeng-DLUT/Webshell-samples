<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

 
?>
 <div class="contenttop">
  <a class="needpopup" href="<?php echo $jumpvaddcatepop1?>"><i class="fa fa-plus-circle"></i> 添加子分类 </a>
</div>


 
<form method=post action="<?php echo $jumpv;?>&act=subpos">


<?php
function echoarrhtml($tree,$multicate='')
{
global $jumpv; global $catid; //catid is catpid.
global  $sta_visible;
$html = '';
foreach($tree as $vsub)
{
	
	$name = $vsub['name'];
	$tid=$vsub['id'];  $jsname = jsdelname($vsub['name']);
	$level=$vsub['level'];$last=$vsub['last']; 
  
	$pidname=$vsub['pidname']; 
  $pidhere=$vsub['pid']; 
   $sta_visiblevv=$vsub['sta_visible'];  
 
	//$url_subcc=l($url_sub_httpcc,$texturl.$aliasjumpv,'','');

	//$url_subcc = '<a target="_blank" href="'.admlink($url).'">'.$url.'</a>';
  $url_subcc = admlink($vsub);

	$classhidev = $sta_visiblevv<>'y'?' hidediv':'';

$numnode = num_subnode(TABLE_NODE,'pid',$pidname);
$numnodev = '<span class="cred">('.$numnode.')</span>';

menu_changesta($vsub['sta_visible'],$jumpv,$tid,'sta_catesub');

 
 $editv=' - <a  href='.$jumpv.'&file=edit&act=edit&pidname='.$pidname.'>修改分类</a>';


if($numnode==0 && !ifhasrecord(TABLE_CATE,$pidname,'pid','')) {
	$del_text= " - <a href=javascript:del('delsubcate','$pidname','$jumpv','$jsname')  style='color:#333'> 删除分类</a>";
}
else  $del_text='';
 


 $jumpvadd ='mod_pop_catesubadd.php?lang='.LANG.'&act=add&catpid='.$catid.'&catid='.$pidname;
 if(MULTICATE=='y' || $multicate=='')  $addv = ' &nbsp; &nbsp; &nbsp;  - <a class="needpopup" href="'.$jumpvadd.'">添加分类</a>';
 else $addv =''; 

 

 
 $jumpvnodegl ='../mod_node/mod_node.php?lang='.LANG.'&act=add&catpid='.$catid.'&catid='.$pidname.'&page=0';
 $addnodeglv = ' &nbsp; &nbsp; &nbsp; &nbsp;   - <a class="but3" target="_blank" href="'.$jumpvnodegl.'">管理内容</a>'.$numnodev;


 $jumpvnodeadd ='../mod_node/mod_pop_nodeadd.php?lang='.LANG.'&act=add&catpid='.$catid.'&catid='.$pidname;
 $addnodev = ' - <a class="needpopup" href="'.$jumpvnodeadd.'">添加内容</a>';

 $posv = '<input type="text" name="'.$tid.'"  value="'.$vsub['pos'].'" size="3" /> ';

 $name =  $posv.'<strong class="cblue">'.decode($name).'</strong> - '.$pidname.' - '.$url_subcc.$addv.$editv.$del_text.$addnodeglv.$addnodev.' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- '.$sta_visible;

 

  if(@$vsub['son'] == '')
  {
   $html .= '<li><div class="'.$classhidev.'">├ '.$name.'</div></li>';
  }
  else
  {
   $html .= '<li><div class="'.$classhidev.'">├ '.$name.'</div>';	  
	  if(MULTICATE=='y' || $multicate=='')  $html .= echoarrhtml($vsub['son'],MULTICATE);
   $html = $html."</li>";
  }
}
 return $html ? '<ul class="tree">'.$html.'</ul>' : $html ;
 // return $html;
}




 $sqlsub = "SELECT * from ".TABLE_CATE." where  ppid='$catid' $andlangbh order by pos desc,id";
 $rowlistsub = getall($sqlsub);
 if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有分类，请添加...</p>';
  }
  else{

  	
			$indexarr = indexingarr($rowlistsub);
			$getnewarr = getnewtreearr($indexarr);
		//	pre($getnewarr);
			
	 
  echo '<div class="treearr treearr_catelist">';
    echo   echoarrhtml($getnewarr);

  echo '</div>';

  ?>

<p style="color:red">提醒：只有当分类下面没有子分类，也没有文章，才会出现删除链接。</p>


<div style="padding-bottom:22px"><input class="mysubmit" type="submit" name="Submit" value="排序" />
<br />

<?php echo $sortid_asc?></div>
</form>



 
<?php
  }


 

  ?>