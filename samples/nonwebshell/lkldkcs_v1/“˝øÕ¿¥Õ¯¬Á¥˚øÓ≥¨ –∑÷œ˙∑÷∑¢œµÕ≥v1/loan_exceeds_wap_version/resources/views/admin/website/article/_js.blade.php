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
    function words_deal()
    {
        var curLength=$("#my_intro").val().length;
        if(curLength>50)
        {
            var num=$("#my_intro").val().substr(0,50);
            $("#my_intro").val(num);
        }
        else
        {
            $("#textCount").text($("#my_intro").val().length);
        }
    }

    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });

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
            my_title: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(value == ''){
                    return '发现标题不能为空！';
                }

                if(value.trim().replace(/\s/g,"").length >31){
                    return '输入框控制30个字以内';
                }

            },
            base_views: function (value, item) {
                if(value <0 || value >99999){
                    layer.msg('阅读数基数请输入0~99999之间的值',{icon:5});
                    return false;
                }
                if(value == ''){
                    return '阅读数基数不能为空';
                }
            },
            my_intro: function (value, item) {
                if(value == ''){
                    return '摘要不能为空';
                }
                // console.log(value.trim().replace(/\s/g,"").length)
                console.log(ue.getContentTxt())
                console.log(ue.getContentTxt().trim().replace(/\r|\n|\\s/g,"").length)
                if(value.trim().replace(/\s/g,"").length >51){
                    return '摘要控制50个字以内';
                }
            }

            //我们既支持上述函数式的方式，也支持下述数组的形式
            //数组的两个值分别代表：[正则匹配、匹配不符时的提示文字]

        });


        form.on('submit(formDemo)', function(data){
            if(!ue.hasContents()){
                layer.msg('内容不能为空',{icon:5});
                return false;
            }

            /*var content = ue.getContent(function (ue) {
                return ue.body.innerHTML;
            })*/
            console.log(ue.getContentTxt().trim().replace(/\r|\n|\\s/g,"").length)
            if(ue.getContentTxt().trim().replace(/\r|\n|\\s/g,"").length >9999){
                layer.msg('内容最多输入9999个字符',{icon:5});
                return false;
            }
            if($('#cover').val()==''){
                layer.msg('封面图不能为空',{icon:5});
                return false;
            }
            return true;
        });
    });


</script>

