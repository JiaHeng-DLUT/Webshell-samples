<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
} 
?>


<?php 
 
 $sql = " SELECT *  FROM  ".TABLE_CART."  where  pid='$mempidname'  and lang='".LANG."'  order by id desc";
       // echo $sql;
  if(getnum($sql)>0){
  		$res = getall($sql);
  		echo '<ul class="cartlist checkoutlist">';
  		echo '<li><div class="w w2">图片</div><div class="w w3">标题</div><div class="w w4">单价</div><div class="w w5">数量</div><div class="w w6">小计</div><div class="w w2"></li>';
  		//pre($res);
  		 
  		foreach ($res as $key => $v) {
  		   
           $pronum = $v['pronum']; 
           $nodepidname = $v['pidpro'];
          
           $nodearr = get_fieldarr(TABLE_NODE,$nodepidname,'pidname');
           if($nodearr=='no') continue;

           $kvsm = get_img($nodearr['kvsm']);
           $title = $nodearr['title'];$detprice = $nodearr['detprice'];
           $url = get_url($nodearr);
            $totalprice = number_format($detprice*$pronum,2);
           ?>
           
           <li>
            
              <div class="w w2">
              <a href="<?php echo $url;?>" target="_blank"><img alt="ddd" src="<?php echo $kvsm;?>"></a>
               </div>
              <div class="w w3"><a  href="<?php echo $url;?>" target="_blank"><?php echo $title;?></a> </div>
              <div class="w w4">¥<?php echo $detprice;?> </div>
              <div class="w w5"><?php echo $pronum;?>	 </div>
              <div class="w w6">¥<?php echo $totalprice;?> </div>
              


           
           </li>
           <?php 
  		}
  		echo '</ul><div class="c"></div>';
  		echo '<div class="gocheckcart"><a href="cart.html">返回购物车</a> <a href="pay.html">提交订单</a></div>';

  }else{


  }


?>




 