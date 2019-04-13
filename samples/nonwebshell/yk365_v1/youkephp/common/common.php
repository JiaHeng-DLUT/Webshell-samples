<?php
function table($table){
  return TABLE_PREFIX.$table;
}
//请求过滤函数
function youke_addslashes($data){
 if($data){
	  array_walk_recursive($data, function(&$v) { $v = addslashes($v);} );	
	}

 return $data;	
}

// function config(){
	
	// include 
// }