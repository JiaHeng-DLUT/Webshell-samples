<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/

  //pre($_POST);
   $content = @htmlentitdm($_POST['content']);
   $nodepidname = @htmlentitdm($_POST['nodepidname']);
    $formid = @htmlentitdm($_POST['pid']);
    $tokenhour = @htmlentitdm($_POST['tokenhour']);

  $ip =@htmlentitdm(getip());  

$limitsubmitsum = 6; //一小时内，允许发布的记录数。


      $sql = " SELECT *  FROM  ".TABLE_COMMENT."  where ip='$ip' and  lang='".LANG."' and type='formblock' and tokenhour='$tokenhour' order by id desc";
       //echo $sql;
    $result = getnum($sql );
   // echo $result ;
    if($result>=6){  $retvv['id']  = 'norepeat';  }
    else {
        $retvv['id'] =  'yes';
        $pidname = 'comm' . $bshou;
    
        $ss = "insert into ".TABLE_COMMENT." (pbh,pidname,pid,lang,type,nodepidname,ip,tokenhour,desp,dateday,dateedit) values ('".USERBH."','$pidname','$formid','".LANG."','formblock','$nodepidname','$ip','$tokenhour','$content','$dateday','$dateall')";
  //echo $ss;
  //echo 'ok';//repeat ajax twice
   iquery($ss);
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