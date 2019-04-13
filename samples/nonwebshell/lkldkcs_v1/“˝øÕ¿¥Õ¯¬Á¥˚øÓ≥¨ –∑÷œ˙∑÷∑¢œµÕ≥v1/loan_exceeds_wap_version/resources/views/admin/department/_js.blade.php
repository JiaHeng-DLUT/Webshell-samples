
<script>
    layui.use(['upload','form'],function () {
        var upload = layui.upload
        var form = layui.form

        form.verify({
            my_name: function(value, item){ //value：表单的值、item：表单的DOM对象
               if($("#name").val().length>10){
                   return '部门名称10个字以内';
               }

               if($("#name").val() == ''){
                   return "部门名称不能为空";
               }
            }

        });



    });


</script>

