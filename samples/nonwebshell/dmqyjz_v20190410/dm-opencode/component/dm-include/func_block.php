<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php
function block($pidname){
$pidname = trim($pidname);
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
   		require(BLOCKROOT.'block_otherlay.php');
	}
	elseif($pidstring=='vide') {
   		//$reqfile = 'video.php';
   		$reqfile = get_field(TABLE_VIDEO,'effect',$pidname,'pidname');
   		 $effect ='video';
   		//echo $reqfile;
   		 $edittype = 'video'; //use for edit linktype
   		require(BLOCKROOT.'block_otherlay.php');
	}
	elseif($pidstring=='albu') {
   		$reqfile = 'album/vv_album.php';
   		 $effect ='album';
   		//echo $reqfile;
   		 $edittype = 'album'; //use for edit linktype
   		require(BLOCKROOT.'block_otherlay.php');
	}
	elseif($pidstring=='musi') {
   		$reqfile = 'music/vv_music.php';
   		 $effect ='music';
   		//echo $reqfile;
   		 $edittype = 'music'; //use for edit linktype
   		require(BLOCKROOT.'block_otherlay.php');
	}

	elseif($pidstring=='imgt') {
   		$reqfile = 'imgtext/vv_imgtext.php';
   		 $effect ='imgtext';
   		//echo $reqfile;
   		 $edittype = 'imgtext'; //use for edit linktype
   		require(BLOCKROOT.'block_otherlay.php');
	}


	elseif($pidstring=='form') {
   		//$reqfile = 'form.php';
   		//$reqfile = get_field(TABLE_FIELD,'effect',$pidname,'pidname');
   		$reqfile = 'form/vv_form.php';
   		 $effect ='form';
   		//echo $reqfile;
   		 $edittype = 'form'; //use for edit linktype
   		require(BLOCKROOT.'block_otherlay.php');
	}





	elseif($pidstring=='prog') {
        $reqfile = 'prog/'.$pidname.'.php';  $effect ='prog';
         $edittype = 'prog'; //use for edit linktype
   		 require(BLOCKROOT.'block_otherlay.php');

	}
		elseif($pidstring=='mypr') { //myprog
          $reqfile = 'myprog/'.$pidname.'.php';  $effect ='myprog';
          $edittype = 'myprog'; //use for edit linktype
   		  require(BLOCKROOT.'block_otherlay.php');

	}
		elseif($pidstring=='dmre') { 
			 if(is_int(strpos($pidname,'/'))){
				  $arrimg = explode('/',$pidname); 
				  $dmregdirname = $arrimg[0];
				  $reqfile = $pidname.'.php';  
			 }
			 else {
				 $dmregdirname = $pidname;
				 $reqfile = $pidname.'/'.$pidname.'.php';  
				 
			 } 			 
			  //$dmregdirname = get_dirname(pathinfo(__FILE__));  			 
			  $curvarimg =  REGIONPATH.$dmregdirname.'/images/';
			 //$curvarimg =  UPLOADPATH.'coolmbimg/'.substr($dmregdirname,9).'/';
			// echo $curvarimg;
			   $effect ='dmregion';          
			  $edittype = 'dmregion'; //use for edit linktype 
			 require(BLOCKROOT.'block_otherlay.php');
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

 

	elseif(in_array($pidifimg,$attach_type)){
		//echo '<div class="bannerimg"><img src="'.UPLOADPATHIMAGE.$pidname.'" alt="" /></div>';
		 $reqfile = 'imgfj'; $effect = 'imgfj';
		  $edittype = 'imgfj'; //use for edit linktype
   		require(BLOCKROOT.'block_otherlay.php');
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
Global $andlangbh; 
echo '<div class="regionwrap">';   
$dmregdir2='';
 $sql2 = "SELECT * from ".TABLE_REGION." where pidname='$region'    $andlangbh order by id";
 if(getnum($sql2)>0){
 	$row2 = getrow($sql2);
   // pre($row2);
 	$dmregdir2 = $row2['dmregdir'];
    $addcss_reg2 = $row2['addcss'];
    $addjs_reg2 = $row2['addjs'];
    if($addcss_reg2<>'') getcssarr($addcss_reg2,$dmregdir2);
    if($addjs_reg2<>'') getjsarr($addjs_reg2,$dmregdir2);

  $sqlbuju = "SELECT * from ".TABLE_REGION." where pid='$region'  and sta_visible='y'  $andlangbh order by pos desc,id";
	 //echo $sqlbuju;
 
	 if(getnum($sqlbuju)>0){
	 	//----------------
	 	 
	 	//--------------------
		 $result = getall($sqlbuju);
		 // pre($result);

			foreach($result as $v){
				  
				 regionblockecho($v);

		// echo $region.'<Br>';
			}//end foreach
 

		}
		else { echo  '<p class="errorfont">出错，没有找到这个区域下的子记录。-- '.$region.'，或者是它的子记录都隐藏了。(至少要有一个是显示的) (注意前后台语言是否一致。)</p>';
				}
	}	
	 
 else{ echo  '<p class="errorfont">出错，没有这个区域： '.$region.' (注意前后台语言是否一致。)</p>';
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


      //  echo '<div class="blockregion" data-effect="'.$effect.'">';
      //make simple,no use edit in sub region.------

	      $effectfile = 'block_regionecho'; $linksize='';

				$effectv = BLOCKROOT.$effectfile.'.php';
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
echo '<div class="c blockgroup '.$cssname.'">';
if($sta_width_cnt=='n') echo '<div class="container">';
//-----------------------
columnecho($grouppidname);
 //-----------------------
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
 	global $curstyle;

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

 	if($type=='group----'){

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
			$editv = '编辑区块';
         $classv="";
          if($fourof_pidcolumn_pid=='sreg')
          	{
          		$linkv = $urlhere.'/mod_column/mod_column.php?lang='.LANG.'&pid='.$pidcolumn_pid.'&type=region&file=editcnt&pidname='.$pidcolumn;
          		$editv = '编辑列';
          		$classv="dmeditcolumn";
          	}
          elseif ($fourof_pidcolumn_pid=='grou') {
          	$linkv = $urlhere.'/mod_column/mod_column.php?lang='.LANG.'&pid='.$pidcolumn_pid.'&type=group&file=editcnt&pidname='.$pidcolumn;
          	$editv = '编辑列';
						$classv="dmeditcolumn";
          }
         else
         {
          $linkv = $urlhere.'/mod_block/mod_block.php?lang='.LANG.'&act=edit&type='.$nodetype.'&pidname='.$pidname;
          }

  		 echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit '.$classv.'">'.$editv.'</a>';

 	 }


	if($type=='video'){
 		 	 //mod_video/mod_video.php?lang=cn&page=0&pid=0&type=block&tid=201&act=edit

		$arr =  get_fieldarr(TABLE_VIDEO,$pidname,'pidname');

		if($arr<>'no'){
			  $tid=$arr['id']; 
			  $type=$arr['type']; 
			  if($type=='block') {
 			 	$linkv = $urlhere.'/mod_video/mod_video.php?lang='.LANG.'&pid=0&type=block&tid='.$tid.'&act=edit';
		   	 	echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit">编辑视频</a>';
			}
		}

	 }
	 if($type=='album'){
		   $arr =  get_fieldarr(TABLE_ALBUM,$pidname,'pidname');
		   	if($arr<>'no'){
		 		$tid=$arr['id']; 
				//mod_album/mod_mainalbum.php?lang=cn&page=0&tid=241&act=edit
 				 $linkv = $urlhere.'/mod_album/mod_mainalbum.php?lang='.LANG.'&tid='.$tid.'&act=edit';
				 echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit">编辑相册</a>';
				}
	 }
	  if($type=='music'){ 
		   $arr =  get_fieldarr(TABLE_MUSIC,$pidname,'pidname'); 
		   	if($arr<>'no'){
		 		$tid=$arr['id']; 
				//mod_album/mod_mainalbum.php?lang=cn&page=0&tid=241&act=edit
 				 $linkv = $urlhere.'/mod_music/mod_mainmusic.php?lang='.LANG.'&tid='.$tid.'&act=edit';
				 echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit">编辑音乐</a>';
				}
	 }
	   if($type=='imgtext'){  
				//mod_imgtext/mod_imgtext.php?lang=cn&pid=imgtext20190401_1332183787
 				 $linkv = $urlhere.'/mod_imgtext/mod_imgtext.php?lang='.LANG.'&pid='.$pidname;
				 echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit">编辑图文生成器</a>';
				
	 }
	    if($type=='imgtextsub'){  
				//mod_imgtext/mod_imgtext.php?lang=cn&file=edit&tid=277&act=edit
 				 $linkv = $urlhere.'/mod_imgtext/mod_imgtext.php?lang='.LANG.'&file=edit&tid='.$tid.'&act=edit';
				 echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit dmeditregion">编辑图文</a>';
				
	 }



 if($type=='form'){
      //mod_form/mod_form.php?lang=cn&pid=block&type=block&file=addedit&act=edit&pidname=form20181219_1421366828
 		 
  $linkv = $urlhere.'/mod_form/mod_form.php?lang='.LANG.'&pid=block&type=block&file=addedit&act=edit&pidname='.$pidname;
		 echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit">编辑表单</a>';

	 }



	if($type=='imgfj'){

		   if(is_int(strpos($pidname,'|'))){
              $arrimg = explode('|',$pidname); 
              $pidname2 = $arrimg[2];
          }
          else  $pidname2 = $pidname;


       $tid =  get_field(TABLE_IMGFJ,'id',$pidname2,'kv');
	 	 ///mod_imgfj/mod_imgfj.php?lang=cn&pid=name&file=edit&act=edit&tid=51
 		$linkv = $urlhere.'/mod_imgfj/mod_imgfj.php?lang='.LANG.'&pid=name&file=edit&act=edit&tid='.$tid;
 		 echo  '<a style="display:none" target="_blank" href="'.$linkv.'" class="dmedit">编辑附件</a>';

	 }


	   if($type=='prog' || $type=='myprog' || $type=='dmregion'){
	    
         echo  '<a style="display:none;top:95px;cursor:default" target="_blank" href="javascript:void(0)" style="cursor:default" class="dmedit">请编辑'.$pidname.'</a>';

	 	}
	 	 
	 //-----------

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
		     	$onlyposi=$v['onlyposi'];
		     	$blockpidname = get_field(TABLE_BLOCK,'pidname',$pidcolumn,'pidcolumn');

		      if($floattype=='clear') 	echo '<div class="c"> </div>';
		      else {
		      	if($floattype=='fl' || $floattype=='fr' ) $floattype = 'col'.$floattype; //use colfl replace fl.because col_1f...has fl.
		      	echo '<div class="'.$width.' '.$floattype.'">';

		      	if($onlyposi=='y') echo '&nbsp;&nbsp;';
		      	else {

		      		if($blockpidname<>'noid') block($blockpidname);

		      	}


		        echo '</div>';
		 	 }


		     }//end foreach




		}

}


