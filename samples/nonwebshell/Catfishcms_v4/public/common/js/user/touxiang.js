/**
 * Created by A.J on 2016/10/16.
 */
$(document).ready(function(){
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
        uploader:'uploadhead',
        onUploadComplete:function(file,data){
            pic = $("#webroot").text()+'data/uploads/'+data.replace('\\','/');
            $('#avatar').val(pic);
            $('#avatarImg').attr("src", pic);
        }
    });
    if($('#avatar').val() != ''){
        $('#avatarImg').attr("src", $('#avatar').val());
    }
});