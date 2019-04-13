<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php
function block($pidname){
if($pidname<>''){
	global $attach_type;global $reqfile;global $curstyle;	global $andlangbh;
 
//block,dhvh,chpr
//custom/devp_***.php
//2013/***/.jpg or .swf
  $pidstring = substr($pidname,0,4);
   $pidifimg = gl_imgtype($pidname);
   if($pidstring=='hide') {
		return '';
	}
 
	elseif($pidstring=='vblo') {
   		$reqfile = 'vblock.php';
   		 $effect ='vblock';
   		//echo $reqfile;
   		 $edittype = 'vblock'; //use for edit linktype
   		require(EFFECTROOT.'block_otherlay.php');
	}


	elseif($pidstring=='prog') {
		//block_reqfile('p',$pidname);
        $reqfile = 'prog/'.$pidname.'.php';  $effect ='prog';
         $edittype = 'prog'; //use for edit linktype
   		require(EFFECTROOT.'block_otherlay.php');
		//$reqfile=EFFECTROOT.'prog/'.$pidname.'.php';
		// if(is_file($reqfile)) require $reqfile;
   		// else echo '<p style="background:#ccc;color:red">没有此文件: '.$reqfile.' </p>';
		
	}
		elseif($pidstring=='mbst') {
		//block_reqfile('p',$pidname);
		 // $biaoshi =str_replace("mbst/",'',$pidname);
        $reqfile = $pidname.'.php'; 
       // echo $reqfile; 
        $effect ='mbst';
         $edittype = 'mbst'; //use for edit linktype
   		 require(EFFECTROOT.'block_otherlay.php');
		
	}


	elseif($pidstring=='fefi') {
		//block_reqfile('p',$pidname);
        $reqfile = 'fefile/'.$pidname.'.php';  
        $effect ='fefile';
         $edittype = 'fefile'; //use for edit linktype
   		//require(EFFECTROOT.'block_otherlay.php');
		
	}

	elseif($pidstring=='part') {
		//block_reqfile('p',$pidname);
        $reqfilepart = $pidname.'.php';  
        $effect ='part';
         $edittype = 'part'; //use for edit linktype
   		//require(EFFECTROOT.'block_otherlay.php');
		
	}

 
    elseif($pidstring=='regi') {
	  			return region($pidname);
	  	// $sqlre = "SELECT id from ".TABLE_REGION." where pidname='$pidname'   $andlangbh order by pos desc,id";
	  	 //and stylebh='$curstyle'   -- cancel temp,bec index and common
	  	// if(getnum($sqlre)>0) 		return region($pidname);	
	  	// else {echo '区域和模板不统一。';}	
	}
	  elseif($pidstring=='grou') {
	  			return group($pidname);
	}

	//elseif($pidstring=='bloc') { //no cancel. for admin preview...
		// return regionblock($pidname);			
	// }
	
	elseif(in_array($pidifimg,$attach_type)){
		//echo '<div class="bannerimg"><img src="'.UPLOADPATHIMAGE.$pidname.'" alt="" /></div>';
		 $reqfile = 'imgfj'; $effect = 'imgfj';
		  $edittype = 'imgfj'; //use for edit linktype
   		require(EFFECTROOT.'block_otherlay.php');		
	}
	
	
	else{echo '<p class="errorfont">error  block -- '.$pidname.'</p>';}
	// $menu_kz = substr($menu,-3);
       // if($menu_kz=='swf') {
      //      get_flash($menu,'transparent');//opaque
      // }
}//pidname not null
}//end func

 


function region($region){
// pre($region);
Global $andlangbh;Global $curstyle;

  $sqlbuju = "SELECT * from ".TABLE_REGION." where pid='$region'  and sta_visible='y'  $andlangbh order by pos desc,id";
	//  echo $sqlbuju;
	  echo '<div class="blockregion" data-effect="regionidnex">';
  //no use edit in region
	 if(getnum($sqlbuju)>0){
		 $result = getall($sqlbuju);
		 // pre($result);	
		
			foreach($result as $v){
				 // $pidname = $v['pidname'];
			 // echo $pidname;
				//  if(strpos('cc'.$region,'nindex')>0 && $regsta_sub=='n'){
				// 		  if(strpos('cc'.$rgindex_design,$pidname)>0){

				// 	     regionblockecho($v);
				// 		 } 
				// }
				// else 
				 regionblockecho($v);

		// echo $region.'<Br>';
			}//end foreach
		
		}
		else { echo  '<p class="errorfont">出错，没有这个区域： '.$region.'，或者是它的区块都隐藏了。(至少要有一个是显示的)</p>';
				}
 
	 	echo '</div>';	
 
}//end func
 

/*
function regionblock($v){ //only echo the block 

Global $andlangbh;
	 $sqlbuju = "SELECT * from ".TABLE_REGION." where pidname='$v' $andlangbh order by id limit 1";
	// echo $sqlbuju;
	 if(getnum($sqlbuju)>0){
	 	  $result = getrow($sqlbuju);
	 	  regionblockecho($result);

		}
		else  echo  '<p class="errorfont">出错，没有这个标识符 '.$v.'</p>';
}//end func
 */
