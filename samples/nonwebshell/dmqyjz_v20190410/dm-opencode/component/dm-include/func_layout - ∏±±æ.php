<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php



/*-----------layout---------layout---------layout---------layout-----
------layout--------layout--------layout---------*/

function layoutcommon(){
global $andlangbh; global $curstyle;

GLOBAL $banner2; //2 is common...
GLOBAL $bannercssname2;GLOBAL $bannereffect2;
GLOBAL $bannertext2;GLOBAL $bannertextstyle2;GLOBAL $bannerbg2;
GLOBAL $bread2; GLOBAL $sta_bread_posi2;
GLOBAL $sta_sidebar2; GLOBAL $sidebar2;GLOBAL $sidebartop2;GLOBAL $sidebarbot2;
GLOBAL $contentheader2;GLOBAL $content2;GLOBAL $contenttop2;GLOBAL $contentbot2;
GLOBAL $pagetop2;GLOBAL $pagebot2;

 
	$sql2="select * from ".TABLE_LAYOUT." where  type='common' and pidstylebh='$curstyle'  $andlangbh limit 1";
	// if common,no pid. .. just use type common
	//echo $sql2;
	 

		if(getnum($sql2)>0){
		$row2=getrow($sql2);
	
		$banner2=$row2['banner'];$bannercssname2=$row2['bannercssname'];$bannereffect2=$row2['bannereffect'];
		$bannertext2=$row2['bannertext'];	$bannertextstyle2=$row2['bannertextstyle'];	
		$bannerbg2=$row2['bannerbg'];				
		$bread2=$row2['bread'];
		$sta_bread_posi2=$row2['sta_bread_posi'];		
		$sta_sidebar2=$row2['sta_sidebar'];
		$sidebar2=$row2['sidebar'];
		$sidebartop2=$row2['sidebartop'];
		$sidebarbot2=$row2['sidebarbot'];	 	
		
		$content2=$row2['content'];
		$contentheader2=$row2['contentheader'];
		$contenttop2=$row2['contenttop'];
		$contentbot2=$row2['contentbot'];
		
		$pagetop2=$row2['pagetop'];
		$pagebot2=$row2['pagebot'];	

	 

	}	
	else echo '<p style="background:red;color:#fff">出错，当前模板没有公共布局。</p>';

 

}//end func



function layoutcur($pidname,$type){ // //invoke is in page
global $test;global $curstyle;
global $detailid;
global $andlangbh;
GLOBAL $banner2; //2 is current...
GLOBAL $bannercssname2;GLOBAL $bannereffect2;GLOBAL $bannerbg2;
GLOBAL $bannertext2;GLOBAL $bannertextstyle2;
GLOBAL $bread2; GLOBAL $sta_bread_posi2;
GLOBAL $sta_sidebar2; GLOBAL $sidebar2;GLOBAL $sidebartop2;GLOBAL $sidebarbot2;
GLOBAL $contentheader2;GLOBAL $content2;GLOBAL $contenttop2;GLOBAL $contentbot2;
GLOBAL $pagetop2;GLOBAL $pagebot2;

GLOBAL $banner;GLOBAL $bannertext;GLOBAL $bannertextstyle;
GLOBAL $bannercssname;GLOBAL $bannereffect;GLOBAL $bannerbg;
GLOBAL $bread; GLOBAL $sta_bread_posi;
GLOBAL $sta_sidebar; GLOBAL $sidebar;GLOBAL $sidebartop;GLOBAL $sidebarbot;
GLOBAL $contentheader;GLOBAL $content;GLOBAL $contenttop;GLOBAL $contentbot;
GLOBAL $pagetop;GLOBAL $pagebot;GLOBAL $template;
 
$template='';
 
 $sql2="select  * from ".TABLE_LAYOUT." where pid='$pidname' and type='$type'  and pidstylebh='$curstyle'  $andlangbh limit 1";
 //echo  $sql2;
if(getnum($sql2)>0){ 
	$row2=getrow($sql2);
	 // pre($row2);
	  
			$banner=$row2['banner'];$bannercssname=$row2['bannercssname'];$bannereffect=$row2['bannereffect'];
			$bannertext=$row2['bannertext'];$bannertextstyle=$row2['bannertextstyle'];
			$bannerbg=$row2['bannerbg'];
			$bread=$row2['bread'];
			$sta_bread_posi=$row2['sta_bread_posi'];		
			$sta_sidebar=$row2['sta_sidebar'];
			$sidebar=$row2['sidebar'];
			$sidebartop=$row2['sidebartop'];
			$sidebarbot=$row2['sidebarbot'];	 	
			
			$contentheader=$row2['contentheader'];
			$content=$row2['content'];
			$contenttop=$row2['contenttop'];
			$contentbot=$row2['contentbot'];
			
			$pagetop=$row2['pagetop'];
			$pagebot=$row2['pagebot'];
			$template=$row2['template'];			
	 
 }
 else{
 	        $banner= $bannercssname= $bannereffect=$bannerbg='';
			$bannertext=$bannertextstyle='';
			$bread='';
			$sta_bread_posi='';		
			$sta_sidebar='';
			$sidebar='';
			$sidebartop='';
			$sidebarbot='';	 	
			
			$contentheader='';
			$content='';
			$contenttop='';
			$contentbot='';
			
			$pagetop='';
			$pagebot='';	
 }

		//=====================begin replace====
		 
			if($banner=='') $banner=$banner2;
			if($bannercssname=='') $bannercssname=$bannercssname2;
			if($bannereffect=='') $bannereffect=$bannereffect2;	
			if($bannertext=='') $bannertext=$bannertext2;	
			if($bannertextstyle=='') $bannertextstyle=$bannertextstyle2;
			if($bannerbg=='') $bannerbg=$bannerbg2;	
			if($bread=='') $bread =$bread2;
			if($sta_bread_posi=='') $sta_bread_posi=$sta_bread_posi2;
			
			if($sta_sidebar=='') $sta_sidebar=$sta_sidebar2;
			if($sidebar=='') $sidebar=$sidebar2;
			if($sidebartop=='') $sidebartop=$sidebartop2;
			if($sidebarbot=='') $sidebarbot=$sidebarbot2;		
			
			if($contentheader=='') $contentheader =$contentheader2;
			if($content=='') $content =$content2;
			if($contenttop=='') $contenttop =$contenttop2;
			if($contentbot=='') $contentbot =$contentbot2;
			
			if($pagetop=='') $pagetop =$pagetop2;
			if($pagebot=='') $pagebot=$pagebot2;
	 
		
		 //--------judge homepage--------------
			 //$bsbanner=$bsbannermob=$bsindex=$bsindexmob=$bsmenu=$bsfooter=$bsfootermob=$bsfooternavmob='';
			Global $bsbanner;Global $bsbannercssname;Global $bsbannermob;Global $pidregion;Global $bsindexmob;
			Global $alias;
			 
			if($alias=='index'){		 
				//default is pc:
				 $banner= $bsbanner;
				 $bannercssname= $bsbannercssname;
				//$content= $pidregion; //pidregion in load.php  //if($bsindex<>'') $content= $bsindex;  
				//then judge mobile
				if(isdmmobile()){ //except ipad
					 if($bsbannermob<>'') $banner= $bsbannermob;
				    // if($bsindexmob<>'') $content= $bsindexmob;
				}
			}

 

}//end func

 


?>