<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
?>
<?php
 $detail_albumid = $detail_videoid =$detail_musicid =$downloadtitle =$downloadurl =$linkmoretitle =$linkmore ='';
 
$modtype='page';
$sql="select * from ".TABLE_PAGE." where id='$routeid'  $andlangbh limit 1";	 
	if(getnum($sql)>0){
		$row_page=getrow($sql); 
				
			 
		 	    $arr_can=$row_page['arr_can'];
				$bscntarr = explode('==#==',$arr_can); 
			     if(count($bscntarr)>1){
			          foreach ($bscntarr as   $bsvalue) {
			             if(strpos($bsvalue, ':##')){
			               $bsvaluearr = explode(':##',$bsvalue);
			               $bsccc = $bsvaluearr[0];
			               $$bsccc=$bsvaluearr[1];
			             }
			          }
			      } 
			 //   pre($bscntarr);
	 $news_moretitle  = $linkmoretitle;
	 $download_title=  $downloadtitle ;
		 
		$regionid=$row_page['regionid'];
		 
		$sta_noaccess=$row_page['sta_noaccess'];

		$seo1v=$row_page['seo1'];
		$seo2v=$row_page['seo2'];
		$seo3v=$row_page['seo3'];
 //-------------	
		$page_id= $row_page['id'];
		$nodepidname = $curpidname = $page_pidname = $pidname= $row_page['pidname'];	
		// $nodepidname for form use.	 
 		$desp=web_despdecode($row_page['desp']);
		$desptext=web_despdecode($row_page['desptext']);		
		$despv='';
		if($desptext<>'') $despv = $desptext;
		else  $despv = $desp;

//--------------------------------------------



		if($sta_noaccess=='y') {fnoid();exit;}

		//$alias=$row['alias'];
	 
        //$sqllayout="select id from ".TABLE_LAYOUT." where  pid='$pidname' and type='page' and pidstylebh='$curstyle'  $andlangbh limit 1";
	  
		//if(getnum($sqllayout)>0)  layoutcur($pidname,'page'); 
        // else layoutcur('common','common'); 
         $pagetemplate='';
         layoutcur($pidname,'page');  //replace in layout.php

		 

		$pid=$row_page['pid'];
		$tid=$row_page['id'];			
		$curpagetitle = $title=decode($row_page['name']);	

		//------- 
	    $cururllink = get_url($row_page);
		$breadarr[0] =  get_link($cururllink,$title,''); 
		 
 		//--seo----
		
		//unset($seo1)
		//array_unshift($seo1, $curseo1);
		if($seo1v<>''){ $seo1[0] =$seo1v;} else  $seo1[0] =strip_tags($title);
		if($seo2v<>''){ $seo2[0] =$seo2v;} else  $seo2[0] =strip_tags($title);
		if($seo3v<>''){ $seo3[0] =$seo3v;} else  $seo3[0] =strip_tags($title);
			
		  
	$bodycss = "$modtype page$tid page_$alias $pagelayout";	 
	
	}
	else{ fnoid();
		  
	}



?>
<?php 
 
 $sqlmenu="select * from ".TABLE_MENU." where type='$pidname'  and ppid='$pidmenu'   and sta_visible='y' $andlangbh order by pos desc,id limit 1";	 
 //echo $sqlmenu;
if(getnum($sqlmenu)>0){
    $rowmenu = getrow($sqlmenu);
  //  pre($rowmenu );
    $menupid = $rowmenu['pid'];
    $menuid = $rowmenu['pidname'];

    if($menupid=='0'){
    		 	 $main_menutitle= $title;
 				$main_menuid= $menuid;
    }
    else{
    	
    	 $main_menuarr= get_fieldarr(TABLE_MENU,$menupid,'pidname');

    	 $main_menutitle= $main_menuarr['name'];
    	  $main_menutype= $main_menuarr['type'];
    	  $main_menuid= $main_menuarr['pidname'];
    	 // if()
    	  $main_menuid= $main_menuarr['pidname'];

    	  $linkurl2=$main_menuarr['linkurl'];

									$type2=$main_menuarr['type'];
									$type2four=substr($type2,0,4);
//echo $type2;
									if($type2four=='page'){
										$pagearr2 = get_fieldarr(TABLE_PAGE,$type2,'pidname');
										//pre($pagearr2);
												if($pagearr2=='no' ){
													$main_menutitle='单页面不存在';$linkurl2='0';
													$alias_jump2='';
												}
													else{
														$tid2 = $pagearr2['id'];
														$main_menutitle = $pagearr2['name'];
								 						//$alias_jump2='';
								 						//$aliascc2 = alias($type2,'page');
								 						//$linkurl2 = url('page',$aliascc2,$tid2,$alias_jump2);
								 						$linkurl2 = get_url($pagearr2);
								 					}
			 						}

 
  							 $breadhere = '<a href="'.$linkurl2.'">'.$main_menutitle.'</a>';

    	  					 array_unshift($breadarr,$breadhere);

    }
    	 

}
 else $main_menutitle= $title;

 //echo $main_menuid.'aaaaaaa';

 $bannertitle = $title;
?>
<?php 

if($alias=='index') {
	 $reqfile = TPLCURROOT.'/tpl/page/page_index.php';
	 if(!is_file($reqfile))  $reqfile = BLOCKROOT.'/tpl/page/page_index.php'; 
 }

else{  
		if($pagetemplate<>'') { 
		  $reqfile =  TPLCURROOT.'/tpl/page/'.$pagetemplate.'.php'; 
          if(!is_file($reqfile))  $reqfile = BLOCKROOT.'tpl/page/'.$pagetemplate.'.php';
		}
		 else {
		 	$reqfile =  TPLCURROOT.'/tpl/page/page_page.php'; 
		 	if(!is_file($reqfile))  $reqfile = BLOCKROOT.'/tpl/page/page_page.php';  
		 	
		 }  
		 
 }
if(checkfile($reqfile))  require  $reqfile; 
 
?>