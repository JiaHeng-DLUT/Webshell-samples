<?php
/*
	power by JASON.ZHANG  DM建站  www.demososo.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>


 <?php
function echoarrhtml_sidebar($tree,$multicate='')
{
global $jumpvf; global $pidname; 
global  $sta_visible;
$html = '';
foreach($tree as $vsub)
{
	
	$name = $vsub['name'];
	$tid=$vsub['id'];  $jsname = jsdelname($vsub['name']);
	$level=$vsub['level'];$last=$vsub['last']; 
  
	$pidnamecur=$vsub['pidname']; 
	$pidhere=$vsub['pid'];  $sta_visiblevv=$vsub['sta_visible']; 
	 
 
	$classhidev = $sta_visiblevv<>'y'?' hidediv':'';
	$hidev = $sta_visiblevv<>'y'?' [隐藏]':'';

    $classv = $pidname==$pidnamecur?' active':'';

  $name = '<a  href="'.$jumpvf.'&pidname='.$pidnamecur.'&act=edit">'.decode($name).'</a>'.$hidev;
 

  if(@$vsub['son'] == '')
  {
   $html .= '<li><div class="'.$classv.$classhidev.'">├ '.$name.'</div></li>';
  }
  else
  {
   $html .= '<li><div class="'.$classv.$classhidev.'">├ '.$name.'</div>';	  
	 if(MULTICATE=='y' || $multicate=='')  $html .= echoarrhtml_sidebar($vsub['son'],MULTICATE);
   $html = $html."</li>";
  }
}
 return $html ? '<ul class="tree">'.$html.'</ul>' : $html ;
 // return $html;
}



echo   '<strong>子分类：</strong><br />';
 $sqlsub = "SELECT * from ".TABLE_CATE." where  ppid='$catid' $andlangbh order by pos desc,id";
 $rowlistsub = getall($sqlsub);
 if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有分类，请添加...</p>';
  }
  else{

  	
			$indexarr = indexingarr($rowlistsub);
			$getnewarr = getnewtreearr($indexarr);
		//	pre($getnewarr);
			
	 
   echo '<div class="sidebarnew">';
    echo   echoarrhtml_sidebar($getnewarr);

  echo '</div>';
}
  ?>






 