@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            @if(request('level'))
                <div class="layui-btn-group ">
                    <a class="layui-btn layui-btn-sm" id="returnParent" href="javascript:history.back()">返回上级</a>
                </div>
            @endif
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('data.district')
                        <a class="layui-btn  layui-btn-sm" lay-event="children">查看下级</a>
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
                ,url: "{{ route('admin.district.data') }}"+"?parent_id={{request('parent_id',0)}}&level={{request('level')}}" //数据接口
                ,page: true //开启分页
                ,cols: [[ //表头
                    // {checkbox: true,fixed: true},
                    // {field: 'id', title: 'ID',width:100}
                    {field: 'adcode', title: '行政编码'}
                    ,{field: 'name', title: '名称'}
                    ,{field: 'created_at', title: '创建时间'}
                    ,{field: 'updated_at', title: '更新时间'}
                    @if(request('level')!='city')
                    ,{title:'操作',width: 100, toolbar: '#options'}
                    @endif
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
                if(layEvent === 'children'){
                    window.location.href='/admin/district?parent_id='+data.id+'&level='+data.level;
                }
            });
        })
    </script>
@endsection