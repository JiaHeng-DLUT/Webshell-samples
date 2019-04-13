
<script>

    layui.use(['upload','form'],function () {
        var form = layui.form

        form.verify({
            // my_title: function(value, item){ //value：表单的值、item：表单的DOM对象
            //     if($('#title').val() == ''){
            //         return '发现标题不能为空！';
            //     }
            //     if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\\\s·]+$").test(value)){
            //         return '不能有特殊字符';
            //     }
            //
            //     if($('#title').val().length >30){
            //         return '输入框控制30个字以内';
            //     }
            //
            // },


        });


        form.on('submit(save)', function(data){
            $.post($('#myForm').attr('action'),data.field,function (res) {
                if(res.code===0){
                    layer.msg(res.msg,{icon:1});
                    setTimeout(function () {
                        window.location.href="{{route('admin.productColumn')}}";
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

