


<script>



    layui.use(['upload','form'],function () {
        var upload = layui.upload
        var form = layui.form

        //普通图片上传
        var uploadInst = upload.render({
            elem: '#uploadPic'
            ,url: '{{ route("uploadImage") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#cover").val(res.url);
                    $('#layui-upload-box li p').text('上传成功');
                    return layer.msg(res.msg,{icon:6});
                }
                return layer.msg(res.msg,{icon:5});
            },
            size:1024
        });



        form.verify({
            my_phone: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(value == ''){
                    return '手机号码不能为空！';
                }

                if(!new RegExp("^[1][3,4,5,7,8][0-9]{9}$").test(value)){
                    return '手机号码有误！';
                }

            },




        });



    });


</script>

