<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.help.create')): ?>
                <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.website.help.create')); ?>">添 加</a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.help.destroy')): ?>
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
                <?php endif; ?>
            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.help.edit')): ?>
                    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.help.destroy')): ?>
                            <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="destroy">删除</a>
                        <?php endif; ?>

                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="{{d.thumb}}" target="_blank" title="点击查看"><img src="{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>
            <script type="text/html" id="category">
                {{ d.category.name }}
            </script>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.help')): ?>
    <script>
        layui.use(['layer','table','form','laydate'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var laydate = layui.laydate;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                // ,height: 500
                ,url: "<?php echo e(route('admin.website.help.data')); ?>" //数据接口
                ,page: true //开启分页
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    // ,{field: 'id', title: 'ID', sort: true,width:80}
                    ,{field: 'question', title: '问题标题'}
                    ,{field: 'answer', title: '问题解答'}
                    ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                ]]
            });

            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'destroy'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("<?php echo e(route('admin.website.help.destroy')); ?>",{_method:'delete',ids:[data.id]},function (res) {
                            if(res.code===0){
                                delReload(dataTable)
                                layer.msg(res.msg,{icon:6});
                            }else {
                                layer.msg(res.msg,{icon:5});
                            }
                        });
                    });
                } else if(layEvent === 'edit'){
                    location.href = '/admin/website/help/'+data.id+'/edit';
                }
            });

            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('zixun.help.edit')): ?>
            //监听是否显示
            form.on('switch(isShow)', function(obj){
                var index = layer.load();
                var url = $(obj.elem).attr('url')
                var data = {
                    "is_show" : obj.elem.checked==true?1:0,
                    "_method" : "put"
                }
                $.post(url,data,function (res) {
                    layer.close(index)
                    layer.msg(res.msg)
                },'json');
            });
            <?php endif; ?>

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
                        $.post("<?php echo e(route('admin.website.help.destroy')); ?>",{_method:'delete',ids:ids},function (res) {
                            if(res.code===0){
                                delReload(dataTable,ids.length)
                                layer.msg(res.msg,{icon:6});
                            }else {
                                layer.msg(res.msg,{icon:5});
                            }
                        });
                    })
                }else {
                    layer.msg('请选择删除项',{icon:5})
                }
            })

            //搜索
            $("#searchBtn").click(function () {
                var catId = $("#category_id").val()
                var title = $("#title").val();
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();
                dataTable.reload({
                    where:{category_id:catId,title:title,start_time:start_time,end_time:end_time},
                    page:{curr:1}
                })
            });

            laydate.render({
                elem: '#start_time' //指定元素
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#end_time' //指定元素
                ,type: 'datetime'
            });
        });

    </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>