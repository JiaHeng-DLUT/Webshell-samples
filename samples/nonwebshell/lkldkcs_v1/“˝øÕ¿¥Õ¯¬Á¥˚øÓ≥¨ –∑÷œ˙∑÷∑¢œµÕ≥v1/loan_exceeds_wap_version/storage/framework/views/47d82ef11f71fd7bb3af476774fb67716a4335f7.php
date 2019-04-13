<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">

            <form class="layui-form-item" id="search-form">
                <div class="layui-inline">
                    <label class="layui-form-label">产品名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" placeholder="请输入产品名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">所属栏目</label>
                    <div class="layui-input-block">
                        <select name="column_id" id="">
                            <option value="">不限</option>
                            <?php if($columns->count()): ?>
                                <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($column->id); ?>"><?php echo e($column->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">合作模式</label>
                    <div class="layui-input-block">
                        <select name="deal_type" id="">
                            <option value="">不限</option>
                            <option value="cpa">cpa</option>
                            <option value="cps">cps</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">上线平台</label>
                    <div class="layui-input-block">
                        <select name="platform" id="">
                            <option value="">不限</option>
                            <option value="android">android</option>
                            <option value="ios">ios</option>
                            <option value="wap">wap</option>
                            <option value="pc">pc</option>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">状态</label>
                    <div class="layui-input-block">
                        <select name="status" id="">
                            <option value="">不限</option>
                            <option value="1">上架</option>
                            <option value="0">下架</option>
                        </select>
                    </div>
                </div>

                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="product-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </form>

        </div>
        <div class="layui-card-body">

            <div class="layui-btn-group layui-inline" style="padding-bottom: 10px">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.create')): ?>
                    <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.product.create')); ?>">添 加</a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.destroy')): ?>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" id="listDelete">删 除</a>
                <?php endif; ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.excel')): ?>
                    <a class="layui-btn layui-btn-normal layui-btn-sm" id="excel">导 出</a>
                <?php endif; ?>
                  
            </div>

            <table id="dataTable" lay-filter="dataTable"></table>

            <script id="platformTpl" type="text/html">
                {{#  layui.each(d.platform, function(index, item){ }}
                 <span>{{ item.platform }}</span>&nbsp;&nbsp;&nbsp;
                {{#  }); }}
            </script>

            <script id="columnTpl" type="text/html">
                {{#  layui.each(d.column, function(index, item){ }}
                 <span>{{ item.name }}</span>&nbsp;&nbsp;&nbsp;
                {{#  }); }}
            </script>

            <script id="labelTpl" type="text/html">
                {{#  layui.each(d.new_label, function(index, item){ }}
                 <span>{{ item.name }}</span>&nbsp;&nbsp;&nbsp;
                {{#  }); }}
            </script>




            <script id="statusTpl" type="text/html">
                <input type="checkbox" name="status" lay-filter="status"  lay-skin="switch" lay-text="上架|下架"  value="{{ d.id }}" {{#  if(d.status === 1){ }} checked {{#  } }}  >
            </script>

            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.edit')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('product.destroy')): ?>
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
                ,url: "<?php echo e(route('admin.product.data')); ?>" //数据接口
                ,page: true //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    // ,{field: 'id', title: 'ID'}
                    ,{field: 'name', title: '产品名称'}
                    ,{title: '所属栏目',templet:'#columnTpl'}
                    ,{field: 'deal_type', title: '合作模式'}
                    ,{title: '上线平台',templet:'#platformTpl'}
                    ,{field: 'first_onsale_at', title: '初次上架时间',sort:true}
                    ,{field: 'updated_at', title: '最后更新时间',sort:true}
                    ,{field: 'status', title: '状态',templet:'#statusTpl',sort:true}
                    ,{field: 'sort', title: '排序',sort:true}
                    ,{title: '标签',templet:'#labelTpl'}
                    ,{title:'操作',width: 150, toolbar: '#options'}
                ]]
            });


            //监听搜索
            form.on('submit(product-search)', function(data){
                var field = data.field;

                //执行重载
                table.reload('dataTable', {
                    where: field
                    ,page:{
                        curr:1
                    }
                });
                return false;
            });

            localStorage.setItem('field','sort');
            localStorage.setItem('order','desc');

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


            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("<?php echo e(route('admin.product.destroy')); ?>",{_method:'delete',ids:[data.id]},function (result) {
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
                    location.href = '/admin/product/'+data.id+'/edit';
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
                        $.post("<?php echo e(route('admin.product.destroy')); ?>",{_method:'delete',ids:ids},function (result) {
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

            //上下架
            form.on('switch(status)', function(data){
                var id=data.value;
                var status=data.elem.checked;
                $.post("<?php echo e(route('admin.product.status')); ?>",{id:id,status:status},function (res) {
                    console.log(res);
                    if(res.code===0){
                        layer.msg(res.msg,{icon:1});
                    }else {
                        layer.msg(res.msg,{icon:2});
                        dataTable.reload();
                    }
                })
            });

            //excel
            $("#excel").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length>0){
                    $.each(hasCheckData,function (index,element) {
                        ids.push(element.id)
                    })
                }
                var params=$('#search-form').serialize();
                var field=localStorage.getItem('field');
                var order=localStorage.getItem('order');
                window.location.href="<?php echo e(route('admin.product.excel')); ?>"+"?ids="+ids+"&"+params+"&field="+field+"&order="+order;
            })

            //上下架测试
            
               
                
            
            
            
               
                
            

        })
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>