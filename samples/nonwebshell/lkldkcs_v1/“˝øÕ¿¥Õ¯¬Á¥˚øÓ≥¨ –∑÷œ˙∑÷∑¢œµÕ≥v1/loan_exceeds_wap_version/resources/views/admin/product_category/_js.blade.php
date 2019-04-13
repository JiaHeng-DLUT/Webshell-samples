
<script>

    layui.use(['upload','form'],function () {
        var form = layui.form;
        var upload=layui.upload;

        $('#iconRemove').on('click',function () {
            $('#iconImg').removeAttr('src');
            $('#iconImg').hide();
            $('input[name="icon"]').val('');
        });

        $('#bannerRemove').on('click',function () {
            $('#bannerImg').removeAttr('src');
            $('#bannerImg').hide();
            $('input[name="banner"]').val('');
        });

        //icon上传
        var uploadInst = upload.render({
            elem: '#icon'
            ,url: '/uploadImage'
            ,size:1024
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#iconImg').attr('src', result); //图片链接（base64）
                    $('#iconImg').show();
                    $('#iconRemove').show();
                });
                $('#iconRemove').on('click',function () {
                    $('#iconImg').attr('src',null);
                    $('input[name="icon"]').val('');
                    $('#iconImg').hide();
                });
            }
            ,done: function(res){
                if(res.code === 0){
                    $('input[name="icon"]').val(res.url);
                }else {
                    return layer.msg('上传失败');
                }
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#iconText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });


        //banner上传
        var uploadInst2 = upload.render({
            elem: '#banner'
            ,url: '/uploadImage'
            ,size:1024
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#bannerImg').attr('src', result); //图片链接（base64）
                    $('#bannerImg').show();
                    $('#bannerRemove').show();
                });
                $('#bannerRemove').on('click',function () {
                    $('#bannerImg').attr('src',null);
                    $('#bannerImg').hide();
                    $('input[name="banner"]').val('');
                });
            }
            ,done: function(res){
                if(res.code === 0){
                    $('input[name="banner"]').val(res.url);
                }else {
                    return layer.msg('上传失败');
                }
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#bannerText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst2.upload();
                });
            }
        });

        var uploadInst3 = upload.render({
            elem: '#pc_banner'
            ,url: '/uploadImage'
            ,size:1024
            ,data:{"_token":"{{ csrf_token() }}"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#pc_bannerImg').attr('src', result); //图片链接（base64）
                    $('#pc_bannerImg').show();
                    $('#pc_bannerRemove').show();
                });
                $('#pc_bannerRemove').on('click',function () {
                    $('#pc_bannerImg').attr('src',null);
                    $('input[name="pc_banner"]').val('');
                    $('#pc_bannerImg').hide();
                });
            }
            ,done: function(res){
                if(res.code === 0){
                    $('input[name="pc_banner"]').val(res.url);
                }else {
                    return layer.msg('上传失败');
                }
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#iconText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst3.upload();
                });
            }
        });

        form.verify({

            icon: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(!value){
                    return '请上传icon';
                }
            },
            banner: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(!value){
                    return '请上传banner';
                }
            },
            sort: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(value<-999 || value>999){
                    return '排序取值范围是-999~999';
                }
            },
        });

        // $('input[name="banner_redirect"]').on('keyup',function () {
        //     if(!$(this).val()){
        //         $(this).attr('lay-verify','')
        //     }else {
        //         $(this).attr('lay-verify','url');
        //     }
        // });

        form.on('radio(redirect_type)', function(data){
            if(data.value==='inside'){
                $('#redirect_slug').attr('lay-verify','required');
                $('input[name="banner_redirect"]').attr('lay-verify','');
                $('#redirect_to').show();
                $('#outside').hide();
                $('#inside').show();
            }else if(data.value==='outside'){
                $('input[name="banner_redirect"]').attr('lay-verify','url');
                $('#redirect_slug').attr('lay-verify','');
                $('#redirect_to').show();
                $('#inside').hide();
                $('#outside').show();
            }else {
                $('input[name="banner_redirect"]').attr('lay-verify','');
                $('#redirect_slug').attr('lay-verify','');
                $('#redirect_to').hide();
            }
        });

        form.on('select(redirect_slug)', function(data){
            $('#list').find('.layui-input-block').each(function () {
               $(this).find('select').attr('name','');
            });
            $('#list').find('.layui-input-block').hide();
            if($.inArray(data.value,['product','credit','article'],-1)){
                var id=data.value+'_list';
                $('#'+id).show();
                $('#'+id).find('select').attr('name','redirect_id');
            }
            form.render();
        });


        form.on('submit(save)', function(data){

            $.post($('#myForm').attr('action'),data.field,function (res) {
                if(res.code===0){
                    layer.msg(res.msg,{icon:1});
                    setTimeout(function () {
                        window.location.href="{{route('admin.productCategory')}}";
                    },1500);
                }else {
                    layer.msg(res.msg,{icon:2});
                }
            }).error(function (data) {
                $.each(data.responseJSON.errors,function (key,value) {
                    layer.msg(value[0],{icon:2});
                    return false;
                })
            });
            return false;
        });
    });


</script>

