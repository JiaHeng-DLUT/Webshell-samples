@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group">

            </div>
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('admin.website.image.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">配置</a>
                    @endcan
                </div>
            </script>
        </div>
    </div>
@endsection

@section('script')
    @can('admin.website.image')
        <script>


            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;

                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    // ,height: 500
                    ,url: "{{ route('admin.website.image.data') }}" //数据接口
                    ,where:{model:"image"}
                    ,page: true //开启分页
                    ,cols: [[ //表头

                        {field: 'name', title: '广告位名称'}
                        ,{field: 'now_number', title: '图片已有'}
                        ,{field: 'number', title: '图片上限'}
                        ,{field: 'platform', title: '所属平台'}
                        ,{field: 'time', title: '上次修改时间'}
                        ,{fixed: 'right',title: '操作', width: 260, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                     if(layEvent === 'edit'){
                        location.href = '/admin/website/image/'+data.id+'/edit';
                    }
                });


            })
        </script>
    @endcan
@endsection