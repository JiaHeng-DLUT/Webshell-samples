 
<?php 
if($type=='page'){

 $sql = "SELECT pidname,name  from ".TABLE_PAGE." where  pid='0'  $andlangbh  order by pos desc,id"; 
$rowlist = getall($sql);
 if($rowlist=='no') echo $norr2;
 else{

echo '<ul>';
   foreach($rowlist as $v){
	 
	$pidnamemain = $v['pidname']; 
	$name = decode($v['name']); 
	//$jsname = jsdelname($v['name']);

	$sqlYY = "SELECT  id  from ".TABLE_LAYOUT." where  pid='$pidnamemain' and pidstylebh='$curstyle' and type='$type' $andlangbh order by pos desc,id";	
	$youv = '';	
	if(getnum($sqlYY)>0) $youv = '<span class="cgray">(有)</span>';
 

 //pre($rowlist);

$stylev='';
if($pidnamemain==$pid) $stylev=' style="background:red;color:#fff" ';

	  echo  '<li><i class="fa fa-angle-right"></i> <a  '.$stylev.' href="'.$jumpv.'&pid='.$pidnamemain.'&type=page">'.$name.'</a>'.$youv.' </li>';
	 

	}

echo '</ul>';
}

}

if($type=='common'){
	echo '这里是公共布局，即默认布局。<br />因为有时并不需要每个页面都要设置布局，则会使用默认布局。';
	$linkhere = '../mod_btheme/mod_style.php?lang='.LANG.'&pidname='.$curstyle.'&file=edit_blockid&act=edit';
	 
	}




if($type=='cate' ||  $type=='csub'  ||  $type=='read'){
	

 $sqlsub = "SELECT pidname,name from ".TABLE_CATE." where  pid='$catid' $andlangbh order by pos desc,id";
 $rowlistsub = getall($sqlsub);
 if($rowlistsub=='no') {
  echo '<p>&nbsp;&nbsp;还没有子分类，请添加...</p>';
  }
  else{
  ?>
  <strong><?php echo $catename;?> 的子分类：</strong><br />
 <?php
 echo '<ul>';
   foreach($rowlistsub as $vsub){
          
		   $pidname=$vsub['pidname'];  
		   $name=decode($vsub['name']);   	

		   $styleSubV = $styleSubVread='';
			if($pidname==$pid) {
				if($type=='read') $styleSubVread=' style="background:red;color:#fff" ';
				else  $styleSubV=' style="background:red;color:#fff" ';
			}
			 	   
		
			$sqlYY = "SELECT  id  from ".TABLE_LAYOUT." where  pid='$pidname' and pidstylebh='$curstyle' and type='cate' $andlangbh order by pos desc,id";	
			$youv = '';	
			if(getnum($sqlYY)>0) $youv = '<span class="cgray">(有)</span>';

			$sqlYYread = "SELECT  id  from ".TABLE_LAYOUT." where  pid='$pidname' and pidstylebh='$curstyle' and type='read' $andlangbh order by pos desc,id";	
			$youreadv = '';	
			if(getnum($sqlYYread)>0) $youreadv = '<span class="cgray">(有)</span>';


		  $laylist = '(<a '.$styleSubV.'  href="'.$jumpv.'&pid='.$pidname.'&catid='.$catid.'&type=cate">列表</a>'.$youv.' - ';
	    $layread= '<a '.$styleSubVread.'  href="'.$jumpv.'&pid='.$pidname.'&catid='.$catid.'&type=read">详情</a>'.$youreadv.')';
		echo '<li><i class="fa fa-angle-right"></i>'.$name.$laylist.$layread.'</li>';
 
					
//----if sub sub cat------------------------
         $sqlsub_sub = "SELECT  pidname,name  from ".TABLE_CATE." where  pid='$pidname' $andlangbh order by pos desc,id";		
         $row_sub = getall($sqlsub_sub);
		  if($row_sub<>'no') $sslevel = "update ".TABLE_CATE." set level=1,last='n' where id='$tid' $andlangbh limit 1";
			else $sslevel = "update ".TABLE_CATE." set level=1,last='y' where id='$tid' $andlangbh limit 1";
        iquery($sslevel); 



  
      //----if sub sub cat------------------------       
         if($row_sub<>'no'){
         	 echo '<ul>';
              foreach($row_sub as $v2_sub){
					$nameSub=decode($v2_sub['name']);   
					$subpidname=$v2_sub['pidname'];


 $styleSubV = $styleSubVread='';
if($subpidname==$pid) {
	if($type=='read') $styleSubVread=' style="background:red;color:#fff" ';
	else  $styleSubV=' style="background:red;color:#fff" ';
}



$sqlYY2 = "SELECT  id  from ".TABLE_LAYOUT." where  pid='$subpidname' and pidstylebh='$curstyle' and type='cate' $andlangbh order by pos desc,id";	
$youv2 = '';	
if(getnum($sqlYY2)>0) $youv2 = '<span class="cgray">(有)</span>';

$sqlYYread2 = "SELECT  id  from ".TABLE_LAYOUT." where  pid='$subpidname' and pidstylebh='$curstyle' and type='read' $andlangbh order by pos desc,id";	
$youreadv2 = '';	
if(getnum($sqlYYread2)>0) $youreadv2 = '<span class="cgray">(有)</span>';


		 $laylistSub = '(<a '.$styleSubV.' href="'.$jumpv.'&pid='.$subpidname.'&catid='.$catid.'&type=cate">列表</a>'.$youv2.' - ';
	    $layreadSub= '<a  '.$styleSubVread.'  href="'.$jumpv.'&pid='.$subpidname.'&catid='.$catid.'&type=read">详情</a>'.$youreadv2.')';
		echo '<li><i class="fa fa-angle-right"></i>'.$nameSub.$laylistSub.$layreadSub.'</li>';

					 
				}
				 echo '</ul>';
				 



	}
	}
	echo '</ul>';
}



} //end cate or subcate




?>


 