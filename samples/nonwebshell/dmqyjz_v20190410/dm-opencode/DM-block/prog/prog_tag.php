    


<div class="taglinkwrap">
 
	 
	<div class="taglink">


<?php
global $noandlangbh;global $page;global $sta_tag_shownum;
 $sql = "SELECT * from ".TABLE_TAG." where  $noandlangbh and sta_visible='y' order by pos desc,id";
$rowlist = getall($sql);
if($rowlist=='no') echo '暂无内容';
else{
foreach($rowlist as $v){
	$tid = $v['id'];
	$name = $v['name'];
	$tagpidname = $v['pidname'];
	$weight = $v['weight'];
 
	//$taglink = BASEURLPATH.'tag-'.$tid.'.html';
    $taglink = get_url($v);

  $ss="select id from  ".TABLE_TAGNODE."  where tag='$tagpidname'   $andlangbh";
$ssnum = getnum($ss);

if($sta_tag_shownum=='y') $numv = '<span>('.$ssnum.')</span>';
else $numv = '';

	?>

  <a href="<?php echo $taglink?>" class="taglink<?php echo $weight?>"  ><?php echo $name;?><?php echo $numv?></a>
									 
  <?php

	 }
	}
 ?>
	</div>
</div>

 










 