layui.use(['form', 'upload'], function(){  //如果只加载一个模块，可以不填数组。如：layui.use('form')
  var form = layui.form //获取form模块
  ,upload = layui.upload; //获取upload模块
  
});

//全选
function CheckAll(form){
	for (var i = 0; i < form.elements.length; i++) {
    	var e = form.elements[i];
        if (e.Name != "ChkAll" && e.disabled == false)
			e.checked = form.ChkAll.checked;
	}
}

//判断是否选择
function IsCheck(ObjName){
	var Obj = document.getElementsByName(ObjName); //获取复选框数组
    var ObjLen = Obj.length; //获取数组长度
    var Flag = false; //是否有选择
    for (var i = 0; i < ObjLen; i++) {
		if (Obj[i].checked == true) {
			Flag = true;
			break;
		}
	}
	return Flag;
}

//栏目合并判断
function ConfirmUnite() {
	if ($("#CurrentClassID").attr("value") == $("#TargetClassID").attr("value")) {
		alert("请不要在相同栏目内进行操作！");
		$("#TargetClassID").focus();
		return false;
	}
return true;
}



//自动去除http
function strip_http() {
	var url = $("#web_url").val();

    if (url.indexOf("http://") >= 0) {
		url = url.replace("http://", "");
	}
    if (url.indexOf("/") >= 0) {
		var domainArr = url.split("/");
        $("#web_url").val(domainArr[0]);
	} else {
		$("#web_url").val(url);
	}
    return url.replace(" ", "");
}

//验证url
function checkurl(url){
	if (url == '') {
		$("#msg").html('请输入网站域名！');
		return false;
	}
	
	$(document).ready(function(){$("#msg").html('<img src="' + sitepath + 'public/images/loading.gif" align="absmiddle"> 正在验证，请稍候...'); $.ajax({type: "GET", url: sitepath + '?mod=collect&type=check', data: 'url=' + url, cache: false, success: function(data){$("#msg").html(data)}});});
return true;
};


//升级
$(function(){
	$(".update_check").on("click",function(){
	var v = $(this).attr('data-v');
	var url = $(this).attr('data-url');

	layer.msg('升级包检测中！', {
		time: 0,
	  icon: 16
	});
	ajax('check');
			function ajax(type){
					  $.ajax({
				  	type:"post",
				  	url:"/admin/update.php",
				  	data:{v:v,"type":type,},
				  	success:function(json){
			         if(json.status == 1){
			         	// 升级前,请确认已经做好数据库和程序备份!
					layer.confirm(json.msg, {
					  btn: ['确定升级','取消'] //按钮
					}, function(){
						ajax('start');
						layer.msg('升级中，请勿关闭！', {
							time: 0,
						  icon: 16
						});
					}, function(){
					});   
			               
			         }else if(json.status == 2){              
			         	layer.alert(json.msg, {
						  icon: 1,
						  skin: 'layer-ext-moon' 
						})
						location.reload();
			         }else if(json.status == -1){
			         	//更新失败
			         	  layer.alert(json.msg, {
						  icon: 2,
						  skin: 'layer-ext-moon'
						  })
			            }else{
			         	//已经是最新版
			         	  layer.alert(json.msg, {
						  icon: 4,
						  skin: 'layer-ext-moon'
						  })
			            }
				  	},
				  	dataType:"json"
				  });
			}

	});
});