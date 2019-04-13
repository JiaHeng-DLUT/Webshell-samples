<script>
    layui.use(['laypage', 'layer','form'], function(){
        var laypage = layui.laypage
            ,layer = layui.layer
            ,form=layui.form;
        laypage.render({
            elem: 'paginate-render'
            ,limit: parseInt("<?php echo e(request('limit',10)); ?>")
            ,layout:['prev', 'page', 'next','limit','count']
            ,curr: window.jsUrlHelper.getUrlParam(window.location.href.toString(), 'page')
            ,count: parseInt("<?php echo e($count); ?>") //数据总数
            ,jump: function(obj, first){
                if(!first){
                    var nUrl = window.jsUrlHelper.putUrlParam( window.location.href.toString(), 'page', obj.curr);
                    nUrl = window.jsUrlHelper.putUrlParam( nUrl, 'limit', obj.limit);
                    window.location.href = nUrl;
                }
            }
        });

        $(".form-delete").click(function(){

            var tUrl = $(this).attr('data-url');
            var trJq=$(this).closest('tr');
            layer.confirm('确认删除吗？', function(index){
                $.post(tUrl,{_method:'delete'},function (result) {
                    if (result.code==0){
                        trJq.remove();
                        layer.close(index);
                        layer.msg(result.msg,{icon:1});
                        setTimeout(function () {
                            window.location.reload();
                        },500)
                    }else {
                        layer.close(index);
                        layer.msg(result.msg,{icon:2});
                    }
                });
            });
            return false;
        });

        //全选
        form.on('checkbox(allChoose)', function(data){
            var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });
        form.on('checkbox(itemChoose)',function(data){
            var sib = $(data.elem).parents('table').find('tbody input[type="checkbox"]:checked').length;
            var total = $(data.elem).parents('table').find('tbody input[type="checkbox"]').length;
            if(sib == total){
                $(data.elem).parents('table').find('thead input[type="checkbox"]').prop("checked",true);
                form.render();
            }else{
                $(data.elem).parents('table').find('thead input[type="checkbox"]').prop("checked",false);
                form.render();
            }
        });
    });
</script>