@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            @can('data.hotCity.create')
                <div class="layui-btn-group ">
                    <a class="layui-btn layui-btn-sm" id="add" href="{{route('admin.hotCity.create')}}">添加</a>
                </div>
            @endcan
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('data.hotCity.edit')
                        <a class="layui-btn  layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('data.hotCity.destroy')
                        <a class="layui-btn  layui-btn-danger layui-btn-sm" lay-event="del">移除</a>
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
                // ,height: 500
                ,url: "{{ route('admin.hotCity.data') }}" //数据接口
                ,page: true //开启分页
                ,cols: [[ //表头
                    // {checkbox: true,fixed: true},
                    // {field: 'id', title: 'ID',width:100}
                    {title: '城市名称',templet:function (d) {
                        return d.city.name;
                    }}
                    ,{field: 'sort', title: '排序值'}
                    ,{field: 'created_at', title: '创建时间'}
                    ,{field: 'updated_at', title: '更新时间'}
                    ,{title:'操作',width: 150, toolbar: '#options'}
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
                    layer.confirm('确认移除该热门城市吗？', function(index){
                        $.post("{{ route('admin.hotCity.destroy') }}",{_method:'delete',id:data.id},function (result) {
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
                    window.location.href='/admin/hotCity/'+data.id+'/edit';
                }else {

                }
            });
        })
    </script>
@endsection