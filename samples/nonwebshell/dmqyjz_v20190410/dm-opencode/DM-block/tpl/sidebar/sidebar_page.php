<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}


?>
<div class="sidebarmenu">
<div class="sdheader"><?php echo decode($main_menutitle)?></div>
<div class="sdcontent">


<?php

$sqlmenu = "SELECT * from ".TABLE_MENU." where pid='$main_menuid'  and ppid='$pidmenu' and sta_visible='y' $andlangbh order by pos desc,id";
// echo $sqlmenu;
if(getnum($sqlmenu)>0){
	echo '<ul>';
	$menulist = getall($sqlmenu);
	//pre($menulist);
		foreach($menulist as $v){
	$pidname=$v['pidname'];
	$linkurl=$v['linkurl'];
	$menu_xiala=$v['menu_xiala'];
	$type=$v['type'];
	$typefour=substr($type,0,4);
	$name=decode($v['name']);
	$active= '';
 if($typefour=='page'){

 		 $subpagearr = get_fieldarr(TABLE_PAGE,$type,'pidname');
             if($subpagearr=='no')  $name='单页面不存在';
                else {
                   $name=decode($subpagearr['name']);
                   $tid=$subpagearr['id'];  
			 		 $linkurl = get_url($subpagearr);
                }
								//-------------------
								 if($curpidname==$type) $active=' active"';
 }
 else{
 	  if(@$cateofpagemenu==$pidname) $active=' active';
   }

  echo '<li class="m"><a class="m'.$active.'" '.linkhref($linkurl).'>'.$name.'</a></li>';
			 //---------------------
                }//end foreach
echo '</ul>';
	} //if(getnum($sqlmenu)>0)
	else echo '<ul><li class="m"><a class="m" href="">'.$main_menutitle.'</a></li></ul>';

?>
</div>
</div>
