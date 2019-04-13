
<script>


    layui.use(['form'],function () {
        var form = layui.form;

        form.verify({
            my_text: function(value, item){ //value：表单的值、item：表单的DOM对象
                if(value == ''){
                    return '问题不能为空！';
                }
                console.log(value.trim().replace(/\s/g,"").length)

                if(value.trim().replace(/\s/g,"").length>50){
                    return '问题最多50个字';
                }

            },
            my_answer: function (value, item) {

                if(value == ''){
                    return '回答不能为空';
                }

                // console.log(value.trim().replace(/\r|\r\n|\n|\\s/g,"").length)
                // console.log(value.trim().replace(/\s/g,"").length)
                if(value.trim().replace(/\s/g,"").length >500){
                    return '回答最多500个字';
                }

            },

        });
    });





</script>

