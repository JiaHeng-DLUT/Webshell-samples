
<div class="siteheader">
<div class="fr">
	 <a href="<?php echo  BASEURLPATH;?>" target="_blank" class="fl tdn headerfront">查看网站></a> 
	 <div class="fl headeruser">
	 	<img class="clicknextshow" src="../cssjs/img/user.png" height="24" alt="user" />
	 		<div class="headeruserinc">
	 		 
	 			 <a href="../mod_common/logout.php" title="退出"><span>退出></span></a> 

	 		</div>

	 </div>
</div>

<h1 class="fl"><?php echo  $websitename;?></h1> 

</div>

<div class="c0"></div>
<ul class="navdm">
<li class="main"><a href="<?php echo $adminurl?>">后台首页</a></li>
  
 <li class="main navblock"><a href="javascript:void(0)" style="cursor:default">内容管理</a>
 <div class="poa dn xialabox">
	  <div class="xialabox_inc">
	     <?php contentsub();    ?>	      
	 </div>
  </div>
 <span class="subicon"><i class="fa fa-caret-down"></i></span> 
 </li>
 

 


 
<!--
 <li ><a href="javascript:this.location.reload()"><b class="cyel">刷新页面</b></a></li>-->
</ul>

<div class="c0"></div>




<?php 
/******************************/
function p20_getmodmenu($k,$name) {
	Global $andlangbh;Global $arrayprevi;
	echo '<strong>'.$name.'：</strong>';
	$ss = "select pidname,name from ".TABLE_CATE." where   pid='0' and modtype='$k' $andlangbh order by pos desc,id";
	//echo $ss;exit;
	if(getnum($ss)>0){
		$row = getall($ss);
		foreach($row as $v){
		   // $bszj=explode('-', $v['bs_zj']);//like news1-news 
			$catpid = $v['pidname'];
			$strpos = strpos($arrayprevi,$catpid);
			if(is_int($strpos)){ 
				   if($k=='node'){
						   	$link='../mod_node/mod_node.php?lang='.LANG.'&catpid='.$catpid;
						}
						echo '<a href="'.$link.'">'.decode($v['name']).'</a>  ';
			}	
		  // else if($k=='book') $link='../mod_book/mod_book.php?lang='.LANG.'&catpid='.$v['pidname'];
		  // else if($k=='hr') $link='../mod_hr/mod_hr.php?lang='.LANG.'&catpid='.$v['pidname'];
	
		}
	}
	else echo '此模块暂无分类... | ';
}//end func

 
 

 function contentsub() { global $arr_mod;
 
 
	  foreach($arr_mod as $k=>$name){
					   //echo $k;
						p20_getmodmenu($k,$name);
					 }
}//end func
 
   
?> 

