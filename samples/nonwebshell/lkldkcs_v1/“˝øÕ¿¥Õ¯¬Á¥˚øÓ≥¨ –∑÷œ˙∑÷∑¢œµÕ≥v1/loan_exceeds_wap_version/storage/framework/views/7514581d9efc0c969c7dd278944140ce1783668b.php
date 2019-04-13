<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <form class="layui-form-item" id="search-form">
                <div class="layui-inline">
                    <label class="layui-form-label">信用卡名称</label>
                    <div class="layui-input-inline">
                        <input type="text" name="title" id="card_name" placeholder="信用卡名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">银行</label>
                    <div class="layui-input-inline">
                        <select name="credit_bank_id" lay-verify="" id="credit_bank_id">
                            <option value="">请选择</option>
                            <?php if($banks): ?>
                                <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" <?php if(request('bank') ==  $item->id): ?> selected <?php endif; ?>><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">上下架</label>
                    <div class="layui-input-inline">
                        <select name="status" lay-verify="" id="status">
                            <option value="">请选择</option>
                            <option value="1" <?php if(request('status') == 1): ?>  selected <?php endif; ?>>上架</option>
                            <option value="0" <?php if(request('status') === 0): ?>  selected <?php endif; ?>>下架</option>
                        </select>
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

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.credit.create')): ?>
                    <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.credit.create')); ?>">添 加</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.credit.excel')): ?>
                    <button class="layui-btn layui-btn-sm" id="excelExport">导 出</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable" ></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    
                    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    
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
    <script>
        layui.use(['layer','table','form','laydate'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var laydate = layui.laydate;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,autoSort: false //禁用前端自动排序。注意：该参数为 layui 2.4.4 新增
                ,url: "<?php echo e(route('admin.credit.data')); ?>" //数据接口
                ,page: true //开启分页
                ,limits: [50,100,200]
                ,limit: 50 //每页默认显示的数量
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
//                    ,{field: 'id', title: 'ID',width:80}
                    ,{field: 'logo', title: '信用卡图片',templet: function(d){
                       return '<img style="display: inline-block; width: 50%; height: 100%;" src="<?php echo e(env('IMG_URL')); ?>'+ d.logo+'">';
                    }}
                    ,{field: 'name', title: '信用卡名称'}
                    ,{field: 'bank', title: '所属银行'}
                    ,{field: 'corner', title: '角标'}
                    ,{field: 'base_apply_num', title: '虚拟申请数',sort: true}
                    ,{field: 'status', title: '状态',sort: true,templet: function(d){
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
                    location.href = '/admin/credit/'+data.id+'/edit';
                }
            });
            //排序监听
            table.on('sort(dataTable)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var bank = $("#credit_bank_id").val()
                var name = $("#card_name").val();
                var status = $("#status").val();
                dataTable.reload({
                    initSort: obj
                    ,where:{title:name,credit_bank_id:bank,status:status,type: obj.field //排序字段
                        ,order: obj.type //排序方式
                        },
                    page:{curr:1}
                })

            });


            //状态变更
            form.on('switch(status)', function(data){
                var id=$(data.elem).data('id');
                var status=$(data.elem).data('value');
                console.log(id+'-status-'+status)
                $.post("<?php echo e(route('admin.credit.set')); ?>",{id:id,status:status},function (res) {
                    console.log(res.data.status);
                    if(res.code===0){
                        $(data.elem).data('value',res.data.status);
                        layer.msg(res.info,{icon:6});
                    }
                    else {
                        layer.msg(res.info,{icon:2});
                        dataTable.reload();
                    }
                })
            })
            //监听搜索
            form.on('submit(searchBtn)', function(data){
                var field = data.field;
                console.log(data.field);
                //执行重载
                table.reload('dataTable', {
                     where: field
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                });
                return false;
            });
            //导出
            $("#excelExport").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length>0){
                    $.each(hasCheckData,function (index,element) {
                        ids.push(element.id)
                    })
                }
                var idStr = '';
                if (ids.length>0){
                    idStr =  a.join(",")
                }else{
                    idStr = '';
                }
                var bank = $("#credit_bank_id").val()
                var name = $("#card_name").val();
                var status = $("#status").val();
                var u = '<?php echo e(route('admin.credit.excel')); ?>'
                u = u+'?name='+name+'&bank='+bank+'&status='+status+'&ids='+idStr;
                window.location.href = u;
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>