<?php 
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
}

   $sql = "SELECT title,desp   from ".TABLE_NODE." where  id='$tid'  $andlangbh order by pos desc,id desc limit 5"; //pos desc,id desc
  //echo $sqltextlist;
    /*begin page roll*/
     $num_rows = get_numrows($sql);
     if($num_rows>0){
         $result = getrow($sql);
         $desp= web_despdecode($result['desp']);
         $result['desp'] = $desp;

        
		// pre($result);
		// pre($_SERVER['HTTP_ACCEPT']);
		$jsonv = json_encode($result,JSON_UNESCAPED_UNICODE);
		//echo jsonv;
		  echo api_jsonp_encode($jsonv); 
		 
	 }
 

 

		
?>