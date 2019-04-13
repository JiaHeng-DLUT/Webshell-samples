<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
$postObj = simplexml_load_string($postArr);
$appid = $postObj->appid;
$attach = $postObj->attach;
$mch_id = $postObj->mch_id;
$nonce_str = $postObj->nonce_str;
$transaction_id = $postObj->transaction_id;
$O_ids = $attach;
$KEY = $C_wx_key;
$sign = strtoupper(MD5("appid=" . $appid . "&mch_id=" . $mch_id . "&nonce_str=" . $nonce_str . "&transaction_id=" . $transaction_id . "&key=" . $KEY));
$aa = "<xml><appid>" . $appid . "</appid><mch_id>" . $mch_id . "</mch_id><nonce_str>" . $nonce_str . "</nonce_str><transaction_id>" . $transaction_id . "</transaction_id><sign>" . $sign . "</sign></xml>";
$info = GetBody("https://api.mch.weixin.qq.com/pay/orderquery", $aa);
$info = simplexml_load_string($info);
$result_code = $info->result_code;
if ($result_code == "SUCCESS") {

	$sql="Select * from SL_list where L_no='".t($transaction_id)."'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	if (mysqli_num_rows($result) > 0) {

	}else{

	    $sql = "select * from SL_orders where O_id=" . intval(splitx($O_ids, ",", 0));
	    $result = mysqli_query($conn, $sql);
	    $row = mysqli_fetch_assoc($result);
	    if (mysqli_num_rows($result) > 0) {
	        $O_state = $row["O_state"];
	        $O_price = $row["O_price"];
	        $O_member = $row["O_member"];
	    }
	    $sql = "select * from SL_config";
	    $result = mysqli_query($conn, $sql);
	    $row = mysqli_fetch_assoc($result);
	    if (mysqli_num_rows($result) > 0) {
	        $C_1yuan = $row["C_1yuan"];
	    }
	    if ($O_state == 0 && $O_price != "") {
	        $O_id = explode(",", $O_ids);
	        for ($i = 0; $i < count($O_id); $i++) {
	            mysqli_query($conn, "update SL_orders set O_state=1,O_tradeno='" . $transaction_id . "（微信付款）' where O_id=" . $O_id[$i]);
	        }
	        mysqli_query($conn, "update SL_member set M_fen=M_fen+" . $total_fee / 100 * $C_1yuan . " where M_id=" . $O_member);
	        mysqli_query($conn, "insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(" . $O_member . ",'用户充值'," . ($total_fee / 100) . ",'" . date('Y-m-d H:i:s') . "','" . $transaction_id . "',0)");
	        mysqli_query($conn, "insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(" . $O_member . ",'购买产品',-" . ($total_fee / 100) . ",'" . date('Y-m-d H:i:s') . "','" . $transaction_id . "',0)");
	        if ($C_1yuan > 0) {
	            mysqli_query($conn, "insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('购买商品'," . $O_member . "," . $total_fee / 100 * $C_1yuan . ",'" . date('Y-m-d H:i:s') . "',1,'" . $transaction_id . "')");
	        }
	        if ($C_1yuan2 > 0) {
	            mysqli_query($conn, "insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('好友购买商品'," . getrs("select * from SL_member where M_id=" . $M_id, "M_from") . "," . $total_fee / 100 * $C_1yuan2 . ",'" . date('Y-m-d H:i:s') . "',1,'" . $transaction_id . "')");
	        }
	        sendmail("有订单已付款，请尽快发货", "<h2>您的网站“" . $C_webtitle2 . "”有订单已付款，请尽快发货</h2><hr>商品编号：" . $O_ids . "<br>价格：" . round($total_fee / 100, 2) . "元<br>交易号：" . $transaction_id . "（微信付款）<br>状态：已付款（等待发货）<hr>请进入“网站后台” - “商城管理” - “订单管理”进行发货操作！", $C_email);
	    }
	}
}

?>