function regionblockecho($v){ 
	// pre($v);
$pid=$v['pid'];$tid=$v['id'];

		   if(dmlogin()){ //is in func_block. bec declare.bec this file repeat require
               dmeditlink($pid,$tid,'regionblock');		//here is $pid,not pidnmae	   
             }
		 
      //  echo '<div class="blockregion" data-effect="'.$effect.'">';	
      //make simple,no use edit in sub region.------ 
      $bgimgattachment = 'n'; $bgimgposition = 'center center'; $sta_title_posi='center';
	      $effectfile = 'block_regionecho'; $linksize='';
				$effectv = EFFECTROOT.$effectfile.'.php';  
				 if(is_file($effectv)) require ($effectv);
				 else echo '效果文件：'.$effectv.'.php不存在--'.$pid.'--'.$pidname.'<br />';
 
	//-----------------
 
}//end func


function group($grouppidname){
Global $andlangbh;
$sql2 = "SELECT cssname,sta_width_cnt from ".TABLE_BLOCKGROUP." where pidname='$grouppidname'  $andlangbh order by id limit 1";
 
if(getnum($sql2)>0){
	$row2 = getrow($sql2); 
	$cssname =  $row2['cssname'];
	$sta_width_cnt = $row2['sta_width_cnt'];
	//$cssnamev = $cssname<>''?' class="'.$cssname.'"':'';
echo '<div class="blockgroup '.$cssname.'">';
if($sta_width_cnt=='n') echo '<div class="container">';
//-----------------------
$sqlbuju = "SELECT id,name,sta_name,cssname,blockid,desptext,desp from ".TABLE_BLOCKGROUP." where pid='$grouppidname'  and sta_visible='y'  $andlangbh order by pos desc,id";
	//  echo $sqlbuju;
	 // echo '<div class="blockregion" data-effect="mainregion">';
  //no use edit in region
	 if(getnum($sqlbuju)>0){
		 $result = getall($sqlbuju);
		 // pre($result);	
		
			foreach($result as $v){
				$tid = $v['id'];
				 $name = $v['name'];$sta_name = $v['sta_name'];$cssname = $v['cssname'];
				 $blockid = $v['blockid'];

				 
				 $desptext= web_despdecode($v['desptext']);
				 $desp= web_despdecode($v['desp']);			
			if($desptext<>'') $despv = $desptext;
			else  $despv = $desp;
 
			 
				echo '<div class="block '.$cssname.'">'; //block for hover edit link
				if($sta_name=='y') echo '<h3 class="hdgroup">'.$name.'</h3>';
				echo '<div class="desp">';
				 if($blockid==''){
				 	if($despv<>''){//except clear css,no desp
						 if(dmlogin()){ //is in func_block. bec declare.bec this file repeat require		 
				               dmeditlink($grouppidname,$tid,'group');		//here is $pid,not pidnmae	
						  } 
					}
		  			
		  			echo $despv;
		  			
		  		}
				 else {
				 	
				 	block($blockid);
				 	
				 }
				 echo '</div>';
				echo '</div>'; 
				


			}//end foreach
		
		}
		else {  
			echo  '<p class="errorfont">出错，没有这个组合区块： '.$grouppidname.'，或者是它的区块都隐藏了。(至少要有一个是显示的)</p>';

		   }
 
	 	//echo '</div>';	
if($sta_width_cnt=='n') echo '</div>';	

 echo '</div>';		   
  }
 
else{ echo  '<p class="errorfont">出错，没有这个组合区块： '.$grouppidname.'</p>';
}

}//end func




