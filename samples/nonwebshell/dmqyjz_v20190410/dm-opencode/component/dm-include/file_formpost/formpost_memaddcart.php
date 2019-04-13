<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/

  //pre($_POST);
 if (isset($_SESSION['mempidname'])){
    $mempidname = $_SESSION['mempidname'];
     
     //$mempidname = 'test...';
    $sql = " SELECT *  FROM  ".TABLE_AUTH."  where  pidname='$mempidname' and lang='".LANG."'  order by id desc";
     if(getnum($sql)==0){ echo 'user error';exit;
      }

 
  }
  else {
    echo 'pls login';exit;
  }

 
 $nodepidname = @htmlentitdm($_POST['pidpro']);
 $pronum = @htmlentitdm($_POST['pronum']);

  $sql = " SELECT *  FROM  ".TABLE_NODE."  where  pidname='$nodepidname' and lang='".LANG."'  order by id desc";
     if(getnum($sql)==0){ 
      $retvv['id'] =  'fail'; 
      //echo 'node error';exit;
      }
      else{
        $row = getrow($sql);
         //  $detprice = $row['detprice']; 
          // $sku = $row['sku']; 
      }

 
   $sql = " SELECT *  FROM  ".TABLE_CART."  where  pid='$mempidname' and pidpro='$nodepidname' and lang='".LANG."'  order by id desc";
       // echo $sql;
    $result = getnum($sql );


  if($result==0){ 
			 $ss = "insert into ".TABLE_CART." (lang,pbh,pid,pidpro,pronum,dateedit) values ('".LANG."','$user2510','$mempidname','$nodepidname',$pronum,'$dateall')";
		 	 // echo $ss;exit;
		    iquery($ss); 			
		}
        else { 
             $row = getrow($sql);
             $num = $row['pronum']+(int)$pronum;
            
             $ss = "update ".TABLE_CART."  set pronum = $num  where  pid='$mempidname' and pidpro='$nodepidname' and pidpro='$nodepidname' and lang='".LANG."'  order by id desc";
           // echo $ss;exit;
            iquery($ss);        
            } 


  $retvv['id'] =  'yes';   
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