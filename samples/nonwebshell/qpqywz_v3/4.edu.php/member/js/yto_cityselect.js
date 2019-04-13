/*
settings 参数说明
-----
url:省市数据josn文件路径
ifhotcity:是否开启热门城市
hotcity:热门城市
ifdist:是否开启县级
InputDefaultText:文本框默认文字
Readonly:文本输入框是否只读
winheight:界面高度不够是否开启滚动
------------------------------ */
(function($){
	'use strict';
	$.fn.citySelect=function(settings){
		if(this.length<1){return;};
		// 默认值
		settings=$.extend({
			url:_ctxPath + "/region.htm",
			ifhotcity:false,
			hotcity: ["北京", "上海", "浙江", "江苏", "天津","广东"],
			ifdist:true,
            Readonly: true,
            winheight: false,
    //        InputDefaultText: "请选择省市区",
            tpl: {
                    wrap:        '<div class="dropdown yto-city"></div>',
                    ytolist: ' <div class="yto-city-box dropdown-menu"><ul><li class="hover">省份</li><li>市区</li><li>县区</li></ul><div class="yto-city-cont"></div></div>',
                    ytohotprov:     '<dl class="ytohotprov"></dl> ',
                    ytoprov:     '<dl class="ytoprov"></dl>',
                    ytocity:    ' <dl class="ytocity"></dl>',
                    ytodist: ' <dl class="ytodist"></dl>'
                }
        }, settings);
		
        var input_obj = this;
        var data_regionId = $("input[name =" + input_obj.attr("data-regionId") +"]")
        input_obj.wrap($(settings.tpl.wrap));
        var yto_obj = input_obj.parent();
        var list_obj = $(settings.tpl.ytolist).insertAfter(input_obj);
   //     input_obj.val(settings.InputDefaultText);
        (settings.Readonly) ? input_obj.attr("readonly", "") : "";
   //     var input_icon = input_obj.children(".icon");
        var win_height = settings.winheight;
        if (list_obj.length < 1 || input_obj.length < 1) { return; };
        
 //       var hotprov_obj = $(settings.tpl.ytohotprov).appendTo(list_obj.children(".yto-city-cont"));
        var prov_obj = $(settings.tpl.ytoprov).appendTo(list_obj.children(".yto-city-cont"));
        var city_obj = $(settings.tpl.ytocity).appendTo(list_obj.children(".yto-city-cont"));
        var dist_obj = $(settings.tpl.ytodist).appendTo(list_obj.children(".yto-city-cont"));
        var prov_val = "";
        var prov_name = "";
        var city_val = "";
        var city_name = "";
        var $ytoul = list_obj.find("li");
        var isHover = true;
        var ifajax = true;
        yto_obj.on({
            mouseenter: function () { isHover = false; },
            mouseleave: function () { isHover = true; }
        });
        $(document).on("click", function (event) {
            event.stopPropagation();
            if (isHover) { yto_obj.removeClass("open"); }
        });
      
        $ytoul.each(function (i) {
            $(this).bind("click", function () {
                $ytoul.removeClass("hover");
                $(this).addClass("hover");
                list_obj.find("dl").hide().eq(i).show();
            })
        });
        
        input_obj.on("click", function () {
            isblock();
        });
        
        function isblock() {
            if (yto_obj.hasClass("open")) {
            	yto_obj.removeClass("open");
            } else {
                $(".yto-city").removeClass("open");
                yto_obj.addClass("open");
                if(ifajax){
                       ytoajax("",prov_obj);
                }
            }
        }

        prov_obj.on("click", "dd",function () {
            prov_val = $(this).attr("value");
            prov_name = $(this).text();
            ytoajax(prov_val, city_obj);
        });
        
        city_obj.on("click", "dd",function () {
        	city_val = $(this).attr("value");
        	city_name = $(this).text();
            ytoajax(city_val, dist_obj);
        });
        
        dist_obj.on("click", "dd",function () {
        	var $ytoval = $(this).attr("value");
            var $ytoname = $(this).text();
            data_regionId.attr("value",$ytoval);
            input_obj.attr({"regionId":$ytoval, "value": prov_name + " "+ city_name + " "+ $ytoname}).val(prov_name+" "+city_name+ " "+ $ytoname);
            isblock();
        });

        function ytoajax(num,num_obj) {
            var city_page = ""
            var requestUrl = settings.url;
            $.ajax({
                url: requestUrl,
                dataType: 'json',
                data: {"regionId":num},
                jsonp: 'callback',
                beforeSend: function () {
                    num_obj.html("<dd class='loading'>加载中...</dd>");
                },
                success: function (result) {
                	if(result.success){ 
                      if (typeof(result.data) =="undefined") {
                    	    data_regionId.attr("value",num);
                    	    yto_obj.removeClass("open"); 
                    	   if(num_obj.hasClass("ytodist")){
                    		 input_obj.attr({"regionId":num, "value":prov_name+" "+city_name}).val(prov_name+" "+city_name);
                    	      }else{
                    	     input_obj.attr({"regionId":num,"value": prov_name}).val(prov_name);
                    	   }
                      	 
                       }else{ 
                    	   $ytoul.removeClass("hover").eq(num_obj.index()).addClass("hover");   
                           list_obj.find("dl").hide();
                           num_obj.show();
                    	   var data = result.data;
                           var leng = data.length;
                           if (leng > 0) {
                               for (var i = 0; i < leng; i++) {
                                   city_page += "<dd title='" + data[i].name + "' value='" + data[i].regionId + "'>" + data[i].name + "</dd>";
                               }
                               num_obj.empty().append(city_page);
                               ifajax = false;
                           } else {
                           	num_obj.html("<dd>对不起！该城市无数据。</dd>");
                           }
                       }
                	}else{
                		num_obj.html("<dd>加载数据出错...</dd>");
                	}
                }
            });
        }
    };
})(jQuery);