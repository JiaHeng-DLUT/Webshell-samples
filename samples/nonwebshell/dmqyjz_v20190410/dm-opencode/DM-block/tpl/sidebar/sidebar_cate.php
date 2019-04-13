<?php
if(!defined('IN_DEMOSOSO')) {
exit('this is wrong page,please back to homepage');
}

?>
<div class="sidebarmenu">
<div class="sdheader"><?php echo decode($maintitle)?></div>
<div class="sdcontent">
<?php

//begin cate level 1
$sql = "SELECT * from ".TABLE_CATE." where ppid='$mainpidname'  and sta_visible='y' $andlangbh order by pos desc,id";	// echo getnum($sql);
if(getnum($sql)>0){
$res = getall($sql);
$indexarr = indexingarr($res);
$getnewarr = getnewtreearr($indexarr);
//	pre($getnewarr);
echo   echoarrhtml($getnewarr);

}//end 	if(getnum($sql)>0)
else echo '<ul><li class="m"><a class="m" href="">'.decode($maintitle).'</a></li></ul>';

?>
</div>
</div>

<?php
function echoarrhtml($tree,$multicate='')
{
global $jumpv; global $catid; //catid is catpid.
global  $curcatepidname;
$html = '';
foreach($tree as $vsub)
{

$name = $vsub['name'];
$tid=$vsub['id'];
$level=$vsub['level'];$last=$vsub['last'];

$pidname=$vsub['pidname'];
$pidhere=$vsub['pid']; 

$url = get_url($vsub);
 
$classv = ($pidname == $curcatepidname )?' class= "active" ':'';
$name = '<a   '.$classv. linkhref($url).'">'.$name.'</a>';


	if(@$vsub['son'] == '')
	{
	$html .= '<li>'.$name.'</li>';
	}
	else
 {
	$html .= '<li>'.$name.'';
	if(MULTICATE=='y' || $multicate=='')  $html .= echoarrhtml($vsub['son'],MULTICATE);
	$html = $html."</li>";
 }

}

 return $html ? '<ul class="sidermenutopul">'.$html.'</ul>' : $html ;
// return $html;
}

?>