?>
<?php 
function dmlogin(){
		if(ISADMIN=='y' &&STA_FRONTEDIT=='y') return true;
		else return false;
	
} 
 function dmeditlink($pidname,$tid,$type){ 
 	global $curstyle;global $curstylenow; 
 	 
 if($curstyle==$curstylenow){ 	 
 	$urlhere = BASEURL.ADMINDIR;
 	 
 
 	if($type=='regionblock'){  
 			$typefirst=substr($pidname,0,11);
 		  $typereg='common'; 
      if($typefirst=='regionindex') $typereg='index';

 		  $linkv = $urlhere.'/mod_region/mod_region.php?lang='.LANG.'&pid='.$pidname.'&file=editcan&act=edit&tid='.$tid;
 	   
 		  echo  '<div style="position:relative"><a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit dmeditregion">编辑区域</a></div>';

 		//return $_SESSION['isadmin'];
 		//return $_SESSION['admindir'];
 	}
 
 	if($type=='group'){

//mod_regcommon/mod_regcommon.php?lang=cn&pid=regcommon20160822_1126481127&file=addedit&act=edit&tid=319
 $linkv = $urlhere.'/mod_blockgroup/mod_group.php?lang='.LANG.'&pid='.$pidname.'&file=addedit&act=edit&tid='.$tid;
 	   
 		  echo  '<div style="position:relative"><a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit dmeditregion">编辑组合区块</a></div>';
//mod_regcommon/mod_regcommon.php?lang=cn&type=common&pidname=regcommon20160509_1200413359&file=subaddedit&act=edit&tid=109
 		//return $_SESSION['isadmin'];
 		//return $_SESSION['admindir'];
 	}


 	if($type=='vblock'){
 		//vblock have 3: 1 region,2 group, 3,block

         $nodetype =  get_field(TABLE_BLOCK,'pid',$pidname,'pidname');
         $pidcolumn =  get_field(TABLE_BLOCK,'pidcolumn',$pidname,'pidname');	
         $pidcolumn_pid =  get_field(TABLE_COLUMN,'pid',$pidcolumn,'pidname'); 
         
         $fourof_pidcolumn_pid = substr($pidcolumn_pid,0,4);

      
      //mod_column/mod_column.php?lang=cn&pid=sregion20160923_1305203022&type=region&file=editcnt&pidname=colu20170914_1813504419';

         if($fourof_pidcolumn_pid=='sreg')  
         	{
         		$linkv = $urlhere.'/mod_column/mod_column.php?lang='.LANG.'&pid='.$pidcolumn_pid.'&type=region&file=editcnt&pidname='.$pidcolumn;
         	}
         elseif ($fourof_pidcolumn_pid=='group') {
         	$linkv = $urlhere.'/mod_column/mod_column.php?lang='.LANG.'&pid='.$pidcolumn_pid.'&type=group&file=editcnt&pidname='.$pidcolumn;
         }
        else 
        {
         $linkv = $urlhere.'/mod_block/mod_block.php?lang='.LANG.'&file=edit&type='.$nodetype.'&pidname='.$pidname; 
         }		
 		
 		 echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit">编辑区块</a>';

	 }


	if($type=='imgfj'){
       $tid =  get_field(TABLE_IMGFJ,'id',$pidname,'kv');
	 	 ///mod_imgfj/mod_imgfj.php?lang=cn&pid=name&file=edit&act=edit&tid=51
 		$linkv = $urlhere.'/mod_imgfj/mod_imgfj.php?lang='.LANG.'&pid=name&file=edit&act=edit&tid='.$tid;
 		 echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit">编辑附件</a>';

	 }
 
 
	   if($type=='prog'){
         echo  '<a style="display:none" target="_blank" href="javascript:void(0)" style="cursor:default" class="dmedit">请编辑'.$pidname.'</a>';

	 	}	
	 	if($type=='fefile'){
         echo  '<a style="display:none" target="_blank" href="javascript:void(0)" style="cursor:default" class="dmedit">模板：'.$pidname.'</a>';

	 	}
	 	if($type=='part'){ 
         echo  '<a style="display:none" target="_blank" href="javascript:void(0)" style="cursor:default" class="dmedit">请编辑 当前模板/'.$pidname.'</a>';
	 	}
	 //-----------
	 } 
//------------------
}




function columnecho($pidname){
  global $andlangbh;
     $sqlbcolumn = "SELECT * from ".TABLE_COLUMN." where pid='$pidname'  and sta_visible='y'  $andlangbh order by pos desc,id";
	 
	 if(getnum($sqlbcolumn)>0){

	 	$rescol = getall($sqlbcolumn);
		     foreach ($rescol as $v) {
		     	//pre($v);
		     	$width=$v['width'];
		     	$pidcolumn=$v['pidname'];
		     	$floattype=$v['floattype'];
		     	$blockpidname = get_field(TABLE_BLOCK,'pidname',$pidcolumn,'pidcolumn');
		      if($floattype=='clear') 	echo '<div class="c"> </div>';
		      else {
		      	echo '<div class="'.$width.' col'.$floattype.'">'; //use colfl replace fl.because col_1f...has fl.

		      	if($blockpidname<>'noid') block($blockpidname);
		        echo '</div>';
		 	 }


		     }//end foreach




		}

}


function editlink($v,$type){
global $curstyle;global $curstylenow; 
 
 if($curstyle==$curstylenow){ 

    $urlhere = BASEURL.ADMINDIR;
	 if(dmlogin()){  
	 echo '<div class="dmeditnode">';
		    if($type=='node'){
				///mod_node/mod_node_edit.php?lang=cn&act=editcan&tid=47&file=editcan
				$linkv = $urlhere.'/mod_node/mod_node_edit.php?lang='.LANG.'&tid='.$v.'&file=editdesp&act=editcan';
				 echo  '<a target="_blank" href="'.$linkv.'">编辑内容</a>';

			}
			 if($type=='page'){
				///mod_menu/mod_menu_edit.php?lang=cn&file=edit_can&act=edit&tid=6
				$linkv = $urlhere.'/mod_page/mod_page_edit.php?lang='.LANG.'&file=edit_desp&act=edit&tid='.$v;
				 echo  '<a target="_blank" href="'.$linkv.'">编辑内容</a>';

			}
		echo '</div>';	
	 }
//------------------------
}	
//-------------------
}//end func


?>