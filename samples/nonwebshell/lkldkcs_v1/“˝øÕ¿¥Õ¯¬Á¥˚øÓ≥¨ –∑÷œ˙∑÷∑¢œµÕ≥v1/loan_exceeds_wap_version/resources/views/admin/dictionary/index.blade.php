@extends('admin.layouts.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-header layuiadmin-card-header-auto">
            {{--<div class="layui-btn-group ">
                <a class="layui-btn layui-btn-sm" href="{{ route('admin.dictionary.create') }}">添 加</a>
            </div>--}}
        </div>
        <div class="layui-card-body">
            <table id="dataTable" lay-filter="dataTable"></table>
            <script type="text/html" id="options">
                @can('data.dictionary.edit')
                    <div class="layui-btn-group">
                        <a class="layui-btn layui-btn-sm" lay-event="edit">编辑</a>
                    </div>
                @endcan
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
                ,url: "{{ route('admin.dictionary.data') }}" //数据接口
                // ,page: true //开启分页
                ,cols: [[ //表头
                    {field: 'function_name', title: '所属功能', align:'center'}
                    ,{field: 'field_name', title: '字段名称', align:'center'}
                    ,{field: 'content', title: '详情', align:'center'}
                    ,{fixed: 'right',title:'操作', width: 100, align:'center', toolbar: '#options'}
                ]]
                ,id:'dictionaryTable'
            });

            //监听工具条
            table.on('tool(dataTable)', function(obj){ //注：tool是工具条事件名，dataTable是table原始容器的属性 lay-filter="对应的值"
                var data = obj.data //获得当前行数据
                    ,layEvent = obj.event; //获得 lay-event 对应的值
                if(layEvent === 'edit'){
                    var slug=obj.data.slug;
                    var route='';
                    var width=900;
                    var height=520;
                    switch (slug){
                        case 'product_material':route="{{route('admin.product.material')}}";width=700;break;
                        case 'product_label':route="{{route('admin.product.label')}}";break;
                        case 'product_quota':route="{{route('admin.product.quota')}}";width=1100;height=700;break;
                        case 'product_repay':route="{{route('admin.product.repay')}}";width=1100;height=700;break;
                        case 'product_corner':route="{{route('admin.product.corner')}}";break;
                        case 'credit_corner':route="{{route('admin.credit.corner')}}";break;
                        case 'credit_bank':route="{{route('admin.credit.bank')}}";break;
                        case 'credit_level':route="{{route('admin.credit.level')}}";break;
                        case 'credit_organization':route="{{route('admin.credit.organization')}}";break;
                        case 'article_corner':route="{{route('admin.article.corner')}}";break;
                        case 'article_category':route="{{route('admin.article.category')}}";break;
                        case 'feedback_category':route="{{route('admin.feedback.category')}}";break;
                        case 'business_cooperation':route="{{route('admin.business.cooperation')}}";break;
                        case 'cooperation':route="{{route('admin.cooperation')}}";break;
                        case 'friendship':route="{{route('admin.friendship')}}";break;
                    }
                    layer.open({
                        type: 2,
                        title: '编辑字段',
                        maxmin: true,
                        shadeClose: true, //点击遮罩关闭层
                        area : [width+'px' , height+'px'],
                        content: route,
                        success:function(){
                            localStorage.setItem('dictionary_status','');
                        },
                        end:function () {
                            if(localStorage.getItem('dictionary_status')==='success'){
                                layer.msg('保存成功',{icon:1});
                                table.reload('dictionaryTable');
                            }
                        }
                    });
                }
            });


        })
    </script>
@endsection