<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>

<?php //get menu

//$liclass = ' drop-down m ';
//$ulclass = ' drop-down-content sub';
//$ulclassaddv = ' w';
$liclass = $ulclass = $ulclassaddv = '';
$liclass = ' m ';
$ulclass = '  sub';

$classarr = array('');

$menufirstv = ' first';
$menulastv = ' last';
//------------
//echo $pidmenu.'----';exit;
$cusmenuarr = get_fieldarr(TABLE_MENU,$pidmenu,'pidname');
//pre($cusmenuarr);
$sta_cusmenu = $cusmenuarr['sta_cusmenu'];
$cusmenudesp= $cusmenuarr['cusmenudesp'];
 if($sta_cusmenu=='y')  {
    if($cusmenudesp=='') echo 'no text in menu.  pls edit.';
 	else echo web_despdecode($cusmenudesp);}
else{

echo '<ul class="m">';
//----------------------
global $andlangbh;
$sqlmenu = "SELECT * from ".TABLE_MENU." where   ppid='$pidmenu' and pid='0' and sta_visible='y'  $andlangbh order by pos desc,id";
 //echo $sqlmenu;
if(getnum($sqlmenu)>0){
//------------
$menulist = getall($sqlmenu);
 //pre($menulist);
		foreach($menulist as $k=>$v){
			$pidname=$v['pidname'];
			$menuid=$v['id'];
			$menu_xiala=$v['menu_xiala'];
			$linkurl=$v['linkurl'];
			 $name=decode($v['name']);
			$typepidname=$v['type'];
			$type = substr($typepidname,0,4);
		// echo $type;
			$aliascc=$menuindex=$menuclass='';


			if (in_array($pidname, $classarr)) { $ulclassadd = $ulclassaddv; }
		    else  $ulclassadd = '';
			$k++;
           $menufirst = $k==1?$menufirstv:'';
		   $menucount = count($menulist);

		   $menulast = $k==$menucount?$menulastv:'';


		  if($type=='cusm' or $type=='page') {
		  	if($type=='cusm') {
		  		$menuclass=' menucus'.$menuid;
		  	}
            if($type=='page'){

							 $pagearr = get_fieldarr(TABLE_PAGE,$typepidname,'pidname');
							// pre($pagearr);
							 if($pagearr=='no'){$name='单页面不存在';$linkurl='0';}
							 else {
							 	 $name=decode($pagearr['name']);
							 	 $tid=$pagearr['id'];
							 	 $alias_jump='';

									$aliascc = alias($typepidname,'page');

							 		$linkurl = get_url($pagearr);


							 		 if($aliascc=='index') $linkurl = BASEURLPATH;
							 		  $menuclass=' menupage'.$tid;
							 	}

				 }

			 	 if($aliascc=='index')  {  $target =''; $menuindex = ' menuindex';}
			 		else $target = linktarget($linkurl);

			 		if($pidname==$main_menuid) $activemenu = ' active';
			 		else $activemenu = '';
                    // echo '----'.$typepidname;

                    echo '<li class="'.$liclass.$menuindex.$menuclass.$menufirst.$menulast.'"><a class="m'.$activemenu.'" '.$target.' href="'.$linkurl.'">'.$name.'</a>';
                    //-----sub menu----------------
                    if($menu_xiala<>'') echo web_despdecode($menu_xiala);
                    else{
						$sql22 = "SELECT * from ".TABLE_MENU." where pid='$pidname' and ppid='$pidmenu' and type<>'cate' and sta_visible='y' $andlangbh order by pos desc,id";
						//echo $sql22;
						$alias_jump2 ='';
						if(getnum($sql22)>0){
							$rowall22 = getall($sql22);
								echo '<ul class="'.$ulclass.'">';
								foreach($rowall22 as $v2){

									$pidname2=$v2['pidname'];
									$name2=decode($v2['name']);
									$linkurl2=$v2['linkurl'];
									$type2=$v2['type'];
									$type2four=substr($type2,0,4);

									if($type2four=='page'){
												$pagearr2 = get_fieldarr(TABLE_PAGE,$type2,'pidname');
												if($pagearr2=='no' ){
													$name2='单页面不存在';$linkurl2='0';
													$alias_jump2='';
												}
													else{
														$tid2 = $pagearr2['id'];
														$name2 = decode($pagearr2['name']);
								 						$alias_jump2='';
								 						$aliascc2 = alias($type2,'page');
								 						$linkurl2 = get_url($pagearr2);
								 					}
			 						}
					                echo '<li><a '. linktarget($alias_jump2).'  href="'.$linkurl2.'">'.$name2.'</a></li>';

								}//end foreach
								echo '</ul>';

						}//end if(getnum($sql22)>0)
					 }//end menu_xiala
                    //-----------
                    echo '</li>';
			}//end page

			 else{//cate menu part
			 		$sqlmenu = "SELECT * from ".TABLE_CATE." where pidname='$typepidname' and sta_visible='y' $andlangbh order by pos desc,id limit 1";
			 		//echo $sqlmenu;
					$row = getrow($sqlmenu); 
					if($row<>'no'){
						$name = decode($row['name']);	$tid = $row['id']; 

	   					$aliascc = alias($typepidname,'cate');
	   					$url = get_url($row);
	   					if($typepidname==$mainpidname) $activemenu = ' active';
				 		else $activemenu = '';
				 		$menuclass = ' menucate'.$tid;

			  			 echo '<li class=" '.$liclass.$menuclass.'"><a class="m'.$activemenu.'"  href="'.$url.'">'.$name.'</a>';

			  			 	//begin cate level 1
						$sql = "SELECT * from ".TABLE_CATE." where ppid='$typepidname' and sta_visible='y' $andlangbh order by pos desc,id";
						if(getnum($sql)>0){
								$rowall = getall($sql);

									$indexarr = indexingarr($rowall);
										$getnewarr = getnewtreearr($indexarr);
								echo '<ul class="'.$ulclass.$ulclassadd.'">';
								 echo   echoarrhtml_menu($getnewarr);
								echo '</ul>';
						}//end 	if(getnum($sql)>0)
			  			//---------
			  			 echo '</li>';
		  			}

			 }//end cate

			}//end main foreach

//---------------

}//end if(getnum($sqlmenu)>0)
else {
	echo '<li>no menu</li>';
}

//----------------------
        echo '</ul>';
   }
