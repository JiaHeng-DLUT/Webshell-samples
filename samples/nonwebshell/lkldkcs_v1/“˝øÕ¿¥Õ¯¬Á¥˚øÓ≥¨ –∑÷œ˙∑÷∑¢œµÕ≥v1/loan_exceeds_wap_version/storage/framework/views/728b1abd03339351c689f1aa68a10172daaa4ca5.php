<?php $__env->startSection('content'); ?>
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">

            <form class="layui-form-item" id="search-form">


                <div class="layui-inline">
                    <label class="layui-form-label">渠道名称</label>
                    <div class="layui-input-inline">
                        <div class="layui-input-inline">
                            <select name="channel_code"  id="channel_code" lay-search>
                                <option value="">渠道名称</option>
                                <?php if(count($channels)): ?>
                                    <?php $__currentLoopData = $channels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->channel_code); ?>" ><?php echo e($item->channel_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="layui-inline" >
                    <label class="layui-form-label">分发平台</label>
                    <div class="layui-input-inline">
                        <select name="platform"  id="platform">
                            <option value="">分发平台</option>
                            <option value="android">android</option>
                            <option value="ios">ios</option>
                            <option value="pc">pc</option>
                            <option value="wap">wap</option>


                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">模板</label>
                    <div class="layui-input-inline">
                        <select name="distribute_template_id"  id="distribute_template_id" >
                            <option value="">分发页模板</option>
                            <?php if(count($distributeTemplates)): ?>
                                <?php $__currentLoopData = $distributeTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($item->id); ?>" ><?php echo e($item->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">buff</label>
                    <div class="layui-input-inline">
                        <select name="reduce_type"  id="reduce_type" >
                            <option value="">不限</option>
                            <option value="apply_register">申请注册比</option>
                            <option value="register">比例</option>


                        </select>
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">分发页</label>
                    <div class="layui-input-inline" style="width: 120px">
                        <input type="text" name="distribute_page_name" id="distribute_page_name" placeholder="请输入分发页" class="layui-input">
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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.channelReduce.toExcel')): ?>
                        <button class="layui-btn layui-btn-sm" id="toExcel">导 出</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.channelReduce.edit')): ?>
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.channelReduce.reduceRecord')): ?>
                            <a class="layui-btn layui-btn-sm" lay-event="distribute">变更记录</a>
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
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('admin.channel.channelReduce')): ?>
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
                    ,url: "<?php echo e(route('admin.channel.channelReduce.data')); ?>" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'channel_name', title: '渠道名称'}
                        ,{field: 'channel_code', title: '渠道码',sort: true}
                        ,{field: 'platform', title: '分发平台'}
                        ,{field: 'distribute_template_name', title: '分发模板名称'}
                        ,{field: 'distribute_page_name', title: '分发页'}
                        ,{field: 'reduce_type', title: 'buff',templet:function (d) {
                                if(d.reduce_type == 'apply_register'){
                                    return '申请注册比'
                                }else if(d.reduce_type == 'register'){
                                    return '比例'
                                }
                            }}
                        ,{field: 'reduce_rate', title: '数值', sort: true,width:210}
                        ,{field: 'updated_at', title: '上次修改时间', sort: true}
                        ,{field: 'modifier_name', title: '修改人'}
                        ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值

                    if(layEvent == 'distribute'){
                        location.href = '/admin/channelReduce/'+data.id+'/reduceRecord';
                    }
                    if(layEvent == 'edit'){
                        if(data.channel.deal_record[0] != null){
                            var last_deal_at = data.channel.deal_record[0].deal_at
                        }else{
                            var last_deal_at = ''
                        }

                        var id = data.id
                        var title = '';
                        var html = '';
                        if(data.reduce_type == 'apply_register'){
                            //按正常申请注册比
                            title = '按正常申请注册比'
                             html = '<form class="layui-form" id="addEmployeeForm" style="margin-top: 30px">' +
                                 '<div class="layui-form-item">' +
                                 '<label for="" class="layui-form-label" style="width: 160px;margin-left: -60px;"><strong class="item-required">*</strong>正常申请注册比</label>' +
                                 '<div class="layui-input-inline">' +
                                 '<input type="text" name="reduce_rate" id="reduce_rate"  lay-verify="reduce_rate_apply" placeholder=" " autocomplete="off" maxlength="4" value="'+data.reduce_rate+'" class="layui-input" style="width: 180px;">' +
                                 '<input type="hidden" name="old_reduce_rate" value="'+data.reduce_rate+'">' +
                                 '<input type="hidden" name="reduce_type" value="'+data.reduce_type+'">' +
                                 '<input type="hidden" name="page_id" value="'+data.distribute_page_id+'">' +
                                 '</div>' +
                                 '<span style="line-height: 40px;">最小单位：%</span>' +
                                 '</div>' +


                                 '<div class="layui-form-item">' +
                                 '<label for="" class="layui-form-label my_width" style="180px;margin-left: 20px;"><strong class="item-required">*</strong>生效时间</label>' +
                                 '<div class="layui-input-block">' +
                                 '<input type="text" class="layui-input" name="effect_on" lay-verify="effect_on"  id="test3" style="width: 200px" value="" autocomplete="off">' +
                                 '</div>' +
                                 '</div>' +

                                 '<div class="layui-form-item">' +
                                 '<label for="" class="layui-form-label my_width" style="180px;margin-left: 20px;">修改备注</label>' +
                                 '<div class="layui-input-block">' +
                                 '<textarea name="mark" id="mark" maxlength="50"  placeholder="" class="layui-textarea" style="width: 300px;"></textarea>' +
                                 '</div>' +
                                 '</div>' +
                                 '</form>';

                        }else if(data.reduce_type == 'register'){
                            //按比例扣量
                            title = '按比例扣量'
                             html = '<form class="layui-form" id="addEmployeeForm" style="margin-top: 30px">' +
                                 '<div class="layui-form-item">' +
                                 '<label for="" class="layui-form-label" style="width: 120px;margin-left: -40px;"><strong class="item-required">*</strong>比例扣量数值</label>' +
                                 '<div class="layui-input-inline">' +
                                 '<input type="text" name="reduce_rate" id="reduce_rate"  lay-verify="reduce_rate" placeholder="" autocomplete="off" value="'+data.reduce_rate+'" class="layui-input" style="width: 180px;">' +
                                 '<input type="hidden" name="old_reduce_rate" value="'+data.reduce_rate+'">' +
                                 '<input type="hidden" name="reduce_type" value="'+data.reduce_type+'">' +
                                 '<input type="hidden" name="page_id" value="'+data.distribute_page_id+'">' +
                                 '</div>' +
                                 '<span style="line-height: 40px;">最小单位：%</span>' +
                                 '</div>' +
                                 '<div class="layui-form-item">' +
                                 '<label for="" class="layui-form-label" style="160px">比例状态</label>' +
                                 '<div class="layui-input-block">' +
                                 '<input type="radio" name="type"  value="1" lay-filter="type" title="更改选中时间段数据的比例">' +
                                 '<input type="radio" name="type"  value="2" lay-filter="type" title="更改当前比例" checked>' +
                                 '</div>' +
                                 '</div>' +
                                 '<div class="times" style="display: none">' +
                                '<div class="layui-form-item">' +
                                '<label for="" class="layui-form-label my_width" style="160px"><strong class="item-required">*</strong>开始时间</label>' +
                                '<div class="layui-input-block">' +
                                '<input type="text" class="layui-input" name="start_time"  id="test1" style="width: 200px" value="" autocomplete="off">' +
                                '</div>' +
                                '</div>' +
                                 '<div class="layui-form-item">' +
                                 '<label for="" class="layui-form-label my_width" style="160px"><strong class="item-required">*</strong>结束时间</label>' +
                                 '<div class="layui-input-block">' +
                                 '<input type="text" class="layui-input" name="end_time"  id="test2" style="width: 200px" value="" autocomplete="off">' +
                                 '</div>' +
                                 '</div>' +
                                 '</div>' +
                                 '<div class="layui-form-item">' +
                                 '<label for="" class="layui-form-label my_width" style="160px">修改备注</label>' +
                                 '<div class="layui-input-block">' +
                                 '<textarea name="mark" id="mark"  maxlength="50"  placeholder="" class="layui-textarea" style="width: 300px;"></textarea>' +
                                 '</div>' +
                                 '</div>' +
                                '</form>';
                        }




                        layer.open({
                            type: 1,
                            title:'修改比例（'+title+'）',
                            skin: 'layui-layer-rim', //加上边框
                            area: ['500px', '400px'], //宽高
                            content: html,
                            btn: ['提交'],

                            yes: function(index, layero){

                                var reduce_rate = $('#reduce_rate').val();

                                form.verify({
                                    reduce_rate: function(value, item){ //value：表单的值、item：表单的DOM对象
                                        if(value == ''){
                                            return '比例扣量数值不能为空！';
                                        }
                                        if(!new RegExp("^[0-9]\\d*$").test(value)){
                                            return '比例扣量数值为0~100整数';
                                        }

                                        if(value>100 || value<0){
                                            return '比例扣量数值为0~100整数';
                                        }
                                    },
                                    start_time: function(value, item){ //value：表单的值、item：表单的DOM对象

                                        if(value == ''){
                                            return '开始时间是必填项';
                                        }

                                    },
                                    end_time: function(value, item){ //value：表单的值、item：表单的DOM对象

                                        if(value == ''){
                                            return '结束时间是必填项';
                                        }

                                    },
                                    my_mark: function(value, item){ //value：表单的值、item：表单的DOM对象

                                        if(value.trim().replace(/\r|\n|\\s/g,"").length > 50){
                                            return '修改备注最多50个字';
                                        }

                                    },
                                    effect_on: function(value, item){ //value：表单的值、item：表单的DOM对象

                                        if(value == ''){
                                            return '生效时间是必填项';
                                        }

                                    },
                                    reduce_rate_apply: function(value, item){ //value：表单的值、item：表单的DOM对象
                                        if(value == ''){
                                            return '正常申请注册比不能为空！';
                                        }
                                        if(!new RegExp("^[0-9]\\d*$").test(value)){
                                            return '正常申请注册比为0~1000整数';
                                        }

                                        if(value>1000 || value<0){
                                            return '正常申请注册比为0~1000整数';
                                        }
                                    },


                                });
                                form.on('submit(formVerify)', function(data){
                                    if($('#test1').val() > $('#test2').val()){
                                        layer.msg('结束时间不能小于开始时间',{icon:5});
                                        return false;
                                    }
                                    $.ajax({
                                        type: 'PUT',
                                        url: "/admin/channelReduce/"+id+"/update",
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
                                });



                            },
                            success: function(layero, index){

                                var  currentTime = new Date().toLocaleString('chinese', { hour12: false }) // 获取当前时间
                                //执行一个laydate实例
                                if(last_deal_at){
                                    laydate.render({
                                        elem: '#test1', //指定元素
                                        type: 'datetime'
                                        ,trigger: 'click'
                                        ,isInitValue: false
                                        ,max:currentTime
                                        ,min:last_deal_at
                                    });
                                    laydate.render({
                                        elem: '#test2', //指定元素
                                        type: 'datetime',
                                        trigger: 'click',
                                        isInitValue: false,
                                        max:currentTime,
                                        min:last_deal_at
                                    });
                                }else{
                                    laydate.render({
                                        elem: '#test1', //指定元素
                                        type: 'datetime',
                                        trigger: 'click',
                                        isInitValue: false,
                                        max:currentTime
                                    });
                                    laydate.render({
                                        elem: '#test2', //指定元素
                                        type: 'datetime',
                                        trigger: 'click',
                                        isInitValue: false,

                                        max:currentTime
                                    });

                                }
                                laydate.render({
                                    elem: '#test3', //指定元素
                                    type: 'datetime',
                                    trigger: 'click',
                                    isInitValue: false,
                                    min:currentTime
                                });

                                layero.addClass('layui-form');
                                layero.find('.layui-layer-btn0').attr('lay-filter','formVerify').attr('lay-submit','');


                                form.on('radio(type)', function(data){
                                    if(data.value == 1){
                                       $(data.elem).parent().parent().parent().find('.times').css('display','block')
                                        $(data.elem).parent().parent().parent().find('.times #test1').attr('lay-verify','start_time')
                                        $(data.elem).parent().parent().parent().find('.times #test2').attr('lay-verify','end_time')
                                    }else if(data.value == 2){
                                        $(data.elem).parent().parent().parent().find('.times').css('display','none')
                                        $(data.elem).parent().parent().parent().find('.times #test1').attr('lay-verify','')
                                        $(data.elem).parent().parent().parent().find('.times #test2').attr('lay-verify','')
                                    }
                                });
                                $("#mark").keyup(function () {
                                    $("#mark").attr('lay-verify','my_mark')
                                })
                                form.render()
                            },

                        });
                    }

                    laydate.render({
                        elem: '#test1' //指定元素
                        ,type: 'datetime'
                        ,trigger: 'click'
                        ,isInitValue: false
                    });
                    laydate.render({
                        elem: '#test2' //指定元素
                        ,type: 'datetime'
                        ,trigger: 'click'
                        ,isInitValue: false
                    });
                    laydate.render({
                        elem: '#test3' //指定元素
                        ,type: 'datetime'
                        ,trigger: 'click'
                        ,isInitValue: false
                    });
                    form.render()
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
                    var channel_code = $("#channel_code").val()
                    var platform = $("#platform").val()
                    var distribute_template_id = $("#distribute_template_id").val()
                    var reduce_type = $("#reduce_type").val()
                    var distribute_page_name = $("#distribute_page_name").val()
                    var u = '<?php echo e(route('admin.channel.channelReduce.toExcel')); ?>';
                    u = u+'?channel_code='+channel_code+'&platform='+platform+'&distribute_template_id='+distribute_template_id+'&ids='+ids+'&reduce_type='+reduce_type+'&distribute_page_name='+distribute_page_name;
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
                //     var channel_code = $("#channel_code").val()
                //     var platform = $("#platform").val()
                //     var distribute_template_id = $("#distribute_template_id").val()
                //     var reduce_type = $("#reduce_type").val()
                //     var distribute_page_name = $("#distribute_page_name").val()
                //
                //     dataTable.reload({
                //         where:{channel_code:channel_code,platform:platform,distribute_template_id:distribute_template_id,reduce_type:reduce_type,distribute_page_name:distribute_page_name},
                //         page:{curr:1}
                //     })
                // });

            });

        </script>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>