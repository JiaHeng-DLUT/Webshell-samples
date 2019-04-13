<script src="/static/admin/layuiadmin/layui/layui.all.js"></script>
<script>



    layui.use(['upload','form','element'],function () {
        var upload = layui.upload
        var form = layui.form
        var element  = layui.element
        // element.init();
        //错误提示
        @if(count($errors)>0)
        @foreach($errors->all() as $error)
        layer.msg("{{$error}}",{icon:5});
        @break
        @endforeach
        @endif
        //创建监听函数
        var xhrOnProgress=function(fun) {
            xhrOnProgress.onprogress = fun; //绑定监听
            //使用闭包实现监听绑
            return function() {
                //通过$.ajaxSettings.xhr();获得XMLHttpRequest对象
                var xhr = $.ajaxSettings.xhr();
                //判断监听函数是否为函数
                if (typeof xhrOnProgress.onprogress !== 'function')
                    return xhr;
                //如果有监听函数并且xhr对象支持绑定时就把监听函数绑定上去
                if (xhrOnProgress.onprogress && xhr.upload) {
                    xhr.upload.onprogress = xhrOnProgress.onprogress;
                }
                return xhr;
            }
        };

        //上传apk
        upload.render({
            elem: '#apk', // 文件选择
            accept:'file',
            url: '{{ route('uploadApk') }}',
            auto: false, // 设置不自动提交
            exts: 'apk', //只允许上传apk
            bindAction: '#apk1', // 提交按钮
            data:{"_token":"{{ csrf_token() }}"},
            xhr:xhrOnProgress,
            progress: function(e , percent) {
                console.log( percent);
                console.log("进度：" + percent + '%');
                element.progress('progressBar',percent  + '%');
            },
            choose: function(obj) {
                obj.preview(function(index, file, result) {
                    $("#fileName").html(file.name);
                });
            },
            done: function(res) {
                if(res.code == 0){
                    $("#download_url").val(res.url);
                    return layer.msg(res.msg,{icon:6});
                }

            },
            error: function(res) {
                return layer.msg(res.msg,{icon:5});
            }
        });

        //普通图片上传
        upload.render({
            elem: '#logo'
            ,url: '{{ route("uploadImage") }}'
            ,multiple: false
            ,data:{"_token":"{{ csrf_token() }}"}
            // ,method:'post'
            ,exts: 'png|jpg'
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
                    $("#uplogo").val(res.url);
                    $('#layui-upload-box1 li p').text('上传成功');
                    return layer.msg(res.msg,{icon:6});
                }
                return layer.msg(res.msg,{icon:5});
            }
            ,size:1024*2
        });

        $('#update_log').keyup(function () {
            $('#update_log').attr('lay-verify','my_update_log')
        })


        form.verify({
            my_name:function(value, item){ //value：表单的值、item：表单的DOM对象

                if(value == ''){
                    return '名称不能为空！';
                }

                if(value.trim().replace(/\s/g,"").length >=11){
                    return '名称控制在10个字以内';
                }

            },
            my_package_name: function (value, item) {

                if(value == ''){
                    return '包名不能为空';
                }
                if(value.trim().replace(/\s/g,"").length >=31){
                    return '包名控制在30个字以内';
                }

            },
            my_logo: function (value, item) {
                if(value == ''){
                    return 'logo不能为空';
                }

            },
            my_download_url: function (value, item) {
                if(value == ''){
                    return 'apk文件必须上传';
                }
            },
            my_version: function (value, item) {
                if(value == ''){
                    return '版本不能为空';
                }
                if(value<0 || value>99){
                    return '版本请填写0~99之间的整数'
                }
            },
            my_update_log: function (value, item) {

                if( value.length>200){
                    return '更新日志最多200个字'
                }
            },


        });




    });


</script>

