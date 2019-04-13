<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
?>
<?php
$modtype='page';
$sql="select * from ".TABLE_PAGE." where id='$routeid'  $andlangbh limit 1";	 
	if(getnum($sql)>0){
		$row_page=getrow($sql); 
				
				/*
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
			      }*/
			    
	 
		 
		$regionid=$row_page['regionid'];
		$downloadurl=$row_page['downloadurl'];
		$sta_noaccess=$row_page['sta_noaccess'];

		$seo1v=$row_page['seo1'];
		$seo2v=$row_page['seo2'];
		$seo3v=$row_page['seo3'];
 //-------------	
		$pidname= $row_page['pidname'];
 		$desp=web_despdecode($row_page['desp']);
		$desptext=web_despdecode($row_page['desptext']);		
		$despv='';
		if($desptext<>'') $despv = $desptext;
		else  $despv = $desp;

//--------------------------------------------



		if($sta_noaccess=='y') {fnoid();exit;}

		//$alias=$row['alias'];
		$curpidname = $pidname=$row_page['pidname']; 
	
        //$sqllayout="select id from ".TABLE_LAYOUT." where  pid='$pidname' and type='page' and pidstylebh='$curstyle'  $andlangbh limit 1";
	  
		//if(getnum($sqllayout)>0)  layoutcur($pidname,'page'); 
        // else layoutcur('common','common'); 

         layoutcur($pidname,'page');  //replace in layout.php

		 

		$pid=$row_page['pid'];$tid=$row_page['id'];			
		$title=decode($row_page['name']);	

		//-------
		 
		 
		$alias_jump =  '';//$row_page['alias_jump']; no use in page,but use in node.
		$alias = alias($pidname,'page');
		$cururl = url('page',$alias,$tid,$alias_jump);
		$curlink = l($cururl,$title,'','');
		$breadarr[0] = $curlink;
 
		 
 		//--seo----
		
		//unset($seo1)
		//array_unshift($seo1, $curseo1);
		if($seo1v<>''){ $seo1[0] =$seo1v;} else  $seo1[0] =$title;
		if($seo2v<>''){ $seo2[0] =$seo2v;} else  $seo2[0] =$title;
		if($seo3v<>''){ $seo3[0] =$seo3v;} else  $seo3[0] =$title;
			
		  
	$bodycss = "$modtype page$tid page_$alias $pagelayout";	 
	
	}
	else{ fnoid();
		  
	}



?>
<?php 
$mainmenupidname = '';
 $sqlmenu="select * from ".TABLE_MENU." where type='$pidname'  and ppid='$pidmenu'   and sta_visible='y' $andlangbh order by pos desc,id limit 1";	 
 echo $sqlmenu;
if(getnum($sqlmenu)>0){
    $rowmenu = getrow($sqlmenu);
  //  pre($rowmenu );
    $parentid = $rowmenu['pid'];
    if($parentid=='0'){
    		 	$maintitle= $title;
 				$mainmenupidname= $pidname;
    }
    else{
    	 $sqlmenu="select * from ".TABLE_MENU." where   pidname='$parentid'   $andlangbh limit 1";	 
    	 // echo $sqlmenu;
		$rowmenu = getrow($sqlmenu);
		//pre($rowmenu);
		$namemenu = $rowmenu['name'];
		 $typemenu = $rowmenu['type'];
		 $linkurlmenu = $rowmenu['linkurl'];
		// echo $typemenu;
		 if($typemenu =='page'){
		 		 $subpagearr = get_fieldarr(TABLE_PAGE,$parentid,'pidname');   
		 		 //pre($subpagearr);
             if($subpagearr=='no') {$namemenu='单页面不存在';
                  $parentid = '-';
                }
                else {
                   $namemenu=decode($subpagearr['name']); 
                  
                }
                $linkmenu =  getlink($parentid,'page','noadmin');
               } 
              else{
              	$linkmenu = l($linkurlmenu,$namemenu,'','');
              } 
//----------------------------------------
                $maintitle= $namemenu;	
 				$mainpidname= $parentid;
 				array_unshift($breadarr, $linkmenu);



		 }



}
else {
	 	$maintitle= $title;
	 	//when menu is cust,and link is page,so not in menu,solve is when link is page,so use pagemenu.bec have jump to page
     	$mainpidname= $curpidname;
}

//echo $maintitle.'aaaaaaa';

 $bannertitle = $title;
?>
<?php 
  
 if($template<>'') {
  $filename =  HTMLDIR.'/tpl/'.$template;
  $reqfile = TEMPLATEROOT.$filename;
 
  checkhasfile($reqfile,$filename);
}
else{
	if($alias=='index') $reqfile =TPLBASEROOT.'page_index.php';
	else  $reqfile =TPLBASEROOT.'page_page.php';
}
 
require_once $reqfile;  
?>