<?php
function navlang(){//use in header.php
// $sql = "SELECT * from ".TABLE_LANG." where pbh='".USERBH."' and sta_visible='y' order by pos desc,id";
 
 $sql = "SELECT * from ".TABLE_LANG." where pbh='".USERBH."' and sta_visible='y' order by pos desc,id";
 
$rowlist = getall($sql);
if($rowlist=='no') echo '暂无内容';
else{
	foreach($rowlist as $v){
	$name=$v['name'];$sta_main=$v['sta_main'];
	$langhere=$v['lang'];
	 
		if($sta_main=='y'){
			$sta_main_v = '(<span class="cred">主语言</span>)';
		}
		else $sta_main_v='';
		
		  echo '<option value="'.$langhere.'">'.$name.$sta_main_v.'</option>';
	}
}
}
//end func

function mainlangnum(){ //use in header.php
 $sql = "SELECT name from ".TABLE_LANG." where pbh='".USERBH."' and sta_main='y'"; 
$num = getnum($sql); 
 return($num);
}

function navlang_cur(){ //use in header.php
 $sql = "SELECT name from ".TABLE_LANG." where pbh='".USERBH."' and lang='".LANG."'  limit 1"; 
$row = getrow($sql);
if($row=='no') return('请选择');
else return($row['name']);
}
//end func

 /* move to welcome.php
function navlang_main(){//use in common.php //must give first in mysql
 $sql = "SELECT pidname from ".TABLE_LANG." where pbh='".USERBH."' and sta_main='y'  limit 1"; 
 echo $sql;
$row = getrow($sql);
return($row['pidname']);
}*/
//end func
 
 function navlang_auto_big5(){//big5 is pre give in mysql; use in common.php
 $sql = "SELECT sta_auto_big5 from ".TABLE_LANG." where pbh='".USERBH."' and pidname='big5'  limit 1"; 
$row = getrow($sql);
return($row['sta_auto_big5']);
}
//end func


//---------theme
 function getthemeid($theme){ 
 $sql = "SELECT themeid from ".TABLE_THEME." where pbh='".USERBH."' and name='$theme'  limit 1"; 
$row = getrow($sql);
if($row=="no") {echo 'error,theme is not exist;';exit;}
else return($row['themeid']);
}
//end func


 
 
 