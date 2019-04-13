<?php 
require '../conn/conn2.php';
require '../conn/function.php';
require 'auto.php';
require 'member_check.php';
require 'left.php';

$show=$_REQUEST["show"];
if(wapstr()){
$port_info="?port_type=wap";
}else{
$port_info="";
}

if ($show=="t"){
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-cn" />
<title>微信充值跳转</title>
<script src="js/jquery.min.js"></script>
<script src="../js/qrcode.min.js"></script>
<link href="http://qzonestyle.gtimg.cn/open_proj/proj_qcloud_v2/css/shop_cart/wechat_pay.css?v=201605201" rel="stylesheet" media="screen"/>
</head>
<body>
<div class="body">
    <h1 class="mod-title">
        <span class="ico-wechat"></span><span class="text">微信支付</span>
    </h1>
    <div class="mod-ct">
        <div class="order">
        </div>
        <div class="amount">
            ￥<?php echo round($_REQUEST["wx_fee"],2)?>
        </div>
        <div class="qr-image" >
        	<div id="billImage" style="display: inline-block;width: 200px;height: 200px;"></div>

        	<script>
        	var qrcode = new QRCode('billImage', {width: 200,height: 200,colorDark: '#000000',colorLight: '#ffffff',correctLevel: QRCode.CorrectLevel.H});
        qrcode.makeCode('<?php echo splitx(GetBody("http://".$_SERVER["HTTP_HOST"].$C_dir."wxpay/native.php","body=用户充值".$_REQUEST["wx_fee"]."元&attach=".$_REQUEST["M_id"]."|"."&total_fee=".$_REQUEST["wx_fee"]),"|",0)?>');
        
    </script>
           
        </div>
        <!--detail-open 加上这个类是展示订单信息，不加不展示-->
        <div class="detail detail-open" id="orderDetail" >
            <dl class="detail-ct">
                <dt>商家</dt>
                <dd id="storeName"><?php echo $C_wtitle?></dd>
                <dt>商品名称</dt>
                <dd id="productName">用户充值<?php echo $_REQUEST["wx_fee"]?>元</dd>
                <dt>交易单号</dt>
                <dd id="billId"><?php echo gen_key(20)?></dd>
                <dt>创建时间</dt>
                <dd id="createTime"><?php echo date('Y-m-d H:i:s')?></dd>
            </dl>

        </div>
        <div class="tip">
            <span class="dec dec-left"></span>
            <span class="dec dec-right"></span>
            <div class="ico-scan"></div>
            <div class="tip-text">
                <p>请使用微信扫一扫</p>
                <p>扫描二维码完成支付</p>
            </div>
        </div>
     </div>

</div>

</body>

</html>
<?php }else{?>
<?php 
if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false){
if ($_REQUEST["jsApiParameters"]="" && $_REQUEST["type"]="jsapi"){


Header("Location: https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$C_wx_appid."&redirect_uri="&urlencode("http://".$_SERVER["HTTP_HOST"]."/wxpay/jsapi.php?O_id=".$_SESSION["M_id"]."|".$_REQUEST["fee"]."&fee=".$_REQUEST["fee"]."&page=member_pay2.php")."&response_type=code&scope=snsapi_base&state=123&connect_redirect=1#wechat_redirect"); 

}
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
</style>
<?php if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false && $_REQUEST["jsApiParameters"]<>""){?>
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
	callpay();
	</script>
<?php }?>
<script type="text/javascript">
function test(){
$.post("post.php",
    {
      O_id:"<?php echo $O_id?>",
    },
    function(data){
	if(data==1){
	document.getElementById("pay_ok").innerHTML="<a href='member_order.php'><img src='img/pay_ok.png'></a>"
	}
    });
}
setInterval("test()",3000); //每3秒钟执行一次test()
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
</head>

<body class="body-index">
		<?php require 'top.php';?>
		<div class="container m_top_30">
					<div class="yto-box">
						<h5>账户充值</h5>
						<ul class="tabs" id="tabs">
		<?php if ($C_alipayon=="true" ){?>
       <li><a href="javascript:;"><img src="img/alipay<?php 
       if (wapstr()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>

       	<?php if ($C_wxpayon=="true" ){?>
       <li><a href="javascript:;"><img src="img/weixin<?php 
       if (wapstr()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>

       	<?php if ($C_bankon=="true" ){?>
       <li><a href="javascript:;"><img src="img/7pay<?php 
       if (wapstr()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>


       <?php if ($C_paypalon=="true" ){?>
       <li><a href="javascript:;"><img src="img/paypal<?php 
       if (wapstr()){
       echo "_m";
       }
       	?>.png" height="25"></a></li>
       	<?php }?>


    </ul>
	<ul class="tab_conbox" id="tab_conbox">
	<?php if ($C_alipayon=="true" ){?>
<li class="tab_con">
<div id="v">
<form action="../alipay/alipayapi.php<?php echo $port_info?>" method="post"  class="form-horizontal" id="form">

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("充值金额/l/Address")?></label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="fee"  value="<?php echo str_replace(",","",$_REQUEST["money"])?>" title="nickname" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" value="<?php echo $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>" name="M_url">
	<input type="hidden" name="M_id" value="<?php echo $M_id?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("付款方式/l/Address")?></label>
	<div class="col-sm-4">
	<div style=" padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;"><input type="radio" value="alipay" name="pay_type" checked="checked" > <img src="img/alipay.png"></div>
	</div>
</div>
<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
	<input type="submit" class="btn btn-primary btn-block m_top_20"  value="付款"  />
	</div>
</div>
</form>
</div>
</li>

<?php }?>
<?php if ($C_wxpayon=="true" ){?>
<li class="tab_con">
<div id="t">
<form action="?show=t" method="post" class="form-horizontal" id="form">
<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("充值金额/l/Address")?></label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="wx_fee" value="<?php echo $_REQUEST["money"]?>" id="wx_fee" title="nickname" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" value="<?php echo $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>" name="M_url">
	<input type="hidden" name="M_id" value="<?php echo $M_id?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("付款方式/l/Address")?></label>
	<div class="col-sm-4">
	<div style="padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;"><input type="radio" value="alipay" name="pay_type" checked="checked" > <img src="img/weixin.png"></div>
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
<?php if (strpos(strtolower($_SERVER["HTTP_USER_AGENT"]),"micromessenger")!==false){?>
<input type="button" class="btn btn-primary btn-block m_top_20" value="微信付款" onClick="location.href='?type=jsapi&fee='+$('#wx_fee').val()">
<?php }else{?>
	<input type="submit" class="btn btn-primary btn-block m_top_20" value="付款"  />
	<?php }?>
	</div>
</div>
</form>

</div>
</li>
<?php }?>


<?php if ($C_bankon=="true" ){?>
<li class="tab_con">
<div id="v">
<form action="../bank/api.php" method="post"  class="form-horizontal" id="form">

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("充值金额/l/Address")?></label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">￥</span>
	<input name="fee"  value="<?php echo str_replace(",","",$_REQUEST["money"])?>" title="nickname" class="form-control"  placeholder="元" >
</div>
	<input type="hidden" value="http://<?php echo $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"]?>" name="M_url">
	<input type="hidden" name="M_id" value="<?php echo $M_id?>">
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("付款方式/l/Address")?></label>
	<div class="col-sm-4">
	<div style=" padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;"><input type="radio" value="bank" name="pay_type" checked="checked" > <img src="img/7pay.png"></div>
	</div>
</div>
<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
	<input type="submit" class="btn btn-primary btn-block m_top_20"  value="付款"  />
	</div>
</div>
</form>
</div>
</li>

<?php }?>


<?php if ($C_paypalon=="true" ){?>
<li class="tab_con">
<div id="v">

<form name="paypal" target="_blank" action="https://www.paypal.com/cgi-bin/webscr" method="post" class="form-horizontal">    
<input type="hidden" name="cmd" value="_xclick"/>
 <input type="hidden" name="notify_url" value="http://<?php echo $C_domain.$C_dir?>paypal/notify_url.php"/>
 <input type="hidden" name="business" value="<?php echo $C_paypal?>"/>
 <input type="hidden" name="item_name" value="账户充值"/>
 <input type="hidden" name="currency_code" value="USD"/>
 <input type="hidden" name="on0" value="customerId"/>
 <input type="hidden" name="os0" value="<?php echo $_SESSION["M_id"]?>"/>
 <input type="hidden" name="return" value="http://<?php echo $C_domain.$C_dir?>member/member_moneylist.php"/>
 <input type="hidden" name="cancel_return" value="http://<?php echo $C_domain.$C_dir?>member/member_pay2.php"/> 

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("充值金额/l/Address")?></label>
	<div class="col-sm-4">
<div class="input-group">
	<span class="input-group-addon">$</span>
	<input name="amount" maxlength="15" value="<?php echo round(str_replace(",","",$_REQUEST["money"]/$C_rate),2)?>" title="nickname" class="form-control"  placeholder="USD" >
</div>
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"><?php echo lang("付款方式/l/Address")?></label>
	<div class="col-sm-4">
	<div style="padding:5px; margin:5px; border:#CCCCCC solid 1px; width:180px; height:35px; float:left;"><input type="radio" value="alipay" name="pay_type" checked="checked" > <img src="img/paypal.png"></div>
	</div>
</div>

<div class="form-group">
	<label for="oldpass" class="col-sm-2 control-label"></label>
	<div class="col-sm-4">
	<input type="submit" class="btn btn-primary btn-block m_top_20"  value="付款"  />
	</div>
</div>
</form>
</div>
</li>

<?php }?>


</ul>
	
			</div>
		</div>

	</div>
	
		<?php require 'foot.php';?>

	<!-- js plugins  -->
	
	<script src="js/bootstrap.min.js"></script>
	<script src="js/icheck.min.js"></script>
	<script src="js/page.js"></script>
	
</body>
</html>
<?php }?>