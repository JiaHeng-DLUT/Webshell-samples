<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-form" >
                <div class="layui-btn-group">
                    
                    
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.role.create')): ?>
                        <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.role.create')); ?>">添 加</a>
                    <?php endif; ?>
                </div>
                <div class="layui-inline" style="float:right;margin-right:5%;">
                    <div class="layui-input-inline">
                        <select name="type">
                            <option value="">全部类型</option>
                            <option value="admin">后台管理员</option>
                            <option value="channel">渠道管理员</option>
                        </select>
                    </div>
                    <button class="layui-btn layui-btn-normal" lay-filter="LAY-user-back-search" lay-submit>搜索</button>
                </div>
            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.role.edit')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.role.permission')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="permission">权限</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.role.destroy')): ?>
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    <?php endif; ?>
                </div>
            </script>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('system.role')): ?>
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                // ,height: 500
                ,url: "<?php echo e(route('admin.data')); ?>" //数据接口
                ,where:{model:"role"}
                ,page: true //开启分页
                ,cols: [[ //表头
                    // {checkbox: true,fixed: true},
                    // {field: 'id', title: 'ID',width:50}
                    {field: 'name', title: '角色标识'}
                    ,{field: 'display_name', title: '显示名称'}
                    ,{field: 'type', title: '角色类型',templet:function (item) {
                            return item.type==='admin'?'后台管理员':'渠道管理员';
                    }}
                    ,{field: 'created_at', title: '创建时间'}
                    ,{field: 'updated_at', title: '更新时间'}
                    ,{title:'操作',width: 200, toolbar: '#options'}
                ]]
            });


            //监听搜索
            form.on('submit(LAY-user-back-search)', function(data){
                var field = data.field;

                //执行重载
                table.reload('dataTable', {
                    where: field
                    ,page:{
                        curr:1
                    }
                });
            });


            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("<?php echo e(route('admin.role.destroy')); ?>",{_method:'delete',ids:[data.id]},function (result) {
                            if (result.code==0){
                                delReload(dataTable)
                                layer.msg(result.msg,{icon:1})
                            }else {
                                layer.msg(result.msg,{icon:2})
                            }
                            layer.close(index);
                        });
                    });
                } else if(layEvent === 'edit'){
                    location.href = '/admin/role/'+data.id+'/edit';
                } else if (layEvent === 'permission'){
                    location.href = '/admin/role/'+data.id+'/permission';
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
                        $.post("<?php echo e(route('admin.role.destroy')); ?>",{_method:'delete',ids:ids},function (result) {
                            if (result.code==0){
                                delReload(dataTable,ids.length)
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    })
                }else {
                    layer.msg('请选择删除项',{icon:5})
                }
            })
        })
    </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>