<style>
    .time{
        line-height: 38px;
        margin: auto;
        text-align: center;
    }
    .my_status{
        display: none;
    }
</style>
<script type="text/javascript">
    formSelects.render('selectId');
</script>


<script>





    layui.use(['upload','form','laydate'],function () {
        var upload = layui.upload
        var form = layui.form
        var laydate = layui.laydate


        form.on('radio(register_at_type)',function () {
            var index=$(this).val();

            if(index==='0'){
                $('#register_abstract,#register_relative').hide();
            }
            if(index==='1'){
                $('#register_abstract').show();
                $('#register_relative').hide();
            }
            if(index==='2'){
                $('#register_abstract').hide();
                $('#register_relative').show();
            }
        })

        form.on('radio(last_active_at_type)',function () {
            var index=$(this).val();

            if(index==='0'){
                $('#last_active_at_abstract,#last_active_at_relative').hide();
            }
            if(index==='1'){
                $('#last_active_at_abstract').show();
                $('#last_active_at_relative').hide();
            }
            if(index==='2'){
                $('#last_active_at_abstract').hide();
                $('#last_active_at_relative').show();
            }
        })

        form.on('radio(last_apply_loan_at_type)',function () {
            var index=$(this).val();

            if(index==='0'){
                $('#last_apply_loan_at_abstract,#last_apply_loan_at_relative').hide();
            }
            if(index==='1'){
                $('#last_apply_loan_at_abstract').show();
                $('#last_apply_loan_at_relative').hide();
            }
            if(index==='2'){
                $('#last_apply_loan_at_abstract').hide();
                $('#last_apply_loan_at_relative').show();
            }
        })



        form.verify({
            my_name: function(value, item){ //value：表单的值、item：表单的DOM对象
                if($('#my_name').val() == ''){
                    return '模型名称不能为空！';
                }
                if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\\\s·]+$").test(value)){
                    return '不能有特殊字符';
                }

                if($('#my_name').val().length >11){
                    return '模型名称控制10个字以内';
                }

            },
            register_at_abstract_start: function (value) {
                var register_at_type = $('input[name="register_at_type"]:checked').val();
                if(register_at_type == '1'){
                    if($('#register_at_abstract_start').val() == ''){
                        return '开始时间不能为空！';
                    }

                }
            },
            register_at_abstract_end: function (value) {
                var register_at_type = $('input[name="register_at_type"]:checked').val();
                if(register_at_type == '1'){
                    if($('#register_at_abstract_end').val() == ''){
                        return '结束时间不能为空！';
                    }
                }
            },
            register_at_relative_num:function(){
                var register_at_type = $('input[name="register_at_type"]:checked').val();
                if(register_at_type == '2'){
                    if($('#register_at_relative_num').val() == ''){
                        return '基数不能为空！';
                    }
                }
            },
            last_active_at_abstract_start: function (value) {
                var last_active_at_type = $('input[name="last_active_at_type"]:checked').val();
                if(last_active_at_type == '1'){
                    if($('#last_active_at_abstract_start').val() == ''){
                        return '开始时间不能为空！';
                    }

                }
            },
            last_active_at_abstract_end: function (value) {
                var last_active_at_type = $('input[name="last_active_at_type"]:checked').val();
                if(last_active_at_type == '1'){
                    if($('#last_active_at_abstract_end').val() == ''){
                        return '结束时间不能为空！';
                    }
                }
            },
            last_active_at_relative_num:function(){
                var last_active_at_type = $('input[name="last_active_at_type"]:checked').val();
                if(last_active_at_type == '2'){
                    if($('#last_active_at_relative_num').val() == ''){
                        return '基数不能为空！';
                    }
                }
            },
            last_apply_loan_at_abstract_start: function (value) {
                var last_apply_loan_at_type = $('input[name="last_apply_loan_at_type"]:checked').val();
                if(last_apply_loan_at_type == '1'){
                    if($('#last_apply_loan_at_abstract_start').val() == ''){
                        return '开始时间不能为空！';
                    }

                }
            },
            last_apply_loan_at_abstract_end: function (value) {
                var last_apply_loan_at_type = $('input[name="last_apply_loan_at_type"]:checked').val();
                if(last_apply_loan_at_type == '1'){
                    if($('#last_apply_loan_at_abstract_end').val() == ''){
                        return '结束时间不能为空！';
                    }
                }
            },
            last_apply_loan_at_relative_num:function(){
                var last_apply_loan_at_type = $('input[name="last_apply_loan_at_type"]:checked').val();
                if(last_apply_loan_at_type == '2'){
                    if($('#last_apply_loan_at_relative_num').val() == ''){
                        return '基数不能为空！';
                    }
                }
            }



        });


        // form.on('submit(formDemo)', function(data){
            /*if(!ue.hasContents()){
                layer.msg('内容不能为空',{icon:5});
                return false;
            }
            if(ue.getContent().length >1000){
                layer.msg('内容最多输入1000个字符',{icon:5});
                return false;
            }
            if(!$('#cover').val()){
                layer.msg('封面图不能为空',{icon:5});
                return false;
            }*/
            // return true;
        // });


        laydate.render({
            elem: '#register_at_abstract_start' //指定元素
            ,type: 'date'
            ,value: ''
            ,trigger: 'click'
            ,isInitValue: false
        });
        laydate.render({
            elem: '#register_at_abstract_end' //指定元素
            ,type: 'date'
            ,value: ''
            ,trigger: 'click'
            ,isInitValue: false
        });

        laydate.render({
            elem: '#last_active_at_abstract_start' //指定元素
            ,type: 'date'
            ,value: ''
            ,trigger: 'click'
            ,isInitValue: false
        });
        laydate.render({
            elem: '#last_active_at_abstract_end' //指定元素
            ,type: 'date'
            ,value: ''
            ,trigger: 'click'
            ,isInitValue: false
        });

        laydate.render({
            elem: '#last_apply_loan_at_abstract_start' //指定元素
            ,type: 'date'
            ,value: ''
            ,trigger: 'click'
            ,isInitValue: false
        });
        laydate.render({
            elem: '#last_apply_loan_at_abstract_end' //指定元素
            ,type: 'date'
            ,value: ''
            ,trigger: 'click'
            ,isInitValue: false
        });



        form.render();
    });





</script>

