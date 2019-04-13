<style>
    .layui-upload-box1 li{
        width: 120px;
        height: 100px;
        float: left;
        position: relative;
        overflow: hidden;
        margin-right: 10px;
        border:1px solid #ddd;
    }
    .layui-upload-box1 li img{
        width: 100%;
    }
    .layui-upload-box1 li p{
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
    .layui-upload-box1 li i{
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
<script src="/static/admin/layuiadmin/layui/layui.all.js"></script>
<script>


    layui.use(['form','upload'],function () {

        var form = layui.form
        var upload = layui.upload


        //普通图片上传
        upload.render({
            elem: '#banner'
            ,url: '{{ route("uploadImage") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}",maxSize:1,filename:'weixin'}
            // ,method:'post'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box1').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#background").val(res.url);
                    $('#layui-upload-box1 li p').text('上传成功');
                    return layer.msg(res.msg,{icon:6});
                }
                return layer.msg(res.msg,{icon:5});
            }
            ,size:1024*2
        });
        //普通图片上传
        upload.render({
            elem: '#banner1'
            ,url: '{{ route("uploadImage") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}",maxSize:1,filename:'weixin'}
            // ,method:'post'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box1').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#background1").val(res.url);
                    $('#layui-upload-box1 li p').text('上传成功');
                    if($("#background1").val()){
                        $('#link1').attr('lay-verify','my_link');
                    }else{
                        $('#link1').attr('lay-verify','');
                    }
                    return layer.msg(res.msg,{icon:6});
                }
                return layer.msg(res.msg,{icon:5});
            }
            ,size:1024*2
        });
        //普通图片上传
        upload.render({
            elem: '#banner2'
            ,url: '{{ route("uploadImage") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}",maxSize:1,filename:'weixin'}
            // ,method:'post'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box2').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#background2").val(res.url);
                    $('#layui-upload-box2 li p').text('上传成功');
                    if($("#background2").val()){
                        $('#link2').attr('lay-verify','my_link');
                    }else{
                        $('#link2').attr('lay-verify','');
                    }
                    return layer.msg(res.msg,{icon:6});
                }
                return layer.msg(res.msg,{icon:5});
            }
            ,size:1024*2
        });
        //普通图片上传
        upload.render({
            elem: '#banner3'
            ,url: '{{ route("uploadImage") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}",maxSize:1,filename:'weixin'}
            // ,method:'post'
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                /*obj.preview(function(index, file, result){
                 $('#layui-upload-box').append('<li><img src="'+result+'" /><p>待上传</p></li>')
                 });*/
                obj.preview(function(index, file, result){
                    $('#layui-upload-box3').html('<li><img src="'+result+'" /><p>上传中</p></li>')
                });

            }
            ,done: function(res){
                //如果上传失败
                if(res.code == 0){
                    $("#background3").val(res.url);
                    $('#layui-upload-box3 li p').text('上传成功');
                    if($("#background3").val()){
                        $('#link3').attr('lay-verify','my_link');
                    }else{
                        $('#link3').attr('lay-verify','');
                    }
                    return layer.msg(res.msg,{icon:6});
                }
                return layer.msg(res.msg,{icon:5});
            }
            ,size:1024*2
        });

        form.verify({
            my_name:function(value, item){ //value：表单的值、item：表单的DOM对象

                if(value == ''){
                    return '名称不能为空！';
                }

                if(value.trim().replace(/\s/g,"").length >=16){
                    return '名称控制在15个字以内';
                }

            },
            my_link:function(value, item){ //value：表单的值、item：表单的DOM对象

                if(value == ''){
                    return '跳转链接不能为空';
                }

                if(!new RegExp("^(http|https|ftp)\\://[a-zA-Z0-9\\-\\.]+\\.[a-zA-Z]{2,3}(:[a-zA-Z0-9]*)?/?([a-zA-Z0-9\\-\\._\\?\\,\\'/\\\\\\+&%\\$#\\=~])*$").test(value)){
                    return '跳转链接不能格式不对 例子：http://www.baidu.com 或者 https://www.baidu.com';
                }

            },

        });


        console.log($('#allChoose').parents('dl').find("dd input[type='checkbox']").is(':checked'))

        //全选
        form.on('checkbox(allChoose)', function(data){
            var child = $(data.elem).parents('dl').find('dd input[type="checkbox"]');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });

        //单选
        form.on('checkbox(isAll)', function (data) {
            var item = $(".product_ids");
            for (var i = 0; i < item.length; i++) {
                if (item[i].checked == false) {
                    $("#allChoose").prop("checked", false);
                    form.render('checkbox');
                    break;
                }
            }
            //如果都勾选了  勾上全选
            var  all=item.length;
            for (var i = 0; i < item.length; i++) {
                if (item[i].checked == true) {
                    all--;
                }

            }
            if(all==0){
                $("#allChoose").prop("checked", true);
                form.render('checkbox');}
        });

        //回显判断是否全选
        var number= $('#allChoose').parents('dl').find("dd input[type='checkbox']").length
        var item= $('#allChoose').parents('dl').find("dd input[type='checkbox']")
        for (var i = 0; i < number; i++) {
            if (item[i].checked == true) {

                number--;
            }
        }
        if(number==1){
            $("#allChoose").prop("checked", true);
            form.render('checkbox');}

    });


</script>

