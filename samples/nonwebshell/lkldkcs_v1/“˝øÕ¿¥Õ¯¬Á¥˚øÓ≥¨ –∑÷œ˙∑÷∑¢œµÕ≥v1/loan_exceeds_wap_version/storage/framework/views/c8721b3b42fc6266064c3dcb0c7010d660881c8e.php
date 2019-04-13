<?php $__env->startSection('content'); ?>
    <style>
        tbody .layui-table-cell{
            height: 100px;
        }
        .layui-table img{
            max-width: 200px;
        }
    </style>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">

            
                
                    
                    
                        
                    
                
                
                    
                        
                    
                
            

        </div>
        <div class="layui-card-body">

            <div class="layui-btn-group layui-inline" style="padding-bottom: 10px">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.category.create')): ?>
                    <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.productCategory.create')); ?>">添 加</a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.category.destroy')): ?>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" id="listDelete">删 除</a>
                <?php endif; ?>
            </div>

            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="iconTpl">
                <img style="display: inline-block; width: 100px; height: 100px;" src= {{ d.icon }}>
            </script>
            <script type="text/html" id="bannerTpl">
                {{#  if(d.banner_redirect){ }}
                    <a  href="{{ d.banner_redirect }}" target="_blank">
                        <img style="display: inline-block; width: 200px; height: 100px;" src= {{ d.banner }}>
                    </a>
                {{#  } else { }}
                    <img style="display: inline-block; width: 200px; height: 100px;" src= {{ d.banner }}>
                {{#  } }}
            </script>

            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.category.edit')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.category.destroy')): ?>
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    <?php endif; ?>

                </div>
            </script>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,url: "<?php echo e(route('admin.productCategory.data')); ?>" //数据接口
                ,page: true //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    ,{field: 'name', title: '类目名称'}
                    ,{field:'icon',title: '类目icon',templet:'#iconTpl'}
                    ,{field:'banner',title: '专题banner',templet:'#bannerTpl'}
                    ,{field: 'sort', title: '排序值',sort:true}
                    ,{field: 'updated_at', title: '最后修改时间',sort:true}
                    ,{title:'操作',width: 150, toolbar: '#options'}
                ]]
            });


            //监听搜索
            // form.on('submit(product-column-search)', function(data){
            //     var field = data.field;
            //
            //     //执行重载
            //     table.reload('dataTable', {
            //         where: field
            //     });
            // });

            //监听排序事件
            table.on('sort(dataTable)', function(obj){
                table.reload('dataTable', {
                    initSort: obj
                    ,where: {
                        field: obj.field //排序字段
                        ,order: obj.type //排序方式
                    }
                });
            });


            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('请确认需要删除'+data.name+'类目？', function(index){
                        $.post("<?php echo e(route('admin.productCategory.destroy')); ?>",{_method:'delete',ids:[data.id]},function (result) {
                            if (result.code===0){
                                delReload(dataTable)
                                layer.msg(result.msg,{icon:1})
                            }else {
                                layer.msg(result.msg,{icon:2})
                            }
                            layer.close(index);
                        });
                    });
                }else if(layEvent==='edit'){
                    location.href = '/admin/productCategory/'+data.id+'/edit';
                }else {

                }
            });

            //按钮批量删除
            $("#listDelete").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length>0){
                    $.each(hasCheckData,function (index,element) {
                        ids.push(element.id)
                    })
                }
                if (ids.length>0){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("<?php echo e(route('admin.productCategory.destroy')); ?>",{_method:'delete',ids:ids},function (result) {
                            if (result.code===0){
                                delReload(dataTable,ids.length);
                                layer.msg(result.msg,{icon:1});
                            }else {
                                layer.msg(result.msg,{icon:2});
                            }
                            layer.close(index);
                        });
                    })
                }else {
                    layer.msg('请选择删除项')
                }
            })

        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>