<?php
$ini['phpshe'] = array('version'=>'1.7', 'type'=>'0');
$ini['userbank_type'] = array('alipay'=>'支付宝', 'wechat'=>'微信', 'ICBCB2C'=>'工商银行', 'ABC'=>'农业银行', 'CCB'=>'建设银行', 'CMB'=>'招商银行', 'POSTGC'=>'邮政储蓄', 'GDB'=>'广发银行', 'CIB'=>'兴业银行', 'COMM'=>'交通银行', 'BOCB2C'=>'中国银行', 'SPDB'=>'浦发银行', 'CMBC'=>'民生银行', 'CEBBANK'=>'光大银行', 'CITIC'=>'中信银行', 'SPABANK'=>'平安银行');
$ini['moneylog_type'] = array('recharge'=>'账户充值', 'add'=>'系统充值', 'back'=>'系统退还', 'tg'=>'推荐收益', 'order_pay'=>'订单支付', 'cashout'=>'余额提现', 'del'=>'系统扣除');
$ini['pointlog_type'] = array('give'=>'系统赠送', 'add'=>'系统充值', 'back'=>'系统退还', 'order_pay'=>'抵现扣除', 'del'=>'系统扣除');
$ini['product_type'] = array('normal'=>'普通商品', 'virtual'=>'虚拟商品');
$ini['huodong_tag'] = array('团购', '特价', '店庆', '限时折扣', '新品上市', '品牌特卖');
$ini['quan_type'] = array('online'=>'点击领取', 'offline'=>'券码兑换');
$ini['quanlog_state'] = array(0=>'未使用', 1=>'已使用', 2=>'已过期');
$ini['notice_tpl'] = array('order_id'=>'订单号', 'order_money'=>'付款金额', 'order_wl_name'=>'快递公司', 'order_wl_id'=>'快递单号', 'order_closetext'=>'订单关闭原因', 'user_name'=>'用户名', 'user_tname'=>'收件人', 'user_phone'=>'联系电话', 'user_address'=>'收货地址');
$ini['class_type'] = array('news'=>'资讯中心', 'help'=>'帮助中心');
$ini['tg_level'] = array('1'=>'一', 2=>'二', 3=>'三');
$ini['userlevel_up'] = array('auto'=>'自动升级', 'hand'=>'手动升级');
$ini['order_state'] = array('wpay'=>'等待付款', 'wtuan'=>'待成团', 'wsend'=>'等待发货',  'wget'=>'已发货', 'success'=>'交易完成', 'close'=>'交易关闭');
$ini['refund_type'] = array(1=>'仅退款', 2=>'退货+退款');
$ini['refund_state'] = array('wcheck'=>'退款待审', 'wsend'=>'待买家寄回', 'wget'=>'待卖家收货', 'success'=>'退款成功', 'refuse'=>'退款拒绝', 'close'=>'退款关闭');
$ini['pintuan_state'] = array('wtuan'=>'拼团中', 'success'=>'拼团成功', 'close'=>'拼团失败');
$ini['express_tag'] = array('user_tname'=>'收货人', 'user_phone'=>'收货人电话', 'user_address'=>'收货地址', 'order_id'=>'订单号', 'order_text'=>'订单备注', 'duigou'=>'√');
$ini['ad_type']['pc']['name'] = '电脑PC版';
$ini['ad_type']['pc']['list']['index_jdt'] = array('name'=>'首页焦点图', 'size'=>'（725*420）');
$ini['ad_type']['pc']['list']['index_header'] = array('name'=>'首页顶部广告', 'size'=>'（1200*80）');
$ini['ad_type']['pc']['list']['index_footer'] = array('name'=>'首页底部广告', 'size'=>'（1200*80）');
$ini['ad_type']['pc']['list']['header'] = array('name'=>'整站顶部广告', 'size'=>'（1200*80）');
$ini['ad_type']['pc']['list']['footer'] = array('name'=>'整站底部广告', 'size'=>'（1200*80）');
$ini['ad_type']['h5']['name'] = '手机H5版';
$ini['ad_type']['h5']['list']['index_jdt'] = array('name'=>'首页焦点图', 'size'=>'（640*250）');
//$ini['pc']['index_category'] = array('name'=>'首页分类广告', 'size'=>'(252*502)');
?>