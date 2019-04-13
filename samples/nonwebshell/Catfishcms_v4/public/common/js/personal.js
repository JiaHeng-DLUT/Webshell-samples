/**
 * Created by A.J on 2016/10/6.
 */
$(document).ready(function(){
    $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true
    });
    //头像
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
    if($('#datepicker').val() == '0000-00-00'){
        $('#datepicker').val('');
    }
});