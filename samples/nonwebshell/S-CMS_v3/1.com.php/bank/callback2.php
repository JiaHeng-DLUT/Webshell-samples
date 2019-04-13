<?php 
require '../conn/conn2.php';
require '../conn/function.php';

$PID = $C_7PID;
$PKEY = $C_7PKEY;

if($PID=="" || $PKEY==""){
    die();
}

$json_string=file_get_contents("php://input");
$obj=json_decode($json_string);

$title = $obj->title;
$money = $obj->money;
$no = $obj->no;
$tradeno = $obj->tradeno;
$paytype = $obj->paytype;
$remark = $obj->remark;
$time = $obj->time;
$sign = $obj->sign;

if(strtolower(md5("money=".$money."&no=".$no."&paytype=".$paytype."&remark=".$remark."&time=".$time."&title=".$title."&tradeno=".$tradeno."&key=".$PKEY))==strtolower($sign)){ 

$O_ids = $remark;
$subject = $title;
$total_fee = $money;
$M_id = getrs("select * from SL_orders where O_id=" . intval(splitx($O_ids, ",", 0)) , "O_member");

$sql = "Select * from SL_list Where L_no='" . t($tradeno) . "'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        if (mysqli_num_rows($result) <= 0) {
            $O_id = explode(",", $O_ids);
            for ($i = 0; $i < count($O_id); $i++) {
                mysqli_query($conn, "update SL_orders set O_state=1,O_tradeno='" . t($tradeno) . "（7支付）' where O_id=" . intval($O_id[$i]));
            }
            mysqli_query($conn, "update SL_member set M_fen=M_fen+" . $total_fee * $C_1yuan . " where M_id=" . intval($M_id));
            mysqli_query($conn, "insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(" . $M_id . ",'用户充值'," . $total_fee . ",'" . date('Y-m-d H:i:s') . "','" . $$tradeno . "',0)");
            mysqli_query($conn, "insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(" . $M_id . ",'购买商品',-" . $total_fee . ",'" . date('Y-m-d H:i:s') . "','" . $tradeno . "',0)");
            if ($C_1yuan > 0) {
                mysqli_query($conn, "insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('购买商品'," . $M_id . "," . $total_fee * $C_1yuan . ",'" . date('Y-m-d H:i:s') . "',1,'" . $tradeno . "')");
            }
            if ($C_1yuan2 > 0) {
                mysqli_query($conn, "insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('好友购买商品'," . getrs("select * from SL_member where M_id=" . intval($M_id), "M_from") . "," . $total_fee * $C_1yuan2 . ",'" . date('Y-m-d H:i:s') . "',1,'" . $tradeno . "')");
            }
            sendmail("有订单已付款，请尽快发货", "<h2>您的网站“" . $C_webtitle2 . "”有订单已付款，请尽快发货</h2><hr>商品名称：" . $subject . "<br>价格：" . $total_fee . "元<br>交易号：" . $tradeno . "（7支付）<br>状态：已付款（等待发货）<hr>请进入“网站后台” - “商城管理” - “订单管理”进行发货操作！", $C_email);
        }

echo "success";
}else{
echo "fail";
}

?>