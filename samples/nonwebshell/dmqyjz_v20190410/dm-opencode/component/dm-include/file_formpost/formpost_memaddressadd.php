<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/

  //pre($_POST);
 $email = @htmlentitdm($_POST['email']);
  $ps = @htmlentitdm($_POST['ps']);
  
  if(is_int(strpos($email,'@')))  $wherev = " email='$email' ";
  else $wherev = " telephone='$email' ";

  $ps= htmlentitdm(crypt($ps, $salt));

  if($email=='' || $ps==''){ $retvv['id']  = 'fail'; }
else{
   $sql = " SELECT pidname  FROM  ".TABLE_AUTH."  where $wherev and ps='$ps' and lang='".LANG."'  order by id desc";
        //echo $sql;
    $result = getnum($sql );

   // echo $result ;
   
        if($result==0){  $retvv['id']  = 'fail';  }
        else { 
            $retvv['id'] =  'yes';
            $row=getrow($sql);
            $pidname = $row['pidname']; 
            $_SESSION['mempidname']=$pidname; 
            }  
      }
//pre($retvv);


  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      $retvv = json_encode($retvv);
      echo $retvv;
        die();
   }
    else {
    //header("Location: ".$_SERVER["HTTP_REFERER"]);
      echo 'pls do not access here directly';
   }

  ?>