<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';

$P_code = gen_key(20);
$O_idx = $_REQUEST["O_id"];

if(isset($_GET["O_idy"])){
  $O_idx=array($_GET["O_idy"]);
}

if(is_array($O_idx)){
	for($i=0;$i<count($O_idx);$i++){
		$O_ids=$O_ids.$O_idx[$i].",";
	}
	$O_ids=substr($O_ids,0,strlen($O_ids)-1);
}else{
	$O_ids = intval($_REQUEST["O_id"]);
}

$action = trim($_REQUEST["action"]);
$pay_type = trim($_REQUEST["pay_type"]);
if ($M_name == "未填写" || $M_code == "未填写" || $M_mobile == "未填写" || $M_add == "未填写") {
    box("请先完善您的收货信息！", "member_edit.php", "error");
}
if (wapstr()) {
    $port_info = "&port_type=wap";
} else {
    $port_info = "";
}

if($action=="submit"){
  $gkey=date("YmdHis").gen_key(5);
  $O_idsx=explode(",",$_GET["O_ids"]);
  for($i=0;$i<count($O_idsx);$i++){
    mysqli_query($conn, "update SL_orders set O_postage=".$_POST["postage"].",O_remark='".$_POST["remark"]."',O_no='".$gkey."' where O_id=".intval($O_idsx[$i]));
  }
  die();
}


$buy_list = $buy_list . "<div class='table-responsive'><div class='buy_box' style='min-width:600px;'>";
$O_id = explode(",", $O_ids);
for ($i = 0; $i < count($O_id); $i++) {
    $sql = "select * from SL_orders,SL_product where O_pid=P_id and O_id=" . intval($O_id[$i]);
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (mysqli_num_rows($result) > 0) {
        $P_title = $row["P_title"];
        $P_price = $row["P_price"];
        $P_path = $row["P_path"];
        $O_num = $row["O_num"];
        $O_price = $row["O_price"];
        $O_shuxings = $row["O_shuxing"];
        $O_remark = $row["O_remark"];
    }
    $O_shuxing = explode("|", $O_shuxings);
    for ($j = 0; $j < count($O_shuxing); $j++) {
        $shuxing = $shuxing . lang($O_shuxing[$j]) . " ";
    }
    $O_shuxing = $shuxing;
    $money = $money + $O_price * $O_num;
    if ($i > 0) {
        $buy_list = $buy_list . "<div style='border-top:solid 1px #DDDDDD; margin:10px 0 10px 0;'></div>";
    } else {
        if (count($O_id) > 1) {
            $P_title1 = lang($P_title) . "等" . count($O_id) . "件商品";
        } else {
            $P_title1 = lang($P_title);
        }
    }
    $buy_list = $buy_list . "<table style='line-height:180%;width:100%'><tr><td width='15%'><img src='../" . splitx(splitx($P_path, "|", 0) , "__", 0) . "' height='80' style='border:#FFFFFF solid 5px; margin-right:10px;'></td><td width='40%'>商品名称：" . lang($P_title) . "<br><span style='color:#999999'>属性：" . $O_shuxing . "</span></td><td width='20%'>数量：" . $O_num . "</td><td width='25%'><span style='color:#ff0000;font-weight:bold;'>总价：" . round($O_price * $O_num, 2) . "元</span></td></tr></table>";
    $shuxing = "";
}

if (round($money, 2)>=$C_baoyou){
	$postage=0;
}else{
	$postage=$C_postage;
}

$buy_list = $buy_list . "</div></div><div class='pull-right' style='margin-bottom:10px;display:block;text-align:right;'><b>邮费：".$postage."元</b> [满".$C_baoyou."元包邮]<br><span style='font-size:17px;color:#ff0000'>合计：" . round($money+$postage, 2) . "元</span></div>";

$total_money = round($money+$postage, 2);

