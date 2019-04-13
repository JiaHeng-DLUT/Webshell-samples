
<script>
    layui.use(['upload','form'],function () {
        var form = layui.form

        var upload = layui.upload;

        //执行实例
        var uploadInst = upload.render({
            elem: '#importPhone' //绑定元素
            ,url: '/uploadFile?type=excel' //上传接口
            ,data:{"_token":"{{ csrf_token() }}"}
            ,accept:'file'
            ,acceptMime:'.csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel'
            // ,auto: false
            ,done: function(res,index,upload){
                //上传完毕回调
                if(res.code!==0){
                    layer.msg(res.msg,{icon:2});
                    return false;
                }else {
                    $('input[name="path"]').val(res.data.path);
                    var fileName='<span class="layui-inline layui-upload-choose">'+res.data.originName+'</span>';
                    $('input[name="path"]').closest('.layui-input-inline').append(fileName);
                }
            }
            ,error: function(){
                //请求异常回调
            }
        });



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
            if(!$('input[name="path"]').val()){
                layer.msg('请上传Excel文件',{icon:2});
                return false;
            }
            $.post($('#form-virtualPhone').attr('action'),data.field,function (res) {
                if(res.code===0){
                    layer.msg(res.msg,{icon:1});
                    setTimeout(function () {
                        window.location.href="{{route('admin.virtualPhone')}}";
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

