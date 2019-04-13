/**
 * Created by A.J on 2016/10/12.
 */
$(document).ready(function(){
    if($("#tubiao").val() != ''){
        $('#linkImg').attr("src", $("#tubiao").val());
    }
    var pic='';
    $('#upload').uploadify({
        auto:true,
        fileTypeExts:'*.jpg;*.png;*.gif;*.jpeg',
        multi:false,
        formData:{},
        fileSizeLimit:9999,
        buttonText:$('#buttonText').text(),
        showUploadedPercent:true,//是否实时显示上传的百分比，如20%
        showUploadedSize:false,
        removeTimeout:3,
        uploader:'uploadLinks',
        onUploadComplete:function(file,data){
            pic = $("#webroot").text()+'data/uploads/'+data.replace('\\','/');
            $('#tubiao').val(pic);
            $('#linkImg').attr("src", pic);
        }
    });
});