<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">

            <form class="layui-form-item" id="search-form">

                <div class="layui-inline">
                    <label class="layui-form-label">时间区间</label>
                    <div class="layui-input-block">
                        <div class="layui-input-inline">
                            <input type="text" name="start_time" placeholder="开始时间" autocomplete="off" class="layui-input" id="start_time">
                        </div>
                        <div class="layui-form-mid">至</div>
                        <div class="layui-input-inline">
                            <input type="text" name="end_time" placeholder="结束时间" autocomplete="off" class="layui-input" id="end_time">
                        </div>
                    </div>
                </div>
                <div class="layui-inline">
                <label class="layui-form-label">发现分类</label>
                <div class="layui-input-inline">
                    <select name="category_id"  id="category_id">
                        <option value="">请选择分类</option>
                        <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item->id); ?>" ><?php echo e($item->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                </div>
                <div class="layui-inline">
                <label class="layui-form-label">文章标题</label>
                <div class="layui-input-inline">
                    <input type="text" name="title" id="title" placeholder="请输入文章标题" class="layui-input">
                </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="searchBtn">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </form>
            <div>
                <div class="layui-btn-group">

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.article.create')): ?>
                        <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.website.article.create')); ?>">添 加</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.article.destroy')): ?>
                        <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.article.edit')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.article.destroy')): ?>
                            <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="destroy">删除</a>
                        <?php endif; ?>

                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="{{d.thumb}}" target="_blank" title="点击查看"><img src="{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>

            <script type="text/html" id="category">





            </script>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.website.article')): ?>
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
                    ,url: "<?php echo e(route('admin.website.article.data')); ?>" //数据接口
                    ,page: true //开启分页
                    ,autoSort: false
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'category', title: '分类',templet: function(d){
                                if(d.category){
                                    return d.category.name
                                }else{
                                    return '暂无分类'
                                }
                            }}
                        ,{field: 'title', title: '标题'}
                        ,{field: 'created_at', title: '创建时间',sort: true}
                        ,{field: 'updated_at', title: '更新时间',sort: true}
                        ,{field: 'real_views', title: '真阅读数',sort: true}
                        ,{field: 'base_views', title: '虚拟阅读数'}
                        ,{field: 'status', title: '状态',templet: function(d){
                                if(d.status == 1){
                                    return '<input type="checkbox" name="status" lay-filter="status" data-id="'+d.id+'" data-value="'+d.status+'" lay-skin="switch" lay-text="上架|下架" checked>'
                                }else if(d.status == 0){
                                    return '<input type="checkbox" name="status" lay-filter="status" data-id="'+d.id+'" data-value="'+d.status+'"  lay-skin="switch" lay-text="上架|下架">'
                                }

                            }}
                        ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'edit'){
                        location.href = '/admin/website/article/'+data.id+'/edit';
                    }
                    if(layEvent === 'destroy'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("<?php echo e(route('admin.website.article.destroy')); ?>",{_method:'delete',ids:[data.id]},function (res) {
                                if(res.code===0){
                                    delReload(dataTable)
                                    layer.msg(res.msg,{icon:6});

                                }else {
                                    layer.msg(res.msg,{icon:5});
                                }
                            });
                        });
                    }
                });

                form.on('switch(status)', function(data){
                    var id=$(data.elem).data('id');
                    var status=$(data.elem).data('value');
                    $.post("<?php echo e(route('admin.website.article.status')); ?>",{id:id,status:status},function (res) {

                        if(res.code===0){
                            $(data.elem).attr('value',res.status);
                            layer.msg(res.msg,{icon:6});
                            dataTable.reload()
                        }else {
                            layer.msg(res.msg,{icon:5});
                            dataTable.reload()
                        }
                    })
                })



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
                            $.post("<?php echo e(route('admin.website.article.destroy')); ?>",{_method:'delete',ids:ids},function (res) {
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


                //监听搜索
                form.on('submit(searchBtn)', function(data){
                    var field = data.field;

                    //执行重载
                    table.reload('dataTable', {
                        where: field
                        ,page: {
                            curr: 1 //重新从第 1 页开始
                        }
                    });
                    return false;
                });

                localStorage.setItem('field','id');
                localStorage.setItem('order','asc');
                //监听排序事件
                table.on('sort(dataTable)', function(obj){
                    table.reload('dataTable', {
                        initSort: obj

                        ,where: {
                            field: obj.field //排序字段
                            ,order: obj.type //排序方式
                        }
                    });
                    localStorage.setItem('field',obj.field);
                    localStorage.setItem('order',obj.type);
                });

                //搜索
                // $("#searchBtn").click(function () {
                //     var catId = $("#category_id").val()
                //     var title = $("#title").val();
                //     var start_time = $("#start_time").val();
                //     var end_time = $("#end_time").val();
                //     dataTable.reload({
                //         where:{category_id:catId,title:title,start_time:start_time,end_time:end_time},
                //         page:{curr:1}
                //     })
                // });

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