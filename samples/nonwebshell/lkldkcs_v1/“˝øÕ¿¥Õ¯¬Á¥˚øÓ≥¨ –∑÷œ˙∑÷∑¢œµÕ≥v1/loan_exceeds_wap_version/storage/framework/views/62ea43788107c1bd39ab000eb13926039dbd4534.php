<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <?php if(request('level')): ?>
                <div class="layui-btn-group ">
                    <a class="layui-btn layui-btn-sm" id="returnParent" href="javascript:history.back()">返回上级</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('data.district')): ?>
                        <a class="layui-btn  layui-btn-sm" lay-event="children">查看下级</a>
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
                // ,height: 500
                ,url: "<?php echo e(route('admin.district.data')); ?>"+"?parent_id=<?php echo e(request('parent_id',0)); ?>&level=<?php echo e(request('level')); ?>" //数据接口
                ,page: true //开启分页
                ,cols: [[ //表头
                    // {checkbox: true,fixed: true},
                    // {field: 'id', title: 'ID',width:100}
                    {field: 'adcode', title: '行政编码'}
                    ,{field: 'name', title: '名称'}
                    ,{field: 'created_at', title: '创建时间'}
                    ,{field: 'updated_at', title: '更新时间'}
                    <?php if(request('level')!='city'): ?>
                    ,{title:'操作',width: 100, toolbar: '#options'}
                    <?php endif; ?>
                ]]
            });


            //监听搜索
            form.on('submit(LAY-user-back-search)', function(data){
                var field = data.field;

                //执行重载
                table.reload('dataTable', {
                    where: field
                });
            });


            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'children'){
                    window.location.href='/admin/district?parent_id='+data.id+'&level='+data.level;
                }
            });
        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>