if ($_REQUEST["type"] == "balance") {
    $x = 0;
    if ($M_money - $total_money >= 0) {
        $O_id = explode(",", $_GET["O_idy"]);
        for ($i = 0; $i < count($O_id); $i++) {
            if (getrs("select * from SL_orders where O_id=" . intval($O_id[$i]), "O_state") == 0) {
                mysqli_query($conn, "update SL_orders set O_state=1,O_tradeno='" . $P_code . "（余额支付）' where O_id=" . intval($O_id[$i]));
                $x = $x + 1;
            }
        }
        if ($x > 0) {
            mysqli_query($conn, "update SL_member set M_fen=M_fen+" . $total_money * $C_1yuan . " where M_id=" . $M_id);
            mysqli_query($conn, "update SL_member set M_money=M_money-" . $total_money . " where M_id=" . $M_id);
            mysqli_query($conn, "insert into SL_list(L_mid,L_title,L_change,L_time,L_no,L_type) values(" . $M_id . ",'购买商品',-" . $total_money . ",'" . date('Y-m-d H:i:s') . "','" . $P_code . "',0)");
            mysqli_query($conn, "insert into SL_list(L_title,L_mid,L_change,L_time,L_type,L_no) values('购买商品'," . $M_id . "," . $total_money * $C_1yuan . ",'" . date('Y-m-d H:i:s') . "',1,'" . $P_code . "')");
            sendmail("有订单已付款，请尽快发货", "<h2>您的网站“" . $C_webtitle2 . "”有订单已付款，请尽快发货</h2><hr>商品名称：" . $P_title1 . "<br>总格：" . $total_money . "元<br>付款方式：余额支付（" . $P_code . "）<br>状态：已付款（等待发货）<hr>请进入“网站后台” - “商城管理” - “订单管理”进行发货操作！", $C_email);
            box("支付成功，请等待发货", "member_order.php", "success");
        } else {
            box("订单已支付过！请勿重复操作", "member_order.php", "error");
        }
    } else {
        box("余额不足，请先充值！", "member_pay2.php?money=" . round($total_money - $M_money, 2) , "error");
    }
}

if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]) , "micromessenger") !== false && $_REQUEST["jsApiParameters"] == "") {
    Header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $C_wx_appid . "&redirect_uri=" . URLEncode("http://" . $_SERVER["HTTP_HOST"] . $C_dir . "wxpay/jsapi.php?O_id=" . $O_ids . "&fee=" . $money . "&page=member_pay.php") . "&response_type=code&scope=snsapi_base&state=123&connect_redirect=1#wechat_redirect");
}
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta name="description" content="<?php echo lang("会员中心/l/Member Center")?>">
  <title><?php echo lang("会员中心/l/Member Center")?></title>
<link href="../<?php echo $C_ico?>" rel="shortcut icon" />
<script src="js/jquery.min.js"></script>
  <!-- Stylesheets -->
    <link rel="stylesheet" href="../css/css/font-awesome.min.css">
  <link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="css/site.min.css">
  <!-- css plugins -->
  <link rel="stylesheet" href="css/icheck.min.css">
 <style>
