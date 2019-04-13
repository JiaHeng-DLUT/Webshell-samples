
<script>

    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.setHeight(400);
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });

    layui.use(['upload','form'],function () {
        var form = layui.form

        form.verify({
            sort: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(value<-999 || value>999){
                    return '排序取值范围是-999~999';
                }
            },

        });


        form.on('submit(save)', function(data){
            if(!ue.hasContents()){
                layer.msg('内容不能为空',{icon:2});
                return false;
            }
            $.post($('#form-page').attr('action'),data.field,function (res) {
                if(res.code===0){
                    layer.msg(res.msg,{icon:1});
                    setTimeout(function () {
                        window.location.href="{{route('admin.page')}}";
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

