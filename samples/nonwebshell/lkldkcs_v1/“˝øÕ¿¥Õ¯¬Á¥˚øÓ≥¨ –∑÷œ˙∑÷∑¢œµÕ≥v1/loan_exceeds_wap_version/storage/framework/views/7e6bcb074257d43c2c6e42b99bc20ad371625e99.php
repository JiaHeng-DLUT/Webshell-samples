<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <form class="layui-form-item" id="search-form">


                <div class="layui-inline">
                    <label class="layui-form-label">角色</label>
                    <div class="layui-input-inline">
                        <select name="role_id"  id="role_id" lay-search>
                            <option value="">渠道角色</option>
                            <?php if(count($roles)): ?>
                                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" ><?php echo e($item->display_name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </select>
                    </div>
                </div>
                <?php echo $__env->make('admin.component.department-channel', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="layui-inline">
                    <label class="layui-form-label">渠道码</label>
                    <div class="layui-input-inline" style="width: 150px">
                        <input type="text" name="channel_name_code" id="channel_name_code" placeholder="请输入渠道码" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">负责人</label>
                    <div class="layui-input-inline" style="width: 150px">
                        <input type="text" name="manage" id="manage" placeholder="请输入负责人" class="layui-input">
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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.channel.create')): ?>
                        <a class="layui-btn layui-btn-sm" href="<?php echo e(route('admin.channel.create')); ?>">添 加</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.channel.status')): ?>
                        <button class="layui-btn layui-btn-sm layui-btn-danger" id="disable">停 用</button>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.channel.toExcel')): ?>
                        <button class="layui-btn layui-btn-sm" id="toExcel">导 出</button>
                    <?php endif; ?>
                </div>
            </div>


        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.channel.edit')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.distribute')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="distribute">分发管理</a>
                        <?php endif; ?>
                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="{{d.thumb}}" target="_blank" title="点击查看"><img src="{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>

            <script id="labelTpl" type="text/html">
                {{#  layui.each(d.new_label, function(index, item){ }}
                <span>{{ item.name }}</span>&nbsp;&nbsp;&nbsp;
                {{#  }); }}
            </script>

            <script type="text/html" id="category">





            </script>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <?php echo $__env->make('admin.component.department-channel-js', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.channel')): ?>

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
                    ,url: "<?php echo e(route('admin.channel.data')); ?>" //数据接口
                    ,page: true //开启分页
                    ,limits: [30,50,100,200]
                    ,limit: 30 //每页默认显示的数量
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'channel_name', title: '渠道名称'}
                        ,{field: 'channel_code', title: '渠道码',sort:true}
                        ,{field: 'department_id', title: '渠道所属部门',templet:function (d) {
                                if(d.department){
                                    return d.department.name
                                }else{
                                    return '没有上级部门'
                                }
                            }}
                        ,{field: 'role_id', title: '渠道角色',templet:function (d) {
                                if(d.role){
                                    return d.role.display_name
                                }else {
                                    return '没有分配角色'
                                }
                            }}
                        ,{field: 'manager', title: '渠道负责人'}
                        ,{field: 'ceiling_num', title: '单日注册上限'}
                        ,{title: '标签',templet:'#labelTpl'}
                        ,{field: 'redirect_status', title: '跳转状态',templet: function(d){
                                if(d.redirect_status == 1){
                                    return '<input type="checkbox" name="redirect_status" lay-filter="redirect_status" data-id="'+d.id+'" data-value="'+d.redirect_status+'" lay-skin="switch" lay-text="正常|关闭" checked>'
                                }else if(d.redirect_status == 0){
                                    return '<input type="checkbox" name="redirect_status" lay-filter="redirect_status" data-id="'+d.id+'" data-value="'+d.redirect_status+'"   lay-skin="switch" lay-text="正常|关闭">'
                                }

                            }}
                        ,{field: 'status', title: '状态',templet: function(d){
                                if(d.status == 1){
                                    return '<input type="checkbox" name="status" lay-filter="status" data-id="'+d.id+'" data-value="'+d.status+'" lay-skin="switch" data-channel_name="'+d.channel_name+'" data-channel_code="'+d.channel_code+'" lay-text="正常|停用" checked>'
                                }else if(d.status == 0){
                                    return '<input type="checkbox" name="status" lay-filter="status" data-id="'+d.id+'" data-value="'+d.status+'"  lay-skin="switch" data-channel_name="'+d.channel_name+'" data-channel_code="'+d.channel_code+'" lay-text="正常|停用">'
                                }

                            }}
                        ,{field: 'deal_at', title: '结算时间',width:250,templet:function (d) {
                                if(d.deal_at != '0000-00-00 00:00:00' && d.deal_at != null){

                                    return '<button class="layui-btn layui-btn-sm" lay-event="deal_at" data-id="'+d.id+'" data-code="'+d.channel_code+'" data-last="'+d.deal_at+'">'+d.deal_at+'</button>'
                                }else{
                                    return '<button class="layui-btn layui-btn-sm" lay-event="deal_at" data-id="'+d.id+'" data-code="'+d.channel_code+'" data-last="'+d.deal_at+'">设置</button>'
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
                        location.href = '/admin/channel/'+data.id+'/edit';
                    }
                    if(layEvent == 'distribute'){
                        location.href = '/admin/distribute/'+data.id+'';
                    }
                    if(layEvent == 'deal_at'){

                        var channel_code = $(this).data('code');
                        var last_deal_at = $(this).data('last');
                        // console.log(last_deal_at)
                        if(last_deal_at == '0000-00-00 00:00:00' || last_deal_at == null){
                            last_deal_at = ''
                        }

                        // console.log(channel_code,last_deal_at)

                        layer.open({
                            type: 1,
                            title:'更新结算时间',
                            skin: 'layui-layer-rim', //加上边框
                            area: ['420px', '240px'], //宽高
                            content: '<form class="layui-form" id="addEmployeeForm" style="margin-top: 30px">' +
                            '<div class="layui-form-item">' +
                            '<label for="" class="layui-form-label my_width">结算时间</label>' +
                            '<div class="layui-input-block">' +
                            '<input type="text" class="layui-input" name="deal_at" id="test1" style="width: 200px" value="'+last_deal_at+'">' +
                            '<input type="hidden" name="channel_code" value="'+channel_code+'">' +
                            '</div>' +
                            '</div>' +
                            '</form>',
                            btn: ['提交'],

                            yes: function(index, layero){
                                var deal_at = $('#test1').val();
                                if(deal_at){
                                    $.ajax({
                                        type: 'POST',
                                        url: "<?php echo e(route('admin.channel.dealAtSet')); ?>",
                                        dataType: 'json',
                                        data:$('#addEmployeeForm').serialize(),
                                        success: function(res){
                                            if(res.code===0){
                                                $(data.elem).attr('value',res.status);
                                                layer.msg(res.msg,{icon:6});
                                                layer.close(index)
                                                dataTable.reload()
                                            }else {
                                                layer.msg(res.msg,{icon:5});
                                            }
                                        }
                                    });
                                }else{

                                    layer.msg('结算时间不能为空！', {icon: 5, time: 2000});return false;
                                }

                            },
                            success: function(layero, index){
                                var  currentTime = new Date().toLocaleString('chinese', { hour12: false }) // 获取当前时间
                                //执行一个laydate实例
                                if(last_deal_at){
                                    laydate.render({
                                        elem: '#test1', //指定元素
                                        type: 'datetime',
                                        max:currentTime,
                                        min:last_deal_at
                                    });
                                }else{
                                    laydate.render({
                                        elem: '#test1', //指定元素
                                        type: 'datetime',
                                        max:currentTime
                                    });
                                }
                            }
                        });
                    }


                    laydate.render({
                        elem: '#test1' //指定元素
                        ,type: 'datetime'
                    });
                    form.render()
                });

                //跳转状态
                form.on('switch(redirect_status)', function(data){
                    var id=$(data.elem).data('id');
                    var status=$(data.elem).data('value');

                    $.post("<?php echo e(route('admin.channel.redirect_status')); ?>",{id:id,redirect_status:status},function (res) {

                        if(res.code===0){
                            $(data.elem).attr('value',res.status);
                            layer.msg(res.msg,{icon:6});
                            dataTable.reload()
                        }else {
                            layer.msg(res.msg,{icon:5});
                        }
                    })

                })

                //停用状态
                form.on('switch(status)', function(data){
                    var id=$(data.elem).data('id');
                    var status=$(data.elem).data('value');
                    var channel_name=$(data.elem).data('channel_name');
                    var channel_code=$(data.elem).data('channel_code');

                    var html = '';
                    if(status == 1){
                        html='确认停用'+channel_name+'('+channel_code+')吗？'
                    }else if(status == 0){
                        html='确认启用'+channel_name+'('+channel_code+')吗？'
                    }


                    layer.confirm(html, {
                        btn: ['确定', '取消'], //可以无限个按钮
                        cancel:function(index, layero){
                            dataTable.reload()
                        }
                    }, function(index, layero){
                        $.post("<?php echo e(route('admin.channel.status')); ?>",{id:id,status:status},function (res) {

                            if(res.code===0){
                                $(data.elem).attr('value',res.status);
                                layer.msg(res.msg,{icon:6});
                                dataTable.reload()
                            }else {
                                layer.msg(res.msg,{icon:5});
                            }
                        })
                    }, function(index){
                        dataTable.reload()
                    });

                });








                //按钮批量停用
                $("#disable").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }


                    if (ids.length>0){
                        layer.confirm('确认是否停用'+ids.length+'个渠道？', {
                            btn: ['确定', '取消'], //可以无限个按钮
                            cancel:function(index, layero){
                                dataTable.reload()
                            }
                        }, function(index, layero){
                            $.post("<?php echo e(route('admin.channel.disable')); ?>",{_method:'post',ids:ids},function (result) {
                                if (result.code==0){
                                    dataTable.reload()
                                }
                                layer.close(index);
                                layer.msg(result.msg,{icon:6})
                            });
                        }, function(index){
                            dataTable.reload()
                        });
                    }else {
                        layer.msg('请选择停用项',{icon:5})
                    }
                });

                //导出
                $("#toExcel").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    var department_id = $("#department_id").val()
                    var role_id = $("#role_id").val()
                    var channel_name_code = $("#channel_name_code").val()
                    var channel_code = $("#channel_code").val()
                    var manage = $("#manage").val()
                    var u = '<?php echo e(route('admin.channel.toExcel')); ?>';
                    u = u+'?department_id='+department_id+'&role_id='+role_id+'&channel_name_code='+channel_name_code+'&ids='+ids+'&channel_code='+channel_code+'&manage='+manage;
                    window.location.href=u;
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

                // //搜索
                // $("#searchBtn").click(function () {
                //     var department_id = $("#department_id").val()
                //     var role_id = $("#role_id").val()
                //     var channel_name_code = $("#channel_name_code").val()
                //     var channel_code = $("#channel_code").val()
                //     var manage = $("#manage").val()
                //
                //     dataTable.reload({
                //         where:{department_id:department_id,role_id:role_id,channel_name_code:channel_name_code,channel_code:channel_code,manage:manage},
                //         page:{curr:1}
                //     })
                // });

            });

        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>