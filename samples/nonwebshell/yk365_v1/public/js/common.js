
layui.use(['form', 'upload'], function(){  //如果只加载一个模块，可以不填数组。如：layui.use('form')
  var form = layui.form //获取form模块
  ,upload = layui.upload; //获取upload模块
  
});
//搜索
$(document).ready(function(){
    $("#selopt").hover(
        function(){
            $("#options").slideDown();
            $("#options li a").click(function(){
                $("#cursel").text($(this).text());
                $("#type").attr("value", $(this).attr("name"));
                $("#options").hide();
            });
        },
        
        function(){$("#options").hide();}
    )   
})


$(function(){
 $(window).scroll(function(){
 var a=	$(this).scrollTop();
 if(a > 200){
   $(".navbox").addClass("navfixed");
 }else{
 $(".navbox").removeClass("navfixed");
 }
 });

})


//搜索伪静态
function rewrite_search(){
	var $type = $("#type").val();
	var $query = $.trim($("#query").val());
	if ($type == null) {$type = "tags"}
	if ($query == "") {
		$("#query").focus();
		return false;
	} else {
		if (rewrite == "yes") {
			window.location.href = sitepath + "search/" + $type + "/" + encodeURI($query) + ".html";
		} else {
			this.form.submit();
		}
	}
	return false;
}

//搜索
$(document).ready(
	function(){
		$("#options").find("a").each(
			function(){
				$(this).click(
					function(){
						$("#cursel").text(this.innerHTML);
						$("#options").toggle();
						$("#type").attr("value", $(this).attr("name"));
						$("#query").css({"background": "#FFFFFF"});
					}
				)
				
			}
		)
		
		$("#cursel").mouseover(
			function(){
				$("#options").toggle().find("a").each(
					function(){
						$(this).parent().attr("className", $(this).text() == $("#cursel").text() ? "current" : "");
					}
				)
			}
		)
	}
)

//自动去除http
function strip_http() {
	var $url = $('#web_url').val();
    if ($url.indexOf('http://') >= 0) {
		$url = $url.replace('http://', '');
	}
    if ($url.indexOf('/') >= 0) {
		var $domain = $url.split('/');
		$url = $domain[0];
	}
	$url = $url.replace(' ', '');
	$('#web_url').val($url);
}




//添加收藏
function addfav($wid) {
	$(document).ready(function(){$.ajax({type: "GET", url: $root + "?mod=getdata&type=addfav", data: "wid=" + $wid, cache: false, success: function($data){$("body").append($data)}});});
};

//点出统计
function clickout($wid) {
	$(document).ready(function(){$.ajax({type: "GET", url: sitepath + "?mod=getdata&type=outstat", data: "wid=" + $wid, cache: false, success: function($data){}});});
};

//错误报告
function report($obj, $wid) {
	$(document).ready(function(){if (confirm("确认报告此错误吗？")){ $("#" + $obj).html("正在提交，请稍候..."); $.ajax({type: "GET", url: sitepath + "?mod=getdata&type=error", data: "wid=" + $wid, cache: false, success: function($data){$("#" + obj).html($data);}})};});
};



