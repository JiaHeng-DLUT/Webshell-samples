<style>
    #layui-upload-box li{
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border:1px solid #ddd;
    }
    #layui-upload-box li img{
        width: 100%;
    }
    #layui-upload-box li p{
        width: 100%;
        height: 22px;
        font-size: 12px;
        position: absolute;
        left: 0;
        bottom: 0;
        line-height: 22px;
        text-align: center;
        color: #fff;
        background-color: #333;
        opacity: 0.6;
    }
    #layui-upload-box li i{
        display: block;
        width: 20px;
        height:20px;
        position: absolute;
        text-align: center;
        top: 2px;
        right:2px;
        z-index:999;
        cursor: pointer;
    }
</style>


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
                    $("#url").val(res.url);
                    $('#layui-upload-box li p').text('上传成功');
                    return layer.msg(res.msg,{icon:6});
                }
                return layer.msg(res.msg,{icon:5});
            }
            ,size:1024
        });
        form.verify({
            my_slug: function (value,item) {
                if(value == ''){
                    return '圈子类型不能为空';
                }
            },
            my_url: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(value == ''){
                    return '二维码图片不能为空';
                }

            },
            my_title: function (value,item) {
                if(value == ''){
                    return '标题不能为空';
                }
                if(value.length>8){
                    return '标题控制在8个字以内';
                }
            },
            my_copy_content: function (value,item) {
                if(value == ''){
                    return '可复制内容不能为空';
                }

                if(value.length>16){
                    return '可复制内容控制在16个字以内';
                }
            },
            my_intro: function (value,item) {
                if(value == ''){
                    return '描述不能为空';
                }

                if(value.length>50){
                    return '描述内容控制在50个字以内';
                }
            },
            my_sort: function (value,item) {
                if(value == ''){
                    return '排序不能为空';
                }

                if(value>999 || value<-999){
                    return '排序值在-999~999的整数';
                }

                if(value.replace(/^-\d{1,3}$|^\d{1,3}$/g,"")){
                    return '排序值在-999~999的整数';
                }
            },



        });



        // form.on('submit(formDemo)', function(data){
        //
        //     if($('#url').val() != ''){
        //         layer.msg('二维码不能为空',{icon:5});
        //         return false;
        //     }
        //
        //     return true;
        // });
    });


</script>

