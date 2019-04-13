@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('admin.channel.distributeTemplate.create')
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.channel.distributeTemplate.create') }}">添 加</a>
                @endcan
            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('admin.channel.distributeTemplate.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan

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
    @can('admin.channel.distributeTemplate')
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
                    ,url: "{{ route('admin.channel.distributeTemplate.data') }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        // ,{field: 'id', title: 'ID', sort: true,width:80}

                        ,{field: 'name', title: '模板名称'}
                        ,{field: 'support_custom', title: '是否支持定制'}
                        ,{field: 'custom_status', title: '是否定制'}
                        ,{field: 'custom_range', title: '可定制范围'}
                        ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'edit'){

                        location.href = '/admin/distributeTemplate/'+data.id+'/edit';
                    }
                });








            });

        </script>
    @endcan
@endsection