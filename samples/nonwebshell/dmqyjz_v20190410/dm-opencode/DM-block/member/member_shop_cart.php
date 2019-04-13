<?php
/*
	欢迎使用DM企业建站系统，本系统由www.demososo.com开发。
*/
if(!defined('IN_DEMOSOSO')) {
	exit('this is wrong page,please back to homepage');
} 
?>


<?php 
 $sql = " SELECT *  FROM  ".TABLE_CART."  where  pid='$mempidname' and  lang='".LANG."'  order by id desc";
       // echo $sql;
  if(getnum($sql)>0){
  		$res = getall($sql);
  		echo '<ul class="cartlist">';
  		echo '<li><div class="w w1"><input p-type="1833249_13" manfanzeng="0" type="checkbox" name="checkItem" value="1833249_13_50000067507" checked="checked" class="jdcheckbox" data-bind="cbid" clstag="clickcart|keycount|xincart|cart_checkOn_sku">全选</div><div class="w w2">图片</div><div class="w w3">标题</div><div class="w w4">单价</div><div class="w w5">数量</div><div class="w w6">小计</div><div class="w w7">操作</div></li>';
  		 //pre($res);
  		 
  		foreach ($res as $key => $v) {
  		   
           $pronum = $v['pronum']; 
           $nodepidname = $v['pidpro'];
          // echo $nodepidname;
          
           $nodearr = get_fieldarr(TABLE_NODE,$nodepidname,'pidname');
           if($nodearr=='no') continue;
           $kvsm = get_img($nodearr['kvsm']);
           $title = $nodearr['title'];$detprice = $nodearr['detprice'];
           $url = get_url($nodearr);
            $totalprice = number_format($detprice*$pronum,2);
           ?>
           
           <li>
              <div class="w w1"> <input p-type="1833249_13" manfanzeng="0" type="checkbox" name="checkItem" value="1833249_13_50000067507" checked="checked" class="jdcheckbox" data-bind="cbid" clstag="clickcart|keycount|xincart|cart_checkOn_sku"> </div>
              <div class="w w2">
              <a href="<?php echo $url;?>" target="_blank"><img alt="ddd" src="<?php echo $kvsm;?>"></a>
               </div>
              <div class="w w3"><a  href="<?php echo $url;?>" target="_blank"><?php echo $title;?></a> </div>
              <div class="w w4">¥<?php echo $detprice;?> </div>
              <div class="w w5"> <div class="quantity-form" promoid="50000067507">
						<a href="javascript:void(0);" clstag="clickcart|keycount|xincart|cart_num_down" class="decrement disabled" id="decrement_8888_1833249_1_13_50000067507">-</a>
						<input autocomplete="off" type="text" class="itxt" value="<?php echo $pronum;?>" id="changeQuantity_8888_1833249_1_13_0_50000067507" minnum="1">
						<a href="javascript:void(0);" clstag="clickcart|keycount|xincart|cart_num_up" class="increment" id="increment_8888_1833249_1_13_0_50000067507">+</a>
					</div></div>
              <div class="w w6">¥<?php echo $totalprice;?> </div>
              <div class="w w7">删除 </div>


           
           </li>
           <?php 
  		}
  		echo '</ul><div class="c"></div>';
  		echo '<div class="gocheckcart"><a href="checkout.html">结算</a></div>';

  }else{

  		echo '购买物车为空';
  }


?>




 