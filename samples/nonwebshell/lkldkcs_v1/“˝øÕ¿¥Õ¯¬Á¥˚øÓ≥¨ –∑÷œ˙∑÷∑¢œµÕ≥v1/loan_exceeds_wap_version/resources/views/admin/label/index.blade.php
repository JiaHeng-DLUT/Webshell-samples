@extends('admin.layouts.base')

@section('content')
    <div class="layui-card">
        <div class="layui-card-body">

            <div class="layui-btn-group layui-inline" style="padding-bottom: 10px">
                @can('label.create')
                    <a class="layui-btn layui-btn-sm" id="add">添加标签</a>
                @endcan
            </div>

            <table id="dataTable" lay-filter="dataTable"></table>
                <script id="statusTpl" type="text/html">
                    <input type="checkbox" name="status" data-channel="@{{ d.channel.length }}" data-product="@{{ d.product.length }}" lay-filter="status"  lay-skin="switch" lay-text="上架|下架"  value="@{{ d.id }}" @{{#  if(d.status === 1){ }} checked @{{#  } }}  >
                </script>

            <script type="text/html" id="options">
                <div class="layui-btn-group">
                    @can('label.edit')
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    @endcan
                    @can('label.destroy')
                        <a class="layui-btn layui-btn-danger layui-btn-sm" lay-event="del">删除</a>
                    @endcan

                </div>
            </script>

        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form','jquery'],function () {
            var layer = layui.layer;
            var table = layui.table;
            var $=layui.jquery;
            var form=layui.form;

            //用户表格初始化
            var dataTable = table.render({
                elem: '#dataTable'
                ,url: "{{ route('admin.label.data') }}" //数据接口
                ,page: true //开启分页
                ,autoSort: false
                ,cols: [[ //表头
                    // {checkbox: true,fixed: true}
                    {field: 'id', title: '序号'}
                    ,{field: 'name', title: '标签名'}
                    ,{field: 'intro', title: '备注'}
                    ,{field: 'status', title: '状态',templet:'#statusTpl',sort:true}
                    ,{title:'操作',width: 150, toolbar: '#options'}
                ]]
            });



            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                var id=data.id;
                if(layEvent === 'edit'){
                    layer.open({
                        type: 2,
                        title: '编辑标签',
                        maxmin: true,
                        shadeClose: true, //点击遮罩关闭层
                        area : ['900px' , '520px'],
                        content: "/admin/label/"+id+"/edit",
                        success:function(){
                            localStorage.setItem('label_status','');
                        },
                        end:function () {
                            if(localStorage.getItem('label_status')==='success'){
                                layer.msg('修改成功',{icon:1});
                                dataTable.reload();
                            }
                        }
                    });
                }else if(layEvent === 'del'){
                    layer.confirm('确认删除吗？', function(index){
                        $.post("{{ route('admin.label.destroy') }}",{_method:'delete',id:id},function (result) {
                            if (result.code===0){
                                delReload(dataTable)
                                layer.msg(result.msg,{icon:1})
                            }else {
                                layer.msg(result.msg,{icon:2})
                            }
                            layer.close(index);
                        });
                    });
                }else {

                }
            });

            //上下架
            form.on('switch(status)', function(data){
                var id=data.value;
                var status=data.elem.checked;
                if(status===false){
                    var channel_count=data.elem.dataset.channel;
                    var product_count=data.elem.dataset.product;
                    if(channel_count >0 || product_count >0){
                        layer.msg('该标签下有渠道或产品与之关联,请先手动解除关联',{icon:2});
                        data.elem.checked=!status;
                        form.render();
                        return false;
                    }else {
                        $.post("{{route('admin.label.status')}}",{id:id,status:status},function (res) {
                            if(res.code===0){
                                layer.msg(res.msg,{icon:1});
                            }else {
                                layer.msg(res.msg,{icon:2});
                                dataTable.reload();
                            }
                        })
                    }
                }else {
                    $.post("{{route('admin.label.status')}}",{id:id,status:status},function (res) {
                        if(res.code===0){
                            layer.msg(res.msg,{icon:1});
                        }else {
                            layer.msg(res.msg,{icon:2});
                            dataTable.reload();
                        }
                    })
                }

            });




            //添加手机号
            $('#add').on('click',function () {
                layer.open({
                    type: 2,
                    title: '添加标签',
                    maxmin: true,
                    shadeClose: true, //点击遮罩关闭层
                    area : ['900px' , '520px'],
                    content: "{{route('admin.label.create')}}",
                    success:function(){
                        localStorage.setItem('label_status','');
                    },
                    end:function () {
                        if(localStorage.getItem('label_status')==='success'){
                            layer.msg('保存成功',{icon:1});
                            dataTable.reload();
                        }
                    }
                });
            })

        })
    </script>
@endsection