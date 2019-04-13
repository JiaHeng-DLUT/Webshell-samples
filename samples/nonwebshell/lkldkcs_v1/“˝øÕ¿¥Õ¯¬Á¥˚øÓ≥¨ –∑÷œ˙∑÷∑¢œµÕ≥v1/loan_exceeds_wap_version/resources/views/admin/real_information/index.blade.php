@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">

            <div class="layui-form" >
                <div class="layui-btn-group">
                    <a class="layui-btn layui-btn-sm" id="create" href="{{route('admin.real.information.export')}}">导出Excel</a>
                   {{-- @can('data.virtualPhone.create')
                        <a class="layui-btn layui-btn-sm" id="create" href="{{route('admin.virtualPhone.create')}}">导出Excel</a>
                    @endcan--}}
                </div>
            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                   {{-- @can('admin.real.information.show')--}}
                        <a class="layui-btn layui-btn-sm" lay-event="show">查看</a>
                   {{-- @endcan--}}
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['table','form'],function () {
            var form = layui.form;
            var table = layui.table;
            //用户表格初始化
             table.render({
                elem: '#dataTable'
                , id: 'dataTable'
                // ,height: 500
                , url: "{{ route('admin.real.information.data') }}" //数据接口
                , where: {model: "role"}
                , page: true //开启分页
                , cols: [[ //表头
                    {checkbox: true, fixed: true}
                    , {field: 'id', title: '编号',width:80}
                    , {field: 'phone', title: '手机号码',templet: function(d){
                            return d.member.phone;
                         },width:300}
                    , {field: 'real_name', title: '姓名',width:150}
                    , {field: 'id_number', title: '身份证号码'}
                    , {field: 'created_at', title: '记录时间'}
                    , {title: '操作', width: 100, toolbar: '#options'}
                ]]
            });
            //监听搜索
            form.on('submit(LAY-user-back-search)', function (data) {
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
                location.href = '/admin/real/information/show/'+data.id;
            });

        })


    </script>
@endsection