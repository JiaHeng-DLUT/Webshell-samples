<?php
/*
	made by cmsmeng.com
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
} 
?>
<?php
$secondcatepidname ='';
$sta_maincate='n';
//----if come from detail--------
if($detailid<>''){
$sql_detail = "SELECT * from ".TABLE_NODE."  where  id='$detailid' $andlangbh  order by id limit 1";
//echo $sql_detail ;
				$row_detail=getrow($sql_detail);	//$row_detail for system/syst_content_article_detail.php	
				if($row_detail=='no') {fnoid();exit;}	
 
//--------
  $nodekvshow='y';				
$arr_candetail=$row_detail['arr_can']; 
$bscntarr = explode('==#==',$arr_candetail); 
     if(count($bscntarr)>1){
          foreach ($bscntarr as   $bsvalue) {
             if(strpos($bsvalue, ':##')){
               $bsvaluearr = explode(':##',$bsvalue);
               $bsccc = $bsvaluearr[0];
               $$bsccc=$bsvaluearr[1];
             }
          }
      }

  //pre($bscntarr);
     $seo1_det = $row_detail['seo1'];
     $seo2_det = $row_detail['seo2'];
     $seo3_det = $row_detail['seo3'];
	 $sta_noaccess =   $row_detail['sta_noaccess'];
	 $sta_tj =   $row_detail['sta_tj']; 
	 $sta_new =   $row_detail['sta_new']; 

//-------hit----
$hit = $row_detail['hit']+1; 
$ss = "update ".TABLE_NODE." set  hit='$hit'  where id='$detailid' $andlangbh limit 1";
iquery($ss);
//-----------------

				$curcatepidname = $row_detail['pid'];
				$ppid= $row_detail['ppid'];
				$detail_title=$title= $row_detail['title'];$detail_pos= $row_detail['pos'];	
				$nodepidname  = $curpidname =$pidname= $row_detail['pidname'];
				$detailkv= $row_detail['kv'];
				
				$dateedit= $row_detail['dateedit'];


				if($sta_noaccess=='y' && ISADMIN<>'y') {
					fnoaccess();exit;
				}

				
				//----------------
				$sql2 = "SELECT id,modtype from ".TABLE_CATE."  where  pidname='$curcatepidname' $andlangbh  order by id limit 1";
				$row2=getrow($sql2);
				if($row2=='no') {fnoid();exit;}	
				$routeid= $row2['id'];
	}			
//------------------
$sql="select * from ".TABLE_CATE." where id='$routeid'  $andlangbh limit 1"; 
	if(getnum($sql)>0){
		$row=getrow($sql); 
		$curcate_pid = $row['pid']; $ppid=$row['ppid']; 
		$tid=$row['id'];
		$cate_level=$row['level'];		$cate_last=$row['last'];
		$cur_list_can=$row['list_can'];
		$cur_catearrcan=$row['arr_can'];
		
		$sta_listcan_inherit=$row['sta_listcan_inherit'];
		//------------	
	 
		$curpagetitle = $catetitle=decode($row['name']); 
		$curcatepidname=$row['pidname'];//not use pidname,conflict to sidebar pidname 
		 
	    $cururllink = $page_canshu = get_url($row);
		$breadarr[0] = get_link($cururllink,$catetitle,'');
      
	 if($curcate_pid=='0'){
        	 $mainpidname = $curcatepidname;   
        	  $sta_maincate='y';
        	//echo $pid.'ss'; 
        }
        else{
        	 $mainpidname = $ppid;          

        }
 //pre($breadarr);  
/*query maincate*/
$sql33="select * from ".TABLE_CATE." where pidname='$mainpidname'  $andlangbh limit 1"; 
//echo $sql33;
$row33=getrow($sql33); 
  
		//--------
		$relativetitle=$relativefg=$ordernowtitle=$cateofpagemenu= $download_title ='';
		$musicfg = 'music.php';
		 $blockimg=$cssname= $namefront=$blockid=$nodebtnmore = '';
		$bgcolor=$bgimg=$cssstyle='';
		$bgrepeat= 'no-repeat';
		$bgposi= 'center center';
		$bgsize= 'cover';
		$bgattach = '';
		$stylev=$linkurl=$linktitle='';


		 $template='grid_node.tpl.php';
		 $detailfg='detail_normal.php';
		 $albumfg='album_fancybox.php';

        $maxline=20;
   		$cus_columns=$cus_columns_album=4;
        $cus_substrnum=30;
        $relamaxline = 20; //just init.will from admin
        $relapid = 'y';
		//-----------
		$main_list_can=$row33['list_can'];
		$main_catearrcan=$row33['arr_can']; 	

		 //pre($bscntarr);
		//-----------------
		$maintitle=decode($row33['name']);
		//$modtype=$row33['modtype']; //modetype only use in maincate or detail
		 $modtype ='node';
		 $seo1_main =$row33['seo1'];
		  $seo2_main = $row33['seo2'];
		  $seo3_main = $row33['seo3'];
 


 
/* end query maincate*/
 

