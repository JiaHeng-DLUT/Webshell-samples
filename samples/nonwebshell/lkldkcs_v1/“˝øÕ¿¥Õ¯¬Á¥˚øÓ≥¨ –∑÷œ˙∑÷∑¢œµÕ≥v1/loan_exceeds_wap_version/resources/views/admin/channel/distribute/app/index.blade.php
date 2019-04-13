@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                @can('admin.channel.distribute.create')
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.channel.distribute.create',['id'=>$id]) }}">添加渠道包</a>
                    @endcan
            </div>
        </div>
        <div class="layui-card-body">
            <ul class="clearfixs-box">
                @if(count($apps))
                    @foreach($apps as $app)
                        <li class="clearfix-item">
                            <div class="lf">
                                <img src="@if($app->logo) {{ env('IMG_URL').$app->logo }} @else /images/default.png @endif" alt="" width="100px" height="100px">
                                <p>
                                    {{--<button  class="layui-btn layui-btn-xs app_edit" href="{{ route('admin.channel.distribute.edit',['id'=>$id,'app_id'=>$app->id]) }}" >编 辑</button>--}}
                                    @can('admin.channel.distribute.edit')
                                        <button  class="layui-btn layui-btn-xs" onclick="app_edit('{{$id}}','{{$app->id}}')" >编 辑</button>
                                    @endcan
                                    @can('admin.channel.distribute.destroy')
                                        <button class="layui-btn layui-btn-xs @if ($loop->first) layui-btn-disabled  @else layui-btn-danger @endif " onclick="app_del('{{$id}}','{{$app->id}}','{{$app->name}}')"  @if ($loop->first) disabled="disabled" @endif >删 除</button>
                                    @endcan

                                </p>
                            </div>
                            <div class="lf" style="margin-left: 20px">
                                <p style="font-size: 18px;color: #333333;margin-bottom: 15px">{{ $app->name }}</p>
                                <p class="mb10"><span class="w tx-c">包名</span><span>{{ $app->package_name }}</span></p>
                                <p class="mb10"><span  class="w tx-c">版本</span><span>{{ $app->version }}</span></p>
                                <p><span  class="w tx-c">修改时间</span><span>{{ $app->updated_at }}</span></p>
                            </div>
                        </li>

                    @endforeach
                @else
                    暂无渠道包
                @endif

            </ul>
        </div>
    </div>

    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            <div class="layui-btn-group ">
                    @can('admin.channel.distribute.createDistribute')
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.channel.distribute.createDistribute',['channel_id'=>$id]) }}">添 加</a>
                    @endcan
                    {{--    @can('admin.channel.distribute.distributeUpdate')
                    <a class="layui-btn layui-btn-sm" id="update_distributes">批量刷新模板</a>
                        @endcan--}}
                    <a class="layui-btn layui-btn-sm" href="{{ route('admin.channel') }}">返 回</a>

            </div>

        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                <div class="layui-btn-group">
                   {{-- @can('admin.channel.distribute.distributeUpdate')
                        <a class="layui-btn layui-btn-sm" lay-event="update_distribute">刷新模板</a>
                    @endcan--}}
                    @can('admin.channel.distribute.editDistribute')
                        <a class="layui-btn layui-btn-sm" lay-event="editDistribute">定制内容</a>
                    @endcan

                        <a class="layui-btn layui-btn-sm" lay-event="QrCode">二维码</a>
                        @can('admin.channel.distribute.destroyDistribute')
                            <a class="layui-btn layui-btn-sm layui-btn-danger" lay-event="del">删除</a>
                        @endcan

                </div>
            </script>
            <script type="text/html" id="thumb">
                <a href="@{{d.thumb}}" target="_blank" title="点击查看"><img src="@{{d.thumb}}" alt="" width="28" height="28"></a>
            </script>

        </div>
    </div>
@endsection

