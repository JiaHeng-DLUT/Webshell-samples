//检测是否微信端打开
function wx_check() { 
    var ua = window.navigator.userAgent.toLowerCase(); 
    if (ua.match(/MicroMessenger/i) == 'micromessenger') { 
        return true;
    }
    else { 
        return false;
    } 
}

//微信支付函数
function wx_pay(order_id) {
	if (wx_check()) {
		wx_jspay(order_id);
	}
	else {
		wx_h5pay(order_id);
	}
}

//调用微信JS api 支付
function wx_jspay(order_id) {
	if (typeof WeixinJSBridge == "undefined"){
		if (document.addEventListener){
			document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
		}
		else if (document.attachEvent){
			document.attachEvent('WeixinJSBridgeReady', onBridgeReady); 
			document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
		}
	}
	else {
		//$.ajaxSettings.async = false;
		$.getJSON("include/plugin/payment/wechat/pay_m.php?type=js", {"id":order_id}, function(json){
			//alert(JSON.stringify(json))
			if (!json.result) {
				app_tip(json.show);
				return false;
			}
			WeixinJSBridge.invoke(
				'getBrandWCPayRequest', json.info,
				function(res){
					//WeixinJSBridge.log(res.err_msg);
					//alert(res.err_code+res.err_desc+res.err_msg);
					if (res.err_msg == "get_brand_wcpay_request:ok") {
						//window.location.href = json.url;
						app_open(json.url);
					}
					else {
						//alert(res.err_code+res.err_desc+res.err_msg);
					}
				}
			);
		})
	}
}
//调用微信H5 支付
function wx_h5pay(order_id) {
	$.getJSON("include/plugin/payment/wechat/pay_m.php?type=h5", {"id":order_id}, function(json){
		//alert(JSON.stringify(json))
		if (!json.result) {
			app_tip(json.show);
			return false;
		}
		app_open(json.url);
	});
}