<?php
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}


?>


<?php
if(substr($curcatepidname,0,4)=='csub') {  
	 $pidcate = get_field(TABLE_CATE,'pid',$curcatepidname,'pidname');

	 if(substr($pidcate,0,4)=='csub'){
            $wherev = "    pid='$pidcate' ";
	 }
	 else{

		$sql = "SELECT * from ".TABLE_CATE." where  pid='$curcatepidname'   and sta_visible='y' $andlangbh order by pos desc,id";	
		//echo $sql;
		$num = getnum($sql);
		if($num>0){
			 $wherev = "    pid='$curcatepidname' ";
		}
		else $wherev = "    pid='$mainpidname' ";
	}

  
	//echo $pidcate;
} 
else  $wherev = "    pid='$mainpidname' ";


//begin cate level 1
$sql = "SELECT * from ".TABLE_CATE." where  $wherev   and sta_visible='y' $andlangbh order by pos desc,id";	
//echo $sql;
$num = getnum($sql);
if($num>0){
$res = getall($sql);
$indexarr = indexingarr($res);
$getnewarr = getnewtreearr($indexarr);
//	pre($getnewarr);
echo '<ul class="sidermenutop sidermenutop_num'.$num.'">';
echo   echoarrhtml($getnewarr);
echo '</ul>';

}//end 	if(getnum($sql)>0)
//else echo '<ul class="sidermenutop sidermenutop_num1"><li class="m"><a class="m" href="">'.decode($maintitle).'</a></li></ul>';

?>


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
 
$url =  get_url($vsub);
 
$classv = ($pidname == $curcatepidname )?' class= "active" ':'';
$name = '<a   '.$classv. linkhref($url).'">'.$name.'</a>';


 if(@$vsub['son'] == '')
 {
 $html .= '<li>'.$name.'</li>';
 }
 else
 {
 $html .= '<li>'.$name.''; //if top , only 1 level...
  //  if(MULTICATE=='y' || $multicate=='')  $html .= echoarrhtml($vsub['son'],MULTICATE);
 $html = $html."</li>";
 }

}

//  return $html ? '<ul class="sidermenutopul">'.$html.'</ul>' : $html ;
return $html;
}

?>
