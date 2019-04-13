<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/

  //pre($_POST);
   $nickname = @htmlentitdm($_POST['nickname']);
   $email = @htmlentitdm($_POST['email']);
    $telephone = @htmlentitdm($_POST['telephone']);
      $ps = @htmlentitdm($_POST['ps']);
    $tokenhour = @htmlentitdm($_POST['tokenhour']);

  $ip =@htmlentitdm(getip());  

$limitsubmitsum = 6; //一小时内，允许发布的记录数。



    $sql = "SELECT nickname from ".TABLE_AUTH." where nickname = '$nickname' and  lang='". LANG ."'  order by id desc";
    $num1 = getnum($sql);

    $sql = "SELECT email from ".TABLE_AUTH." where email = '$email' and  lang='". LANG ."'  order by id desc";
    $num2 = getnum($sql);

    $sql = "SELECT telephone from ".TABLE_AUTH." where telephone = '$telephone' and  lang='". LANG ."'  order by id desc";
    $num3 = getnum($sql);

    if($num1>0 && $nickname<>'')
    { $retvv['id']  = 'repeat_nickname'; 
    }
    else if($num2>0 && $email<>'')
    { $retvv['id']  = 'repeat_email'; 
    }
    else if($num3>0 && $telephone<>'')
    {

        $retvv['id']  = 'repeat_telephone'; 
    }
 else{



      $sql = " SELECT *  FROM  ".TABLE_AUTH."  where ip='$ip' and  lang='".LANG."' and   tokenhour='$tokenhour' order by id desc";
       //echo $sql;
    $result = getnum($sql );

   // echo $result ;
   
        if($result>=6){  $retvv['id']  = 'norepeat';  }
        else {

            $retvv['id'] =  'yes';
            $pidname = 'mem' . $bshou.'t'.rand(11111,99999);
        $ps= htmlentitdm(crypt($ps, $salt));
             $ss = "insert into ".TABLE_AUTH." (pbh,pidname,lang,nickname,email,telephone,ps,ip,tokenhour,dateday,dateedit) values ('".USERBH."','$pidname','".LANG."','$nickname','$email','$telephone','$ps','$ip','$tokenhour','$dateday','$dateall')";
       //echo $ss;
      //echo 'ok';//repeat ajax twice
       iquery($ss);
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