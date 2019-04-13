@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">

                @can('admin.website.circle.create')
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.website.circle.create') }}">添 加</a>
                @endcan
                @can('admin.website.circle.destroy')
                    <button class="layui-btn layui-btn-sm layui-btn-danger" id="listDelete">删 除</button>
                @endcan
            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('admin.website.circle.edit')
                    <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                        @can('admin.website.circle.destroy')
                            <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="destroy">删除</a>
                        @endcan

                </div>
            </script>

            <script type="text/html" id="url">
                <img style="display: inline-block; width: 200px; height: 100px;" src="{{env('IMG_URL')}}@{{ d.url }}" alt="">
            </script>

        </div>
    </div>
@endsection

@section('script')
    @can('admin.website.circle')
        <style>
            tbody .layui-table-cell{
                height: 100px;
            }
            .layui-table img{
                max-width: 200px;
            }
        </style>
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
                ,url: "{{ route('admin.website.circle.data') }}" //数据接口
                ,page: true //开启分页
                ,cols: [[ //表头
                    {checkbox: true,fixed: true}
                    // ,{field: 'id', title: 'ID', sort: true,width:80}
                    ,{field: 'url', title: '二维码图片',templet: '#url'}
                    ,{field: 'title', title: '标题'}
                    ,{field: 'copy_content', title: '可复制的内容'}
                    ,{field: 'intro', title: '描述'}
                    ,{field: 'slug', title: '圈子类型',templet:function (d) {
                            if(d.slug === 'wechat_public'){
                                return '微信公众号'
                            }else if(d.slug === 'wechat_person'){
                                return '微信个人号'
                            }else if(d.slug === 'qq'){
                                return 'QQ'
                            }else{
                                return '未知类型'
                            }
                        }}
                    ,{field: 'sort', title: '排序',sort:true}
                    ,{field: 'created_at', title: '更新时间'}
                    ,{fixed: 'right', title:'操作',width: 220, align:'center', toolbar: '#options'}
                ]]
            });

            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'destroy'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("{{ route('admin.website.circle.destroy') }}",{_method:'delete',ids:[data.id]},function (res) {
                            if(res.code===0){
                               delReload(dataTable);
                                layer.msg(res.msg,{icon:6});

                            }else {
                                layer.msg(res.msg,{icon:5});
                            }
                        });
                    });
                } else if(layEvent === 'edit'){
                    location.href = '/admin/website/circle/'+data.id+'/edit';
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
                        $.post("{{ route('admin.website.circle.destroy') }}",{_method:'delete',ids:ids},function (res) {
                            if(res.code===0){
                                delReload(dataTable,ids.length);
                                layer.msg(res.msg,{icon:6});

                            }else {
                                layer.msg(res.msg,{icon:5});
                            }
                        });
                    })
                }else {
                    layer.msg('请选择删除项',{icon:5})
                }
            })

            //搜索
            $("#searchBtn").click(function () {
                var catId = $("#category_id").val()
                var title = $("#title").val();
                var start_time = $("#start_time").val();
                var end_time = $("#end_time").val();
                dataTable.reload({
                    where:{category_id:catId,title:title,start_time:start_time,end_time:end_time},
                    page:{curr:1}
                })
            });

            laydate.render({
                elem: '#start_time' //指定元素
                ,type: 'datetime'
            });
            laydate.render({
                elem: '#end_time' //指定元素
                ,type: 'datetime'
            });
        });

    </script>
    @endcan
@endsection