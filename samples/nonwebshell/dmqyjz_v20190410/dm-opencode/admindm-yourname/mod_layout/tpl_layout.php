<div class="layoutheader">

<?php
 echo $stylename; //in common.inc
?>

 <?php
  $styleSubVTop =$styleSubVToptag = '';
  if($type=='common') {
	  $styleSubVTop=' style="background:red;color:#fff" ';
	}
	if($type=='tag') {
	  $styleSubVToptag=' style="background:red;color:#fff" ';
	}
 
 ?>
<a <?php echo $styleSubVTop;?> href="<?php echo $jumpv?>&pid=common&type=common">公共布局</a> &nbsp;&nbsp;

<a href="<?php echo $jumpv?>&type=page">单页面</a>&nbsp;&nbsp;&nbsp;
<a <?php echo $styleSubVToptag;?> href="<?php echo $jumpv?>&pid=tag&type=tag">标签</a>&nbsp;&nbsp;&nbsp;


<strong><a title="进入分类管理" target="_blank"    href="../mod_category/mod_category.php?lang=<?php echo LANG;?>">分类</a>的布局：</strong>
<?php
$sql = "SELECT pidname,name from ".TABLE_CATE." where   modtype='node' and pid='0'   $andlangbh  order by pos desc,id desc";
$rowlist = getall($sql);
 if($rowlist=='no') echo $norr2;
 else{

	foreach($rowlist as $v){

	$pidnamemain = $v['pidname'];
	$name = decode($v['name']);


	$sqlYY2 = "SELECT  id  from ".TABLE_LAYOUT." where  pid='$pidnamemain' and pidstylebh='$curstyle' and type='cate' $andlangbh order by pos desc,id";
	$youv2 = '';
	if(getnum($sqlYY2)>0) $youv2 = '<span class="cgray">(有)</span>';

	$sqlYYread2 = "SELECT  id  from ".TABLE_LAYOUT." where  pid='$pidnamemain' and pidstylebh='$curstyle' and type='read' $andlangbh order by pos desc,id";
	$youreadv2 = '';
	if(getnum($sqlYYread2)>0) $youreadv2 = '<span class="cgray">(有)</span>';


 $styleSubVTop = $styleSubVTopread='';
			if($pidnamemain==$pid) {
				if($type=='read') $styleSubVTopread=' style="background:red;color:#fff" ';
				else  $styleSubVTop=' style="background:red;color:#fff" ';
			}



	   $laylist = '(<a '.$styleSubVTop.' href="'.$jumpv.'&pid='.$pidnamemain.'&catid='.$pidnamemain.'&type=cate">列表</a>'.$youv2.' - ';
	    $layread= '<a '.$styleSubVTopread.' href="'.$jumpv.'&pid='.$pidnamemain.'&catid='.$pidnamemain.'&type=read">详情</a>'.$youreadv2.')';
		echo $name.$laylist.$layread.'&nbsp; | &nbsp;';



}
}


?>

</div>

 <div class="layoutsidebar fl col-xs-12 col-sm-12  col-md-2">

     <?php  require_once HERE_ROOT.'mod_layout/tpl_layout_sidebar.php'; ?>

</div>

 <div class="fl col-xs-12 col-sm-12  col-md-10">
    <?php
 if($pid=='') echo '请先在上面或左边选择';
    else{
    	$linkhere = '../mod_btheme/mod_style.php?lang='.LANG.'&pidname='.$curstyle.'&file=edit_blockid&act=edit';

		if($alias=='index') echo '(提示，如果是首页，不在这里布局，<br />首页的布局由  模板管理-->修改标识 里操作<br /><br />';
     	else {


			   $sqllayout = "SELECT * from ".TABLE_LAYOUT."  where pid='$pid' and pidstylebh='$curstyle' and type='$type'  $andlangbh order by id limit 1";
			   //cancel and stylebh='$stylebh'
					 //echo $sqllayout; exit;
					 if(getnum($sqllayout)>0){
					   $row = getrow($sqllayout);
					   $tid=$row['id'];
					   $pagetemplate='';
					   //$bannertext=zbdesp_imgpath($row['bannertext']);
					   $bannermobi='';
					   $arr_can = $row['layoutcan'];
					   $header_pc = $skincss = $selemenu = '';
					    //echo $arr_can;
					   $bscntarr = explode('==#==',$arr_can);// pre($bscntarr);
					   if(count($bscntarr)>1){
						 foreach ($bscntarr as   $bsvalue) {
						  if(strpos($bsvalue, ':##')){
							$bsvaluearr = explode(':##',$bsvalue);
							$bsccc = $bsvaluearr[0];
							$$bsccc=$bsvaluearr[1];
						  }
						}
					  }

					   require_once HERE_ROOT.'mod_layout/tpl_layout_rg.php';

					   }
					 else{

						if($type=='common'){
							$pidname='layout'.$bshou;
							$ss = "insert into ".TABLE_LAYOUT." (pid,pidname,pidstylebh,pbh,lang,type,layoutcan,dateedit) values ('$pid','$pidname','$curstyle','$user2510','".LANG."','$type','$arr_layoutcan','$dateall')";
							iquery($ss);
							$jumpv2 = $jumpv.'&pid='.$pid.'&catid='.$catid.'&type='.$type;
							jump($jumpv2);
						}
						else{
							$jumpv2 = $jumpv.'&pid='.$pid.'&catid='.$catid.'&type='.$type.'&act=insert';
							if($pidstring=='csub')  echo '<br /><br />没有布局，则会<strong class="cred">继承主类的布局</strong>。如果主类也没有布局，则<strong class="cred">继承公共布局</strong>。';
							else echo '<br /><br />没有布局，则会<strong class="cred">继承公共布局</strong>。';
							echo '<br />是否<a href="'.$jumpv2.'">创建布局?</a>';
						}
					}


	}
}
    ?>
 </div>


<div class="c"> </div>
