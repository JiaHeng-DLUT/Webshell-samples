<?php $__env->startSection('content'); ?>
    <style>
        .layui-table-cell{
            display:table-cell;
            vertical-align: middle;
        }
    </style>
    <div class="layui-card">

        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <form class="layui-form-item" id="search-form">
                <div class="layui-inline">
                    <label class="layui-form-label">评论内容</label>
                    <div class="layui-input-inline">
                        <input type="text" name="content" id="content" placeholder="请输入评论内容" class="layui-input" >
                    </div>
                </div>
                <div class="layui-inline">
                    <label class="layui-form-label">评分</label>
                    <div class="layui-input-inline">
                        <select name="star" lay-verify="" id="star">
                            <option value="0">全部评分</option>
                            <option value="1" >1</option>
                            <option value="2" >2</option>
                            <option value="3" >3</option>
                            <option value="4" >4</option>
                            <option value="5" >5</option>
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
                    <a class="layui-btn layui-btn-sm"  style="width: 90px" href="/template.xlsx">下载导入模板</a>
                    <button type="button" class="layui-btn layui-btn-sm" id="app" lay-data="{accept: 'file',exts: 'xls|xlsx'}"> 导入excel</button>
                    <button class="layui-btn layui-btn-sm" id="listExport" style="width: 90px">导出</button>
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删除</button>
                </div>
            </div>
        </div>

      
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" lay-event="edit" >编辑</a>
                    <span style="margin-right: 20px"></span>
                    <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
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
    
    <script>
        layui.use(['layer','table','form','laydate','upload'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            var laydate = layui.laydate;
            var upload = layui.upload
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,url: "<?php echo e(route('admin.virtual.comment.data')); ?>" //数据接口
                ,page: true //开启分页
                ,limits: [50,100,200]
                ,limit: 50 //每页默认显示的数量
                ,cols: [[ //表头
                    {checkbox: true}
                    ,{field: 'star', title: '评分',width: 100, align:'center'}
                    ,{field: 'content', title: '评论内容', align:'center',templet: function(d){
                        if(d.content.length > 60)
                        {
                            return  d.content.substring(0,60)+'...'
                        }else{
                            return  d.content
                        }
                     }}
                    ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                ]]
            });
            //导入EXCEL
            upload.render({
                elem: '#app'
                ,url: '<?php echo e(route("admin.virtual.comment.import.template")); ?>'
                ,multiple: false
                ,data:{"_token":"<?php echo e(csrf_token()); ?>",maxSize:1,filename:'file'}
                ,done: function(res){
                    console.log(res);
                    if(res.code == 0){//成功
                        layer.msg(res.msg,{icon:1})
                        dataTable.reload()
                    }else{
                        layer.msg(res.msg,{icon:6})
                    }
                }
            });
            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("<?php echo e(route('admin.virtual.comment.destroy')); ?>",{_method:'delete',id:data.id},function (result) {
                            if (result.code==0){
                                obj.del(); //删除对应行（tr）的DOM结构
                            }
                            layer.close(index);
                            layer.msg(result.info,{icon:6})
                        });
                    });
                }
                else if(layEvent === 'edit'){
                    layer.open({
                        type:0,
                        title:'编辑',
                        anim: 0 ,

                        scrollbar: false,
                        area:["550px","450px"] ,
                        content: '<form class="layui-form" id="addEmployeeForm">' +
                        ' <div class="layui-row layui-col-space10 layui-form-item"  style="margin-top: 20px;">' +
                            '<div class="layui-col-lg9">' +
                                '<label class="layui-form-label">评分：</label>' +
                                '<div class="layui-input-block">' +
                                    '<input type="number" name="star" id="edit_star" value="'+data.star+'" placeholder="请输入评分"  autocomplete="off" class="layui-input">' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        ' <div class="layui-row layui-col-space10 layui-form-item">' +
                            '<div class="layui-col-lg9">' +
                                '<label class="layui-form-label">评论内容：</label>' +
                                '<div class="layui-input-block">' +
                                    '<textarea  id="edit_content" onkeyup="onfo($(this))" class="layui-input" style="height: 150px;resize:none">'+data.content+'</textarea>' +
                                    '<span style=" position: absolute; color: #ccc;top: 125px;left: 200px;"><span id="count">'+data.content.length+'</span>/100</span>' +
                                '</div>' +
                            '</div>' +
                        '</div>' +
                        '</form>',
                        btn: ['确定'],
                        yes: function(index, layero){
                            var edit_star = $('#edit_star').val();
                            var edit_content = $("#edit_content").val();
                            if(edit_star < 1){
                                layer.msg("请输入评分", {icon: 2, time: 2000});
                                return false;
                            }else if(!edit_content){
                                layer.msg("请输入评论内容", {icon: 2, time: 2000});
                                return false;
                            }else if(edit_content.length > 100){
                                layer.msg("请输入评论内容,100个字以内", {icon: 2, time: 2000});
                                return false;
                            }
                            $.post('<?php echo e(route('admin.virtual.comment.update')); ?>',
                                {   edit_star:edit_star,
                                    edit_content:edit_content,
                                    id:data.id
                                },
                                function(data){
                                    if(data.code==0){
                                        layer.msg(data.info,{'icon':1,'time':2000});
                                        window.setTimeout(function(){
                                            window.location.href='/admin/virtual/comment/index'
                                        },2000)
                                    }else{
                                        layer.msg(data.info,{'icon':2,'time':2000});
                                    }
                                })
                        }
                    });
                }
            });
            //监听搜索
            form.on('submit(searchBtn)', function(data){
                var field = data.field;
                console.log(data.field)
                //执行重载
                table.reload('dataTable', {
                     where: field
                    ,page: {
                        curr: 1 //重新从第 1 页开始
                    }
                });
                return false;
            });
            //搜索
            /*$("#searchBtn").click(function () {
                var content = $("#content").val();
                var star = $("#star").val();
                dataTable.reload({
                    where:{content:content,star:star},
                    page:{curr:1}
                })
            });*/
            //下载模板
            $("#downTemplate").click(function () {
                layer.confirm('确认下载模板吗？', function(index){
                    $.get("<?php echo e(route('admin.virtual.comment.down.template')); ?>",function (result) {
                        layer.close(index);
                    });
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
                        $.post("<?php echo e(route('admin.virtual.comment.audit.destroy')); ?>",{ids:ids},function (result) {
                            if (result.code==0){
                                delReload(dataTable,ids.length);
                            }
                            layer.close(index);
                            layer.msg(result.info,{icon:6})
                        });
                    })
                }else {
                    layer.msg('请选择需要批量处理的评论',{icon:5})
                }
            })
            //按钮批量导出
            $("#listExport").click(function () {
                var ids = []
                var hasCheck = table.checkStatus('dataTable')
                var hasCheckData = hasCheck.data
                if (hasCheckData.length>0){
                    $.each(hasCheckData,function (index,element) {
                        ids.push(element.id)
                    })
                }
                var content = $("#content").val();
                var star = $("#star").val();
                var u = '<?php echo e(route('admin.virtual.comment.export')); ?>'
                u = u+'?content='+content+'&star='+star+'&ids='+ids;
                window.location.href=u;
            })
            laydate.render({
                elem: '#start_time' //指定元素
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#end_time' //指定元素
                ,type: 'datetime'
            });
        });
        function  onfo(e){
           var str = $(e).val();
           var count = 0;
            if (str.length > 100) {
                count =100;
                $(e).val(str.substring(0, 100));
            }else{
                count =  str.length;
            }
            $("#count").text(count);
        }

    </script>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>