@section('script')
    <style>
        .lf {
            float: left
        }
        .clearfixs-box{
            overflow: hidden;
        }
        .clearfixs-box a{
            color: #ccc;
        }
        .clearfixs-box .green{
            color: green;
        }
        .clearfix-item {
            float: left;
            margin-left: 4%;
            margin-top: 3%;
        }
        .clearfixs-box .clearfix-item:last-child{
            margin-right: 0;
        }
        .w{
            width: 70px;
        }
        .tx-c{
            display: inline-block;
        }
        .mb10{
            margin-bottom: 5px;
        }
    </style>
    @can('admin.channel.distribute')
        <script src="/js/jquery.qrcode.min.js"></script>
        <script>
            //修改app包
            function app_edit(id,app_id){
                location.href = '/admin/distribute/'+id+'/edit?app_id='+app_id;
            }

            //删除app包
            function app_del(id,app_id,name){
                layui.use(['layer'],function () {
                    var layer = layui.layer;

                    layer.confirm('请确认是否删除 '+name+' ？', {
                        btn: ['确定', '取消'], //可以无限个按钮
                        cancel:function(index, layero){

                        }
                    }, function(index, layero){
                        $.post("{{ route('admin.channel.distribute.destroy') }}",{_method:'delete',id:id,app_id:app_id},function (res) {
                            if(res.code===0){

                                layer.msg(res.msg,{icon:6});
                                window.location.reload();
                            }else {
                                layer.msg(res.msg,{icon:5});
                            }
                        })
                    }, function(index){

                    });
                });
            }

            layui.use(['layer','table','form','laydate'],function () {
                var layer = layui.layer;
                var form = layui.form;
                var table = layui.table;
                var laydate = layui.laydate;
                //用户表格初始化
                var dataTable = table.render({
                    elem: '#dataTable'
                    // ,height: 500
                    ,url: "{{ route('admin.channel.distribute.data',['id'=>$id]) }}" //数据接口
                    ,page: true //开启分页
                    ,cols: [[ //表头
                        {checkbox: true,fixed: true}
                        ,{field: 'id', title: 'ID', sort: true,width:80}
                        ,{field: 'template_id', title: '分发h5页模板',templet:function (d) {
                                if(d.template != null){
                                    return d.template.name
                                }else{
                                    return '没有模板'
                                }
                            }}
                        ,{field: 'name', title: '分发页名称'}
                        ,{field: 'reduce_type', title: '扣量模式',templet:function (d) {
                                if(d.reduce_type == 'apply_register'){
                                    return '按正常申请注册比'
                                }else if(d.reduce_type == 'register'){
                                    return '按比例扣量'
                                }
                            }}
                        ,{field: 'custom_status', title: '订制状态状态',sort: true,templet:function (d) {
                                if(d.support_custom){
                                    if(d.custom_status){
                                        return '已定制'
                                    }else{
                                        return '未定制'
                                    }
                                }else{
                                    return '不可定制'
                                }

                            }}
                        ,{field: 'updated_at', title: '上次修改时间'}
                        ,{field: 'url', title: '分发地址',sort: true,templet:function (d) {
                                if(d.support_custom){
                                    if(d.custom_status){
                                        return d.url
                                    }else{
                                        return '请先定制'
                                    }
                                }else{
                                    return d.url
                                }
                            }}
                        ,{field: 'status', title: '状态',sort: true,templet:function (d) {
                                if(d.status == 1){
                                    return '<input type="checkbox" name="status" lay-filter="status" data-id="'+d.id+'" data-value="'+d.status+'" lay-skin="switch"  lay-text="正常|停用" checked>'
                                }else if(d.status == 0){
                                    return '<input type="checkbox" name="status" lay-filter="status" data-id="'+d.id+'" data-value="'+d.status+'"  lay-skin="switch"  lay-text="正常|停用">'
                                }
                            }}
                        ,{fixed: 'right', title:'操作',width: 300, align:'center', toolbar: '#options'}
                    ]]
                });

                //监听工具条
                table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                    var data = obj.data //获得当前行数据
                        ,layEvent = obj.event; //获得 lay-event 对应的值
                    if(layEvent === 'editDistribute'){
                        if(data.support_custom){
                            location.href = '/admin/distribute/'+data.id+'/editDistribute';
                        }else{
                            layer.msg('该模板暂不支持定制',{icon:5});
                        }

                    }
                    if(layEvent === 'update_distribute'){
                        $.post("{{ route('admin.channel.distribute.distributeUpdate') }}",{_method:'post',ids:[data.id]},function (result) {
                            if (result.code==0){
                                layer.msg(result.msg,{icon:6})
                            }else{

                                layer.msg(result.msg,{icon:5})
                            }

                        });
                    }
                    if(layEvent == 'QrCode'){
                        var content = '<div id="qrcode"></div>';

                        if(data.support_custom){
                            if(data.custom_status){
                                layer.open({
                                    title: '二维码',
                                    content: content,
                                    success: function(layero, index){
                                        $('body #qrcode').qrcode(data.url);
                                    }
                                });
                            }else{
                                 layer.msg('请先定制内容',{icon:5});
                            }
                        }else{
                            layer.open({
                                title: '二维码',
                                content: content,
                                success: function(layero, index){
                                    $('body #qrcode').qrcode(data.url);
                                }
                            });
                        }
                    }
                    if(layEvent == 'del'){
                        layer.confirm('确认删除吗？', function(index){
                            $.post("{{ route('admin.channel.distribute.destroyDistribute') }}",{_method:'delete',ids:[data.id]},function (result) {
                                if (result.code==0){
                                    layer.msg(result.msg,{icon:6})
                                    layer.close(index);
                                    dataTable.reload()
                                }else{
                                    layer.close(index);
                                    layer.msg(result.msg,{icon:5})
                                }

                            });
                        });
                    }


                    form.render()
                });

                //批量刷新模板
                $("#update_distributes").click(function () {
                    var ids = []
                    var hasCheck = table.checkStatus('dataTable')
                    var hasCheckData = hasCheck.data
                    if (hasCheckData.length>0){
                        $.each(hasCheckData,function (index,element) {
                            ids.push(element.id)
                        })
                    }
                    if (ids.length>0){
                        layer.confirm('确认刷新所有模板吗？', function(index){
                            $.post("{{ route('admin.channel.distribute.distributeUpdate') }}",{_method:'post',ids:ids},function (res) {
                                if(res.code===0){

                                    layer.msg(res.msg,{icon:6});
                                    dataTable.reload()

                                }else {
                                    layer.msg(res.msg,{icon:5});
                                }
                            });
                        })
                    }else {
                        layer.msg('请选择需要刷新的模板项',{icon:5})
                    }
                })



                form.on('switch(status)', function(data){
                    var id=$(data.elem).data('id');
                    var status=$(data.elem).data('value');
                    var page_id = '{{ $id }}';
                    $.post("{{route('admin.channel.distribute.status')}}",{_method:'post',id:id,status:status},function (res) {

                        if(res.code===0){
                            $(data.elem).attr('value',res.status);
                            layer.msg(res.msg,{icon:6});
                            dataTable.reload()
                        }else {
                            layer.msg(res.msg,{icon:5});
                            dataTable.reload()
                        }
                    })
                })


            });

        </script>
    @endcan
@endsection