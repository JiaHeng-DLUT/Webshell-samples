@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
        {{--<div class="layui-btn-group layui-inline">--}}
            {{--@can('data.page.create')--}}
                {{--<a class="layui-btn layui-btn-sm" href="{{ route('admin.page.create') }}">添 加</a>--}}
            {{--@endcan--}}
        {{--</div>--}}
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('data.page.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
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
                ,url: "{{ route('admin.page.data') }}" //数据接口
                ,where:{model:"role"}
                ,page: false //开启分页
                ,cols: [[ //表头
                    {field: 'title', title: '单页名称'}
                    ,{field: 'sort', title: '排序值'}
                    ,{field: 'updated_at', title: '上次修改时间'}
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
                    {{--layer.confirm('确认删除吗？', function(index){--}}
                        {{--$.post("{{ route('admin.page.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {--}}
                            {{--if (result.code===0){--}}
                                {{--obj.del(); //删除对应行（tr）的DOM结构--}}
                            {{--}--}}
                            {{--layer.close(index);--}}
                            {{--layer.msg(result.msg,{icon:6})--}}
                        {{--});--}}
                    {{--});--}}
                }else if(layEvent==='edit'){
                    location.href = '/admin/page/'+data.id+'/edit';
                }else {

                }
            });

        })
    </script>
@endsection