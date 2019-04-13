<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>贷贷狐后台管理系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="stylesheet" href="/static/admin/layuiadmin/layui/css/layui.css" media="all">
    <link rel="stylesheet" href="/static/admin/layuiadmin/style/admin.css" media="all">
    <style>
        .item-required{
            color: red;
        }
    </style>
    <script>
        function delReload(dataTable,count=1) {
            var jumpPage=parseInt($('.layui-laypage-skip').find('input').val());
            dataTable.config.page.count -=count;
            var curr=Math.ceil(dataTable.config.page.count/dataTable.config.limit);
            if(jumpPage-1===curr){
                dataTable.reload({
                    page:{curr:curr}
                });
            }else {
                dataTable.reload();
            }
        }
    </script>
</head>
<body>

<div class="layui-fluid">
    <?php echo $__env->yieldContent('content'); ?>
</div>

<script src="/js/jquery.min.js"></script>

<script src="/static/admin/layuiadmin/layui/layui.js"></script>

<script src="<?php echo e(asset('js/admin.js')); ?>"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    layui.config({
        base: '/static/admin/layuiadmin/' //静态资源所在路径
    }).extend({
        index: 'lib/index' //主入口模块
        ,echarts:'lib/extend/echarts'
        ,echartsTheme:'lib/extend/echartsTheme'
    }).use(['element','form','layer','table','upload','laydate'],function () {

        //全选反选
        var $ = layui.jquery,form = layui.form;
        form.on('checkbox(allChoose)', function(data){
            var child = $(data.elem).parents('table').find('tbody input[type="checkbox"]');
            child.each(function(index, item){
                item.checked = data.elem.checked;
            });
            form.render('checkbox');
        });

        var element = layui.element;
        var layer = layui.layer;
        var form = layui.form;
        var table = layui.table;
        var upload = layui.upload;
        var laydate = layui.laydate;

        //错误提示
        <?php if(count($errors)>0): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                layer.msg("<?php echo e($error); ?>",{icon:5});
                <?php break; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        //信息提示
        <?php if(session('status')): ?>
            layer.msg('<?php echo e(session("status")); ?>',{icon:6});
        <?php endif; ?>


        //监听消息推送
        $(document).ready(function () {
            
            
            
            
                
            
            
            
                
                
                    
                    
                    
                    
                    
                
            
        });

    });




</script>
<?php echo $__env->yieldContent('script'); ?>
</body>
</html>



