<title>del</title>
 
<?php
/*  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
 
require_once '../config_a/common.inc2010.php';
//

 

//exit;

//echo 'no use temp';
//exit;

  
    $ss3 = "select * from ".TABLE_REGION." where pid like '%regin%'  ";
     
    $rowall3 = getall($ss3);
    if(getnum($ss3)>0){
      foreach($rowall3 as $v2){
        $title2 = $v2['name'];
        $pid  = $v2['pid'];
       $pidname2v = 'regionindex'.substr($pid,10);
        
       echo '<br>'.$title2.' --- '.$pid .' --- '.$pidname2v ;

     
      $ss = "update ".TABLE_REGION." set pid = '$pidname2v' where pid  = '$pid'  ";
   //iquery($ss);


 }
      
      
    }
       
   // $delsql2 = "delete  from ".TABLE_CATE." where  pidname = '$v'";
    //iquery($delsql2);
   
   
 


 
 
 
?>