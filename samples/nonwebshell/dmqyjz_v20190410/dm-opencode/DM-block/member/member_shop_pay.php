<?php
/*
  欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
  exit('this is wrong page,please back to homepage');
} 
?>


<?php 
 $order = 'order'.$bshou;
 $sql = " SELECT *  FROM  ".TABLE_CART."  where  pid='$mempidname'  and lang='".LANG."'  order by id";//here not id desc
       // echo $sql;
  if(getnum($sql)>0){
      $res = getall($sql);
  
       
      foreach ($res as $key => $v) {
           $tid = $v['id']; 
           $pronum = $v['pronum']; 
           $nodepidname = $v['pidpro'];
          
           $nodearr = get_fieldarr(TABLE_NODE,$nodepidname,'pidname');
           if($nodearr=='no') continue;

           $kvsm = get_img($nodearr['kvsm']);
           $title = $nodearr['title'];
           $detprice = $nodearr['detprice'];
           $sku = $nodearr['sku'];
           $url = get_url($nodearr);
            $totalprice = number_format($detprice*$pronum,2);

        $ss = "insert into ".TABLE_ORDER." (lang,pbh,pid,pidname,address,dateedit) values ('".LANG."','$user2510','$mempidname','$order','address.........','$dateall')";
       // echo $ss;exit;
        iquery($ss);  

       $ss = "insert into ".TABLE_CHECKOUT." (lang,pbh,pid,pidorder,pidpro,protitle,prosku,pronum,proprice,propricetotal) values ('".LANG."','$user2510','$mempidname','$order','$nodepidname','$title','$sku',$pronum,$detprice,$totalprice)";
         //echo $ss;exit;
        iquery($ss);  

         $ss = "delete from ".TABLE_CART."  where id = '$tid'";
       // echo $ss;exit;
        iquery($ss);  

       }
        echo '跳转到支付。。。';

   
     
  }else{
     echo '结算时，发现购物车为空。';

  }


?>




 