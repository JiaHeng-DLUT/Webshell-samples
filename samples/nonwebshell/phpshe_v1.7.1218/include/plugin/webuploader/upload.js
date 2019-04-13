(function($){
	var _this, _client, _num;
	$.fn.pe_upload = function(client, num) {
		_this = this;
		_client = (typeof(client) == 'undefined' || client == 'pc') ? 'pc' : 'app';
		_num = typeof(num) == 'undefined' ? 1 : num;
		var duo = _num == 1 ? false : true;
		// 初始化Web Uploader
		var uploader = WebUploader.create({
		    // 自动上传。
		    auto: true,
		    // swf文件路径
		    swf: "include/plugin/webuploader/Uploader.swf",
		    // 文件接收服务端。
		    server: "include/plugin/webuploader/upload.php",	
		    // 选择文件的按钮。可选。
		    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
		    pick: {id:'.upload_btn', multiple:duo},
		    fileNumLimit : _num,
		    // 只允许选择文件，可选。
		    accept: {
		        title: 'Images',
		        extensions: 'gif,jpg,jpeg,bmp,png',
		        mimeTypes: 'image/*'
		    }
		});
		// 当有文件添加进来的时候
		uploader.on('fileQueued', function( file ) {
			if (_num > 1) {
				if ($(".upload_html[lock=0]:eq(0)", _this).length == 0) {
					uploader.removeFile( file ,true);
				}
				$(".upload_html[lock=0]:eq(0)", _this).attr("id", file.id).attr("lock", 1);		
			}
			else {
				$("#rt_"+file.source.ruid).parents(".upload_html").attr("id", file.id);		
			}
		    $("#"+file.id).find(".upload_jindu").show().html("（上传中 0%）");
		});
		// 文件上传过程中创建进度条实时显示。
		uploader.on('uploadProgress', function( file, percentage ) {
		    $("#"+file.id).find(".upload_jindu").html('（上传中' + parseInt(percentage * 100) + '%）' );
		});
		// 文件上传成功，给item添加成功class, 用样式标记上传成功。
		uploader.on('uploadSuccess', function( file, response) {
		    if (response.result == true) {
		        $("#"+file.id).find(".upload_jindu").html('（上传成功）').hide();
		        $("#"+file.id).find(".upload_logo").attr("src", response.img);
		        $("#"+file.id).find(".upload_value").val(response.val);
		        $("#"+file.id).find(".upload_bg").show();
		        if (_client == 'app') $("#"+file.id).find(".upload_appdel").show();
		        //$("#"+file.id).find(".upload_do").show();
		    }
		    else {
		        $("#"+file.id).attr('lock', 0);
		        $("#"+file.id).find(".upload_jindu").html('（上传失败）');
		        $("#"+file.id).find(".upload_bg").hide();
		        if (_client == 'app') $("#"+file.id).find(".upload_appdel").hide();
		        //$("#"+file.id).find(".upload_do").hide();
		    }
		});
		//文件上传失败，现实上传出错。
		uploader.on('uploadError', function(file){
		    $("#"+file.id).attr('lock', 0);
		    $("#"+file.id).find(".upload_jindu").html('（上传失败）');
		    $("#"+file.id).find(".upload_bg").hide();
		    if (_client == 'app') $("#"+file.id).find(".upload_appdel").hide();
		    //$("#"+file.id).find(".upload_do").hide();
		});
		//所有文件上次完成
		uploader.on('uploadFinished', function(){
			uploader.reset();
		})
	}
	//初始化
	$(".upload_value").each(function(){
		var lock = $(this).val() ? 1 : 0;
		var upload_html = $(this).parents(".upload_html");
		if ($(this).val()) {
			upload_html.attr("lock", 1);
			upload_html.find(".upload_bg").show();
			if (_client == 'app') upload_html.find(".upload_appdel").show();		
			//upload_html.find(".upload_do").show();
		}
		else {
			upload_html.attr("lock", 0);
	 		upload_html.find(".upload_bg").hide();
	 		if (_client == 'app') upload_html.find(".upload_appdel").hide();
			//upload_html.find(".upload_do").hide();
		}
	})
	//显示操作
	$(".upload_html").mouseenter(function(){
		if (_client == 'app') return false;
		if ($(this).find(".upload_bg").is(":visible")) {
			$(this).find(".upload_do").show();
		}
	}).mouseleave(function(){
		if (_client == 'app') return false;
	    $(".upload_do").hide();
	});
	/*$(".upload_html").click(function(){
		if (client == 'pc') return false;
		if ($(this).find(".upload_bg").is(":visible")) {
			$(this).find(".upload_do").show();
		}
	})*/
	//左移
	$(".upload_left").live("click", function(){
		if (_num == 1) return false;
	    var current = $(this).parents(".upload_html");
	    var prev = current.prev();
	    if (current.index() > 0) {
	    	current.find(".upload_do").hide();
	    	current.insertBefore(prev);
	    }
	})
	//右移
	$(".upload_right").live("click", function(){
		if (_num == 1) return false;
	    var current = $(this).parents(".upload_html");
	    var next = $(this).parents(".upload_html").next();
	    if (current.index() < $(".upload_html", _this).length - 1) {
	    	current.find(".upload_do").hide();
	    	current.insertAfter(next);
	    }
	})
	//删除
	$(".upload_del, .upload_appdel").click(function(){
		var upload_html = $(this).parents(".upload_html");
	    upload_html.attr("lock", 0);
	    upload_html.find(".upload_logo").attr("src", "include/plugin/webuploader/images/up_bg.jpg");
	    upload_html.find(".upload_value").val('');
	    upload_html.find(".upload_bg").hide();
	    upload_html.find(".upload_do").hide();
	 	if (_client == 'app') upload_html.find(".upload_appdel").hide();
	})
})(jQuery);