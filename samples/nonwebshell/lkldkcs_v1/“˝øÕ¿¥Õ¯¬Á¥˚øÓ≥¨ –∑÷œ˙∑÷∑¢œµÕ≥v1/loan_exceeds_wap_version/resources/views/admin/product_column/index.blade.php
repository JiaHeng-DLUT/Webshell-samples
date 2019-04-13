@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto layui-form">

            <div class="layui-form-item">
                <div class="layui-inline">
                    <label class="layui-form-label">栏目名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" placeholder="请输入栏目名称" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-inline">
                    <button class="layui-btn layuiadmin-btn-useradmin" lay-submit="" lay-filter="product-column-search">
                        <i class="layui-icon layui-icon-search layuiadmin-button-btn"></i>
                    </button>
                </div>
            </div>

        </div>
        <div class="layui-card-body">

            <div class="layui-btn-group layui-inline" style="padding-bottom: 10px">
                @can('product.column.create')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.productColumn.create') }}">添 加</a>
                @endcan
                @can('product.column.destroy')
                    <a class="layui-btn layui-btn-danger layui-btn-sm" id="listDelete">删 除</a>
                @endcan
            </div>

            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('product.column.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('product.column.destroy')
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
                ,url: "{{ route('admin.productColumn.data') }}" //数据接口
                ,page: true //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    ,{field: 'name', title: '栏目名称'}
                    ,{field: 'sort', title: '排序值',sort:true}
                    ,{field: 'updated_at', title: '上次修改时间',sort:true}
                    ,{title:'操作',width: 150, toolbar: '#options'}
                ]]
            });


            //监听搜索
            form.on('submit(product-column-search)', function(data){
                var field = data.field;

                //执行重载
                table.reload('dataTable', {
                    where: field
                    ,page:{
                        curr:1
                    }
                });
            });

            //监听排序事件
            table.on('sort(dataTable)', function(obj){
                table.reload('dataTable', {
                    initSort: obj
                    ,where: {
                        field: obj.field //排序字段
                        ,order: obj.type //排序方式
                    }
                    ,page:{
                        curr:1
                    }
                });
            });


            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'del'){
                    layer.confirm('请确认需要删除'+data.name+'栏目？', function(index){
                        $.post("{{ route('admin.productColumn.destroy') }}",{_method:'delete',ids:[data.id]},function (result) {
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
                    location.href = '/admin/productColumn/'+data.id+'/edit';
                }else {

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
                        $.post("{{ route('admin.productColumn.destroy') }}",{_method:'delete',ids:ids},function (result) {
                            if (result.code===0){
                                delReload(dataTable,ids.length);
                                layer.msg(result.msg,{icon:1});
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

        })
    </script>
@endsection