if($detailid=='')  $layouttype = 'cate';
else $layouttype = 'read';

$pagetemplate='';
$sqllayout="select id from ".TABLE_LAYOUT." where  pid='$curcatepidname' and type='$layouttype' and pidstylebh='$curstyle'  $andlangbh limit 1";	  
 if(getnum($sqllayout)>0)  {
 		layoutcur($curcatepidname,$layouttype); 
 }
 else{ 
	 layoutcur($mainpidname,$layouttype); 
 }
 //---list can-----------------       


 

if($sta_listcan_inherit<>'y') { 
	$main_list_can = $cur_list_can;
   $main_catearrcan = $cur_catearrcan;
}

  $bscntarr = explode('==#==',$main_list_can); 
    if(count($bscntarr)>1){
      foreach ($bscntarr as   $bsvalue) {
       if(strpos($bsvalue, ':##')){
         $bsvaluearr = explode(':##',$bsvalue);
         $bsccc = $bsvaluearr[0];
         $$bsccc=$bsvaluearr[1];
       }
     }
   }
   //------------
	$bscntarr = explode('==#==',$main_catearrcan); 
		     if(count($bscntarr)>1){
		          foreach ($bscntarr as   $bsvalue) {
		             if(strpos($bsvalue, ':##')){
		               $bsvaluearr = explode(':##',$bsvalue);
		               $bsccc = $bsvaluearr[0];
		               $$bsccc=$bsvaluearr[1];
		             }
		          }
		      }
		 
   //--------------
    $maxline = intval($maxline);
   $cus_columns = intval($cus_columns);
   $cus_substrnum = intval($cus_substrnum);
	//-----------------	
		$cur_sta_noaccess=$row['sta_noaccess'];
		if($cur_sta_noaccess=='y') {fnoaccess();exit;}
	
		//-------------		
		//---breadcurmb
		// breadcrumb('cate');//in func_breadcrumb.php 


 		//--seo----
		if($detailid<>''){ 
		$seo1v=$seo1_det;
		$seo2v=$seo2_det;
		$seo3v=$seo3_det;
		$seotitle= $title;
		 
		}
		else{
			if($sta_maincate=='y'){
				$seo1v=$seo1_main;
				$seo2v=$seo2_main;
				$seo3v=$seo3_main;

			}
				else{
				$seo1v=$row['seo1'];
				$seo2v=$row['seo2'];
				$seo3v=$row['seo3'];
			}

			$seotitle= $catetitle;
			  
			}

		 //array_unshift($seo1, $curseo1);

		if($seo1v<>''){ $seo1[0] =$seo1v;} else  $seo1[0] =$seotitle;
		if($seo2v<>''){ $seo2[0] =$seo2v;} else  $seo2[0] =$seotitle;
		if($seo3v<>''){ $seo3[0] =$seo3v;} else  $seo3[0] =$seotitle;
		//var_dump($seo1);
			

	}
	else{ fnoid();exit;
	}

	$bannertitle = $catetitle;

	
?>
<?php 
//------bread--------------
	 if($curcate_pid<>'0'){
        	 
        		$sql22="select * from ".TABLE_CATE." where pidname='$curcate_pid'  $andlangbh limit 1"; 
				 $row22=getrow($sql22); 
				  // pre($row22);
				 $pid22=$row22['pid']; 
				 //echo $pid22; 
				 $pidname22=$row22['pidname'];
				 $name22=$row22['name'];

				 if($pid22=='0'){
			        	//$mainpidname = $pidname22;  			        			        	 
			        	array_unshift($breadarr, get_link(get_url($row22),$name22,''));  //get_link($url,$name,$css)
			        	//$secondcatepidname = $curcatepidname;
			        	
			        }  
			        else {

			        	$sql3="select * from ".TABLE_CATE." where pidname='$pidname22'  $andlangbh limit 1"; 
						 $row3=getrow($sql3); 
						 $name3=$row3['name'];
						  //pre($row3);
						array_unshift($breadarr, get_link(get_url($row3),$name3,''));
						array_unshift($breadarr, get_link(get_url($row33),$maintitle,''));
					
			        } 


        }
        

//----------------

$mainalias = alias($mainpidname);
 
$reqfile = '';

 if($pagetemplate <>'') {
    $reqfile =  TPLCURROOT.'/tpl/page/'.$pagetemplate; 
}
else{
	 if($detailid<>''){
	 $bodycss = "single single_$detailid single_cate$tid single_cate_$mainalias";  			 $reqfile = TPLCURROOT.'tpl/page/single.php'; 
		   if(!is_file($reqfile))  $reqfile = BLOCKROOT.'tpl/page/single.php'; 
		}
		else{
			 $bodycss = "category cate$tid cate_$mainalias";				   
			 $reqfile = TPLCURROOT.'tpl/page/category.php';
			  if(!is_file($reqfile))  $reqfile = BLOCKROOT.'tpl/page/category.php';
		} 


}

 if(checkfile($reqfile))  require  $reqfile; 
 
?>