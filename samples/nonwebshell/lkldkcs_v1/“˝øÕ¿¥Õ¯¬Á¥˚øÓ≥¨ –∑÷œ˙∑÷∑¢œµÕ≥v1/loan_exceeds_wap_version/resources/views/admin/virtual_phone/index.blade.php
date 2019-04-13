@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-form" >
                <div class="layui-btn-group">
                    @can('data.virtualPhone.create')
                        <a class="layui-btn layui-btn-sm" id="create" href="{{route('admin.virtualPhone.create')}}">导入号码</a>
                    @endcan
                    @can('data.virtualPhone.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" id="listDelete">删除</a>
                    @endcan
                    @can('data.virtualPhone.destroyAll')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" id="delAll">一键清空</a>
                    @endcan


                </div>
            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('data.virtualPhone.destroy')
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
                ,url: "{{ route('admin.virtualPhone.data') }}" //数据接口
                ,where:{model:"role"}
                ,page: true //开启分页
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    ,{field: 'phone', title: '手机号码'}
                    ,{field: 'created_at', title: '导入时间'}
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
                        $.post("{{ route('admin.virtualPhone.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
                            if (result.code===0){
                                delReload(dataTable);
                                layer.msg(result.msg,{icon:1})
                            }else {
                                layer.msg(result.msg,{icon:2});
                            }
                            layer.close(index);
                        });
                    });
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
                        $.post("{{ route('admin.virtualPhone.destroy') }}",{_method:'delete',ids:ids},function (result) {
                            if (result.code===0){
                                delReload(dataTable,ids.length);
                                layer.msg(result.msg,{icon:1})
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

            //一键清空
            $('#delAll').on('click',function () {
                layer.confirm('确认清空所有号码吗？', function(index){
                    $.post("{{ route('admin.virtualPhone.destroyAll') }}",{_method:'delete'},function (result) {
                        if (result.code===0){
                            dataTable.reload()
                            layer.msg(result.msg,{icon:1})
                        }else {
                            layer.msg(result.msg,{icon:2});
                        }
                        layer.close(index);
                    });
                })
            });

        })
</script>
@endsection