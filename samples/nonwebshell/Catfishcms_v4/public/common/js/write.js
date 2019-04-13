/**
 * Created by A.J on 2016/10/2.
 */

$(document).ready(function(){
    if($("#fabushijian").length > 0){
        $("#fabushijian").datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'});
    }
    var tmp='',pic='',picw='';
    if($("#slt").val() != ''){
        tmp = $("#suolvetu").html();
        $("#suolvetu img").attr('src',$("#slt").val());
        $("#shangchuantu").addClass("hidden");
        $("#quxiaotu").removeClass("hidden");
    }
    $('#upload').uploadify({
        auto:true,
        fileTypeExts:'*.jpg;*.png;*.gif;*.jpeg',
        multi:false,
        formData:{upload:1},
        fileSizeLimit:9999,
        buttonText:$('#buttonText').text(),
        showUploadedPercent:true,//是否实时显示上传的百分比，如20%
        showUploadedSize:false,
        removeTimeout:3,
        uploader:$("#upload_url").text(),
        onUploadComplete:function(file,data){
            pic = $("#webroot").text()+'data/uploads/'+data.replace('\\','/');
            $("#bendi .panel-body").html('<img src="'+pic+'" class="img-responsive" alt="Responsive image">');
        }
    });
    $("#queding").click(function(){
        tmp = $("#suolvetu").html();
        if($("#xuanbendi").hasClass("active") && pic != ''){
            $("#suolvetu").html('<img src="'+pic+'" class="img-responsive" alt="Responsive image">');
            $("#slt").val(pic);
        }
        else if($("#xuanwangluo").hasClass("active") && picw != ''){
            $("#suolvetu").html('<img src="'+picw+'" class="img-responsive" alt="Responsive image">');
            $("#slt").val(picw);
        }
        if(pic != '' || picw != ''){
            $("#shangchuantu").addClass("hidden");
            $("#quxiaotu").removeClass("hidden");
        }
        $('#myModal').modal('hide');
    });
    $("#quxiaotu").click(function(){
        $("#suolvetu").html(tmp);
        $("#slt").val('');
        $("#quxiaotu").addClass("hidden");
        $("#shangchuantu").removeClass("hidden");
    });
    $("#wangluodizhi").change(function(){
        picw = $("#wangluodizhi").val();
        $("#wangluo .panel-body").html('<img src="'+picw+'" class="img-responsive" alt="Responsive image">');
        $("#slt").val(picw);
    });
    var upara = $.getQueryString(["editor"]);
    if(upara != ""){
        $("#switchEditor").attr("href", $("#switchEditor").attr("href")+"&"+upara);
    }
});
