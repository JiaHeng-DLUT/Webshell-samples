<style>
    .my_width{
        width: 110px;
    }
</style>
<script>

    layui.use(['upload','form'],function () {
        var upload = layui.upload
        var form = layui.form
        var count = '{{ $count }}';

        $('#ceiling_num').keydown(function () {

            $(this).attr('lay-verify','my_ceiling_num')
        })

        form.verify({
            my_channel_name: function(value, item){ //value：表单的值、item：表单的DOM对象
                // console.log(value)
                if(value == ''){
                    return '渠道名称不能为空！';
                }
                if(!new RegExp("^[a-zA-Z0-9_\u4e00-\u9fa5\\\\s·]+$").test(value)){
                    return '不能有特殊字符';
                }

                if(value.trim().replace(/\s/g,"").length >=16){
                    return '渠道名称控制在15个字以内';
                }

            },
            my_department_id: function (value, item) {

                if(value == ''){
                    return '请选择一个渠道所属部门';
                }
            },
            my_manager: function (value, item) {
                if(value == ''){
                    return '渠道负责人不能为空';
                }

                if(value.trim().replace(/\s/g,"").length >=11){
                    return '渠道负责人控制在10个字以内';
                }
            },
            my_reduce_type: function (value, item) {
                if(value == ''){
                    return '请选择一个渠道包扣量模式 提交后改模式不能修改';
                }
            },
            my_role_id: function (value, item) {
                if(value == ''){
                    return '请选择一个渠道角色 提交后改角色不能修改';
                }
            },
            my_username: function (value, item) {
                if(value == ''){
                    return '登录用户不能为空';
                }
                if(value.trim().replace(/\s/g,"").length<6){
                    return '请设置6位以上的登录用户名'
                }

            },

            my_password: function (value, item) {
                if(value == ''){
                    return '登录密码不能为空';
                }
                // console.log(value.trim().replace(/\s/g,"").length)
                if(value.trim().replace(/\s/g,"").length<6 || value.trim().replace(/\s/g,"").length>18){
                    return '请设置6~18位的登录密码'
                }
                if(!new RegExp("^[^\\s　]+$").test(value)){
                    return '密码中不能有空格';
                }

            },
            my_ceiling_num: function (value, item) {
                if(value <0 ){
                    return '单日注册上限不能小于0';
                }
                var apply_register = $('#reduce_type').val();

                if(apply_register=='apply_register'){
                    if(value<5){
                        return '该模式下注册上限必须大于5';
                    }
                }
                console.log(value)
                if(count){
                    if(parseInt(count)>value){
                        return '该渠道现已有'+count+'个申请，单日注册上限不能<'+count;
                    }
                }


            },
        });






        /*form.on('submit(formDemo)', function(data){

            $("#channel_name").removeAttr("readonly");
            $("#department_id").removeAttr("disabled");
            $("#manager").removeAttr("readonly");
            $("#reduce_type").removeAttr("disabled");
            $("#role_id").removeAttr("disabled");
            $("#username").removeAttr("readonly");
            return true;
        });*/



    });


</script>

