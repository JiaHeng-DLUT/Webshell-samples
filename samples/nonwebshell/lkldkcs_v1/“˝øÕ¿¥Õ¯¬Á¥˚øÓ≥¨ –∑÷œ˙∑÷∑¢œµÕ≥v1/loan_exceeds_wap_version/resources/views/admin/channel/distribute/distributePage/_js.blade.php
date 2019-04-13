
<script>

    var string = "{{$distrs}}"
    var arry =string.replace(/&quot;/g,"");
    arry =arry.replace(']]',"");
    arry =arry.replace('[[',"");
    console.log();
    var arr = arry.split('],[');
    var arrs= []
    arr.forEach((item,index)=>{
        arrs.push({
            'id':item.split(',')[0],
            'name':item.split(',')[1]
        })
    })
    //console.log(arrs)
    layui.use(['form'],function () {
        var form = layui.form
        form.verify({
            my_name:function(value, item){ //value：表单的值、item：表单的DOM对象

                if(value == ''){
                    return '名称不能为空！';
                }

                if(value.trim().replace(/\s/g,"").length >=16){
                    return '名称控制在15个字以内';
                }
            },
        });
        //TODO
        form.on('select(redirect_type)', function(data){
          /*  console.log(arry);
            return false;*/
          //
            arrs.forEach((item,index)=>{
                if(item.name ==='伪装包下载页面' && data.value == item.id){
                    $("#redirect_type").show();
                }else{
                    $("#redirect_type").hide();
                }
            })
            // $("#redirect_type").show();
           // $("#redirect_type").hide();
           // form.render();
        });

    });


</script>

