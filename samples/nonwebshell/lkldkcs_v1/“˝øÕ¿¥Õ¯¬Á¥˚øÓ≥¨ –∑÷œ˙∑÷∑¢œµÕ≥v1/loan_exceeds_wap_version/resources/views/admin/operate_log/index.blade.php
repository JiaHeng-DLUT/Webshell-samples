@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-form" >
                <div class="layui-btn-group">
                    @can('data.operateLog.excel')
                        <a class="layui-btn layui-btn-sm" id="excel">导出</a>
                    @endcan
                </div>
            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('data.operateLog.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;
            var table = layui.table;
            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,id:'dataTable'
                // ,height: 500
                ,url: "{{ route('admin.operateLog.data') }}" //数据接口
                ,where:{model:"role"}
                ,page: true //开启分页
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    // {field: 'id', title: 'ID',width:100}
                    ,{title: '管理员',templet:function (d) {
                        if(d.user){
                            return d.user.name+'('+d.user.username+')';
                        }else {
                            return '';
                        }
                    }}
                    ,{field: 'path', title: '路由地址'}
                    ,{field: 'ip', title: 'Ip地址'}
                    ,{field: 'input', title: '请求参数'}
                    ,{field: 'created_at', title: '记录时间'}
                    ,{title:'操作',width: 100, toolbar: '#options'}
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
                if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        console.log(dataTable);
                        $.post("{{ route('admin.operateLog.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                            if (result.code===0){
                                delReload(dataTable);
                            }
                            layer.close(index);
                            layer.msg(result.msg,{icon:6})
                        });
                    });
                }
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
                window.location.href="{{ route('admin.operateLog.excel') }}"+"?ids="+ids
            })
        })
    </script>
@endsection