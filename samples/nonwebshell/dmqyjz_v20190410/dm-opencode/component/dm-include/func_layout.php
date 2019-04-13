<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php

 $pidmenu = $header_pc =  $skincss = '';

/*-----------layout---------layout---------layout---------layout-----
------layout--------layout--------layout---------*/

function layoutcommon(){
global $andlangbh; global $curstyle;
GLOBAL $pidmenu2; GLOBAL $header_pc2; GLOBAL $skincss2; 
GLOBAL $banner2; //2 is common...
GLOBAL $bannermobi2;
GLOBAL $bannercssname2;GLOBAL $bannereffect2;
GLOBAL $bannertext2;GLOBAL $bannertextstyle2;GLOBAL $bannerbg2;
GLOBAL $breadtext2; GLOBAL $breadposi2;
GLOBAL $sidebarposi2; GLOBAL $sidebar2;GLOBAL $sidebartop2;GLOBAL $sidebarbot2;
GLOBAL $contentheader2;GLOBAL $content2;GLOBAL $contenttop2;GLOBAL $contentbot2;
GLOBAL $pagetop2;GLOBAL $pagebot2;

 
	$sql2="select * from ".TABLE_LAYOUT." where  type='common' and pidstylebh='$curstyle'  $andlangbh limit 1";
	// if common,no pid. .. just use type common
	//echo $sql2;
	 

		if(getnum($sql2)>0){
		$row2=getrow($sql2);	

		  $arr_can = $row2['layoutcan'];
					   //echo $arr_can;
					   $bscntarr = explode('==#==',$arr_can); 
					   if(count($bscntarr)>1){
						 foreach ($bscntarr as   $bsvalue) {
						  if(strpos($bsvalue, ':##')){
							$bsvaluearr = explode(':##',$bsvalue);
							$bsccc = $bsvaluearr[0].'2';
							$$bsccc=$bsvaluearr[1];
						  }
						}
					  }

         // echo $bannermobi2;
			 if(isdmmobile()){  
					 if($bannermobi2<>'') $banner2= $bannermobi2; 
				}
	 

	}	
	else echo '<p style="background:red;color:#fff">出错，当前模板没有公共布局。</p>';

 

}//end func



function layoutcur($pidname,$type){ // //invoke is in page
global $andlangbh;global $curstyle; 
GLOBAL $pidmenu2; GLOBAL $header_pc2; GLOBAL $skincss2; 
GLOBAL $banner2; //2 is current...
GLOBAL $bannermobi2; 
GLOBAL $bannercssname2;GLOBAL $bannereffect2;GLOBAL $bannerbg2;
GLOBAL $bannertext2;GLOBAL $bannertextstyle2;
GLOBAL $breadtext2; GLOBAL $breadposi2;
GLOBAL $sidebarposi2; GLOBAL $sidebar2;GLOBAL $sidebartop2;GLOBAL $sidebarbot2;
GLOBAL $contentheader2;GLOBAL $content2;GLOBAL $contenttop2;GLOBAL $contentbot2;
GLOBAL $pagetop2;GLOBAL $pagebot2;

GLOBAL $pidmenu; GLOBAL $header_pc; GLOBAL $skincss;
GLOBAL $banner;GLOBAL $bannermobi;GLOBAL $bannertext;GLOBAL $bannertextstyle;
GLOBAL $bannercssname;GLOBAL $bannereffect;GLOBAL $bannerbg;
GLOBAL $breadtext; GLOBAL $breadposi;
GLOBAL $sidebarposi; GLOBAL $sidebar;GLOBAL $sidebartop;GLOBAL $sidebarbot;
GLOBAL $contentheader;GLOBAL $content;GLOBAL $contenttop;GLOBAL $contentbot;
GLOBAL $pagetop;GLOBAL $pagebot;GLOBAL $pagetemplate;
 
$template='';
 
 $sql2="select  * from ".TABLE_LAYOUT." where pid='$pidname' and type='$type'  and pidstylebh='$curstyle'  $andlangbh limit 1";
 //echo  $sql2;
if(getnum($sql2)>0){ 
	$row2=getrow($sql2);
	 // pre($row2); 
			 $arr_can = $row2['layoutcan'];
					   //echo $arr_can;
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

 }
 else{
	        $pidmenu = $header_pc = $skincss = 'jcgg';
 	        $banner= $bannermobi= $bannercssname= $bannereffect=$bannerbg='';
			$bannertext=$bannertextstyle='';
			$breadtext=''; $breadposi='';		
			$sidebarposi='';$sidebar='';$sidebartop='';$sidebarbot=''; 				
			$contentheader='';$content='';$contenttop='';$contentbot='';			
			$pagetop='';$pagebot='';$pagetemplate='';	
 }

		//=====================begin replace====
		 
			if($pidmenu=='jcgg') $pidmenu=$pidmenu2;
			if($header_pc=='jcgg') $header_pc=$header_pc2;
			if($skincss=='jcgg') $skincss=$skincss2;
			if($banner=='') $banner=$banner2;
			if($bannermobi=='') $bannermobi=$bannermobi2;
			if($bannercssname=='') $bannercssname=$bannercssname2;
			if($bannereffect=='') $bannereffect=$bannereffect2;	
			if($bannertext=='') $bannertext=$bannertext2;	
			if($bannertextstyle=='') $bannertextstyle=$bannertextstyle2;
			if($bannerbg=='') $bannerbg=$bannerbg2;	
			if($breadtext=='') $breadtext =$breadtext2;
			if($breadposi=='') $breadposi=$breadposi2;
			
			if($sidebarposi=='') $sidebarposi=$sidebarposi2;
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
			Global $bsbanner; Global $bsbannermob; 
			Global $alias;
			 
			if($alias=='index'){		 
				//default is pc:
				 $banner= $bsbanner;
				 $bannermobi= $bsbannermob;
				 $bannercssname= 'bannerindex';
				//$content= $pidregion; //pidregion in load.php  //if($bsindex<>'') $content= $bsindex;  
				//then judge mobile
			
			}

				if(isdmmobile()){  
					 if($bannermobi<>'') $banner= $bannermobi; 
				}

 

}//end func

 


?>