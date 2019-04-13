@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">
            <form class="layui-form-item" id="search-form">
                    <div class="layui-inline">
                        <label class="layui-form-label">创建时间</label>
                        <div class="layui-input-block">
                            <div class="layui-input-inline">
                                <input type="text"  placeholder="开始时间" autocomplete="off" class="layui-input" name="create_start" id="create_start">
                            </div>
                            <div class="layui-form-mid">至</div>
                            <div class="layui-input-inline">
                                <input type="text"  placeholder="结束时间" autocomplete="off" class="layui-input" name="create_end" id="create_end">
                            </div>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">执行时间</label>
                        <div class="layui-input-block">
                            <div class="layui-input-inline">
                                <input type="text"  placeholder="开始时间" autocomplete="off" class="layui-input" name="action_start" id="action_start">
                            </div>
                            <div class="layui-form-mid">至</div>
                            <div class="layui-input-inline">
                                <input type="text"  placeholder="结束时间" autocomplete="off" class="layui-input" name="action_end" id="action_end">
                            </div>
                        </div>
                    </div>
                    <div class="layui-inline">
                        <label class="layui-form-label">消息内容</label>
                        <div class="layui-input-inline">
                            <input type="text" name="body" id="body" placeholder="消息内容" class="layui-input" >
                        </div>
                    </div>
                    <div class="layui-inline">
                        <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="searchBtn">
                            <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                        </button>
                    </div>
            </form>
            <div class="layui-btn-group">
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.push.create') }}" >+push推送</a>
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.system.create') }}">+系统消息</a>
            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable" ></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @{{#  if(d.send_type ==  2 && d.status == 0){ }}
                    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @{{#  } else { }}
                    <a class="layui-btn layui-btn-sm" lay-event="edit">查看</a>
                    @{{#  } }}



                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>

            <script type="text/html" id="category">

            </script>

        </div>
    </div>
@endsection

@section('script')
    {{--@can('zixun.article')--}}
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
                ,url: "{{ route('admin.push.data') }}" //数据接口
                ,page: true //开启分页
                ,limits: [50,100,200]
                ,limit: 50 //每页默认显示的数量
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    ,{field: 'id', title: 'ID',width:80}
                    ,{field: 'type', title: '类型',templet: function(d){
                        if(d.type == 'push'){
                            return 'push推送';
                        }else{
                            return '系统消息';
                        }
                    }}
                    ,{field: 'title', title: '标题'}
                    ,{field: 'content', title: '内容'}
                    ,{field: 'created_at', title: '创建时间'}
                    ,{field: 'status', title: '发送状态',templet: function(d){
                        if(d.status == 0){
                            return '未发送';
                        }else{
                            return '已发送';
                        }
                    }}
                    ,{field: 'send_at', title: '执行时间',templet: function(d){
                        if(d.send_type == 1 &&(d.status == 1)){
                            return d.send_at?d.send_at:d.created_at;
                        }else if((d.send_type == 2) &&(d.status == 1) ){
                            return d.send_at;
                        }else{
                            return '';
                        }
                    }}
                    ,{field: 'counts', title: '发送数量'}
                    ,{field: 'counts', title: '到达数量',templet: function(d){
                        if(d.status == 1){
                            return d.counts;
                        }else{
                            return '';
                        }
                    }}
                    ,{field: 'clicks', title: '点击数量',templet: function(d){
                        return d.device.length;
                    }}
                    ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                ]]
            });

            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'edit'){
                    if(data.type == 'push') {
                        location.href = '/admin/push/' + data.id + '/edit';
                    }else{
                        location.href = '/admin/system/' + data.id + '/edit';
                    }
                }
            });
            //排序监听
            table.on('sort(dataTable)', function(obj){ //注：tool是工具条事件名，test是table原始容器的属性 lay-filter="对应的值"
                var bank = $("#credit_bank_id").val()
                var name = $("#card_name").val();
                var status = $("#status").val();
                dataTable.reload({
                    initSort: obj
                    ,where:{name:name,bank:bank,status:status,type: obj.field //排序字段
                        ,order: obj.type //排序方式
                    },
                    page:{curr:1}
                })

            });


            //状态变更
            form.on('switch(status)', function(data){
                var id=$(data.elem).data('id');
                var status=$(data.elem).data('value');
                $.post("{{route('admin.credit.set')}}",{id:id,status:status},function (res) {
                    if(res.code===0){
                        $(data.elem).attr('value',res.status);
                        layer.msg(res.info,{icon:6});
                    }else {
                        layer.msg(res.info,{icon:5});
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
                        $.post("{{ route('admin.website.article.destroy') }}",{_method:'delete',ids:ids},function (result) {
                            if (result.code==0){
                                dataTable.reload()
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    })
                }else {
                    layer.msg('请选择删除项',{icon:5})
                }
            })

            //搜索
           /* $("#searchBtn").click(function () {
                var create_start = $("#create_start").val()
                var create_end = $("#create_end").val();
                var action_start = $("#action_start").val();
                var action_end = $("#action_end").val();
                var body = $("#body").val();
                console.log(name)
                dataTable.reload({
                    where:{create_start:create_start,create_end:create_end,action_start:action_start,action_end:action_end,body:body},
                    page:{curr:1}
                })
            });*/
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
                var create_start = $("#create_start").val()
                var create_end = $("#create_end").val();
                var action_start = $("#action_start").val();
                var action_end = $("#action_end").val();
                var body = $("#body").val();
                var u = '{{route('admin.push.excel')}}'
                u = u+'?create_start='+create_start+'&create_end='+create_end+'&action_start='+action_start+'&action_end='+action_end+'&body='+body;
                window.location.href = u;
            });

            laydate.render({
                elem: '#create_start' //指定元素
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#create_end' //指定元素
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#action_start' //指定元素
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#action_end' //指定元素
                ,type: 'datetime'
            });
        });

    </script>
    {{--@endcan--}}
@endsection