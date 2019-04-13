<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。


 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知
 */
require_once("../conn/conn2.php");
require_once("../conn/function.php");
require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if($verify_result) {//验证成功
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//请在这里加上商户的业务逻辑程序代

	
	//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
	
    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
	
	//商户订单号

	$out_trade_no = $_POST['out_trade_no'];

	//支付宝交易号

	$trade_no = $_POST['trade_no'];

	//交易状态
	$trade_status = $_POST['trade_status'];


    if($_POST['trade_status'] == 'TRADE_FINISHED') {
		//判断该笔订单是否在商户网站中已经做过处理
			//如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
			//请务必判断请求时的total_fee、seller_id与通知时获取的total_fee、seller_id为一致的
			//如果有做过处理，不执行商户的业务程序
				
		//注意：
		//退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
    else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		

if (strpos($_POST["body"], "|") !== false) {
    $body = explode("|", $_POST["body"]);
} else {
    $O_ids = $_POST["body"];
    $subject = $_POST["subject"];
    $total_fee = $_POST["total_fee"];
    $M_id = getrs("select * from SL_orders where O_id=" . intval(splitx($O_ids, ",", 0)) , "O_member");
}

if ($_POST["trade_status"] = "TRADE_SUCCESS") {
    if (strpos($_POST["body"], "|") !== false) {
        $sql = "Select * from SL_list Where L_no='" . t($trade_no) . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) <= 0) {
            mysqli_query($conn, "update SL_member set M_money=M_money+" . $body[1] . " where M_id=" . intval($body[0]));
            mysqli_query($conn, "insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(" . $body[0] . ",'用户充值'," . $body[1] . ",'" . date('Y-m-d H:i:s') . "','" . $trade_no . "',0)");
            sendmail("有用户通过支付宝充值", "用户ID：" . $body[0] . "<br>充值金额：" . $body[1] . "元<br>交易单号：" . $trade_no, $C_email);
        }
    } else {
        $sql = "Select * from SL_list Where L_no='" . t($trade_no) . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) <= 0) {
            $O_id = explode(",", $O_ids);
            for ($i = 0; $i < count($O_id); $i++) {
                mysqli_query($conn, "update SL_orders set O_state=1,O_tradeno='" . $trade_no . "（支付宝付款）' where O_id=" . intval($O_id[$i]));
            }
            mysqli_query($conn, "update SL_member set M_fen=M_fen+" . $total_fee * $C_1yuan . " where M_id=" . intval($M_id));
            mysqli_query($conn, "insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(" . $M_id . ",'用户充值'," . $total_fee . ",'" . date('Y-m-d H:i:s') . "','" . $trade_no . "',0)");
            mysqli_query($conn, "insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(" . $M_id . ",'购买商品',-" . $total_fee . ",'" . date('Y-m-d H:i:s') . "','" . $trade_no . "',0)");
            if ($C_1yuan > 0) {
                mysqli_query($conn, "insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('购买商品'," . $M_id . "," . $total_fee * $C_1yuan . ",'" . date('Y-m-d H:i:s') . "',1,'" . $trade_no . "')");
            }
            if ($C_1yuan2 > 0) {
                mysqli_query($conn, "insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('好友购买商品'," . getrs("select * from SL_member where M_id=" . intval($M_id), "M_from") . "," . $total_fee * $C_1yuan2 . ",'" . date('Y-m-d H:i:s') . "',1,'" . $trade_no . "')");
            }
            sendmail("有订单已付款，请尽快发货", "<h2>您的网站“" . $C_webtitle2 . "”有订单已付款，请尽快发货</h2><hr>商品名称：" . $subject . "<br>价格：" . $total_fee . "元<br>交易号：" . $trade_no . "（支付宝付款）<br>状态：已付款（等待发货）<hr>请进入“网站后台” - “商城管理” - “订单管理”进行发货操作！", $C_email);
        }
    }
}
	//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
        
	echo "success";		//请不要修改或删除
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}
else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
}
?>