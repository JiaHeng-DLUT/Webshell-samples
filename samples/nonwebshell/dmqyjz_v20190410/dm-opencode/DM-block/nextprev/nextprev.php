<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}
?>
<?php 
//上一篇和下一篇，是以哪个为主？
$pid_nextprev = "ppid='$mainpidname'";
//$pid_nextprev = "pid='$curcatepidname'";


//prev page：

$sqlrele  = "select * from ".TABLE_NODE." where id>$detailid and pos=$detail_pos and $pid_nextprev  and sta_visible='y' $andlangbh order by id limit 1";
$sqlrele2  = "select * from ".TABLE_NODE." where pos>$detail_pos and $pid_nextprev and sta_visible='y' $andlangbh order by pos,id limit 1";

$rowrele = getrow($sqlrele);
if($rowrele=='no') $sqlrele_cur = $sqlrele2;
else $sqlrele_cur = $sqlrele;

 //echo $sqlrele_cur;
$rowrele = getrow($sqlrele_cur);
//pre($rowrele);
if($rowrele<>'no'){ 
    $rele_tid=$rowrele['id'];
    $rele_pidname=$rowrele['pidname'];    
	//$rele_alias=alias($rele_pidname,'node');  
    $rele_url =get_url($rowrele);

	 $rele_pre = '<a href="'.$rele_url.'">'.$rowrele['title'].'</a>';
}
else {$rele_pre = NEXTPREV_NO;}//没有了'

//next page
$sqlrele  = "select * from ".TABLE_NODE." where id<$detailid and pos=$detail_pos and $pid_nextprev and sta_visible='y' $andlangbh order by id desc limit 1";
$sqlrele2  = "select * from ".TABLE_NODE." where pos<$detail_pos and $pid_nextprev and sta_visible='y' $andlangbh order by pos desc,id desc limit 1";
$rowrele = getrow($sqlrele);
if($rowrele=='no') $sqlrele_cur = $sqlrele2;
else $sqlrele_cur = $sqlrele;

//echo $sqlrele_cur;
$rowrele = getrow($sqlrele_cur);
//pre($rowrele);
if($rowrele<>'no'){      
    $rele_tid=$rowrele['id'];
    $rele_pidname=$rowrele['pidname'];    
	//$rele_alias=alias($rele_pidname,'node');  
    $rele_url = get_url($rowrele);
	 $rele_next = '<a href="'.$rele_url.'">'.$rowrele['title'].'</a>';
 
}
else {$rele_next =  NEXTPREV_NO;}


?>
<ul class="pagerele">
<li><?php echo NEXTPREV_PREV.'：'.$rele_pre; //上一篇?></li>
<li><?php echo NEXTPREV_NEXT.'：'.$rele_next; //下一篇?></li>
</ul>

<?php 
/*
echo '上一篇:';
$has_pre=mysql_fetch_array(mysql_query("select * from content where id>$id and pos=$pos order by id limit 1"));
 
$rel_pre=$has_pre[0]?$has_pre:mysql_fetch_array(mysql_query("select * from content where pos>$pos order by pos,id limit 1"));
 
echo $rel_pre['name'];
 
echo '下一篇:';
$has_next=mysql_fetch_array(mysql_query("select * from content where id<$id and pos=$pos order by id desc limit 1"));
 
$rel_next=$has_next[0]?$has_next:mysql_fetch_array(mysql_query("select * from content where pos<$pos order by pos desc,id desc limit 1"));
 
echo $rel_next['name'];
*/

?>