.submit{ width:131px;height:34px; border:hidden; font-family:"微软雅黑";color:#FFFFFF;background-image:url(img/btn.png);cursor:hand;font-size:15px}
.submit2{ width:131px;height:34px; border:hidden; font-family:"微软雅黑";color:#FFFFFF;background-image:url(img/btn2.png);cursor:hand;font-size:15px}
.boxx{width:150px; height:25px; float:left; font-size:18px; padding:10px;background-color:#EEEEEE;border:#DDDDDD solid 1px; text-align:center;}
.box2x{width:150px; height:25px; float:left; font-size:18px; padding:10px;background-color:#EEEEEE;border-top:#DDDDDD solid 1px;border-right:#DDDDDD solid 1px;border-bottom:#DDDDDD solid 1px;text-align:center;}
.box3x{width:150px; height:25px; float:left; font-size:18px; padding:10px;background-color:#FFFFFF;border-left:#DDDDDD solid 1px;border-right:#DDDDDD solid 1px;border-top:#ff0000 solid 2px;text-align:center; }
.box4x{width:150px; height:25px; float:left; font-size:18px; padding:10px;background-color:#FFFFFF;border-right:#DDDDDD solid 1px;border-top:#ff0000 solid 2px; text-align:center;}
.boxy{background-color:#0066FF; padding:10px; margin:10px 3px 10px 3px; float:left; color:#FFFFFF; font-size:14px; width:60px;}
.box2y{background-color:#0099FF; padding:10px; margin:10px 3px 10px 3px; float:left; color:#FFFFFF; font-size:14px; width:60px;}
.bankbox{padding:5px; margin:5px; border:#CCCCCC solid 1px; width:195px; height:45px; float:left;}
 ul,li{list-style: none;margin:0;padding:0;}
#tabbox{ width:600px; overflow:hidden; margin:0 auto;}
.tab_conbox{}
.tab_con{ display:none;}
.tabs{height:50px; background:#f7f7f7;}
.tabs li{line-height:48px;float:left;border:1px solid #DDDDDD;border-left:none;margin-bottom: -1px;background: #f7f7f7;overflow: hidden;position: relative; font-size:15px; }
.tabs li a {display: block;padding: 0 20px;outline: none;}
.tabs li a:hover {}	
.tabs .thistab{background: #ffffff;border-bottom: 1px solid #ffffff;  border-top:2px solid #FF0000;}
.tab_con {padding:12px;font-size: 12px; line-height:175%;}
.buy_box{background:#f7f7f7; border:#DDDDDD solid 1px; margin:10px 0 10px 0; padding:10px;}
</style>
<script type="text/javascript">
function test(){
$.post("post.php",
    {
      O_id:"<?php echo splitx($O_ids,",",0)?>",
    },
    function(data){
	if(data==1){
	document.getElementById("pay_ok").innerHTML="<a href='member_order.php'><img src='img/pay_ok.png'></a>";
  var t1=window.setTimeout(payok, 1000 * 3);
    
	}
    });
}
function payok() {
  window.location="member_order.php";
}

</SCRIPT>
<script type="text/javascript">
$(document).ready(function() {
	jQuery.jqtab = function(tabtit,tab_conbox,shijian) {
		$(tab_conbox).find("li").hide();
		$(tabtit).find("li:first").addClass("thistab").show(); 
		$(tab_conbox).find("li:first").show();
	
		$(tabtit).find("li").bind(shijian,function(){
		  $(this).addClass("thistab").siblings("li").removeClass("thistab"); 
			var activeindex = $(tabtit).find("li").index(this);
			$(tab_conbox).children().eq(activeindex).show().siblings().hide();
			return false;
		});
	
	};
	/*调用方法如下：*/
	$.jqtab("#tabs","#tab_conbox","click");
	$.jqtab("#tabs2","#tab_conbox2","mouseenter");
});
</script>
  <!--[if lt IE 9]>
    <script src="/assets/js/plugins/html5shiv/html5shiv.min.js"></script>
    <![endif]-->
  <!--[if lt IE 10]>
    <link rel="stylesheet" href="/assets/css/ie8.min.css">
    <script src="/assets/js/plugins/respond/respond.min.js"></script>
    <![endif]-->
	<script>
		var _ctxPath='';
	</script>    
	<?php 
	if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false){
	?>
 <script type="text/javascript">
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $_REQUEST["jsApiParameters"]?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	</script>
<?php 
}
?>
</head>

<body class="body-index">

		<?php require 'top.php';?>
		<div class="container m_top_30">
					<div class="yto-box">
						<h5>订单支付</h5>
						<ul class="tabs" id="tabs">
       <?php if ($C_alipayon=="true" ){?>
       <li><a href="javascript:;"><img src="img/alipay<?php 
       if (wapstr()) {
       echo "_m" ;
       }
       ?>.png" height="25"></a></li>
       <?php }?>

       <?php if ($C_wxpayon=="true" ){?>
       <li><a href="javascript:;"><img src="img/weixin<?php 
       if (wapstr()) {
       echo "_m" ;
       }
       	?>.png" height="25"></a></li>
       	<?php }?>


        <?php if ($C_bankon=="true" ){?>
       <li><a href="javascript:;"><img src="img/7pay<?php 
       if (wapstr()) {
       echo "_m" ;
       }
        ?>.png" height="25"></a></li>
        <?php }?>

       	<?php if ($C_paypalon=="true" ){?>
       <li><a href="javascript:;"><img src="img/paypal<?php 
       if (wapstr()) {
       echo "_m" ;
       }
       	?>.png" height="25"></a></li>
       	<?php }?>


       	<?php if ($C_balanceon=="true" ){?>
	   <li><a href="javascript:;"><img src="img/money<?php 
	   if (wapstr()) {
       echo "_m" ;
       }
	   	?>.png"></a></li>
	   	<?php }?>
    </ul>
	<ul class="tab_conbox" id="tab_conbox">
<?php if ($C_alipayon=="true"){?>
<li class="tab_con">
<div id="v">
<?php echo $buy_list?>

<div class="input-group">
<span class="input-group-addon">备注</span><input type='text' id='O_remark1' placeholder='留言/备注' class='form-control' style='width:100%;max-width:500px;' value="<?php echo $O_remark?>">
</div>

<div class="col-sm-4">
<input name="button" type="button" class="btn btn-primary btn-block m_top_20"  value="使用支付宝付款" onclick="alipay()" />
</div>
</div>
</li>
<?php }?>
<?php if ($C_wxpayon=="true" ){?>
<li class="tab_con">
<div id="t">
<?php echo $buy_list?>
<div class="input-group">
<span class="input-group-addon">备注</span><input type='text' id='O_remark2' placeholder='留言/备注' class='form-control' style='width:100%;max-width:500px;' value="<?php echo $O_remark?>">
</div>
<div class="col-sm-4">
<input name="button" type="button" class="btn btn-primary btn-block m_top_20"  value="使用微信付款" onclick="wxpayx()" />
</div>

<?php if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false){?>
<input type="button" class="btn btn-primary btn-block m_top_20" value="微信付款" onClick="callpay()">
<?php }else{?>
<div id="pay_ok"><div id="wx" style="margin: 10px;"></div></div>
<?php }?>
</div>
</li>
<?php }?>

<?php if ($C_bankon=="true"){?>
<li class="tab_con">
<div id="v">
<?php echo $buy_list?>
<div class="input-group">
<span class="input-group-addon">备注</span><input type='text' id='O_remark5' placeholder='留言/备注' class='form-control' style='width:100%;max-width:500px;' value="<?php echo $O_remark?>">
</div>
<div class="col-sm-4">
<input name="button" type="button" class="btn btn-primary btn-block m_top_20"  value="使用7支付" onclick="spay()" />
</div>
</div>
</li>
<?php }?>

<?php if ($C_paypalon=="true"){?>
<li class="tab_con">
<div id="p">
<?php echo $buy_list?>
<div class="input-group">
<span class="input-group-addon">备注</span><input type='text' id='O_remark3' placeholder='留言/备注' class='form-control' style='width:100%;max-width:500px;' value="<?php echo $O_remark?>">
</div>
<div class="col-sm-4">
<form name="paypal" id="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post">    
<input type="hidden" name="cmd" value="_xclick"/>
 <input type="hidden" name="notify_url" value="http://<?php echo $C_domain.$C_dir?>paypal/notify_url2.php"/>
 <input type="hidden" name="business" value="<?php echo $C_paypal?>"/>
 <input type="hidden" name="item_name" value="<?php echo $P_title1?>"/>
 <input type="hidden" name="amount" value="<?php echo round($total_money/$C_rate,2)?>"/>
 <input type="hidden" name="currency_code" value="USD"/>
 <input type="hidden" name="on0" value="OID"/>
 <input type="hidden" name="os0" value="<?php echo $O_ids?>"/>
 <input type="hidden" name="return" value="http://<?php echo $C_domain.$C_dir?>member/member_moneylist.php"/>
 <input type="hidden" name="cancel_return" value="http://<?php echo $C_domain.$C_dir?>member/member_order.php"/> 
<input name="button1" type="button" class="btn btn-primary btn-block m_top_20" value="Go to Paypal" onclick="paypalx()"/>
</form>
</div>
</div>
</li>
<?php }?>


<?php if ($C_balanceon=="true"){?>
<li class="tab_con">
<?php echo $buy_list?>

<div class="input-group">
<span class="input-group-addon">备注</span><input type='text' id='O_remark4' placeholder='留言/备注' class='form-control' style='width:100%;max-width:500px;' value="<?php echo $O_remark?>">
</div>

<div class="col-sm-4">
<input name="button" type="button" class="btn btn-primary btn-block m_top_20"  value="使用余额付款" onclick="banlance()" />
</div>
</li>
<?php }?>

</ul>
			</div>
					<div class="yto-box">
						<h5>收货信息</h5>
						<p>收件人：<?php echo $M_name?></p>
						<p>收件地址：<?php echo $M_add?></p>
						<p>联系方式：<?php echo $M_mobile?></p>
						<p>邮政编码：<?php echo $M_code?></p>
						<div class="col-sm-4">
<input name="button" type="button" class="btn btn-primary btn-block m_top_20"  value="修改信息" onClick="document.location.href='member_edit.php'" />
</div>
						</div>
						</div>
	</div>
		<?php require 'foot.php';?>

	<!-- js plugins  -->
	
	<script src="js/bootstrap.min.js"></script>
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	<script src="../js/qrcode.min.js"></script>
	<script>

function showcode(){
    $.ajax({
        type: "post",
        url: "../wxpay/native.php",
        data: "<?php echo "body=".$P_title1."&attach=".$O_ids?>",
        success: function(data) {
            var qrcode = new QRCode('wx', {
                width: 110,
                height: 110,
                colorDark: '#000000',
                colorLight: '#ffffff',
                correctLevel: QRCode.CorrectLevel.H
            });
            qrcode.makeCode(data.split("|")[0]);
        }
    })
}

function alipay() {
    $.ajax({
        type: "post",
        url: "member_pay.php?action=submit&O_ids=<?php echo $O_ids?>",
        data: "remark=" + $("#O_remark1").val() + "&postage=<?php echo $postage?>",
        success: function(data) {
            document.location.href = '../alipay/alipayapi.php?O_id=<?php echo $O_ids.$port_info?>';
        }
    })
}


function spay() {
    $.ajax({
        type: "post",
        url: "member_pay.php?action=submit&O_ids=<?php echo $O_ids?>",
        data: "remark=" + $("#O_remark5").val() + "&postage=<?php echo $postage?>",
        success: function(data) {
            document.location.href = '../bank/api.php?O_id=<?php echo $O_ids.$port_info?>';
        }
    })
}

function wxpayx() {
    $.ajax({
        type: "post",
        url: "member_pay.php?action=submit&O_ids=<?php echo $O_ids?>",
        data: "remark=" + $("#O_remark2").val() + "&postage=<?php echo $postage?>",
        success: function(data) {
        	setInterval("test()",3000); 
            showcode();
        }
    })
}
function paypalx() {
    $.ajax({
        type: "post",
        url: "member_pay.php?action=submit&O_ids=<?php echo $O_ids?>",
        data: "remark=" + $("#O_remark3").val() + "&postage=<?php echo $postage?>",
        success: function(data) {
            $("#paypal").submit();
        }
    })
}
function banlance() {
    $.ajax({
        type: "post",
        url: "member_pay.php?action=submit&O_ids=<?php echo $O_ids?>",
        data: "remark=" + $("#O_remark4").val() + "&postage=<?php echo $postage?>",
        success: function(data) {
            document.location.href = '?O_idy=<?php echo $O_ids?>&type=balance';
        }
    })
}
	</script>
</body>
</html>