?>

<?php
function echoarrhtml_menu($tree,$multicate='')
{
global $jumpv; global $catid; //catid is catpid.
global  $curcatepidname;
$html = '';
foreach($tree as $vsub)
{

 $name = $vsub['name'];
 $tid=$vsub['id'];
 $level=$vsub['level'];$last=$vsub['last'];

 $pidname=$vsub['pidname'];
 $pidhere=$vsub['pid'];  $sta_visiblevv=$vsub['sta_visible'];

 $alias_jump=$vsub['alias_jump'];
 $aliascc = alias($pidname,'cate');


 if($alias_jump<>'') $aliasjumpv = '<span class="cred" >(跳转)</span>';
 else  $aliasjumpv = '';

	$url_subcc = get_url($vsub);

	if($aliascc<>'') $texturl = $aliascc.'.html';
	else $texturl = 'category-'.$tid.'.html';


 //$url_subcc=l($url_sub_httpcc,$texturl.$aliasjumpv,'','');
$classv = ($pidname == $curcatepidname )?' class= "active" ':'';

 $name = '<a   '.$classv.' href="'.$url_subcc.'">'.$name.'</a>';




 if(@$vsub['son'] == '')
 {
 $html .= '<li>'.$name.'</li>';
 }
 else
 {
 $html .= '<li>'.$name.'<ul class="sub">';
	  if(MULTICATE=='y' || $multicate=='')  $html .= echoarrhtml_menu($vsub['son'],MULTICATE);
 $html = $html."</ul></li>";
 }


}

return $html ;
// return $html;
}
