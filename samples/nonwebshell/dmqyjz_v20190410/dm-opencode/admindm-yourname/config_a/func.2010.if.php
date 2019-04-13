<?php
function ifhaspidname($table,$pidname){ //ifhascate
Global $andlangbh;
$ss = "select * from $table where pidname= '$pidname' limit 1";// $andlangbh  becuase effect
//echo $ss;
		$row = getrow($ss);

		$error22='出错，标识不存在!'.$table;
		if($row=='no'){
			echo($error22);exit;
			//alert($error22);jump(HOME_ADMIN);
		}

}

function ifhaspidname2($table,$pidname){ //ifhascate
Global $andlangbh;
$ss = "select * from $table where pidname= '$pidname' $andlangbh limit 1";
//echo $ss;
		$row = getrow($ss);
		if($row=='no') return false;
		else return true;

}
//end func

function ifhasid($table,$tid){ //ifhascate
Global $andlangbh; Global $backlist;
$ss = "select * from $table where id= '$tid' $andlangbh limit 1";
//echo $ss;
		$row = getrow($ss);
		$error22='出错，no ID! '.$table;
		if($row=='no'){
			echo($error22.$backlist);exit;
			//alert($error22);jump(HOME_ADMIN);
		}

}
//end func
function ifhasrecord($table,$v,$k,$text){
	Global $andlangbh;
	$ss = "select id from $table where $k= '$v' $andlangbh order by id limit 1";
	//echo $ss;
	if(getnum($ss)>0) return true;
	else {
		if($text<>'') {echo $text;exit;}
		return false;
	}
}
//end func

function ifhasid_nolang($table,$tid){ //ifhascate
Global $andlangbh; Global $backlist;
$ss = "select * from $table where id= '$tid'  limit 1";
//echo $ss;
		$row = getrow($ss);
		$error22='出错，no ID! '.$table;
		if($row=='no'){
			echo($error22.$backlist);exit;
			//alert($error22);jump(HOME_ADMIN);
		}

}
//end func




function ifaliasrepeat($alias,$curid,$type,$backpage){
Global $andlangbh;
  if($type=='maincate'){
		$ss = "select * from ".TABLE_CATE." where alias= '$alias' and pid='0' and pidname<>'$curid' $andlangbh limit 1";
			$row = getrow($ss);
	}
	if($row<>'no'){
	alert('出错，别名已存在。');jump($backpage);
	}
}
//end func






function ifhave_lang($lang){
	$sql = "SELECT id from ".TABLE_LANG."  where  lang='$lang' and pbh='".USERBH."' order by id";
	//echo $sql;
    $row= getrow($sql);
    if($row=='no'){
		echo('出错，此语言不存在。请选择正确的语言!');exit;
		//alert('出错，此语言不存在。请选择正确的语言!');jump(HOME_ADMIN);

	}//this judge is important

}//end func

function ifhave_theme($theme){
	$sql = "SELECT id from ".TABLE_THEME."  where  lang='$lang' and pbh='".USERBH."' order by id";
	//echo $sql;
    $row= getrow($sql);
    if($row=='no'){
		echo('出错，此语言不存在。请选择正确的语言!');exit;
		//alert('出错，此语言不存在。请选择正确的语言!');jump(HOME_ADMIN);

	}//this judge is important

}//end func

//-----------------------------
function ifcandel($table,$pidname,$error,$back){
Global $andlangbh;
   $ss = "select id from $table where pid= '$pidname' $andlangbh limit 1"; 
		$row = getrow($ss);
		if($row=='no'){
		 return true;//go to ifsuredel();
			}
			else {alert($error);jump($back);return false;}

}//end func

function ifcandel_field($table,$field,$value,$typelike,$error,$back){
Global $andlangbh;
    if($typelike=='like')  $ss2 = "select id  from $table where $field like  '%$value%' $andlangbh limit 1";
 	else   $ss2 = "select id  from $table where $field= '$value' $andlangbh limit 1";
	 //echo $ss2; exit;
		$row = getrow($ss2);
		if($row=='no'){
		 return true;//go to ifsuredel();
			}
			else {alert($error);jump($back);return false;}



}//end func



function ifsuredel($deltable,$pidname,$back){
Global $andlangbh;
		$ss2 = "delete from $deltable where pidname= '$pidname' $andlangbh limit 1";
		 //echo $ss2.'<br />';
			iquery($ss2);
			//when dele two,need this,like delete menu in pro-cmenu-edit.php
			if($back<>'noback') {
				//alert('删除成功！');
			jump($back);
		}


}//end func

function ifsuredel_field($table,$field,$value,$typelike,$back){
Global $andlangbh;
 if($typelike=='like')  $ss2 = "delete from $table where $field like  '%$value%' $andlangbh limit 1";
 	else   $ss2 = "delete from $table where $field= '$value' $andlangbh limit 1";
	//echo $ss2; exit;
			iquery($ss2);
			//when dele two,need this,like delete menu in pro-cmenu-edit.php
			if($back<>'noback') {
				//alert('删除成功！');
				jump($back);}


}//end func

function ifsuredel_fieldmore($table,$field,$value,$typelike,$back){
// no  limit 1
 if($typelike=='like')  $ss2 = "delete from $table where $field like  '%$value%' ".ANDLANGBH;
 	else   $ss2 = "delete from $table where $field= '$value'  ".ANDLANGBH;
	//echo $ss2; exit;
			iquery($ss2);
			//when dele two,need this,like delete menu in pro-cmenu-edit.php
			if($back<>'noback') {
				//alert('删除成功！');
				jump($back);}


}//end func

/*
function ifcandel_byid($deltable,$tid,$back){
Global $andlangbh;
		$ss2 = "delete from $deltable where id= '$tid' $andlangbh limit 1";
			// echo $ss2;exit;
			iquery($ss2);
			if($back<>'noback') {alert('删除成功！');jump($back);}


}//end func
function ifcandel_bypid($deltable,$pid,$back){
Global $andlangbh;
		$ss2 = "delete from $deltable where pid= '$pid' $andlangbh limit 1";
			// echo $ss2;exit;
			iquery($ss2);
			if($back<>'noback') {alert('删除成功！');jump($back);}


}//end func
*/


//-------------------------------------