function editcate_goadm($cate,$curcate,$detailid){  //for node content...
 
    $urlhere = BASEURL.ADMINDIR;
	
	$catetype = substr($curcate,0,4);
	//mod_layout/mod_layout.php?lang=qing&pid=cate20150805_1125344029&catid=cate20150805_1125344029&type=cate
	//mod_layout/mod_layout.php?lang=qing&pid=csub20150805_1128542682&catid=cate20150805_1125344029&type=cate
	$catelayout = $urlhere.'/mod_layout/mod_layout.php?lang='.LANG.'&pid='.$cate.'&type=cate&catid='.$cate;
	$sublayout = $urlhere.'/mod_layout/mod_layout.php?lang='.LANG.'&pid='.$curcate.'&type=cate&catid='.$cate;
	
	//mod_category/mod_category.php?lang=qing&catid=cate20150805_1125344029&file=edit&act=edit
	//mod_subcate.php?lang=qing&catid=cate20150805_1125344029&file=edit&act=edit&pidname=csub20150805_1127279495
	$catelink = $urlhere.'/mod_category/mod_category.php?lang='.LANG.'&catid='.$cate.'&file=edit&act=edit';
	$sublink = $urlhere.'/mod_category/mod_subcate.php?lang='.LANG.'&catid='.$cate.'&file=edit&act=edit&pidname='.$curcate;
	
	//mod_node/mod_node_edit.php?lang=qing&act=editdesp&tid=575&file=editdesp
	
	$detlink = $urlhere.'/mod_node/mod_node_edit.php?lang='.LANG.'&tid='.$detailid.'&file=editdesp&act=editdesp';
	 if(dmlogin()){
	 echo '<div class="dmeditnode">';
		    if($detailid<>''){
				 echo  '<a   target="_blank" href="'.$detlink.'">编辑详情页</a>';
			}
			 
				//if($catetype=='cate'){
					echo  '<a class="cate" target="_blank" href="'.$catelink.'">编辑主类</a>';
					echo  '<a class="cate" target="_blank" href="'.$catelayout.'">主类布局</a>';
			//	}
				if($catetype<>'cate'){

					echo  '<a class="cate" target="_blank" href="'.$sublink.'">编辑子分类</a>';
					echo  '<a class="cate" target="_blank" href="'.$sublayout.'">子分类布局</a>';
				}
			 
		echo '</div>';
	 }
//------------------------
//}
//-------------------
}//end func


function editpage_goadm($tid,$pidname){  //for node content...

//mod_page/mod_page_edit.php?lang=qing&file=edit_desp&act=edit&tid=107
//mod_layout/mod_layout.php?lang=qing&pid=page20150805_1138522811&type=page

    $urlhere = BASEURL.ADMINDIR;
	$pagelink = $urlhere.'/mod_page/mod_page_edit.php?lang='.LANG.'&file=edit_desp&act=edit&tid='.$tid;
	$layoutlink = $urlhere.'/mod_layout/mod_layout.php?lang='.LANG.'&pid='.$pidname.'&type=page';
	
	 if(dmlogin()){
	 echo '<div class="dmeditnode">';
		   
          echo  '<a target="_blank" href="'.$pagelink.'">编辑单页面</a>';
		  echo  '<a target="_blank" href="'.$layoutlink.'">单页面布局</a>';

		echo '</div>';
	 }
//------------------------
//}
//-------------------
}//end func


?>
