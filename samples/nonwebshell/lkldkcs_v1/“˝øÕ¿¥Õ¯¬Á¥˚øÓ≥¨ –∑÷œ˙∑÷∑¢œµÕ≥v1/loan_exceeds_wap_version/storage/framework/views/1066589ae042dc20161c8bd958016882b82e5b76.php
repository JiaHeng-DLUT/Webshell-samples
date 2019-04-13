
<script>
    var hour_mintues = $("#auto_up_date").val();
    if(!hour_mintues){
        hour_mintues = '00:00'
    }
    layui.use(['upload','form','laydate'],function () {
        var form = layui.form;
        var upload=layui.upload;
        var laydate = layui.laydate;


        //logo上传
        var uploadInst = upload.render({
            elem: '#logo'
            ,url: '/uploadImage'
            ,size:1024
            ,data:{"_token":"<?php echo e(csrf_token()); ?>"}
            ,before: function(obj){
                //预读本地文件示例，不支持ie8
                obj.preview(function(index, file, result){
                    $('#logoImg').attr('src', result); //图片链接（base64）
                    $('#logoRemove').show();
                });
                $('#logoRemove').on('click',function () {
                    $('#logoImg').attr('src',null);
                    $('#logoRemove').hide();
                    $('input[name="logo"]').val('');
                });
            }
            ,done: function(res){
                if(res.code === 0){
                    $('input[name="logo"]').val(res.url);
                }else {
                    return layer.msg('上传失败');
                }
            }
            ,error: function(){
                //演示失败状态，并实现重传
                var demoText = $('#logoText');
                demoText.html('<span style="color: #FF5722;">上传失败</span> <a class="layui-btn layui-btn-xs demo-reload">重试</a>');
                demoText.find('.demo-reload').on('click', function(){
                    uploadInst.upload();
                });
            }
        });
        laydate.render({
            elem: '#auto_up_date' //指定元素
            ,type:'time'
            ,format: 'HH:mm' //可任意组合
            ,value:hour_mintues
        });
        form.on('radio(control_volume)', function(data){
            if(data.value === 'yes'){
                $('#control_volume1').show();
                $('#control_volume2').show();
            }else {
                $('#control_volume1').hide();
                $('#control_volume2').hide();

            }
        });
        form.verify({

            logo: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(!value){
                    return '请上传logo';
                }
            },
            rate_value:function (value,item) {
                if(value<0 || value>100){
                    return '利率取值范围为0~100';
                }
                if(value.indexOf(".") !== -1 ){
                    if(value.toString().split(".")[1].length>3){
                        return '利率最多小数点后3位';
                    }
                }

            },
            repay_min:function(value,item){
                if(value<1 || value>999){
                    return '还款周期取值范围为1~999';
                }
            },
            repay_max:function(value,item){
                if(value<1 || value>999){
                    return '还款周期取值范围为1~999';
                }
                if(value<parseInt($('input[name="repay_min"]').val())){
                    return '还款周期后值不能比前值小';
                }
            },
            quota_min:function(value,item){
                if(value<0 || value>999999){
                    return '贷款额度取值范围为0~999999';
                }
            },
            quota_max:function(value,item){
                if(value<1 || value>999999){
                    return '贷款额度取值范围为0~999999';
                }
                if(value<=parseInt($('input[name="quota_min"]').val())){
                    return '贷款额度后值必须必前值大';
                }
            },
            fast_lend_value:function(value,item){
                if(value<1 || value>999){
                    return '最快放款时间取值范围为1~999';
                }
            },
            success_rate:function(value,item){
                if(value<1 || value>100){
                    return '成功率取值范围为1~100';
                }
            },
            auto_down_sale_num:function(value,item) {
                var control_volume_type = $("input[name='control_volume']:checked").val();
               // return '自动下架申请数取值范围为1~99999';
                if (control_volume_type === 'yes')
                {
                    if (value < 1 || value > 99999) {
                        return '自动下架申请数取值范围为1~99999';
                    }
                }
            },
            auto_up_date:function(value,item)
            {
                var control_volume_type = $("input[name='control_volume']:checked").val();
                if (control_volume_type === 'yes')
                {
                    if (value === '') {
                        return '请选择上架时间';
                    }
                }
            },
            sort: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(value<-999 || value>999){
                    return '排序取值范围是-999~999';
                }
            },
            deal_price:function (value,item) {
                if(value<=0 || value>=1000){
                    return '结算单价取值范围是0.01~999.99';
                }
            },
            required:function (value,item) {
                if(!value){
                    var tagName=$(item)[0].tagName;
                    if(tagName==='INPUT' || tagName==='TEXTAREA'){
                        var str=$(item).closest('.layui-form-item').find('label').html();
                        var index=str.lastIndexOf("\>");
                        var label=str.substring(index+1,str.length);
                        var msg=label+'不能为空';
                    }
                    if(tagName==='SELECT'){
                        var msg=$(item).find('option:first-child').text();
                    }
                    return msg;
                }
            }
        });

        $('input[type="number"]').on('keyup',function () {

            if($(this).attr('name')!=='sort'){
                if($(this).val()<0){
                    $(this).val('');
                }
            }
        });

        function checkLabel(){
            var checked=$('.product_label:checked').length;
            if(checked>=3){
                $('.product_label').not('input:checked').each(function () {
                    $(this).attr("disabled",true);
                })
            }else {
                $('.product_label').not('input:checked').each(function () {
                    $(this).attr("disabled",false);
                })
            }
        }

        function checkCategory(){
            var checked=$('.product_category:checked').length;
            if(checked>=4){
                $('.product_category').not('input:checked').each(function () {
                    $(this).attr("disabled",true);
                })
            }else {
                $('.product_category').not('input:checked').each(function () {
                    $(this).attr("disabled",false);
                })
            }
        }

        function checkColumn(){
            var checked=$('.product_column:checked').length;
            if(checked>=4){
                $('.product_column').not('input:checked').each(function () {
                    $(this).attr("disabled",true);
                })
            }else {
                $('.product_column').not('input:checked').each(function () {
                    $(this).attr("disabled",false);
                })
            }
        }

        checkLabel();
        checkCategory();
        checkColumn();

        form.on('checkbox(label)', function(data){
            checkLabel();
        });
        
        form.on('checkbox(category)', function(data){
            checkCategory();
        });
        
        form.on('checkbox(column)', function(data){
            checkColumn();
        });


        form.on('submit(save)', function(data){

            if($('#platform').find('.layui-form-checked').length===0){
                layer.msg('请选择上线平台',{icon:2});
                return false;
            }

            $.post($('#myForm').attr('action'),data.field,function (res) {
                if(res.code===0){
                    layer.msg(res.msg,{icon:1});
                    setTimeout(function () {
                        window.location.href="<?php echo e(route('admin.product')); ?>";
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

    function words_deal()
    {
        var curLength=$('textarea[name="apply_condition"]').val().length;
        if(curLength>999)
        {
            var num=$('textarea[name="apply_condition"]').val().substr(0,999);
            $('textarea[name="apply_condition"]').val(num);
        }
        else
        {
            $("#textCount").text($('textarea[name="apply_condition"]').val().length);
        }
    }


</script>

